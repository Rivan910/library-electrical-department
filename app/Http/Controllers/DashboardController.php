<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Services\GoogleSheetsService;
use App\Services\LibrarySheetSyncService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Throwable;

class DashboardController extends Controller
{
    public function index(Request $request, LibrarySheetSyncService $syncService)
    {
        // Sinkronisasi otomatis dari Google Sheets setiap 60 detik (atau jika database masih kosong)
        if (Document::count() === 0 || Cache::add('library_sheets_auto_sync', true, 60)) {
            try {
                $syncService->sync();
            } catch (Throwable $e) {
                // Abaikan jika sedang offline, tetap tampilkan data dari MySQL
            }
        }

        $search = trim((string) $request->input('search', ''));
        $vendorFilter = trim((string) $request->input('vendor', ''));
        $typeFilter = trim((string) $request->input('type', ''));
        $rackFilter = trim((string) $request->input('rack', ''));

        // Daftar pilihan dropdown diambil langsung dari data nyata di database
        $vendors = Document::query()
            ->whereNotNull('vendor')
            ->where('vendor', '!=', '')
            ->distinct()
            ->orderBy('vendor')
            ->pluck('vendor')
            ->values()
            ->all();

        $racks = Document::query()
            ->whereNotNull('rack')
            ->where('rack', '!=', '')
            ->distinct()
            ->pluck('rack')
            ->values()
            ->all();
        natsort($racks);
        $racks = array_values($racks);

        // Kumpulkan daftar Content / Tipe Dokumen
        $explicitTypes = Document::query()
            ->whereNotNull('content')
            ->where('content', '!=', '')
            ->distinct()
            ->orderBy('content')
            ->pluck('content')
            ->values()
            ->all();

        $types = $explicitTypes !== []
            ? $explicitTypes
            : ['Drawing', 'Electrical Doc', 'Parts List', 'Manual', 'Datasheet'];

        // Query utama untuk tabel dokumen
        $query = Document::query()->orderBy('sheet_row_number')->orderBy('id');

        if ($vendorFilter !== '') {
            $query->where('vendor', $vendorFilter);
        }

        if ($rackFilter !== '') {
            $query->where('rack', $rackFilter);
        }

        if ($typeFilter !== '') {
            $query->where(function (Builder $q) use ($typeFilter) {
                $q->where('content', $typeFilter);

                $lower = strtolower($typeFilter);
                if ($lower === 'drawing') {
                    $q->orWhere('title', 'like', '%DRAWING%');
                } elseif ($lower === 'electrical doc') {
                    $q->orWhere('title', 'like', '%ELECTRICAL%');
                } elseif ($lower === 'parts list') {
                    $q->orWhere('title', 'like', '%PART%')->orWhere('title', 'like', '%LIST%');
                } elseif ($lower === 'manual') {
                    $q->orWhere('title', 'like', '%MANUAL%')->orWhere('title', 'like', '%INSTRUCTION%');
                } elseif ($lower === 'datasheet') {
                    $q->orWhere('title', 'like', '%DATASHEET%')->orWhere('title', 'like', '%DATA SHEET%');
                }
            });
        }

        if ($search !== '') {
            // Mendukung pencarian multi-kata kunci dengan pemisah '&' (seperti di Stock Opname)
            $keywords = array_values(array_filter(array_map('trim', explode('&', $search))));

            foreach ($keywords as $keyword) {
                // Normalisasi jika user mengetik "rak 2", "rack 2", "rak 02", atau "r2" -> cocokkan juga dengan "R-02"
                $normalizedRack = null;
                if (preg_match('/^(?:rak|rack|r)\s*[-_]?\s*0*(\d+)$/i', $keyword, $matches)) {
                    $rackNumber = (int) $matches[1];
                    $normalizedRack = sprintf('R-%02d', $rackNumber);
                }

                $query->where(function (Builder $q) use ($keyword, $normalizedRack) {
                    $like = '%' . $keyword . '%';
                    $q->where('document_no', 'like', $like)
                        ->orWhere('vendor', 'like', $like)
                        ->orWhere('title', 'like', $like)
                        ->orWhere('content', 'like', $like)
                        ->orWhere('rack', 'like', $like)
                        ->orWhere('notes', 'like', $like)
                        ->orWhere('no', 'like', $like);

                    if ($normalizedRack !== null) {
                        $q->orWhere('rack', 'like', '%' . $normalizedRack . '%');
                    }
                });
            }
        }

        $totalAllDocuments = Document::count();
        $documents = $query->paginate(15)->withQueryString();

        // Hitung dokumen yang ditandai rusak / hilang / tidak tersedia di kolom Notes
        $unavailableCount = Document::query()
            ->whereNotNull('notes')
            ->where(function (Builder $q) {
                $q->where('notes', 'like', '%rusak%')
                    ->orWhere('notes', 'like', '%hilang%')
                    ->orWhere('notes', 'like', '%damaged%')
                    ->orWhere('notes', 'like', '%missing%')
                    ->orWhere('notes', 'like', '%tidak tersedia%')
                    ->orWhere('notes', 'like', '%dipinjam%')
                    ->orWhere('notes', 'like', '%borrowed%');
            })
            ->count();

        $availableCount = max(0, $totalAllDocuments - $unavailableCount);

        $manualsAndAsBuiltQuery = Document::query()
            ->where(function (Builder $q) {
                $q->whereIn('content', ['Manual', 'As-Built', 'Manuals', 'As-Built Drawing'])
                    ->orWhere('content', 'like', '%manual%')
                    ->orWhere('content', 'like', '%as-built%')
                    ->orWhere('content', 'like', '%as built%')
                    ->orWhere('title', 'like', '%MANUAL%')
                    ->orWhere('title', 'like', '%AS-BUILT%')
                    ->orWhere('title', 'like', '%AS BUILT%');
            });

        $manualsAndAsBuiltCount = $manualsAndAsBuiltQuery->count();

        $lastSyncedAt = Document::max('updated_at');

        $stats = [
            'total_documents' => $totalAllDocuments,
            'available' => $availableCount,
            'racks' => count($racks),
            'manuals_as_built' => $manualsAndAsBuiltCount,
            'unavailable' => $unavailableCount,
            'vendors_count' => count($vendors),
        ];

        return view('dashboard', [
            'documents' => $documents,
            'stats' => $stats,
            'vendors' => $vendors,
            'types' => $types,
            'racks' => $racks,
            'search' => $search,
            'vendorFilter' => $vendorFilter,
            'typeFilter' => $typeFilter,
            'rackFilter' => $rackFilter,
            'lastSyncedAt' => $lastSyncedAt,
        ]);
    }

    /**
     * Sinkronisasi manual dari tombol "Sync Spreadsheet" di Dashboard.
     */
    public function sync(
        GoogleSheetsService $googleSheets,
        LibrarySheetSyncService $syncService
    ): RedirectResponse {
        try {
            $googleSheets->clearCache();
            $result = $syncService->sync();

            return redirect()
                ->route('dashboard')
                ->with(
                    'sync_status',
                    sprintf(
                        'Sinkronisasi Google Sheets berhasil! Total: %d dokumen (Baru: %d, Diperbarui: %d, Dihapus: %d).',
                        $result['total_rows'],
                        $result['inserted'],
                        $result['updated'],
                        $result['deleted']
                    )
                );
        } catch (Throwable $e) {
            return redirect()
                ->route('dashboard')
                ->with('sync_error', 'Gagal sinkronisasi Google Sheets: ' . $e->getMessage());
        }
    }
}
