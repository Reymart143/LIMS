@extends('layouts.app')
@section('content')
@php
    function histamineJson($value) {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    $calTarget = $worksheet ? histamineJson($worksheet->calibration_target_concentration ?? null) : [];
    $calActual = $worksheet ? histamineJson($worksheet->calibration_actual_concentration ?? null) : [];
    $calRfu = $worksheet ? histamineJson($worksheet->calibration_rfu ?? null) : [];

    $qcLabel = $worksheet ? histamineJson($worksheet->qc_label ?? null) : [];
    $qcMass = $worksheet ? histamineJson($worksheet->qc_mass_sample ?? null) : [];
    $qcRfu = $worksheet ? histamineJson($worksheet->qc_rfu ?? null) : [];
    $qcCurve = $worksheet ? histamineJson($worksheet->qc_histamine_from_curve ?? null) : [];
    $qcCorrected = $worksheet ? histamineJson($worksheet->qc_corrected_histamine ?? null) : [];
    $qcOnSample = $worksheet ? histamineJson($worksheet->qc_histamine_on_sample ?? null) : [];
    $qcAverage = $worksheet ? histamineJson($worksheet->qc_average_histamine_conc ?? null) : [];
    $qcRemarks = $worksheet ? histamineJson($worksheet->qc_remarks ?? null) : [];

    $sampleLabCode = $worksheet ? histamineJson($worksheet->sample_laboratory_code ?? null) : [];
    $sampleMass = $worksheet ? histamineJson($worksheet->sample_mass_sample ?? null) : [];
    $sampleRfu = $worksheet ? histamineJson($worksheet->sample_rfu ?? null) : [];
    $sampleCurve = $worksheet ? histamineJson($worksheet->sample_histamine_from_curve ?? null) : [];
    $sampleCorrected = $worksheet ? histamineJson($worksheet->sample_corrected_histamine ?? null) : [];
    $sampleOnSample = $worksheet ? histamineJson($worksheet->sample_histamine_on_sample ?? null) : [];
    $sampleAverage = $worksheet ? histamineJson($worksheet->sample_average_histamine_conc ?? null) : [];
    $sampleRemarks = $worksheet ? histamineJson($worksheet->sample_remarks ?? null) : [];

    $laboratoryCodes = histamineJson($rla->laboratory_code ?? null);
    $defaultTargets = ['Blank', '0.01', '0.05', '0.10', '0.20', '0.30'];
@endphp

<style>
    .signature-select {
    width: 300px;
    border: none;
    border-bottom: 1px solid #000;
    outline: none;
    text-align: center;
    font-family: "Times New Roman", serif;
    font-size: 14px;
    background: transparent;
    padding: 4px;
    color: #000;
}
    .histamine-wrapper {
        width: 100%;
        overflow-x: auto;
        padding: 15px 0 40px 0;
    }

    .histamine-page {
        width: 1200px;
        background: #fff;
        margin: 0 auto;
        padding: 0;
        color: #000;
        font-family: "Times New Roman", serif;
        font-size: 15px;
    }

    .histamine-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .histamine-table td,
    .histamine-table th {
        border: 1px solid #000;
        padding: 5px;
        vertical-align: middle;
        line-height: 1.15;
        font-size: 14px;
        color: #000;
    }

    .histamine-table th {
        font-weight: bold;
        text-align: center;
    }

    .no-border,
    .no-border td,
    .no-border th {
        border: none !important;
    }

    .center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    .small {
        font-size: 12px !important;
    }

    .tiny {
        font-size: 11px !important;
    }

    .header-logo {
        width: 170px;
        text-align: center;
    }

    .header-logo img {
        width: 115px;
        height: auto;
    }

    .input-cell {
        width: 100%;
        min-height: 25px;
        border: none;
        outline: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        text-align: center;
        padding: 2px;
        margin: 0;
        color: #000;
        box-sizing: border-box;
    }

    .input-line {
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        padding: 2px 4px;
        color: #000;
        box-sizing: border-box;
    }

    .header-label-cell {
        font-size: 14px;
        vertical-align: top;
        text-align: left;
        padding: 6px 8px !important;
        line-height: 1.2;
    }

    .header-value-cell {
        padding: 0 !important;
        vertical-align: middle;
    }

    .header-input {
        width: 100%;
        height: 100%;
        min-height: 32px;
        border: none;
        outline: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        color: #000;
        padding: 6px 8px;
        box-sizing: border-box;
        text-align: center;
    }

    .textarea-notes {
        width: 100%;
        height: 120px;
        border: none;
        outline: none;
        resize: none;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        background: transparent;
        color: #000;
        box-sizing: border-box;
    }

    .section-title {
        margin-top: 18px;
        margin-left: 38px;
        margin-bottom: 4px;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 15px;
    }

    .indent {
        margin-left: 38px;
        font-size: 15px;
    }

    .dotted td {
        border-top: 1px dotted #000 !important;
        border-bottom: 1px dotted #000 !important;
    }

    .save-area {
        width: 1200px;
        margin: 15px auto 40px auto;
        text-align: right;
    }

    .btn-save {
        background: #198754;
        color: #fff;
        border: none;
        padding: 10px 24px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 15px;
        font-weight: bold;
    }

    .alert-success-custom {
        width: 1200px;
        margin: 15px auto;
        padding: 12px;
        background: #d1e7dd;
        border: 1px solid #badbcc;
        color: #0f5132;
        font-size: 14px;
    }

    .alert-error-custom {
        width: 1200px;
        margin: 15px auto;
        padding: 12px;
        background: #f8d7da;
        border: 1px solid #f5c2c7;
        color: #842029;
        font-size: 14px;
    }

    @media print {
        .btn-save,
        .save-area,
        .alert-success-custom,
        .alert-error-custom {
            display: none !important;
        }

        .histamine-wrapper {
            overflow: visible;
            padding: 0;
        }

        .histamine-page {
            width: 100%;
            margin: 0;
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

{{-- @if($worksheet)
    <div style="background:#d1e7dd; color:#0f5132; padding:10px; width:1200px; margin:10px auto;">
        Worksheet loaded | ID: {{ $worksheet->id }} | Reagent No: {{ $worksheet->reagent_no }}
    </div>
@else
    <div style="background:#f8d7da; color:#842029; padding:10px; width:1200px; margin:10px auto;">
        No worksheet loaded for lf_06_02_id: {{ $rla->id }}
    </div>
@endif --}}
<form action="{{ route('histamine_worksheet.store', $rla->id) }}" method="POST">
    @csrf

    <input type="hidden" name="user_id" value="{{ $rla->user_id }}">
    <input type="hidden" name="rla_no" value="{{ $rla->RLA_no }}">

    <div class="histamine-wrapper">
        <div class="histamine-page">

            {{-- HEADER --}}
            <table class="histamine-table">
                <tr>
                    <td class="header-logo">
                        <img src="{{ asset('assets/images/bfarlogo.png') }}" alt="BFAR Logo" onerror="this.style.display='none'">
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

            <table class="histamine-table">
                <tr>
                    <td style="width:23%;">
                        Document Type<br>
                        <b>Laboratory Form</b>
                    </td>
                    <td style="width:23%;">
                        Revision No:<br>
                        0
                    </td>
                    <td style="width:28%;">
                        Date Adopted:<br>
                        13 Aug 2019
                    </td>
                    <td colspan="3" style="width:26%;">
                        Page No:
                    </td>
                </tr>

                <tr>
                    <td>
                        Document Code:<br>
                        LF W01-CHE-01
                    </td>
                    <td colspan="5" class="center bold">
                        ANALYST WORKSHEET FOR HISTAMINE ANALYSIS
                    </td>
                </tr>

                <tr>
                    <td class="header-label-cell" style="width:13%;">
                        Date / Time<br>started:
                    </td>
                    <td class="header-value-cell" style="width:18%;">
                        {{-- <input type="text" name="date_time_started" class="header-input"
                            value="{{ old('date_time_started', $worksheet->date_time_started ?? '') }}"> --}}

                             <input type="datetime-local" class="header-input"
                            id="date_time_started"
                            name="date_time_started"
                            value="{{ old('date_time_started', !empty($worksheet->date_time_started) ? \Carbon\Carbon::parse($worksheet->date_time_started)->format('Y-m-d\TH:i') : '') }}">
                    </td>

                    <td class="header-label-cell" style="width:16%;">
                        Date / Time<br>finished:
                    </td>
                    <td class="header-value-cell" style="width:18%;">
                    <input type="datetime-local" class="header-input"
                            id="date_time_finished"
                            name="date_time_finished"
                            value="{{ old('date_time_finished', !empty($worksheet->date_time_finished) ? \Carbon\Carbon::parse($worksheet->date_time_finished)->format('Y-m-d\TH:i') : '') }}">
                    </td>

                    <td class="header-label-cell" style="width:14%;">
                        RLA No.:
                    </td>
                    <td class="header-value-cell" style="width:18%;">
                        <input type="text" class="header-input"
                            value="{{ $worksheet->rla_no ?? $rla->RLA_no ?? '' }}" readonly>
                    </td>
                </tr>
            </table>

            <br>

            {{-- REAGENT --}}
            <div class="indent">
                Reagent No
                <input type="text" name="reagent_no" class="input-line" style="width:470px;"
                    value="{{ old('reagent_no', $worksheet->reagent_no ?? '') }}">
                (From LF W01-01)
            </div>

            {{-- CALIBRATION CURVE --}}
            <div class="section-title">Preparation of Calibration Curve</div>

            <div class="indent">
                Mass of standard
                <input type="text" name="mass_of_standard" class="input-line" style="width:170px;"
                    value="{{ old('mass_of_standard', $worksheet->mass_of_standard ?? '') }}">
                grams
            </div>

            <table class="histamine-table" style="margin-top:5px;">
                <thead>
                    <tr>
                        <th style="width:30%;">Target concentration<br>(ppm)</th>
                        <th style="width:35%;">Actual Concentration<br>(ppm)</th>
                        <th style="width:35%;">RFU</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($defaultTargets as $i => $target)
                        <tr class="dotted">
                            <td>
                                <input type="text" name="calibration_target_concentration[]" class="input-cell"
                                    value="{{ old('calibration_target_concentration.' . $i, $calTarget[$i] ?? $target) }}">
                            </td>
                            <td>
                                <input type="text" name="calibration_actual_concentration[]" class="input-cell"
                                    value="{{ old('calibration_actual_concentration.' . $i, $calActual[$i] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="calibration_rfu[]" class="input-cell"
                                    value="{{ old('calibration_rfu.' . $i, $calRfu[$i] ?? '') }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="histamine-table no-border" style="margin-top:6px;">
                <tr>
                    <td style="width:55%; padding-left:38px;">
                        Equation of line
                        <input type="text" name="equation_of_line" class="input-line" style="width:370px;"
                            value="{{ old('equation_of_line', $worksheet->equation_of_line ?? '') }}">
                    </td>
                    <td>
                        R
                        <input type="text" name="r_value" class="input-line" style="width:310px;"
                            value="{{ old('r_value', $worksheet->r_value ?? '') }}">
                    </td>
                </tr>
            </table>

            <br>

            {{-- SPIKED SAMPLE / CCV --}}
            <table class="histamine-table">
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
                    @php
                        $qcDefaultLabels = [
                            'Spiked Sample',
                            'Spiked Sample',
                            'Spiked Sample',
                            'CCV',
                            'CCV',
                            ''
                        ];
                    @endphp

                    @foreach($qcDefaultLabels as $i => $label)
                        <tr>
                            <td class="center bold">
                                <input type="text" name="qc_label[]" class="input-cell bold"
                                    value="{{ old('qc_label.' . $i, $qcLabel[$i] ?? $label) }}">
                            </td>
                            <td>
                                <input type="text" name="qc_mass_sample[]" class="input-cell"
                                    value="{{ old('qc_mass_sample.' . $i, $qcMass[$i] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="qc_rfu[]" class="input-cell"
                                    value="{{ old('qc_rfu.' . $i, $qcRfu[$i] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="qc_histamine_from_curve[]" class="input-cell"
                                    value="{{ old('qc_histamine_from_curve.' . $i, $qcCurve[$i] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="qc_corrected_histamine[]" class="input-cell"
                                    value="{{ old('qc_corrected_histamine.' . $i, $qcCorrected[$i] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="qc_histamine_on_sample[]" class="input-cell"
                                    value="{{ old('qc_histamine_on_sample.' . $i, $qcOnSample[$i] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="qc_average_histamine_conc[]" class="input-cell"
                                    value="{{ old('qc_average_histamine_conc.' . $i, $qcAverage[$i] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="qc_remarks[]" class="input-cell"
                                    value="{{ old('qc_remarks.' . $i, $qcRemarks[$i] ?? '') }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- ANALYSIS OF SAMPLE --}}
            <div class="section-title">Analysis of Sample</div>

            <table class="histamine-table">
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
                    <tr>
                        <td class="center">
                            Reagent Blank
                            <input type="hidden" name="sample_laboratory_code[]" value="Reagent Blank">
                        </td>
                        <td class="center">
                            ---
                            <input type="hidden" name="sample_mass_sample[]" value="---">
                        </td>
                        <td>
                            <input type="text" name="sample_rfu[]" class="input-cell"
                                value="{{ old('sample_rfu.0', $sampleRfu[0] ?? '') }}">
                        </td>
                        <td>
                            <input type="text" name="sample_histamine_from_curve[]" class="input-cell"
                                value="{{ old('sample_histamine_from_curve.0', $sampleCurve[0] ?? '') }}">
                        </td>
                        <td>
                            <input type="text" name="sample_corrected_histamine[]" class="input-cell"
                                value="{{ old('sample_corrected_histamine.0', $sampleCorrected[0] ?? '') }}">
                        </td>
                        <td>
                            <input type="text" name="sample_histamine_on_sample[]" class="input-cell"
                                value="{{ old('sample_histamine_on_sample.0', $sampleOnSample[0] ?? '') }}">
                        </td>
                        <td>
                            <input type="text" name="sample_average_histamine_conc[]" class="input-cell"
                                value="{{ old('sample_average_histamine_conc.0', $sampleAverage[0] ?? '') }}">
                        </td>
                        <td>
                            <input type="text" name="sample_remarks[]" class="input-cell"
                                value="{{ old('sample_remarks.0', $sampleRemarks[0] ?? '') }}">
                        </td>
                    </tr>

                    @php
                        $rowCount = max(count($laboratoryCodes), count($sampleLabCode), 10);
                    @endphp

                    @for($i = 1; $i <= $rowCount; $i++)
                        <tr class="dotted">
                            <td>
                                <input type="text" name="sample_laboratory_code[]" class="input-cell"
                                    value="{{ old('sample_laboratory_code.' . $i, $sampleLabCode[$i] ?? ($laboratoryCodes[$i - 1] ?? '')) }}">
                            </td>
                            <td>
                                <input type="text" name="sample_mass_sample[]" class="input-cell"
                                    value="{{ old('sample_mass_sample.' . $i, $sampleMass[$i] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="sample_rfu[]" class="input-cell"
                                    value="{{ old('sample_rfu.' . $i, $sampleRfu[$i] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="sample_histamine_from_curve[]" class="input-cell"
                                    value="{{ old('sample_histamine_from_curve.' . $i, $sampleCurve[$i] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="sample_corrected_histamine[]" class="input-cell"
                                    value="{{ old('sample_corrected_histamine.' . $i, $sampleCorrected[$i] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="sample_histamine_on_sample[]" class="input-cell"
                                    value="{{ old('sample_histamine_on_sample.' . $i, $sampleOnSample[$i] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="sample_average_histamine_conc[]" class="input-cell"
                                    value="{{ old('sample_average_histamine_conc.' . $i, $sampleAverage[$i] ?? '') }}">
                            </td>
                            <td>
                                <input type="text" name="sample_remarks[]" class="input-cell"
                                    value="{{ old('sample_remarks.' . $i, $sampleRemarks[$i] ?? '') }}">
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <br>

            {{-- NOTES / CALCULATED BY --}}
            <table class="histamine-table">
                <tr>
                    <td style="height:130px; width:42%; vertical-align:top;">
                        <b class="tiny">Notes:</b>
                        <textarea name="notes" class="textarea-notes">{{ old('notes', $worksheet->notes ?? '') }}</textarea>
                    </td>
                    <td style="height:130px; vertical-align:top;">
                        <b class="tiny">Calculated by:</b>
                        <input type="text" name="calculated_by" class="input-line" style="width:370px;"
                            value="{{ old('calculated_by', $worksheet->calculated_by ?? '') }}">

                        <br><br>

                        <div class="tiny">
                            <b>ppm Histamine = (C x E x 50 x 50)/(D x 5 x 1 x W)</b><br>
                            <b>Where:</b><br>
                            C - amount of histamine from calibration curve (corrected)<br>
                            D - total solution volume after dilution (ml)<br>
                            W - Weight of sample<br>
                            E - Eluate solution volume for dilution (ml)<br>
                            E and D is 1 if no dilution
                        </div>
                    </td>
                </tr>
            </table>

            {{-- SIGNATURES --}}
          <table class="histamine-table no-border" style="margin-top:10px;">
    <tr>
        <td class="center bold tiny">Analyzed by:</td>
        <td class="center bold tiny">Checked by:</td>
    </tr>

    <tr>
        <td class="center">
            <select name="analyst" class="signature-select">
                <option value="">Select Analyst</option>

                @foreach($users as $user)
                    @php
                        $fullName = trim(
                            ($user->f_name ?? '') . ' ' .
                            ($user->m_name ?? '') . ' ' .
                            ($user->l_name ?? '')
                        );
                    @endphp

                    <option value="{{ $fullName }}"
                        {{ old('analyst', $worksheet->analyst ?? '') == $fullName ? 'selected' : '' }}>
                        {{ $fullName }}
                    </option>
                @endforeach
            </select>
        </td>

        <td class="center">
            <select name="checked_by" class="signature-select">
                <option value="">Select Checker</option>

                @foreach($users as $user)
                    @php
                        $fullName = trim(
                            ($user->f_name ?? '') . ' ' .
                            ($user->m_name ?? '') . ' ' .
                            ($user->l_name ?? '')
                        );
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

    <div class="save-area">
        <button type="submit" class="btn-save">Save Worksheet</button>
    </div>
</form>
@endsection
