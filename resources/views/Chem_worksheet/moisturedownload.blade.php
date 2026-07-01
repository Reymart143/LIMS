@php
    $labCodes = [];

    if (!empty($worksheet->laboratory_code)) {
        $labCodes = json_decode($worksheet->laboratory_code, true) ?? [];
    }

    if (count($labCodes) === 0) {
        $rlaLabCodes = json_decode($rla->laboratory_code ?? '[]', true);

        if (!is_array($rlaLabCodes)) {
            $rlaLabCodes = [$rla->laboratory_code ?? ''];
        }

        $labCodes = $rlaLabCodes;
    }

    $labCodes = array_values(array_filter($labCodes, function ($value) {
        return trim((string) $value) !== '';
    }));

    if (count($labCodes) === 0) {
        $labCodes = [''];
    }

    $trialsPerLabCode = 3;

    $savedTrial = !empty($worksheet->trial) ? json_decode($worksheet->trial, true) ?? [] : [];
    $savedWtPan = !empty($worksheet->wt_pan) ? json_decode($worksheet->wt_pan, true) ?? [] : [];
    $savedWtSampleBeforeDrying = !empty($worksheet->wt_sample_before_drying) ? json_decode($worksheet->wt_sample_before_drying, true) ?? [] : [];
    $savedWtPanSampleAfterDrying = !empty($worksheet->wt_pan_sample_after_drying) ? json_decode($worksheet->wt_pan_sample_after_drying, true) ?? [] : [];
    $savedWtSampleAfterDrying = !empty($worksheet->wt_sample_after_drying) ? json_decode($worksheet->wt_sample_after_drying, true) ?? [] : [];
    $savedWtLostOnDrying = !empty($worksheet->wt_lost_on_drying) ? json_decode($worksheet->wt_lost_on_drying, true) ?? [] : [];
    $savedMoistureContent = !empty($worksheet->moisture_content) ? json_decode($worksheet->moisture_content, true) ?? [] : [];

    $savedAverage = !empty($worksheet->average) ? json_decode($worksheet->average, true) ?? [] : [];
    $savedRemarks = !empty($worksheet->remarks) ? json_decode($worksheet->remarks, true) ?? [] : [];

    $dateStarted = '';
    $dateFinished = '';

    if (!empty($worksheet->date_time_started)) {
        $dateStarted = \Carbon\Carbon::parse($worksheet->date_time_started)->format('m/d/Y h:i A');
    }

    if (!empty($worksheet->date_time_finished)) {
        $dateFinished = \Carbon\Carbon::parse($worksheet->date_time_finished)->format('m/d/Y h:i A');
    }

    $rlaNo = $worksheet->rla_no ?? $rla->RLA_no ?? '';

    $method = $worksheet->method ?? 'Oven Dried';
    $reference = $worksheet->reference ?? 'AOAC';
    $ovenTemperature = $worksheet->oven_temperature ?? '105°C';
    $isActualTemperature = $worksheet->is_actual_temperature ?? false;
    $dryingTime = $worksheet->drying_time ?? '';

    $logoPath = public_path('assets/images/bfarlogo.png');

    function moistureDisplayValue($value)
    {
        return $value ?? '';
    }
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

 <style>
    @page {
        margin: 36px 44px;
    }

    body {
         font-family: Cambria, "Times New Roman", serif;
        font-size: 9px;
        color: #000;
        margin: 0;
        padding: 0;
    }

    table {
        border-collapse: collapse;
    }

    .sheet {
        width: 100%;
    }

    /*
        SAME WIDTH TANAN MAIN TABLES
        Header, document info, date table, moisture table
    */
    .bordered,
    .doc-table,
    .date-table,
    .moisture-table {
        width: 88%;
        margin-left: auto;
        margin-right: auto;
        border-collapse: collapse;
        border: 1px solid #000;
        table-layout: fixed;
    }

    .bordered {
        margin-top: 0;
        margin-bottom: 0;
    }

    .doc-table {
        margin-top: 0;
        margin-bottom: 0;
    }

    .date-table {
        margin-top: 0;
        margin-bottom: 0;
    }

    .moisture-table {
        margin-top: 0;
        margin-bottom: 0;
    }

    .bordered td,
    .bordered th {
        border: 1px solid #000;
        padding: 3px 5px;
        vertical-align: middle;
    }

    .logo-cell {
        width: 90px;
        text-align: center;
        vertical-align: middle;
    }

    .logo-cell img {
        max-width: 58px;
        max-height: 58px;
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

    .doc-table td {
        border: 1px solid #000;
        padding: 3px 5px;
        font-size: 8px;
        line-height: 1.1;
        vertical-align: middle;
    }

    .doc-title {
        text-align: center;
        font-size: 9px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .date-table td {
        border: 1px solid #000;
        padding: 3px 5px;
        font-size: 8px;
        line-height: 1.1;
        height: 12px;
        vertical-align: middle;
    }

    .details {
        width: 88%;
        margin: 16px auto 12px;
        font-size: 10px;
        line-height: 1.25;
    }

    .details strong {
        font-weight: bold;
    }

    .underline {
        text-decoration: underline;
        font-weight: bold;
    }

    .checkbox-box {
        display: inline-block;
        width: 9px;
        height: 9px;
        border: 1px solid #000;
        vertical-align: middle;
        margin: 0 3px;
    }

    .checkbox-checked {
        background: #000;
    }

    .moisture-table th,
    .moisture-table td {
        border: 1px solid #000;
        text-align: center;
        vertical-align: middle;
        padding: 2px 3px;
        font-size: 10px;
        line-height: 1.08;
        font-weight: normal;
    }

    .moisture-table th {
        height: 58px;
    }

    .moisture-table td {
        height: 12px;
    }

    .text-left {
        text-align: left !important;
    }

    .lab-code-cell {
        word-break: break-word;
        line-height: 1.1;
    }

    .remarks-cell {
        text-align: left !important;
        vertical-align: top !important;
        line-height: 1.2;
        padding-left: 5px !important;
    }

    .signature-table {
        width: 88%;
        margin: 132px auto 0;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .signature-table td {
        border: none;
        text-align: center;
        font-size: 8px;
        font-weight: bold;
        vertical-align: bottom;
    }

    .signature-name {
        height: 28px;
        font-size: 9px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .signature-line {
        width: 120px;
        border-top: 1px solid #000;
        margin: 5px auto 0;
    }
</style>
</head>

<body>
    <div class="sheet">

        {{-- HEADER --}}
        <table class="bordered">
            <colgroup>
                <col style="width: 78px;">
                <col>
            </colgroup>

            <tr>
                <td class="logo-cell">
                    @if(file_exists($logoPath))
                        <img src="{{ $logoPath }}" alt="Logo">
                    @endif
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

        {{-- DOCUMENT INFO --}}
        <table class="doc-table">
            <colgroup>
                <col style="width: 23%;">
                <col style="width: 25%;">
                <col style="width: 34%;">
                <col style="width: 18%;">
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
                    <div>LF W01-CHE-02</div>
                </td>

                <td colspan="3" class="doc-title">
                    Analyst Spreadsheet for Moisture Content Analysis
                </td>
            </tr>
        </table>

        {{-- DATE / TIME --}}
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
                <td>Date /Time started:</td>
                <td>{{ $dateStarted }}</td>

                <td>Date /Time finished:</td>
                <td>{{ $dateFinished }}</td>

                <td>RLA No.:</td>
                <td>{{ $rlaNo }}</td>
            </tr>
        </table>

        {{-- METHOD DETAILS --}}
        <div class="details">
            <div>
                <strong>Method:</strong>
                <span class="underline">{{ $method }}</span>
            </div>

            <div>
                <strong>Reference:</strong>
                <span class="underline">{{ $reference }}</span>
            </div>

            <br>

            <div>
                <strong>Oven Temperature:</strong>
                <span class="underline">{{ $ovenTemperature }}</span>

               <span class="checkbox-box {{ $isActualTemperature ? 'checkbox-checked' : '' }}"></span>
                    Checked if temperature reading is actual temperature.
            </div>

            <div>
                <strong>Drying Time:</strong>

              <span class="checkbox-box {{ $dryingTime === '1 hour' ? 'checkbox-checked' : '' }}"></span>
                1 hour

                <span class="checkbox-box {{ $dryingTime === '16 hours' ? 'checkbox-checked' : '' }}" style="margin-left: 8px;"></span>
                16 hours
            </div>
        </div>

        {{-- TABLE --}}
        <table class="moisture-table">
            <colgroup>
                <col style="width: 13%;">
                <col style="width: 8%;">
                <col style="width: 9%;">
                <col style="width: 10%;">
                <col style="width: 13%;">
                <col style="width: 10%;">
                <col style="width: 9%;">
                <col style="width: 10%;">
                <col style="width: 10%;">
                <col style="width: 8%;">
            </colgroup>

            <thead>
                <tr>
                    <th>Laboratory<br>Code</th>
                    <th>Trial</th>
                    <th>Wt. of<br>Pan</th>
                    <th>Wt. Of<br>sample<br>before<br>drying</th>
                    <th>Wt of pan<br>and<br>sample<br>after<br>drying</th>
                    <th>Wt of<br>sample<br>after<br>drying</th>
                    <th>Wt<br><u>lost on</u><br>drying</th>
                    <th><u>Moisture</u><br>content</th>
                    <th>Average</th>
                    <th>Remarks</th>
                </tr>
            </thead>

            <tbody>
                @foreach($labCodes as $labIndex => $labCode)
                    @for($trialIndex = 0; $trialIndex < $trialsPerLabCode; $trialIndex++)
                        @php
                            $rowIndex = ($labIndex * $trialsPerLabCode) + $trialIndex;
                            $remarksText = $savedRemarks[$labIndex] ?? '';
                        @endphp

                        <tr>
                            @if($trialIndex == 0)
                                <td rowspan="{{ $trialsPerLabCode }}" class="lab-code-cell">
                                    {{ $labCode }}
                                </td>
                            @endif

                            <td>{{ moistureDisplayValue($savedTrial[$rowIndex] ?? ($trialIndex + 1)) }}</td>
                            <td>{{ moistureDisplayValue($savedWtPan[$rowIndex] ?? '') }}</td>
                            <td>{{ moistureDisplayValue($savedWtSampleBeforeDrying[$rowIndex] ?? '') }}</td>
                            <td>{{ moistureDisplayValue($savedWtPanSampleAfterDrying[$rowIndex] ?? '') }}</td>
                            <td>{{ moistureDisplayValue($savedWtSampleAfterDrying[$rowIndex] ?? '') }}</td>
                            <td>{{ moistureDisplayValue($savedWtLostOnDrying[$rowIndex] ?? '') }}</td>
                            <td>{{ moistureDisplayValue($savedMoistureContent[$rowIndex] ?? '') }}</td>

                            @if($trialIndex == 0)
                                <td rowspan="{{ $trialsPerLabCode }}">
                                    {{ $savedAverage[$labIndex] ?? '' }}
                                </td>

                                <td rowspan="{{ $trialsPerLabCode }}" class="remarks-cell">
                                    {!! nl2br(e($remarksText)) !!}
                                </td>
                            @endif
                        </tr>
                    @endfor
                @endforeach
            </tbody>
        </table>

        {{-- SIGNATURE --}}
        <table class="signature-table">
            <tr>
                <td>
                    <div>Analyzed by:</div>
                    <div class="signature-name">
                        {{ $worksheet->analyzed_by_1 ?? '' }}
                    </div>
                    <div class="signature-line"></div>
                </td>

                <td>
                    <div>Analyzed by:</div>
                    <div class="signature-name">
                        {{ $worksheet->analyzed_by_2 ?? '' }}
                    </div>
                    <div class="signature-line"></div>
                </td>

                <td>
                    <div>Checked by:</div>
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