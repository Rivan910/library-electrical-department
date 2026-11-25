@extends('layouts.app')

@section('title', 'Library Electrical P611')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v=3">
@endpush

@section('content')
<div class="wtl-page">
    <!-- HERO HEADER -->
    <header class="wtl-hero">
        <div class="wtl-hero-bg"></div>

        <div class="wtl-hero-top">
            <div>
                <div class="wtl-eyebrow">ELECTRICAL DEPARTMENT P611</div>
                <h1 class="wtl-hero-title">Library Electrical P611</h1>
                <p class="wtl-hero-sub">Technical Document Archive &amp; Rack Location System &mdash; Workshop P611</p>
            </div>

            <div class="wtl-top-Widgets">
                <div class="wtl-pill-card">
                    <div class="wtl-pill-icon">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div>
                        <div class="wtl-pill-label">Today</div>
                        <div class="wtl-pill-value">{{ now()->format('d M Y • H:i') }}</div>
                    </div>
                </div>

                <div class="wtl-pill-card" style="position:relative;">
                    <div class="wtl-avatar">
                        {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'AD' }}
                    </div>
                    <div>
                        <div class="wtl-pill-value">{{ auth()->check() ? auth()->user()->name : 'Admin' }}</div>
                        <div class="wtl-pill-label" style="text-transform:capitalize;">{{ auth()->check() ? (auth()->user()->role ?? 'Admin') : 'Document Controller' }}</div>
                    </div>
                    @auth
                        <form method="POST" action="{{ route('logout') }}" style="margin:0 0 0 4px;">
                            @csrf
                            <button
                                type="submit"
                                title="Log Out"
                                style="background:#FEE2E2;border:1px solid #FECACA;color:#DC2626;width:25px;height:25px;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;"
                            >
                                <i class="fas fa-sign-out-alt" style="font-size:10.5px;"></i>
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- 3 SUMMARY KPI CARDS -->
    <section class="wtl-kpi-grid">
        <div class="wtl-kpi-card wtl-kpi-blue">
            <div class="wtl-kpi-head">
                <span class="wtl-kpi-dot"></span>
                <p class="wtl-kpi-title">Total Documents</p>
            </div>
            <div class="wtl-kpi-body">
                <span class="wtl-kpi-num">{{ number_format($stats['total_documents']) }}</span>
                <span class="wtl-kpi-unit">documents registered</span>
            </div>
        </div>

        <div class="wtl-kpi-card wtl-kpi-green">
            <div class="wtl-kpi-head">
                <span class="wtl-kpi-dot"></span>
                <p class="wtl-kpi-title">Available</p>
            </div>
            <div class="wtl-kpi-body">
                <span class="wtl-kpi-num">{{ number_format($stats['available']) }}</span>
                <span class="wtl-kpi-unit">ready in storage</span>
            </div>
        </div>

        <div class="wtl-kpi-card wtl-kpi-amber">
            <div class="wtl-kpi-head">
                <span class="wtl-kpi-dot"></span>
                <p class="wtl-kpi-title">Racks</p>
            </div>
            <div class="wtl-kpi-body">
                <span class="wtl-kpi-num">{{ $stats['racks'] }}</span>
                <span class="wtl-kpi-unit">active rack locations</span>
            </div>
        </div>
    </section>

    <!-- DOCUMENT REPOSITORY CARD -->
    <section class="wtl-repo-card">
        <!-- SEARCH & FILTER FORM -->
        <form method="GET" action="{{ route('dashboard') }}" class="wtl-filter-bar">
            <div class="wtl-search-input-wrap">
                <i class="fas fa-search"></i>
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search by Document No, Title, Vendor, or Rack (e.g. R-02 / Rak 2)..."
                    class="wtl-input"
                >
            </div>

            <div class="wtl-select-wrap">
                <i class="far fa-building prefix-icon"></i>
                <select name="vendor" class="wtl-select" onchange="this.form.submit()">
                    <option value="">All vendors</option>
                    @foreach($vendors as $v)
                        <option value="{{ $v }}" {{ $vendorFilter === $v ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>

            <div class="wtl-select-wrap">
                <i class="far fa-file-alt prefix-icon"></i>
                <select name="type" class="wtl-select" onchange="this.form.submit()">
                    <option value="">All types</option>
                    @foreach($types as $t)
                        <option value="{{ $t }}" {{ $typeFilter === $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>

            <div class="wtl-select-wrap" id="rack-filter">
                <i class="fas fa-server prefix-icon"></i>
                <select name="rack" id="selectRack" class="wtl-select" onchange="this.form.submit()">
                    <option value="">All racks</option>
                    @foreach($racks as $r)
                        <option value="{{ $r }}" {{ $rackFilter === $r ? 'selected' : '' }}>Rack {{ $r }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="wtl-search-submit">
                <i class="fas fa-search"></i>
                <span>Search</span>
            </button>
        </form>

        <!-- META ROW -->
        <div class="wtl-meta-row">
            <div>
                <i class="fas fa-sliders-h" style="margin-right:6px;color:#94A3B8;"></i>
                Showing
                <strong>{{ $documents->firstItem() ?? 0 }}–{{ $documents->lastItem() ?? 0 }}</strong>
                of <strong>{{ number_format($documents->total()) }}</strong> documents
                @if($rackFilter !== '')
                    in <span class="wtl-rack-pill" style="padding:2px 8px;font-size:11px;">{{ $rackFilter }}</span>
                @endif
                @if($search !== '' || $vendorFilter !== '' || $typeFilter !== '' || $rackFilter !== '')
                    &bull; <a href="{{ route('dashboard') }}" style="color:#2563EB;text-decoration:none;font-weight:700;">Reset Filter</a>
                @endif
            </div>
            <div>
                @if($lastSyncedAt)
                    Last synced: {{ \Illuminate\Support\Carbon::parse($lastSyncedAt)->format('d M Y, H:i') }}
                @else
                    Connected to Google Sheets
                @endif
            </div>
        </div>

        <!-- TABLE -->
        <div class="wtl-table-wrap">
            <table class="wtl-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Document No</th>
                        <th>Vendor</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Rack</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                        @php
                            $rawContent = trim((string) ($doc->content ?? ''));
                            $typeClass = match (strtolower($rawContent)) {
                                'drawing' => 'wtl-type-drawing',
                                'manual' => 'wtl-type-manual',
                                default => 'wtl-type-datasheet',
                            };
                            $typeIcon = match (strtolower($rawContent)) {
                                'drawing' => 'fa-drafting-compass',
                                'manual' => 'fa-book-open',
                                default => 'fa-file-invoice',
                            };
                            $displayNo = is_numeric($doc->no)
                                ? str_pad((string) $doc->no, 2, '0', STR_PAD_LEFT)
                                : ($doc->no ?: '-');
                        @endphp
                        <tr>
                            <td class="wtl-col-no">{{ $displayNo }}</td>
                            <td class="wtl-doc-no">{{ $doc->document_no }}</td>
                            <td>
                                @if($doc->vendor)
                                    <span class="wtl-vendor-cell">
                                        <span class="wtl-vendor-badge">{{ $doc->vendor_code }}</span>
                                        <span>{{ $doc->vendor }}</span>
                                    </span>
                                @else
                                    <span class="wtl-notes">-</span>
                                @endif
                            </td>
                            <td class="wtl-doc-title">{{ $doc->title ?: '-' }}</td>
                            <td>
                                @if($rawContent !== '')
                                    <span class="wtl-type-pill {{ $typeClass }}">
                                        <i class="fas {{ $typeIcon }}" style="font-size:10.5px;"></i>
                                        <span>{{ $rawContent }}</span>
                                    </span>
                                @else
                                    <span class="wtl-notes">-</span>
                                @endif
                            </td>
                            <td>
                                @if($doc->rack)
                                    <a
                                        href="{{ route('dashboard', array_filter(['search' => $search, 'vendor' => $vendorFilter, 'type' => $typeFilter, 'rack' => $doc->rack])) }}"
                                        class="wtl-rack-pill"
                                        style="text-decoration:none;"
                                        title="Filter hanya dokumen di {{ $doc->rack }}"
                                    >
                                        {{ $doc->rack }}
                                    </a>
                                @else
                                    <span class="wtl-notes">-</span>
                                @endif
                            </td>
                            <td class="wtl-notes">{{ $doc->notes ?: '-' }}</td>
                            <td>
                                <div class="wtl-actions">
                                    <button
                                        type="button"
                                        class="wtl-act-btn wtl-act-view"
                                        title="View Document Details"
                                        onclick="openDocModal('{{ e($doc->document_no) }}', '{{ e($doc->vendor ?? '-') }}', '{{ e($doc->title ?? '-') }}', '{{ e($rawContent !== '' ? $rawContent : $doc->display_content) }}', '{{ e($doc->rack ?? '-') }}', '{{ e($doc->notes ?? '-') }}')"
                                    >
                                        <i class="far fa-eye"></i>
                                    </button>
                                    <button type="button" class="wtl-act-btn" title="Download">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button type="button" class="wtl-act-btn" title="More options">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;padding:36px 20px;color:#64748B;">
                                <i class="far fa-folder-open" style="font-size:24px;margin-bottom:8px;display:block;color:#94A3B8;"></i>
                                <strong>No matching documents found.</strong><br>
                                <span style="font-size:12px;">Try adjusting your search keywords or rack location filter.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION FOOTER -->
        <div class="wtl-footer">
            <div class="wtl-page-info">
                Showing
                <strong>{{ $documents->firstItem() ?? 0 }}–{{ $documents->lastItem() ?? 0 }}</strong>
                of <strong>{{ number_format($documents->total()) }}</strong> documents
            </div>

            @if($documents->hasPages())
                <div class="wtl-pagination">
                    @if($documents->onFirstPage())
                        <span class="wtl-page-btn" style="color:#94A3B8;cursor:not-allowed;">
                            <i class="fas fa-chevron-left" style="font-size:10px;"></i>
                            <span>Previous</span>
                        </span>
                    @else
                        <a href="{{ $documents->previousPageUrl() }}" class="wtl-page-btn">
                            <i class="fas fa-chevron-left" style="font-size:10px;"></i>
                            <span>Previous</span>
                        </a>
                    @endif

                    @foreach($documents->getUrlRange(max(1, $documents->currentPage() - 2), min($documents->lastPage(), $documents->currentPage() + 2)) as $page => $url)
                        <a
                            href="{{ $url }}"
                            class="wtl-page-btn {{ $page === $documents->currentPage() ? 'is-active' : '' }}"
                        >
                            {{ $page }}
                        </a>
                    @endforeach

                    @if($documents->hasMorePages())
                        <a href="{{ $documents->nextPageUrl() }}" class="wtl-page-btn">
                            <span>Next</span>
                            <i class="fas fa-chevron-right" style="font-size:10px;"></i>
                        </a>
                    @else
                        <span class="wtl-page-btn" style="color:#94A3B8;cursor:not-allowed;">
                            <span>Next</span>
                            <i class="fas fa-chevron-right" style="font-size:10px;"></i>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </section>
</div>

<!-- DOCUMENT PREVIEW MODAL -->
<div id="docDetailModal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.55);backdrop-filter:blur(4px);z-index:60;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#FFFFFF;border-radius:18px;max-width:500px;width:100%;overflow:hidden;box-shadow:0 20px 50px rgba(15,23,42,0.25);border:1px solid #E2E8F0;">
        <div style="padding:18px 22px;background:#133B6E;color:#FFFFFF;display:flex;align-items:center;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:10px;">
                <i class="fas fa-book-open"></i>
                <strong style="font-size:15px;" id="modalDocNo">ASB-001-2023</strong>
            </div>
            <button type="button" onclick="closeDocModal()" style="background:rgba(255,255,255,0.15);border:0;color:#FFFFFF;width:30px;height:30px;border-radius:8px;cursor:pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="padding:22px;display:flex;flex-direction:column;gap:14px;font-size:13.5px;">
            <div>
                <div style="font-size:11px;font-weight:700;color:#64748B;text-transform:uppercase;">Document Title</div>
                <div style="font-size:16px;font-weight:800;color:#0F294A;margin-top:2px;" id="modalDocTitle"></div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div style="background:#F8FAFC;padding:12px;border-radius:12px;border:1px solid #E2E8F0;">
                    <div style="font-size:11px;font-weight:700;color:#64748B;text-transform:uppercase;">Vendor</div>
                    <div style="font-weight:800;color:#1E293B;margin-top:3px;" id="modalDocVendor"></div>
                </div>
                <div style="background:#ECFDF5;padding:12px;border-radius:12px;border:1px solid #A7F3D0;">
                    <div style="font-size:11px;font-weight:700;color:#047857;text-transform:uppercase;">Rack Storage Location</div>
                    <div style="font-weight:800;color:#065F46;font-size:15px;margin-top:3px;" id="modalDocRack"></div>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div style="background:#F8FAFC;padding:12px;border-radius:12px;border:1px solid #E2E8F0;">
                    <div style="font-size:11px;font-weight:700;color:#64748B;text-transform:uppercase;">Content Type</div>
                    <div style="font-weight:700;color:#1E293B;margin-top:3px;" id="modalDocContent"></div>
                </div>
                <div style="background:#F8FAFC;padding:12px;border-radius:12px;border:1px solid #E2E8F0;">
                    <div style="font-size:11px;font-weight:700;color:#64748B;text-transform:uppercase;">Area / Notes</div>
                    <div style="font-weight:700;color:#1E293B;margin-top:3px;" id="modalDocNotes"></div>
                </div>
            </div>
        </div>
        <div style="padding:14px 22px;background:#F8FAFC;border-top:1px solid #E2E8F0;display:flex;justify-content:flex-end;">
            <button type="button" onclick="closeDocModal()" style="padding:9px 18px;border-radius:10px;border:0;background:#133B6E;color:#FFFFFF;font-weight:700;font-size:12.5px;cursor:pointer;">
                Close
            </button>
        </div>
    </div>
</div>

<script>
    function openDocModal(docNo, vendor, title, content, rack, notes) {
        document.getElementById('modalDocNo').textContent = docNo;
        document.getElementById('modalDocTitle').textContent = title;
        document.getElementById('modalDocVendor').textContent = vendor;
        document.getElementById('modalDocContent').textContent = content;
        document.getElementById('modalDocRack').textContent = 'Rack ' + rack;
        document.getElementById('modalDocNotes').textContent = notes;
        document.getElementById('docDetailModal').style.display = 'flex';
    }

    function closeDocModal() {
        document.getElementById('docDetailModal').style.display = 'none';
    }

    function openAddModal() {
        alert('Fitur Add Document siap kita kembangkan di tahap berikutnya setelah Dashboard selesai.');
    }
</script>
@endsection
