@extends('layouts.app')

@section('content')

@php
    $labCodes = json_decode($rla->laboratory_code ?? '[]', true);

    if (!is_array($labCodes)) {
        $labCodes = [$rla->laboratory_code ?? ''];
    }

    $labCodes = array_values(array_filter($labCodes, function ($value) {
        return trim((string) $value) !== '';
    }));

    if (count($labCodes) === 0) {
        $labCodes = [''];
    }

    /*
        Default: 3 trials per laboratory code.
        Example:
        1 lab code = 3 rows
        2 lab codes = 6 rows
    */
    $trialsPerLabCode = 3;

    $savedLaboratoryCode = !empty($worksheet->laboratory_code) ? json_decode($worksheet->laboratory_code, true) ?? [] : [];
    $savedTrial = !empty($worksheet->trial) ? json_decode($worksheet->trial, true) ?? [] : [];
    $savedWtPan = !empty($worksheet->wt_pan) ? json_decode($worksheet->wt_pan, true) ?? [] : [];
    $savedWtSampleBeforeDrying = !empty($worksheet->wt_sample_before_drying) ? json_decode($worksheet->wt_sample_before_drying, true) ?? [] : [];
    $savedWtPanSampleAfterDrying = !empty($worksheet->wt_pan_sample_after_drying) ? json_decode($worksheet->wt_pan_sample_after_drying, true) ?? [] : [];
    $savedWtSampleAfterDrying = !empty($worksheet->wt_sample_after_drying) ? json_decode($worksheet->wt_sample_after_drying, true) ?? [] : [];
    $savedWtLostOnDrying = !empty($worksheet->wt_lost_on_drying) ? json_decode($worksheet->wt_lost_on_drying, true) ?? [] : [];
    $savedMoistureContent = !empty($worksheet->moisture_content) ? json_decode($worksheet->moisture_content, true) ?? [] : [];

    $savedAverage = !empty($worksheet->average) ? json_decode($worksheet->average, true) ?? [] : [];
    $savedRemarks = !empty($worksheet->remarks) ? json_decode($worksheet->remarks, true) ?? [] : [];
@endphp

<style>
    .content-inner {
        color: #000;
    }

    .card-body {
        background: #f5f5f5;
        padding-top: 25px;
        padding-bottom: 45px;
    }

    .form-sheet {
        width: 1100px;
        max-width: 100%;
        margin: 0 auto;
        background: #fff;
        padding: 0;
        overflow: visible;
    }

    .bordered {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        font-family: "Times New Roman", serif;
        background: #fff;
        border: 1px solid #555;
        margin-bottom: 0 !important;
    }

    .bordered td,
    .bordered th {
        border: 1px solid #555;
        padding: 5px 8px;
        vertical-align: middle;
        color: #000;
        font-size: 14px;
        line-height: 1.15;
    }

    .logo-cell {
        width: 110px;
        text-align: center;
        vertical-align: middle;
    }

    .logo-cell img {
        max-width: 95px;
        height: auto;
    }

    .header-title {
        font-family: "Times New Roman", serif;
        color: #000;
        font-size: 15px;
        line-height: 1.15;
    }

    .header-title .big {
        font-weight: bold;
        color: #000;
        font-size: 15px;
    }

    .section-title {
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
        color: #000;
        font-size: 15px;
    }

    .date-rla-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        font-family: "Times New Roman", serif;
        background: #fff;
        margin-top: 0;
    }

    .date-rla-table td {
        border: 1px solid #555;
        padding: 5px 8px;
        vertical-align: middle;
        color: #000;
        font-size: 14px;
        line-height: 1.15;
        height: 34px;
    }

    .date-rla-table input {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        color: #000;
    }

    .method-area {
        width: 90%;
        margin: 22px auto 18px;
        font-family: "Times New Roman", serif;
        color: #000;
        font-size: 15px;
    }

    .method-area input[type="text"] {
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        font-size: 15px;
        color: #000;
    }

    .small-input {
        width: 80px;
    }

    .method-line {
        margin-bottom: 8px;
    }

    .moisture-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        font-family: "Times New Roman", serif;
        background: #fff;
        color: #000;
        margin-top: 18px;
    }

    .moisture-table th,
    .moisture-table td {
        border: 1px solid #000;
        padding: 4px 5px;
        font-size: 14px;
        line-height: 1.1;
        text-align: center;
        vertical-align: middle;
        font-weight: normal;
        color: #000;
    }

    .moisture-table th {
        font-weight: bold;
    }

    .moisture-table input,
    .moisture-table textarea {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;
        text-align: center;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        padding: 0;
        margin: 0;
        color: #000;
        resize: none;
    }

    .average-input {
        font-weight: bold;
    }

    .row-space td {
        height: 28px;
    }

    .lab-code-display {
        word-break: break-word;
        text-align: center;
    }

    .signature-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        margin-top: 80px;
        font-family: "Times New Roman", serif;
    }

    .signature-table td {
        border: none;
        text-align: center;
        font-size: 13px;
        font-weight: bold;
        color: #000;
    }

    .signature-select {
        width: 180px;
        margin-top: 15px;
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        background: transparent;
        text-align: center;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        font-weight: bold;
        color: #000;
        padding: 3px 2px;
    }

    .signature-select option {
        font-family: Arial, sans-serif;
        font-size: 14px;
        color: #000;
    }

    .no-print {
        margin-bottom: 10px;
    }
