@extends('layouts.app')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    :root {
        --report-ink: #0f172a;
        --report-muted: #64748b;
        --report-border: #dbe2ea;
        --report-soft: #f8fafc;
        --report-brand: #173a5e;
        --report-blue: #0369a1;
        --report-green: #15803d;
        --report-amber: #d7a642;
        --report-red: #b91c1c;
        --report-teal: #0f766e;
    }
    .equipment-report-shell {
        color: var(--report-ink);
    }
    .report-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem 1.1rem;
        border: 1px solid var(--report-border);
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 8px 26px rgba(15, 23, 42, 0.05);
    }
    .report-brand {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        min-width: 260px;
    }
    .report-logo {
        width: 54px;
        height: 54px;
        object-fit: contain;
        flex: 0 0 auto;
    }
    .report-title {
        margin: 0;
        color: var(--report-brand);
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: 0;
    }
    .report-subtitle {
        margin: 0.15rem 0 0;
        color: var(--report-muted);
        font-size: 0.88rem;
    }
    .report-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 0.5rem;
    }
    .report-panel {
        margin-top: 1rem;
        padding: 1rem;
        border: 1px solid var(--report-border);
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 8px 26px rgba(15, 23, 42, 0.04);
    }
    .report-panel-title {
        margin: 0 0 0.8rem;
        color: var(--report-brand);
        font-size: 0.95rem;
        font-weight: 800;
    }
    .report-filter-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.75rem;
    }
    .report-filter-grid .form-label {
        margin-bottom: 0.25rem;
        color: #334155;
        font-size: 0.78rem;
        font-weight: 700;
    }
    .report-filter-grid .form-control,
    .report-filter-grid .form-select {
        min-height: 36px;
        font-size: 0.88rem;
    }
    .report-filter-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-end;
        gap: 0.5rem;
        margin-top: 0.85rem;
    }
    .filter-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
        margin-top: 0.85rem;
    }
    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        max-width: 100%;
        padding: 0.25rem 0.55rem;
        border: 1px solid #c7d7e8;
        border-radius: 999px;
        background: #eef5fb;
        color: #28435f;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .filter-chip strong {
        color: var(--report-brand);
    }
    .report-kpi-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 0.75rem;
        margin-top: 1rem;
    }
    .kpi-card {
        min-height: 118px;
        padding: 0.85rem;
        border: 1px solid var(--report-border);
        border-top: 4px solid var(--report-brand);
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
    }
    .kpi-card .kpi-label {
        margin: 0;
        color: var(--report-muted);
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .kpi-card .kpi-value {
        margin: 0.3rem 0 0;
        color: var(--report-ink);
        font-size: 1.35rem;
        font-weight: 800;
        line-height: 1.15;
        word-break: break-word;
    }
    .kpi-card .kpi-note {
        margin: 0.35rem 0 0;
        color: var(--report-muted);
        font-size: 0.78rem;
    }
    .kpi-tone-success { border-top-color: var(--report-green); }
    .kpi-tone-info { border-top-color: var(--report-blue); }
    .kpi-tone-warning { border-top-color: var(--report-amber); }
    .kpi-tone-danger { border-top-color: var(--report-red); }
    .kpi-tone-muted { border-top-color: #64748b; }
    .kpi-tone-teal { border-top-color: var(--report-teal); }
    .report-chart-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.85rem;
        margin-top: 1rem;
    }
    .chart-panel {
        min-height: 320px;
        padding: 1rem;
        border: 1px solid var(--report-border);
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
    }
    .chart-title {
        margin: 0 0 0.75rem;
        color: var(--report-brand);
        font-size: 0.92rem;
        font-weight: 800;
    }
    .chart-box {
        position: relative;
        height: 248px;
    }
    .report-table-toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }
    .table-tools {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .report-column-selector {
        max-height: 230px;
        overflow: auto;
        padding: 0.75rem;
        border: 1px solid var(--report-border);
        border-radius: 8px;
        background: var(--report-soft);
    }
    .report-table-shell {
        max-height: 650px;
        overflow: auto;
        border: 1px solid var(--report-border);
        border-radius: 8px;
    }
    .report-table {
        margin-bottom: 0;
        min-width: 1180px;
    }
    .report-table th {
        position: sticky;
        top: 0;
        z-index: 5;
        border-color: #173a5e !important;
        background: #173a5e !important;
        color: #fff;
        font-size: 0.76rem;
        vertical-align: middle;
        cursor: pointer;
        white-space: nowrap;
    }
    .report-table td {
        vertical-align: top;
        font-size: 0.84rem;
    }
    .report-table td[data-column="description"],
    .report-table td[data-column="updates"] {
        min-width: 260px;
        white-space: normal;
    }
    .report-table td[data-column="person_in_charge"] {
        min-width: 160px;
    }
    .report-status-pill {
        display: inline-flex;
        align-items: center;
        max-width: 100%;
        padding: 0.2rem 0.5rem;
        border-radius: 999px;
        font-size: 0.76rem;
        font-weight: 800;
        white-space: normal;
    }
    .report-status-available { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .report-status-in-use { background: #eff7ff; color: #075985; border: 1px solid #bae6fd; }
    .report-status-maintenance { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
    .report-status-danger { background: #fff1f1; color: #991b1b; border: 1px solid #fecaca; }
    .report-status-review { background: #f8fafc; color: #475569; border: 1px solid #cbd5e1; }
    .empty-state {
        padding: 2rem 1rem;
        color: var(--report-muted);
        text-align: center;
    }
    .loading-overlay {
        position: fixed;
        inset: 0;
        z-index: 2000;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(15, 23, 42, 0.32);
    }
    .loading-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.2rem;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 20px 44px rgba(15, 23, 42, 0.18);
        color: var(--report-brand);
        font-weight: 700;
    }
    @media (max-width: 1400px) {
        .report-filter-grid,
        .report-kpi-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        .report-chart-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 992px) {
        .report-filter-grid,
        .report-kpi-grid,
        .report-chart-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 640px) {
        .report-header,
        .report-actions,
        .report-filter-actions,
        .report-table-toolbar {
            align-items: stretch;
            flex-direction: column;
        }
        .report-filter-grid,
        .report-kpi-grid,
        .report-chart-grid {
            grid-template-columns: 1fr;
        }
        .report-actions .btn,
        .report-filter-actions .btn,
        .table-tools .btn,
        .table-tools .form-control {
            width: 100%;
        }
    }
</style>

@php
    $dateBasisOptions = [
        'date_acquired' => 'Date Acquired',
        'created_at' => 'Created Date',
        'updated_at' => 'Last Updated',
    ];
    $statusOptions = [
        'available' => 'Available',
        'in_use' => 'In Use',
        'maintenance' => 'Maintenance',
        'damaged' => 'Damaged',
        'lost' => 'Lost',
        'retired' => 'Retired/Inactive',
        'review' => 'Needs Review',
    ];
    $numericColumns = ['qty', 'received_quantity', 'used_quantity', 'balance_quantity', 'unit_cost', 'total_cost'];
@endphp

<div class="conatiner-fluid content-inner mt-n5 py-0 equipment-report-shell" id="equipmentReportsPage" data-export-url="{{ route('equipments.export') }}" data-default-columns='@json($defaultColumnKeys)'>
    <div class="report-header">
        <div class="report-brand">
            <img src="{{ asset('assets/images/bfarlogo.png') }}" class="report-logo" alt="BFAR logo">
            <div>
                <h1 class="report-title">Equipment Reports</h1>
                <p class="report-subtitle">Regional Fisheries Laboratory XII inventory intelligence dashboard</p>
            </div>
        </div>
        <div class="report-actions">
            <a href="{{ route('equipments.index') }}" class="btn btn-outline-secondary">Equipment List</a>
            <div class="btn-group">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Export</button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><button class="dropdown-item report-export-action" type="button" data-format="pdf">Export PDF</button></li>
                    <li><button class="dropdown-item report-export-action" type="button" data-format="xlsx">Export Excel (.xlsx)</button></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="report-panel">
        <h2 class="report-panel-title">Report Filters</h2>
        <form id="equipmentReportFilterForm" method="GET" action="{{ route('equipments.reports') }}">
            <div class="report-filter-grid">
                <div>
                    <label class="form-label" for="report_type">Report Type</label>
                    <select class="form-select" id="report_type" name="report_type">
                        <option value="">Dashboard Overview</option>
                        @foreach($reportTypes as $group)
                            <optgroup label="{{ $group['group'] }}">
                                @foreach($group['items'] as $item)
                                    <option value="{{ $item['value'] }}" @selected(request('report_type') === $item['value'])>{{ $item['label'] }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="search">Search</label>
                    <input class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Equipment, code, brand, location">
                </div>
                <div>
                    <label class="form-label" for="date_basis">Date Basis</label>
                    <select class="form-select" id="date_basis" name="date_basis">
                        @foreach($dateBasisOptions as $value => $label)
                            <option value="{{ $value }}" @selected(request('date_basis', 'date_acquired') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="availability">Availability</label>
                    <select class="form-select" id="availability" name="availability">
                        <option value="">All availability states</option>
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected(request('availability') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="date_from">Date From</label>
                    <input class="form-control" type="date" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div>
                    <label class="form-label" for="date_to">Date To</label>
                    <input class="form-control" type="date" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div>
                    <label class="form-label" for="month">Month</label>
                    <input class="form-control" type="month" id="month" name="month" value="{{ request('month') }}">
                </div>
                <div>
                    <label class="form-label" for="year">Year</label>
                    <select class="form-select" id="year" name="year">
                        <option value="">Any year</option>
                        @foreach($filterOptions['years'] as $year)
                            <option value="{{ $year }}" @selected((string) request('year') === (string) $year)>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="equipment">Equipment Name</label>
                    <select class="form-select" id="equipment" name="equipment">
                        <option value="">All equipment</option>
                        @foreach($filterOptions['equipment'] as $option)
                            <option value="{{ $option }}" @selected(request('equipment') === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="equipment_no">Asset Code / Inventory No.</label>
                    <input class="form-control" id="equipment_no" name="equipment_no" value="{{ request('equipment_no') }}" list="equipmentNoOptions">
                    <datalist id="equipmentNoOptions">
                        @foreach($filterOptions['equipment_no'] as $option)
                            <option value="{{ $option }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div>
                    <label class="form-label" for="brand_model">Brand / Model</label>
                    <select class="form-select" id="brand_model" name="brand_model">
                        <option value="">All brands/models</option>
                        @foreach($filterOptions['brand_model'] as $option)
                            <option value="{{ $option }}" @selected(request('brand_model') === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="location">Office / Location</label>
                    <select class="form-select" id="location" name="location">
                        <option value="">All locations</option>
                        @foreach($filterOptions['location'] as $option)
                            <option value="{{ $option }}" @selected(request('location') === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="status_remarks">Status / Condition</label>
                    <input class="form-control" id="status_remarks" name="status_remarks" value="{{ request('status_remarks') }}" list="statusRemarkOptions">
                    <datalist id="statusRemarkOptions">
                        @foreach($filterOptions['status_remarks'] as $option)
                            <option value="{{ $option }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div>
                    <label class="form-label" for="person_in_charge">Assigned User</label>
                    <select class="form-select" id="person_in_charge" name="person_in_charge">
                        <option value="">All assigned users</option>
                        @foreach($users as $user)
                            @php $userName = trim(collect([$user->f_name, $user->m_name, $user->l_name])->filter()->implode(' ')); @endphp
                            <option value="{{ $user->id }}" @selected((string) request('person_in_charge') === (string) $user->id)>{{ $userName ?: 'User #' . $user->id }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="unit">Unit</label>
                    <select class="form-select" id="unit" name="unit">
                        <option value="">All units</option>
                        @foreach($filterOptions['unit'] as $option)
                            <option value="{{ $option }}" @selected(request('unit') === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="rfl_control_no">RFL Control No.</label>
                    <input class="form-control" id="rfl_control_no" name="rfl_control_no" value="{{ request('rfl_control_no') }}" list="rflOptions">
                    <datalist id="rflOptions">
                        @foreach($filterOptions['rfl_control_no'] as $option)
                            <option value="{{ $option }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div>
                    <label class="form-label" for="quarter">Quarter</label>
                    <select class="form-select" id="quarter" name="quarter">
                        <option value="">Any quarter</option>
                        <option value="1" @selected(request('quarter') === '1')>Q1</option>
                        <option value="2" @selected(request('quarter') === '2')>Q2</option>
                        <option value="3" @selected(request('quarter') === '3')>Q3</option>
                        <option value="4" @selected(request('quarter') === '4')>Q4</option>
                    </select>
                </div>
            </div>

            <div class="collapse mt-3" id="advancedReportFilters">
                <div class="report-filter-grid">
                    <div>
                        <label class="form-label" for="day">Day</label>
                        <input class="form-control" type="date" id="day" name="day" value="{{ request('day') }}">
                    </div>
                    <div>
                        <label class="form-label" for="week">Week</label>
                        <input class="form-control" type="week" id="week" name="week" value="{{ request('week') }}">
                    </div>
                    <div>
                        <label class="form-label" for="description">Description</label>
                        <input class="form-control" id="description" name="description" value="{{ request('description') }}">
                    </div>
                    <div>
                        <label class="form-label" for="updates">Updates / Tags</label>
                        <input class="form-control" id="updates" name="updates" value="{{ request('updates') }}">
                    </div>
                    @foreach($numericColumns as $numericColumn)
                        @php $columnLabel = collect($equipmentTableColumns)->firstWhere('key', $numericColumn)['label'] ?? $numericColumn; @endphp
                        <div>
                            <label class="form-label" for="{{ $numericColumn }}_min">{{ $columnLabel }} Min</label>
                            <input class="form-control" type="number" step="0.01" id="{{ $numericColumn }}_min" name="{{ $numericColumn }}_min" value="{{ request($numericColumn . '_min') }}">
                        </div>
                        <div>
                            <label class="form-label" for="{{ $numericColumn }}_max">{{ $columnLabel }} Max</label>
                            <input class="form-control" type="number" step="0.01" id="{{ $numericColumn }}_max" name="{{ $numericColumn }}_max" value="{{ request($numericColumn . '_max') }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="report-filter-actions">
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#advancedReportFilters" aria-expanded="false" aria-controls="advancedReportFilters">Advanced Filters</button>
                <a class="btn btn-light" href="{{ route('equipments.reports') }}">Reset</a>
                <button class="btn btn-primary" type="submit">Apply Filters</button>
            </div>
        </form>

        @if(!empty($appliedFilters['applied']))
            <div class="filter-chips">
                @foreach($appliedFilters['applied'] as $filter)
                    <span class="filter-chip"><strong>{{ $filter['label'] }}:</strong> {{ $filter['value'] }}</span>
                @endforeach
            </div>
        @endif
    </div>

    <div class="report-kpi-grid">
        @foreach($reportStats['cards'] as $card)
            <div class="kpi-card kpi-tone-{{ $card['tone'] }}">
                <p class="kpi-label">{{ $card['label'] }}</p>
                <p class="kpi-value">{{ $card['value'] }}</p>
                <p class="kpi-note">{{ $card['note'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="report-chart-grid">
        <div class="chart-panel">
            <h2 class="chart-title">Equipment Status Distribution</h2>
            <div class="chart-box"><canvas id="statusDistributionChart"></canvas></div>
        </div>
        <div class="chart-panel">
            <h2 class="chart-title">Equipment Added Per Month</h2>
            <div class="chart-box"><canvas id="addedPerMonthChart"></canvas></div>
        </div>
        <div class="chart-panel">
            <h2 class="chart-title">Equipment Availability</h2>
            <div class="chart-box"><canvas id="availabilityChart"></canvas></div>
        </div>
        <div class="chart-panel">
            <h2 class="chart-title">Location Distribution</h2>
            <div class="chart-box"><canvas id="locationDistributionChart"></canvas></div>
        </div>
        <div class="chart-panel">
            <h2 class="chart-title">Brand / Model Distribution</h2>
            <div class="chart-box"><canvas id="brandDistributionChart"></canvas></div>
        </div>
        <div class="chart-panel">
            <h2 class="chart-title">Quantity Position</h2>
            <div class="chart-box"><canvas id="quantitySummaryChart"></canvas></div>
        </div>
    </div>

    <div class="report-panel">
        <div class="report-table-toolbar">
            <div>
                <h2 class="report-panel-title mb-1">Filtered Equipment Records</h2>
                <div class="text-muted small">{{ number_format($reportEquipments->total()) }} records found</div>
            </div>
            <div class="table-tools">
                <input class="form-control" id="reportTableQuickSearch" placeholder="Search current page">
                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#reportColumnSelector" aria-expanded="false" aria-controls="reportColumnSelector">Columns</button>
            </div>
        </div>

        <div class="collapse mb-3" id="reportColumnSelector">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>Visible Columns</strong>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="reportSelectAllColumns">Select All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="reportResetColumns">Default</button>
                </div>
            </div>
            <div class="report-column-selector">
                <div class="row g-2">
                    @foreach($equipmentTableColumns as $column)
                        <div class="col-md-4 col-sm-6">
                            <div class="form-check">
                                <input class="form-check-input report-column-toggle" type="checkbox" value="{{ $column['key'] }}" id="report_column_{{ $column['key'] }}" {{ in_array($column['key'], $defaultColumnKeys, true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="report_column_{{ $column['key'] }}">{{ $column['label'] }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="report-table-shell">
            <table class="table table-striped report-table" id="equipmentReportTable">
                <thead>
                    <tr>
                        @foreach($equipmentTableColumns as $column)
                            <th data-column="{{ $column['key'] }}" data-sort-column="{{ $column['key'] }}" class="{{ in_array($column['key'], $defaultColumnKeys, true) ? '' : 'd-none' }}">{{ $column['label'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportEquipments as $equipment)
                        @php
                            $row = $reportRows[$equipment->id] ?? [];
                            $statusText = strtolower($row['status_remarks'] ?? '');
                            $statusClass = 'report-status-review';
                            if (str_contains($statusText, 'maintenance') || str_contains($statusText, 'repair') || str_contains($statusText, 'calibration')) {
                                $statusClass = 'report-status-maintenance';
                            } elseif (str_contains($statusText, 'in use') || str_contains($statusText, 'assigned') || str_contains($statusText, 'issued')) {
                                $statusClass = 'report-status-in-use';
                            } elseif (str_contains($statusText, 'available') || str_contains($statusText, 'ready') || $statusText === 'n/a') {
                                $statusClass = 'report-status-available';
                            } elseif (str_contains($statusText, 'damaged') || str_contains($statusText, 'lost') || str_contains($statusText, 'retired') || str_contains($statusText, 'inactive')) {
                                $statusClass = 'report-status-danger';
                            }
                        @endphp
                        <tr>
                            @foreach($equipmentTableColumns as $column)
                                @php
                                    $value = $row[$column['key']] ?? 'N/A';
                                    $isNumeric = in_array($column['type'] ?? 'text', ['number'], true);
                                @endphp
                                <td data-column="{{ $column['key'] }}" data-sort-value="{{ strtolower((string) $value) }}" class="{{ in_array($column['key'], $defaultColumnKeys, true) ? '' : 'd-none' }} {{ $isNumeric ? 'text-end' : '' }}">
                                    @if($column['key'] === 'status_remarks')
                                        <span class="report-status-pill {{ $statusClass }}">{{ $value }}</span>
                                    @else
                                        {!! nl2br(e($value)) !!}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($equipmentTableColumns) }}" class="empty-state">No equipment records match the selected filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $reportEquipments->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<div class="loading-overlay" id="reportLoadingOverlay">
    <div class="loading-card">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span>Generating report...</span>
    </div>
</div>

<script type="application/json" id="equipmentReportChartData">@json($chartData)</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const page = document.getElementById('equipmentReportsPage');
    if (!page) {
        return;
    }

    const defaultColumns = JSON.parse(page.dataset.defaultColumns || '[]');
    const storageKey = 'equipment-report-visible-columns';
    const table = document.getElementById('equipmentReportTable');
    const toggles = Array.from(document.querySelectorAll('.report-column-toggle'));
    const form = document.getElementById('equipmentReportFilterForm');
    const overlay = document.getElementById('reportLoadingOverlay');
    const chartData = JSON.parse(document.getElementById('equipmentReportChartData')?.textContent || '{}');

    function showOverlay() {
        if (overlay) {
            overlay.style.display = 'flex';
        }
    }

    function hideOverlay() {
        if (overlay) {
            overlay.style.display = 'none';
        }
    }

    function getStoredColumns() {
        try {
            const stored = JSON.parse(localStorage.getItem(storageKey) || '[]');
            return stored.length ? stored : defaultColumns;
        } catch (error) {
            return defaultColumns;
        }
    }

    function visibleColumns() {
        const selected = toggles.filter(function (toggle) {
            return toggle.checked;
        }).map(function (toggle) {
            return toggle.value;
        });

        return selected.length ? selected : defaultColumns;
    }

    function syncToggles(columns) {
        const visible = new Set(columns);
        toggles.forEach(function (toggle) {
            toggle.checked = visible.has(toggle.value);
        });
    }

    function applyColumns(columns) {
        const visible = new Set(columns);
        table?.querySelectorAll('[data-column]').forEach(function (cell) {
            cell.classList.toggle('d-none', !visible.has(cell.dataset.column));
        });
    }

    const initialColumns = getStoredColumns();
    syncToggles(initialColumns);
    applyColumns(initialColumns);

    toggles.forEach(function (toggle) {
        toggle.addEventListener('change', function () {
            const columns = visibleColumns();
            localStorage.setItem(storageKey, JSON.stringify(columns));
            applyColumns(columns);
        });
    });

    document.getElementById('reportSelectAllColumns')?.addEventListener('click', function () {
        const columns = toggles.map(function (toggle) { return toggle.value; });
        syncToggles(columns);
        localStorage.setItem(storageKey, JSON.stringify(columns));
        applyColumns(columns);
    });

    document.getElementById('reportResetColumns')?.addEventListener('click', function () {
        syncToggles(defaultColumns);
        localStorage.setItem(storageKey, JSON.stringify(defaultColumns));
        applyColumns(defaultColumns);
    });

    form?.addEventListener('submit', showOverlay);

    document.querySelectorAll('.report-export-action').forEach(function (button) {
        button.addEventListener('click', function () {
            const exportUrl = new URL(page.dataset.exportUrl, window.location.origin);
            const formData = new FormData(form);
            const dateFilterKeys = ['date_from', 'date_to', 'day', 'week', 'month', 'quarter', 'year'];
            const hasDateFilter = dateFilterKeys.some(function (key) {
                return String(formData.get(key) || '').trim() !== '';
            });

            formData.forEach(function (value, key) {
                if (key === 'date_basis' && !hasDateFilter) {
                    return;
                }

                if (String(value).trim() !== '') {
                    exportUrl.searchParams.append(key, value);
                }
            });

            exportUrl.searchParams.set('format', button.dataset.format);
            visibleColumns().forEach(function (column) {
                exportUrl.searchParams.append('columns[]', column);
            });

            showOverlay();
            window.location.href = exportUrl.toString();
            setTimeout(hideOverlay, 1400);
        });
    });

    document.getElementById('reportTableQuickSearch')?.addEventListener('input', function (event) {
        const needle = event.target.value.trim().toLowerCase();
        table?.querySelectorAll('tbody tr').forEach(function (row) {
            row.style.display = row.textContent.toLowerCase().includes(needle) ? '' : 'none';
        });
    });

    table?.querySelectorAll('th[data-sort-column]').forEach(function (header) {
        header.addEventListener('click', function () {
            const tbody = table.querySelector('tbody');
            const column = header.dataset.sortColumn;
            const rows = Array.from(tbody.querySelectorAll('tr')).filter(function (row) {
                return row.querySelector('td[data-column]');
            });
            const direction = header.dataset.direction === 'asc' ? 'desc' : 'asc';

            table.querySelectorAll('th[data-sort-column]').forEach(function (th) {
                delete th.dataset.direction;
            });
            header.dataset.direction = direction;

            rows.sort(function (a, b) {
                const aValue = a.querySelector('[data-column="' + column + '"]')?.dataset.sortValue || '';
                const bValue = b.querySelector('[data-column="' + column + '"]')?.dataset.sortValue || '';
                const aNumber = Number(aValue.replace(/,/g, ''));
                const bNumber = Number(bValue.replace(/,/g, ''));
                const comparison = !Number.isNaN(aNumber) && !Number.isNaN(bNumber)
                    ? aNumber - bNumber
                    : aValue.localeCompare(bValue);

                return direction === 'asc' ? comparison : -comparison;
            });

            rows.forEach(function (row) {
                tbody.appendChild(row);
            });
        });
    });

    if (!window.Chart) {
        return;
    }

    Chart.defaults.font.family = 'Arial, sans-serif';
    Chart.defaults.color = '#475569';

    const commonGrid = {
        color: 'rgba(203, 213, 225, 0.7)',
        borderColor: 'rgba(203, 213, 225, 0.7)'
    };

    function createDoughnut(canvasId, payload) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) {
            return;
        }
        new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels: payload.labels || [],
                datasets: [{
                    data: payload.data || [],
                    backgroundColor: payload.colors || ['#173a5e', '#0369a1', '#15803d'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                cutout: '62%'
            }
        });
    }

    createDoughnut('statusDistributionChart', chartData.statusDistribution || {});
    createDoughnut('availabilityChart', chartData.availability || {});

    const addedCanvas = document.getElementById('addedPerMonthChart');
    if (addedCanvas) {
        new Chart(addedCanvas, {
            type: 'bar',
            data: {
                labels: chartData.addedPerMonth?.labels || [],
                datasets: [
                    {
                        type: 'bar',
                        label: 'Added',
                        data: chartData.addedPerMonth?.added || [],
                        backgroundColor: '#173a5e',
                        borderRadius: 4
                    },
                    {
                        type: 'line',
                        label: 'Maintenance',
                        data: chartData.addedPerMonth?.maintenance || [],
                        borderColor: '#d7a642',
                        backgroundColor: '#d7a642',
                        tension: 0.35
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: commonGrid }
                },
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    function createHorizontalBar(canvasId, payload, color) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) {
            return;
        }
        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: payload.labels || [],
                datasets: [{
                    label: 'Records',
                    data: payload.data || [],
                    backgroundColor: color,
                    borderRadius: 4
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { beginAtZero: true, ticks: { precision: 0 }, grid: commonGrid },
                    y: { grid: { display: false } }
                },
                plugins: { legend: { display: false } }
            }
        });
    }

    createHorizontalBar('locationDistributionChart', chartData.locationDistribution || {}, '#0369a1');
    createHorizontalBar('brandDistributionChart', chartData.brandDistribution || {}, '#0f766e');

    const quantityCanvas = document.getElementById('quantitySummaryChart');
    if (quantityCanvas) {
        new Chart(quantityCanvas, {
            type: 'bar',
            data: {
                labels: chartData.quantitySummary?.labels || [],
                datasets: [{
                    label: 'Quantity',
                    data: chartData.quantitySummary?.data || [],
                    backgroundColor: chartData.quantitySummary?.colors || ['#173a5e', '#0369a1', '#15803d'],
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: commonGrid }
                },
                plugins: { legend: { display: false } }
            }
        });
    }
});
</script>
@endsection
