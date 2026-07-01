@extends('layouts.app')

@section('content')
@php
    function pcrJson($value) {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    function pcrFlatten($array) {
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

    function pcrArrayValue($array, $index, $default = '') {
        return isset($array[$index]) && $array[$index] !== null && $array[$index] !== ''
            ? $array[$index]
            : $default;
    }

    $labCodes = pcrJson($rla->laboratory_code ?? null);
    $sampleDescriptions = pcrJson($rla->sample_description ?? null);

    $analysisRequested = pcrFlatten(pcrJson($rla->analysis_requested ?? null));
    $analysisRequestedText = implode(', ', $analysisRequested);

    $testMethods = $worksheet ? pcrJson($worksheet->test_method ?? null) : [];
    $sampleTypes = $worksheet ? pcrJson($worksheet->sample_type ?? null) : [];

    $diagnosisRla = $worksheet ? pcrJson($worksheet->diagnosis_rla ?? null) : [];
    $diagnosisLaneNo = $worksheet ? pcrJson($worksheet->diagnosis_lane_no ?? null) : [];
    $diagnosisLabCode = $worksheet ? pcrJson($worksheet->diagnosis_laboratory_code ?? null) : [];
    $diagnosis50 = $worksheet ? pcrJson($worksheet->diagnosis_50nm ?? null) : [];
    $diagnosis55 = $worksheet ? pcrJson($worksheet->diagnosis_55nm ?? null) : [];
    $diagnosisResult = $worksheet ? pcrJson($worksheet->diagnosis_result ?? null) : [];

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

    $methodOptions = [
        'IQ 2000™ DETECTION AND PREVENTION SYSTEM',
        'IQ PLUS KIT W / POCKIT SYSTEM',
    ];

    $sampleTypeOptions = [
        'SHRIMP (FRY/ADULT)',
        'CRAB (FRY/ADULT)',
        'TILAPIA (FRY/ADULT)',
        'OTHERS',
    ];
@endphp

<style>
    .pcr-wrapper {
        width: 100%;
        overflow-x: auto;
        padding: 20px 0 40px;
    }

    .pcr-page {
        width: 1000px;
        background: #fff;
        margin: 0 auto;
        padding: 20px;
        color: #000;
        font-family: "Times New Roman", serif;
        font-size: 13px;
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

    .center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    .tiny {
        font-size: 9px;
    }

    .small {
        font-size: 10px;
    }

    .logo-cell {
        width: 140px;
        text-align: center;
    }

    .logo-cell img {
        width: 100px;
        height: auto;
    }

    .input-cell {
        width: 100%;
        min-height: 24px;
        border: none;
        outline: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        font-size: 12px;
        text-align: center;
        padding: 2px;
        color: #000;
        box-sizing: border-box;
    }

    .section-title {
        font-weight: bold;
        margin-top: 18px;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .checkbox-item {
        display: inline-block;
        margin-right: 12px;
        font-weight: bold;
        white-space: nowrap;
    }

    .checkbox-item input {
        width: 14px;
        height: 14px;
        vertical-align: middle;
    }

    .picture-box {
        width: 100%;
        height: 520px;
        border: 1px solid #000;
        text-align: center;
        vertical-align: middle;
        position: relative;
        overflow: hidden;
        background: #fff;
    }

    .picture-box img {
        max-width: 100%;
        max-height: 500px;
        display: block;
        margin: 10px auto;
        object-fit: contain;
    }

    .picture-label {
        margin-top: 240px;
        font-weight: bold;
        text-align: center;
    }

    .camera-actions {
        margin-top: 10px;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .btn-upload-file {
        display: inline-block;
        background: #0d6efd;
        color: #fff;
        padding: 8px 14px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        font-weight: bold;
        border: none;
    }

    .btn-clear-picture {
        display: inline-block;
        background: #dc3545;
        color: #fff;
        padding: 8px 14px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        font-weight: bold;
        border: none;
    }

    .hidden-file-input {
        display: none;
    }

    .signature-table {
        width: 100%;
        margin-top: 25px;
        border-collapse: collapse;
    }

    .signature-table td {
        border: none;
        text-align: center;
        font-size: 12px;
    }

    .signature-select {
        width: 260px;
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        text-align: center;
        font-family: "Times New Roman", serif;
        font-size: 12px;
        background: transparent;
        padding: 4px;
        color: #000;
    }

    .save-area {
        width: 1000px;
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
        width: 1000px;
        margin: 15px auto;
        padding: 12px;
        background: #d1e7dd;
        border: 1px solid #badbcc;
        color: #0f5132;
        font-size: 14px;
    }

    .alert-error-custom {
        width: 1000px;
        margin: 15px auto;
        padding: 12px;
        background: #f8d7da;
        border: 1px solid #f5c2c7;
        color: #842029;
        font-size: 14px;
    }

    @media (max-width: 1000px) {
        .pcr-page {
            width: 100%;
            min-width: 950px;
        }

        .save-area {
            width: 100%;
            min-width: 950px;
            padding-right: 15px;
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

<form action="{{ route('pcr_worksheet.store', $rla->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="user_id" value="{{ $rla->user_id }}">
    <input type="hidden" name="rla_no" value="{{ $rla->RLA_no }}">

    <div class="pcr-wrapper">
        <div class="pcr-page">

            {{-- HEADER --}}
            <table class="pcr-table">
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

            <table class="pcr-table">
                <tr>
                    <td style="width:20%;">
                        Document Type<br>
                        <b>Work Instruction</b>
                    </td>
                    <td style="width:25%;">
                        Revision No:<br>
                        0
                    </td>
                    <td style="width:30%;">
                        Date Adopted:<br>
                        06 January 2020
                    </td>
                    <td style="width:25%;">
                        Page No:<br>
                        1
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

            <br>

            {{-- TEST METHOD --}}
            <div>
                <b>TEST METHOD:</b>

                @foreach($methodOptions as $method)
                    <label class="checkbox-item">
                        <input type="checkbox" name="test_method[]" value="{{ $method }}"
                            {{ in_array($method, old('test_method', $testMethods)) ? 'checked' : '' }}>
                        {{ $method }}
                    </label>
                @endforeach
            </div>

            {{-- SAMPLE TYPE --}}
            <div style="margin-top:5px;">
                <b>SAMPLE TYPE:</b>

                @foreach($sampleTypeOptions as $sampleType)
                    <label class="checkbox-item">
                        <input type="checkbox" name="sample_type[]" value="{{ $sampleType }}"
                            {{ in_array($sampleType, old('sample_type', $sampleTypes)) ? 'checked' : '' }}>
                        {{ $sampleType }}
                    </label>
                @endforeach
            </div>

            <br>

            {{-- SUMMARY TABLE --}}
            <table class="pcr-table">
                <tr>
                    <th style="width:18%;">TOTAL NO. OF<br>SAMPLE</th>
                    <th style="width:25%;">ANALYSIS</th>
                    <th style="width:20%;">DATE/TIME STARTED</th>
                    <th style="width:20%;">DATE/TIME FINISHED</th>
                    <th style="width:17%;">KIT LOT NO.</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="total_no_of_sample" class="input-cell"
                            value="{{ old('total_no_of_sample', $worksheet->total_no_of_sample ?? count($labCodes)) }}">
                    </td>
                    <td>
                        <input type="text" name="analysis" class="input-cell"
                            value="{{ old('analysis', $worksheet->analysis ?? $analysisRequestedText) }}">
                    </td>
                    <td>
                        <input type="datetime-local" name="date_time_started" class="input-cell"
                            value="{{ old('date_time_started', $worksheet->date_time_started ?? '') }}">
                    </td>
                    <td>
                        <input type="datetime-local" name="date_time_finished" class="input-cell"
                            value="{{ old('date_time_finished', $worksheet->date_time_finished ?? '') }}">
                    </td>
                    <td>
                        <input type="text" name="kit_lot_no" class="input-cell"
                            value="{{ old('kit_lot_no', $worksheet->kit_lot_no ?? '') }}">
                    </td>
                </tr>
            </table>

            {{-- REAGENT PREPARATION --}}
            <div class="section-title">I. Reagent Preparation</div>

            <div class="bold small">A. WSSV First PCR</div>
            <table class="pcr-table">
                <tr>
                    <td>First PCR premix</td>
                    <td class="center">
                        <input type="text" name="fish_pcr_premix" class="input-cell"
                            value="{{ old('fish_pcr_premix', $worksheet->fish_pcr_premix ?? '7.5 ul x') }}">
                    </td>
                    <td>
                        <input type="text" name="fish_pcr_premix_result" class="input-cell"
                            value="{{ old('fish_pcr_premix_result', $worksheet->fish_pcr_premix_result ?? '') }}">
                    </td>
                </tr>
                <tr>
                    <td>iQzyme DNA polymerase</td>
                    <td class="center">
                        <input type="text" name="dnazyme_polymerase" class="input-cell"
                            value="{{ old('dnazyme_polymerase', $worksheet->dnazyme_polymerase ?? '0.5 ul x') }}">
                    </td>
                    <td>
                        <input type="text" name="dnazyme_polymerase_result" class="input-cell"
                            value="{{ old('dnazyme_polymerase_result', $worksheet->dnazyme_polymerase_result ?? '') }}">
                    </td>
                </tr>
            </table>

            <div class="bold small">B. Nested</div>
            <table class="pcr-table">
                <tr>
                    <td>Nested PCR premix</td>
                    <td class="center">
                        <input type="text" name="nested_pcr_premix" class="input-cell"
                            value="{{ old('nested_pcr_premix', $worksheet->nested_pcr_premix ?? '14 ul x') }}">
                    </td>
                    <td>
                        <input type="text" name="nested_pcr_premix_result" class="input-cell"
                            value="{{ old('nested_pcr_premix_result', $worksheet->nested_pcr_premix_result ?? '') }}">
                    </td>
                </tr>
                <tr>
                    <td>iQzyme DNA polymerase</td>
                    <td class="center">
                        <input type="text" name="dnazyme_dna_polymerase" class="input-cell"
                            value="{{ old('dnazyme_dna_polymerase', $worksheet->dnazyme_dna_polymerase ?? '1 ul x') }}">
                    </td>
                    <td>
                        <input type="text" name="dnazyme_dna_polymerase_result" class="input-cell"
                            value="{{ old('dnazyme_dna_polymerase_result', $worksheet->dnazyme_dna_polymerase_result ?? '') }}">
                    </td>
                </tr>
            </table>

            <div class="bold small">C. AHPND/EMS</div>
            <table class="pcr-table">
                <tr>
                    <td>EMS/AHPND premix</td>
                    <td class="center">
                        <input type="text" name="ems_ahpnd_premix" class="input-cell"
                            value="{{ old('ems_ahpnd_premix', $worksheet->ems_ahpnd_premix ?? '12.5 ul x') }}">
                    </td>
                    <td>
                        <input type="text" name="ems_ahpnd_premix_result" class="input-cell"
                            value="{{ old('ems_ahpnd_premix_result', $worksheet->ems_ahpnd_premix_result ?? '') }}">
                    </td>
                </tr>
                <tr>
                    <td>iQzyme DNA polymerase</td>
                    <td class="center">
                        <input type="text" name="dnazyme_dna_polymerase_2" class="input-cell"
                            value="{{ old('dnazyme_dna_polymerase_2', $worksheet->dnazyme_dna_polymerase_2 ?? '0.5 ul x') }}">
                    </td>
                    <td>
                        <input type="text" name="dnazyme_dna_polymerase_2_result" class="input-cell"
                            value="{{ old('dnazyme_dna_polymerase_2_result', $worksheet->dnazyme_dna_polymerase_2_result ?? '') }}">
                    </td>
                </tr>
            </table>

            {{-- DIAGNOSIS --}}
            <div class="section-title">II. Diagnosis</div>

            <table style="width:100%;">
                <tr>
                    <td style="width:57%; vertical-align:top; border:none; padding:0;">
                        <table class="pcr-table">
                            <tr>
                                <th rowspan="2" style="width:9%;">RLA</th>
                                <th rowspan="2" style="width:10%;">LANE<br>NO.</th>
                                <th rowspan="2" style="width:32%;">LABORATORY CODE</th>
                                <th colspan="2" style="width:20%;">WAVELENGTH<br>OF APPLIED</th>
                                <th rowspan="2" style="width:29%;">RESULT</th>
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
                                        $defaultRla = '';
                                        $defaultLaneNo = '';
                                        $defaultLabCode = '';
                                        $defaultResult = '';
                                        $isFixedRow = false;
                                    }
                                @endphp

                                <tr>
                                    <td>
                                        <input type="text" name="diagnosis_rla[]" class="input-cell"
                                            value="{{ $isFixedRow ? $defaultRla : old('diagnosis_rla.' . $i, pcrArrayValue($diagnosisRla, $i, $defaultRla)) }}">
                                    </td>

                                    <td>
                                        <input type="text" name="diagnosis_lane_no[]" class="input-cell"
                                            value="{{ $isFixedRow ? $defaultLaneNo : old('diagnosis_lane_no.' . $i, pcrArrayValue($diagnosisLaneNo, $i, $defaultLaneNo)) }}">
                                    </td>

                                    <td>
                                        <input type="text" name="diagnosis_laboratory_code[]" class="input-cell"
                                            value="{{ $isFixedRow ? $defaultLabCode : old('diagnosis_laboratory_code.' . $i, pcrArrayValue($diagnosisLabCode, $i, $defaultLabCode)) }}">
                                    </td>

                                    <td>
                                        <input type="text" name="diagnosis_50nm[]" class="input-cell"
                                            value="{{ old('diagnosis_50nm.' . $i, pcrArrayValue($diagnosis50, $i)) }}">
                                    </td>

                                    <td>
                                        <input type="text" name="diagnosis_55nm[]" class="input-cell"
                                            value="{{ old('diagnosis_55nm.' . $i, pcrArrayValue($diagnosis55, $i)) }}">
                                    </td>

                                    <td>
                                        <input type="text" name="diagnosis_result[]" class="input-cell"
                                            value="{{ $isFixedRow ? $defaultResult : old('diagnosis_result.' . $i, pcrArrayValue($diagnosisResult, $i, $defaultResult)) }}">
                                    </td>
                                </tr>
                            @endfor
                        </table>
                    </td>

                    <td style="width:3%; border:none;"></td>

                    <td style="width:40%; vertical-align:top; border:none; padding:0;">
                        <div class="picture-box" id="picturePreviewBox">
                            @if(!empty($worksheet->picture))
                                <img id="picturePreview" src="{{ asset('storage/' . $worksheet->picture) }}" alt="PCR Picture">
                                <div class="picture-label" id="pictureLabel" style="display:none;">PICTURE</div>
                            @else
                                <img id="picturePreview" src="" alt="PCR Picture" style="display:none;">
                                <div class="picture-label" id="pictureLabel">PICTURE</div>
                            @endif
                        </div>

                        <div class="camera-actions">
                            <label class="btn-upload-file">
                                Upload Picture
                                <input type="file"
                                    name="picture"
                                    id="pictureInput"
                                    accept="image/*"
                                    class="hidden-file-input">
                            </label>

                            <button type="button" class="btn-clear-picture" id="clearPictureBtn">
                                Clear Preview
                            </button>
                        </div>
                    </td>
                </tr>
            </table>

            {{-- SIGNATURES --}}
            <table class="signature-table">
                <tr>
                    <td class="bold">Analyzed by:</td>
                    <td class="bold">Checked by:</td>
                </tr>

                <tr>
                    <td style="height:35px;"></td>
                    <td style="height:35px;"></td>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pictureInput = document.getElementById('pictureInput');
        const preview = document.getElementById('picturePreview');
        const label = document.getElementById('pictureLabel');
        const clearBtn = document.getElementById('clearPictureBtn');

        if (pictureInput) {
            pictureInput.addEventListener('change', function () {
                const file = this.files[0];

                if (!file) {
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';

                    if (label) {
                        label.style.display = 'none';
                    }
                };

                reader.readAsDataURL(file);
            });
        }

        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                pictureInput.value = '';
                preview.src = '';
                preview.style.display = 'none';

                if (label) {
                    label.style.display = 'block';
                }
            });
        }
    });
</script>
@endsection