{{-- resources/views/ReportTest/meat.blade.php --}}

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 25px 26px;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            color: #000;
        }

        .header {
            text-align: center;
            line-height: 1.1;
            position: relative;
            min-height: 125px;
        }

        .logo-left {
            position: absolute;
            left: 35px;
            top: 0;
            width: 105px;
            height: 80px;
            object-fit: contain;
        }

        .bold {
            font-weight: bold;
        }

        .report-title {
            text-align: center;
            font-weight: bold;
            font-size: 17px;
            margin-top: 2px;
        }

        .report-no {
            text-align: center;
            font-size: 13px;
            margin-top: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .info {
            margin-top: 5px;
        }

        .info td {
            border-top: 1px solid #000;
            padding: 2px 5px;
            font-weight: bold;
        }

        .result-table {
            margin-top: 18px;
        }

        .result-table th,
        .result-table td {
            border: 1px solid #000;
            padding: 3px 4px;
            text-align: center;
            vertical-align: middle;
        }

        .result-table th {
            font-weight: bold;
        }

        .result-table td {
            height: 14px;
        }

        .left {
            text-align: left !important;
        }

        .remarks {
            margin-top: 12px;
            line-height: 1.1;
        }

        .watermark {
            position: fixed;
            top: 400px;
            left: 95px;
            font-size: 70px;
            color: #777;
            opacity: 0.12;
            z-index: -1;
            letter-spacing: 5px;
        }

        .conditions {
            margin-top: 5px;
            font-weight: bold;
        }

        .standard-table {
            margin-top: 10px;
        }

        .standard-table th,
        .standard-table td {
            border: 1px solid #000;
            padding: 3px 6px;
            vertical-align: middle;
        }

        .standard-table th {
            text-align: left;
            font-weight: bold;
        }

        .signatories {
            margin-top: 18px;
        }

        .signatories td {
            width: 33.33%;
            vertical-align: top;
            padding: 0 10px;
        }

        .name {
            font-weight: bold;
            margin-top: 25px;
        }

        .footer-line {
            border-top: 1px solid #000;
            margin: 28px 35px 5px;
        }

        .footer {
            font-size: 10px;
            color: #555;
            line-height: 1.1;
        }

        .footer ul {
            margin-top: 0;
            margin-bottom: 0;
        }

        .seal {
            font-style: italic;
            font-size: 11px;
            color: #555;
            width: 120px;
        }

        .bottom-code {
            font-size: 11px;
            color: #555;
        }

        .page {
            text-align: right;
            font-size: 13px;
            letter-spacing: 3px;
        }

        .italic {
            font-style: italic;
        }
    </style>
</head>

<body>

@php
    use Carbon\Carbon;

    $dateCollected = !empty($rla->date_collected)
        ? Carbon::parse($rla->date_collected)->format('F d, Y')
        : '';

    $dateReceived = !empty($rla->date_received)
        ? Carbon::parse($rla->date_received)->format('F d, Y')
        : '';

    $dateIssue = now()->format('F d, Y');
@endphp

<div class="watermark">DRAFT COPY</div>

<div class="header">
    <img src="{{ public_path('assets/images/bfarlogo.png') }}" class="logo-left">

    <div>Republic of the Philippines</div>
    <div>Department of Agriculture</div>
    <div class="bold">BUREAU OF FISHERIES AND AQUATIC RESOURCES</div>
    <div class="bold">REGIONAL FISHERIES LABORATORY XII</div>
    <div>J. Catolico St., Lagao, General Santos City</div>
    <div>Contact No: 09686421148 / Email Address: bfar12rfl@gmail.com</div>

    <div class="report-title">REPORT OF TEST</div>
    <div class="report-no">No.: {{ $reportNo ?? '' }}</div>
</div>

<table class="info">
    <tr>
        <td colspan="2">Customer: {{ $rla->company_name ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="2">Address of Customer: {{ $rla->address ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="2">Contact Number and/or Email Address: {{ $rla->contact_no ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="2">Source of Sample: {{ $rla->source_sample ?? '' }}</td>
    </tr>
    <tr>
        <td style="width:58%;">Date Collected: {{ $dateCollected }}</td>
        <td>Date of Test:</td>
    </tr>
    <tr>
        <td>Date of Receipt: {{ $dateReceived }}</td>
        <td>Date of Issue: {{ $dateIssue }}</td>
    </tr>
</table>

<table class="result-table">
    <thead>
        <tr>
            <th rowspan="2" style="width:95px;">Laboratory<br>Codes</th>
            <th rowspan="2" style="width:70px;">Sample<br>Codes</th>
            <th rowspan="2" style="width:95px;">Sample Type</th>
            <th colspan="5">Results</th>
        </tr>
        <tr>
            <th style="width:55px;">APC<br>cfu/g</th>
            <th style="width:55px;"><em>E. Coli</em><br>MPN/g</th>
            <th style="width:65px;"><em>S. aureus</em><br>cfu/g</th>
            <th style="width:95px;"><em>Salmonella</em><br><em>(Absent in 25g)</em></th>
            <th style="width:80px;"><em>Shigella</em><br><em>(Absent in 25g)</em></th>
        </tr>
    </thead>

    <tbody>
        @for ($i = 0; $i < 5; $i++)
            <tr>
                <td class="bold">{{ $laboratoryCodes[$i] ?? '' }}</td>
                <td>{{ $sampleCodes[$i] ?? '' }}</td>
                <td>{{ $sampleDescriptions[$i] ?? '' }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endfor
    </tbody>
</table>

<div class="remarks">
    <strong>REMARKS:</strong>
    {{ $rla->remarks ?? 'Result is based on sample submitted.' }}<br>
    <span style="margin-left:55px;">
        The laboratory is having not been responsible for the sampling stage of the submitted sample.
    </span><br>
    <span style="margin-left:55px;">
        No part of this report may be reproduced nor transmitted without the written permission of the Laboratory Manager.
    </span><br>
    <span style="margin-left:55px;">
        This report shall not be used for advertisement.
    </span>

    <span style="float:right; font-weight:bold;">
        *EAPC - Estimated Aerobic Plate Count
    </span>
</div>

<div class="conditions">
    Environmental Conditions of the laboratory:<br>
    Temperature: 20-25 ºC
    <span style="margin-left:190px;">Relative Humidity: ≤ 50%</span>
</div>

<table class="standard-table">
    <thead>
        <tr>
            <th style="width:145px;">TEST</th>
            <th style="width:140px;">METHOD</th>
            <th style="width:95px;">STANDARD<br>LIMITS</th>
            <th>REFERENCE</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td class="bold">Aerobic Plate Count (APC)</td>
            <td class="bold">Pour Plate Method</td>
            <td class="bold"><em>500,000 g</em></td>
            <td rowspan="5" class="bold">
                FAO No. 210 Series 2001,ICMSF,<br>
                1986<br>
                FAO No. 195 Series 1999
            </td>
        </tr>
        <tr>
            <td><em>E.coli</em></td>
            <td class="bold">Multiple Tube Method</td>
            <td class="bold"><em>11/g</em></td>
        </tr>
        <tr>
            <td><em>Staphylococcus aureus</em></td>
            <td class="bold">Conventional Method</td>
            <td class="bold"><em>1000/g</em></td>
        </tr>
        <tr>
            <td><em>Salmonella</em></td>
            <td class="bold">Conventional Method</td>
            <td class="bold">Absent</td>
        </tr>
        <tr>
            <td><em>Shigella</em></td>
            <td class="bold">Conventional Method</td>
            <td class="bold">Absent</td>
        </tr>
    </tbody>
</table>

<table class="signatories">
    <tr>
        <td>
            <strong>Analyzed by:</strong>
            <div class="name">CHARISSE ZIANNE N. LIBRES</div>
            Analyst
        </td>

        <td>
            <strong>Certified by:</strong>
            <div class="name">MA. MAURICE A. BANQUILING</div>
            Quality Assurance Manager
        </td>

        <td>
            <strong>Approved by:</strong>
            <div class="name">EUGENE GAY B. JAMORA</div>
            Laboratory Manager
        </td>
    </tr>
</table>

<div class="footer-line"></div>
<div class="footer-line" style="margin-top:4px;"></div>

<table class="footer">
    <tr>
        <td class="seal">
            Not valid without<br>
            the official dry seal
        </td>

        <td>
            <ul>
                <li>The results of test have traceability to the national and/or international standards.</li>
                <li>This Report of Test may not be reproduced other than full, except with the prior written approval of both the Bureau of Fisheries and Aquatic Resources and the issuing Regional Fisheries Laboratory.</li>
                <li>Report of Test without seal and signature are not valid. A copy of this report of test will be kept at the issuing laboratory for five years. The results concern only the test items.</li>
            </ul>
        </td>
    </tr>
</table>

<table style="margin-top:4px;">
    <tr>
        <td class="bottom-code">
            LF 08-01-04 Rev. No.: 0 Effectivity Date: 13 August 2019
        </td>
        <td class="page">
            Page 1 of 1
        </td>
    </tr>
</table>

</body>
</html>