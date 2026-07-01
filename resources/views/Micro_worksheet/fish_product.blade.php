@extends('layouts.app')

@section('content')
@php
    if (!function_exists('ffJson')) {
        function ffJson($value) {
            if (empty($value)) return [];
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
    }

    if (!function_exists('ffFlatten')) {
        function ffFlatten($array) {
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
    }

    if (!function_exists('ffDateTimeValue')) {
        function ffDateTimeValue($value) {
            if (empty($value)) return '';

            try {
                return \Carbon\Carbon::parse($value)->format('Y-m-d\TH:i');
            } catch (\Exception $e) {
                return '';
            }
        }
    }

    $labCodes = ffJson($rla->laboratory_code ?? null);
    $firstLabCode = $labCodes[0] ?? '';

    $sampleDescriptions = ffJson($rla->sample_description ?? null);
    $firstSampleDescription = $sampleDescriptions[0] ?? '';

    $analysisRequested = ffFlatten(ffJson($rla->analysis_requested ?? null));
    $analysisUpper = array_map(fn($item) => strtoupper(trim($item)), $analysisRequested);

    $selected = function ($needles) use ($analysisUpper) {
        if (count($analysisUpper) === 0) return true;

        foreach ($needles as $needle) {
            $needle = strtoupper($needle);

            foreach ($analysisUpper as $item) {
                if ($item === $needle || str_contains($item, $needle) || str_contains($needle, $item)) {
                    return true;
                }
            }
        }

        return false;
    };

    $showApc = $selected(['APC', 'AEROBIC PLATE COUNT']);
    $showEcoli = $selected(['E COLI', 'E. COLI', 'TOTAL COLIFORM', 'FECAL COLIFORM']);
    $showStaph = $selected(['S. AUREUS', 'STAPHYLOCOCCUS AUREUS']);
    $showSalmonella = $selected(['SALMONELLA']);
    $showShigella = $selected(['SHIGELLA']);

    $dateTimeStarted = old('date_time_started', ffDateTimeValue($worksheet->date_time_started ?? ''));
    $dateTimeFinished = old('date_time_finished', ffDateTimeValue($worksheet->date_time_finished ?? ''));

    $val = function ($field, $default = '') use ($worksheet) {
        return old($field, $worksheet->{$field} ?? $default);
    };

    $users = $users ?? collect();

    $apcDilutions = [
        '10_1' => '10⁻¹',
        '10_2' => '10⁻²',
        '10_3' => '10⁻³',
        '10_4' => '10⁻⁴',
        '10_5' => '10⁻⁵',
        '10_6' => '10⁻⁶',
    ];

    $replicateDilutions = [
        '10_1' => '10<sup>-1</sup> (0.1)',
        '10_2' => '10<sup>-2</sup> (0.01)',
        '10_3' => '10<sup>-3</sup> (0.001)',
    ];

    $staphDilutions = [
        '10_1' => '10⁻¹',
        '10_2' => '10⁻²',
        '10_3' => '10⁻³',
    ];

    $salmonellaRows = [
        'tsi_agar_slant' => 'TSI Agar Slant',
        'tsi_agar_butt' => 'TSI Agar Butt',
        'lia_butt' => 'LIA Butt',
        'biochemical' => 'Biochemical Tests / API',
    ];

    $salmonellaCols = [
        'rv_bs_agar' => 'BS Agar',
        'rv_xld_agar' => 'XLD Agar',
        'rv_he_agar' => 'HE Agar',
        'tt_bs_agar' => 'BS Agar',
        'tt_xld_agar' => 'XLD Agar',
        'tt_he_agar' => 'HE Agar',
    ];
@endphp

<style>
    .ff-screen {
        width: 100%;
        overflow-x: auto;
        overflow-y: visible;
        padding: 18px 0 50px;
        background: #f5f6fa;
    }

    .ff-wrap {
        width: 1700px;
        min-width: 1700px;
        margin: 0 auto;
    }

    .ff-page {
        width: 1700px;
        min-width: 1700px;
        background: #fff;
        color: #000;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 13px;
        padding: 22px;
        box-sizing: border-box;
    }

    .ff-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .ff-table td,
    .ff-table th {
        border: 1px solid #000;
        vertical-align: middle;
        color: #000;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 12.5px;
        line-height: 1.15;
        padding: 3px 4px;
        box-sizing: border-box;
        overflow: hidden;
    }

    .center { text-align: center; }
    .left { text-align: left; }
    .right { text-align: right; }
    .bold { font-weight: bold; }
    .italic { font-style: italic; }

    .header-table td {
        height: 76px;
    }

    .logo-cell {
        width: 150px;
        text-align: center;
    }

    .logo-cell img {
        width: 76px;
        height: auto;
    }

    .header-text {
        text-align: left;
        font-size: 13px;
        line-height: 1.08;
        padding-left: 10px !important;
    }

    .doc-table td {
        height: 31px;
        font-size: 12px;
    }

    .info-table {
        margin-top: 22px;
    }

    .info-table td {
        height: 36px;
        font-size: 12.5px;
        white-space: nowrap;
        padding: 4px 7px;
        overflow: visible;
    }

    .sample-area {
        margin: 14px 0;
        font-size: 14px;
    }

    .input-cell {
        width: 100%;
        min-height: 24px;
        border: none;
        outline: none;
        background: transparent;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 12.5px;
        text-align: center;
        padding: 2px 3px;
        color: #000;
        box-sizing: border-box;
    }

    .input-line {
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        background: transparent;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 12.5px;
        text-align: center;
        color: #000;
        box-sizing: border-box;
    }

    .sample-input {
        width: 320px;
        height: 25px;
    }

    .date-input {
        width: 190px;
        height: 28px;
        border: 1px solid transparent;
        outline: none;
        background: #fff;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 12px;
        text-align: center;
        color: #000;
        box-sizing: border-box;
        cursor: pointer;
    }

    .micro-table {
        margin-top: 0;
    }

    .micro-table th,
    .micro-table td {
        height: 30px;
        padding: 0;
        text-align: center;
        font-size: 12.5px;
        overflow: hidden;
    }

    .micro-table th {
        font-weight: bold;
    }

    .test-name {
        text-align: left !important;
        padding: 4px 8px !important;
        font-weight: bold;
        font-size: 12.5px !important;
        white-space: normal;
    }

    .unit-cell {
        text-align: right !important;
        font-weight: bold;
        font-size: 14px !important;
        padding-right: 8px !important;
        white-space: nowrap;
        overflow: hidden !important;
    }

    .unit-input {
        width: 70%;
        min-height: 23px;
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        background: transparent;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 12.5px;
        text-align: center;
    }

    .section-gap td {
        height: 9px !important;
        background: #eee7f5;
        border-left: 1px solid #000;
        border-right: 1px solid #000;
        padding: 0 !important;
    }

    /*
    |--------------------------------------------------------------------------
    | REPLICATES SECTION - SAME SA PIC
    |--------------------------------------------------------------------------
    */
    .rep-main-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .rep-main-table th,
    .rep-main-table td {
        border: 1px solid #000;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 13px;
        line-height: 1.1;
        padding: 0;
        vertical-align: middle;
        overflow: hidden;
    }

    .rep-head-main {
        font-weight: bold;
        font-size: 14px !important;
        height: 33px;
        text-align: center;
    }

    .rep-head-dilution {
        font-weight: bold;
        font-size: 16px !important;
        height: 31px;
        text-align: center;
        border-bottom: 1px dotted #000 !important;
    }

    .rep-test-cell {
        padding: 0 10px !important;
        text-align: left !important;
        font-weight: bold;
        font-size: 14px !important;
        height: 31px;
        border-bottom: 1px dotted #000 !important;
    }

    .rep-label-cell {
        padding: 0 12px !important;
        text-align: left !important;
        font-size: 14px !important;
        height: 31px;
        border-bottom: 1px dotted #000 !important;
    }

    .rep-label-flex {
        display: grid;
        grid-template-columns: 145px minmax(0, 1fr);
        align-items: center;
        width: 100%;
        column-gap: 5px;
        box-sizing: border-box;
    }

    .rep-label-text {
        white-space: nowrap;
        text-align: left;
        font-size: 14px;
    }

    .rep-input-line {
        width: 100%;
        min-width: 0;
        height: 24px;
        border: none;
        outline: none;
        background: transparent;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 13px;
        text-align: center;
        box-sizing: border-box;
    }

    .rep-result-cell {
        padding: 0 10px !important;
        text-align: right !important;
        font-weight: bold;
        font-size: 15px !important;
        white-space: nowrap;
        border-bottom: 1px dotted #000 !important;
    }

    .rep-result-input {
        width: 72%;
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        background: transparent;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 13px;
        text-align: center;
        margin-right: 5px;
    }

    .staph-small {
        font-size: 10.5px !important;
        line-height: 1.05;
    }

    .staph-test-cell {
        padding: 2px 6px !important;
        overflow: hidden !important;
    }

    .staph-test-grid {
        display: grid;
        grid-template-columns: 110px minmax(0, 1fr);
        align-items: center;
        width: 100%;
        column-gap: 4px;
        box-sizing: border-box;
    }

    .field-label {
        text-align: left;
        font-size: 11.5px;
        white-space: nowrap;
    }

    .line-input {
        width: 100%;
        min-width: 0;
        height: 20px;
        border: none;
        border-bottom: 1px dotted #000;
        outline: none;
        background: transparent;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 12px;
        text-align: center;
        box-sizing: border-box;
    }

    .salmonella-top {
        height: 34px !important;
        padding: 4px 6px !important;
        text-align: left !important;
        overflow: hidden !important;
    }

    .salmonella-flex {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        box-sizing: border-box;
    }

    .salmonella-flex label {
        white-space: nowrap;
        font-size: 12px;
    }

    .salmonella-line {
        width: 130px;
        border: none;
        border-bottom: 1px dotted #000;
        outline: none;
        background: transparent;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 12px;
        text-align: center;
        min-width: 0;
    }

    .salmonella-cell {
        padding: 0 !important;
    }

    .shigella-line-wrap {
        display: grid;
        grid-template-columns: 205px minmax(0, 1fr);
        align-items: center;
        width: 100%;
        padding: 2px 6px;
        box-sizing: border-box;
        column-gap: 4px;
    }

    .qc-title {
        margin-top: 8px;
        border: 1px solid #000;
        border-bottom: none;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        padding: 5px;
        background: #f3f3f3;
    }

    .qc-table th,
    .qc-table td {
        font-size: 12.5px;
        padding: 4px 6px;
        vertical-align: top;
        overflow: hidden;
    }

    .qc-table th {
        background: #f6f6f6;
        text-align: center;
    }

    .textarea-cell {
        width: 100%;
        min-height: 48px;
        border: none;
        outline: none;
        resize: vertical;
        background: transparent;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 12px;
        line-height: 1.25;
        box-sizing: border-box;
    }

    .controls-area {
        margin-top: 16px;
        text-align: center;
        font-size: 14px;
        line-height: 1.8;
    }

    .control-input {
        width: 170px;
        height: 22px;
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        background: transparent;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 12.5px;
        text-align: center;
    }

    .calculations-box {
        margin-top: 18px;
        border: 1px solid #000;
        height: 250px;
    }

    .calculations-title {
        text-align: center;
        font-weight: bold;
        font-size: 15px;
        padding-top: 7px;
    }

    .calculations-textarea {
        width: 100%;
        height: 210px;
        border: none;
        outline: none;
        resize: none;
        background: transparent;
        font-family: Cambria, "Times New Roman", serif;
        font-size: 13px;
        padding: 8px;
        box-sizing: border-box;
    }

    .signature-table {
        margin-top: 25px;
    }

    .signature-table td {
        border: none !important;
        text-align: center;
        font-size: 13px;
    }

    .signature-select {
        width: 300px;
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
        font-size: 11px;
        margin-top: 4px;
    }

    .save-area {
        width: 1700px;
        min-width: 1700px;
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
        width: 1700px;
        min-width: 1700px;
        margin: 15px auto;
        padding: 12px;
        font-size: 14px;
    }
   .pcr-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .pcr-table td,
    .pcr-table th {
        border: 1px solid #000;
        padding: 4px;
        vertical-align: middle;
        font-size: 12px;
        line-height: 1.1;
        color: #000;
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


<form action="{{ route('fish_fishery_worksheet.store', $rla->id) }}" method="POST">
    @csrf

    <input type="hidden" name="user_id" value="{{ $rla->user_id }}">

    <div class="ff-screen">
        <div class="ff-wrap">
            <div class="ff-page">

                {{-- HEADER --}}
                <table class="ff-table header-table">
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

                <table class="ff-table doc-table">
                    <tr>
                        <td style="width:23%;">
                            Document Type<br>
                            <b>Laboratory Form</b>
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
                            <b>LF-W01-MIC-03</b>
                        </td>
                        <td colspan="3" class="center bold">
                            ANALYST WORKSHEET FOR BACTERIOLOGICAL EXAMINATION OF<br>
                            FISH AND FISHERY PRODUCTS
                        </td>
                    </tr>
                </table>

                {{-- INFO --}}
                <table class="ff-table info-table">
                    <tr>
                        <td style="width:23%;">
                            <b>RLA No.:</b>
                            <input type="text" name="rla_no" class="input-cell"
                                value="{{ old('rla_no', $worksheet->rla_no ?? $rla->RLA_no ?? '') }}">
                        </td>
                        <td style="width:23%;">
                            <b>Lab Code:</b>
                            <input type="text" name="lab_code" class="input-cell"
                                value="{{ old('lab_code', $worksheet->lab_code ?? $firstLabCode) }}">
                        </td>
                        <td style="width:27%;">
                            <b>Date/Time Started:</b>
                            <input type="datetime-local" name="date_time_started" class="date-input"
                                value="{{ $dateTimeStarted }}">
                        </td>
                        <td style="width:27%;">
                            <b>Date/Time Finished:</b>
                            <input type="datetime-local" name="date_time_finished" class="date-input"
                                value="{{ $dateTimeFinished }}">
                        </td>
                    </tr>
                </table>

                <div class="sample-area">
                    <b>Sample Type:</b>
                    <input type="text" name="sample_type" class="input-line sample-input"
                        value="{{ old('sample_type', $worksheet->sample_type ?? $firstSampleDescription) }}">
                </div>

                {{-- APC --}}
                @if($showApc)
                    <table class="ff-table micro-table">
                        <colgroup>
                            <col style="width:16%;">
                            @for($i = 0; $i < 12; $i++)
                                <col style="width:6.2%;">
                            @endfor
                            <col style="width:9.6%;">
                        </colgroup>

                        <tr>
                            <th rowspan="3">TESTS</th>
                            <th colspan="12">Dilutions</th>
                            <th rowspan="3">RESULTS</th>
                        </tr>
                        <tr>
                            @foreach($apcDilutions as $label)
                                <th colspan="2">{{ $label }}</th>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach($apcDilutions as $label)
                                <th>R1</th>
                                <th>R2</th>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="test-name">Aerobic Plate Count</td>

                            @foreach(array_keys($apcDilutions) as $code)
                                <td>
                                    <input type="text" name="apc_{{ $code }}_r1" class="input-cell" value="{{ $val('apc_' . $code . '_r1') }}">
                                </td>
                                <td>
                                    <input type="text" name="apc_{{ $code }}_r2" class="input-cell" value="{{ $val('apc_' . $code . '_r2') }}">
                                </td>
                            @endforeach

                            <td class="unit-cell">
                                <input type="text" name="apc_result" class="unit-input" value="{{ $val('apc_result') }}">
                                cfu / g
                            </td>
                        </tr>
                    </table>

                    <table class="ff-table">
                        <tr class="section-gap">
                            <td></td>
                        </tr>
                    </table>
                @endif

                {{-- TOTAL / FECAL / E. COLI - SAME SA PIC --}}
                @if($showEcoli)
                    <table class="ff-table rep-main-table">
                        <colgroup>
                            <col style="width:23%;">
                            <col style="width:22%;">
                            <col style="width:22%;">
                            <col style="width:22%;">
                            <col style="width:11%;">
                        </colgroup>

                        <tr>
                            <th rowspan="2"></th>
                            <th colspan="3" class="rep-head-main">No. of + Replicates</th>
                            <th rowspan="2"></th>
                        </tr>

                        <tr>
                            @foreach($replicateDilutions as $label)
                                <th class="rep-head-dilution">{!! $label !!}</th>
                            @endforeach
                        </tr>

                        {{-- LST BROTH --}}
                        <tr>
                            <td class="rep-test-cell"></td>

                            @foreach(array_keys($replicateDilutions) as $code)
                                <td class="rep-label-cell">
                                    <div class="rep-label-flex">
                                        <span class="rep-label-text">LST Broth:</span>

                                        @php
                                            $field = 'tc_' . $code . '_lst_broth';
                                        @endphp

                                        <input type="text"
                                               name="{{ $field }}"
                                               class="rep-input-line"
                                               value="{{ $val($field) }}">
                                    </div>
                                </td>
                            @endforeach

                            <td class="rep-result-cell"></td>
                        </tr>

                        {{-- BGLB BROTH / TOTAL COLIFORM RESULT --}}
                        <tr>
                            <td class="rep-test-cell">Total Coliform Count</td>

                            @foreach(array_keys($replicateDilutions) as $code)
                                <td class="rep-label-cell">
                                    <div class="rep-label-flex">
                                        <span class="rep-label-text">BGLB Broth:</span>

                                        @php
                                            $field = 'tc_' . $code . '_bglb_broth';
                                        @endphp

                                        <input type="text"
                                               name="{{ $field }}"
                                               class="rep-input-line"
                                               value="{{ $val($field) }}">
                                    </div>
                                </td>
                            @endforeach

                            <td class="rep-result-cell">
                                <input type="text"
                                       name="tc_result"
                                       class="rep-result-input"
                                       value="{{ $val('tc_result') }}">
                                MPN/g
                            </td>
                        </tr>

                        {{-- EC BROTH / FECAL COLIFORM RESULT --}}
                        <tr>
                            <td class="rep-test-cell">Fecal Coliform Count</td>

                            @foreach(array_keys($replicateDilutions) as $code)
                                <td class="rep-label-cell">
                                    <div class="rep-label-flex">
                                        <span class="rep-label-text">EC Broth:</span>

                                        @php
                                            $field = 'fc_' . $code . '_ec_broth';
                                        @endphp

                                        <input type="text"
                                               name="{{ $field }}"
                                               class="rep-input-line"
                                               value="{{ $val($field) }}">
                                    </div>
                                </td>
                            @endforeach

                            <td class="rep-result-cell">
                                <input type="text"
                                       name="fc_result"
                                       class="rep-result-input"
                                       value="{{ $val('fc_result') }}">
                                MPN/g
                            </td>
                        </tr>

                        {{-- L-EMB AGAR --}}
                        <tr>
                            <td class="rep-test-cell"><i>Escherichia coli</i> Count</td>

                            @foreach(array_keys($replicateDilutions) as $code)
                                <td class="rep-label-cell">
                                    <div class="rep-label-flex">
                                        <span class="rep-label-text">L-EMB Agar:</span>

                                        @php
                                            $field = 'ecoli_' . $code . '_l_emb_agar';
                                        @endphp

                                        <input type="text"
                                               name="{{ $field }}"
                                               class="rep-input-line"
                                               value="{{ $val($field) }}">
                                    </div>
                                </td>
                            @endforeach

                            <td class="rep-result-cell"></td>
                        </tr>

                        {{-- CONFIRMED TESTS / E. COLI RESULT --}}
                        <tr>
                            <td class="rep-test-cell"></td>

                            @foreach(array_keys($replicateDilutions) as $code)
                                <td class="rep-label-cell">
                                    <div class="rep-label-flex">
                                        <span class="rep-label-text">Confirmed Tests:</span>

                                        @php
                                            $field = 'ecoli_' . $code . '_confirmed_tests';
                                        @endphp

                                        <input type="text"
                                               name="{{ $field }}"
                                               class="rep-input-line"
                                               value="{{ $val($field) }}">
                                    </div>
                                </td>
                            @endforeach

                            <td class="rep-result-cell">
                                <input type="text"
                                       name="ecoli_result"
                                       class="rep-result-input"
                                       value="{{ $val('ecoli_result') }}">
                                MPN/g
                            </td>
                        </tr>
                    </table>

                    <table class="ff-table">
                        <tr class="section-gap">
                            <td></td>
                        </tr>
                    </table>
                @endif

                {{-- STAPH --}}
                @if($showStaph)
                    <table class="ff-table micro-table">
                        <colgroup>
                            <col style="width:16%;">
                            @for($i = 0; $i < 9; $i++)
                                <col style="width:8.2%;">
                            @endfor
                            <col style="width:10.2%;">
                        </colgroup>

                        <tr>
                            <th rowspan="4" class="italic">Staphylococcus aureus Count</th>
                            @foreach($staphDilutions as $label)
                                <th colspan="3">{{ $label }}</th>
                            @endforeach
                            <th rowspan="4">RESULTS</th>
                        </tr>

                        <tr>
                            @foreach($staphDilutions as $label)
                                <th class="staph-small">R1 0.3 ml</th>
                                <th class="staph-small">R2 0.3 ml</th>
                                <th class="staph-small">R3 0.4 ml</th>
                            @endforeach
                        </tr>

                        <tr>
                            @foreach(array_keys($staphDilutions) as $code)
                                <td><input type="text" name="staph_{{ $code }}_r1_03ml" class="input-cell" value="{{ $val('staph_' . $code . '_r1_03ml') }}"></td>
                                <td><input type="text" name="staph_{{ $code }}_r2_03ml" class="input-cell" value="{{ $val('staph_' . $code . '_r2_03ml') }}"></td>
                                <td><input type="text" name="staph_{{ $code }}_r3_04ml" class="input-cell" value="{{ $val('staph_' . $code . '_r3_04ml') }}"></td>
                            @endforeach
                        </tr>

                        <tr>
                            @foreach(array_keys($staphDilutions) as $code)
                                <td colspan="2" class="staph-test-cell">
                                    <div class="staph-test-grid">
                                        <span class="field-label">Coagulase Test</span>
                                        <input type="text" name="staph_{{ $code }}_coagulase_test" class="line-input" value="{{ $val('staph_' . $code . '_coagulase_test') }}">
                                    </div>
                                </td>
                                <td class="staph-test-cell">
                                    <div class="staph-test-grid">
                                        <span class="field-label">Catalase Test</span>
                                        <input type="text" name="staph_{{ $code }}_catalase_test" class="line-input" value="{{ $val('staph_' . $code . '_catalase_test') }}">
                                    </div>
                                </td>
                            @endforeach
                        </tr>

                        <tr>
                            <td colspan="11" class="unit-cell">
                                Result:
                                <input type="text" name="staph_result" class="unit-input" value="{{ $val('staph_result') }}">
                                cfu/g
                            </td>
                        </tr>
                    </table>

                    <table class="ff-table">
                        <tr class="section-gap">
                            <td></td>
                        </tr>
                    </table>
                @endif

                {{-- SALMONELLA --}}
                @if($showSalmonella)
                    <table class="ff-table micro-table">
                        <colgroup>
                            <col style="width:16%;">
                            <col style="width:12%;">
                            @for($i = 0; $i < 6; $i++)
                                <col style="width:12%;">
                            @endfor
                        </colgroup>

                        <tr>
                            <th rowspan="8" class="italic">Salmonella sp.</th>
                            <td colspan="7" class="salmonella-top">
                                <div class="salmonella-flex">
                                    <label>pH:</label>
                                    <input type="text" name="salmonella_ph" class="salmonella-line" value="{{ $val('salmonella_ph') }}">

                                    <label>Incubation at Room Temperature:</label>
                                    <input type="text" name="salmonella_room_temperature" class="salmonella-line" value="{{ $val('salmonella_room_temperature') }}">

                                    <label>Time Started:</label>
                                    <input type="text" name="salmonella_time_started" class="salmonella-line" value="{{ $val('salmonella_time_started') }}">

                                    <label>Time Ended:</label>
                                    <input type="text" name="salmonella_time_ended" class="salmonella-line" value="{{ $val('salmonella_time_ended') }}">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="2">Isolation</td>
                            <th colspan="3">RV Medium</th>
                            <th colspan="3">TT Broth</th>
                        </tr>

                        <tr>
                            @foreach($salmonellaCols as $colLabel)
                                <th>{{ $colLabel }}</th>
                            @endforeach
                        </tr>

                        @foreach($salmonellaRows as $rowKey => $rowLabel)
                            <tr>
                                <td>{{ $rowLabel }}</td>

                                @foreach($salmonellaCols as $colKey => $colLabel)
                                    @php
                                        $field = 'salmonella_' . $rowKey . '_' . $colKey;
                                    @endphp
                                    <td class="salmonella-cell">
                                        <input type="text" name="{{ $field }}" class="input-cell" value="{{ $val($field) }}">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="7" class="unit-cell">
                                Result:
                                <input type="text" name="salmonella_result" class="unit-input" value="{{ $val('salmonella_result') }}">
                                per 25 g sample
                            </td>
                        </tr>
                    </table>

                    <table class="ff-table">
                        <tr class="section-gap">
                            <td></td>
                        </tr>
                    </table>
                @endif

                {{-- SHIGELLA --}}
                @if($showShigella)
                    <table class="ff-table micro-table">
                        <colgroup>
                            <col style="width:16%;">
                            <col style="width:74%;">
                            <col style="width:10%;">
                        </colgroup>

                        <tr>
                            <th rowspan="2" class="italic">Shigella sp.</th>
                            <td class="left">
                                <div class="shigella-line-wrap">
                                    <span>Isolation: McConkey Agar Plate</span>
                                    <input type="text" name="shigella_isolation_mcconkey_agar_plate" class="line-input" value="{{ $val('shigella_isolation_mcconkey_agar_plate') }}">
                                </div>
                            </td>
                            <td rowspan="2" class="unit-cell">
                                <input type="text" name="shigella_result" class="unit-input" value="{{ $val('shigella_result') }}">
                                per 25 g sample
                            </td>
                        </tr>

                        <tr>
                            <td class="left">
                                <div class="shigella-line-wrap">
                                    <span>Biochemical Tests / API</span>
                                    <input type="text" name="shigella_biochemical_tests_api" class="line-input" value="{{ $val('shigella_biochemical_tests_api') }}">
                                </div>
                            </td>
                        </tr>
                    </table>
                @endif

                {{-- QC RESULTS --}}
                <div class="qc-title">QC RESULTS</div>

                <table class="ff-table qc-table">
                    <colgroup>
                        <col style="width:25%;">
                        <col style="width:20%;">
                        <col style="width:27.5%;">
                        <col style="width:27.5%;">
                    </colgroup>

                    <tr>
                        <th>Tests</th>
                        <th>QC Checks</th>
                        <th>Negative Control</th>
                        <th>Positive Control</th>
                    </tr>

                    @foreach([
                        'apc' => ['Aerobic Plate Count', 'PCA', '', 'white colonies'],
                        'presumptive' => ['Presumptive Tests for TC, FC, EC', 'LST Broth', '', "with gas production, turbid with\neffervescence"],
                        'total_coliform' => ['Total Coliform', 'BGLB', '', ''],
                        'fecal_coliform' => ['Fecal Coliform', 'EC Broth', '', "with gas production, turbid with\neffervescence"],
                        'ecoli' => ['E. coli', "EMB Agar\nGram Reaction\nTB / Indole Test\nVogues Proskauer\nMethyl Red\nSCA / KCB / Citrate\nUtilization\nGas Production", '', "€ greenish metallic sheen\n€ gram (-)\n€ red color\n€ red color\n€ yellow color (-)\n€ no color change\n€ with gas production"],
                        'staph' => ['Staphylococcus aureus', '', 'E. coli - inhibition', ''],
                        'salmonella' => ['Salmonella sp.', '', '', ''],
                        'shigella' => ['Shigella sp.', '', '', ''],
                    ] as $key => $qc)
                        <tr>
                            <td class="left">{!! $qc[0] === 'E. coli' ? '<i>E. coli</i>' : $qc[0] !!}</td>

                            <td>
                                <textarea name="qc_{{ $key }}_check" class="textarea-cell">{{ old('qc_' . $key . '_check', $worksheet->{'qc_' . $key . '_check'} ?? $qc[1]) }}</textarea>
                            </td>

                            <td>
                                <textarea name="qc_{{ $key }}_negative" class="textarea-cell">{{ old('qc_' . $key . '_negative', $worksheet->{'qc_' . $key . '_negative'} ?? $qc[2]) }}</textarea>
                            </td>

                            <td>
                                <textarea name="qc_{{ $key }}_positive" class="textarea-cell">{{ old('qc_' . $key . '_positive', $worksheet->{'qc_' . $key . '_positive'} ?? $qc[3]) }}</textarea>
                            </td>
                        </tr>
                    @endforeach
                </table>

                {{-- CONTROLS --}}
                <div class="controls-area">
                    <div>
                        Batch No. of Prepared Culture Media:
                        <input type="text" name="batch_no_prepared_culture_media" class="control-input" value="{{ $val('batch_no_prepared_culture_media') }}">

                        &nbsp;&nbsp;
                        Air Control:
                        <input type="text" name="air_control" class="control-input" value="{{ $val('air_control') }}">
                    </div>

                    <div>
                        Medium Control:
                        <input type="text" name="medium_control" class="control-input" value="{{ $val('medium_control') }}">

                        &nbsp;&nbsp;
                        Diluent Control:
                        <input type="text" name="diluent_control" class="control-input" value="{{ $val('diluent_control') }}">
                    </div>
                </div>

                {{-- CALCULATIONS --}}
                <div class="calculations-box">
                    <div class="calculations-title">CALCULATIONS</div>
                    <textarea name="calculations" class="calculations-textarea">{{ old('calculations', $worksheet->calculations ?? '') }}</textarea>
                </div>

                {{-- SIGNATURE --}}
                <table class="ff-table signature-table">
                    <tr>
                        <td style="width:50%;">Analyzed by:</td>
                        <td style="width:50%;">Checked by:</td>
                    </tr>

                    <tr>
                        <td>
                            <select name="analyzed_by" class="signature-select">
                                <option value="">Select Analyst</option>
                                @foreach($users as $user)
                                    @php
                                        $fullName = trim(($user->f_name ?? '') . ' ' . ($user->m_name ?? '') . ' ' . ($user->l_name ?? ''));
                                    @endphp
                                    <option value="{{ $fullName }}" {{ old('analyzed_by', $worksheet->analyzed_by ?? '') == $fullName ? 'selected' : '' }}>
                                        {{ $fullName }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="signature-label">Name of Analyst and Signature</div>
                        </td>

                        <td>
                            <select name="checked_by" class="signature-select">
                                <option value="">Select Checker</option>
                                @foreach($users as $user)
                                    @php
                                        $fullName = trim(($user->f_name ?? '') . ' ' . ($user->m_name ?? '') . ' ' . ($user->l_name ?? ''));
                                    @endphp
                                    <option value="{{ $fullName }}" {{ old('checked_by', $worksheet->checked_by ?? '') == $fullName ? 'selected' : '' }}>
                                        {{ $fullName }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="signature-label">Name of Analyst and Signature</div>
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