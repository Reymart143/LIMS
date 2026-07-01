@extends('layouts.app')

@section('content')

@php
    $sampleCodes = json_decode($rla->sample_code ?? '[]', true);
    $analysisRequestedRaw = json_decode($rla->analysis_requested ?? '[]', true);

    if (!is_array($sampleCodes)) {
        $sampleCodes = [$rla->sample_code ?? ''];
    }

    if (!is_array($analysisRequestedRaw)) {
        $analysisRequestedRaw = [$rla->analysis_requested ?? ''];
    }

    /*
        Clean sample codes.
        Example:
        ["RFL12-26-001", "RFL12-26-002"]
    */
    $sampleCodes = array_values(array_filter($sampleCodes, function ($value) {
        return trim((string) $value) !== '';
    }));

    /*
        Flatten analysis_requested.
        Supports:
        ["pH", "Alkalinity"]
        or
        [["pH", "Alkalinity"]]
    */
    $selectedAnalysis = [];

    foreach ($analysisRequestedRaw as $item) {
        if (is_array($item)) {
            foreach ($item as $subItem) {
                if (trim((string) $subItem) !== '') {
                    $selectedAnalysis[] = $subItem;
                }
            }
        } else {
            if (trim((string) $item) !== '') {
                $selectedAnalysis[] = $item;
            }
        }
    }

    $selectedAnalysis = array_filter(array_unique($selectedAnalysis));

    $waterQualityParams = [
        'PH' => 'pH',
        'TEMP' => 'Temp (°C)',
        'TEMP (°C)' => 'Temp (°C)',
        'TEMPERATURE' => 'Temp (°C)',
        'NITRITE' => 'Nitrite (mg/L)',
        'NITRITE NITROGEN' => 'Nitrite (mg/L)',
        'CALCIUM HARDNESS' => 'Calcium Hardness (mg/L)',
        'ALKALINITY' => 'Alkalinity (mg/L)',
        'AMMONIA' => 'Ammonia (mg/L)',
        'DISSOLVED OXYGEN' => 'Dissolved Oxygen (mg/L)',
    ];

    $selectedColumns = [];

    foreach ($selectedAnalysis as $analysis) {
        $key = strtoupper(trim($analysis));

        if (isset($waterQualityParams[$key])) {
            $selectedColumns[$key] = $waterQualityParams[$key];
        }
    }

    /*
        Fallback kung empty ang analysis_requested.
        I-remove ni nga block kung gusto nimo walay columns kung walay selected.
    */
    if (count($selectedColumns) === 0) {
        $selectedColumns = [
            'PH' => 'pH',
            'TEMP' => 'Temp (°C)',
            'NITRITE' => 'Nitrite (mg/L)',
            'CALCIUM HARDNESS' => 'Calcium Hardness (mg/L)',
            'ALKALINITY' => 'Alkalinity (mg/L)',
            'AMMONIA' => 'Ammonia (mg/L)',
            'DISSOLVED OXYGEN' => 'Dissolved Oxygen (mg/L)',
        ];
    }

    $savedResults = [];

    if (isset($worksheet) && !empty($worksheet->results)) {
        $savedResults = json_decode($worksheet->results, true) ?? [];
    }

    $savedSamplingSites = [];

    if (isset($worksheet) && !empty($worksheet->sampling_site)) {
        $savedSamplingSites = json_decode($worksheet->sampling_site, true) ?? [];
    }

    /*
        Kung 1 ra sample code = 1 row.
        Kung 2 sample codes = 2 rows.
        Kung walay sample code = 1 blank row.
    */
    $totalRows = count($sampleCodes) > 0 ? count($sampleCodes) : 1;

    /*
        Users dropdown.
        Better ni ibutang sa controller, pero okay ra sad diri sa Blade kung mao imong setup.
    */
    $users = DB::table('users')->get();

    /*
        Helper function for input names.
        Example:
        PH => ph
        CALCIUM HARDNESS => calcium_hardness
        DISSOLVED OXYGEN => dissolved_oxygen
    */
    function worksheetInputKey($key) {
        $inputName = strtolower($key);
        $inputName = str_replace([' ', '/', '(', ')', '°'], '_', $inputName);
        $inputName = preg_replace('/_+/', '_', $inputName);
        $inputName = trim($inputName, '_');

        return $inputName;
    }
@endphp

