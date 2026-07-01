{{-- resources/views/ReportTestMic/waterpotabilitydownload.blade.php --}}

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 20px 28px;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 11px;
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
            font-weight: bold;
            font-size: 17px;
            margin-top: 4px;
        }

        .report-no {
            font-size: 12px;
            font-weight: bold;
            margin-top: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .info td {
            border-top: 1px solid #000;
            padding: 2px 6px;
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
            padding: 4px 4px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .result-table td {
            height: 22px;
        }

        .watermark {
            position: fixed;
            top: 390px;
            left: 70px;
            font-size: 75px;
            color: #777;
            opacity: 0.12;
            z-index: -1;
            letter-spacing: 5px;
        }

        .remarks {
            margin-top: 10px;
            line-height: 1.15;
        }

        .conditions {
            margin-top: 10px;
            font-weight: bold;
            line-height: 1.15;
        }

        .standard-table {
            margin-top: 12px;
            font-size: 10.5px;
        }

        .standard-table th,
        .standard-table td {
            border: 1px solid #000;
            padding: 4px 5px;
            vertical-align: top;
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
            padding: 0 8px;
        }

        .name {
            font-weight: bold;
            margin-top: 35px;
        }

        .footer-line {
            border-top: 1px solid #000;
            margin: 45px 35px 5px;
        }

        .footer {
            font-size: 9.5px;
            color: #555;
            line-height: 1.1;
        }

        .footer ul {
            margin-top: 0;
            margin-bottom: 0;
        }

        .seal {
            font-style: italic;
            font-size: 9.5px;
            color: #555;
            width: 115px;
        }

        .bottom-code {
            font-size: 9.5px;
            color: #555;
        }

        .page {
            text-align: right;
            font-size: 11px;
            letter-spacing: 3px;
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
        ? Carbon::parse($rla->date_collected)->format('d F Y')
        : '';

    $dateReceived = !empty($rla->date_received)
        ? Carbon::parse($rla->date_received)->format('d F Y')
        : '';

    $dateIssue = now()->format('d F Y');

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

    $flattenArray = function ($items) use (&$flattenArray) {
        $result = [];

        foreach ($items as $item) {
            if (is_array($item)) {
                $result = array_merge($result, $flattenArray($item));
            } else {
                $result[] = $item;
            }
        }

        return $result;
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
    | ANALYSIS REQUESTED
    | Dili fixed. Kung unsay selected sa RLA, mao ra ang result columns.
    |--------------------------------------------------------------------------
    */
    if (!isset($analysisRequested) || !is_array($analysisRequested)) {
        $analysisRequestedRaw = $decodeJsonArray($rla->analysis_requested ?? null);
        $analysisRequestedFlat = $flattenArray($analysisRequestedRaw);

        $analysisRequested = [];

        foreach ($analysisRequestedFlat as $item) {
            if (!empty($item)) {
                $parts = explode(',', $item);

                foreach ($parts as $part) {
                    $value = trim($part);

                    if ($value !== '') {
                        $analysisRequested[] = $value;
                    }
                }
            }
        }

        $analysisRequested = array_values(array_unique($analysisRequested));
    }

    $resultColumnCount = count($analysisRequested);

    /*
    |--------------------------------------------------------------------------
    | NORMALIZE KEY
    |--------------------------------------------------------------------------
    */
    $normalizeKey = function ($value) {
        $value = strtoupper(trim((string) $value));
        $value = str_replace(['.', '_', '-', '/', '(', ')'], ' ', $value);
        $value = preg_replace('/\s+/', ' ', $value);

        return trim($value);
    };

    /*
    |--------------------------------------------------------------------------
    | FORMAT HEADER ONLY
    | Dili ni default/fixed. I-format ra niya kung mao ni ang selected.
    |--------------------------------------------------------------------------
    */
    $formatAnalysisHeader = function ($value) use ($normalizeKey) {
        $key = $normalizeKey($value);

        return match ($key) {
            'HPC', 'HETEROTROPHIC PLATE COUNT' => 'HPC<br><em>cfu/ml</em>',
            'E COLI', 'ECOLI' => '<em>E. coli</em><br>MPN/100 ml',
            'TOTAL COLIFORM' => '<em>Total<br>Coliform</em><br>MPN/100 ml',
            'FECAL COLIFORM', 'FAECAL COLIFORM' => '<em>Fecal<br>Coliform</em><br>MPN/100 ml',
            'ENTEROCOCCI' => '<em>Enterococci</em><br>MPN/100 ml',
            default => e($value),
        };
    };

    /*
    |--------------------------------------------------------------------------
    | OPTIONAL RESULT VALUES
    |
    | Example worksheet->results:
    | {
    |   "RFL12-26-862": {
    |       "HPC": "<1",
    |       "E COLI": "<1.1",
    |       "TOTAL COLIFORM": "<1.1"
    |   }
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

    $getPotabilityResult = function ($labCode, $analysisName) use ($worksheetResults, $worksheet, $normalizeKey) {
        if (isset($worksheetResults[$labCode][$analysisName])) {
            return $worksheetResults[$labCode][$analysisName];
        }

        $targetKey = $normalizeKey($analysisName);

        if (isset($worksheetResults[$labCode]) && is_array($worksheetResults[$labCode])) {
            foreach ($worksheetResults[$labCode] as $key => $value) {
                if ($normalizeKey($key) === $targetKey) {
                    return $value;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Fallback kung column fields ang gamit sa water_potability_worksheets table
        |--------------------------------------------------------------------------
        */
        $possibleFields = [
            'HPC' => ['hpc', 'hpc_result'],
            'HETEROTROPHIC PLATE COUNT' => ['hpc', 'hpc_result'],

            'E COLI' => ['e_coli', 'ecoli', 'e_coli_result', 'ecoli_result'],
            'ECOLI' => ['e_coli', 'ecoli', 'e_coli_result', 'ecoli_result'],

            'TOTAL COLIFORM' => ['total_coliform', 'total_coliform_result'],

            'FECAL COLIFORM' => ['fecal_coliform', 'faecal_coliform', 'fecal_coliform_result'],
            'FAECAL COLIFORM' => ['fecal_coliform', 'faecal_coliform', 'fecal_coliform_result'],

            'ENTEROCOCCI' => ['enterococci', 'enterococci_result'],
        ];

        if (isset($possibleFields[$targetKey])) {
            foreach ($possibleFields[$targetKey] as $field) {
                if (!empty($worksheet->$field)) {
                    return $worksheet->$field;
                }
            }
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
        <td colspan="2">Contact No./E-mail: {{ $rla->contact_no ?? '' }}</td>
    </tr>

    <tr>
        <td colspan="2">Source of Sample: {{ $rla->source_sample ?? '' }}</td>
    </tr>

    <tr>
        <td style="width:58%;">Date Collected: {{ $dateCollected }}</td>
        <td>Date of Test: {{ $dateCollected }}</td>
    </tr>

    <tr>
        <td>Date of Receipt: {{ $dateReceived }}</td>
        <td>Date of Issue: {{ $dateIssue }}</td>
    </tr>
</table>

<table class="result-table" style="font-size: {{ $resultColumnCount >= 5 ? '9.5px' : '10.5px' }};">
    <thead>
        <tr>
            @if ($resultColumnCount > 0)
                <th rowspan="2" style="width:95px;">Laboratory<br>Codes</th>
                <th rowspan="2" style="width:65px;">Sample<br>Codes</th>
                <th rowspan="2" style="width:70px;">Sample<br>Type</th>
                <th colspan="{{ $resultColumnCount }}">Results</th>
            @else
                <th style="width:95px;">Laboratory<br>Codes</th>
                <th style="width:65px;">Sample<br>Codes</th>
                <th style="width:70px;">Sample<br>Type</th>
                <th>Results</th>
            @endif
        </tr>

        @if ($resultColumnCount > 0)
            <tr>
                @foreach ($analysisRequested as $requested)
                    <th>{!! $formatAnalysisHeader($requested) !!}</th>
                @endforeach
            </tr>
        @endif
    </thead>

    <tbody>
        @foreach ($samples as $sample)
            @php
                $labCode = $displayValue($sample['lab_code'] ?? '');
                $sampleCode = $displayValue($sample['sample_code'] ?? '');
                $sampleType = $displayValue($sample['sample_type'] ?? '');
            @endphp

            <tr>
                <td class="bold">{{ $labCode }}</td>
                <td class="bold">{{ $sampleCode }}</td>
                <td class="bold">{!! nl2br(e($sampleType)) !!}</td>

                @if ($resultColumnCount > 0)
                    @foreach ($analysisRequested as $requested)
                        <td class="bold">
                            {{ $getPotabilityResult($labCode, $requested) }}
                        </td>
                    @endforeach
                @else
                    <td></td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

<div class="remarks">
    <strong>REMARKS:</strong>
    <span style="margin-left:20px;">
        Test results presented in the report relates only to the sample tested and as received.
    </span><br>

    <span style="margin-left:78px;">
        The laboratory is not responsible for the sampling stage of the submitted sample.
    </span><br>

    <span style="margin-left:78px;">
        No part of this report may be reproduced nor transmitted without the written permission of the Laboratory Manager.
    </span><br>

    <span style="margin-left:78px;">
        This report shall not be used for advertisement.
    </span>
</div>

<div class="conditions">
    Environmental Conditions of the laboratory:<br>
    Temperature: 21-23 ºC
    <span style="margin-left:130px;">Relative Humidity: 45-50%</span>
</div>

<table class="standard-table">
    <thead>
        <tr>
            <th style="width:28%;">TEST</th>
            <th style="width:24%;">METHOD</th>
            <th style="width:18%;">STANDARD<br>LIMITS</th>
            <th>REFERENCE</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td><em>Heterotrophic Plate Count<br>(HPC)</em></td>
            <td>Pour Plate Method</td>
            <td style="text-align:center;">&lt;500 <em>cfu/ml</em></td>
            <td style="text-align:center;">
                <em>SMEWW 23RD Edition<br>PNS 2017</em>
            </td>
        </tr>

        <tr>
            <td><em>E.coli<br>Coliform</em></td>
            <td>Multiple Tube Method</td>
            <td style="text-align:center;">&lt;1.1/100</td>
            <td style="text-align:center;">
                <em>SMEWW 23RD Edition</em>
            </td>
        </tr>

        <tr>
            <td><em>Fecal<br>Streptococci/Enterococci</em></td>
            <td>Multiple Tube Method</td>
            <td style="text-align:center;">&lt;1.1/100</td>
            <td style="text-align:center;">
                <em>SMEWW 23RD Edition</em>
            </td>
        </tr>

        <tr>
            <td><em>Fecal Coliform</em></td>
            <td>Multiple Tube Method</td>
            <td style="text-align:center;">&lt;1.1/100</td>
            <td style="text-align:center;">
                <em>SMEWW 23RD Edition</em>
            </td>
        </tr>
    </tbody>
</table>

<table class="signatories">
    <tr>
        <td>
            <strong>Analyzed by:</strong>
            <div class="name">CHARISSE ZIANNE L. SUICO</div>
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
            Form No.: LF 08-01-08 Rev. No.:0 Effectivity Date: 13 August 2019
        </td>

        <td class="page">
            Page 1 of 1
        </td>
    </tr>
</table>

</body>
</html>