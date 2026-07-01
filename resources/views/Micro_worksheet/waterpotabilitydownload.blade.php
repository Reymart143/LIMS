<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 18px 22px;
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
            padding: 2px 3px;
            vertical-align: middle;
            color: #000;
            line-height: 1.05;
            box-sizing: border-box;
            font-family: Cambria, "Times New Roman", serif;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .bold {
            font-weight: bold;
        }

        .tiny {
            font-size: 6.5px;
            line-height: 1.05;
        }

        .small {
            font-size: 8px;
        }

        /* HEADER SAME SA IMONG SAMPLE */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .header-table td {
            border: 1px solid #000;
            height: 70px;
            vertical-align: middle;
        }

        .logo-cell {
            width: 145px;
            text-align: center;
        }

        .logo {
            width: 72px;
            height: auto;
        }

        .header-text {
            text-align: left;
            font-size: 10px;
            line-height: 1.08;
            padding-left: 8px;
        }

        .doc-table td {
            height: 22px;
            font-size: 8px;
        }

        .info-table {
            margin-top: 28px;
        }

        .info-table td {
            height: 22px;
            font-size: 8px;
        }

        .hpc-table td,
        .hpc-table th {
            height: 17px;
            font-size: 7px;
            padding: 1px 2px;
        }

        .hpc-table .dotted-row td {
            border-bottom: 1px dotted #000;
        }

        .bottom-count {
            height: 38px !important;
            vertical-align: middle;
        }

        .qc-title {
            margin-top: 12px;
            border: 1px solid #000;
            border-bottom: none;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            padding: 3px 0;
        }

        .qc-table th,
        .qc-table td {
            font-size: 6px;
            padding: 1px;
            height: 20px;
            line-height: 1.05;
            text-align: center;
        }

        .qc-table .qc-left {
            font-size: 7px;
            text-align: left;
            padding-left: 3px;
        }

        .controls-area {
            margin-top: 15px;
            margin-left: 35px;
            font-size: 8px;
            line-height: 1.6;
        }

        .line {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 95px;
            min-height: 9px;
            padding: 0 3px;
            text-align: center;
        }

        .line-sm {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 75px;
            min-height: 9px;
            padding: 0 3px;
            text-align: center;
        }

        .line-lg {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 130px;
            min-height: 9px;
            padding: 0 3px;
            text-align: center;
        }

        .confirm-title {
            text-align: center;
            font-weight: bold;
            margin-top: 13px;
            font-size: 9px;
        }

        .confirm-table th,
        .confirm-table td {
            font-size: 7px;
            height: 16px;
            text-align: center;
            padding: 1px 2px;
        }

        .calculations-table th {
            font-size: 9px;
            text-align: center;
            height: 18px;
        }

        .calculations-table td {
            height: 78px;
            vertical-align: top;
            font-size: 8px;
            white-space: pre-wrap;
        }

        .signature-table {
            margin-top: 24px;
        }

        .signature-table td {
            border: none !important;
            text-align: center;
            font-size: 8px;
            vertical-align: top;
        }

        .signature-name {
            width: 160px;
            margin: 22px auto 0;
            text-align: center;
            font-size: 8px;
            min-height: 10px;
        }
    .pcr-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .pcr-table td,
    .pcr-table th {
        border: 1px solid #000;
        padding: 4px;
        vertical-align: middle;
        font-size: 12px;
        line-height: 1.1;
        color: #000;
    }
        .signature-line {
            border-top: 1px solid #000;
            width: 160px;
            margin: 2px auto 0;
            height: 4px;
        }
    </style>
</head>

