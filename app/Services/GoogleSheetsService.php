<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class GoogleSheetsService
{
    private Sheets $service;
    private string $spreadsheetId;
    private static array $memoryCache = [];

    public function __construct()
    {
        $client = new Client();

        $client->setAuthConfig(
            config('services.google_sheets.credentials_path')
        );

        $client->setScopes([
            Sheets::SPREADSHEETS,
        ]);

        $client->setHttpClient(new GuzzleClient([
            'timeout' => 20,
            'connect_timeout' => 10,
        ]));

        $this->service = new Sheets($client);

        $this->spreadsheetId = (string) config(
            'services.google_sheets.spreadsheet_id'
        );

        if ($this->spreadsheetId === '') {
            throw new RuntimeException(
                'Google Sheets Spreadsheet ID belum dikonfigurasi.'
            );
        }
    }

    private function getCacheKey(string $range): string
    {
        return 'gsheets_range_' . md5($this->spreadsheetId . '|' . $range);
    }

    private function getFallbackCacheKey(string $range): string
    {
        return 'gsheets_fallback_' . md5($this->spreadsheetId . '|' . $range);
    }

    /**
     * Bersihkan cache pembacaan saat ada penulisan data baru.
     */
    public function clearCache(): void
    {
        self::$memoryCache = [];

        $libraryTab = trim((string) config('services.google_sheets.library_tab', 'library')) ?: 'library';

        foreach ([
            sprintf("'%s'!A3:G", $libraryTab),
            "'Master CN'!A3:D",
            "'IN WH'!A3:M",
            "'OUT WH'!A3:K",
        ] as $knownRange) {
            Cache::forget($this->getCacheKey($knownRange));
        }
    }

    public function getSpreadsheetTitle(): ?string
    {
        $spreadsheet = $this->service->spreadsheets->get(
            $this->spreadsheetId,
            ['fields' => 'properties.title']
        );

        return $spreadsheet->getProperties()?->getTitle();
    }

    public function getSheetNames(): array
    {
        $spreadsheet = $this->service->spreadsheets->get(
            $this->spreadsheetId,
            ['fields' => 'sheets.properties.title']
        );

        return array_map(
            fn ($sheet) => $sheet->getProperties()->getTitle(),
            $spreadsheet->getSheets() ?? []
        );
    }

    /**
     * Membaca data dari range tertentu dengan cache singkat & fallback
     * agar tidak terkena limit kuota 60 request/menit Google Sheets API.
     */
    public function readRange(string $range): array
    {
        $isConsole = app()->runningInConsole();
        $cacheKey = $this->getCacheKey($range);
        $fallbackKey = $this->getFallbackCacheKey($range);

        // Gunakan memory cache dalam satu siklus proses (menghemat puluhan call di sheets:sync).
        if (array_key_exists($range, self::$memoryCache)) {
            return self::$memoryCache[$range];
        }

        // Untuk request website (Dashboard / Detail Barang), gunakan cache 10 detik.
        if (!$isConsole) {
            $cached = Cache::get($cacheKey);
            if (is_array($cached)) {
                self::$memoryCache[$range] = $cached;
                return $cached;
            }
        }

        $lastException = null;

        for ($attempt = 1; $attempt <= 3; $attempt++) {
            try {
                $result = $this->service->spreadsheets_values->get(
                    $this->spreadsheetId,
                    $range
                );

                $values = $result->getValues() ?? [];

                self::$memoryCache[$range] = $values;
                Cache::put($cacheKey, $values, now()->addSeconds(10));
                Cache::put($fallbackKey, $values, now()->addHours(24));

                return $values;
            } catch (Throwable $e) {
                $lastException = $e;
                if ($attempt < 3) {
                    usleep($attempt * 500000); // Tunggu 0.5s lalu 1.0s sebelum mencoba ulang
                }
            }
        }

        // Jika di halaman website terjadi timeout / rate-limit dari Google,
        // gunakan data fallback terakhir agar halaman tidak 500 Server Error.
        if (!$isConsole) {
            $fallback = Cache::get($fallbackKey);
            if (is_array($fallback)) {
                Log::warning('Google Sheets API gagal diakses, menggunakan data fallback cache.', [
                    'range' => $range,
                    'error' => $lastException?->getMessage(),
                ]);
                self::$memoryCache[$range] = $fallback;
                return $fallback;
            }
        }

        throw $lastException;
    }

    /**
     * Mengubah data pada range tertentu (dengan auto-retry jika koneksi/kuota sibuk).
     */
    public function writeRange(
        string $range,
        array $values
    ): int {
        $lastException = null;

        for ($attempt = 1; $attempt <= 3; $attempt++) {
            try {
                $result = $this->service->spreadsheets_values->update(
                    $this->spreadsheetId,
                    $range,
                    new ValueRange(['values' => $values]),
                    ['valueInputOption' => 'RAW']
                );

                $this->clearCache();

                return (int) ($result->getUpdatedCells() ?? 0);
            } catch (Throwable $e) {
                $lastException = $e;
                if ($attempt < 3) {
                    usleep($attempt * 500000);
                }
            }
        }

        throw $lastException;
    }

    /**
     * Menambahkan baris baru di Google Sheets.
     *
     * Contoh:
     * appendRow("'IN WH'!A:L", [...]);
     *
     * Menggunakan RAW agar ID transaksi dan kode barang
     * tidak diubah formatnya oleh Google Sheets.
     */
    public function appendRow(
        string $range,
        array $values
    ): array {
        $lastException = null;

        for ($attempt = 1; $attempt <= 3; $attempt++) {
            try {
                $result = $this->service->spreadsheets_values->append(
                    $this->spreadsheetId,
                    $range,
                    new ValueRange([
                        'values' => [$values],
                    ]),
                    [
                        'valueInputOption' => 'RAW',
                        'insertDataOption' => 'INSERT_ROWS',
                    ]
                );

                $this->clearCache();

                $updates = $result->getUpdates();

                return [
                    'updated_range' => $updates?->getUpdatedRange(),
                    'updated_rows' => (int) (
                        $updates?->getUpdatedRows() ?? 0
                    ),
                    'updated_cells' => (int) (
                        $updates?->getUpdatedCells() ?? 0
                    ),
                ];
            } catch (Throwable $e) {
                $lastException = $e;
                if ($attempt < 3) {
                    usleep($attempt * 500000);
                }
            }
        }

        throw $lastException;
    }
}
