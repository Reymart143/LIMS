<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            size: A4 landscape;
            margin: 5mm;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 8px;
            color: #000;
        }

        .sheet {
            width: 100%;
            border: 2px solid #007a78;
            padding: 3px;
            page-break-inside: avoid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        td, th {
            border: 1px solid #007a78;
            padding: 1px 2px;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .bordered td { border: 1px solid #007a78; }

        .official-header {
            width: auto !important;
            table-layout: auto !important;
            margin-bottom: 3px;
        }

        .official-header td { border: 1px solid #007a78; }

        .official-logo {
            width: 95px;
            text-align: center;
            vertical-align: middle;
            padding: 4px;
        }

        .official-logo img {
            width: 55px;
            height: auto;
        }

        .official-title {
            width: 970px;
            vertical-align: middle;
            padding: 4px 6px;
            text-align: left;
            line-height: 1.12;
        }

        .official-title .normal { font-size: 8px; }
        .official-title .big {
            font-size: 9px;
            font-weight: bold;
        }

        .section-title {
            text-align: center;
            font-weight: bold;
            font-size: 8px;
            line-height: 1.1;
        }

        .doc-info {
            font-size: 8px;
            margin-bottom: 2px;
        }

        .doc-info td {
            padding: 2px 3px;
            line-height: 1.1;
        }

        .micro-table {
            border: 1px solid #007a78;
            margin-top: 2px;
            font-size: 7.4px;
        }

        .micro-table td {
            padding: 0.45px 1px;
            line-height: 1;
        }

        .teal-head {
            background: #007a78;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        .light-cell { background: #f3ffff; }

        .top-info {
            font-size: 8px;
            font-weight: bold;
            line-height: 1.15;
        }

        .line {
            display: inline-block;
            border-bottom: 1px solid #777;
            min-width: 50px;
            min-height: 7px;
            padding-left: 2px;
            font-weight: normal;
        }

        .line-wide { min-width: 85px; }

        .test-name {
            font-weight: bold;
            background: #f3ffff;
            font-size: 7px;
            line-height: 1.05;
        }

        .italic { font-style: italic; }
        .center { text-align: center; }
        .bold { font-weight: bold; }

        .tiny {
            font-size: 5.6px;
            text-align: center;
            font-weight: bold;
        }

        .dilution {
            font-size: 7.6px;
            font-weight: bold;
            text-align: center;
        }

        .sub-dilution {
            font-size: 5.8px;
            text-align: center;
            font-weight: bold;
        }

        .result-cell {
            font-size: 8.5px;
            font-weight: bold;
            text-align: center;
            background: #dffdfa !important;
            white-space: normal !important;
            border-left: 2px solid #007a78 !important;
            padding: 2px 4px !important;
            overflow: hidden !important;
            line-height: 1.05;
        }

        .result-line {
            display: inline-block;
            border-bottom: 1.5px solid #000;
            width: 70px;
            min-height: 9px;
            vertical-align: bottom;
            text-align: center;
            font-weight: bold;
        }

        .result-unit {
            font-size: 7.2px;
            font-weight: bold;
            white-space: normal;
            display: inline-block;
            max-width: 100%;
        }

        .separator td {
            height: 4px;
            padding: 0 !important;
            background: #d5c9df;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .blank {
            height: 5px;
            padding: 0 !important;
        }

        .salmonella-row td {
            height: 6px;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .qc-table {
            margin-top: 2px;
            font-size: 7px;
        }

        .qc-table td {
            padding: 1px 2px;
            line-height: 1.08;
        }

        .qc-title {
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            padding: 2px !important;
        }

        .qc-subheader td {
            background: #e5e0ec;
            font-weight: bold;
            text-align: center;
        }

        .page-break { page-break-before: always; }

        .formula-page {
            width: 100%;
            border: 2px solid #007a78;
            padding: 8px;
        }

        .formula-title {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 8px;
        }

        .formula-box {
            border: 1px solid #007a78;
            min-height: 620px;
            padding: 8px;
            font-size: 10px;
            line-height: 1.4;
            white-space: pre-wrap;
        }
    </style>
</head>

<body>
@php
    $dateStarted = $worksheet->date_started ?? '';
    $timeStarted = $worksheet->time_started ?? '';
    $dateFinish = $worksheet->date_finish ?? '';
    $timeFinish = $worksheet->time_finish ?? '';

    if ($timeStarted) {
        $timeStarted = \Carbon\Carbon::parse($timeStarted)->format('H:i');
    }

    if ($timeFinish) {
        $timeFinish = \Carbon\Carbon::parse($timeFinish)->format('H:i');
    }

    $formula = $worksheet->formula ?? '';
@endphp

<div class="sheet">

    <table class="official-header">
        <tr>
            <td class="official-logo">
                <img src="{{ public_path('assets/images/bfarlogo.png') }}" alt="Logo">
            </td>

            <td class="official-title">
                <div class="normal">Republic of the Philippines</div>
                <div class="normal">Department of Agriculture</div>
                <div class="big">BUREAU OF FISHERIES AND AQUATIC RESOURCES</div>
                <div class="big">REGIONAL FISHERIES LABORATORY XII</div>
                <div class="normal">J. Catolico St., Lagao, General Santos City</div>
            </td>
        </tr>
    </table>

    <table class="bordered doc-info">
        <colgroup>
            <col style="width:25%;">
            <col style="width:25%;">
            <col style="width:25%;">
            <col style="width:25%;">
        </colgroup>
        <tr>
            <td>Document Type<br><strong>Laboratory Form</strong></td>
            <td>Revision No:<br>0</td>
            <td>Date Adopted:<br>13 Aug 2019</td>
            <td>Page No:<br>Page 1 of 2</td>
        </tr>
        <tr>
            <td>Document Code:<br><strong>LF-W01-MIC-03</strong></td>
            <td colspan="3" class="section-title">
                ANALYST WORKSHEET FOR BACTERIOLOGICAL EXAMINATION OF FISH AND FISHERY PRODUCTS
            </td>
        </tr>
    </table>

    <table class="micro-table">
        <colgroup>
            <col style="width:11%;">
            <col span="12" style="width:5.333%;">
            <col style="width:25%;">
        </colgroup>

        <tr>
            <td class="top-info light-cell">
                RLA No.:<br>
                <span class="line">{{ $worksheet->RLA_no ?? $rla->RLA_no ?? '' }}</span>
            </td>

            <td colspan="4" class="top-info light-cell">
                Lab Code:<br>
                <span class="line line-wide">{{ $worksheet->laboratory_code ?? $firstLabCode ?? '' }}</span>
            </td>

            <td colspan="5" class="top-info light-cell">
                Date Started: <span class="line">{{ $dateStarted }}</span><br>
                Time Started: <span class="line">{{ $timeStarted }}</span>
            </td>

            <td colspan="4" class="top-info light-cell">
                Date Finished: <span class="line">{{ $dateFinish }}</span><br>
                Time Finished: <span class="line">{{ $timeFinish }}</span>
            </td>
        </tr>

        <tr>
            <td rowspan="2" class="teal-head">TESTS</td>
            <td colspan="12" class="teal-head">DILUTIONS</td>
            <td rowspan="2" class="teal-head">RESULTS</td>
        </tr>

        <tr>
            <td colspan="2" class="teal-head dilution">10<sup>-1</sup></td>
            <td colspan="2" class="teal-head dilution">10<sup>-2</sup></td>
            <td colspan="2" class="teal-head dilution">10<sup>-3</sup></td>
            <td colspan="2" class="teal-head dilution">10<sup>-4</sup></td>
            <td colspan="2" class="teal-head dilution">10<sup>-5</sup></td>
            <td colspan="2" class="teal-head dilution">10<sup>-6</sup></td>
        </tr>

        <tr>
            <td class="test-name">Aerobic Plate Count</td>
            @for($i = 1; $i <= 6; $i++)
                <td class="sub-dilution">R1</td>
                <td class="sub-dilution">R2</td>
            @endfor
            <td class="result-cell">
                <span class="result-line">{{ $worksheet->aerobic_plate_count_result ?? '' }}</span>
                <span class="result-unit">cfu/g</span>
            </td>
        </tr>

        <tr class="separator"><td colspan="14"></td></tr>

        <tr>
            <td class="light-cell"></td>
            <td colspan="12" class="teal-head">NO. OF + REPLICATES</td>
            <td class="light-cell"></td>
        </tr>

        <tr>
            <td class="light-cell"></td>
            <td colspan="4" class="dilution">10<sup>-1</sup> (0.1)</td>
            <td colspan="4" class="dilution">10<sup>-2</sup> (0.01)</td>
            <td colspan="4" class="dilution">10<sup>-3</sup> (0.001)</td>
            <td class="light-cell"></td>
        </tr>

        <tr>
            <td class="light-cell"></td>
            <td colspan="4">LST Broth:</td>
            <td colspan="4">LST Broth:</td>
            <td colspan="4">LST Broth:</td>
            <td class="light-cell"></td>
        </tr>

        <tr>
            <td class="test-name">Total Coliform Count</td>
            <td colspan="4">BGLB Broth:</td>
            <td colspan="4">BGLB Broth:</td>
            <td colspan="4">BGLB Broth:</td>
            <td class="result-cell">
                <span class="result-line">{{ $worksheet->total_col_count_result ?? '' }}</span>
                <span class="result-unit">MPN/g</span>
            </td>
        </tr>

        <tr>
            <td class="test-name">Fecal Coliform Count</td>
            <td colspan="4">EC Broth:</td>
            <td colspan="4">EC Broth:</td>
            <td colspan="4">EC Broth:</td>
            <td class="result-cell">
                <span class="result-line">{{ $worksheet->fecal_col_count_result ?? '' }}</span>
                <span class="result-unit">MPN/g</span>
            </td>
        </tr>

        <tr>
            <td class="test-name italic">Escherichia coli Count</td>
            <td colspan="4">L-EMB Agar:<br>Confirmed Tests:</td>
            <td colspan="4">L-EMB Agar:<br>Confirmed Tests:</td>
            <td colspan="4">L-EMB Agar:<br>Confirmed Tests:</td>
            <td class="result-cell">
                <span class="result-line">{{ $worksheet->esc_coli_count_result ?? '' }}</span>
                <span class="result-unit">MPN/g</span>
            </td>
        </tr>

        <tr class="separator"><td colspan="14"></td></tr>

        <tr>
            <td rowspan="3" class="test-name italic">Staphylococcus aureus Count</td>
            <td colspan="4" class="teal-head dilution">10<sup>-1</sup></td>
            <td colspan="4" class="teal-head dilution">10<sup>-2</sup></td>
            <td colspan="4" class="teal-head dilution">10<sup>-3</sup></td>
            <td rowspan="3" class="result-cell">
                <span class="result-line">{{ $worksheet->staphy_aureus_count_result ?? '' }}</span>
                <span class="result-unit">cfu/g</span>
            </td>
        </tr>

        <tr>
            @for($i = 1; $i <= 3; $i++)
                <td class="tiny">R1 0.3 ml</td>
                <td class="tiny">R2 0.3 ml</td>
                <td colspan="2" class="tiny">R3 0.4 ml</td>
            @endfor
        </tr>

        <tr>
            @for($i = 1; $i <= 3; $i++)
                <td colspan="2" class="tiny">Coagulase Test</td>
                <td colspan="2" class="tiny">Catalase Test</td>
            @endfor
        </tr>

        <tr class="separator"><td colspan="14"></td></tr>

        <tr>
            <td rowspan="6" class="test-name italic">Salmonella sp.</td>
            <td colspan="2">pH:</td>
            <td colspan="10" class="center">
                Incubation at Room Temperature: &nbsp; Time Started: &nbsp; Time Ended:
            </td>
            <td rowspan="6" class="result-cell">
                <span class="result-line">{{ $worksheet->salmonella_result ?? '' }}</span><br><span class="result-unit">per 25 g sample</span>
            </td>
        </tr>

        <tr class="salmonella-row">
            <td colspan="2">Isolation</td>
            <td colspan="5" class="bold center">RV Medium</td>
            <td colspan="5" class="bold center">TT Broth</td>
        </tr>

        <tr class="salmonella-row">
            <td colspan="2"></td>
            <td class="center">BS Agar</td>
            <td colspan="2" class="center">XLD Agar</td>
            <td colspan="2" class="center">HE Agar</td>
            <td class="center">BS Agar</td>
            <td colspan="2" class="center">XLD Agar</td>
            <td colspan="2" class="center">HE Agar</td>
        </tr>

        <tr>
            <td colspan="2">TSI Agar Slant<br>TSI Agar Butt</td>
            <td colspan="10" class="blank"></td>
        </tr>

        <tr>
            <td colspan="2">LIA Butt</td>
            <td colspan="10" class="blank"></td>
        </tr>

        <tr>
            <td colspan="2">Biochemical<br>Tests / API</td>
            <td colspan="10" class="blank"></td>
        </tr>

        <tr class="separator"><td colspan="14"></td></tr>

        <tr>
            <td rowspan="2" class="test-name italic">Shigella sp.</td>
            <td colspan="3">Isolation: McConkey Agar<br>Plate</td>
            <td colspan="9" class="blank"></td>
            <td rowspan="2" class="result-cell">
                <span class="result-line">{{ $worksheet->shigella_result ?? '' }}</span><br><span class="result-unit">per 25 g sample</span>
            </td>
        </tr>

        <tr>
            <td colspan="3">Biochemical Tests / API</td>
            <td colspan="9" class="blank"></td>
        </tr>
    </table>

    <table class="micro-table qc-table">
        <colgroup>
            <col style="width:25%;">
            <col style="width:19%;">
            <col style="width:27%;">
            <col style="width:29%;">
        </colgroup>

        <tr>
            <td colspan="4" class="qc-title">QC RESULTS</td>
        </tr>

        <tr class="qc-subheader">
            <td>Tests</td>
            <td>QC Checks</td>
            <td>Negative Control</td>
            <td>Positive Control</td>
        </tr>

        <tr>
            <td>Aerobic Plate Count</td>
            <td>PCA</td>
            <td></td>
            <td>white colonies</td>
        </tr>

        <tr>
            <td>Presumptive Tests for TC, FC, EC</td>
            <td>LST Broth</td>
            <td></td>
            <td>with gas production, turbid with effervescence</td>
        </tr>

        <tr>
            <td>Total Coliform</td>
            <td>BGLB</td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td>Fecal Coliform</td>
            <td>EC Broth</td>
            <td></td>
            <td>with gas production, turbid with effervescence</td>
        </tr>

        <tr>
            <td class="italic">E. coli</td>
            <td>
                EMB Agar<br>
                Gram Reaction<br>
                TB / Indole Test<br>
                Voges Proskauer<br>
                Methyl Red<br>
                SCA / KCB / Citrate Utilization<br>
                Gas Production
            </td>
            <td></td>
            <td>
                &#9744; greenish metallic sheen<br>
                &#9744; gram (-)<br>
                &#9744; red color<br>
                &#9744; red color<br>
                &#9744; yellow color (-)<br>
                &#9744; no color change<br>
                &#9744; with gas production
            </td>
        </tr>

        <tr>
            <td class="italic">Staphylococcus aureus</td>
            <td></td>
            <td><em>E. coli</em> - inhibition</td>
            <td></td>
        </tr>

        <tr>
            <td class="italic">Salmonella sp.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td class="italic">Shigella sp.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>

<div class="page-break"></div>

<div class="formula-page">
    <div class="formula-title">Formula / Computation</div>
    <div class="formula-box">{!! nl2br(e($formula)) !!}</div>
</div>

</body>
</html>
