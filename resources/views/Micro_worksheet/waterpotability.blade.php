@extends('layouts.app')

@section('content')
@php
    function wpJson($value) {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    function wpVal($array, $index, $default = '') {
        return isset($array[$index]) && $array[$index] !== null && $array[$index] !== ''
            ? $array[$index]
            : $default;
    }

    function wpDateTimeValue($value) {
        if (empty($value)) {
            return '';
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d\TH:i');
        } catch (\Exception $e) {
            return '';
        }
    }

    $labCodes = wpJson($rla->laboratory_code ?? null);
    $firstLabCode = $labCodes[0] ?? '';

    $hpcDilution = $worksheet ? wpJson($worksheet->hpc_dilution ?? null) : [];
    $hpcR1 = $worksheet ? wpJson($worksheet->hpc_r1 ?? null) : [];
    $hpcR2 = $worksheet ? wpJson($worksheet->hpc_r2 ?? null) : [];

    $dsLstBroth = $worksheet ? wpJson($worksheet->ds_lst_broth ?? null) : [];
    $bglbBroth = $worksheet ? wpJson($worksheet->bglb_broth ?? null) : [];
    $ecBroth = $worksheet ? wpJson($worksheet->ec_broth ?? null) : [];
    $embPlate = $worksheet ? wpJson($worksheet->emb_plate ?? null) : [];
    $dsAzide = $worksheet ? wpJson($worksheet->ds_azide_dextrose_broth ?? null) : [];
    $evaBroth = $worksheet ? wpJson($worksheet->eva_broth ?? null) : [];

    $qcNegative = $worksheet ? wpJson($worksheet->qc_negative ?? null) : [];
    $qcPositive = $worksheet ? wpJson($worksheet->qc_positive ?? null) : [];
    $qcRemarks = $worksheet ? wpJson($worksheet->qc_remarks ?? null) : [];

    $confirmLabCode = $worksheet ? wpJson($worksheet->confirm_lab_code ?? null) : [];
    $gramReaction = $worksheet ? wpJson($worksheet->gram_reaction ?? null) : [];
    $indoleProduction = $worksheet ? wpJson($worksheet->indole_production ?? null) : [];
    $vogesProskauer = $worksheet ? wpJson($worksheet->voges_proskauer ?? null) : [];
    $methylRed = $worksheet ? wpJson($worksheet->methyl_red ?? null) : [];
    $citrateUtilization = $worksheet ? wpJson($worksheet->citrate_utilization ?? null) : [];
    $gasProduction = $worksheet ? wpJson($worksheet->gas_production ?? null) : [];
    $confirmResult = $worksheet ? wpJson($worksheet->confirm_result ?? null) : [];

    $hpcDefaultDilutions = ['10⁰', '10⁻¹', '10⁻²', '10⁻³'];

    $confirmRows = max(count($labCodes), count($confirmLabCode), 3);

    $dateTimeStarted = old(
        'date_time_started',
        wpDateTimeValue($worksheet->date_time_started ?? '')
    );

    $dateTimeFinished = old(
        'date_time_finished',
        wpDateTimeValue($worksheet->date_time_finished ?? '')
    );
@endphp

<style>
    .wp-screen {
        width: 100%;
        overflow-x: auto;
        padding: 20px 0 50px;
        background: #f5f6fa;
    }

    .wp-scale-wrap {
        width: 1450px;
        margin: 0 auto;
        transform-origin: top center;
    }

    .wp-page {
        width: 1450px;
        background: #fff;
        color: #000;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        padding: 24px;
        box-sizing: border-box;
    }

    .wp-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .wp-table td,
    .wp-table th {
        border: 1px solid #000;
        padding: 4px 5px;
        vertical-align: middle;
        color: #000;
        line-height: 1.15;
        font-size: 12px;
        box-sizing: border-box;
        overflow: hidden;
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
        font-size: 9px !important;
        line-height: 1.1;
    }

    .small {
        font-size: 11px !important;
    }

    .logo-cell {
        width: 170px;
        text-align: center;
    }

    .logo-cell img {
        width: 100px;
        height: auto;
    }

    .header-text {
        text-align: center;
        font-size: 14px;
        line-height: 1.08;
    }

    .doc-table td {
        height: 34px;
        font-size: 12px;
    }

    .info-table {
        margin-top: 32px;
    }

    .info-table td {
        height: 46px;
        font-size: 12px;
        white-space: nowrap;
        overflow: visible;
    }

    .info-label {
        display: inline-block;
        margin-right: 8px;
        font-weight: bold;
    }

    .input-cell {
        width: 100%;
        min-height: 26px;
        border: none;
        outline: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        font-size: 12px;
        text-align: center;
        padding: 2px 3px;
        color: #000;
        box-sizing: border-box;
    }

    .input-cell-left {
        text-align: left;
    }

    .date-input {
        width: 190px;
        min-height: 28px;
        font-size: 12px;
        border: none;
        outline: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        color: #000;
        box-sizing: border-box;
    }

    .input-line {
        width: 140px;
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        font-size: 12px;
        text-align: center;
        color: #000;
    }

    .textarea-cell {
        width: 100%;
        height: 130px;
        border: none;
        outline: none;
        resize: none;
        font-family: "Times New Roman", serif;
        font-size: 12px;
        box-sizing: border-box;
        background: transparent;
    }

    .hpc-table td,
    .hpc-table th {
        height: 34px;
        font-size: 11px;
        white-space: nowrap;
    }

    .hpc-table .dotted-row td {
        border-bottom: 1px dotted #000;
    }

    .qc-title {
        margin-top: 16px;
        border: 1px solid #000;
        border-bottom: none;
        text-align: center;
        font-weight: bold;
        font-size: 22px;
        padding: 6px 0;
    }

    .qc-table th,
    .qc-table td {
        font-size: 9.5px;
        padding: 3px 2px;
        height: 40px;
        line-height: 1.08;
        text-align: center;
        overflow: hidden;
        word-break: normal;
        overflow-wrap: normal;
    }

    .qc-table .qc-left {
        font-size: 12px;
        text-align: left;
        padding-left: 6px;
    }

    .qc-input {
        width: 100%;
        height: 28px;
        border: none;
        outline: none;
        background: transparent;
        font-size: 10px;
        text-align: center;
        font-family: "Times New Roman", serif;
        padding: 0;
        box-sizing: border-box;
    }

    .controls-area {
        margin-top: 20px;
        padding-left: 55px;
        font-size: 13px;
        line-height: 1.9;
    }

    .confirm-title {
        text-align: center;
        font-weight: bold;
        margin-top: 18px;
        font-size: 16px;
    }

    .confirm-table th,
    .confirm-table td {
        font-size: 11px;
        height: 34px;
        text-align: center;
    }

    .calculations-table th {
        font-size: 15px;
        text-align: center;
        height: 30px;
    }

    .calculations-table td {
        height: 130px;
        vertical-align: top;
    }

    .signature-table {
        margin-top: 36px;
    }

    .signature-table td {
        border: none !important;
        text-align: center;
        font-size: 13px;
        overflow: visible;
    }

    .signature-select {
        width: 300px;
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        text-align: center;
        font-family: "Times New Roman", serif;
        font-size: 13px;
        background: transparent;
        padding: 5px;
        color: #000;
    }

    .save-area {
        width: 1450px;
        margin: 15px auto 40px;
        text-align: right;
    }

    .btn-save {
        background: #198754;
        color: #fff;
        border: none;
        padding: 12px 28px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
    }

    .alert-success-custom {
        width: 1450px;
        margin: 15px auto;
        padding: 12px;
        background: #d1e7dd;
        border: 1px solid #badbcc;
        color: #0f5132;
        font-size: 14px;
    }

    .alert-error-custom {
        width: 1450px;
        margin: 15px auto;
        padding: 12px;
        background: #f8d7da;
        border: 1px solid #f5c2c7;
        color: #842029;
        font-size: 14px;
    }

    @media (max-width: 1500px) {
        .save-area,
        .alert-success-custom,
        .alert-error-custom {
            width: calc(100% - 20px);
        }
    }
</style>

<div class="card-header d-flex justify-content-between">
    <a class="btn btn-sm btn-secondary"
        style="margin-left:8mm"
        href="/analyst_worksheet"
        title="return">
        Back
    </a>
</div>


<form action="{{ route('water_potability_worksheet.store', $rla->id) }}" method="POST">
    @csrf

    <input type="hidden" name="user_id" value="{{ $rla->user_id }}">
    <input type="hidden" name="rla_no" value="{{ $rla->RLA_no }}">

    <div class="wp-screen" id="wpScreen">
        <div class="wp-scale-wrap" id="wpScaleWrap">
            <div class="wp-page">

                {{-- HEADER --}}
                <table class="wp-table">
                    <tr>
                        <td class="logo-cell">
                            <img src="{{ asset('assets/images/bfarlogo.png') }}" alt="BFAR Logo" onerror="this.style.display='none'">
                        </td>
                        <td class="header-text">
                            <div>Republic of the Philippines</div>
                            <div>Department of Agriculture</div>
                            <div class="bold">BUREAU OF FISHERIES AND AQUATIC RESOURCES</div>
                            <div class="bold">REGIONAL FISHERIES LABORATORY XII</div>
                            <div>J. Catolico St., Lagao, General Santos City</div>
                        </td>
                    </tr>
                </table>

                <table class="wp-table doc-table">
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
                <table class="wp-table info-table">
                    <tr>
                        <td style="width:25%;">
                            <span class="info-label">RLA No.:</span>
                            <input type="text" name="rla_no" class="input-cell"
                                   value="{{ old('rla_no', $worksheet->rla_no ?? $rla->RLA_no ?? '') }}">
                        </td>

                        <td style="width:25%;">
                            <span class="info-label">Lab Code:</span>
                            <input type="text" name="lab_code" class="input-cell"
                                   value="{{ old('lab_code', $worksheet->lab_code ?? $firstLabCode) }}">
                        </td>

                        <td style="width:25%;">
                            <span class="info-label">Date/Time Started:</span>
                            <input type="datetime-local"
                                   name="date_time_started"
                                   class="date-input"
                                   value="{{ $dateTimeStarted }}">
                        </td>

                        <td style="width:25%;">
                            <span class="info-label">Date/Time Finished:</span>
                            <input type="datetime-local"
                                   name="date_time_finished"
                                   class="date-input"
                                   value="{{ $dateTimeFinished }}">
                        </td>
                    </tr>
                </table>

                {{-- HPC --}}
                <table class="wp-table hpc-table">
                    <colgroup>
                        <col style="width:11%;">
                        <col style="width:11%;">
                        <col style="width:11%;">
                        <col style="width:11%;">
                        <col style="width:11%;">
                        <col style="width:11%;">
                        <col style="width:11%;">
                        <col style="width:11%;">
                        <col style="width:12%;">
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
                            <td>
                                <input type="text" name="hpc_dilution[]" class="input-cell"
                                       value="{{ old('hpc_dilution.' . $i, wpVal($hpcDilution, $i, $hpcDefaultDilutions[$i] ?? '')) }}">
                            </td>
                            <td>
                                <input type="text" name="hpc_r1[]" class="input-cell"
                                       value="{{ old('hpc_r1.' . $i, wpVal($hpcR1, $i)) }}">
                            </td>
                            <td>
                                <input type="text" name="hpc_r2[]" class="input-cell"
                                       value="{{ old('hpc_r2.' . $i, wpVal($hpcR2, $i)) }}">
                            </td>
                            <td>
                                <input type="text" name="ds_lst_broth[]" class="input-cell"
                                       value="{{ old('ds_lst_broth.' . $i, wpVal($dsLstBroth, $i)) }}">
                            </td>
                            <td>
                                <input type="text" name="bglb_broth[]" class="input-cell"
                                       value="{{ old('bglb_broth.' . $i, wpVal($bglbBroth, $i)) }}">
                            </td>
                            <td>
                                <input type="text" name="ec_broth[]" class="input-cell"
                                       value="{{ old('ec_broth.' . $i, wpVal($ecBroth, $i)) }}">
                            </td>
                            <td>
                                <input type="text" name="emb_plate[]" class="input-cell"
                                       value="{{ old('emb_plate.' . $i, wpVal($embPlate, $i)) }}">
                            </td>
                            <td>
                                <input type="text" name="ds_azide_dextrose_broth[]" class="input-cell"
                                       value="{{ old('ds_azide_dextrose_broth.' . $i, wpVal($dsAzide, $i)) }}">
                            </td>
                            <td>
                                <input type="text" name="eva_broth[]" class="input-cell"
                                       value="{{ old('eva_broth.' . $i, wpVal($evaBroth, $i)) }}">
                            </td>
                        </tr>
                    @endfor

                    <tr>
                        <td colspan="3" class="left">
                            <b>HPC =</b>
                            <input type="text" name="hpc_result" class="input-line"
                                   value="{{ old('hpc_result', $worksheet->hpc_result ?? '') }}">
                            cfu/ml
                        </td>
                        <td colspan="2" class="left">
                            <b>Note:</b><br>
                            <input type="text" name="note" class="input-cell input-cell-left"
                                   value="{{ old('note', $worksheet->note ?? '') }}">
                            <br>
                            <input type="text" name="tube_mpn" class="input-line"
                                   value="{{ old('tube_mpn', $worksheet->tube_mpn ?? '') }}">
                            tube MPN
                        </td>
                        <td class="center">
                            <b>Total Coliform Count</b><br>
                            <span class="tiny">(MPN/100 ml)</span>
                            <input type="text" name="total_coliform_count" class="input-cell"
                                   value="{{ old('total_coliform_count', $worksheet->total_coliform_count ?? '') }}">
                        </td>
                        <td class="center">
                            <b>Fecal Coliform Count</b><br>
                            <span class="tiny">(MPN/100 ml)</span>
                            <input type="text" name="fecal_coliform_count" class="input-cell"
                                   value="{{ old('fecal_coliform_count', $worksheet->fecal_coliform_count ?? '') }}">
                        </td>
                        <td class="center">
                            <b><i>E. coli</i> Count</b><br>
                            <span class="tiny">(MPN/100 ml)</span>
                            <input type="text" name="e_coli_count" class="input-cell"
                                   value="{{ old('e_coli_count', $worksheet->e_coli_count ?? '') }}">
                        </td>
                        <td class="center">
                            <b><i>Enterococci</i> Count</b><br>
                            <span class="tiny">(MPN/100 ml)</span>
                            <input type="text" name="enterococci_count" class="input-cell"
                                   value="{{ old('enterococci_count', $worksheet->enterococci_count ?? '') }}">
                        </td>
                    </tr>
                </table>

                {{-- QC RESULTS --}}
                <div class="qc-title">QC RESULTS</div>

                <table class="wp-table qc-table">
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
                        <th>Gram<br>Reaction</th>
                        <th>TB/<br>Indole<br>Test</th>
                        <th>MRVP<br>Broth/<br>MR Test</th>
                        <th>VP<br>Test</th>
                        <th>KSB/<br>CSA/<br>Citrate Test</th>
                        <th>LST<br>Broth/<br>Gas Production</th>
                        <th>DS Azide<br>Dextrose Broth</th>
                        <th>EVA<br>Broth</th>
                    </tr>

                    <tr>
                        <td class="qc-left">Negative Control Organism</td>
                        @for($i = 0; $i < 13; $i++)
                            <td>
                                <input type="text" name="qc_negative[]" class="qc-input"
                                       value="{{ old('qc_negative.' . $i, wpVal($qcNegative, $i)) }}">
                            </td>
                        @endfor
                    </tr>

                    <tr>
                        <td class="qc-left">Positive Control Organism</td>
                        @for($i = 0; $i < 13; $i++)
                            <td>
                                <input type="text" name="qc_positive[]" class="qc-input"
                                       value="{{ old('qc_positive.' . $i, wpVal($qcPositive, $i)) }}">
                            </td>
                        @endfor
                    </tr>

                    <tr>
                        <td class="qc-left">Remarks</td>
                        @for($i = 0; $i < 13; $i++)
                            <td>
                                <input type="text" name="qc_remarks[]" class="qc-input"
                                       value="{{ old('qc_remarks.' . $i, wpVal($qcRemarks, $i)) }}">
                            </td>
                        @endfor
                    </tr>
                </table>

                {{-- CONTROLS --}}
                <div class="controls-area">
                    <div>
                        <b>Culture Media Batch No.</b>
                        <input type="text" name="culture_media_batch_no" class="input-line"
                               value="{{ old('culture_media_batch_no', $worksheet->culture_media_batch_no ?? '') }}">
                    </div>

                    <div>
                        <b>Air Control</b> (15 m open plate exposure):
                        <input type="text" name="air_control" class="input-line"
                               value="{{ old('air_control', $worksheet->air_control ?? '') }}">

                        <b>Isolation Room</b>
                        <input type="text" name="isolation_room" class="input-line"
                               value="{{ old('isolation_room', $worksheet->isolation_room ?? '') }}">

                        <b>Biosafety Cabinet</b>
                        <input type="text" name="biosafety_cabinet" class="input-line"
                               value="{{ old('biosafety_cabinet', $worksheet->biosafety_cabinet ?? '') }}">
                    </div>

                    <div>
                        <b>Medium Control</b>
                        <input type="text" name="medium_control" class="input-line"
                               value="{{ old('medium_control', $worksheet->medium_control ?? '') }}">

                        <b>Diluent Control</b>
                        <input type="text" name="diluent_control" class="input-line"
                               value="{{ old('diluent_control', $worksheet->diluent_control ?? '') }}">
                    </div>
                </div>

                {{-- CONFIRMATORY --}}
                <div class="confirm-title">
                    CONFIRMATORY TESTS for <i>Escherichia coli</i>
                </div>

                <table class="wp-table confirm-table">
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
                            <td>
                                <input type="text" name="confirm_lab_code[]" class="input-cell"
                                       value="{{ old('confirm_lab_code.' . $i, wpVal($confirmLabCode, $i, $labCodes[$i] ?? '')) }}">
                            </td>
                            <td>
                                <input type="text" name="gram_reaction[]" class="input-cell"
                                       value="{{ old('gram_reaction.' . $i, wpVal($gramReaction, $i)) }}">
                            </td>
                            <td>
                                <input type="text" name="indole_production[]" class="input-cell"
                                       value="{{ old('indole_production.' . $i, wpVal($indoleProduction, $i)) }}">
                            </td>
                            <td>
                                <input type="text" name="voges_proskauer[]" class="input-cell"
                                       value="{{ old('voges_proskauer.' . $i, wpVal($vogesProskauer, $i)) }}">
                            </td>
                            <td>
                                <input type="text" name="methyl_red[]" class="input-cell"
                                       value="{{ old('methyl_red.' . $i, wpVal($methylRed, $i)) }}">
                            </td>
                            <td>
                                <input type="text" name="citrate_utilization[]" class="input-cell"
                                       value="{{ old('citrate_utilization.' . $i, wpVal($citrateUtilization, $i)) }}">
                            </td>
                            <td>
                                <input type="text" name="gas_production[]" class="input-cell"
                                       value="{{ old('gas_production.' . $i, wpVal($gasProduction, $i)) }}">
                            </td>
                            <td>
                                <input type="text" name="confirm_result[]" class="input-cell"
                                       value="{{ old('confirm_result.' . $i, wpVal($confirmResult, $i)) }}">
                            </td>
                        </tr>
                    @endfor
                </table>

                <table class="wp-table calculations-table">
                    <tr>
                        <th>CALCULATIONS</th>
                    </tr>
                    <tr>
                        <td>
                            <textarea name="calculations" class="textarea-cell">{{ old('calculations', $worksheet->calculations ?? '') }}</textarea>
                        </td>
                    </tr>
                </table>

                {{-- SIGNATURES --}}
                <table class="wp-table signature-table">
                    <tr>
                        <td style="width:50%;" class="bold">
                            Analyzed by:
                        </td>
                        <td style="width:50%;" class="bold">
                            Checked by:
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="analyzed_by" class="signature-select">
                                <option value="">Select Analyst</option>
                                @foreach($users as $user)
                                    @php
                                        $fullName = trim(($user->f_name ?? '') . ' ' . ($user->m_name ?? '') . ' ' . ($user->l_name ?? ''));
                                    @endphp
                                    <option value="{{ $fullName }}"
                                        {{ old('analyzed_by', $worksheet->analyzed_by ?? '') == $fullName ? 'selected' : '' }}>
                                        {{ $fullName }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="checked_by" class="signature-select">
                                <option value="">Select Checker</option>
                                @foreach($users as $user)
                                    @php
                                        $fullName = trim(($user->f_name ?? '') . ' ' . ($user->m_name ?? '') . ' ' . ($user->l_name ?? ''));
                                    @endphp
                                    <option value="{{ $fullName }}"
                                        {{ old('checked_by', $worksheet->checked_by ?? '') == $fullName ? 'selected' : '' }}>
                                        {{ $fullName }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

    <div class="save-area">
        <button type="submit" class="btn-save">Save Worksheet</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const screen = document.getElementById('wpScreen');
        const wrap = document.getElementById('wpScaleWrap');

        function scaleWorksheet() {
            if (!screen || !wrap) {
                return;
            }

            const baseWidth = 1450;
            const availableWidth = screen.clientWidth - 20;
            const scale = Math.min(1, availableWidth / baseWidth);

            wrap.style.transform = 'scale(' + scale + ')';
            wrap.style.height = (wrap.scrollHeight * scale) + 'px';
        }

        scaleWorksheet();
        window.addEventListener('resize', scaleWorksheet);
    });
</script>
@endsection