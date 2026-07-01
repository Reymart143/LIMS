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
            line-height: 1.05;
        }

        th {
            text-align: center;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .tiny {
            font-size: 7px;
        }

        .small {
            font-size: 8px;
        }

        .logo-cell {
            width: 90px;
            text-align: center;
        }

        .logo {
            width: 70px;
            height: auto;
        }

        .no-border {
            border: none !important;
        }

        .no-border td,
        .no-border th {
            border: none !important;
        }

        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 12px;
            margin-left: 25px;
            margin-bottom: 3px;
        }

        .indent {
            margin-left: 25px;
        }

        .line {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-height: 10px;
            padding: 0 3px;
            vertical-align: bottom;
        }

        .dotted td {
            border-top: 1px dotted #000 !important;
            border-bottom: 1px dotted #000 !important;
        }

        .blank-cell {
            height: 13px;
        }

        .analysis-row td {
            height: 15px;
        }

        .notes-box {
            height: 70px;
            vertical-align: top;
        }

        .signature-line {
            display: inline-block;
            border-bottom: 1px solid #000;
            width: 140px;
            min-height: 18px;
        }

        .mt-8 {
            margin-top: 8px;
        }

        .mt-12 {
            margin-top: 12px;
        }
    </style>
</head>
<body>

@php
    function hJson($value) {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    function hVal($array, $index, $default = '') {
        return isset($array[$index]) && $array[$index] !== null ? $array[$index] : $default;
    }

    $calTarget = hJson($worksheet->calibration_target_concentration ?? null);
    $calActual = hJson($worksheet->calibration_actual_concentration ?? null);
    $calRfu = hJson($worksheet->calibration_rfu ?? null);

    $qcLabel = hJson($worksheet->qc_label ?? null);
    $qcMass = hJson($worksheet->qc_mass_sample ?? null);
    $qcRfu = hJson($worksheet->qc_rfu ?? null);
    $qcCurve = hJson($worksheet->qc_histamine_from_curve ?? null);
    $qcCorrected = hJson($worksheet->qc_corrected_histamine ?? null);
    $qcOnSample = hJson($worksheet->qc_histamine_on_sample ?? null);
    $qcAverage = hJson($worksheet->qc_average_histamine_conc ?? null);
    $qcRemarks = hJson($worksheet->qc_remarks ?? null);

    $sampleLabCode = hJson($worksheet->sample_laboratory_code ?? null);
    $sampleMass = hJson($worksheet->sample_mass_sample ?? null);
    $sampleRfu = hJson($worksheet->sample_rfu ?? null);
    $sampleCurve = hJson($worksheet->sample_histamine_from_curve ?? null);
    $sampleCorrected = hJson($worksheet->sample_corrected_histamine ?? null);
    $sampleOnSample = hJson($worksheet->sample_histamine_on_sample ?? null);
    $sampleAverage = hJson($worksheet->sample_average_histamine_conc ?? null);
    $sampleRemarks = hJson($worksheet->sample_remarks ?? null);

    $laboratoryCodes = hJson($rla->laboratory_code ?? null);

    $defaultTargets = ['Blank', '0.01', '0.05', '0.10', '0.20', '0.30'];

    $qcDefaultLabels = [
        'Spiked Sample',
        'Spiked Sample',
        'Spiked Sample',
        'CCV',
        'CCV',
        ''
    ];

    $sampleRowCount = max(count($sampleLabCode), count($laboratoryCodes) + 1, 10);
@endphp

<table>
    <tr>
        <td class="logo-cell">
            <img src="{{ public_path('assets/images/bfarlogo.png') }}" class="logo">
        </td>
        <td colspan="5" class="center">
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
        <td style="width:24%;">
            Document Type<br>
            <b>Laboratory Form</b>
        </td>
        <td style="width:24%;">
            Revision No:<br>
            0
        </td>
        <td style="width:28%;">
            Date Adopted:<br>
            13 Aug 2019
        </td>
        <td style="width:24%;">
            Page No:
        </td>
    </tr>

    <tr>
        <td>
            Document Code:<br>
            LF W01-CHE-01
        </td>
        <td colspan="3" class="center bold">
            ANALYST WORKSHEET FOR HISTAMINE ANALYSIS
        </td>
    </tr>
</table>

<table>
    <tr>
        <td style="width:18%;">
            Date / Time<br>started:
        </td>
        <td style="width:18%;" class="center">
            {{ $worksheet->date_time_started ?? '' }}
        </td>

        <td style="width:18%;">
            Date / Time<br>finished:
        </td>
        <td style="width:18%;" class="center">
            {{ $worksheet->date_time_finished ?? '' }}
        </td>

        <td style="width:14%;">
            RLA No.:
        </td>
        <td style="width:14%;" class="center">
            {{ $worksheet->rla_no ?? $rla->RLA_no ?? '' }}
        </td>
    </tr>
</table>

<br>

<div class="indent">
    Reagent No
    <span class="line" style="width: 300px;">{{ $worksheet->reagent_no ?? '' }}</span>
    (From LF W01-01)
</div>

<div class="section-title">Preparation of Calibration Curve</div>

<div class="indent">
    Mass of standard
    <span class="line" style="width: 120px;">{{ $worksheet->mass_of_standard ?? '' }}</span>
    grams
</div>

<table class="mt-8">
    <thead>
        <tr>
            <th style="width:33%;">Target concentration<br>(ppm)</th>
            <th style="width:34%;">Actual Concentration<br>(ppm)</th>
            <th style="width:33%;">RFU</th>
        </tr>
    </thead>
    <tbody>
        @foreach($defaultTargets as $i => $target)
            <tr class="dotted">
                <td class="center blank-cell">
                    {{ hVal($calTarget, $i, $target) }}
                </td>
                <td class="center blank-cell">
                    {{ hVal($calActual, $i) }}
                </td>
                <td class="center blank-cell">
                    {{ hVal($calRfu, $i) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<table class="no-border mt-8">
    <tr>
        <td style="width:50%; padding-left:25px;">
            Equation of line
            <span class="line" style="width:240px;">{{ $worksheet->equation_of_line ?? '' }}</span>
        </td>
        <td style="width:50%;">
            R
            <span class="line" style="width:220px;">{{ $worksheet->r_value ?? '' }}</span>
        </td>
    </tr>
</table>

<table class="mt-12">
    <thead>
        <tr>
            <th style="width:14%;"></th>
            <th style="width:10%;">Mass<br>Sample<br>(g)</th>
            <th style="width:12%;">RFU</th>
            <th style="width:13%;">Histamine<br>from<br>curve(µg)</th>
            <th style="width:13%;">Corrected<br>histamine,<br>C (µg)</th>
            <th style="width:13%;">Histamine<br>on sample<br>(ppm)</th>
            <th style="width:13%;">Average of<br>Histamine<br>Conc. (ppm)</th>
            <th style="width:12%;">Remarks</th>
        </tr>
    </thead>
    <tbody>
        @foreach($qcDefaultLabels as $i => $label)
            <tr>
                <td class="center bold blank-cell">
                    {{ hVal($qcLabel, $i, $label) }}
                </td>
                <td class="center">{{ hVal($qcMass, $i) }}</td>
                <td class="center">{{ hVal($qcRfu, $i) }}</td>
                <td class="center">{{ hVal($qcCurve, $i) }}</td>
                <td class="center">{{ hVal($qcCorrected, $i) }}</td>
                <td class="center">{{ hVal($qcOnSample, $i) }}</td>
                <td class="center">{{ hVal($qcAverage, $i) }}</td>
                <td class="center">{{ hVal($qcRemarks, $i) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="section-title">Analysis of Sample</div>

<table>
    <thead>
        <tr>
            <th style="width:15%;">Laboratory<br>Code</th>
            <th style="width:10%;">Mass<br>Sample<br>(g)</th>
            <th style="width:13%;">RFU</th>
            <th style="width:13%;">Histamine<br>from curve<br>(µg)</th>
            <th style="width:13%;">Corrected<br>histamine,<br>C (µg)</th>
            <th style="width:13%;">Histamine<br>on sample<br>(ppm)</th>
            <th style="width:13%;">Average of<br>Histamine<br>Conc. (ppm)</th>
            <th style="width:10%;">Remarks</th>
        </tr>
    </thead>
    <tbody>
        @for($i = 0; $i < $sampleRowCount; $i++)
            @php
                $defaultLab = '';

                if ($i === 0) {
                    $defaultLab = 'Reagent Blank';
                } else {
                    $defaultLab = $laboratoryCodes[$i - 1] ?? '';
                }

                $defaultMass = $i === 0 ? '---' : '';
            @endphp

            <tr class="analysis-row {{ $i > 0 ? 'dotted' : '' }}">
                <td class="center">
                    {{ hVal($sampleLabCode, $i, $defaultLab) }}
                </td>
                <td class="center">
                    {{ hVal($sampleMass, $i, $defaultMass) }}
                </td>
                <td class="center">
                    {{ hVal($sampleRfu, $i) }}
                </td>
                <td class="center">
                    {{ hVal($sampleCurve, $i) }}
                </td>
                <td class="center">
                    {{ hVal($sampleCorrected, $i) }}
                </td>
                <td class="center">
                    {{ hVal($sampleOnSample, $i) }}
                </td>
                <td class="center">
                    {{ hVal($sampleAverage, $i) }}
                </td>
                <td class="center">
                    {{ hVal($sampleRemarks, $i) }}
                </td>
            </tr>
        @endfor
    </tbody>
</table>

<br>

<table>
    <tr>
        <td class="notes-box" style="width:42%;">
            <b class="tiny">Notes:</b><br>
            {{ $worksheet->notes ?? '' }}
        </td>
        <td class="notes-box" style="width:58%;">
            <b class="tiny">Calculated by:</b>
            <span class="line" style="width:180px;">{{ $worksheet->calculated_by ?? '' }}</span>

            <br><br>

            <div class="tiny">
                <b>ppm Histamine = (C x E x 50 x 50)/(D x 5 x 1 x W)</b><br>
                <b>Where:</b>
                &nbsp;&nbsp;&nbsp; C - amount of histamine from calibration curve (corrected)
                &nbsp;&nbsp;&nbsp; D - total solution volume after dilution (ml)<br>
                &nbsp;&nbsp;&nbsp; W - Weight of sample
                &nbsp;&nbsp;&nbsp; E - Eluate solution volume for dilution (ml)
                &nbsp;&nbsp;&nbsp; E and D is 1 if no dilution
            </div>
        </td>
    </tr>
</table>

<table class="no-border mt-8">
    <tr>
        <td class="center bold tiny">Analyzed by:</td>
        <td class="center bold tiny">Analyzed by:</td>
        <td class="center bold tiny">Checked by:</td>
    </tr>
    <tr>
        <td class="center">
            <span class="signature-line">{{ $worksheet->analyst ?? '' }}</span>
        </td>
        <td class="center">
            <span class="signature-line">{{ $worksheet->analyst_2 ?? '' }}</span>
        </td>
        <td class="center">
            <span class="signature-line">{{ $worksheet->checked_by ?? '' }}</span>
        </td>
    </tr>
</table>

</body>
</html>