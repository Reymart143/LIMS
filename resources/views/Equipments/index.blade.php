@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<style>
    :root {
        --equipment-surface: #ffffff;
        --equipment-muted: #6b7280;
        --equipment-border: #dbe2ea;
        --equipment-accent: #1e3a5f;
        --equipment-soft: #f8fafc;
    }
    .toolbar-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.75rem;
    }
    .toolbar-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.5rem;
    }
    .toolbar-search {
        min-width: 220px;
        max-width: 320px;
    }
    .toolbar-button {
        margin-left: auto;
        flex-shrink: 0;
    }
    .toolbar-panel {
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        border: 1px solid var(--equipment-border);
        border-radius: 14px;
        padding: 0.85rem 1rem;
        box-shadow: 0 8px 30px rgba(15, 23, 42, 0.05);
        margin-bottom: 1rem;
    }
    .column-selector {
        max-height: 220px;
        overflow: auto;
        border: 1px solid var(--equipment-border);
        border-radius: 12px;
        padding: 0.75rem;
        background: var(--equipment-soft);
    }
    .column-selector .form-check {
        margin-bottom: 0.35rem;
    }
    .table-shell {
        border: 1px solid var(--equipment-border);
        border-radius: 14px;
        overflow-x: auto;
        box-shadow: 0 8px 30px rgba(15, 23, 42, 0.05);
    }
    .equipment-table th,
    .equipment-table td {
        vertical-align: top;
        white-space: nowrap;
    }
    .equipment-table td[data-column="description"],
    .equipment-table td[data-column="updates"],
    .equipment-table th[data-column="description"],
    .equipment-table th[data-column="updates"] {
        white-space: normal;
        min-width: 180px;
    }
    .equipment-table td[data-column="person_in_charge"],
    .equipment-table th[data-column="person_in_charge"] {
        min-width: 150px;
    }
    .equipment-table-shell {
        position: relative;
    }
    .equipment-row-actions-overlay {
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: 20;
    }
    .equipment-row-actions-panel {
        position: absolute;
        left: 0;
        right: auto;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.45rem;
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid rgba(219, 226, 234, 0.95);
        border-radius: 0.6rem;
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.12);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-50%) translateX(8px);
        transition: opacity 0.18s ease, transform 0.18s ease, visibility 0.18s ease;
        pointer-events: auto;
    }
    .equipment-row-actions-panel.is-visible {
        opacity: 1;
        visibility: visible;
        transform: translateY(-50%) translateX(0);
    }
    .equipment-row-actions-panel .row-actions {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .field-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.75rem;
        padding: 0.2rem 0.5rem;
        border-radius: 999px;
        background: #eef4fb;
        color: #36506d;
        margin-left: 0.4rem;
    }
    .compact-panel {
        background: var(--equipment-surface);
        border: 1px solid var(--equipment-border);
        border-radius: 14px;
        padding: 0.7rem 0.8rem;
        margin-bottom: 0;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
    }
    .compact-panel .form-label {
        margin-bottom: 0.2rem;
        font-size: 0.8rem;
        line-height: 1.15;
    }
    .compact-panel .form-control,
    .compact-panel .form-select {
        min-height: 34px;
        font-size: 0.88rem;
    }
    .compact-panel textarea.form-control {
        min-height: 54px;
    }
    .readonly-field {
        background: #eef2f7 !important;
        cursor: not-allowed;
    }
    .field-help {
        font-size: 0.78rem;
        color: var(--equipment-muted);
        margin-top: 0.25rem;
    }
    .section-title {
        font-size: 0.86rem;
        font-weight: 700;
        color: var(--equipment-accent);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .section-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.85rem 1rem;
    }
    .section-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.85rem 1rem;
    }
    .equipment-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.65rem 0.75rem;
        align-items: start;
    }
    .equipment-form-grid .compact-panel,
    .equipment-form-grid .actions-row {
        min-width: 0;
    }
    .equipment-form-grid .actions-row {
        grid-column: 1 / -1;
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
        margin-top: 0.15rem;
    }
    .equipment-form-grid .section-grid {
        gap: 0.55rem 0.75rem;
    }
    .equipment-form-grid .section-grid-3 {
        gap: 0.55rem 0.75rem;
    }
    .loading-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.38);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2000;
    }
    .loading-card {
        background: #fff;
        padding: 1rem 1.25rem;
        border-radius: 14px;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .equipment-modal .modal-content {
        max-height: calc(100vh - 1.25rem);
    }
    .equipment-modal .modal-body {
        padding-top: 0.85rem;
        padding-bottom: 0.85rem;
    }
    .equipment-modal .modal-header {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
@media (max-width: 576px) {
         .toolbar-row {
             flex-direction: column;
         }
         .toolbar-search {
             max-width: 100%;
             width: 100%;
         }
         .toolbar-button {
             width: 100%;
             margin-left: 0;
         }
         .toolbar-group {
             width: 100%;
             justify-content: flex-end;
         }
         .section-grid,
         .section-grid-3 {
            grid-template-columns: 1fr;
        }
        .equipment-form-grid {
            grid-template-columns: 1fr;
        }
        .equipment-form-grid .actions-row {
            grid-column: auto;
        }
    }
    .choices {
        width: 100% !important;
    }
    .choices__inner {
        width: 100% !important;
        box-sizing: border-box;
    }
    .swal2-popup.equipment-swal {
        border-radius: 1rem;
        font-family: inherit;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@php
    $visibleColumnKeys = collect($equipmentTableColumns)->filter(fn ($column) => !empty($column['default_visible']))->pluck('key')->values()->all();
@endphp
<div class="conatiner-fluid content-inner mt-n5 py-0" id="equipmentPage" data-default-columns='@json($visibleColumnKeys)' data-export-url="{{ route('equipments.export') }}" data-error-modal="{{ old('form_type', '') }}" data-success-message="{{ session('success') }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">INVENTORY</h4>
                        <p class="mb-0 text-muted">Equipment, Glassware, and Supplies Inventory Management</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon-shape bg-success bg-opacity-10 text-primary rounded-3 p-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted mb-1">Total Items</h6>
                                        <h3 class="mb-0 fw-bold">{{ number_format($totalItems ?? 0) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon-shape bg-success bg-opacity-10 text-success rounded-3 p-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted mb-1">Available</h6>
                                        <h3 class="mb-0 fw-bold">{{ number_format($availableCount ?? 0) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted mb-1">In Use</h6>
                                        <h3 class="mb-0 fw-bold">{{ number_format($inUseCount ?? 0) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon-shape bg-danger bg-opacity-10 text-danger rounded-3 p-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted mb-1">Under Maintenance</h6>
                                        <h3 class="mb-0 fw-bold">{{ number_format($underMaintenanceCount ?? 0) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="toolbar-panel">
                        <div class="toolbar-row">
                            <div class="toolbar-group">
                                <div class="toolbar-search">
                                    <form id="equipmentFilterForm" action="{{ route('equipments.index') }}" method="GET" class="d-flex gap-2">
                                        <input type="text" name="search" class="form-control" placeholder="Search equipment..." value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">Filter</button>
                                    </form>
                                </div>
                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#columnSelectorPanel" aria-expanded="false" aria-controls="columnSelectorPanel">Column Selector</button>
                                <div class="btn-group">
                                    <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Export</button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><button class="dropdown-item export-action" type="button" data-format="xlsx">Export Excel (.xlsx)</button></li>
                                        <li><button class="dropdown-item export-action" type="button" data-format="pdf">Export PDF</button></li>
                                    </ul>
                                </div>
                            </div>
                            <a class="btn btn-success toolbar-button" data-bs-toggle="modal" data-bs-target="#addEquipmentModal" aria-label="Add Equipment" title="Add Equipment">
                                Add Equipment
                            </a>
                        </div>
                        <div class="collapse mt-3" id="columnSelectorPanel">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Visible Columns</strong>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="selectAllColumns">Select All</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="resetColumns">Default</button>
                                </div>
                            </div>
                            <div class="column-selector" id="columnSelector">
                                <div class="row g-2">
                                    @foreach($equipmentTableColumns as $column)
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="{{ $column['key'] }}" id="column_{{ $column['key'] }}" {{ !empty($column['default_visible']) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="column_{{ $column['key'] }}">{{ $column['label'] }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-3 table-shell equipment-table-shell" id="equipmentTableShell">
                        <table class="table table-striped mb-0 equipment-table" role="grid" data-bs-toggle="data-table" id="equipmentTable">
                            <thead>
                                <tr class="light">
                                    @foreach($equipmentTableColumns as $column)
                                        <th data-column="{{ $column['key'] }}" data-default-visible="{{ !empty($column['default_visible']) ? '1' : '0' }}" class="{{ empty($column['default_visible']) ? 'd-none' : '' }}">{{ $column['label'] }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($equipments as $equipment)
                                @php
                                    $personInChargeValue = $equipment->person_in_charge;
                                    if (is_string($personInChargeValue)) {
                                        $personInChargeValue = json_decode($personInChargeValue, true);
                                    }
                                    $personInChargeValue = is_array($personInChargeValue) ? $personInChargeValue : [];
                                @endphp
                                <tr
                                    class="equipment-row"
                                    data-update-url="{{ route('equipments.update', $equipment->id) }}"
                                    data-delete-url="{{ route('equipments.destroy', $equipment->id) }}"
                                    data-equipment-id="{{ $equipment->id }}"
                                    data-equipment="{{ $equipment->equipment }}"
                                    data-equipment-no="{{ $equipment->equipment_no ?? '' }}"
                                    data-qty="{{ $equipment->qty ?? 0 }}"
                                    data-unit="{{ $equipment->unit ?? '' }}"
                                    data-rfl-control-no="{{ $equipment->rfl_control_no ?? '' }}"
                                    data-description="{{ e($equipment->description ?? '') }}"
                                    data-brand-model="{{ $equipment->brand_model ?? '' }}"
                                    data-date-acquired="{{ $equipment->date_acquired ? \Carbon\Carbon::parse($equipment->date_acquired)->format('Y-m-d') : '' }}"
                                    data-unit-cost="{{ $equipment->unit_cost ?? 0 }}"
                                    data-total-cost="{{ $equipment->total_cost ?? 0 }}"
                                    data-status-remarks="{{ e($equipment->status_remarks ?? '') }}"
                                    data-received-quantity="{{ $equipment->received_quantity ?? 0 }}"
                                    data-used-quantity="{{ $equipment->used_quantity ?? 0 }}"
                                    data-balance-quantity="{{ $equipment->balance_quantity ?? 0 }}"
                                    data-location="{{ e($equipment->location ?? '') }}"
                                    data-person-in-charge='@json($personInChargeValue)'
                                    data-updates='@json($equipment->updates ?? "")'
                                >
                                    <td data-column="equipment">{{ $equipment->equipment }}</td>
                                    <td data-column="equipment_no">{{ $equipment->equipment_no ?? 'N/A' }}</td>
                                    <td data-column="qty">{{ $equipment->qty ?? 0 }}</td>
                                    <td data-column="unit">{{ $equipment->unit ?? 'N/A' }}</td>
                                    <td data-column="rfl_control_no" class="d-none">{{ $equipment->rfl_control_no ?? 'N/A' }}</td>
                                    <td data-column="description">{{ $equipment->description ?? 'N/A' }}</td>
                                    <td data-column="brand_model" class="d-none">{{ $equipment->brand_model ?? 'N/A' }}</td>
                                    <td data-column="date_acquired" class="d-none">{{ $equipment->date_acquired ? \Carbon\Carbon::parse($equipment->date_acquired)->format('Y-m-d') : 'N/A' }}</td>
                                    <td data-column="unit_cost" class="d-none">{{ $equipment->unit_cost ?? 0 }}</td>
                                    <td data-column="total_cost" class="d-none">{{ $equipment->total_cost ?? 0 }}</td>
                                    <td data-column="status_remarks">{{ $equipment->status_remarks ?? 'N/A' }}</td>
                                    <td data-column="received_quantity" class="d-none">{{ $equipment->received_quantity ?? 0 }}</td>
                                    <td data-column="used_quantity" class="d-none">{{ $equipment->used_quantity ?? 0 }}</td>
                                    <td data-column="balance_quantity" class="d-none">{{ $equipment->balance_quantity ?? 0 }}</td>
                                    <td data-column="location" class="d-none">{{ $equipment->location ?? 'N/A' }}</td>
                                    <td data-column="person_in_charge" class="d-none">
                                        @php
                                            $personInCharge = $equipment->person_in_charge;
                                            if (is_string($personInCharge)) {
                                                $personInCharge = json_decode($personInCharge, true);
                                            }
                                            $personInCharge = is_array($personInCharge) ? $personInCharge : [];
                                        @endphp
                                        @if(!empty($personInCharge))
                                            @foreach($personInCharge as $userId)
                                                @php
                                                    $user = $users->firstWhere('id', $userId);
                                                    $initials = $user ? strtoupper(
                                                        ($user->f_name ? substr($user->f_name, 0, 1) : '') .
                                                        ($user->m_name ? substr($user->m_name, 0, 1) : '') .
                                                        ($user->l_name ? substr($user->l_name, 0, 1) : '')
                                                    ) : '';
                                                @endphp
                                                <span class="badge bg-secondary">{{ $initials }}</span>
                                            @endforeach
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td data-column="updates" class="d-none">{!! $equipment->updates ?? 'N/A' !!}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ count($equipmentTableColumns) }}" class="text-center text-muted py-5">
                                        <em>No inventory data available yet.</em>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="equipment-row-actions-overlay" id="equipmentRowActionsOverlay" aria-hidden="true">
                            <div class="equipment-row-actions-panel" id="equipmentRowActionsPanel">
                                <button type="button" class="btn btn-sm btn-primary" id="equipmentRowEditButton">Edit</button>
                                <form id="equipmentRowDeleteForm" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body py-2">
                        <div class="d-flex justify-content-center">
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm mb-0">
                                    {{ $equipments->links('pagination::bootstrap-5') }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Equipment Modal -->
<div class="modal fade" id="addEquipmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered equipment-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEquipmentModalLabel">Add New Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <strong>Please correct the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif
                <form id="equipmentForm" data-has-errors="{{ $errors->any() ? '1' : '0' }}" class="equipment-form-grid needs-validation" action="{{ route('equipments.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="compact-panel">
                        <div class="section-title">Source & Identification</div>
                        <div class="section-grid">
                            <div>
                                <label for="equipment" class="form-label">Equipment *</label>
                                <select class="form-select @error('equipment') is-invalid @enderror" id="equipment" name="equipment" required>
                                    <option value="">Select Equipment</option>
                                    @foreach($equipmentDropdown as $item)
                                        <option value="{{ $item->equipment }}" data-id="{{ $item->id }}" data-equipment-no="{{ $item->equipment_no }}" data-brand-model="{{ $item->model }}" data-location="{{ $item->location }}" data-year="{{ $item->year }}" data-date="{{ $item->date }}" {{ old('equipment') === $item->equipment ? 'selected' : '' }}>
                                            {{ $item->equipment }}{{ $item->model ? ' (' . $item->model . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="field-help">Pick the inventory source record. This drives the system-generated fields below.</div>
                                @error('equipment')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="equipment_no" class="form-label">Equipment No. <span class="field-chip">Auto-generated</span></label>
                                <input type="text" class="form-control readonly-field @error('equipment_no') is-invalid @enderror" id="equipment_no" name="equipment_no" value="{{ old('equipment_no') }}" readonly required data-bs-toggle="tooltip" title="Filled automatically from the selected source record.">
                                @error('equipment_no')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="compact-panel">
                        <div class="section-title">Quantity & Cost</div>
                        <div class="section-grid-3">
                            <div>
                                <label for="qty" class="form-label">Qty *</label>
                                <input type="number" class="form-control @error('qty') is-invalid @enderror" id="qty" name="qty" min="0" value="{{ old('qty', 0) }}" required>
                                @error('qty')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="unit_cost" class="form-label">Unit Cost * <span class="field-chip">Editable</span></label>
                                <input type="number" step="0.01" min="0" class="form-control @error('unit_cost') is-invalid @enderror" id="unit_cost" name="unit_cost" value="{{ old('unit_cost', 0) }}" required>
                                @error('unit_cost')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="total_cost" class="form-label">Total Cost <span class="field-chip">Auto</span></label>
                                <input type="number" step="0.01" min="0" class="form-control readonly-field @error('total_cost') is-invalid @enderror" id="total_cost" name="total_cost" value="{{ old('total_cost') }}" readonly data-bs-toggle="tooltip" title="Calculated automatically from Qty x Unit Cost.">
                                @error('total_cost')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="received_quantity" class="form-label">Received Quantity *</label>
                                <input type="number" class="form-control @error('received_quantity') is-invalid @enderror" id="received_quantity" name="received_quantity" min="0" value="{{ old('received_quantity', 0) }}" required>
                                @error('received_quantity')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="used_quantity" class="form-label">Used Quantity *</label>
                                <input type="number" class="form-control @error('used_quantity') is-invalid @enderror" id="used_quantity" name="used_quantity" min="0" value="{{ old('used_quantity', 0) }}" required>
                                @error('used_quantity')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="balance_quantity" class="form-label">Balance Quantity <span class="field-chip">Auto</span></label>
                                <input type="number" class="form-control readonly-field @error('balance_quantity') is-invalid @enderror" id="balance_quantity" name="balance_quantity" value="{{ old('balance_quantity') }}" readonly data-bs-toggle="tooltip" title="Calculated automatically from Received Quantity - Used Quantity.">
                                @error('balance_quantity')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="compact-panel">
                        <div class="section-title">Details & Assignment</div>
                        <div class="section-grid">
                            <div>
                                <label for="unit" class="form-label">Unit</label>
                                <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" value="{{ old('unit') }}" maxlength="255">
                                @error('unit')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="brand_model" class="form-label">Brand / Model <span class="field-chip">System-generated</span></label>
                                <input type="text" class="form-control readonly-field @error('brand_model') is-invalid @enderror" id="brand_model" name="brand_model" value="{{ old('brand_model') }}" readonly maxlength="255" data-bs-toggle="tooltip" title="Filled automatically from the selected source record.">
                                @error('brand_model')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="date_acquired" class="form-label">Date Acquired</label>
                                <input type="date" class="form-control @error('date_acquired') is-invalid @enderror" id="date_acquired" name="date_acquired" value="{{ old('date_acquired') }}">
                                @error('date_acquired')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="location" class="form-label">Location <span class="field-chip">System-generated</span></label>
                                <input type="text" class="form-control readonly-field @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" readonly maxlength="255" data-bs-toggle="tooltip" title="Filled automatically from the selected source record.">
                                @error('location')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mt-2">
                            <label for="person_in_charge" class="form-label">Person In-Charge</label>
                            <select class="form-select @error('person_in_charge') is-invalid @enderror @error('person_in_charge.*') is-invalid @enderror" id="person_in_charge" name="person_in_charge[]" multiple>
                                @foreach($users as $user)
                                    @php
                                        $initials = strtoupper(
                                            ($user->f_name ? substr($user->f_name, 0, 1) : '') .
                                            ($user->m_name ? substr($user->m_name, 0, 1) : '') .
                                            ($user->l_name ? substr($user->l_name, 0, 1) : '')
                                        );
                                        $selectedPersonInCharge = old('person_in_charge', []);
                                        if (is_string($selectedPersonInCharge)) {
                                            $selectedPersonInCharge = json_decode($selectedPersonInCharge, true);
                                        }
                                        $selectedPersonInCharge = is_array($selectedPersonInCharge) ? $selectedPersonInCharge : [];
                                    @endphp
                                    <option value="{{ $user->id }}" {{ in_array($user->id, $selectedPersonInCharge) ? 'selected' : '' }}>{{ $initials }}</option>
                                @endforeach
                            </select>
                            @error('person_in_charge')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            @error('person_in_charge.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="compact-panel">
                        <div class="section-title">Remarks & Notes</div>
                        <div class="section-grid">
                            <div>
                                <label for="rfl_control_no" class="form-label">RFL Control No.</label>
                                <input type="text" class="form-control @error('rfl_control_no') is-invalid @enderror" id="rfl_control_no" name="rfl_control_no" value="{{ old('rfl_control_no') }}" maxlength="255">
                                @error('rfl_control_no')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="status_remarks" class="form-label">Status / Remarks</label>
                                <textarea class="form-control @error('status_remarks') is-invalid @enderror" id="status_remarks" name="status_remarks" rows="2" maxlength="5000">{{ old('status_remarks') }}</textarea>
                                @error('status_remarks')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mt-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="1" maxlength="5000">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="mt-2">
                            <label for="updates" class="form-label">Updates</label>
                            <textarea class="form-control @error('updates') is-invalid @enderror" id="updates" name="updates" rows="1" maxlength="10000">{{ old('updates') }}</textarea>
                            @error('updates')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="actions-row">
                        <button class="btn btn-success" id="saveEquipmentBtn" type="submit">
                            <span class="save-label">Save Equipment</span>
                            <span class="save-spinner spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Equipment Modal -->
<div class="modal fade" id="editEquipmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered equipment-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEquipmentModalLabel">Update Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <strong>Please correct the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif
                <form id="editEquipmentForm" data-has-errors="{{ $errors->any() ? '1' : '0' }}" class="equipment-form-grid needs-validation" action="{{ route('equipments.update', old('equipment_id', 0)) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_type" value="edit">
                    <input type="hidden" name="equipment_id" id="edit_equipment_id" value="{{ old('equipment_id') }}">
                    <div class="compact-panel">
                        <div class="section-title">Source & Identification</div>
                        <div class="section-grid">
                            <div>
                                <label for="edit_equipment" class="form-label">Equipment *</label>
                                <select class="form-select @error('equipment') is-invalid @enderror" id="edit_equipment" name="equipment" required>
                                    <option value="">Select Equipment</option>
                                    @foreach($equipmentDropdown as $item)
                                        <option value="{{ $item->equipment }}" data-id="{{ $item->id }}" data-equipment-no="{{ $item->equipment_no }}" data-brand-model="{{ $item->model }}" data-location="{{ $item->location }}" data-year="{{ $item->year }}" data-date="{{ $item->date }}" {{ old('equipment') === $item->equipment ? 'selected' : '' }}>
                                            {{ $item->equipment }}{{ $item->model ? ' (' . $item->model . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="field-help">Pick the inventory source record. This drives the system-generated fields below.</div>
                                @error('equipment')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="edit_equipment_no" class="form-label">Equipment No. <span class="field-chip">Auto-generated</span></label>
                                <input type="text" class="form-control readonly-field @error('equipment_no') is-invalid @enderror" id="edit_equipment_no" name="equipment_no" value="{{ old('equipment_no') }}" readonly required data-bs-toggle="tooltip" title="Filled automatically from the selected source record.">
                                @error('equipment_no')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="compact-panel">
                        <div class="section-title">Quantity & Cost</div>
                        <div class="section-grid-3">
                            <div>
                                <label for="edit_qty" class="form-label">Qty *</label>
                                <input type="number" class="form-control @error('qty') is-invalid @enderror" id="edit_qty" name="qty" min="0" value="{{ old('qty') }}" required>
                                @error('qty')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="edit_unit_cost" class="form-label">Unit Cost * <span class="field-chip">Editable</span></label>
                                <input type="number" step="0.01" min="0" class="form-control @error('unit_cost') is-invalid @enderror" id="edit_unit_cost" name="unit_cost" value="{{ old('unit_cost') }}" required>
                                @error('unit_cost')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="edit_total_cost" class="form-label">Total Cost <span class="field-chip">Auto</span></label>
                                <input type="number" step="0.01" min="0" class="form-control readonly-field @error('total_cost') is-invalid @enderror" id="edit_total_cost" name="total_cost" value="{{ old('total_cost') }}" readonly data-bs-toggle="tooltip" title="Calculated automatically from Qty x Unit Cost.">
                                @error('total_cost')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="edit_received_quantity" class="form-label">Received Quantity *</label>
                                <input type="number" class="form-control @error('received_quantity') is-invalid @enderror" id="edit_received_quantity" name="received_quantity" min="0" value="{{ old('received_quantity') }}" required>
                                @error('received_quantity')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="edit_used_quantity" class="form-label">Used Quantity *</label>
                                <input type="number" class="form-control @error('used_quantity') is-invalid @enderror" id="edit_used_quantity" name="used_quantity" min="0" value="{{ old('used_quantity') }}" required>
                                @error('used_quantity')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="edit_balance_quantity" class="form-label">Balance Quantity <span class="field-chip">Auto</span></label>
                                <input type="number" class="form-control readonly-field @error('balance_quantity') is-invalid @enderror" id="edit_balance_quantity" name="balance_quantity" value="{{ old('balance_quantity') }}" readonly data-bs-toggle="tooltip" title="Calculated automatically from Received Quantity - Used Quantity.">
                                @error('balance_quantity')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="compact-panel">
                        <div class="section-title">Details & Assignment</div>
                        <div class="section-grid">
                            <div>
                                <label for="edit_unit" class="form-label">Unit</label>
                                <input type="text" class="form-control @error('unit') is-invalid @enderror" id="edit_unit" name="unit" value="{{ old('unit') }}" maxlength="255">
                                @error('unit')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="edit_brand_model" class="form-label">Brand / Model <span class="field-chip">System-generated</span></label>
                                <input type="text" class="form-control readonly-field @error('brand_model') is-invalid @enderror" id="edit_brand_model" name="brand_model" value="{{ old('brand_model') }}" readonly maxlength="255" data-bs-toggle="tooltip" title="Filled automatically from the selected source record.">
                                @error('brand_model')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="edit_date_acquired" class="form-label">Date Acquired</label>
                                <input type="date" class="form-control @error('date_acquired') is-invalid @enderror" id="edit_date_acquired" name="date_acquired" value="{{ old('date_acquired') }}">
                                @error('date_acquired')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="edit_location" class="form-label">Location <span class="field-chip">System-generated</span></label>
                                <input type="text" class="form-control readonly-field @error('location') is-invalid @enderror" id="edit_location" name="location" value="{{ old('location') }}" readonly maxlength="255" data-bs-toggle="tooltip" title="Filled automatically from the selected source record.">
                                @error('location')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mt-2">
                            <label for="edit_person_in_charge" class="form-label">Person In-Charge</label>
                            @php
                                $editSelectedPersonInCharge = old('person_in_charge', []);
                                if (is_string($editSelectedPersonInCharge)) {
                                    $editSelectedPersonInCharge = json_decode($editSelectedPersonInCharge, true);
                                }
                                $editSelectedPersonInCharge = is_array($editSelectedPersonInCharge) ? $editSelectedPersonInCharge : [];
                            @endphp
                            <select class="form-select @error('person_in_charge') is-invalid @enderror @error('person_in_charge.*') is-invalid @enderror" id="edit_person_in_charge" name="person_in_charge[]" multiple>
                                @foreach($users as $user)
                                    @php
                                        $initials = strtoupper(
                                            ($user->f_name ? substr($user->f_name, 0, 1) : '') .
                                            ($user->m_name ? substr($user->m_name, 0, 1) : '') .
                                            ($user->l_name ? substr($user->l_name, 0, 1) : '')
                                        );
                                    @endphp
                                    <option value="{{ $user->id }}" {{ in_array($user->id, $editSelectedPersonInCharge) ? 'selected' : '' }}>{{ $initials }}</option>
                                @endforeach
                            </select>
                            @error('person_in_charge')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            @error('person_in_charge.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="compact-panel">
                        <div class="section-title">Remarks & Notes</div>
                        <div class="section-grid">
                            <div>
                                <label for="edit_rfl_control_no" class="form-label">RFL Control No.</label>
                                <input type="text" class="form-control @error('rfl_control_no') is-invalid @enderror" id="edit_rfl_control_no" name="rfl_control_no" value="{{ old('rfl_control_no') }}" maxlength="255">
                                @error('rfl_control_no')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="edit_status_remarks" class="form-label">Status / Remarks</label>
                                <textarea class="form-control @error('status_remarks') is-invalid @enderror" id="edit_status_remarks" name="status_remarks" rows="2" maxlength="5000">{{ old('status_remarks') }}</textarea>
                                @error('status_remarks')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mt-2">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="edit_description" name="description" rows="1" maxlength="5000">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="mt-2">
                            <label for="edit_updates" class="form-label">Updates</label>
                            <textarea class="form-control @error('updates') is-invalid @enderror" id="edit_updates" name="updates" rows="1" maxlength="10000">{{ old('updates') }}</textarea>
                            @error('updates')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="actions-row">
                        <button class="btn btn-success" id="editSaveEquipmentBtn" type="submit">
                            <span class="save-label">Update Equipment</span>
                            <span class="save-spinner spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="loading-overlay" id="globalLoadingOverlay" aria-hidden="true">
    <div class="loading-card">
        <div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
        <div>
            <div class="fw-semibold">Processing...</div>
            <div class="text-muted small">Please wait while your request completes.</div>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';
    const pageRoot = document.getElementById('equipmentPage');
    const defaultColumns = JSON.parse(pageRoot?.dataset.defaultColumns || '[]');
    const exportBaseUrl = pageRoot?.dataset.exportUrl || '';
    const errorModalType = pageRoot?.dataset.errorModal || '';

    const storageKey = 'equipment.visibleColumns';
    const columnToggles = Array.from(document.querySelectorAll('.column-toggle'));

    const addForm = document.getElementById('equipmentForm');
    const addModalElement = document.getElementById('addEquipmentModal');
    const addSaveButton = document.getElementById('saveEquipmentBtn');
    const addSaveLabel = addSaveButton?.querySelector('.save-label');
    const addSaveSpinner = addSaveButton?.querySelector('.save-spinner');

    const editForm = document.getElementById('editEquipmentForm');
    const editModalElement = document.getElementById('editEquipmentModal');
    const editSaveButton = document.getElementById('editSaveEquipmentBtn');
    const editSaveLabel = editSaveButton?.querySelector('.save-label');
    const editSaveSpinner = editSaveButton?.querySelector('.save-spinner');
    const rowActionsOverlay = document.getElementById('equipmentRowActionsOverlay');
    const rowActionsPanel = document.getElementById('equipmentRowActionsPanel');
    const rowActionsEditButton = document.getElementById('equipmentRowEditButton');
    const rowActionsDeleteForm = document.getElementById('equipmentRowDeleteForm');
    const tableShell = document.getElementById('equipmentTableShell');

    const equipmentTable = document.getElementById('equipmentTable');

    let addPersonInChargeChoices = null;
    let addEquipmentChoices = null;
    let editPersonInChargeChoices = null;
    let editEquipmentChoices = null;
    let activeEquipmentRow = null;
    let hideRowActionsTimer = null;

    function safeParseJson(value, fallback) {
        if (value === null || value === undefined || value === '') {
            return fallback;
        }

        try {
            const parsed = JSON.parse(value);
            return parsed === null ? fallback : parsed;
        } catch (error) {
            return fallback;
        }
    }

    function showSweetAlert(type, title, text) {
        if (typeof Swal === 'undefined') {
            return;
        }

        Swal.fire({
            icon: type,
            title: title,
            text: text,
            confirmButtonText: 'OK',
            buttonsStyling: false,
            customClass: {
                popup: 'equipment-swal',
                confirmButton: 'btn btn-primary px-4'
            }
        });
    }

    function normalizeIntegerValue(value) {
        const text = String(value ?? '').trim();

        if (!text) {
            return '';
        }

        if (!/^\d+$/.test(text)) {
            return value;
        }

        return String(parseInt(text, 10));
    }

    function normalizeFormIntegers(form, fieldNames) {
        fieldNames.forEach(function(fieldName) {
            const input = form?.querySelector(`[name="${fieldName}"]`);
            if (input && input.value !== '') {
                input.value = normalizeIntegerValue(input.value);
            }
        });
    }

    function focusFirstInvalid(container) {
        const firstInvalid = container?.querySelector('.is-invalid, .form-control:invalid, .form-select:invalid');
        if (firstInvalid) {
            firstInvalid.focus();
        }
    }

    function wireFormValidation(form, modalElement, saveButton, saveLabel, saveSpinner, integerFieldNames) {
        if (!form) {
            return;
        }

        form.addEventListener('submit', function(event) {
            normalizeFormIntegers(form, integerFieldNames);

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                focusFirstInvalid(form);
                return;
            }

            if (saveButton) {
                saveButton.disabled = true;
                if (saveLabel) {
                    saveLabel.textContent = 'Saving...';
                }
                if (saveSpinner) {
                    saveSpinner.classList.remove('d-none');
                }
            }

            form.classList.add('was-validated');
        });

        form.querySelectorAll('input, textarea, select').forEach(function(field) {
            field.addEventListener('input', function() {
                if (field.checkValidity()) {
                    field.classList.remove('is-invalid');
                }
            });
        });

        form.querySelectorAll(`[name="${integerFieldNames.join('"], [name="')}"]`).forEach(function(field) {
            field.addEventListener('blur', function() {
                if (field.value !== '') {
                    field.value = normalizeIntegerValue(field.value);
                }
            });
        });

        if (modalElement) {
            modalElement.addEventListener('shown.bs.modal', function() {
                focusFirstInvalid(modalElement);
            }, { once: false });
        }
    }

    function bindSelectAutoFill(selectElement, equipmentNoInput, brandModelInput, dateAcquiredInput, locationInput) {
        if (!selectElement) {
            return;
        }

        selectElement.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption && selectedOption.value) {
                equipmentNoInput.value = selectedOption.dataset.equipmentNo || '';
                brandModelInput.value = selectedOption.dataset.brandModel || '';
                if (selectedOption.dataset.date) {
                    const datePart = selectedOption.dataset.date.split(' ')[0];
                    dateAcquiredInput.value = datePart;
                } else {
                    dateAcquiredInput.value = '';
                }
                locationInput.value = selectedOption.dataset.location || '';
            } else {
                equipmentNoInput.value = '';
                brandModelInput.value = '';
                dateAcquiredInput.value = '';
                locationInput.value = '';
            }
        });
    }

    function bindCalculation(qtyInput, unitCostInput, totalCostInput) {
        if (!qtyInput || !unitCostInput || !totalCostInput) {
            return;
        }

        function calculateTotalCost() {
            const qty = parseFloat(qtyInput.value) || 0;
            const unitCost = parseFloat(unitCostInput.value) || 0;
            totalCostInput.value = (qty * unitCost).toFixed(2);
        }

        qtyInput.addEventListener('input', calculateTotalCost);
        unitCostInput.addEventListener('input', calculateTotalCost);
        calculateTotalCost();
    }

    function bindBalanceCalculation(receivedQtyInput, usedQtyInput, balanceQtyInput) {
        if (!receivedQtyInput || !usedQtyInput || !balanceQtyInput) {
            return;
        }

        function calculateBalance() {
            const received = parseInt(receivedQtyInput.value, 10) || 0;
            const used = parseInt(usedQtyInput.value, 10) || 0;
            balanceQtyInput.value = Math.max(0, received - used);
        }

        receivedQtyInput.addEventListener('input', calculateBalance);
        usedQtyInput.addEventListener('input', calculateBalance);
        calculateBalance();
    }

    function bindChoices(selectElement, config) {
        if (!selectElement) {
            return null;
        }

        return new Choices(selectElement, config);
    }

    function setChoicesSelection(choicesInstance, selectElement, value) {
        if (!selectElement) {
            return;
        }

        if (choicesInstance && typeof choicesInstance.removeActiveItems === 'function') {
            choicesInstance.removeActiveItems();

            if (Array.isArray(value)) {
                value.forEach(function(item) {
                    choicesInstance.setChoiceByValue(String(item));
                });
            } else if (value !== null && value !== undefined && value !== '') {
                choicesInstance.setChoiceByValue(String(value));
            }
            return;
        }

        if (Array.isArray(value)) {
            Array.from(selectElement.options).forEach(function(option) {
                option.selected = value.map(String).includes(String(option.value));
            });
        } else {
            selectElement.value = value ?? '';
        }

        selectElement.dispatchEvent(new Event('change', { bubbles: true }));
    }

    function getStoredColumns() {
        try {
            const stored = JSON.parse(sessionStorage.getItem(storageKey) || localStorage.getItem(storageKey) || 'null');
            return Array.isArray(stored) && stored.length ? stored : defaultColumns;
        } catch (error) {
            return defaultColumns;
        }
    }

    function persistColumns(columns) {
        sessionStorage.setItem(storageKey, JSON.stringify(columns));
        try {
            localStorage.setItem(storageKey, JSON.stringify(columns));
        } catch (error) {}
    }

    function applyVisibleColumns(columns) {
        const visibleSet = new Set(columns);
        document.querySelectorAll('[data-column]').forEach(function(cell) {
            const isVisible = visibleSet.has(cell.dataset.column);
            cell.classList.toggle('d-none', !isVisible);
        });
    }

    function syncColumnToggles(columns) {
        const visibleSet = new Set(columns);
        columnToggles.forEach(function(toggle) {
            toggle.checked = visibleSet.has(toggle.value);
        });
    }

    function currentVisibleColumns() {
        return columnToggles.filter(function(toggle) { return toggle.checked; }).map(function(toggle) { return toggle.value; });
    }

    bindSelectAutoFill(
        document.getElementById('equipment'),
        document.getElementById('equipment_no'),
        document.getElementById('brand_model'),
        document.getElementById('date_acquired'),
        document.getElementById('location')
    );

    bindSelectAutoFill(
        document.getElementById('edit_equipment'),
        document.getElementById('edit_equipment_no'),
        document.getElementById('edit_brand_model'),
        document.getElementById('edit_date_acquired'),
        document.getElementById('edit_location')
    );

    bindCalculation(document.getElementById('qty'), document.getElementById('unit_cost'), document.getElementById('total_cost'));
    bindCalculation(document.getElementById('edit_qty'), document.getElementById('edit_unit_cost'), document.getElementById('edit_total_cost'));

    bindBalanceCalculation(document.getElementById('received_quantity'), document.getElementById('used_quantity'), document.getElementById('balance_quantity'));
    bindBalanceCalculation(document.getElementById('edit_received_quantity'), document.getElementById('edit_used_quantity'), document.getElementById('edit_balance_quantity'));

    addPersonInChargeChoices = bindChoices(document.getElementById('person_in_charge'), {
        removeItemButton: true,
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select persons in-charge',
    });

    editPersonInChargeChoices = bindChoices(document.getElementById('edit_person_in_charge'), {
        removeItemButton: true,
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select persons in-charge',
    });

    addEquipmentChoices = bindChoices(document.getElementById('equipment'), {
        removeItemButton: false,
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Search equipment...',
    });

    editEquipmentChoices = bindChoices(document.getElementById('edit_equipment'), {
        removeItemButton: false,
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Search equipment...',
    });

    const initialColumns = getStoredColumns();
    syncColumnToggles(initialColumns);
    applyVisibleColumns(initialColumns);

    columnToggles.forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const columns = currentVisibleColumns();
            persistColumns(columns);
            applyVisibleColumns(columns);
        });
    });

    document.getElementById('selectAllColumns')?.addEventListener('click', function() {
        const columns = columnToggles.map(function(toggle) { return toggle.value; });
        syncColumnToggles(columns);
        persistColumns(columns);
        applyVisibleColumns(columns);
    });

    document.getElementById('resetColumns')?.addEventListener('click', function() {
        syncColumnToggles(defaultColumns);
        persistColumns(defaultColumns);
        applyVisibleColumns(defaultColumns);
    });

    document.querySelectorAll('.export-action').forEach(function(button) {
        button.addEventListener('click', function() {
            const columns = currentVisibleColumns();
            const exportUrl = new URL(exportBaseUrl, window.location.origin);
            exportUrl.searchParams.set('format', button.dataset.format);
            exportUrl.searchParams.set('search', document.querySelector('input[name="search"]')?.value || '');
            columns.forEach(function(column) {
                exportUrl.searchParams.append('columns[]', column);
            });

            const overlay = document.getElementById('globalLoadingOverlay');
            overlay.style.display = 'flex';
            window.location.href = exportUrl.toString();
            setTimeout(function() {
                overlay.style.display = 'none';
            }, 1200);
        });
    });

    function populateEditModal(button) {
        if (!editForm || !button) {
            return;
        }

        const savedDateAcquired = button.dataset.dateAcquired || '';
        editForm.action = button.dataset.updateUrl || editForm.action;
        document.getElementById('edit_equipment_id').value = button.dataset.equipmentId || '';

        setChoicesSelection(editEquipmentChoices, document.getElementById('edit_equipment'), button.dataset.equipment || '');
        document.getElementById('edit_equipment_no').value = button.dataset.equipmentNo || '';
        document.getElementById('edit_qty').value = button.dataset.qty || 0;
        document.getElementById('edit_unit').value = button.dataset.unit || '';
        document.getElementById('edit_rfl_control_no').value = button.dataset.rflControlNo || '';
        document.getElementById('edit_description').value = button.dataset.description || '';
        document.getElementById('edit_brand_model').value = button.dataset.brandModel || '';
        document.getElementById('edit_date_acquired').value = savedDateAcquired;
        document.getElementById('edit_unit_cost').value = button.dataset.unitCost || 0;
        document.getElementById('edit_total_cost').value = button.dataset.totalCost || 0;
        document.getElementById('edit_status_remarks').value = button.dataset.statusRemarks || '';
        document.getElementById('edit_received_quantity').value = button.dataset.receivedQuantity || 0;
        document.getElementById('edit_used_quantity').value = button.dataset.usedQuantity || 0;
        document.getElementById('edit_balance_quantity').value = button.dataset.balanceQuantity || 0;
        document.getElementById('edit_location').value = button.dataset.location || '';
        document.getElementById('edit_updates').value = safeParseJson(button.dataset.updates, '');

        const personIds = safeParseJson(button.dataset.personInCharge, []);
        setChoicesSelection(editPersonInChargeChoices, document.getElementById('edit_person_in_charge'), personIds);

        document.getElementById('edit_equipment').dispatchEvent(new Event('change', { bubbles: true }));
        document.getElementById('edit_date_acquired').value = savedDateAcquired;
        document.getElementById('edit_qty').dispatchEvent(new Event('input', { bubbles: true }));
        document.getElementById('edit_received_quantity').dispatchEvent(new Event('input', { bubbles: true }));
        document.getElementById('edit_used_quantity').dispatchEvent(new Event('input', { bubbles: true }));
    }

    function populateEditModalFromRow(row) {
        if (!row) {
            return;
        }

        populateEditModal({
            dataset: row.dataset,
        });
    }

    function showRowActions(row) {
        if (!rowActionsOverlay || !rowActionsPanel || !row) {
            return;
        }

        activeEquipmentRow = row;
        clearTimeout(hideRowActionsTimer);

        const shellRect = tableShell.getBoundingClientRect();
        const rowRect = row.getBoundingClientRect();

        rowActionsOverlay.setAttribute('aria-hidden', 'false');
        rowActionsPanel.classList.add('is-visible');
        rowActionsPanel.style.top = `${rowRect.top - shellRect.top + tableShell.scrollTop + (row.offsetHeight / 2)}px`;

        window.requestAnimationFrame(function() {
            const panelWidth = rowActionsPanel.offsetWidth;
            rowActionsPanel.style.left = `${tableShell.scrollLeft + tableShell.clientWidth - panelWidth - 12}px`;
        });

        rowActionsDeleteForm.action = row.dataset.deleteUrl || rowActionsDeleteForm.action;
        rowActionsEditButton.onclick = function() {
            populateEditModalFromRow(row);
            bootstrap.Modal.getOrCreateInstance(editModalElement).show();
        };
    }

    function hideRowActions() {
        if (!rowActionsOverlay || !rowActionsPanel) {
            return;
        }

        activeEquipmentRow = null;
        rowActionsPanel.classList.remove('is-visible');
        rowActionsOverlay.setAttribute('aria-hidden', 'true');
    }

    rowActionsDeleteForm?.addEventListener('submit', function(event) {
        event.preventDefault();

        if (typeof Swal === 'undefined') {
            rowActionsDeleteForm.submit();
            return;
        }

        Swal.fire({
            icon: 'warning',
            title: 'Delete this record?',
            text: 'This action cannot be undone.',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            buttonsStyling: false,
            customClass: {
                popup: 'equipment-swal',
                confirmButton: 'btn btn-danger px-4 mx-1',
                cancelButton: 'btn btn-outline-secondary px-4 mx-1'
            }
        }).then(function(result) {
            if (result.isConfirmed) {
                rowActionsDeleteForm.submit();
            }
        });
    });

    document.querySelectorAll('.equipment-row').forEach(function(row) {
        row.addEventListener('mouseenter', function() {
            showRowActions(row);
        });

        row.addEventListener('mousemove', function() {
            if (activeEquipmentRow === row) {
                showRowActions(row);
            }
        });

        row.addEventListener('mouseleave', function() {
            clearTimeout(hideRowActionsTimer);
            hideRowActionsTimer = setTimeout(function() {
                if (!rowActionsPanel?.matches(':hover')) {
                    hideRowActions();
                }
            }, 90);
        });

        row.addEventListener('focusin', function() {
            showRowActions(row);
        });
    });

    rowActionsPanel?.addEventListener('mouseenter', function() {
        clearTimeout(hideRowActionsTimer);
    });

    rowActionsPanel?.addEventListener('mouseleave', function() {
        hideRowActionsTimer = setTimeout(function() {
            if (!activeEquipmentRow) {
                hideRowActions();
            }
        }, 90);
    });

    tableShell?.addEventListener('scroll', function() {
        if (activeEquipmentRow) {
            showRowActions(activeEquipmentRow);
        }
    });

    window.addEventListener('resize', function() {
        if (activeEquipmentRow) {
            showRowActions(activeEquipmentRow);
        }
    });

    wireFormValidation(addForm, addModalElement, addSaveButton, addSaveLabel, addSaveSpinner, ['qty', 'received_quantity', 'used_quantity', 'balance_quantity']);
    wireFormValidation(editForm, editModalElement, editSaveButton, editSaveLabel, editSaveSpinner, ['qty', 'received_quantity', 'used_quantity', 'balance_quantity']);

    if (addForm && document.getElementById('equipment')?.value) {
        document.getElementById('equipment').dispatchEvent(new Event('change', { bubbles: true }));
    }

    if (editForm && document.getElementById('edit_equipment')?.value) {
        document.getElementById('edit_equipment').dispatchEvent(new Event('change', { bubbles: true }));
    }

    if (addForm && addForm.dataset.hasErrors === '1' && errorModalType !== 'edit' && addModalElement) {
        const modal = bootstrap.Modal.getOrCreateInstance(addModalElement);
        modal.show();
    }

    if (editForm && editForm.dataset.hasErrors === '1' && errorModalType === 'edit' && editModalElement) {
        const modal = bootstrap.Modal.getOrCreateInstance(editModalElement);
        modal.show();
    }

    const successMessage = pageRoot?.dataset.successMessage || '';
    
    function showSuccessAlertWhenReady() {
        if (!successMessage) return;
        if (typeof Swal !== 'undefined') {
            showSweetAlert('success', 'Success', successMessage);
        } else {
            setTimeout(showSuccessAlertWhenReady, 100);
        }
    }
    
    showSuccessAlertWhenReady();

    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
})();
</script>

@endsection