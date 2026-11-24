<?php

namespace App\Console\Commands;

use App\Services\LibrarySheetSyncService;
use Illuminate\Console\Command;
use Throwable;

class SyncLibraryFromSheetsCommand extends Command
{
    protected $signature = 'sheets:sync-library';

    protected $description = 'Sinkronisasi data dokumen dari tab library di Google Sheets ke database MySQL';

    public function handle(LibrarySheetSyncService $syncService): int
    {
        $this->info('Memulai sinkronisasi dokumen dari Google Sheets (tab library)...');

        try {
            $result = $syncService->sync();

            $this->info(sprintf(
                'Selesai! Total baris: %d | Baru: %d | Diperbarui: %d | Tetap: %d | Dihapus: %d',
                $result['total_rows'],
                $result['inserted'],
                $result['updated'],
                $result['unchanged'],
                $result['deleted']
            ));

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error('Gagal sinkronisasi Google Sheets: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
