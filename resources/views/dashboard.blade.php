@extends('layouts.app')

@section('title', 'Library Electrical P611')

@section('content')
<style>
    .wtl-page {
        position: relative;
        min-height: 100vh;
        padding: 0 28px 36px;
    }

    /* =========================================================
       HERO BANNER WITH INDUSTRIAL BACKGROUND
    ========================================================= */
    .wtl-hero {
        position: relative;
        margin: 0 -28px 20px;
        padding: 22px 28px 74px;
        overflow: hidden;
        background: linear-gradient(90deg, #F4F8FC 0%, #EBF2FA 52%, rgba(235, 242, 250, 0.65) 100%);
        border-bottom: 1px solid #DCE7F3;
    }

    .wtl-hero-bg {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        width: 50%;
        background-image: url('{{ asset('images/hero-banner-p611.jpg') }}?v=3');
        background-size: 100% 100%;
        background-repeat: no-repeat;
        background-position: right center;
        opacity: 0.55;
        pointer-events: none;
        -webkit-mask-image: linear-gradient(90deg, transparent 0%, rgba(0, 0, 0, 0.65) 28%, rgba(0, 0, 0, 1) 70%);
        mask-image: linear-gradient(90deg, transparent 0%, rgba(0, 0, 0, 0.65) 28%, rgba(0, 0, 0, 1) 70%);
    }

    .wtl-hero-top {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .wtl-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #1D68C4;
        margin-bottom: 8px;
    }

    .wtl-eyebrow::before {
        content: '';
        width: 18px;
        height: 2px;
        background: #1D68C4;
        display: inline-block;
    }

    .wtl-hero-title {
        margin: 0;
        font-size: clamp(24px, 2.5vw, 34px);
        font-weight: 800;
        color: #0D2E57;
        letter-spacing: -0.02em;
        line-height: 1.18;
    }

    .wtl-hero-sub {
        margin: 8px 0 0;
        font-size: 14px;
        font-weight: 500;
        color: #476282;
    }

    /* Right Status Pills (Date & User) - Compact */
    .wtl-top-Widgets {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .wtl-pill-card {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 11px;
        border-radius: 11px;
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(219, 231, 245, 0.95);
        box-shadow: 0 3px 10px rgba(15, 45, 80, 0.05);
    }

    .wtl-pill-icon {
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: #EFF6FF;
        color: #1D68C4;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
    }

    .wtl-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #113D73;
        color: #FFFFFF;
        font-size: 10.5px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .wtl-pill-label {
        font-size: 9.5px;
        font-weight: 600;
        color: #64748B;
        line-height: 1.15;
    }

    .wtl-pill-value {
        font-size: 11px;
        font-weight: 800;
        color: #0F294A;
        line-height: 1.2;
    }

    /* =========================================================
       4 KPI SUMMARY CARDS (COMPACT)
    ========================================================= */
    .wtl-kpi-grid {
        position: relative;
        z-index: 3;
        margin-top: -48px;
        margin-bottom: 18px;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .wtl-kpi-card {
        position: relative;
        overflow: hidden;
        border-radius: 13px;
        padding: 12px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 6px 18px rgba(15, 45, 80, 0.05);
    }

    .wtl-kpi-blue {
        background: #EAF2FD;
        border-color: #D6E6FB;
    }

    .wtl-kpi-green {
        background: #E8F8F0;
        border-color: #CEEFE0;
    }

    .wtl-kpi-amber {
        background: #FFF1E0;
        border-color: #FDE2C4;
    }

    .wtl-kpi-purple {
        background: #F1ECFE;
        border-color: #E3D8FD;
    }

    .wtl-kpi-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        flex-shrink: 0;
    }

    .wtl-kpi-blue .wtl-kpi-icon {
        color: #1A73E8;
    }

    .wtl-kpi-green .wtl-kpi-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #1E8E5A;
        color: #FFFFFF;
        font-size: 20px;
    }

    .wtl-kpi-amber .wtl-kpi-icon {
        color: #E07A16;
    }

    .wtl-kpi-purple .wtl-kpi-icon {
        color: #7C3AED;
    }

    .wtl-kpi-num {
        font-size: 22px;
        font-weight: 800;
        color: #0B1F3A;
        line-height: 1.15;
        margin: 0 0 2px;
        letter-spacing: -0.02em;
    }

    .wtl-kpi-title {
        font-size: 11.5px;
        font-weight: 600;
        margin: 0;
    }

    .wtl-kpi-blue .wtl-kpi-title {
        color: #1E3A5F;
    }

    .wtl-kpi-green .wtl-kpi-title {
        color: #14532D;
    }

    .wtl-kpi-amber .wtl-kpi-title {
        color: #431407;
    }

    .wtl-kpi-purple .wtl-kpi-title {
        color: #6D28D9;
    }

    /* =========================================================
       MAIN REPOSITORY CARD
    ========================================================= */
    .wtl-repo-card {
        background: #FFFFFF;
        border: 1px solid #DCE7F3;
        border-radius: 18px;
        box-shadow: 0 8px 28px rgba(15, 45, 80, 0.05);
        overflow: hidden;
    }

    .wtl-repo-header {
        padding: 22px 24px 16px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .wtl-repo-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #2563EB;
        margin-bottom: 4px;
    }

    .wtl-repo-title {
        margin: 0;
        font-size: 21px;
        font-weight: 800;
        color: #0D2E57;
    }

    .wtl-repo-desc {
        margin: 4px 0 0;
        font-size: 12.5px;
        color: #64748B;
        font-weight: 500;
    }

    .wtl-add-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 10px;
        background: #F8FAFC;
        border: 1px solid #CBD5E1;
        color: #1E40AF;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .wtl-add-btn:hover {
        background: #EFF6FF;
        border-color: #93C5FD;
    }

    /* Filter Form Row */
    .wtl-filter-bar {
        padding: 20px 24px 16px;
        display: grid;
        grid-template-columns: minmax(240px, 2.2fr) repeat(3, minmax(130px, 1fr)) auto;
        gap: 10px;
        align-items: center;
    }

    .wtl-search-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .wtl-search-input-wrap i {
        position: absolute;
        left: 14px;
        color: #94A3B8;
        font-size: 13.5px;
        pointer-events: none;
    }

    .wtl-input {
        width: 100%;
        height: 42px;
        padding: 0 14px 0 38px;
        border-radius: 10px;
        border: 1px solid #D5E2F0;
        background: #FBFDFF;
        font-size: 13px;
        font-weight: 500;
        color: #1E293B;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .wtl-input:focus,
    .wtl-select:focus {
        border-color: #2563EB;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        background: #FFFFFF;
    }

    .wtl-select-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .wtl-select-wrap i.prefix-icon {
        position: absolute;
        left: 12px;
        color: #64748B;
        font-size: 12.5px;
        pointer-events: none;
    }

    .wtl-select {
        width: 100%;
        height: 42px;
        padding: 0 28px 0 33px;
        border-radius: 10px;
        border: 1px solid #D5E2F0;
        background: #FBFDFF;
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        outline: none;
        cursor: pointer;
    }

    .wtl-search-submit {
        height: 42px;
        padding: 0 20px;
        border-radius: 10px;
        border: 0;
        background: linear-gradient(135deg, #1976D2, #1565C0);
        color: #FFFFFF;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(25, 118, 210, 0.25);
        transition: opacity 0.15s;
    }

    .wtl-search-submit:hover {
        opacity: 0.94;
    }

    /* Meta Row Above Table */
    .wtl-meta-row {
        padding: 0 24px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
        color: #64748B;
        font-weight: 500;
    }

    .wtl-meta-row strong {
        color: #0F172A;
        font-weight: 800;
    }

    /* Table */
    .wtl-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .wtl-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .wtl-table thead tr {
        background: #133B6E;
        color: #FFFFFF;
    }

    .wtl-table th {
        padding: 13px 16px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.02em;
        white-space: nowrap;
    }

    .wtl-table th:first-child,
    .wtl-table td:first-child {
        padding-left: 24px;
    }

    .wtl-table th:last-child,
    .wtl-table td:last-child {
        padding-right: 24px;
    }

    .wtl-table tbody tr {
        border-bottom: 1px solid #EEF2F7;
        transition: background-color 0.15s ease;
    }

    .wtl-table tbody tr:hover {
        background-color: #F8FBFF;
    }

    .wtl-table td {
        padding: 13px 16px;
        font-size: 13px;
        vertical-align: middle;
        color: #1E293B;
    }

    .wtl-col-no {
        color: #94A3B8 !important;
        font-weight: 700;
        font-size: 12px !important;
    }

    .wtl-doc-no {
        font-weight: 800;
        color: #0F294A;
        white-space: nowrap;
    }

    .wtl-vendor-cell {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        font-weight: 600;
        color: #334155;
        white-space: nowrap;
    }

    .wtl-vendor-badge {
        width: 26px;
        height: 26px;
        border-radius: 7px;
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
        color: #1D4ED8;
        font-size: 10px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .wtl-doc-title {
        font-weight: 600;
        color: #1E293B;
    }

    /* Content Type Pill */
    .wtl-type-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 11px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        white-space: nowrap;
    }

    .wtl-type-drawing {
        background: #EFF6FF;
        color: #1D4ED8;
        border: 1px solid #BFDBFE;
    }

    .wtl-type-manual {
        background: #F5F3FF;
        color: #6D28D9;
        border: 1px solid #DDD6FE;
    }

    .wtl-type-datasheet {
        background: #ECFDF5;
        color: #047857;
        border: 1px solid #A7F3D0;
    }

    /* Rack Pill */
    .wtl-rack-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 4px 11px;
        border-radius: 999px;
        background: #ECFDF5;
        color: #059669;
        border: 1px solid #A7F3D0;
        font-size: 11.5px;
        font-weight: 800;
        white-space: nowrap;
    }

    .wtl-notes {
        color: #64748B;
        font-size: 12.5px;
        font-weight: 500;
        white-space: nowrap;
    }

    /* Action Buttons */
    .wtl-actions {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .wtl-act-btn {
        width: 31px;
        height: 29px;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.15s ease;
        border: 1px solid #D5E2F0;
        background: #FFFFFF;
        color: #475569;
    }

    .wtl-act-btn:hover {
        background: #F1F5F9;
        color: #0F172A;
    }

    .wtl-act-view {
        background: #1976D2;
        border-color: #1976D2;
        color: #FFFFFF;
    }

    .wtl-act-view:hover {
        background: #1565C0;
        color: #FFFFFF;
    }

    /* Pagination Footer */
    .wtl-footer {
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        background: #FBFDFF;
    }

    .wtl-page-info {
        font-size: 12px;
        color: #64748B;
        font-weight: 500;
    }

    .wtl-page-info strong {
        color: #0F172A;
        font-weight: 800;
    }

    .wtl-pagination {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .wtl-page-btn {
        height: 32px;
        min-width: 32px;
        padding: 0 10px;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        background: #FFFFFF;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        text-decoration: none;
        cursor: pointer;
    }

    .wtl-page-btn.is-active {
        background: #1976D2;
        border-color: #1976D2;
        color: #FFFFFF;
    }

    @media (max-width: 1100px) {
        .wtl-kpi-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .wtl-filter-bar {
            grid-template-columns: 1fr 1fr;
        }

        .wtl-search-input-wrap {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 640px) {
        .wtl-page {
            padding: 0 14px 24px;
        }

        .wtl-topbar {
            margin: 0 -14px;
            padding: 10px 14px;
        }

        .wtl-hero {
            margin: 0 -14px 18px;
            padding: 20px 14px 22px;
        }

        .wtl-kpi-grid {
            grid-template-columns: 1fr;
        }

        .wtl-filter-bar {
            grid-template-columns: 1fr;
        }
    }
</style>

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

    <!-- 4 SUMMARY KPI CARDS -->
    <section class="wtl-kpi-grid">
        <div class="wtl-kpi-card wtl-kpi-blue">
            <div>
                <div class="wtl-kpi-num">{{ number_format($stats['total_documents']) }}</div>
                <p class="wtl-kpi-title">Total Documents</p>
            </div>
        </div>

        <div class="wtl-kpi-card wtl-kpi-green">
            <div>
                <div class="wtl-kpi-num">{{ number_format($stats['available']) }}</div>
                <p class="wtl-kpi-title">Available</p>
            </div>
        </div>

        <div class="wtl-kpi-card wtl-kpi-amber">
            <div>
                <div class="wtl-kpi-num">{{ $stats['racks'] }}</div>
                <p class="wtl-kpi-title">Racks</p>
            </div>
        </div>

        <div class="wtl-kpi-card wtl-kpi-purple">
            <div>
                <div class="wtl-kpi-num">{{ number_format($stats['manuals_as_built']) }}</div>
                <p class="wtl-kpi-title">Manuals &amp; As-Built</p>
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
