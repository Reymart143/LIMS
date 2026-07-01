<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 22px 28px;
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
            padding: 3px;
            vertical-align: middle;
            color: #000;
            line-height: 1.05;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .logo-cell {
            width: 95px;
            text-align: center;
        }

        .logo {
            width: 70px;
            height: auto;
        }

        .header-text {
            text-align: left;
            font-size: 9px;
            line-height: 1.05;
        }

        .doc-table td {
            height: 18px;
        }

        /*
            FIXED OPTIONS SECTION FOR DOMPDF
            Gamay ang font para kasigo ang taas nga TEST METHOD text.
        */
        .options-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 6px;
            margin-bottom: 2px;
        }

        .options-table td {
            border: none !important;
            padding: 0 2px !important;
            font-size: 7.4px;
            font-weight: bold;
            line-height: 1.15;
            vertical-align: middle;
            white-space: nowrap;
        }

        .option-label-cell {
            width: 13%;
            text-align: left;
        }

        .option-check-cell {
            width: 3%;
            text-align: center;
        }

        .option-text-method-1 {
            width: 44%;
            text-align: left;
        }

        .option-text-method-2 {
            width: 37%;
            text-align: left;
        }

        .option-text-sample-1 {
            width: 21%;
            text-align: left;
        }

        .option-text-sample-2 {
            width: 17%;
            text-align: left;
        }

        .option-text-sample-3 {
            width: 20%;
            text-align: left;
        }

        .option-text-sample-4 {
            width: 20%;
            text-align: left;
        }

        .check-box {
            display: inline-block;
            width: 8px;
            height: 8px;
            border: 1px solid #000;
        }

        .check-box.checked {
            background: #000;
        }

        .summary-table {
            margin-top: 6px;
        }

        .summary-table th,
        .summary-table td {
            height: 18px;
            text-align: center;
        }

        .section-title {
            font-weight: bold;
            margin-top: 12px;
            margin-bottom: 3px;
            text-transform: uppercase;
            font-size: 9px;
        }

        .reagent-title {
            font-weight: bold;
            font-size: 8px;
            margin-left: 18px;
            margin-top: 2px;
            margin-bottom: 1px;
        }

        .reagent-table td {
            height: 13px;
            padding: 2px;
            font-size: 7.5px;
        }

        .diagnosis-wrapper {
            width: 100%;
            margin-top: 5px;
        }

        .diagnosis-left {
            width: 57%;
            vertical-align: top;
            border: none !important;
            padding: 0 !important;
        }

        .diagnosis-gap {
            width: 2%;
            border: none !important;
            padding: 0 !important;
        }

        .diagnosis-right {
            width: 41%;
            vertical-align: top;
            border: none !important;
            padding: 0 !important;
        }

        .diagnosis-table th {
            font-size: 6.5px;
            padding: 2px;
            height: 20px;
        }

        .diagnosis-table td {
            height: 12px;
            padding: 1px 2px;
            font-size: 7.2px;
            text-align: center;
        }

        .picture-box {
            width: 100%;
            height: 400px;
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            position: relative;
            overflow: hidden;
        }

        .picture-box img {
            max-width: 100%;
            max-height: 390px;
            margin: 5px auto;
            display: block;
        }

        .picture-label {
            padding-top: 185px;
            font-size: 11px;
        }

        .signature-table {
            margin-top: 8px;
        }

        .signature-table td {
            border: none !important;
            font-size: 8px;
            vertical-align: top;
            text-align: center;
        }

        .signature-label {
            font-weight: bold;
            text-align: left;
            margin-bottom: 20px;
        }

        .signature-name {
            width: 160px;
            margin: 0 auto;
            text-align: center;
            font-size: 8px;
            min-height: 10px;
            line-height: 1.1;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 160px;
            margin: 2px auto 0;
            height: 4px;
        }

        .footer-label {
            font-size: 7px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>
@php
    function pcrDownloadJson($value) {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    function pcrDownloadFlatten($array) {
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

    function pcrDownloadValue($array, $index, $default = '') {
        return isset($array[$index]) && $array[$index] !== null && $array[$index] !== ''
            ? $array[$index]
            : $default;
    }

    $labCodes = pcrDownloadJson($rla->laboratory_code ?? null);

    $analysisRequested = pcrDownloadFlatten(pcrDownloadJson($rla->analysis_requested ?? null));
    $analysisRequestedText = implode(', ', $analysisRequested);

    $testMethods = pcrDownloadJson($worksheet->test_method ?? null);
    $sampleTypes = pcrDownloadJson($worksheet->sample_type ?? null);

    $diagnosisRla = pcrDownloadJson($worksheet->diagnosis_rla ?? null);
    $diagnosisLaneNo = pcrDownloadJson($worksheet->diagnosis_lane_no ?? null);
    $diagnosisLabCode = pcrDownloadJson($worksheet->diagnosis_laboratory_code ?? null);
    $diagnosis50 = pcrDownloadJson($worksheet->diagnosis_50nm ?? null);
    $diagnosis55 = pcrDownloadJson($worksheet->diagnosis_55nm ?? null);
    $diagnosisResult = pcrDownloadJson($worksheet->diagnosis_result ?? null);

    $fixedDiagnosisRows = [
        [
            'rla' => '',
            'lane_no' => '1',
            'laboratory_code' => '10³',
            'result' => 'OK',
        ],
        [
            'rla' => '',
            'lane_no' => '2',
            'laboratory_code' => '10²',
            'result' => 'OK',
        ],
        [
            'rla' => '',
            'lane_no' => '3',
            'laboratory_code' => 'Known (-) Sample',
            'result' => 'OK',
        ],
        [
            'rla' => '',
            'lane_no' => '4',
            'laboratory_code' => 'Negative Control',
            'result' => 'OK',
        ],
    ];

    $fixedRowsCount = count($fixedDiagnosisRows);
    $dnaMarkerIndex = $fixedRowsCount + count($labCodes);

    $rowCount = max(
        $fixedRowsCount + count($labCodes) + 1,
        count($diagnosisLabCode),
        22
    );

    $analysisValue = $worksheet->analysis ?? $analysisRequestedText;

    $methodIq2000 = 'IQ 2000™ DETECTION AND PREVENTION SYSTEM';
    $methodIqPlus = 'IQ PLUS KIT W / POCKIT SYSTEM';

    $sampleShrimp = 'SHRIMP (FRY/ADULT)';
    $sampleCrab = 'CRAB (FRY/ADULT)';
    $sampleTilapia = 'TILAPIA (FRY/ADULT)';
    $sampleOthers = 'OTHERS';
@endphp

{{-- HEADER --}}
<table>
    <tr>
        <td class="logo-cell">
            <img src="{{ public_path('assets/images/bfarlogo.png') }}" class="logo">
        </td>
        <td colspan="4" class="header-text">
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
            06 January 2020
        </td>
        <td style="width:21%;">
            Page No:<br>
            <div class="center">1</div>
        </td>
    </tr>
    <tr>
        <td>
            Document Code:<br>
            <b>LF-W01-FIS-01</b>
        </td>
        <td colspan="3" class="center bold">
            ANALYST WORKSHEET FOR MOLECULAR DIAGNOSIS
        </td>
    </tr>
</table>

{{-- TEST METHOD --}}
<table class="options-table">
    <tr>
        <td class="option-label-cell">TEST METHOD:</td>

        <td class="option-check-cell">
            <span class="check-box {{ in_array($methodIq2000, $testMethods) ? 'checked' : '' }}"></span>
        </td>
        <td class="option-text-method-1">
            {{ $methodIq2000 }}
        </td>

        <td class="option-check-cell">
            <span class="check-box {{ in_array($methodIqPlus, $testMethods) ? 'checked' : '' }}"></span>
        </td>
        <td class="option-text-method-2">
            {{ $methodIqPlus }}
        </td>
    </tr>
</table>

{{-- SAMPLE TYPE --}}
<table class="options-table" style="margin-top:0;">
    <tr>
        <td class="option-label-cell">SAMPLE TYPE:</td>

        <td class="option-check-cell">
            <span class="check-box {{ in_array($sampleShrimp, $sampleTypes) ? 'checked' : '' }}"></span>
        </td>
        <td class="option-text-sample-1">
            {{ $sampleShrimp }}
        </td>

        <td class="option-check-cell">
            <span class="check-box {{ in_array($sampleCrab, $sampleTypes) ? 'checked' : '' }}"></span>
        </td>
        <td class="option-text-sample-2">
            {{ $sampleCrab }}
        </td>

        <td class="option-check-cell">
            <span class="check-box {{ in_array($sampleTilapia, $sampleTypes) ? 'checked' : '' }}"></span>
        </td>
        <td class="option-text-sample-3">
            {{ $sampleTilapia }}
        </td>

        <td class="option-check-cell">
            <span class="check-box {{ in_array($sampleOthers, $sampleTypes) ? 'checked' : '' }}"></span>
        </td>
        <td class="option-text-sample-4">
            OTHERS: __________________
        </td>
    </tr>
</table>

{{-- SUMMARY TABLE --}}
<table class="summary-table">
    <tr>
        <th style="width:15%;">TOTAL NO. OF<br>SAMPLE</th>
        <th style="width:25%;">ANALYSIS</th>
        <th style="width:20%;">DATE/TIME STARTED</th>
        <th style="width:20%;">DATE/TIME FINISHED</th>
        <th style="width:20%;">KIT LOT NO.</th>
    </tr>
    <tr>
        <td>{{ $worksheet->total_no_of_sample ?? count($labCodes) }}</td>
        <td>{{ $analysisValue }}</td>
        <td>{{ $worksheet->date_time_started ?? '' }}</td>
        <td>{{ $worksheet->date_time_finished ?? '' }}</td>
        <td>{{ $worksheet->kit_lot_no ?? '' }}</td>
    </tr>
</table>

{{-- REAGENT PREPARATION --}}
<div class="section-title">I. Reagent Preparation</div>

<div class="reagent-title">A. WSSV First PCR</div>
<table class="reagent-table">
    <tr>
        <td style="width:35%;" class="center">First PCR premix</td>
        <td style="width:30%;" class="center">{{ $worksheet->fish_pcr_premix ?? '7.5 ul x' }}</td>
        <td style="width:35%;">= {{ $worksheet->fish_pcr_premix_result ?? '' }}</td>
    </tr>
    <tr>
        <td class="center">iQzyme DNA polymerase</td>
        <td class="center">{{ $worksheet->dnazyme_polymerase ?? '0.5 ul x' }}</td>
        <td>= {{ $worksheet->dnazyme_polymerase_result ?? '' }}</td>
    </tr>
</table>

<div class="reagent-title">B. Nested</div>
<table class="reagent-table">
    <tr>
        <td style="width:35%;" class="center">Nested PCR premix</td>
        <td style="width:30%;" class="center">{{ $worksheet->nested_pcr_premix ?? '14 ul x' }}</td>
        <td style="width:35%;">= {{ $worksheet->nested_pcr_premix_result ?? '' }}</td>
    </tr>
    <tr>
        <td class="center">iQzyme DNA polymerase</td>
        <td class="center">{{ $worksheet->dnazyme_dna_polymerase ?? '1 ul x' }}</td>
        <td>= {{ $worksheet->dnazyme_dna_polymerase_result ?? '' }}</td>
    </tr>
</table>

<div class="reagent-title">C. AHPND/EMS</div>
<table class="reagent-table">
    <tr>
        <td style="width:35%;" class="center">EMS/AHPND premix</td>
        <td style="width:30%;" class="center">{{ $worksheet->ems_ahpnd_premix ?? '12.5 ul x' }}</td>
        <td style="width:35%;">= {{ $worksheet->ems_ahpnd_premix_result ?? '' }}</td>
    </tr>
    <tr>
        <td class="center">iQzyme DNA polymerase</td>
        <td class="center">{{ $worksheet->dnazyme_dna_polymerase_2 ?? '0.5 ul x' }}</td>
        <td>= {{ $worksheet->dnazyme_dna_polymerase_2_result ?? '' }}</td>
    </tr>
</table>

{{-- DIAGNOSIS --}}
<div class="section-title">II. Diagnosis</div>

<table class="diagnosis-wrapper">
    <tr>
        <td class="diagnosis-left">
            <table class="diagnosis-table">
                <tr>
                    <th rowspan="2" style="width:8%;">RLA</th>
                    <th rowspan="2" style="width:10%;">LANE<br>NO.</th>
                    <th rowspan="2" style="width:32%;">LABORATORY CODE</th>
                    <th colspan="2" style="width:20%;">
                        WAVELENGTH<br>
                        <i>(If Applicable)</i>
                    </th>
                    <th rowspan="2" style="width:30%;">RESULT</th>
                </tr>
                <tr>
                    <th>520<br>nm</th>
                    <th>550<br>nm</th>
                </tr>

                @for($i = 0; $i < $rowCount; $i++)
                    @php
                        $defaultRla = '';
                        $defaultLaneNo = '';
                        $defaultLabCode = '';
                        $defaultResult = '';

                        if ($i < $fixedRowsCount) {
                            $defaultRla = $fixedDiagnosisRows[$i]['rla'];
                            $defaultLaneNo = $fixedDiagnosisRows[$i]['lane_no'];
                            $defaultLabCode = $fixedDiagnosisRows[$i]['laboratory_code'];
                            $defaultResult = $fixedDiagnosisRows[$i]['result'];
                            $isFixedRow = true;
                        } elseif ($i >= $fixedRowsCount && $i < $dnaMarkerIndex) {
                            $actualIndex = $i - $fixedRowsCount;

                            $defaultRla = $actualIndex === 0 ? ($rla->RLA_no ?? '') : '';
                            $defaultLaneNo = (string) ($i + 1);
                            $defaultLabCode = $labCodes[$actualIndex] ?? '';
                            $defaultResult = '';
                            $isFixedRow = false;
                        } elseif ($i === $dnaMarkerIndex) {
                            $defaultRla = '';
                            $defaultLaneNo = (string) ($i + 1);
                            $defaultLabCode = 'DNA Marker';
                            $defaultResult = 'OK';
                            $isFixedRow = true;
                        } else {
                            $isFixedRow = false;
                        }

                        $printRla = $isFixedRow
                            ? $defaultRla
                            : pcrDownloadValue($diagnosisRla, $i, $defaultRla);

                        $printLaneNo = $isFixedRow
                            ? $defaultLaneNo
                            : pcrDownloadValue($diagnosisLaneNo, $i, $defaultLaneNo);

                        $printLabCode = $isFixedRow
                            ? $defaultLabCode
                            : pcrDownloadValue($diagnosisLabCode, $i, $defaultLabCode);

                        $printResult = $isFixedRow
                            ? $defaultResult
                            : pcrDownloadValue($diagnosisResult, $i, $defaultResult);
                    @endphp

                    <tr>
                        <td>{{ $printRla }}</td>
                        <td>{{ $printLaneNo }}</td>
                        <td>{{ $printLabCode }}</td>
                        <td>{{ pcrDownloadValue($diagnosis50, $i) }}</td>
                        <td>{{ pcrDownloadValue($diagnosis55, $i) }}</td>
                        <td>{{ $printResult }}</td>
                    </tr>
                @endfor
            </table>

            {{-- SIGNATURES --}}
            <table class="signature-table">
                <tr>
                    <td style="width:50%;">
                        <div class="signature-label">Analyzed by:</div>

                        <div class="signature-name">
                            {{ $worksheet->analyzed_by ?? '' }}
                        </div>
                        <div class="signature-line"></div>

                        <div class="footer-label">
                            NAME OF ANALYST AND SIGNATURE
                        </div>
                    </td>

                    <td style="width:50%;">
                        <div class="signature-label">&nbsp;</div>

                        <div class="signature-name">
                            {{ $worksheet->checked_by ?? '' }}
                        </div>
                        <div class="signature-line"></div>

                        <div class="footer-label">
                            NAME OF ANALYST AND SIGNATURE
                        </div>
                    </td>
                </tr>
            </table>
        </td>

        <td class="diagnosis-gap"></td>

        <td class="diagnosis-right">
            <div class="picture-box">
                @if(!empty($worksheet->picture))
                    <img src="{{ public_path('storage/' . $worksheet->picture) }}" alt="PCR Picture">
                @else
                    <div class="picture-label">PICTURE</div>
                @endif
            </div>
        </td>
    </tr>
</table>

</body>
</html>