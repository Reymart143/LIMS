{{-- resources/views/ReportTestChem/waterqualitydownload.blade.php --}}

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 24px 26px;
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
            min-height: 128px;
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
            font-size: 18px;
            margin-top: 4px;
        }

        .report-no {
            font-size: 13px;
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
            margin-top: 12px;
            table-layout: fixed;
        }

        .result-table th,
        .result-table td {
            border: 1px solid #000;
            padding: 3px 4px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .result-table td {
            height: 18px;
        }

        .result-table th {
            font-weight: bold;
        }

        .remarks {
            margin-top: 2px;
            line-height: 1.15;
        }

        .watermark {
            position: fixed;
            top: 395px;
            left: 95px;
            font-size: 70px;
            color: #777;
            opacity: 0.12;
            z-index: -1;
            letter-spacing: 5px;
        }

        .conditions {
            margin-top: 6px;
            font-weight: bold;
        }

        .standard-table {
            margin-top: 5px;
        }

        .standard-table th,
        .standard-table td {
            border: 1px solid #000;
            padding: 2px 5px;
            vertical-align: top;
        }

        .standard-table th {
            text-align: left;
            font-weight: bold;
        }

        .signatories {
            margin-top: 15px;
        }

        .signatories td {
            width: 50%;
            vertical-align: top;
            padding: 0 8px;
        }

        .name {
            font-weight: bold;
            margin-top: 20px;
            font-size: 13px;
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
            width: 110px;
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
    | FALLBACK DECODER
    | Para safe gihapon bisan wala napasa gikan controller
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
    | Dili fixed. Kung unsay selected sa RLA, mao ra ang RESULTS columns.
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
    | OPTIONAL RESULT VALUES
    | Kung naa kay JSON results sa water_quality_worksheets table.
    |
    | Example worksheet->results:
    | {
    |   "RFL12-26-001": {
    |       "pH": "7.5",
    |       "Alkalinity": "80",
    |       "Dissolved Oxygen": "5"
    |   },
    |   "RFL12-26-002": {
    |       "pH": "7.2",
    |       "Alkalinity": "75"
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

    $normalizeKey = function ($value) {
        $value = strtoupper(trim((string) $value));
        $value = str_replace(['(', ')', '/', '-', '_'], ' ', $value);
        $value = preg_replace('/\s+/', ' ', $value);

        return trim($value);
    };

    $getWaterQualityResult = function ($labCode, $analysisName) use ($worksheetResults, $normalizeKey) {
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

<table class="result-table" style="font-size: {{ $resultColumnCount >= 7 ? '10px' : '11px' }};">
    <thead>
        <tr>
            @if ($resultColumnCount > 0)
                <th rowspan="2" style="width:95px;">LABORATORY<br>CODE(S)</th>
                <th rowspan="2" style="width:55px;">SAMPLE<br>CODE(S)</th>
                <th rowspan="2" style="width:70px;">SAMPLE<br>TYPE</th>
                <th colspan="{{ $resultColumnCount }}">RESULTS</th>
            @else
                <th style="width:95px;">LABORATORY<br>CODE(S)</th>
                <th style="width:55px;">SAMPLE<br>CODE(S)</th>
                <th style="width:70px;">SAMPLE<br>TYPE</th>
                <th>RESULTS</th>
            @endif
        </tr>

        @if ($resultColumnCount > 0)
            <tr>
                @foreach ($analysisRequested as $requested)
                    <th>{{ $requested }}</th>
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
                <td>{{ $sampleCode }}</td>
                <td>{{ $sampleType }}</td>

                @if ($resultColumnCount > 0)
                    @foreach ($analysisRequested as $requested)
                        <td>{{ $getWaterQualityResult($labCode, $requested) }}</td>
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
    {{ $rla->remarks ?? 'Result is based on sample submitted.' }}<br>

    <span style="margin-left:55px;">
        The laboratory is not responsible for the sampling stage of the submitted sample.
    </span><br>

    <span style="margin-left:55px;">
        No part of this report may be reproduced nor transmitted without the written permission of the Laboratory Manager.
    </span><br>

    <span style="margin-left:55px;">
        This report shall not be used for advertisement.
    </span>
</div>

<div style="margin-top:12px;">
    ND-Not Detected, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    N/A- Not Applicable
</div>

<div>
    Environmental Conditions of the laboratory:<br>
    <strong>Temperature: 23 ± 3 ºC</strong>
    <span style="margin-left:45px;">
        <strong>Relative Humidity: 50 ± 15 %</strong>
    </span>
</div>

<table class="standard-table">
    <thead>
        <tr>
            <th style="width:115px;">Test</th>
            <th style="width:120px;">Method</th>
            <th style="width:130px;">Desirable limits</th>
            <th>References</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>pH</td>
            <td rowspan="10">
                Palintext [photometer<br>
                9500]
            </td>
            <td>6.5 - 9.0<sub>ab</sub></td>
            <td rowspan="10">
                <strong>a.</strong> Anita Bhatnagar, Pooja Devi. Water quality guidelines for the management of pond fish culture. International Journal of Environmental Sciences vol. 3, no. 6, 2013<br><br>
                <strong>b.</strong> DENR Administrative Order DAO 2016-08, General Effluent Standards and Water Quality Guidelines
            </td>
        </tr>

        <tr>
            <td>Temperature</td>
            <td>25 - 31 °C<sub>ab</sub></td>
        </tr>

        <tr>
            <td>Nitrite Nitrogen</td>
            <td>0 - &lt;0.02 mg/L<sub>a</sub></td>
        </tr>

        <tr>
            <td>Calcium Hardness</td>
            <td>25-100 mg/L<sub>a</sub></td>
        </tr>

        <tr>
            <td>Alkalinity</td>
            <td>25 - 100 mg/L<sub>a</sub></td>
        </tr>

        <tr>
            <td>Ammonia</td>
            <td>0.0 – 0.05 mg/L<sub>b</sub></td>
        </tr>

        <tr>
            <td>Dissolved Oxygen</td>
            <td>3 – 5 mg/L<sub>b</sub></td>
        </tr>

        <tr>
            <td>Nitrate</td>
            <td>7 mg/L<sub>b</sub></td>
        </tr>

        <tr>
            <td>Turbidity</td>
            <td>30-80cm, 150 NTU<sub>b</sub></td>
        </tr>

        <tr>
            <td>TSS</td>
            <td>100 mg/L<sub>b</sub></td>
        </tr>

        <tr>
            <td>Cyanide</td>
            <td></td>
            <td>0.1 mg/L<sub>b</sub></td>
            <td></td>
        </tr>
    </tbody>
</table>

<table class="signatories">
    <tr>
        <td>
            <strong>Analyzed and Certified by:</strong>
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
            Form No.: LF 08-01-07 Rev. No.:0 Effectivity Date: 13 August 2019
        </td>

        <td class="page">
            Page 1 of 1
        </td>
    </tr>
</table>

</body>
</html>