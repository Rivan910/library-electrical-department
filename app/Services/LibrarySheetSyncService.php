<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Support\Facades\DB;

class LibrarySheetSyncService
{
    public function __construct(
        private GoogleSheetsService $googleSheets
    ) {
    }

    /**
     * Sinkronisasi data dokumen dari tab 'library' Google Sheets ke tabel documents di MySQL.
     *
     * Struktur Kolom Google Sheets (Mulai Baris 3 / A3:G):
     * A (0) = No
     * B (1) = Document No
     * C (2) = Vendor
     * D (3) = Tittle
     * E (4) = Content
     * F (5) = Rack
     * G (6) = Notes
     */
    public function sync(): array
    {
        $tabName = trim((string) config('services.google_sheets.library_tab', 'library'));
        if ($tabName === '') {
            $tabName = 'library';
        }

        $range = sprintf("'%s'!A3:G", $tabName);
        $rows = $this->googleSheets->readRange($range);

        $inserted = 0;
        $updated = 0;
        $unchanged = 0;
        $deleted = 0;
        $activeRowNumbers = [];

        DB::transaction(function () use (
            $rows,
            &$inserted,
            &$updated,
            &$unchanged,
            &$deleted,
            &$activeRowNumbers
        ) {
            foreach ($rows as $index => $row) {
                $sheetRowNumber = $index + 3; // Karena pembacaan dimulai dari baris ke-3 (A3:G)

                $no = trim((string) ($row[0] ?? ''));
                $documentNo = trim((string) ($row[1] ?? ''));
                $vendor = trim((string) ($row[2] ?? ''));
                $title = trim((string) ($row[3] ?? ''));
                $content = trim((string) ($row[4] ?? ''));
                $rack = trim((string) ($row[5] ?? ''));
                $notes = trim((string) ($row[6] ?? ''));

                // Lewati baris yang benar-benar kosong (tidak ada Document No dan tidak ada Title).
                if ($documentNo === '' && $title === '') {
                    continue;
                }

                $activeRowNumbers[] = $sheetRowNumber;

                $values = [
                    'no' => $no !== '' ? $no : (string) ($index + 1),
                    'document_no' => $documentNo !== '' ? $documentNo : '-',
                    'vendor' => $vendor !== '' ? $vendor : null,
                    'title' => $title !== '' ? $title : null,
                    'content' => $content !== '' ? $content : null,
                    'rack' => $rack !== '' ? $rack : null,
                    'notes' => $notes !== '' ? $notes : null,
                ];

                $document = Document::where('sheet_row_number', $sheetRowNumber)->first();

                if (!$document) {
                    Document::create([
                        'sheet_row_number' => $sheetRowNumber,
                        ...$values,
                    ]);
                    $inserted++;
                    continue;
                }

                $changes = [];
                foreach ($values as $field => $newValue) {
                    $currentValue = $document->{$field};
                    if ((string) ($currentValue ?? '') !== (string) ($newValue ?? '')) {
                        $changes[$field] = $newValue;
                    }
                }

                if ($changes === []) {
                    $unchanged++;
                    continue;
                }

                $document->fill($changes);
                $document->save();
                $updated++;
            }

            // Hapus baris dokumen di MySQL jika baris tersebut sudah dihapus di Google Sheets
            if ($activeRowNumbers !== []) {
                $deleted = Document::whereNotNull('sheet_row_number')
                    ->whereNotIn('sheet_row_number', $activeRowNumbers)
                    ->delete();
            }
        });

        return [
            'total_rows' => count($activeRowNumbers),
            'inserted' => $inserted,
            'updated' => $updated,
            'unchanged' => $unchanged,
            'deleted' => $deleted,
        ];
    }
}
