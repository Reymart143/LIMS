@extends('layouts.app')

@section('content')
@php
    $labCodes = json_decode($rla->laboratory_code ?? '[]', true) ?? [];
    $firstLabCode = is_array($labCodes) ? ($labCodes[0] ?? '') : '';

    $sampleDescriptions = json_decode($rla->sample_description ?? '[]', true) ?? [];
    $firstSampleDescription = is_array($sampleDescriptions)
        ? ($sampleDescriptions[0] ?? '')
        : ($rla->sample_description ?? '');

    $objectives = [];

    if ($worksheet && !empty($worksheet->objective_used)) {
        $decoded = json_decode($worksheet->objective_used, true);
        $objectives = is_array($decoded) ? $decoded : [];
    }

    $selected10x = in_array('10x', $objectives);
    $selected40x = in_array('40x', $objectives);
    $selected100x = in_array('100x', $objectives);

    $dateStarted = '';
    $dateFinished = '';

    if (!empty($worksheet->date_started)) {
        try {
            $dateStarted = \Carbon\Carbon::parse($worksheet->date_started)->format('Y-m-d');
        } catch (\Exception $e) {
            $dateStarted = $worksheet->date_started;
        }
    }

    if (!empty($worksheet->date_finished)) {
        try {
            $dateFinished = \Carbon\Carbon::parse($worksheet->date_finished)->format('Y-m-d');
        } catch (\Exception $e) {
            $dateFinished = $worksheet->date_finished;
        }
    }
@endphp

