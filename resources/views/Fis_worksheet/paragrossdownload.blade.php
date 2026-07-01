<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 35px 45px;
        }
        body {
            font-family: Cambria, "Times New Roman", serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .page {
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        td, th {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: middle;
            line-height: 1.15;
            color: #000;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .tiny {
            font-size: 8px;
        }

        .small {
            font-size: 10px;
        }
        .logo-cell {
            width: 95px;
            text-align: center;
        }
        .logo {
            width: 75px;
            height: auto;
        }
        .sample-type {
            margin-top: 28px;
            margin-bottom: 25px;
            font-size: 13px;
        }
        .line {
            display: inline-block;
            min-width: 95px;
            border-bottom: 1px solid #000;
            padding: 0 4px;
            min-height: 12px;
        }
        .main-table td,
        .main-table th {
            height: 28px;
        }
        .method-cell {
            height: 65px;
            text-align: center;
        }
        .result-cell {
            height: 65px;
            text-align: center;
            white-space: pre-wrap;
        }
        .remarks {
            margin-top: 22px;
            font-size: 12px;
        }

        .remarks-lines {
            margin-top: 18px;
            line-height: 1.5;
            white-space: pre-wrap;
        }

        .signature-table {
            margin-top: 45px;
            width: 100%;
            border-collapse: collapse;
        }

        .signature-table td {
            border: none;
            text-align: center;
            font-size: 11px;
        }

        .signature-line {
            display: inline-block;
            border-bottom: 1px solid #000;
            width: 150px;
            min-height: 18px;
            padding: 2px 4px;
        }

        .checkbox-box {
            display: inline-block;
            width: 11px;
            height: 11px;
            border: 1px solid #000;
            text-align: center;
            line-height: 11px;
            font-size: 9px;
            font-weight: bold;
            font-family: DejaVu Sans, sans-serif;
        }
    </style>
</head>

<body>
@php
    function pgJson($value) {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    $labCodes = pgJson($rla->laboratory_code ?? null);
    $firstLabCode = $labCodes[0] ?? '';

    $sampleDescriptions = pgJson($rla->sample_description ?? null);
    $firstSampleDescription = $sampleDescriptions[0] ?? '';

    $objectives = pgJson($worksheet->objective_used ?? null);

    $selected10x = in_array('10x', $objectives);
    $selected40x = in_array('40x', $objectives);
    $selected100x = in_array('100x', $objectives);

    $sampleType = $worksheet->sample_type ?? $firstSampleDescription;
    $rlaNo = $worksheet->rla_no ?? $rla->RLA_no ?? '';
    $labCode = $worksheet->lab_code ?? $firstLabCode;
@endphp

<div class="page">

    {{-- HEADER --}}
    <table>
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

    <table>
        <tr>
            <td style="width:20%;">
                Document Type<br>
                <b>Laboratory<br>Form</b>
            </td>
            <td style="width:25%;">
                Revision No:<br>
                0
            </td>
            <td style="width:30%;">
                Date Adopted:<br>
                21 Jan 2020
            </td>
            <td style="width:25%;">
                Page No:
            </td>
        </tr>

        <tr>
            <td>
                Document Code:<br>
                LF-W01-FIS-02
            </td>
            <td colspan="3" class="center bold">
                ANALYST WORKSHEET FOR GROSS MORPHOLOGY &amp; PARASITOLOGY
            </td>
        </tr>
    </table>

    {{-- SAMPLE TYPE --}}
    <div class="sample-type">
        <b>Sample Type:</b>
        <span class="line">{{ $sampleType }}</span>
    </div>

    {{-- INFO TABLE --}}
    <table>
        <tr>
            <td style="width:14%;" class="bold">RLA No.:</td>
            <td style="width:18%;" class="center">{{ $rlaNo }}</td>

            <td style="width:14%;" class="bold">Lab Code:</td>
            <td style="width:22%;" class="center">{{ $labCode }}</td>

            <td style="width:16%;" class="bold">Date Started:</td>
            <td style="width:16%;" class="center">{{ $worksheet->date_started ?? '' }}</td>
        </tr>

        <tr>
            <td style="width:16%;" class="bold">Date Finished:</td>
            <td colspan="5" class="center">{{ $worksheet->date_finished ?? '' }}</td>
        </tr>
    </table>

    {{-- MAIN TABLE --}}
    <table class="main-table">
        <tr>
            <td rowspan="2" style="width:20%;" class="center bold">
                Test Method
            </td>

            <td colspan="3" style="width:28%;" class="center bold">
                Objective Used
            </td>

            <td rowspan="2" style="width:22%;" class="center bold">
                Length<br><br>(cm)
            </td>

            <td rowspan="2" style="width:30%;" class="center bold">
                Result
            </td>
        </tr>

        <tr>
            <td class="center">10x</td>
            <td class="center">40x</td>
            <td class="center">100x</td>
        </tr>

        <tr>
            <td class="method-cell">
                {{ $worksheet->test_method ?? 'Wet Mount Microscopy' }}
            </td>

            <td class="center">
                <span class="checkbox-box">{{ $selected10x ? 'X' : '' }}</span>
            </td>

            <td class="center">
                <span class="checkbox-box">{{ $selected40x ? 'X' : '' }}</span>
            </td>

            <td class="center">
                <span class="checkbox-box">{{ $selected100x ? 'X' : '' }}</span>
            </td>

            <td class="center">
                {{ $worksheet->length_cm ?? '' }}
            </td>

            <td class="result-cell">
                {{ $worksheet->result ?? '' }}
            </td>
        </tr>
    </table>

    {{-- REMARKS --}}
    <div class="remarks">
        <b>REMARKS:</b>
    </div>

    <div class="remarks-lines">
@if(!empty($worksheet->remarks))
{{ $worksheet->remarks }}
@else
________________________________________________
________________________________________________
@endif
    </div>

    {{-- SIGNATURES --}}
    <table class="signature-table">
        <tr>
            <td class="bold">Analysed by:</td>
            <td class="bold">Checked by:</td>
        </tr>

        <tr>
            <td style="height:45px;"></td>
            <td style="height:45px;"></td>
        </tr>

        <tr>
            <td>
                <span class="signature-line">{{ $worksheet->analyzed_by ?? '' }}</span>
            </td>
            <td>
                <span class="signature-line">{{ $worksheet->checked_by ?? '' }}</span>
            </td>
        </tr>

        <tr>
            <td class="tiny bold">NAME OF ANALYST AND SIGNATURE</td>
            <td class="tiny bold">NAME OF ANALYST AND SIGNATURE</td>
        </tr>
    </table>

</div>
</body>
</html>