</style>

<div class="card-header d-flex justify-content-between">
    <a class="btn btn-sm btn-secondary"
        style="margin-left:8mm"
        href="/analyst_worksheet"
        title="return">
        Back
    </a>
</div>

<div class="card-body">
    <div class="form-sheet">

        {{-- HEADER --}}
        <table class="bordered">
            <colgroup>
                <col style="width:110px;">
                <col>
            </colgroup>

            <tr>
                <td class="logo-cell">
                    <img src="{{ asset('assets/images/bfarlogo.png') }}"
                        alt="Logo"
                        onerror="this.style.display='none'">
                </td>

                <td class="header-title">
                    <div>Republic of the Philippines</div>
                    <div>Department of Agriculture</div>
                    <div class="big">BUREAU OF FISHERIES AND AQUATIC RESOURCES</div>
                    <div class="big">REGIONAL FISHERIES LABORATORY XII</div>
                    <div>J. Catolico St., Lagao, General Santos City</div>
                </td>
            </tr>
        </table>

        {{-- DOCUMENT DETAILS --}}
        <table class="bordered">
            <colgroup>
                <col style="width:23%;">
                <col style="width:26%;">
                <col style="width:28%;">
                <col style="width:23%;">
            </colgroup>

            <tr>
                <td>
                    <div>Document Type</div>
                    <div><strong>Laboratory Form</strong></div>
                </td>

                <td>
                    <div>Revision No:</div>
                    <div>0</div>
                </td>

                <td>
                    <div>Date Adopted:</div>
                    <div>13 Aug 2019</div>
                </td>

                <td>
                    <div>Page No:</div>
                    <div></div>
                </td>
            </tr>

            <tr>
                <td>
                    <div>Document Code:</div>
                    <div><strong>LF W01-CHE-02</strong></div>
                </td>

                <td colspan="3" class="section-title">
                    Analyst Spreadsheet for Moisture Content Analysis
                </td>
            </tr>
        </table>

        <form method="POST" action="{{ route('MoistureWorksheet.store', $rla->id) }}">
            @csrf

            {{-- HIDDEN VALUES --}}
            <input type="hidden"
                id="lf_06_02_id"
                name="lf_06_02_id"
                value="{{ $rla->id ?? '' }}">

            <input type="hidden"
                id="user_id"
                name="user_id"
                value="{{ $rla->user_id ?? '' }}">

            <input type="hidden"
                id="hidden_rla_no"
                name="rla_no"
                value="{{ $worksheet->rla_no ?? $rla->RLA_no ?? '' }}">

            {{-- DATE / TIME / RLA --}}
            <table class="date-rla-table">
                <colgroup>
                    <col style="width:19%;">
                    <col style="width:17%;">
                    <col style="width:18%;">
                    <col style="width:17%;">
                    <col style="width:12%;">
                    <col style="width:17%;">
                </colgroup>

                <tr>
                    <td>
                        <div>Date /Time</div>
                        <div>started:</div>
                    </td>

                    <td>
                        <input type="datetime-local"
                            id="date_time_started"
                            name="date_time_started"
                            value="{{ old('date_time_started', !empty($worksheet->date_time_started) ? \Carbon\Carbon::parse($worksheet->date_time_started)->format('Y-m-d\TH:i') : '') }}">
                    </td>

                    <td>
                        <div>Date /Time</div>
                        <div>finished:</div>
                    </td>

                    <td>
                        <input type="datetime-local"
                            id="date_time_finished"
                            name="date_time_finished"
                            value="{{ old('date_time_finished', !empty($worksheet->date_time_finished) ? \Carbon\Carbon::parse($worksheet->date_time_finished)->format('Y-m-d\TH:i') : '') }}">
                    </td>

                    <td>
                        RLA No.:
                    </td>

                    <td>
                        <input type="text"
                            id="RLA_no"
                            name="RLA_no"
                            value="{{ old('RLA_no', $worksheet->rla_no ?? $rla->RLA_no ?? '') }}"
                            readonly>
                    </td>
                </tr>
            </table>

            {{-- METHOD AREA --}}
            <div class="method-area">
                <div class="method-line">
                    <strong>Method:</strong>
                    <input type="text"
                        id="method"
                        name="method"
                        value="{{ old('method', $worksheet->method ?? 'Oven Dried') }}"
                        style="width:180px;">
                </div>

                <div class="method-line">
                    <strong>Reference:</strong>
                    <input type="text"
                        id="reference"
                        name="reference"
                        value="{{ old('reference', $worksheet->reference ?? 'AOAC') }}"
                        style="width:180px;">
                </div>

                <br>

                <div class="method-line">
                    <strong>Oven Temperature:</strong>
                    <input type="text"
                        id="oven_temperature"
                        name="oven_temperature"
                        value="{{ old('oven_temperature', $worksheet->oven_temperature ?? '105°C') }}"
                        class="small-input">

                    <label>
                        <input type="checkbox"
                            id="is_actual_temperature"
                            name="is_actual_temperature"
                            value="1"
                            {{ old('is_actual_temperature', $worksheet->is_actual_temperature ?? false) ? 'checked' : '' }}>
                        Checked if temperature reading is actual temperature.
                    </label>
                </div>

                <div class="method-line">
                    <strong>Drying Time:</strong>

                    <label>
                        <input type="radio"
                            id="drying_time_1_hour"
                            name="drying_time"
                            value="1 hour"
                            {{ old('drying_time', $worksheet->drying_time ?? '') == '1 hour' ? 'checked' : '' }}>
                        1 hour
                    </label>

                    <label style="margin-left:18px;">
                        <input type="radio"
                            id="drying_time_16_hours"
                            name="drying_time"
                            value="16 hours"
                            {{ old('drying_time', $worksheet->drying_time ?? '') == '16 hours' ? 'checked' : '' }}>
                        16 hours
                    </label>
                </div>
            </div>

            {{-- MAIN MOISTURE TABLE --}}
            <table class="moisture-table">
                <colgroup>
                    <col style="width:13%;">
                    <col style="width:8%;">
                    <col style="width:9%;">
                    <col style="width:10%;">
                    <col style="width:13%;">
                    <col style="width:10%;">
                    <col style="width:9%;">
                    <col style="width:10%;">
                    <col style="width:10%;">
                    <col style="width:8%;">
                </colgroup>

                <thead>
                    <tr>
                        <th>Laboratory<br>Code</th>
                        <th>Trial</th>
                        <th>Wt. of<br>Pan</th>
                        <th>Wt. Of sample<br>before drying</th>
                        <th>Wt of pan and<br>sample after<br>drying</th>
                        <th>Wt of sample<br>after drying</th>
                        <th>Wt lost on<br>drying</th>
                        <th>Moisture<br>content</th>
                        <th>Average</th>
                        <th>Remarks</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($labCodes as $labIndex => $labCode)
                        @for($trialIndex = 0; $trialIndex < $trialsPerLabCode; $trialIndex++)
                            @php
                                $rowIndex = ($labIndex * $trialsPerLabCode) + $trialIndex;
                                $currentLabCode = $savedLaboratoryCode[$labIndex] ?? $labCode;
                            @endphp

                            <tr class="row-space">
                                @if($trialIndex == 0)
                                    <td rowspan="{{ $trialsPerLabCode }}" class="lab-code-display">
                                        {{ $currentLabCode }}

                                        <input type="hidden"
                                            id="laboratory_code_{{ $labIndex }}"
                                            name="laboratory_code[]"
                                            value="{{ $currentLabCode }}">
                                    </td>
                                @endif

                                <td>
                                    <input type="text"
                                        id="trial_{{ $rowIndex }}"
                                        name="trial[]"
                                        value="{{ old('trial.' . $rowIndex, $savedTrial[$rowIndex] ?? ($trialIndex + 1)) }}">
                                </td>

                                <td>
                                    <input type="text"
                                        id="wt_pan_{{ $rowIndex }}"
                                        name="wt_pan[]"
                                        value="{{ old('wt_pan.' . $rowIndex, $savedWtPan[$rowIndex] ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                        id="wt_sample_before_drying_{{ $rowIndex }}"
                                        name="wt_sample_before_drying[]"
                                        value="{{ old('wt_sample_before_drying.' . $rowIndex, $savedWtSampleBeforeDrying[$rowIndex] ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                        id="wt_pan_sample_after_drying_{{ $rowIndex }}"
                                        name="wt_pan_sample_after_drying[]"
                                        value="{{ old('wt_pan_sample_after_drying.' . $rowIndex, $savedWtPanSampleAfterDrying[$rowIndex] ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                        id="wt_sample_after_drying_{{ $rowIndex }}"
                                        name="wt_sample_after_drying[]"
                                        value="{{ old('wt_sample_after_drying.' . $rowIndex, $savedWtSampleAfterDrying[$rowIndex] ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                        id="wt_lost_on_drying_{{ $rowIndex }}"
                                        name="wt_lost_on_drying[]"
                                        value="{{ old('wt_lost_on_drying.' . $rowIndex, $savedWtLostOnDrying[$rowIndex] ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                        id="moisture_content_{{ $rowIndex }}"
                                        name="moisture_content[]"
                                        class="moisture-content-input"
                                        data-lab-index="{{ $labIndex }}"
                                        value="{{ old('moisture_content.' . $rowIndex, $savedMoistureContent[$rowIndex] ?? '') }}">
                                </td>

                                @if($trialIndex == 0)
                                    <td rowspan="{{ $trialsPerLabCode }}">
                                        <input type="text"
                                            id="average_{{ $labIndex }}"
                                            name="average[]"
                                            class="average-input"
                                            value="{{ old('average.' . $labIndex, $savedAverage[$labIndex] ?? '') }}"
                                            readonly>
                                    </td>

                                    <td rowspan="{{ $trialsPerLabCode }}">
                                        <textarea id="remarks_{{ $labIndex }}"
                                            name="remarks[]"
                                            rows="4">{{ old('remarks.' . $labIndex, $savedRemarks[$labIndex] ?? '') }}</textarea>
                                    </td>
                                @endif
                            </tr>
                        @endfor
                    @endforeach
                </tbody>
            </table>

            {{-- SIGNATURE --}}
            <table class="signature-table">
                <tr>
                    <td>
                        Analyzed by:

                        <select id="analyzed_by_1"
                            name="analyzed_by_1"
                            class="signature-select">
                            <option value="">Select User</option>

                            @foreach($users as $user)
                                @php
                                    $fullName = trim(
                                        ($user->f_name ?? '') . ' ' .
                                        ($user->m_name ?? '') . ' ' .
                                        ($user->l_name ?? '')
                                    );
                                @endphp

                                <option value="{{ $fullName }}"
                                    {{ old('analyzed_by_1', $worksheet->analyzed_by_1 ?? '') == $fullName ? 'selected' : '' }}>
                                    {{ $fullName }}
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        Analyzed by:

                        <select id="analyzed_by_2"
                            name="analyzed_by_2"
                            class="signature-select">
                            <option value="">Select User</option>

                            @foreach($users as $user)
                                @php
                                    $fullName = trim(
                                        ($user->f_name ?? '') . ' ' .
                                        ($user->m_name ?? '') . ' ' .
                                        ($user->l_name ?? '')
                                    );
                                @endphp

                                <option value="{{ $fullName }}"
                                    {{ old('analyzed_by_2', $worksheet->analyzed_by_2 ?? '') == $fullName ? 'selected' : '' }}>
                                    {{ $fullName }}
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        Checked by:

                        <select id="checked_by"
                            name="checked_by"
                            class="signature-select">
                            <option value="">Select User</option>

                            @foreach($users as $user)
                                @php
                                    $fullName = trim(
                                        ($user->f_name ?? '') . ' ' .
                                        ($user->m_name ?? '') . ' ' .
                                        ($user->l_name ?? '')
                                    );
                                @endphp

                                <option value="{{ $fullName }}"
                                    {{ old('checked_by', $worksheet->checked_by ?? '') == $fullName ? 'selected' : '' }}>
                                    {{ $fullName }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>

            <div class="text-end mt-3 no-print">
                <button type="submit"
                    id="submit_moisture_worksheet"
                    name="submit_moisture_worksheet"
                    class="btn btn-success">
                    {{ isset($worksheet) ? 'Update' : 'Save' }}
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function truncateToTwoDecimals(value) {
            return Math.trunc(value * 100) / 100;
        }

        function calculateAverage(labIndex) {
            const inputs = document.querySelectorAll(
                '.moisture-content-input[data-lab-index="' + labIndex + '"]'
            );

            let total = 0;
            let count = 0;

            inputs.forEach(function (input) {
                const value = parseFloat(input.value);

                if (!isNaN(value)) {
                    total += value;
                    count++;
                }
            });

            const averageInput = document.getElementById('average_' + labIndex);

            if (!averageInput) {
                return;
            }

            if (count > 0) {
                const average = total / count;
                const truncatedAverage = truncateToTwoDecimals(average);

                averageInput.value = truncatedAverage.toFixed(2);
            } else {
                averageInput.value = '';
            }
        }

        document.querySelectorAll('.moisture-content-input').forEach(function (input) {
            input.addEventListener('input', function () {
                const labIndex = this.getAttribute('data-lab-index');
                calculateAverage(labIndex);
            });
        });

        document.querySelectorAll('.average-input').forEach(function (input) {
            const labIndex = input.id.replace('average_', '');
            calculateAverage(labIndex);
        });
    });
</script>

@endsection