@extends('layouts.app')

@section('content')
@php
    $users = $users ?? collect();

    $savedRows = collect($logbooks ?? [])->values();

    /*
        Behavior:
        - If walay saved data: show 1 blank row.
        - If naa saved data: show all saved rows + 1 blank new row sa pinaka-ubos.
    */
    if ($savedRows->count() === 0) {
        $rows = collect([null]);
    } else {
        $rows = $savedRows;
        $rows->push(null);
    }
@endphp

<style>
    .rml-screen {
        width: 100%;
        overflow-x: auto;
        overflow-y: visible;
        background: #f5f6fa;
        padding: 18px 0 50px;
    }

    .rml-wrap {
        width: 1320px;
        min-width: 1320px;
        margin: 0 auto;
    }

    .rml-page {
        width: 1320px;
        min-width: 1320px;
        background: #fff;
        color: #000;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 13px;
        padding: 22px;
        box-sizing: border-box;
    }

    .rml-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .rml-table td,
    .rml-table th {
        border: 1px solid #000;
        vertical-align: middle;
        color: #000;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 12px;
        line-height: 1.15;
        padding: 4px 5px;
        box-sizing: border-box;
        overflow: hidden;
    }

    .center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    .header-table td {
        height: 76px;
    }

    .logo-cell {
        width: 150px;
        text-align: center;
    }

    .logo-cell img {
        width: 78px;
        height: auto;
    }

    .header-text {
        text-align: left;
        font-size: 13px;
        line-height: 1.08;
        padding-left: 10px !important;
    }

    .doc-table td {
        height: 33px;
        font-size: 12px;
    }

    .logbook-table {
        margin-top: 45px;
    }

    .logbook-table th {
        text-align: center;
        font-weight: normal;
        height: 46px;
        font-size: 12px;
        line-height: 1.1;
    }

    .logbook-table td {
        height: 34px;
        padding: 0;
    }

    .rml-input {
        width: 100%;
        height: 33px;
        min-height: 33px;
        border: none;
        outline: none;
        background: transparent;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 12px;
        text-align: center;
        padding: 3px 4px;
        box-sizing: border-box;
        color: #000;
    }

    .rml-date {
        width: 100%;
        height: 33px;
        min-height: 33px;
        border: none;
        outline: none;
        background: #fff;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 11.5px;
        text-align: center;
        padding: 3px 4px;
        box-sizing: border-box;
        color: #000;
        cursor: pointer;
    }

    .rml-select {
        width: 100%;
        height: 33px;
        min-height: 33px;
        border: none;
        outline: none;
        background: transparent;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 11.5px;
        text-align: center;
        padding: 3px 4px;
        box-sizing: border-box;
        color: #000;
    }

    .action-cell {
        text-align: center;
        padding: 2px !important;
    }

    .btn-delete-row {
        background: #dc3545;
        color: #fff;
        border: none;
        border-radius: 3px;
        padding: 5px 8px;
        font-size: 11px;
        cursor: pointer;
    }

    .button-area {
        width: 1320px;
        min-width: 1320px;
        margin: 14px auto 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-add-row {
        background: #0d6efd;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 10px 18px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-save {
        background: #198754;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 10px 24px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
    }

    .alert-success-custom,
    .alert-error-custom {
        width: 1320px;
        min-width: 1320px;
        margin: 14px auto;
        padding: 12px;
        font-size: 14px;
    }

    .alert-success-custom {
        background: #d1e7dd;
        border: 1px solid #badbcc;
        color: #0f5132;
    }

    .alert-error-custom {
        background: #f8d7da;
        border: 1px solid #f5c2c7;
        color: #842029;
    }
</style>

{{-- <div class="card-header d-flex justify-content-between">
    <a class="btn btn-sm btn-secondary"
        style="margin-left:8mm"
        href="/reagent-media-logbook"
        title="return">
        Back
    </a>
</div> --}}


<form action="{{ route('reagent_media_logbook.store') }}" method="POST">
    @csrf

    <div class="rml-screen">
        <div class="rml-wrap">
            <div class="rml-page">

                {{-- HEADER --}}
                <table class="rml-table header-table">
                    <tr>
                        <td class="logo-cell">
                            <img src="{{ asset('assets/images/bfarlogo.png') }}" alt="BFAR Logo" onerror="this.style.display='none'">
                        </td>

                        <td class="header-text">
                            <div>Republic of the Philippines</div>
                            <div>Department of Agriculture</div>
                            <div class="bold">BUREAU OF FISHERIES AND AQUATIC RESOURCES</div>
                            <div class="bold">REGIONAL FISHERIES LABORATORY XII</div>
                            <div>J. Catolico St., Lagao, General Santos City</div>
                        </td>
                    </tr>
                </table>

                {{-- DOCUMENT INFO --}}
                <table class="rml-table doc-table">
                    <tr>
                        <td style="width:15%;">
                            Document Type<br>
                            <b>Laboratory Form</b>
                        </td>

                        <td style="width:17%;">
                            Revision No:<br>
                            <b>0</b>
                        </td>

                        <td style="width:36%;">
                            Date Adopted:<br>
                            <b>13 August 2019</b>
                        </td>

                        <td style="width:17%;">
                            Page No:
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Document Code:<br>
                            <b>LF-W01-MIC-01</b>
                        </td>

                        <td colspan="3" class="center bold">
                            REAGENT AND MEDIA PREPARATION LOGBOOK
                        </td>
                    </tr>
                </table>

                {{-- LOGBOOK TABLE --}}
                <table class="rml-table logbook-table" id="logbookTable">
                    <colgroup>
                        <col style="width:7%;">
                        <col style="width:8%;">
                        <col style="width:8%;">
                        <col style="width:11%;">
                        <col style="width:8%;">
                        <col style="width:8%;">
                        <col style="width:8%;">
                        <col style="width:9%;">
                        <col style="width:9%;">
                        <col style="width:7%;">
                        <col style="width:10%;">
                        <col style="width:8%;">
                        <col style="width:5%;">
                    </colgroup>

                    <thead>
                        <tr>
                            <th rowspan="2">Media<br>Batch<br>No.</th>
                            <th rowspan="2">Date<br>Prepared</th>
                            <th rowspan="2">Chemical /<br>Media</th>
                            <th rowspan="2">Manufacturer's<br>Batch /<br>Lot No.</th>
                            <th rowspan="2">Quantity<br>Used</th>
                            <th rowspan="2">Quantity<br>Prepared</th>
                            <th colspan="3">pH Check</th>
                            <th rowspan="2">Expiry</th>
                            <th rowspan="2">Physical<br>Appearance</th>
                            <th rowspan="2">Prepared by</th>
                            <th rowspan="2">Action</th>
                        </tr>

                        <tr>
                            <th>Required</th>
                            <th>Pre-Sterilizat<br>ion</th>
                            <th>Post<br>Sterilization</th>
                        </tr>
                    </thead>

                    <tbody id="logbookBody">
                        @foreach($rows as $rowIndex => $row)
                            <tr>
                                <td>
                                    <input type="hidden" name="row_id[]" value="{{ $row->id ?? '' }}">

                                    <input type="text"
                                           name="media_batch_no[]"
                                           class="rml-input"
                                           value="{{ old('media_batch_no.' . $rowIndex, $row->media_batch_no ?? '') }}">
                                </td>

                                <td>
                                    <input type="date"
                                           name="date_prepared[]"
                                           class="rml-date"
                                           value="{{ old('date_prepared.' . $rowIndex, $row->date_prepared ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                           name="chemical_media[]"
                                           class="rml-input"
                                           value="{{ old('chemical_media.' . $rowIndex, $row->chemical_media ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                           name="manufacturer_batch_lot_no[]"
                                           class="rml-input"
                                           value="{{ old('manufacturer_batch_lot_no.' . $rowIndex, $row->manufacturer_batch_lot_no ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                           name="quantity_used[]"
                                           class="rml-input"
                                           value="{{ old('quantity_used.' . $rowIndex, $row->quantity_used ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                           name="quantity_prepared[]"
                                           class="rml-input"
                                           value="{{ old('quantity_prepared.' . $rowIndex, $row->quantity_prepared ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                           name="ph_required[]"
                                           class="rml-input"
                                           value="{{ old('ph_required.' . $rowIndex, $row->ph_required ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                           name="ph_pre_sterilization[]"
                                           class="rml-input"
                                           value="{{ old('ph_pre_sterilization.' . $rowIndex, $row->ph_pre_sterilization ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                           name="ph_post_sterilization[]"
                                           class="rml-input"
                                           value="{{ old('ph_post_sterilization.' . $rowIndex, $row->ph_post_sterilization ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                           name="expiry[]"
                                           class="rml-input"
                                           value="{{ old('expiry.' . $rowIndex, $row->expiry ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                           name="physical_appearance[]"
                                           class="rml-input"
                                           value="{{ old('physical_appearance.' . $rowIndex, $row->physical_appearance ?? '') }}">
                                </td>

                                <td>
                                    <select name="prepared_by[]" class="rml-select">
                                        <option value="">Select</option>

                                        @foreach($users as $user)
                                            @php
                                                $fullName = trim(($user->f_name ?? '') . ' ' . ($user->m_name ?? '') . ' ' . ($user->l_name ?? ''));
                                                $selectedPreparedBy = old('prepared_by.' . $rowIndex, $row->prepared_by ?? '');
                                            @endphp

                                            <option value="{{ $fullName }}" {{ $selectedPreparedBy == $fullName ? 'selected' : '' }}>
                                                {{ $fullName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td class="action-cell">
                                    <button type="button" class="btn-delete-row">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="button-area">
        <button type="button" class="btn-add-row" id="addRowBtn">+ Add Row</button>
        <button type="submit" class="btn-save">Save / Update Logbook</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tbody = document.getElementById('logbookBody');
        const addRowBtn = document.getElementById('addRowBtn');

        addRowBtn.addEventListener('click', function () {
            const firstRow = tbody.querySelector('tr');
            const clone = firstRow.cloneNode(true);

            clone.querySelectorAll('input').forEach(function (input) {
                input.value = '';
            });

            clone.querySelectorAll('select').forEach(function (select) {
                select.selectedIndex = 0;
            });

            tbody.appendChild(clone);
        });

        tbody.addEventListener('click', function (event) {
            if (!event.target.classList.contains('btn-delete-row')) {
                return;
            }

            const rows = tbody.querySelectorAll('tr');
            const row = event.target.closest('tr');

            if (rows.length > 1) {
                row.remove();
                return;
            }

            row.querySelectorAll('input').forEach(function (input) {
                input.value = '';
            });

            row.querySelectorAll('select').forEach(function (select) {
                select.selectedIndex = 0;
            });
        });
    });
</script>
@endsection