<style>
    .content-inner {
        color: #000;
    }

    .card-body {
        background: #f5f5f5;
        padding-top: 25px;
        padding-bottom: 45px;
    }

    .form-sheet {
        width: 1100px;
        max-width: 100%;
        margin: 0 auto;
        padding: 0;
        background: #fff;
        overflow: visible;
    }

    .bordered {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        font-family: "Times New Roman", serif;
        background: #fff;
        margin-bottom: 0 !important;
    }

    .bordered td,
    .bordered th {
        border: 1px solid #555;
        padding: 5px 8px;
        vertical-align: middle;
        color: #000;
        font-size: 15px;
        line-height: 1.15;
    }

    .logo-cell {
        width: 110px;
        text-align: center;
        vertical-align: middle;
    }

    .logo-cell img {
        max-width: 95px;
        height: auto;
    }

    .header-title {
        font-family: "Times New Roman", serif;
        color: #000;
        font-size: 15px;
        line-height: 1.15;
    }

    .header-title .big {
        font-weight: bold;
        color: #666;
        font-size: 15px;
    }

    .section-title {
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
        color: #000;
        font-size: 15px;
    }

    .date-rla-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        font-family: "Times New Roman", serif;
        background: #fff;
        margin-top: 18px;
    }

    .date-rla-table td {
        border: 1px solid #555;
        padding: 5px 8px;
        vertical-align: middle;
        color: #000;
        font-size: 15px;
        line-height: 1.15;
        height: 38px;
    }

    .date-rla-table input {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;
        font-family: "Times New Roman", serif;
        font-size: 15px;
        color: #000;
    }

    .worksheet-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        font-family: "Times New Roman", serif;
        background: #fff;
        color: #000;
        margin-top: 18px;
    }

    .worksheet-table th,
    .worksheet-table td {
        border: 1px solid #000;
        padding: 4px 6px;
        font-size: 15px;
        line-height: 1.1;
        text-align: center;
        vertical-align: middle;
        font-weight: normal;
        color: #000;
    }

    .worksheet-table th {
        font-weight: bold;
    }

    .worksheet-table input {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;
        text-align: center;
        font-family: "Times New Roman", serif;
        font-size: 15px;
        padding: 0;
        margin: 0;
        color: #000;
    }

    .row-space td {
        height: 34px;
    }

    .signature-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        margin-top: 70px;
        font-family: "Times New Roman", serif;
    }

    .signature-table td {
        border: none;
        text-align: center;
        font-size: 13px;
        font-weight: bold;
        color: #000;
    }

    .signature-line {
        display: none;
    }

    .signature-select {
        width: 180px;
        margin-top: 15px;
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        background: transparent;
        text-align: center;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        font-weight: bold;
        color: #000;
        padding: 3px 2px;
    }

    .signature-select option {
        font-family: Arial, sans-serif;
        font-size: 14px;
        color: #000;
    }

    .table-responsive-fix {
        width: 100%;
        overflow-x: visible;
    }

    .no-print {
        margin-bottom: 10px;
    }
</style>

<div class="card-header d-flex justify-content-between">
    <a class="btn btn-sm btn-icon btn-secondary"
        style="margin-left:8mm"
        data-bs-toggle="tooltip"
        data-bs-placement="top"
        href="/analyst_worksheet"
        aria-label="return"
        title="return">

        <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M2 12C2 6.48 6.49 2 12 2L12.2798 2.00384C17.6706 2.15216 22 6.57356 22 12C22 17.51 17.52 22 12 22C6.49 22 2 17.51 2 12ZM13.98 16C14.27 15.7 14.27 15.23 13.97 14.94L11.02 12L13.97 9.06C14.27 8.77 14.27 8.29 13.98 8C13.68 7.7 13.21 7.7 12.92 8L9.43 11.47C9.29 11.61 9.21 11.8 9.21 12C9.21 12.2 9.29 12.39 9.43 12.53L12.92 16C13.06 16.15 13.25 16.22 13.44 16.22C13.64 16.22 13.83 16.15 13.98 16Z"
                fill="currentColor">
            </path>
        </svg>
    </a>
</div>

