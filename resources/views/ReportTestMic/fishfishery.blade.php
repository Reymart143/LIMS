{{-- resources/views/ReportTestMic/fishfisherydownload.blade.php --}}

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
    font-size: 13px;
    color: #000;
}

.header {
    text-align: center;
    line-height: 1.1;
    position: relative;
    min-height: 130px;
}

.logo-left {
    position: absolute;
    left: 32px;
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
    font-size: 19px;
    margin-top: 5px;
}

.report-no {
    font-size: 14px;
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
    margin-top: 12px;
    table-layout: fixed;
}

.result-table th,
.result-table td {
    border: 1px solid #000;
    padding: 5px;
    text-align: center;
    vertical-align: middle;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.result-table td {
    height: 20px;
}

.watermark {
    position: fixed;
    top: 390px;
    left: 80px;
    font-size: 80px;
    color: #777;
    opacity: 0.12;
    z-index: -1;
    letter-spacing: 5px;
}

.remarks {
    margin-top: 12px;
    line-height: 1.2;
}

.conditions {
    margin-top: 6px;
    font-weight: bold;
}

.standard-table {
    margin-top: 10px;
}

.standard-table th,
.standard-table td {
    border: 1px solid #000;
    padding: 5px;
    vertical-align: top;
}

.standard-table th {
    text-align: left;
    font-weight: bold;
}

.signatories {
    margin-top: 25px;
}

.signatories td {
    width: 33%;
    vertical-align: top;
}

.position {
    margin-top: 35px;
}

.footer-line {
    border-top: 1px solid #000;
    margin: 35px 30px 5px;
}

.footer {
    font-size: 10px;
    color: #555;
    line-height: 1.2;
}

.page {
    text-align: right;
    font-size: 12px;
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
        ? Carbon::parse($rla->date_collected)->format('F d, Y')
        : '';

    $dateReceived = !empty($rla->date_received)
        ? Carbon::parse($rla->date_received)->format('F d, Y')
        : '';

    $dateIssue = now()->format('F d, Y');

    /*
    |--------------------------------------------------------------------------
    | FALLBACK DECODER
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
    | HEADER FORMAT ONLY
    | Dili ni default. I-format ra niya kung mao ni ang selected analysis requested.
    |--------------------------------------------------------------------------
    */
    $normalizeKey = function ($value) {
        $value = strtoupper(trim((string) $value));
        $value = str_replace(['.', '_', '-', '/', '(', ')'], ' ', $value);
        $value = preg_replace('/\s+/', ' ', $value);

        return trim($value);
    };

    $formatAnalysisHeader = function ($value) use ($normalizeKey) {
        $key = $normalizeKey($value);

        return match ($key) {
            'APC', 'AEROBIC PLATE COUNT' => 'APC<br>cfu/g',
            'E COLI', 'ECOLI' => '<em>E. coli</em><br>MPN/g',
            'S AUREUS', 'STAPHYLOCOCCUS AUREUS' => '<em>S. aureus</em><br>cfu/g',
            'SALMONELLA' => '<em>Salmonella</em><br>Absent in 25g',
            'SHIGELLA' => '<em>Shigella</em><br>Absent in 25g',
            default => e($value),
        };
    };

    /*
    |--------------------------------------------------------------------------
    | OPTIONAL RESULT VALUES
    | Kung naa kay JSON results sa fish_fishery_worksheets table.
    |
    | Example worksheet->results:
    | {
    |   "RFL12-26-001": {
    |       "APC": "100",
    |       "E COLI": "<3",
    |       "SALMONELLA": "Absent"
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

    $getFishFisheryResult = function ($labCode, $analysisName) use ($worksheetResults, $normalizeKey) {
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
        <td colspan="2">Contact No./E-mail: {{ $rla->contact_no ?? '' }}</td>
    </tr>

    <tr>
        <td colspan="2">Source of Sample: {{ $rla->source_sample ?? '' }}</td>
    </tr>

    <tr>
        <td>Date Collected: {{ $dateCollected }}</td>
        <td>Date of Test:</td>
    </tr>

    <tr>
        <td>Date of Receipt: {{ $dateReceived }}</td>
        <td>Date of Issue: {{ $dateIssue }}</td>
    </tr>
</table>

<table class="result-table" style="font-size: {{ $resultColumnCount >= 5 ? '11px' : '12px' }};">
    <thead>
        <tr>
            @if ($resultColumnCount > 0)
                <th rowspan="2" style="width:95px;">Laboratory<br>Codes</th>
                <th rowspan="2" style="width:80px;">Sample<br>Codes</th>
                <th rowspan="2" style="width:95px;">Sample<br>Type</th>
                <th colspan="{{ $resultColumnCount }}">Results</th>
            @else
                <th style="width:95px;">Laboratory<br>Codes</th>
                <th style="width:80px;">Sample<br>Codes</th>
                <th style="width:95px;">Sample<br>Type</th>
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
                <td>{{ $sampleCode }}</td>
                <td>{{ $sampleType }}</td>

                @if ($resultColumnCount > 0)
                    @foreach ($analysisRequested as $requested)
                        <td>{{ $getFishFisheryResult($labCode, $requested) }}</td>
                    @endforeach
                @else
                    <td></td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

<div class="remarks">
    <strong>REMARKS:</strong><br>
    Test results presented in the report relates only to the sample tested and as received.<br>
    The laboratory is not responsible for the sampling stage.<br>
    No part of this report may be reproduced without permission.<br>
    This report shall not be used for advertisement.

    <span style="float:right;">
        <strong>*EAPC - Estimated Aerobic Plate Count</strong>
    </span>
</div>

<div class="conditions">
    Environmental Conditions of the laboratory:<br>
    Temperature: 21-23 ºC
    <span style="margin-left:140px;">Relative Humidity: 45-50%</span>
</div>

<table class="standard-table">
    <thead>
        <tr>
            <th>TEST</th>
            <th>METHOD</th>
            <th>STANDARD LIMITS</th>
            <th>REFERENCE</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>Aerobic Plate Count APC</td>
            <td><strong>Pour Plate Method</strong></td>
            <td><strong>500,000/g</strong></td>
            <td rowspan="5">
                FAO No. 210 Series 2001, ICMSF, 1986<br>
                FAO No. 195 Series 1999
            </td>
        </tr>

        <tr>
            <td><em>E. coli</em></td>
            <td><strong>Multiple Tube Method</strong></td>
            <td><strong>11/g</strong></td>
        </tr>

        <tr>
            <td><em>Staphylococcus aureus</em></td>
            <td><strong>Conventional Method</strong></td>
            <td><strong>1000/g</strong></td>
        </tr>

        <tr>
            <td><em>Salmonella</em></td>
            <td><strong>Conventional Method</strong></td>
            <td><strong>Absent</strong></td>
        </tr>

        <tr>
            <td><em>Shigella</em></td>
            <td><strong>Conventional Method</strong></td>
            <td><strong>Absent</strong></td>
        </tr>
    </tbody>
</table>

<table class="signatories">
<tr>
    <td>
        Analyzed by:<br>
        <div class="position">Analyst</div>
    </td>

    <td>
        Certified by:<br>
        <div class="position">Quality Assurance Manager</div>
    </td>

    <td>
        Approved by:<br>
        <div class="position">Laboratory Manager</div>
    </td>
</tr>
</table>

<div class="footer-line"></div>

<div class="footer">
    • The results of test have traceability to the national and/or international standards.<br>
    • This report shall not be reproduced except in full.<br>
    • Valid only for tested samples.
</div>

<table style="margin-top:5px;">
<tr>
    <td>Form No.: LF 08-01-04 Rev. No.:0 Effectivity Date: 13 August 2019</td>
    <td class="page">Page 1 of 1</td>
</tr>
</table>

</body>
</html>