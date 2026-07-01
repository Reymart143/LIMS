@extends('layouts.app')

@section('content')
@php
    function wbJson($value) {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    function wbFlatten($array) {
        $result = [];

        foreach ($array as $item) {
            if (is_array($item)) {
                foreach ($item as $subItem) {
                    if ($subItem !== null && $subItem !== '') {
                        $result[] = $subItem;
                    }
                }
            } else {
                if ($item !== null && $item !== '') {
                    $result[] = $item;
                }
            }
        }

        return $result;
    }

    function wbVal($array, $index, $default = '') {
        return isset($array[$index]) && $array[$index] !== null && $array[$index] !== ''
            ? $array[$index]
            : $default;
    }

    function wbDateValue($value) {
        if (empty($value)) {
            return '';
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return '';
        }
    }

    $labCodes = wbJson($rla->laboratory_code ?? null);
    $firstLabCode = $labCodes[0] ?? '';

    $sampleDescriptions = wbJson($rla->sample_description ?? null);
    $firstSampleDescription = $sampleDescriptions[0] ?? '';

    $analysisRequested = wbFlatten(wbJson($rla->analysis_requested ?? null));

    $testName = $worksheet ? wbJson($worksheet->test_name ?? null) : [];

    $d100r1 = $worksheet ? wbJson($worksheet->dilution_100_r1 ?? null) : [];
    $d100r2 = $worksheet ? wbJson($worksheet->dilution_100_r2 ?? null) : [];

    $d101r1 = $worksheet ? wbJson($worksheet->dilution_101_r1 ?? null) : [];
    $d101r2 = $worksheet ? wbJson($worksheet->dilution_101_r2 ?? null) : [];

    $d102r1 = $worksheet ? wbJson($worksheet->dilution_102_r1 ?? null) : [];
    $d102r2 = $worksheet ? wbJson($worksheet->dilution_102_r2 ?? null) : [];

    $d103r1 = $worksheet ? wbJson($worksheet->dilution_103_r1 ?? null) : [];
    $d103r2 = $worksheet ? wbJson($worksheet->dilution_103_r2 ?? null) : [];

    $results = $worksheet ? wbJson($worksheet->results ?? null) : [];

    $fallbackTests = [
        'Total Vibrio Colonies',
        'Total Luminous Bacteria',
        '%Yellow Colonies',
        '%Green Colonies',
    ];

    $displayTests = count($analysisRequested) > 0
        ? $analysisRequested
        : $fallbackTests;

    $rowCount = max(count($displayTests), count($testName));

    $dateStarted = old('date_started', wbDateValue($worksheet->date_started ?? ''));
    $dateFinished = old('date_finished', wbDateValue($worksheet->date_finished ?? ''));
@endphp

<style>
    .wb-screen {
        width: 100%;
        overflow-x: auto;
        overflow-y: visible;
        padding: 20px 0 50px;
        background: #f5f6fa;
    }

    .wb-scale-wrap {
        width: 1150px;
        min-width: 1150px;
        margin: 0 auto;
    }

    .wb-page {
        width: 1150px;
        min-width: 1150px;
        min-height: 900px;
        background: #fff;
        color: #000;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 13px;
        padding: 24px;
        box-sizing: border-box;
    }

    .wb-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .wb-table td,
    .wb-table th {
        border: 1px solid #000;
        padding: 4px 5px;
        vertical-align: middle;
        color: #000;
        line-height: 1.15;
        font-size: 12px;
        box-sizing: border-box;
        font-family: Cambria, "Times New Roman", serif;
    }

    .center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    .header-table td {
        height: 78px;
    }

    .logo-cell {
        width: 145px;
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
        padding-left: 10px;
    }

    .doc-table td {
        height: 30px;
        font-size: 11px;
    }

    .sample-row {
        margin-top: 45px;
        margin-left: 80px;
        margin-bottom: 35px;
        font-size: 16px;
    }

    .sample-input-line {
        width: 300px;
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        background: transparent;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 14px;
        text-align: center;
    }

    .input-cell {
        width: 100%;
        height: 100%;
        min-height: 32px;
        border: none;
        outline: none;
        background: transparent;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 12px;
        text-align: center;
        padding: 2px;
        color: #000;
        box-sizing: border-box;
        pointer-events: auto;
    }

    .input-cell-left {
        text-align: left;
        padding-left: 6px;
    }

    .date-input {
        width: 145px;
        height: 28px;
        min-height: 28px;
        border: 1px solid transparent;
        outline: none;
        background: #fff;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 12px;
        text-align: center;
        color: #000;
        box-sizing: border-box;
        position: relative;
        z-index: 10;
        cursor: pointer;
        pointer-events: auto;
    }

    .date-input::-webkit-calendar-picker-indicator {
        opacity: 1;
        display: block;
        cursor: pointer;
        pointer-events: auto;
    }

    .main-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .main-table th,
    .main-table td {
        border: 1px solid #000;
        height: 36px;
        font-size: 12px;
        padding: 0;
        vertical-align: middle;
        text-align: center;
        overflow: visible;
        box-sizing: border-box;
        font-family: Cambria, "Times New Roman", serif;
        position: relative;
    }

    .main-table .info-cell {
        text-align: left;
        font-size: 12px;
        white-space: nowrap;
        overflow: visible !important;
        position: relative;
        z-index: 5;
        padding: 4px 5px;
    }

    .main-table .test-col {
        text-align: left;
        font-size: 12px;
        white-space: normal;
        word-break: normal;
        padding: 0;
    }

    .result-header {
        font-weight: bold;
        font-size: 14px;
        text-align: center;
    }

    .result-sub-header {
        height: 36px;
        background: #fff;
    }

    .result-cell {
        padding: 0 !important;
        height: 36px !important;
        vertical-align: middle;
        background: #fff;
        position: relative;
        z-index: 50;
    }

    .results-input {
        display: block;
        width: 100%;
        height: 36px;
        min-height: 36px;
        border: none;
        outline: none;
        background: #fff;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 12px;
        text-align: center;
        padding: 4px;
        color: #000;
        box-sizing: border-box;
        cursor: text;
        pointer-events: auto;
        position: relative;
        z-index: 100;
    }

    .controls-area {
        margin-top: 28px;
        text-align: center;
        font-size: 15px;
        line-height: 1.6;
    }

    .control-input {
        width: 130px;
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 13px;
        text-align: center;
        background: transparent;
    }

    .calculations-box {
        margin-top: 22px;
        border: 1px solid #000;
        height: 320px;
    }

    .calculations-title {
        text-align: center;
        font-weight: bold;
        font-size: 15px;
        padding-top: 8px;
    }

    .calculations-textarea {
        width: 100%;
        height: 280px;
        border: none;
        outline: none;
        resize: none;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 13px;
        padding: 8px;
        box-sizing: border-box;
        background: transparent;
    }

    .signature-table {
        margin-top: 35px;
    }

    .signature-table td {
        border: none !important;
        text-align: center;
        font-size: 14px;
    }

    .signature-select {
        width: 280px;
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        text-align: center;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 13px;
        background: transparent;
        padding: 5px;
        color: #000;
    }

    .signature-label {
        font-size: 12px;
        margin-top: 4px;
    }

    .save-area {
        width: 1150px;
        min-width: 1150px;
        margin: 15px auto 40px;
        text-align: right;
    }

    .btn-save {
        background: #198754;
        color: #fff;
        border: none;
        padding: 12px 28px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
    }

    .alert-success-custom,
    .alert-error-custom {
        width: 1150px;
        min-width: 1150px;
        margin: 15px auto;
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

<div class="card-header d-flex justify-content-between">
    <a class="btn btn-sm btn-secondary"
        style="margin-left:8mm"
        href="/analyst_worksheet"
        title="return">
        Back
    </a>
</div>

<form action="{{ route('water_bacteriology_worksheet.store', $rla->id) }}" method="POST">
    @csrf

    <input type="hidden" name="user_id" value="{{ $rla->user_id }}">
    <input type="hidden" name="rla_no" value="{{ $rla->RLA_no }}">

    <div class="wb-screen" id="wbScreen">
        <div class="wb-scale-wrap" id="wbScaleWrap">
            <div class="wb-page">

                {{-- HEADER --}}
                <table class="wb-table header-table">
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

                <table class="wb-table doc-table">
                    <tr>
                        <td style="width:23%;">
                            Document Type<br>
                            <b>Work Instruction</b>
                        </td>
                        <td style="width:24%;">
                            Revision No:<br>
                            0
                        </td>
                        <td style="width:32%;">
                            Date Adopted:<br>
                            13 August 2019
                        </td>
                        <td style="width:21%;">
                            Page No:
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Document Code:<br>
                            <b>LF W01-MIC-04</b>
                        </td>
                        <td colspan="3" class="center bold">
                            ANALYST WORKSHEET FOR BACTERIAL ANALYSIS OF<br>
                            SHRIMP, WATER, SOIL AND MOLASSES
                        </td>
                    </tr>
                </table>

                {{-- SAMPLE TYPE --}}
                <div class="sample-row">
                    Sample Type:
                    <input type="text"
                           name="sample_type"
                           class="sample-input-line"
                           value="{{ old('sample_type', $worksheet->sample_type ?? $firstSampleDescription) }}">
                </div>

                {{-- MAIN TABLE --}}
                <table class="wb-table main-table">
                    <colgroup>
                        <col style="width:18%;">
                        <col style="width:8%;">
                        <col style="width:8%;">
                        <col style="width:8%;">
                        <col style="width:8%;">
                        <col style="width:8%;">
                        <col style="width:8%;">
                        <col style="width:8%;">
                        <col style="width:8%;">
                        <col style="width:18%;">
                    </colgroup>

                    {{-- INFO ROW --}}
                    <tr>
                        <td colspan="1" class="info-cell">
                            <b>RLA No.:</b>
                            <input type="text"
                                   name="rla_no"
                                   class="input-cell"
                                   value="{{ old('rla_no', $worksheet->rla_no ?? $rla->RLA_no ?? '') }}">
                        </td>

                        <td colspan="3" class="info-cell">
                            <b>Lab Code:</b>
                            <input type="text"
                                   name="lab_code"
                                   class="input-cell"
                                   value="{{ old('lab_code', $worksheet->lab_code ?? $firstLabCode) }}">
                        </td>

                        <td colspan="3" class="info-cell">
                            <label for="date_started"><b>Date Started:</b></label>
                            <input type="date"
                                   id="date_started"
                                   name="date_started"
                                   class="date-input"
                                   value="{{ old('date_started', $dateStarted) }}">
                        </td>

                        <td colspan="3" class="info-cell">
                            <label for="date_finished"><b>Date Finished:</b></label>
                            <input type="date"
                                   id="date_finished"
                                   name="date_finished"
                                   class="date-input"
                                   value="{{ old('date_finished', $dateFinished) }}">
                        </td>
                    </tr>

                    {{-- HEADER ROW 1 --}}
                    <tr>
                        <td rowspan="3" class="center bold">Test</td>
                        <td colspan="8" class="center bold">Dilution</td>
                        <td class="result-header">Results</td>
                    </tr>

                    {{-- HEADER ROW 2 --}}
                    <tr>
                        <td colspan="2" class="center">10⁰</td>
                        <td colspan="2" class="center">10⁻¹</td>
                        <td colspan="2" class="center">10⁻²</td>
                        <td colspan="2" class="center">10⁻³</td>
                        <td class="result-sub-header"></td>
                    </tr>

                    {{-- HEADER ROW 3 --}}
                    <tr>
                        <td class="center">R1</td>
                        <td class="center">R2</td>
                        <td class="center">R1</td>
                        <td class="center">R2</td>
                        <td class="center">R1</td>
                        <td class="center">R2</td>
                        <td class="center">R1</td>
                        <td class="center">R2</td>
                        <td class="result-sub-header"></td>
                    </tr>

                    {{-- DATA ROWS --}}
                    @for($i = 0; $i < $rowCount; $i++)
                        @php
                            $defaultTestName = $displayTests[$i] ?? '';
                        @endphp

                        <tr>
                            <td class="test-col">
                                <input type="text"
                                       name="test_name[]"
                                       class="input-cell input-cell-left"
                                       value="{{ old('test_name.' . $i, wbVal($testName, $i, $defaultTestName)) }}">
                            </td>

                            <td>
                                <input type="text"
                                       name="dilution_100_r1[]"
                                       class="input-cell"
                                       value="{{ old('dilution_100_r1.' . $i, wbVal($d100r1, $i)) }}">
                            </td>

                            <td>
                                <input type="text"
                                       name="dilution_100_r2[]"
                                       class="input-cell"
                                       value="{{ old('dilution_100_r2.' . $i, wbVal($d100r2, $i)) }}">
                            </td>

                            <td>
                                <input type="text"
                                       name="dilution_101_r1[]"
                                       class="input-cell"
                                       value="{{ old('dilution_101_r1.' . $i, wbVal($d101r1, $i)) }}">
                            </td>

                            <td>
                                <input type="text"
                                       name="dilution_101_r2[]"
                                       class="input-cell"
                                       value="{{ old('dilution_101_r2.' . $i, wbVal($d101r2, $i)) }}">
                            </td>

                            <td>
                                <input type="text"
                                       name="dilution_102_r1[]"
                                       class="input-cell"
                                       value="{{ old('dilution_102_r1.' . $i, wbVal($d102r1, $i)) }}">
                            </td>

                            <td>
                                <input type="text"
                                       name="dilution_102_r2[]"
                                       class="input-cell"
                                       value="{{ old('dilution_102_r2.' . $i, wbVal($d102r2, $i)) }}">
                            </td>

                            <td>
                                <input type="text"
                                       name="dilution_103_r1[]"
                                       class="input-cell"
                                       value="{{ old('dilution_103_r1.' . $i, wbVal($d103r1, $i)) }}">
                            </td>

                            <td>
                                <input type="text"
                                       name="dilution_103_r2[]"
                                       class="input-cell"
                                       value="{{ old('dilution_103_r2.' . $i, wbVal($d103r2, $i)) }}">
                            </td>

                            <td class="result-cell">
                                <input type="text"
                                       name="results[]"
                                       class="results-input"
                                       value="{{ old('results.' . $i, wbVal($results, $i)) }}">
                            </td>
                        </tr>
                    @endfor
                </table>

                {{-- CONTROLS --}}
                <div class="controls-area">
                    <div>
                        Batch No. of Prepared Culture Media:
                        <input type="text"
                               name="batch_no_prepared_culture_media"
                               class="control-input"
                               value="{{ old('batch_no_prepared_culture_media', $worksheet->batch_no_prepared_culture_media ?? '') }}">

                        &nbsp;&nbsp;
                        Air Control (15 m exposure):
                        <input type="text"
                               name="air_control"
                               class="control-input"
                               value="{{ old('air_control', $worksheet->air_control ?? '') }}">
                    </div>

                    <div>
                        Medium Control (TCBS):
                        <input type="text"
                               name="medium_control_tcbs"
                               class="control-input"
                               value="{{ old('medium_control_tcbs', $worksheet->medium_control_tcbs ?? '') }}">

                        &nbsp;&nbsp;
                        Diluent (Sterile Sea Water):
                        <input type="text"
                               name="diluent_sterile_sea_water"
                               class="control-input"
                               value="{{ old('diluent_sterile_sea_water', $worksheet->diluent_sterile_sea_water ?? '') }}">
                    </div>
                </div>

                {{-- CALCULATIONS --}}
                <div class="calculations-box">
                    <div class="calculations-title">CALCULATIONS</div>
                    <textarea name="calculations" class="calculations-textarea">{{ old('calculations', $worksheet->calculations ?? '') }}</textarea>
                </div>

                {{-- SIGNATURE --}}
                <table class="wb-table signature-table">
                    <tr>
                        <td style="width:50%;">
                            Analyzed by:
                        </td>
                        <td style="width:50%;">
                            Checked by:
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <select name="analyzed_by" class="signature-select">
                                <option value="">Select Analyst</option>
                                @foreach($users as $user)
                                    @php
                                        $fullName = trim(($user->f_name ?? '') . ' ' . ($user->m_name ?? '') . ' ' . ($user->l_name ?? ''));
                                    @endphp

                                    <option value="{{ $fullName }}"
                                        {{ old('analyzed_by', $worksheet->analyzed_by ?? '') == $fullName ? 'selected' : '' }}>
                                        {{ $fullName }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="signature-label">
                                Name of Analyst and Signature
                            </div>
                        </td>

                        <td>
                            <select name="checked_by" class="signature-select">
                                <option value="">Select Checker</option>
                                @foreach($users as $user)
                                    @php
                                        $fullName = trim(($user->f_name ?? '') . ' ' . ($user->m_name ?? '') . ' ' . ($user->l_name ?? ''));
                                    @endphp

                                    <option value="{{ $fullName }}"
                                        {{ old('checked_by', $worksheet->checked_by ?? '') == $fullName ? 'selected' : '' }}>
                                        {{ $fullName }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="signature-label">
                                Name of Analyst and Signature
                            </div>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

    <div class="save-area">
        <button type="submit" class="btn-save">Save Worksheet</button>
    </div>
</form>
@endsection