<div class="card-body">
    <div class="form-sheet">

        {{-- HEADER --}}
        <table class="bordered mb-2">
            <colgroup>
                <col style="width:110px;">
                <col>
            </colgroup>

            <tr>
                <td class="logo-cell">
                    <img src="{{ asset('assets/images/bfarlogo.png') }}"
                        alt="Logo"
                        onerror="this.style.display='none'">
                </td>

                <td class="header-title">
                    <div>Republic of the Philippines</div>
                    <div>Department of Agriculture</div>
                    <div class="big">BUREAU OF FISHERIES AND AQUATIC RESOURCES</div>
                    <div class="big">REGIONAL FISHERIES LABORATORY XII</div>
                    <div>J. Catolico St., Lagao, General Santos City</div>
                </td>
            </tr>
        </table>

        <table class="bordered mb-3">
            <colgroup>
                <col style="width:23%;">
                <col style="width:26%;">
                <col style="width:28%;">
                <col style="width:23%;">
            </colgroup>

            <tr>
                <td>
                    <div>Document Type</div>
                    <div><strong>Laboratory Form</strong></div>
                </td>

                <td>
                    <div>Revision No:</div>
                    <div>0</div>
                </td>

                <td>
                    <div>Date Adopted:</div>
                    <div>13 Aug 2019</div>
                </td>

                <td>
                    <div>Page No:</div>
                    <div></div>
                </td>
            </tr>

            <tr>
                <td>
                    <div>Document Code:</div>
                    <div><strong>LF WQ1-CHE-05</strong></div>
                </td>

                <td colspan="3" class="section-title">
                    Analyst Worksheet for Water Quality Analysis
                </td>
            </tr>
        </table>

        <form method="POST" action="{{ route('WaterQualityWorksheet.store', $rla->id) }}">
            @csrf

            {{-- HIDDEN IMPORTANT VALUES --}}
            <input type="hidden"
                id="lf_06_02_id"
                name="lf_06_02_id"
                value="{{ $rla->id ?? '' }}">

            <input type="hidden"
                id="user_id"
                name="user_id"
                value="{{ $rla->user_id ?? '' }}">

            <input type="hidden"
                id="hidden_rla_no"
                name="rla_no"
                value="{{ $rla->RLA_no ?? '' }}">

            {{-- HIDDEN ANALYSIS REQUESTED VALUES --}}
            @foreach($selectedColumns as $key => $column)
                @php
                    $analysisInputName = worksheetInputKey($key);
                @endphp

                <input type="hidden"
                    id="analysis_requested_{{ $analysisInputName }}"
                    name="analysis_requested[]"
                    value="{{ $analysisInputName }}">
            @endforeach

            {{-- DATE / TIME / RLA NO --}}
           <table class="date-rla-table">
            <colgroup>
                <col style="width:19%;">
                <col style="width:17%;">
                <col style="width:18%;">
                <col style="width:17%;">
                <col style="width:12%;">
                <col style="width:17%;">
            </colgroup>

            <tr>
                <td>
                    <div>Date /Time</div>
                    <div>started:</div>
                </td>

                <td>
                    <input type="datetime-local"
                        id="date_time_started"
                        name="date_time_started"
                        value="{{ old('date_time_started', isset($worksheet->date_time_started) && $worksheet->date_time_started ? \Carbon\Carbon::parse($worksheet->date_time_started)->format('Y-m-d\TH:i') : '') }}">
                </td>

                <td>
                    <div>Date /Time</div>
                    <div>finished:</div>
                </td>

                <td>
                    <input type="datetime-local"
                        id="date_time_finished"
                        name="date_time_finished"
                        value="{{ old('date_time_finished', isset($worksheet->date_time_finished) && $worksheet->date_time_finished ? \Carbon\Carbon::parse($worksheet->date_time_finished)->format('Y-m-d\TH:i') : '') }}">
                </td>

                <td>
                    RLA No.:
                </td>

                <td>
                    <input type="text"
                        id="RLA_no"
                        name="RLA_no"
                        value="{{ old('RLA_no', $worksheet->RLA_no ?? $rla->RLA_no ?? '') }}"
                        readonly>
                </td>
            </tr>
        </table>
            <div class="table-responsive-fix">

                {{-- MAIN WATER QUALITY TABLE --}}
                <table class="worksheet-table">
                    <colgroup>
                        <col style="width:14%;">
                        <col style="width:13%;">

                        @foreach($selectedColumns as $column)
                            <col style="width:{{ 73 / max(count($selectedColumns), 1) }}%;">
                        @endforeach
                    </colgroup>

                    <thead>
                        <tr>
                            <th rowspan="2">
                                SAMPLE<br>CODE
                            </th>

                            <th rowspan="2">
                                SAMPLING<br>SITE
                            </th>

                            <th colspan="{{ count($selectedColumns) }}">
                                WATER QUALITY PARAMETERS
                            </th>
                        </tr>

                        <tr>
                            @foreach($selectedColumns as $column)
                                <th>
                                    {!! nl2br(e(
                                        str_replace(
                                            [
                                                'Temp (°C)',
                                                'Nitrite (mg/L)',
                                                'Calcium Hardness (mg/L)',
                                                'Alkalinity (mg/L)',
                                                'Ammonia (mg/L)',
                                                'Dissolved Oxygen (mg/L)'
                                            ],
                                            [
                                                "Temp\n(°C)",
                                                "Nitrite\n(mg/L)",
                                                "Calcium\nHardness\n(mg/L)",
                                                "Alkalinity\n(mg/L)",
                                                "Ammonia\n(mg/L)",
                                                "Dissolved\nOxygen\n(mg/L)"
                                            ],
                                            $column
                                        )
                                    )) !!}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @for($i = 0; $i < $totalRows; $i++)
                            <tr class="row-space">
                                <td>
                                    <input type="text"
                                        id="sample_code_{{ $i }}"
                                        name="sample_code[]"
                                        value="{{ old('sample_code.' . $i, $sampleCodes[$i] ?? '') }}"
                                        readonly>
                                </td>

                                <td>
                                    <input type="text"
                                        id="sampling_site_{{ $i }}"
                                        name="sampling_site[]"
                                        value="{{ old('sampling_site.' . $i, $savedSamplingSites[$i] ?? '') }}">
                                </td>

                                @foreach($selectedColumns as $key => $column)
                                    @php
                                        $inputName = worksheetInputKey($key);
                                        $inputId = 'result_' . $i . '_' . $inputName;
                                    @endphp

                                    <td>
                                        <input type="text"
                                            id="{{ $inputId }}"
                                            name="results[{{ $i }}][{{ $inputName }}]"
                                            value="{{ old('results.' . $i . '.' . $inputName, $savedResults[$i][$inputName] ?? '') }}">
                                    </td>
                                @endforeach
                            </tr>
                        @endfor
                    </tbody>
                </table>

                {{-- SIGNATURE --}}
                <table class="signature-table">
                    <tr>
                        <td>
                            Analyzed by:

                            <select id="analyzed_by_1"
                                name="analyzed_by_1"
                                class="signature-select">

                                <option value="">Select User</option>

                                @foreach($users as $user)
                                    @php
                                        $fullName = trim(
                                            ($user->f_name ?? '') . ' ' .
                                            ($user->m_name ?? '') . ' ' .
                                            ($user->l_name ?? '')
                                        );
                                    @endphp

                                    <option value="{{ $fullName }}"
                                        {{ old('analyzed_by_1', $worksheet->analyzed_by_1 ?? '') == $fullName ? 'selected' : '' }}>
                                        {{ $fullName }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="signature-line"></div>
                        </td>

                        <td>
                            Analyzed by:

                            <select id="analyzed_by_2"
                                name="analyzed_by_2"
                                class="signature-select">

                                <option value="">Select User</option>

                                @foreach($users as $user)
                                    @php
                                        $fullName = trim(
                                            ($user->f_name ?? '') . ' ' .
                                            ($user->m_name ?? '') . ' ' .
                                            ($user->l_name ?? '')
                                        );
                                    @endphp

                                    <option value="{{ $fullName }}"
                                        {{ old('analyzed_by_2', $worksheet->analyzed_by_2 ?? '') == $fullName ? 'selected' : '' }}>
                                        {{ $fullName }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="signature-line"></div>
                        </td>

                        <td>
                            Checked by:

                            <select id="checked_by"
                                name="checked_by"
                                class="signature-select">

                                <option value="">Select User</option>

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

                            <div class="signature-line"></div>
                        </td>
                    </tr>
                </table>

            </div>

            <div class="text-end mt-3 no-print">
                <button type="submit" id="submit_worksheet" name="submit_worksheet" class="btn btn-success">
                    {{ isset($worksheet) ? 'Update' : 'Save' }}
                </button>
            </div>
        </form>

    </div>
</div>

@endsection