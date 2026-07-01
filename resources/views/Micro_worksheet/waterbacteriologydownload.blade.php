<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 18px 22px;
        }

        body {
            font-family: Cambria, "Times New Roman", serif;
            font-size: 9px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        td, th {
            border: 1px solid #000;
            padding: 2px 3px;
            vertical-align: middle;
            color: #000;
            line-height: 1.05;
            box-sizing: border-box;
            font-family: Cambria, "Times New Roman", serif;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .bold {
            font-weight: bold;
        }

        .header-table td {
            height: 70px;
        }

        .logo-cell {
            width: 145px;
            text-align: center;
        }

        .logo {
            width: 72px;
            height: auto;
        }

        .header-text {
            text-align: left;
            font-size: 10px;
            line-height: 1.08;
            padding-left: 8px;
        }

        .doc-table td {
            height: 24px;
            font-size: 8px;
        }

        .sample-row {
            margin-top: 42px;
            margin-left: 70px;
            margin-bottom: 30px;
            font-size: 11px;
        }

        .sample-line {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 260px;
            min-height: 12px;
            text-align: center;
            padding: 0 5px;
        }

        .main-table th,
        .main-table td {
            height: 18px;
            font-size: 7.5px;
            padding: 1px 2px;
            text-align: center;
        }

        .main-table .info-cell {
            text-align: left;
            font-size: 8px;
            height: 20px;
            padding: 2px 4px;
            white-space: nowrap;
        }

        .main-table .test-col {
            text-align: left;
            font-size: 8px;
            padding-left: 5px;
            white-space: normal;
            word-break: normal;
        }

        .result-header {
            font-size: 9px;
            font-weight: bold;
        }

        .result-sub-header {
            background: #fff;
        }

        .controls-area {
            margin-top: 22px;
            text-align: center;
            font-size: 9px;
            line-height: 1.55;
        }

        .line {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 95px;
            min-height: 10px;
            padding: 0 4px;
            text-align: center;
        }

        .line-lg {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 130px;
            min-height: 10px;
            padding: 0 4px;
            text-align: center;
        }

        .calculations-box {
            margin-top: 20px;
            border: 1px solid #000;
            height: 245px;
        }

        .calculations-title {
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            padding-top: 6px;
        }

        .calculations-content {
            padding: 8px;
            font-size: 9px;
            white-space: pre-wrap;
            line-height: 1.2;
        }

        .signature-table {
            margin-top: 24px;
        }

        .signature-table td {
            border: none !important;
            text-align: center;
            font-size: 9px;
            vertical-align: top;
        }

        .signature-name {
            width: 170px;
            margin: 28px auto 0;
            text-align: center;
            min-height: 12px;
            font-size: 9px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 170px;
            margin: 2px auto 0;
            height: 4px;
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
        .signature-label {
            font-size: 7px;
            margin-top: 2px;
        }
    </style>
</head>

<body>
@php
    function wbDownloadJson($value) {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    function wbDownloadFlatten($array) {
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

    function wbDownloadVal($array, $index, $default = '') {
        return isset($array[$index]) && $array[$index] !== null && $array[$index] !== ''
            ? $array[$index]
            : $default;
    }

    function wbDownloadDate($value) {
        if (empty($value)) {
            return '';
        }

        try {
            return \Carbon\Carbon::parse($value)->format('m/d/Y');
        } catch (\Exception $e) {
            return $value;
        }
    }

    $labCodes = wbDownloadJson($rla->laboratory_code ?? null);
    $firstLabCode = $labCodes[0] ?? '';

    $sampleDescriptions = wbDownloadJson($rla->sample_description ?? null);
    $firstSampleDescription = $sampleDescriptions[0] ?? '';

    $analysisRequested = wbDownloadFlatten(wbDownloadJson($rla->analysis_requested ?? null));

    $testName = wbDownloadJson($worksheet->test_name ?? null);

    $d100r1 = wbDownloadJson($worksheet->dilution_100_r1 ?? null);
    $d100r2 = wbDownloadJson($worksheet->dilution_100_r2 ?? null);

    $d101r1 = wbDownloadJson($worksheet->dilution_101_r1 ?? null);
    $d101r2 = wbDownloadJson($worksheet->dilution_101_r2 ?? null);

    $d102r1 = wbDownloadJson($worksheet->dilution_102_r1 ?? null);
    $d102r2 = wbDownloadJson($worksheet->dilution_102_r2 ?? null);

    $d103r1 = wbDownloadJson($worksheet->dilution_103_r1 ?? null);
    $d103r2 = wbDownloadJson($worksheet->dilution_103_r2 ?? null);

    $results = wbDownloadJson($worksheet->results ?? null);

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

    $rlaNo = $worksheet->rla_no ?? $rla->RLA_no ?? '';
    $labCode = $worksheet->lab_code ?? $firstLabCode;
    $sampleType = $worksheet->sample_type ?? $firstSampleDescription;

    $dateStarted = wbDownloadDate($worksheet->date_started ?? '');
    $dateFinished = wbDownloadDate($worksheet->date_finished ?? '');
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
    <span class="sample-line">{{ $sampleType }}</span>
</div>

{{-- MAIN TABLE --}}
<table class="main-table">
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
        <td colspan="2" class="info-cell">
            <b>RLA No.:</b>
            <span style="margin-left:35px;">{{ $rlaNo }}</span>
        </td>

        <td colspan="2" class="info-cell">
            <b>Lab Code:</b>
            <span style="margin-left:30px;">{{ $labCode }}</span>
        </td>

        <td colspan="3" class="info-cell">
            <b>Date Started:</b>
            <span style="margin-left:25px;">{{ $dateStarted }}</span>
        </td>

        <td colspan="3" class="info-cell">
            <b>Date Finished:</b>
            <span style="margin-left:25px;">{{ $dateFinished }}</span>
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
            $printTestName = wbDownloadVal($testName, $i, $defaultTestName);
        @endphp

        <tr>
            <td class="test-col">{{ $printTestName }}</td>
            <td>{{ wbDownloadVal($d100r1, $i) }}</td>
            <td>{{ wbDownloadVal($d100r2, $i) }}</td>
            <td>{{ wbDownloadVal($d101r1, $i) }}</td>
            <td>{{ wbDownloadVal($d101r2, $i) }}</td>
            <td>{{ wbDownloadVal($d102r1, $i) }}</td>
            <td>{{ wbDownloadVal($d102r2, $i) }}</td>
            <td>{{ wbDownloadVal($d103r1, $i) }}</td>
            <td>{{ wbDownloadVal($d103r2, $i) }}</td>
            <td>{{ wbDownloadVal($results, $i) }}</td>
        </tr>
    @endfor
</table>

{{-- CONTROLS --}}
<div class="controls-area">
    <div>
        Batch No. of Prepared Culture Media:
        <span class="line">{{ $worksheet->batch_no_prepared_culture_media ?? '' }}</span>

        &nbsp;&nbsp;
        Air Control (15 m exposure):
        <span class="line">{{ $worksheet->air_control ?? '' }}</span>
    </div>

    <div>
        Medium Control (TCBS):
        <span class="line">{{ $worksheet->medium_control_tcbs ?? '' }}</span>

        &nbsp;&nbsp;
        Diluent (Sterile Sea Water):
        <span class="line">{{ $worksheet->diluent_sterile_sea_water ?? '' }}</span>
    </div>
</div>

{{-- CALCULATIONS --}}
<div class="calculations-box">
    <div class="calculations-title">CALCULATIONS</div>
    <div class="calculations-content">
        {{ $worksheet->calculations ?? '' }}
    </div>
</div>

{{-- SIGNATURE --}}
<table class="signature-table">
    <tr>
        <td style="width:50%;">
            Analyzed by:

            <div class="signature-name">
                {{ $worksheet->analyzed_by ?? '' }}
            </div>
            <div class="signature-line"></div>
            <div class="signature-label">Name of Analyst and Signature</div>
        </td>

        <td style="width:50%;">
            Checked by:

            <div class="signature-name">
                {{ $worksheet->checked_by ?? '' }}
            </div>
            <div class="signature-line"></div>
            <div class="signature-label">Name of Analyst and Signature</div>
        </td>
    </tr>
</table>

</body>
</html>