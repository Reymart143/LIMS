@extends('layouts.app')

@section('content')
@php
    $users = $users ?? collect();

    $savedRows = collect($sterilityChecks ?? [])->values();

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
    .sc-screen {
        width: 100%;
        overflow-x: auto;
        overflow-y: visible;
        background: #f5f6fa;
        padding: 18px 0 50px;
    }

    .sc-wrap {
        width: 980px;
        min-width: 980px;
        margin: 0 auto;
    }

    .sc-page {
        width: 980px;
        min-width: 980px;
        background: #fff;
        color: #000;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 13px;
        padding: 22px;
        box-sizing: border-box;
    }

    .sc-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .sc-table td,
    .sc-table th {
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
        margin-top: 42px;
    }

    .logbook-table th {
        text-align: center;
        font-weight: normal;
        height: 48px;
        font-size: 12px;
        line-height: 1.1;
    }

    .logbook-table td {
        height: 35px;
        padding: 0;
    }

    .sc-input {
        width: 100%;
        height: 34px;
        min-height: 34px;
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

    .sc-date {
        width: 100%;
        height: 34px;
        min-height: 34px;
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

    .sc-select {
        width: 100%;
        height: 34px;
        min-height: 34px;
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

    .footer-table {
        margin-top: 30px;
    }

    .footer-table td {
        height: 70px;
        vertical-align: top;
        font-size: 12px;
        padding: 8px 10px;
    }

    .footer-name {
        margin-top: 22px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .button-area {
        width: 980px;
        min-width: 980px;
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
        width: 980px;
        min-width: 980px;
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

<form action="{{ route('sterility_check.store') }}" method="POST">
    @csrf

    <div class="sc-screen">
        <div class="sc-wrap">
            <div class="sc-page">

                {{-- HEADER --}}
                <table class="sc-table header-table">
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
                <table class="sc-table doc-table">
                    <tr>
                        <td style="width:22%;">
                            Document Type<br>
                            <b>Laboratory Form</b>
                        </td>

                        <td style="width:18%;">
                            Revision No:<br>
                            <b>0</b>
                        </td>

                        <td style="width:30%;">
                            Date Adopted:<br>
                            <b>13 August 2019</b>
                        </td>

                        <td style="width:18%;">
                            Page No:<br>
                            <b>2</b>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Document Code:<br>
                            <b>LF W01-MIC-05</b>
                        </td>

                        <td colspan="3" class="center bold">
                            STERILITY CHECK
                        </td>
                    </tr>
                </table>

                {{-- TABLE --}}
                <table class="sc-table logbook-table" id="sterilityTable">
                    <colgroup>
                        <col style="width:18%;">
                        <col style="width:13%;">
                        <col style="width:25%;">
                        <col style="width:12%;">
                        <col style="width:12%;">
                        <col style="width:14%;">
                        <col style="width:6%;">
                    </colgroup>

                    <thead>
                        <tr>
                            <th rowspan="2">Date</th>
                            <th rowspan="2">Batch No.</th>
                            <th rowspan="2">Temperature, Time and<br>Pressure of Sterilization</th>
                            <th colspan="2">Sterility Check</th>
                            <th rowspan="2">Checked by</th>
                            <th rowspan="2">Action</th>
                        </tr>

                        <tr>
                            <th>Autoclave<br>Tape</th>
                            <th>Biological<br>Indicator</th>
                        </tr>
                    </thead>

                    <tbody id="sterilityBody">
                        @foreach($rows as $rowIndex => $row)
                            <tr>
                                <td>
                                    <input type="hidden" name="row_id[]" value="{{ $row->id ?? '' }}">

                                    <input type="date"
                                           name="date[]"
                                           class="sc-date"
                                           value="{{ old('date.' . $rowIndex, $row->date ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                           name="batch_no[]"
                                           class="sc-input"
                                           value="{{ old('batch_no.' . $rowIndex, $row->batch_no ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                           name="temperature_time_pressure[]"
                                           class="sc-input"
                                           value="{{ old('temperature_time_pressure.' . $rowIndex, $row->temperature_time_pressure ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                           name="autoclave_tape[]"
                                           class="sc-input"
                                           value="{{ old('autoclave_tape.' . $rowIndex, $row->autoclave_tape ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                           name="biological_indicator[]"
                                           class="sc-input"
                                           value="{{ old('biological_indicator.' . $rowIndex, $row->biological_indicator ?? '') }}">
                                </td>

                                <td>
                                    <select name="checked_by[]" class="sc-select">
                                        <option value="">Select</option>

                                        @foreach($users as $user)
                                            @php
                                                $fullName = trim(($user->f_name ?? '') . ' ' . ($user->m_name ?? '') . ' ' . ($user->l_name ?? ''));
                                                $selectedCheckedBy = old('checked_by.' . $rowIndex, $row->checked_by ?? '');
                                            @endphp

                                            <option value="{{ $fullName }}" {{ $selectedCheckedBy == $fullName ? 'selected' : '' }}>
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

                {{-- FOOTER --}}
                <table class="sc-table footer-table">
                    <tr>
                        <td style="width:33.33%;">
                            Prepared by:
                            <div class="footer-name">CHARISSE ZIANNE N. LIBRES</div>
                            <div>Laboratory Analyst-Microbiology</div>
                        </td>

                        <td style="width:33.33%;">
                            Reviewed by:
                            <div class="footer-name">MA. MAURICE A. BANQUILING</div>
                            <div>Quality Assurance Manager</div>
                        </td>

                        <td style="width:33.33%;">
                            Approved by:
                            <div class="footer-name">EUGENE GAY B. JAMORA</div>
                            <div>Laboratory Manager</div>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

    <div class="button-area">
        <button type="button" class="btn-add-row" id="addRowBtn">+ Add Row</button>
        <button type="submit" class="btn-save">Save / Update Sterility Check</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tbody = document.getElementById('sterilityBody');
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