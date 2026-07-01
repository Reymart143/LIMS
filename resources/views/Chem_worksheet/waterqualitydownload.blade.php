@php
    /*
        Decode saved worksheet values
    */
    $worksheetSampleCodes = [];
    $savedSamplingSites = [];
    $savedResults = [];
    $savedAnalysisRequested = [];

    if (isset($worksheet) && !empty($worksheet->sample_code)) {
        $worksheetSampleCodes = json_decode($worksheet->sample_code, true) ?? [];
    }

    if (isset($worksheet) && !empty($worksheet->sampling_site)) {
        $savedSamplingSites = json_decode($worksheet->sampling_site, true) ?? [];
    }

    if (isset($worksheet) && !empty($worksheet->results)) {
        $savedResults = json_decode($worksheet->results, true) ?? [];
    }

    if (isset($worksheet) && !empty($worksheet->analysis_requested)) {
        $savedAnalysisRequested = json_decode($worksheet->analysis_requested, true) ?? [];
    }

    /*
        Fallback sample codes from RLA if no saved worksheet yet
    */
    $rlaSampleCodes = json_decode($rla->sample_code ?? '[]', true);

    if (!is_array($rlaSampleCodes)) {
        $rlaSampleCodes = [$rla->sample_code ?? ''];
    }

    $sampleCodes = count($worksheetSampleCodes) > 0 ? $worksheetSampleCodes : $rlaSampleCodes;

    $sampleCodes = array_values(array_filter($sampleCodes, function ($value) {
        return trim((string) $value) !== '';
    }));

    /*
        Get analysis requested.
        Prefer saved worksheet analysis_requested.
        If empty, fallback to RLA analysis_requested.
    */
    if (count($savedAnalysisRequested) > 0) {
        $analysisRequestedRaw = $savedAnalysisRequested;
    } else {
        $analysisRequestedRaw = json_decode($rla->analysis_requested ?? '[]', true);
    }

    if (!is_array($analysisRequestedRaw)) {
        $analysisRequestedRaw = [$rla->analysis_requested ?? ''];
    }

    /*
        Flatten analysis_requested.
        Supports:
        ["ph", "alkalinity"]
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

    /*
        Column labels
    */
    $waterQualityParams = [
        'PH' => 'pH',
        'TEMP' => 'Temp (°C)',
        'TEMP (°C)' => 'Temp (°C)',
        'TEMPERATURE' => 'Temp (°C)',

        'NITRITE' => 'Nitrite (mg/L)',
        'NITRITE_NITROGEN' => 'Nitrite (mg/L)',
        'NITRITE NITROGEN' => 'Nitrite (mg/L)',

        'CALCIUM_HARDNESS' => 'Calcium Hardness (mg/L)',
        'CALCIUM HARDNESS' => 'Calcium Hardness (mg/L)',

        'ALKALINITY' => 'Alkalinity (mg/L)',

        'AMMONIA' => 'Ammonia (mg/L)',

        'DISSOLVED_OXYGEN' => 'Dissolved Oxygen (mg/L)',
        'DISSOLVED OXYGEN' => 'Dissolved Oxygen (mg/L)',
    ];

    $selectedColumns = [];

    foreach ($selectedAnalysis as $analysis) {
        $key = strtoupper(trim($analysis));
        $key = str_replace('-', '_', $key);

        if (isset($waterQualityParams[$key])) {
            $selectedColumns[$key] = $waterQualityParams[$key];
        }
    }

    /*
        Fallback columns if walay saved analysis_requested
    */
    if (count($selectedColumns) === 0) {
        $selectedColumns = [
            'PH' => 'pH',
            'TEMP' => 'Temp (°C)',
            'NITRITE' => 'Nitrite (mg/L)',
            'CALCIUM_HARDNESS' => 'Calcium Hardness (mg/L)',
            'ALKALINITY' => 'Alkalinity (mg/L)',
            'AMMONIA' => 'Ammonia (mg/L)',
            'DISSOLVED_OXYGEN' => 'Dissolved Oxygen (mg/L)',
        ];
    }

    /*
        Input key helper.
        Must match saved results:
        ph
        temp
        nitrite
        calcium_hardness
        alkalinity
        ammonia
        dissolved_oxygen
    */
    $makeKey = function ($key) {
        $inputName = strtolower($key);
        $inputName = str_replace([' ', '/', '(', ')', '°', '-'], '_', $inputName);
        $inputName = preg_replace('/_+/', '_', $inputName);
        $inputName = trim($inputName, '_');

        return $inputName;
    };

    /*
        Keep layout same sa picture.
        If 1 sample only, still show blank rows below.
    */
    $totalRows = max(count($sampleCodes), 10);

    $dateStarted = '';
    $dateFinished = '';

    if (isset($worksheet) && !empty($worksheet->date_time_started)) {
        $dateStarted = \Carbon\Carbon::parse($worksheet->date_time_started)->format('m/d/Y h:i A');
    }

    if (isset($worksheet) && !empty($worksheet->date_time_finished)) {
        $dateFinished = \Carbon\Carbon::parse($worksheet->date_time_finished)->format('m/d/Y h:i A');
    }

    $rlaNo = $worksheet->rla_no ?? $rla->RLA_no ?? '';

    $logoPath = public_path('assets/images/bfarlogo.png');
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 28px 40px;
        }

        body {
            font-family: Cambria, "Times New Roman", serif;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .sheet {
            width: 100%;
        }

        table {
            border-collapse: collapse;
        }

        .header-table {
            width: 100%;
            table-layout: fixed;
        }
        .header-title {
            line-height: 1.12;
            font-size: 9px;
        }

        .big {
            font-weight: bold;
            font-size: 10px;
        }

        .header-table td {
            border: 1px solid #555;
            padding: 4px 6px;
            vertical-align: middle;
            font-size: 11px;
            line-height: 1.1;
        }
        .logo-cell {
            width: 90px;
            text-align: center;
            vertical-align: middle !important;
        }

        .logo-cell img {
            max-width: 58px;
            max-height: 58px;
        }
        .agency-text {
            font-size: 12px;
            line-height: 1.1;
        }

        .agency-text .bold-gray {
            font-weight: bold;
            color: #666;
        }

        .info-table {
            width: 100%;
            table-layout: fixed;
        }

        .info-table td {
            border: 1px solid #555;
            padding: 4px 6px;
            font-size: 11px;
            line-height: 1.1;
            vertical-align: middle;
        }

        .info-label {
            color: #666;
            font-weight: bold;
        }

        .title-cell {
            text-align: center;
            font-weight: bold;
            color: #666;
            text-transform: uppercase;
        }

        .date-table {
            width: 100%;
            table-layout: fixed;
            margin-bottom: 16px;
        }

        .date-table td {
            border: 1px solid #555;
            padding: 4px 6px;
            font-size: 11px;
            line-height: 1.1;
            height: 22px;
            vertical-align: middle;
        }

        .worksheet-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .worksheet-table th,
        .worksheet-table td {
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            font-size: 11px;
            line-height: 1.1;
            padding: 3px 4px;
            font-weight: normal;
        }

        .worksheet-table th {
            font-weight: normal;
        }

        .worksheet-table .main-head {
            font-weight: normal;
            text-transform: uppercase;
        }

        .row-space td {
            height: 24px;
        }

        .signature-table {
            width: 100%;
            table-layout: fixed;
            margin-top: 48px;
        }

        .signature-table td {
            text-align: center;
            border: none;
            font-size: 10px;
            font-weight: bold;
            vertical-align: bottom;
        }

        .signature-name {
            height: 24px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .signature-line {
            width: 160px;
            border-top: 1px solid #000;
            margin: 8px auto 0;
        }

        .small-label {
            font-size: 10px;
            font-weight: bold;
        }

        .text-left {
            text-align: left;
        }
         .bordered {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        .bordered td {
            border: 1px solid #000;
        }
    </style>
</head>

<body>
    <div class="sheet">

        {{-- HEADER --}}
        <table class="bordered mb-1" >
            <colgroup>
                <col style="width: 78px;">
                <col>
            </colgroup>
            <tr>
                <td class="logo-cell">
                    <img src="{{ public_path('assets/images/bfarlogo.png') }}" alt="Logo">
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

        {{-- DOCUMENT DETAILS --}}
        <table class="info-table">
            <colgroup>
                <col style="width: 23%;">
                <col style="width: 28%;">
                <col style="width: 28%;">
                <col style="width: 21%;">
            </colgroup>

            <tr>
                <td>
                    <div class="info-label">Document Type</div>
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

                <td colspan="3" class="title-cell">
                    Analyst Worksheet for Water Quality Analysis
                </td>
            </tr>
        </table>

        {{-- DATE / TIME / RLA --}}
        <table class="date-table">
            <colgroup>
                <col style="width: 19%;">
                <col style="width: 17%;">
                <col style="width: 18%;">
                <col style="width: 17%;">
                <col style="width: 12%;">
                <col style="width: 17%;">
            </colgroup>

            <tr>
                <td>
                    <div>Date /Time</div>
                    <div>started:</div>
                </td>

                <td>{{ $dateStarted }}</td>

                <td>
                    <div>Date /Time</div>
                    <div>finished:</div>
                </td>

                <td>{{ $dateFinished }}</td>

                <td>RLA No.:</td>

                <td>{{ $rlaNo }}</td>
            </tr>
        </table>

        {{-- MAIN WATER QUALITY TABLE --}}
        <table class="worksheet-table">
            <colgroup>
                <col style="width: 14%;">
                <col style="width: 13%;">

                @foreach($selectedColumns as $column)
                    <col style="width: {{ 73 / max(count($selectedColumns), 1) }}%;">
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

                    <th colspan="{{ count($selectedColumns) }}" class="main-head">
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
                            {{ $sampleCodes[$i] ?? '' }}
                        </td>

                        <td>
                            {{ $savedSamplingSites[$i] ?? '' }}
                        </td>

                        @foreach($selectedColumns as $key => $column)
                            @php
                                $inputName = $makeKey($key);
                            @endphp

                            <td>
                                {{ $savedResults[$i][$inputName] ?? '' }}
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
                    <div class="small-label">Analyzed by:</div>
                    <div class="signature-name">
                        {{ $worksheet->analyzed_by_1 ?? '' }}
                    </div>
                    <div class="signature-line"></div>
                </td>

                <td>
                    <div class="small-label">Analyzed by:</div>
                    <div class="signature-name">
                        {{ $worksheet->analyzed_by_2 ?? '' }}
                    </div>
                    <div class="signature-line"></div>
                </td>

                <td>
                    <div class="small-label">Checked by:</div>
                    <div class="signature-name">
                        {{ $worksheet->checked_by ?? '' }}
                    </div>
                    <div class="signature-line"></div>
                </td>
            </tr>
        </table>

    </div>
</body>
</html>