<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 12px 14px;
        }

        body {
            font-family: Cambria, "Times New Roman", serif;
            font-size: 8px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 2px 3px;
            vertical-align: middle;
            color: #000;
            line-height: 1.05;
            font-family: Cambria, "Times New Roman", serif;
            box-sizing: border-box;
            overflow: hidden;
        }

        .center { text-align: center; }
        .left { text-align: left; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .italic { font-style: italic; }

        .header-table td {
            height: 66px;
        }

        .logo-cell {
            width: 130px;
            text-align: center;
        }

        .logo {
            width: 68px;
            height: auto;
        }

        .header-text {
            text-align: left;
            font-size: 9px;
            line-height: 1.05;
            padding-left: 8px;
        }

        .doc-table td {
            height: 24px;
            font-size: 8px;
        }

        .info-table {
            margin-top: 22px;
        }

        .info-table td {
            height: 18px;
            font-size: 7.5px;
            white-space: nowrap;
        }

        .main-title {
            font-size: 8px;
            font-weight: bold;
            text-align: center;
        }

        .sample-row {
            margin-top: 12px;
            margin-bottom: 8px;
            font-size: 8px;
        }

        .sample-line {
            display: inline-block;
            min-width: 180px;
            border-bottom: 1px solid #000;
            text-align: center;
            padding: 0 5px;
        }

        .section-gap td {
            height: 6px;
            background: #eee7f5;
            padding: 0;
        }

        .micro-table th,
        .micro-table td {
            font-size: 6.8px;
            padding: 1px 2px;
            height: 16px;
        }

        .test-name {
            text-align: left;
            font-weight: bold;
            padding-left: 4px;
        }

        .unit-cell {
            text-align: right;
            font-weight: bold;
            font-size: 8px;
            white-space: nowrap;
        }

        .unit-line {
            display: inline-block;
            min-width: 50px;
            border-bottom: 1px solid #000;
            text-align: center;
            padding: 0 3px;
        }

        /*
        |--------------------------------------------------------------------------
        | Replicates table
        |--------------------------------------------------------------------------
        */
        .rep-table th,
        .rep-table td {
            font-size: 8px;
            padding: 0;
            line-height: 1.05;
        }

        .rep-head-main {
            height: 18px;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
        }

        .rep-head-dilution {
            height: 16px;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px dotted #000 !important;
        }

        .rep-test-cell {
            height: 17px;
            font-size: 8px;
            font-weight: bold;
            text-align: left;
            padding-left: 7px !important;
            border-bottom: 1px dotted #000 !important;
        }

        .rep-label-cell {
            height: 17px;
            font-size: 8px;
            text-align: left;
            padding-left: 7px !important;
            border-bottom: 1px dotted #000 !important;
        }

        .rep-label-flex {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .rep-label-text {
            display: table-cell;
            width: 92px;
            white-space: nowrap;
            text-align: left;
        }

        .rep-value {
            display: table-cell;
            border-bottom: 1px dotted #000;
            text-align: center;
            min-height: 10px;
        }

        .rep-result-cell {
            height: 17px;
            text-align: right;
            font-weight: bold;
            font-size: 8px;
            padding-right: 6px !important;
            border-bottom: 1px dotted #000 !important;
            white-space: nowrap;
        }

        .rep-result-line {
            display: inline-block;
            min-width: 42px;
            border-bottom: 1px solid #000;
            text-align: center;
            padding: 0 3px;
        }

        .staph-small {
            font-size: 5.5px;
            line-height: 1;
        }

        .staph-test {
            font-size: 5.8px;
        }

        .salmonella-top {
            height: 18px;
            text-align: left;
            font-size: 7px;
            padding-left: 5px !important;
        }

        .salmonella-line {
            display: inline-block;
            min-width: 80px;
            border-bottom: 1px dotted #000;
            text-align: center;
        }

        .shigella-label {
            display: inline-block;
            width: 130px;
            text-align: left;
        }

        .shigella-line {
            display: inline-block;
            width: 78%;
            border-bottom: 1px dotted #000;
            text-align: center;
        }

        .qc-title {
            border: 1px solid #000;
            border-bottom: none;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            padding: 3px;
            background: #f3f3f3;
        }

        .qc-table th,
        .qc-table td {
            font-size: 7px;
            padding: 2px 4px;
            vertical-align: top;
            line-height: 1.08;
        }

        .qc-table th {
            text-align: center;
            background: #f6f6f6;
        }

        .pre-wrap {
            white-space: pre-line;
        }

        .controls-area {
            margin-top: 8px;
            text-align: center;
            font-size: 8px;
            line-height: 1.4;
        }

        .control-line {
            display: inline-block;
            min-width: 90px;
            border-bottom: 1px solid #000;
            text-align: center;
            padding: 0 4px;
        }

        .calculations-box {
            margin-top: 10px;
            border: 1px solid #000;
            height: 130px;
        }

        .calculations-title {
            text-align: center;
            font-weight: bold;
            font-size: 9px;
            padding-top: 4px;
        }

        .calculations-content {
            padding: 6px;
            font-size: 8px;
            white-space: pre-wrap;
        }

        .signature-table {
            margin-top: 16px;
        }

        .signature-table td {
            border: none !important;
            text-align: center;
            font-size: 8px;
        }

        .signature-name {
            width: 160px;
            margin: 22px auto 0;
            text-align: center;
            min-height: 10px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 160px;
            margin: 2px auto 0;
        }

        .signature-label {
            font-size: 6px;
            margin-top: 2px;
        }
    </style>
</head>

<body>
@php
    function ffDownloadJson($value) {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    function ffDownloadFlatten($array) {
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

    function ffDownloadDateTime($value) {
        if (empty($value)) {
            return '';
        }

        try {
            return \Carbon\Carbon::parse($value)->format('m/d/Y h:i A');
        } catch (\Exception $e) {
            return $value;
        }
    }

    function ffv($worksheet, $field, $default = '') {
        return $worksheet->{$field} ?? $default;
    }

    $labCodes = ffDownloadJson($rla->laboratory_code ?? null);
    $firstLabCode = $labCodes[0] ?? '';

    $sampleDescriptions = ffDownloadJson($rla->sample_description ?? null);
    $firstSampleDescription = $sampleDescriptions[0] ?? '';

    $analysisRequested = ffDownloadFlatten(ffDownloadJson($rla->analysis_requested ?? null));
    $analysisUpper = array_map(function ($item) {
        return strtoupper(trim($item));
    }, $analysisRequested);

    $selected = function ($needles) use ($analysisUpper) {
        if (count($analysisUpper) === 0) {
            return true;
        }

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

    $rlaNo = $worksheet->rla_no ?? $rla->RLA_no ?? '';
    $labCode = $worksheet->lab_code ?? $firstLabCode;
    $sampleType = $worksheet->sample_type ?? $firstSampleDescription;

    $dateTimeStarted = ffDownloadDateTime($worksheet->date_time_started ?? '');
    $dateTimeFinished = ffDownloadDateTime($worksheet->date_time_finished ?? '');

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

{{-- HEADER --}}
     <table class="pcr-table">
                <tr>
                    <td class="logo-cell">
                          <img src="{{ public_path('assets/images/bfarlogo.png') }}" class="logo">

                    </td>
                    <td colspan="4" class="center">
                        <div>Republic of the Philippines</div>
                        <div>Department of Agriculture</div>
                        <div class="bold">BUREAU OF FISHERIES AND AQUATIC RESOURCES</div>
                        <div class="bold">REGIONAL FISHERIES LABORATORY XII</div>
                        <div>J. Catolico St., Lagao, General Santos City</div>
                    </td>
                </tr>
            </table>

{{-- DOCUMENT INFO --}}
    <table class="doc-table">
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
            <td colspan="3" class="main-title">
                ANALYST WORKSHEET FOR BACTERIOLOGICAL EXAMINATION OF<br>
                FISH AND FISHERY PRODUCTS
            </td>
        </tr>
    </table>

{{-- INFO --}}
<table class="info-table">
    <tr>
        <td style="width:23%;">
            <b>RLA No.:</b>
            <span style="margin-left:35px;">{{ $rlaNo }}</span>
        </td>
        <td style="width:23%;">
            <b>Lab Code:</b>
            <span style="margin-left:35px;">{{ $labCode }}</span>
        </td>
        <td style="width:27%;">
            <b>Date/Time Started:</b>
            <span style="margin-left:20px;">{{ $dateTimeStarted }}</span>
        </td>
        <td style="width:27%;">
            <b>Date/Time Finished:</b>
            <span style="margin-left:20px;">{{ $dateTimeFinished }}</span>
        </td>
    </tr>
</table>

<div class="sample-row">
    <b>Sample Type:</b>
    <span class="sample-line">{{ $sampleType }}</span>
</div>

{{-- APC --}}
@if($showApc)
    <table class="micro-table">
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
                <td>{{ ffv($worksheet, 'apc_' . $code . '_r1') }}</td>
                <td>{{ ffv($worksheet, 'apc_' . $code . '_r2') }}</td>
            @endforeach

            <td class="unit-cell">
                <span class="unit-line">{{ ffv($worksheet, 'apc_result') }}</span>
                cfu / g
            </td>
        </tr>
    </table>

    <table>
        <tr class="section-gap">
            <td></td>
        </tr>
    </table>
@endif

{{-- TOTAL / FECAL / E. COLI --}}
@if($showEcoli)
    <table class="rep-table">
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

        <tr>
            <td class="rep-test-cell"></td>

            @foreach(array_keys($replicateDilutions) as $code)
                <td class="rep-label-cell">
                    <div class="rep-label-flex">
                        <span class="rep-label-text">LST Broth:</span>
                        <span class="rep-value">{{ ffv($worksheet, 'tc_' . $code . '_lst_broth') }}</span>
                    </div>
                </td>
            @endforeach

            <td class="rep-result-cell"></td>
        </tr>

        <tr>
            <td class="rep-test-cell">Total Coliform Count</td>

            @foreach(array_keys($replicateDilutions) as $code)
                <td class="rep-label-cell">
                    <div class="rep-label-flex">
                        <span class="rep-label-text">BGLB Broth:</span>
                        <span class="rep-value">{{ ffv($worksheet, 'tc_' . $code . '_bglb_broth') }}</span>
                    </div>
                </td>
            @endforeach

            <td class="rep-result-cell">
                <span class="rep-result-line">{{ ffv($worksheet, 'tc_result') }}</span>
                MPN/g
            </td>
        </tr>

        <tr>
            <td class="rep-test-cell">Fecal Coliform Count</td>

            @foreach(array_keys($replicateDilutions) as $code)
                <td class="rep-label-cell">
                    <div class="rep-label-flex">
                        <span class="rep-label-text">EC Broth:</span>
                        <span class="rep-value">{{ ffv($worksheet, 'fc_' . $code . '_ec_broth') }}</span>
                    </div>
                </td>
            @endforeach

            <td class="rep-result-cell">
                <span class="rep-result-line">{{ ffv($worksheet, 'fc_result') }}</span>
                MPN/g
            </td>
        </tr>

        <tr>
            <td class="rep-test-cell"><i>Escherichia coli</i> Count</td>

            @foreach(array_keys($replicateDilutions) as $code)
                <td class="rep-label-cell">
                    <div class="rep-label-flex">
                        <span class="rep-label-text">L-EMB Agar:</span>
                        <span class="rep-value">{{ ffv($worksheet, 'ecoli_' . $code . '_l_emb_agar') }}</span>
                    </div>
                </td>
            @endforeach

            <td class="rep-result-cell"></td>
        </tr>

        <tr>
            <td class="rep-test-cell"></td>

            @foreach(array_keys($replicateDilutions) as $code)
                <td class="rep-label-cell">
                    <div class="rep-label-flex">
                        <span class="rep-label-text">Confirmed Tests:</span>
                        <span class="rep-value">{{ ffv($worksheet, 'ecoli_' . $code . '_confirmed_tests') }}</span>
                    </div>
                </td>
            @endforeach

            <td class="rep-result-cell">
                <span class="rep-result-line">{{ ffv($worksheet, 'ecoli_result') }}</span>
                MPN/g
            </td>
        </tr>
    </table>

    <table>
        <tr class="section-gap">
            <td></td>
        </tr>
    </table>
@endif

{{-- STAPH --}}
@if($showStaph)
    <table class="micro-table">
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
                <td>{{ ffv($worksheet, 'staph_' . $code . '_r1_03ml') }}</td>
                <td>{{ ffv($worksheet, 'staph_' . $code . '_r2_03ml') }}</td>
                <td>{{ ffv($worksheet, 'staph_' . $code . '_r3_04ml') }}</td>
            @endforeach
        </tr>

        <tr>
            @foreach(array_keys($staphDilutions) as $code)
                <td colspan="2" class="staph-test">
                    Coagulase Test
                    {{ ffv($worksheet, 'staph_' . $code . '_coagulase_test') }}
                </td>
                <td class="staph-test">
                    Catalase Test
                    {{ ffv($worksheet, 'staph_' . $code . '_catalase_test') }}
                </td>
            @endforeach
        </tr>

        <tr>
            <td colspan="11" class="unit-cell">
                Result:
                <span class="unit-line">{{ ffv($worksheet, 'staph_result') }}</span>
                cfu/g
            </td>
        </tr>
    </table>

    <table>
        <tr class="section-gap">
            <td></td>
        </tr>
    </table>
@endif

{{-- SALMONELLA --}}
@if($showSalmonella)
    <table class="micro-table">
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
                pH:
                <span class="salmonella-line">{{ ffv($worksheet, 'salmonella_ph') }}</span>

                Incubation at Room Temperature:
                <span class="salmonella-line">{{ ffv($worksheet, 'salmonella_room_temperature') }}</span>

                Time Started:
                <span class="salmonella-line">{{ ffv($worksheet, 'salmonella_time_started') }}</span>

                Time Ended:
                <span class="salmonella-line">{{ ffv($worksheet, 'salmonella_time_ended') }}</span>
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
                    <td>{{ ffv($worksheet, $field) }}</td>
                @endforeach
            </tr>
        @endforeach

        <tr>
            <td colspan="7" class="unit-cell">
                Result:
                <span class="unit-line">{{ ffv($worksheet, 'salmonella_result') }}</span>
                per 25 g sample
            </td>
        </tr>
    </table>

    <table>
        <tr class="section-gap">
            <td></td>
        </tr>
    </table>
@endif

{{-- SHIGELLA --}}
@if($showShigella)
    <table class="micro-table">
        <colgroup>
            <col style="width:16%;">
            <col style="width:74%;">
            <col style="width:10%;">
        </colgroup>

        <tr>
            <th rowspan="2" class="italic">Shigella sp.</th>
            <td class="left">
                <span class="shigella-label">Isolation: McConkey Agar Plate</span>
                <span class="shigella-line">{{ ffv($worksheet, 'shigella_isolation_mcconkey_agar_plate') }}</span>
            </td>
            <td rowspan="2" class="unit-cell">
                <span class="unit-line">{{ ffv($worksheet, 'shigella_result') }}</span>
                per 25 g sample
            </td>
        </tr>

        <tr>
            <td class="left">
                <span class="shigella-label">Biochemical Tests / API</span>
                <span class="shigella-line">{{ ffv($worksheet, 'shigella_biochemical_tests_api') }}</span>
            </td>
        </tr>
    </table>
@endif

{{-- QC RESULTS --}}
<div class="qc-title">QC RESULTS</div>

<table class="qc-table">
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

            <td class="pre-wrap">
                {{ ffv($worksheet, 'qc_' . $key . '_check', $qc[1]) }}
            </td>

            <td class="pre-wrap">
                {{ ffv($worksheet, 'qc_' . $key . '_negative', $qc[2]) }}
            </td>

            <td class="pre-wrap">
                {{ ffv($worksheet, 'qc_' . $key . '_positive', $qc[3]) }}
            </td>
        </tr>
    @endforeach
</table>

{{-- CONTROLS --}}
<div class="controls-area">
    <div>
        Batch No. of Prepared Culture Media:
        <span class="control-line">{{ ffv($worksheet, 'batch_no_prepared_culture_media') }}</span>

        &nbsp;&nbsp;
        Air Control:
        <span class="control-line">{{ ffv($worksheet, 'air_control') }}</span>
    </div>

    <div>
        Medium Control:
        <span class="control-line">{{ ffv($worksheet, 'medium_control') }}</span>

        &nbsp;&nbsp;
        Diluent Control:
        <span class="control-line">{{ ffv($worksheet, 'diluent_control') }}</span>
    </div>
</div>

{{-- CALCULATIONS --}}
<div class="calculations-box">
    <div class="calculations-title">CALCULATIONS</div>
    <div class="calculations-content">
        {{ ffv($worksheet, 'calculations') }}
    </div>
</div>

{{-- SIGNATURE --}}
<table class="signature-table">
    <tr>
        <td style="width:50%;">
            Analyzed by:

            <div class="signature-name">
                {{ ffv($worksheet, 'analyzed_by') }}
            </div>
            <div class="signature-line"></div>
            <div class="signature-label">Name of Analyst and Signature</div>
        </td>

        <td style="width:50%;">
            Checked by:

            <div class="signature-name">
                {{ ffv($worksheet, 'checked_by') }}
            </div>
            <div class="signature-line"></div>
            <div class="signature-label">Name of Analyst and Signature</div>
        </td>
    </tr>
</table>

</body>
</html>