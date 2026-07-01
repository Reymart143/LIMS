<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 25px 28px;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 13px;
            color: #000;
        }

        .header {
            text-align: center;
            line-height: 1.15;
            position: relative;
        }

        .logo-left {
            position: absolute;
            left: 40px;
            top: 0;
            width: 85px;
        }

        .logo-right {
            position: absolute;
            left: 35px;
            top: 0;
            width: 85px;
        }

        .bold {
            font-weight: bold;
        }

        .report-title {
            text-align: center;
            font-weight: bold;
            font-size: 20px;
            margin-top: 8px;
        }

        .report-no {
            text-align: center;
            font-size: 14px;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .info td {
            border-top: 1px solid #000;
            padding: 3px 6px;
            font-weight: bold;
            vertical-align: top;
        }

        .result-table th,
        .result-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }

        .result-table th {
            font-weight: bold;
        }

        .result-table th:nth-child(1),
        .result-table td:nth-child(1) {
            width: 5%;
        }

        .result-table th:nth-child(2),
        .result-table td:nth-child(2) {
            width: 22%;
        }

        .result-table th:nth-child(3),
        .result-table td:nth-child(3) {
            width: 22%;
        }

        .result-table th:nth-child(4),
        .result-table td:nth-child(4) {
            width: 28%;
        }

        .result-table th:nth-child(5),
        .result-table td:nth-child(5) {
            width: 23%;
        }

        .remarks {
            margin-top: 12px;
            line-height: 1.2;
        }

        .watermark {
            position: fixed;
            top: 380px;
            left: 50px;
            font-size: 70px;
            color: #999;
            opacity: 0.12;
            z-index: -1;
        }

        .standard-table th,
        .standard-table td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
        }

        .standard-table th {
            text-align: center;
        }

        .signatories td {
            width: 33%;
            padding-top: 25px;
            vertical-align: top;
        }

        .name {
            font-weight: bold;
            margin-top: 20px;
        }

        .footer {
            font-size: 11px;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

@php
    use Carbon\Carbon;

    $samples = $samples ?? [];

    if (count($samples) < 1) {
        $samples = [
            [
                'lab_code' => '',
                'sample_code' => '',
                'sample_type' => '',
            ]
        ];
    }
@endphp

<div class="watermark">DRAFT COPY</div>

<div class="header">
    <img src="{{ public_path('assets/images/bfarlogo.png') }}" class="logo-right">

    <div>Republic of the Philippines</div>
    <div>Department of Agriculture</div>
    <div class="bold">BUREAU OF FISHERIES AND AQUATIC RESOURCES</div>
    <div class="bold">REGIONAL FISHERIES LABORATORY XII</div>
    <div>J. Catolico St., Lagao, General Santos City</div>
    <div>Contact No: 09686421148 / Email Address: bfar12rfl@gmail.com</div>
</div>

<div class="report-title">REPORT OF TEST</div>
<div class="report-no">No.: {{ $reportNo ?? '' }}</div>

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
        <td>
            Date Collected:
            {{ !empty($rla->date_collected) ? Carbon::parse($rla->date_collected)->format('F d, Y') : '' }}
        </td>

        <td>
            Date of Test:
        </td>
    </tr>

    <tr>
        <td>
            Date of Receipt:
            {{ !empty($rla->date_received) ? Carbon::parse($rla->date_received)->format('F d, Y') : '' }}
        </td>

        <td>
            Date of Issue:
            {{ now()->format('F d, Y') }}
        </td>
    </tr>
</table>

<table class="result-table" style="margin-top:10px;">
    <thead>
        <tr>
            <th rowspan="2">#</th>
            <th rowspan="2">LABORATORY CODE(S)</th>
            <th rowspan="2">SAMPLE CODE(S)</th>
            <th rowspan="2">SAMPLE TYPE</th>
            <th>RESULTS</th>
        </tr>

        <tr>
            <th><em>Histamine (ppm)</em></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($samples as $i => $sample)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $sample['lab_code'] ?? '' }}</td>
                <td>{{ $sample['sample_code'] ?? '' }}</td>
                <td>{{ $sample['sample_type'] ?? '' }}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="remarks">
    <strong>REMARKS:</strong>
    {{ $rla->remarks ?? 'Result is based on sample submitted.' }}<br>

    <span style="margin-left:55px;">
        The laboratory is not responsible for the sampling stage of the submitted sample.
    </span><br>

    <span style="margin-left:55px;">
        No part of this report may be reproduced without written permission.
    </span><br>

    <span style="margin-left:55px;">
        This report shall not be used for advertisement.
    </span>
</div>

<div style="margin-top:10px;">
    ND-Not Detected, &nbsp;&nbsp; N/A- Not Applicable
</div>

<div style="margin-top:5px;">
    Environmental Conditions of the laboratory:<br>
    Temperature: 23 ± 3 ºC &nbsp;&nbsp;
    Relative Humidity: 50 ± 15 %
</div>

<table class="standard-table" style="margin-top:8px;">
    <thead>
        <tr>
            <th>TEST</th>
            <th>METHOD</th>
            <th>Standard Limits</th>
            <th>Reference</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td rowspan="4">Histamine</td>
            <td rowspan="4">AOAC Fluorometric</td>
            <td><em>US- 50ppm</em></td>
            <td>USFDA Revised Compliance Policy Guide 7108.24/1995</td>
        </tr>

        <tr>
            <td><em>EU- 100ppm</em></td>
            <td>EC No. 2073/2005</td>
        </tr>

        <tr>
            <td><em>Canada- 100ppm</em></td>
            <td>Canadian Guidelines for Chemical Contaminants...</td>
        </tr>

        <tr>
            <td><em>Other countries- 200ppm</em></td>
            <td>Codex Alimentarius Standard...</td>
        </tr>
    </tbody>
</table>

<table class="signatories">
    <tr>
        <td>
            Analyzed by:
            <div class="name">JUMADAN S. HADJARANI</div>
            Analyst<br>
            License No. 0014436
        </td>

        <td>
            Certified by:
            <div class="name">MA. MAURICE A. BANQUILING</div>
            QA Manager<br>
            License No. 0011748
        </td>

        <td>
            Approved by:
            <div class="name">EUGENE GAY B. JAMORA</div>
            Laboratory Manager
        </td>
    </tr>
</table>

<hr>

<div class="footer">
    Not valid without official dry seal<br><br>

    • The results of test have traceability to national/international standards.<br>
    • This report shall not be reproduced except in full.<br>
    • Valid for 5 years. Applies only to tested items.
</div>

<div style="margin-top:5px; font-size:10px;">
    LF 08-01-01 Rev. No.: 0 Effectivity Date: 13 August 2019
</div>

<div style="text-align:right; font-size:11px;">
    Page 1 of 1
</div>

</body>
</html>