<body>
@php
    function wpDownloadJson($value) {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    function wpDownloadVal($array, $index, $default = '') {
        return isset($array[$index]) && $array[$index] !== null && $array[$index] !== ''
            ? $array[$index]
            : $default;
    }

    function wpDownloadDateTime($value) {
        if (empty($value)) {
            return '';
        }

        try {
            return \Carbon\Carbon::parse($value)->format('m/d/Y h:i A');
        } catch (\Exception $e) {
            return $value;
        }
    }

    $labCodes = wpDownloadJson($rla->laboratory_code ?? null);
    $firstLabCode = $labCodes[0] ?? '';

    $hpcDilution = wpDownloadJson($worksheet->hpc_dilution ?? null);
    $hpcR1 = wpDownloadJson($worksheet->hpc_r1 ?? null);
    $hpcR2 = wpDownloadJson($worksheet->hpc_r2 ?? null);

    $dsLstBroth = wpDownloadJson($worksheet->ds_lst_broth ?? null);
    $bglbBroth = wpDownloadJson($worksheet->bglb_broth ?? null);
    $ecBroth = wpDownloadJson($worksheet->ec_broth ?? null);
    $embPlate = wpDownloadJson($worksheet->emb_plate ?? null);
    $dsAzide = wpDownloadJson($worksheet->ds_azide_dextrose_broth ?? null);
    $evaBroth = wpDownloadJson($worksheet->eva_broth ?? null);

    $qcNegative = wpDownloadJson($worksheet->qc_negative ?? null);
    $qcPositive = wpDownloadJson($worksheet->qc_positive ?? null);
    $qcRemarks = wpDownloadJson($worksheet->qc_remarks ?? null);

    $confirmLabCode = wpDownloadJson($worksheet->confirm_lab_code ?? null);
    $gramReaction = wpDownloadJson($worksheet->gram_reaction ?? null);
    $indoleProduction = wpDownloadJson($worksheet->indole_production ?? null);
    $vogesProskauer = wpDownloadJson($worksheet->voges_proskauer ?? null);
    $methylRed = wpDownloadJson($worksheet->methyl_red ?? null);
    $citrateUtilization = wpDownloadJson($worksheet->citrate_utilization ?? null);
    $gasProduction = wpDownloadJson($worksheet->gas_production ?? null);
    $confirmResult = wpDownloadJson($worksheet->confirm_result ?? null);

    $hpcDefaultDilutions = ['10⁰', '10⁻¹', '10⁻²', '10⁻³'];

    $confirmRows = max(count($labCodes), count($confirmLabCode), 3);

    $rlaNo = $worksheet->rla_no ?? $rla->RLA_no ?? '';
    $labCode = $worksheet->lab_code ?? $firstLabCode;

    $dateStarted = wpDownloadDateTime($worksheet->date_time_started ?? '');
    $dateFinished = wpDownloadDateTime($worksheet->date_time_finished ?? '');
@endphp

{{-- HEADER --}}
   <table class="pcr-table">
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

<table class="doc-table">
    <tr>
        <td style="width:23%;">
            Document Type<br>
            <b>Laboratory Form</b>
        </td>
        <td style="width:24%;">
            Revision No:<br>
            0
        </td>
        <td style="width:32%;">
            Date Adopted:<br>
            13 August 2019
        </td>
        <td style="width:21%;">
            Page No:
        </td>
    </tr>
    <tr>
        <td>
            Document Code:<br>
            <b>LF W01-MIC-02</b>
        </td>
        <td colspan="3" class="center bold">
            ANALYST WORKSHEET FOR BACTERIOLOGICAL<br>
            EXAMINATION OF WATER
        </td>
    </tr>
</table>

{{-- INFO --}}
<table class="info-table">
    <tr>
        <td style="width:25%;">
            <b>RLA No.:</b>
            <span style="margin-left:45px;">{{ $rlaNo }}</span>
        </td>
        <td style="width:25%;">
            <b>Lab Code:</b>
            <span style="margin-left:45px;">{{ $labCode }}</span>
        </td>
        <td style="width:25%;">
            <b>Date/Time Started:</b>
            <span style="margin-left:25px;">{{ $dateStarted }}</span>
        </td>
        <td style="width:25%;">
            <b>Date/Time Finished:</b>
            <span style="margin-left:25px;">{{ $dateFinished }}</span>
        </td>
    </tr>
</table>

{{-- HPC --}}
<table class="hpc-table">
    <colgroup>
        <col style="width:11%;">
        <col style="width:8%;">
        <col style="width:8%;">
        <col style="width:13%;">
        <col style="width:13%;">
        <col style="width:13%;">
        <col style="width:13%;">
        <col style="width:13%;">
        <col style="width:8%;">
    </colgroup>

    <tr>
        <th colspan="3" class="left">Heterotrophic Plate Count</th>
        <th colspan="6" class="center">No. of Positive (+) Replicates</th>
    </tr>
    <tr>
        <th>Dilution</th>
        <th>R1</th>
        <th>R2</th>
        <th>DS LST Broth</th>
        <th>BGLB Broth</th>
        <th>EC Broth</th>
        <th>EMB Plate</th>
        <th>DS Azide Dextrose Broth</th>
        <th>EVA Broth</th>
    </tr>

    @for($i = 0; $i < 4; $i++)
        <tr class="dotted-row">
            <td class="center">{{ wpDownloadVal($hpcDilution, $i, $hpcDefaultDilutions[$i] ?? '') }}</td>
            <td class="center">{{ wpDownloadVal($hpcR1, $i) }}</td>
            <td class="center">{{ wpDownloadVal($hpcR2, $i) }}</td>
            <td class="center">{{ wpDownloadVal($dsLstBroth, $i) }}</td>
            <td class="center">{{ wpDownloadVal($bglbBroth, $i) }}</td>
            <td class="center">{{ wpDownloadVal($ecBroth, $i) }}</td>
            <td class="center">{{ wpDownloadVal($embPlate, $i) }}</td>
            <td class="center">{{ wpDownloadVal($dsAzide, $i) }}</td>
            <td class="center">{{ wpDownloadVal($evaBroth, $i) }}</td>
        </tr>
    @endfor

    <tr>
        <td colspan="3" class="bottom-count">
            <b>HPC =</b>
            <span class="line-lg">{{ $worksheet->hpc_result ?? '' }}</span>
            cfu/ml
        </td>
        <td colspan="2" class="bottom-count">
            <b>Note:</b><br>
            {{ $worksheet->note ?? '' }}
            <br>
            <span class="line-lg">{{ $worksheet->tube_mpn ?? '' }}</span>
            tube MPN
        </td>
        <td class="center bottom-count">
            <b>Total Coliform Count</b><br>
            <span class="tiny">(MPN/100 ml)</span><br>
            {{ $worksheet->total_coliform_count ?? '' }}
        </td>
        <td class="center bottom-count">
            <b>Fecal Coliform Count</b><br>
            <span class="tiny">(MPN/100 ml)</span><br>
            {{ $worksheet->fecal_coliform_count ?? '' }}
        </td>
        <td class="center bottom-count">
            <b><i>E. coli</i> Count</b><br>
            <span class="tiny">(MPN/100 ml)</span><br>
            {{ $worksheet->e_coli_count ?? '' }}
        </td>
        <td class="center bottom-count">
            <b><i>Enterococci</i> Count</b><br>
            <span class="tiny">(MPN/100 ml)</span><br>
            {{ $worksheet->enterococci_count ?? '' }}
        </td>
    </tr>
</table>

{{-- QC RESULTS --}}
<div class="qc-title">QC RESULTS</div>

<table class="qc-table">
    <colgroup>
        <col style="width:12%;">
        <col style="width:5%;">
        <col style="width:6%;">
        <col style="width:6%;">
        <col style="width:6%;">
        <col style="width:5.5%;">
        <col style="width:5.5%;">
        <col style="width:5.5%;">
        <col style="width:6%;">
        <col style="width:5%;">
        <col style="width:6%;">
        <col style="width:7%;">
        <col style="width:7%;">
        <col style="width:6.5%;">
    </colgroup>

    <tr>
        <th rowspan="2" class="qc-left">QC Check</th>
        <th rowspan="2">HPC<br>PCA</th>
        <th colspan="1">Presump-<br>tive Test</th>
        <th>Total<br>Coliform</th>
        <th>Fecal<br>Coliform</th>
        <th colspan="7"><i>E. coli</i></th>
        <th colspan="2"><i>Enterococci</i></th>
    </tr>

    <tr>
        <th>DS LST<br>Broth</th>
        <th>BGLB</th>
        <th>EC<br>Broth</th>
        <th>EMB<br>Agar</th>
        <th>Gram<br>React<br>-ion</th>
        <th>TB/<br>Indole<br>Test</th>
        <th>MRVP<br>Broth/<br>MR<br>Test</th>
        <th>VP<br>Test</th>
        <th>KSB/<br>CSA/<br>Citrate<br>Test</th>
        <th>LST<br>Broth/<br>Gas<br>Producti<br>on</th>
        <th>DS Azide<br>Dextrose<br>Broth</th>
        <th>EVA<br>Broth</th>
    </tr>

    <tr>
        <td class="qc-left">Negative Control Organism</td>
        @for($i = 0; $i < 13; $i++)
            <td>{{ wpDownloadVal($qcNegative, $i) }}</td>
        @endfor
    </tr>

    <tr>
        <td class="qc-left">Positive Control Organism</td>
        @for($i = 0; $i < 13; $i++)
            <td>{{ wpDownloadVal($qcPositive, $i) }}</td>
        @endfor
    </tr>

    <tr>
        <td class="qc-left">Remarks</td>
        @for($i = 0; $i < 13; $i++)
            <td>{{ wpDownloadVal($qcRemarks, $i) }}</td>
        @endfor
    </tr>
</table>

{{-- CONTROLS --}}
<div class="controls-area">
    <div>
        <b>Culture Media Batch No.</b>
        <span class="line-lg">{{ $worksheet->culture_media_batch_no ?? '' }}</span>
    </div>

    <div>
        <b>Air Control</b> (15 m open plate exposure):
        <span class="line">{{ $worksheet->air_control ?? '' }}</span>

        <b>Isolation Room</b>
        <span class="line">{{ $worksheet->isolation_room ?? '' }}</span>

        <b>Biosafety Cabinet</b>
        <span class="line">{{ $worksheet->biosafety_cabinet ?? '' }}</span>
    </div>

    <div>
        <b>Medium Control</b>
        <span class="line">{{ $worksheet->medium_control ?? '' }}</span>

        <b>Diluent Control</b>
        <span class="line">{{ $worksheet->diluent_control ?? '' }}</span>
    </div>
</div>

{{-- CONFIRMATORY --}}
<div class="confirm-title">
    CONFIRMATORY TESTS for <i>Escherichia coli</i>
</div>

<table class="confirm-table">
    <tr>
        <th style="width:14%;">LABORATORY CODE</th>
        <th>Gram Reaction</th>
        <th>Indole Production</th>
        <th>Vogues-Proskauer</th>
        <th>Methyl Red</th>
        <th>Citrate Utilization</th>
        <th>Gas Production</th>
        <th>Result</th>
    </tr>

    @for($i = 0; $i < $confirmRows; $i++)
        <tr>
            <td>{{ wpDownloadVal($confirmLabCode, $i, $labCodes[$i] ?? '') }}</td>
            <td>{{ wpDownloadVal($gramReaction, $i) }}</td>
            <td>{{ wpDownloadVal($indoleProduction, $i) }}</td>
            <td>{{ wpDownloadVal($vogesProskauer, $i) }}</td>
            <td>{{ wpDownloadVal($methylRed, $i) }}</td>
            <td>{{ wpDownloadVal($citrateUtilization, $i) }}</td>
            <td>{{ wpDownloadVal($gasProduction, $i) }}</td>
            <td>{{ wpDownloadVal($confirmResult, $i) }}</td>
        </tr>
    @endfor
</table>

<table class="calculations-table">
    <tr>
        <th>CALCULATIONS</th>
    </tr>
    <tr>
        <td>{{ $worksheet->calculations ?? '' }}</td>
    </tr>
</table>

{{-- SIGNATURES --}}
<table class="signature-table">
    <tr>
        <td style="width:50%;">
            <b>Analyzed by:</b>

            <div class="signature-name">
                {{ $worksheet->analyzed_by ?? '' }}
            </div>
            <div class="signature-line"></div>
        </td>

        <td style="width:50%;">
            <b>Checked by:</b>

            <div class="signature-name">
                {{ $worksheet->checked_by ?? '' }}
            </div>
            <div class="signature-line"></div>
        </td>
    </tr>
</table>

</body>
</html>