{{-- resources/views/ReportTestFis/paragrossdownload.blade.php --}}

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 24px 30px;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 14px;
            color: #000;
        }

        .header {
            text-align: center;
            line-height: 1.15;
            position: relative;
            min-height: 130px;
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
            font-weight: bold;
            font-size: 20px;
            margin-top: 6px;
        }

        .report-no {
            font-size: 16px;
            margin-top: 2px;
            font-weight: bold;
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

      .result-table {
            margin-top: 18px;
            table-layout: fixed;
        }

        .result-table th,
        .result-table td {
            border: 1px solid #000;
            padding: 6px 5px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .result-table td {
            height: 24px;
        }

        .result-table td:first-child {
            width: 35px;
        }

        .remarks {
            margin-top: 18px;
            line-height: 1.2;
        }

        .watermark {
            position: fixed;
            top: 370px;
            left: 95px;
            font-size: 70px;
            color: #777;
            opacity: 0.12;
            z-index: -1;
            letter-spacing: 5px;
        }

        .conditions {
            margin-top: 8px;
            line-height: 1.2;
            font-weight: bold;
        }

        .standard-table {
            margin-top: 18px;
            font-size: 13px;
        }

        .standard-table th,
        .standard-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
        }

        .standard-table th {
            text-align: left;
            font-weight: bold;
            font-style: italic;
        }

        .signatories {
            margin-top: 20px;
        }

        .signatories td {
            width: 50%;
            vertical-align: top;
            padding: 0 8px;
        }

        .name {
            font-weight: bold;
            margin-top: 35px;
        }

        .footer-line {
            border-top: 1px solid #000;
            margin: 70px 35px 5px;
        }

        .footer {
            font-size: 13px;
            color: #777;
            line-height: 1.15;
        }

        .footer ul {
            margin-top: 0;
            margin-bottom: 0;
        }

        .seal {
            font-style: italic;
            font-size: 13px;
            color: #777;
            width: 110px;
        }

        .bottom-code {
            font-size: 13px;
            color: #777;
        }

        .page {
            text-align: right;
            font-size: 15px;
            letter-spacing: 3px;
            color: #777;
        }

        tr {
            page-break-inside: avoid;
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

    /*
    |--------------------------------------------------------------------------
    | JSON DECODER
    |--------------------------------------------------------------------------
    */
    $decodeJsonArray = function ($value) {
        if (empty($value)) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        $decoded = json_decode($value, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return [$value];
    };

    $displayValue = function ($value) use (&$displayValue) {
        if (is_array($value)) {
            $flat = [];

            foreach ($value as $item) {
                if (is_array($item)) {
                    $flat[] = $displayValue($item);
                } else {
                    $flat[] = $item;
                }
            }

            return implode(', ', array_filter($flat, function ($item) {
                return trim((string) $item) !== '';
            }));
        }

        return $value ?? '';
    };

    /*
    |--------------------------------------------------------------------------
    | SAMPLE ROWS
    | laboratory_code[index] = sample_code[index] = sample_description[index]
    |--------------------------------------------------------------------------
    */
    if (!isset($samples) || !is_array($samples)) {
        $laboratoryCodes = $laboratoryCodes ?? $decodeJsonArray($rla->laboratory_code ?? null);
        $sampleCodes = $sampleCodes ?? $decodeJsonArray($rla->sample_code ?? null);
        $sampleDescriptions = $sampleDescriptions ?? $decodeJsonArray($rla->sample_description ?? null);

        $rowCount = max(
            count($laboratoryCodes),
            count($sampleCodes),
            count($sampleDescriptions),
            1
        );

        $samples = [];

        for ($i = 0; $i < $rowCount; $i++) {
            $samples[] = [
                'lab_code' => $laboratoryCodes[$i] ?? '',
                'sample_code' => $sampleCodes[$i] ?? '',
                'sample_type' => $sampleDescriptions[$i] ?? '',
            ];
        }
    }

    if (count($samples) < 1) {
        $samples = [
            [
                'lab_code' => '',
                'sample_code' => '',
                'sample_type' => '',
            ]
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK IF PARASITOLOGICAL OR GROSS
    |--------------------------------------------------------------------------
    */
    $currentAnalysis = strtoupper(trim($analysisDescription ?? ''));

    $isParasitological = $currentAnalysis === 'PARASITOLOGICAL EXAMINATION';
    $isGross = $currentAnalysis === 'GROSS EXAMINATION';

    /*
    |--------------------------------------------------------------------------
    | RESULT VALUES
    |
    | Para sa Parasitological:
    | worksheet->results example:
    | {
    |   "RFL12-25-780": {
    |       "endoparasite": "NEGATIVE",
    |       "ectoparasite": "NEGATIVE"
    |   }
    | }
    |
    | Para sa Gross:
    | worksheet->results example:
    | {
    |   "RFL12-25-780": "GOOD AND HEALTHY"
    | }
    |--------------------------------------------------------------------------
    */
    $worksheetResults = [];

    if (!empty($worksheet->results)) {
        $decodedResults = json_decode($worksheet->results, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedResults)) {
            $worksheetResults = $decodedResults;
        }
    }

    $normalizeKey = function ($value) {
        $value = strtoupper(trim((string) $value));
        $value = str_replace(['-', '_', '/', '(', ')'], ' ', $value);
        $value = preg_replace('/\s+/', ' ', $value);

        return trim($value);
    };

    $getParasiteResult = function ($labCode, $type) use ($worksheetResults, $worksheet, $normalizeKey) {
        $typeKey = $normalizeKey($type);

        if (isset($worksheetResults[$labCode]) && is_array($worksheetResults[$labCode])) {
            foreach ($worksheetResults[$labCode] as $key => $value) {
                if ($normalizeKey($key) === $typeKey) {
                    return $value;
                }
            }
        }

        if ($typeKey === 'ENDOPARASITE' && !empty($worksheet->endoparasite)) {
            return $worksheet->endoparasite;
        }

        if ($typeKey === 'ECTOPARASITE' && !empty($worksheet->ectoparasite)) {
            return $worksheet->ectoparasite;
        }

        return '';
    };

    $getGrossResult = function ($labCode) use ($worksheetResults, $worksheet) {
        if (isset($worksheetResults[$labCode])) {
            if (is_array($worksheetResults[$labCode])) {
                return $worksheetResults[$labCode]['result'] ?? '';
            }

            return $worksheetResults[$labCode];
        }

        if (!empty($worksheet->result)) {
            return $worksheet->result;
        }

        return '';
    };
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
        @if ($isParasitological)
            <tr>
                <th rowspan="2" colspan="2" style="width:165px;">
                    LABORATORY<br>CODE(S)
                </th>

                <th rowspan="2" style="width:120px;">
                    SAMPLE<br>CODE(S)
                </th>

                <th rowspan="2" style="width:170px;">
                    SAMPLE TYPE
                </th>

                <th colspan="2">
                    RESULT
                </th>
            </tr>

            <tr>
                <th style="width:115px;">ENDOPARASITE</th>
                <th style="width:115px;">ECTOPARASITE</th>
            </tr>
        @else
            <tr>
                <th colspan="2" style="width:165px;">
                    LABORATORY<br>CODE(S)
                </th>

                <th style="width:150px;">
                    SAMPLE CODE(S)
                </th>

                <th style="width:150px;">
                    SAMPLE TYPE
                </th>

                <th>
                    RESULT
                </th>
            </tr>
        @endif
    </thead>

    <tbody>
        @foreach ($samples as $index => $sample)
            @php
                $labCode = $displayValue($sample['lab_code'] ?? '');
                $sampleCode = $displayValue($sample['sample_code'] ?? '');
                $sampleType = $displayValue($sample['sample_type'] ?? '');
            @endphp

            @if ($isParasitological)
                <tr>
                    <td style="width:35px;" class="bold">
                        {{ $index + 1 }}
                    </td>

                    <td style="width:130px;" class="bold">
                        {{ $labCode }}
                    </td>

                    <td>
                        {{ $sampleCode }}
                    </td>

                    <td>
                        {!! nl2br(e($sampleType)) !!}
                    </td>

                    <td class="bold">
                        {{ $getParasiteResult($labCode, 'endoparasite') }}
                    </td>

                    <td class="bold">
                        {{ $getParasiteResult($labCode, 'ectoparasite') }}
                    </td>
                </tr>
            @else
                <tr>
                    <td style="width:35px;" class="bold">
                        {{ $index + 1 }}
                    </td>

                    <td style="width:130px;" class="bold">
                        {{ $labCode }}
                    </td>

                    <td>
                        {{ $sampleCode }}
                    </td>

                    <td>
                        {!! nl2br(e($sampleType)) !!}
                    </td>

                    <td class="bold">
                        {{ $getGrossResult($labCode) }}
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

<div class="remarks">
    <strong>REMARKS:</strong>
    Test results presented in the report relates only to the sample tested and as received.<br>

    <span style="margin-left:65px;">
        The laboratory is not responsible for the sampling stage of the submitted sample.
    </span><br>

    <span style="margin-left:65px;">
        No part of this report may be reproduced nor transmitted without the written permission of the Laboratory Manager.
    </span><br>

    <span style="margin-left:65px;">
        This report shall not be used for advertisement.
    </span>
</div>

<div class="conditions">
    Environmental Conditions of the laboratory:<br>
    Temperature: 23 ± 3 ºC
    <span style="margin-left:80px;">Relative Humidity: 50 ± 15 %</span>
</div>

<table class="standard-table">
    <thead>
        <tr>
            <th style="width:16%;">TEST</th>
            <th style="width:14%;">METHOD</th>
            <th style="width:14%;">Acceptable<br>Range</th>
            <th>Reference</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>E.U.S</td>
            <td></td>
            <td>
                No gross<br>
                signs
            </td>
            <td rowspan="3">
                Velasquez, C., Fish Parasitology and Aquaculture Management In The Philippines<br><br>
                Edward J. Noga, Fish Disease: Diagnosis and Treatment, 2<sup>nd</sup>. Edition
            </td>
        </tr>

        <tr>
            <td>
                Gross<br>
                Examination
            </td>
            <td>
                Gross<br>
                Morphology
            </td>
            <td>
                Good and<br>
                healthy
            </td>
        </tr>

        <tr>
            <td>
                Parasitological<br>
                Examination
            </td>
            <td>
                Wet mount<br>
                microscopy
            </td>
            <td>
                Negative and<br>
                Positive
            </td>
        </tr>
    </tbody>
</table>

<table class="signatories">
    <tr>
        <td>
            <strong>Analyzed by:</strong>
            <div class="name">MCERRL M. MARU</div>
            Analyst
        </td>

        <td>
            <strong>Certified and Approved by:</strong>
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
            Form No.: LF 08-01-08 Rev. No.:0 Effectivity Date: 06 Jan 2020
        </td>

        <td class="page">
            Page 1 of 1
        </td>
    </tr>
</table>

</body>
</html>