<style>
    .signature-select {
    width: 230px;
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
    .paragross-wrapper {
        width: 100%;
        overflow-x: auto;
        padding: 20px 0 40px;
    }

    .paragross-page {
        width: 900px;
        background: #fff;
        margin: 0 auto;
        padding: 25px;
        color: #000;
        font-family: "Times New Roman", serif;
        font-size: 15px;
    }

    .paragross-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .paragross-table td,
    .paragross-table th {
        border: 1px solid #000;
        padding: 6px;
        vertical-align: middle;
        font-size: 14px;
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
        font-size: 10px;
    }

    .logo-cell {
        width: 145px;
        text-align: center;
    }

    .logo-cell img {
        width: 110px;
        height: auto;
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

    .input-cell {
        width: 100%;
        min-height: 32px;
        border: none;
        outline: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        text-align: center;
        padding: 5px 6px;
        color: #000;
        box-sizing: border-box;
    }

    .input-date {
        width: 100%;
        min-height: 32px;
        border: none;
        outline: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        text-align: center;
        padding: 5px 6px;
        color: #000;
        box-sizing: border-box;
    }

    .textarea-cell {
        width: 100%;
        height: 90px;
        border: none;
        outline: none;
        resize: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        color: #000;
        box-sizing: border-box;
        text-align: center;
    }

    .textarea-result {
        width: 100%;
        height: 90px;
        border: none;
        outline: none;
        resize: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        color: #000;
        box-sizing: border-box;
        text-align: left;
    }

    .remarks-area {
        width: 100%;
        height: 85px;
        border: none;
        outline: none;
        resize: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        color: #000;
        box-sizing: border-box;
        line-height: 1.4;
    }

    .sample-type {
        margin-top: 35px;
        margin-bottom: 30px;
        font-size: 16px;
    }

    .section-space {
        margin-top: 25px;
    }

    .info-label {
        font-weight: bold;
        white-space: nowrap;
        text-align: left;
        padding: 6px 8px !important;
        vertical-align: middle;
    }

    .info-value {
        padding: 0 !important;
        vertical-align: middle;
    }

    .objective-checkbox {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .signature-table {
        width: 100%;
        margin-top: 45px;
        border-collapse: collapse;
    }

    .signature-table td {
        border: none;
        text-align: center;
        font-size: 14px;
    }

    .signature-line {
        width: 230px;
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        text-align: center;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        background: transparent;
        padding: 4px;
    }

    .save-area {
        width: 900px;
        margin: 15px auto 40px;
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
        width: 900px;
        margin: 15px auto;
        padding: 12px;
        background: #d1e7dd;
        border: 1px solid #badbcc;
        color: #0f5132;
        font-size: 14px;
    }

    .alert-error-custom {
        width: 900px;
        margin: 15px auto;
        padding: 12px;
        background: #f8d7da;
        border: 1px solid #f5c2c7;
        color: #842029;
        font-size: 14px;
    }

    @media (max-width: 900px) {
        .paragross-page {
            width: 100%;
            min-width: 780px;
            padding: 15px;
        }

        .save-area {
            width: 100%;
            min-width: 780px;
            padding-right: 15px;
        }

        .paragross-wrapper {
            overflow-x: auto;
        }
    }

    @media print {
        .save-area,
        .btn-save,
        .alert-success-custom,
        .alert-error-custom {
            display: none !important;
        }

        .paragross-wrapper {
            padding: 0;
            overflow: visible;
        }

        .paragross-page {
            width: 100%;
            margin: 0;
            padding: 0;
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
<form action="{{ route('paragross_worksheet.store', $rla->id) }}" method="POST">
    @csrf

    <input type="hidden" name="user_id" value="{{ $rla->user_id }}">
    <input type="hidden" name="rla_no" value="{{ $rla->RLA_no }}">
    <input type="hidden" name="lab_code" value="{{ $worksheet->lab_code ?? $firstLabCode }}">

    <div class="paragross-wrapper">
        <div class="paragross-page">

            {{-- HEADER --}}
            <table class="paragross-table">
                <tr>
                    <td class="logo-cell">
                        <img src="{{ asset('assets/images/bfarlogo.png') }}" alt="BFAR Logo" onerror="this.style.display='none'">
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

            <table class="paragross-table">
                <tr>
                    <td style="width:20%;">
                        Document Type<br>
                        <b>Laboratory Form</b>
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
                <input type="text" name="sample_type" readonly class="input-line" style="width:300px;"
                    value="{{ old('sample_type', $worksheet->sample_type ?? $firstSampleDescription) }}">
            </div>

            {{-- ONE LINE INFO TABLE --}}
            <table class="paragross-table">
                <tr>
                    <td style="width:10%;" class="info-label">RLA No.:</td>
                    <td style="width:14%;" class="info-value">
                        <input type="text" class="input-cell"
                            value="{{ $worksheet->rla_no ?? $rla->RLA_no ?? '' }}" readonly>
                    </td>

                    <td style="width:12%;" class="info-label">Lab Code:</td>
                    <td style="width:22%;" class="info-value">
                        <input type="text" class="input-cell"
                            value="{{ $worksheet->lab_code ?? $firstLabCode ?? '' }}" readonly>
                    </td>

                    <td style="width:16%;" class="info-label">Date Started:</td>
                    <td style="width:13%;" class="info-value">
                        <input type="date" name="date_started" class="input-date"
                            value="{{ old('date_started', $dateStarted) }}">
                    </td>

                    <td style="width:16%;" class="info-label">Date Finished:</td>
                    <td style="width:13%;" class="info-value">
                        <input type="date" name="date_finished" class="input-date"
                            value="{{ old('date_finished', $dateFinished) }}">
                    </td>
                </tr>
            </table>

            {{-- MAIN WORKSHEET TABLE --}}
            <table class="paragross-table">
                <tr>
                    <td rowspan="2" style="width:22%;" class="center bold">
                        Test Method
                    </td>

                    <td colspan="3" style="width:27%;" class="center bold">
                        Objective Used
                    </td>

                    <td rowspan="2" style="width:21%;" class="center bold">
                        Length<br><br>(cm)
                    </td>

                    <td rowspan="2" style="width:30%;" class="center bold">
                        Result
                    </td>
                </tr>

                <tr>
                    <td class="center" style="width:9%;">10x</td>
                    <td class="center" style="width:9%;">40x</td>
                    <td class="center" style="width:9%;">100x</td>
                </tr>

                <tr>
                    <td class="center">
                        <textarea name="test_method" class="textarea-cell">{{ old('test_method', $worksheet->test_method ?? 'Wet Mount Microscopy') }}</textarea>
                    </td>

                    <td class="center">
                        <input type="checkbox" class="objective-checkbox" name="objective_used[]" value="10x"
                            {{ old('objective_used') ? (in_array('10x', old('objective_used')) ? 'checked' : '') : ($selected10x ? 'checked' : '') }}>
                    </td>

                    <td class="center">
                        <input type="checkbox" class="objective-checkbox" name="objective_used[]" value="40x"
                            {{ old('objective_used') ? (in_array('40x', old('objective_used')) ? 'checked' : '') : ($selected40x ? 'checked' : '') }}>
                    </td>

                    <td class="center">
                        <input type="checkbox" class="objective-checkbox" name="objective_used[]" value="100x"
                            {{ old('objective_used') ? (in_array('100x', old('objective_used')) ? 'checked' : '') : ($selected100x ? 'checked' : '') }}>
                    </td>

                    <td>
                        <input type="text" name="length_cm" class="input-cell"
                            value="{{ old('length_cm', $worksheet->length_cm ?? '') }}">
                    </td>

                    <td>
                        <textarea name="result" class="textarea-result">{{ old('result', $worksheet->result ?? '') }}</textarea>
                    </td>
                </tr>
            </table>

            {{-- REMARKS --}}
            <div class="section-space">
                <b>REMARKS:</b>
                <br><br>

                <textarea name="remarks" class="remarks-area">{{ old('remarks', $worksheet->remarks ?? '') }}</textarea>
            </div>

            {{-- SIGNATURES --}}
           <table class="signature-table">
    <tr>
        <td class="bold">Analysed by:</td>
        <td class="bold">Checked by:</td>
    </tr>

    <tr>
        <td style="height:60px;"></td>
        <td style="height:60px;"></td>
    </tr>

    <tr>
        <td>
            <select name="analyzed_by" class="signature-select">
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

    <tr>
        <td class="tiny bold">NAME OF ANALYST AND SIGNATURE</td>
        <td class="tiny bold">NAME OF ANALYST AND SIGNATURE</td>
    </tr>
</table>

        </div>
    </div>

    <div class="save-area">
        <button type="submit" class="btn-save">Save Worksheet</button>
    </div>
</form>
@endsection 