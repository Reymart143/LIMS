<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Environmental Conditions Monitoring</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
        }

        .header-table, .monitoring-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td, .header-table th,
        .monitoring-table td, .monitoring-table th {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .bold {
            font-weight: bold;
        }

        .small {
            font-size: 11px;
        }

        .tiny {
            font-size: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .line {
            border-bottom: 1px solid #000;
            display: inline-block;
            width: 250px;
            height: 14px;
        }

        .logo-cell {
            width: 140px;
            text-align: center;
        }

        .meta-label {
            font-size: 11px;
        }

        .meta-value {
            font-size: 14px;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="logo-cell" rowspan="3">
                <img src="{{ public_path('assets/images/bfarlogo.png') }}" width="150" alt="Logo">
            </td>
            <td colspan="5" class="text-left" style="font-size: 18px;">
                Republic of the Philippines<br>
                Department of Agriculture<br>
                BUREAU OF FISHERIES AND AQUATIC RESOURCES<br>
                <span class="bold">REGIONAL FISHERIES LABORATORY XII</span><br>
                J. Catolico St., Lagao, General Santos City
            </td>
        </tr>
        <tr>
            <td style="width: 14%;">
                <div class="meta-label">Document Type</div>
                <div class="meta-value bold">Laboratory Form</div>
            </td>
            <td style="width: 12%;">
                <div class="meta-label">Revision No:</div>
                <div class="meta-value">0</div>
            </td>
            <td style="width: 18%;">
                <div class="meta-label">Date Adopted:</div>
                <div class="meta-value">13 Aug 2019</div>
            </td>
            <td colspan="2">
                <div class="meta-label">Page No:</div>
                <div class="meta-value">Page 1 of 1</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="meta-label">Document Code:</div>
                <div class="meta-value bold">LF 02-01</div>
            </td>
            <td colspan="4">
                <div class="meta-label">Title:</div>
                <div class="meta-value bold text-center">ENVIRONMENTAL CONDITIONS MONITORING</div>
            </td>
        </tr>
    </table>

    <br><br>

    <table class="monitoring-table">
        <tr>
            <th style="width: 7%;" class="text-center">Area</th>
            <th colspan="6" class="text-left">
                <span class="bold" style="text-decoration: underline;">Name of Laboratory</span><br>
                {{ $laboratoryName }}
            </th>
            <th style="width: 6%;" class="text-center">Area</th>
            <th colspan="6" class="text-left">
                <span class="bold" style="text-decoration: underline;">Name of Laboratory</span><br>
                {{ $laboratoryName }}
            </th>
        </tr>

       <tr>
            <th class="text-center tiny" rowspan="2">Requirements</th>
            <th colspan="2" class="text-center">
                Temperature
                <br>
                <span class="small">
                    <i>CHE/FIS: 23 ± 3 °C</i><br>
                    <i>MIC: 21-23°C</i>
                </span>
            </th>
            <th colspan="2" class="text-center">
                Humidity
                <br>
                <span class="small">
                    <i>CHE/FIS: 50±15%</i><br>
                    <i>MIC: 45-50%</i>
                </span>
            </th>
            <th rowspan="2" class="text-center">Remarks<br>(Analysis Conducted / Lab Code / RLA)</th>
            <th rowspan="2" class="text-center">Analyst</th>

            <th class="text-center tiny" rowspan="2">Requirements</th>
            <th colspan="2" class="text-center">
                Temperature
                <br>
                <span class="small">
                    <i>CHE/FIS: 23 ± 3 °C</i><br>
                    <i>MIC: 21-23°C</i>
                </span>
            </th>
            <th colspan="2" class="text-center">
                Humidity
                <br>
                <span class="small">
                    <i>CHE/FIS: 50±15%</i><br>
                    <i>MIC: 45-50%</i>
                </span>
            </th>
            <th rowspan="2" class="text-center">Remarks<br>(Analysis Conducted / Lab Code / RLA)</th>
            <th rowspan="2" class="text-center">Analyst</th>
        </tr>

        <tr>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>

            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
        </tr>

        <tr>
            <th class="text-center">Date</th>
            <th class="text-center">AM</th>
            <th class="text-center">PM</th>
            <th class="text-center">AM</th>
            <th class="text-center">PM</th>
            <th class="text-center"></th>
            <th class="text-center"></th>

            <th class="text-center">Date</th>
            <th class="text-center">AM</th>
            <th class="text-center">PM</th>
            <th class="text-center">AM</th>
            <th class="text-center">PM</th>
            <th class="text-center"></th>
            <th class="text-center"></th>
        </tr>

        @php
            $leftRows = $records->slice(0, 18)->values();
            $rightRows = $records->slice(18, 18)->values();
            $maxRows = max($leftRows->count(), $rightRows->count(), 18);
        @endphp

        @for($i = 0; $i < $maxRows; $i++)
            <tr>
                <td>{{ $leftRows[$i]->date ?? '' }}</td>
                <td>{{ $leftRows[$i]->temperature_am ?? '' }}</td>
                <td>{{ $leftRows[$i]->temperature_pm ?? '' }}</td>
                <td>{{ $leftRows[$i]->humidity_am ?? '' }}</td>
                <td>{{ $leftRows[$i]->humidity_pm ?? '' }}</td>
                <td colspan="2">{{ $leftRows[$i]->remarks ?? '' }}</td>

                <td>{{ $rightRows[$i]->date ?? '' }}</td>
                <td>{{ $rightRows[$i]->temperature_am ?? '' }}</td>
                <td>{{ $rightRows[$i]->temperature_pm ?? '' }}</td>
                <td>{{ $rightRows[$i]->humidity_am ?? '' }}</td>
                <td>{{ $rightRows[$i]->humidity_pm ?? '' }}</td>
                <td colspan="2">{{ $rightRows[$i]->remarks ?? '' }}</td>
            </tr>
        @endfor
    </table>

    <br><br><br>

   <div style="margin-top: 30px;">
        Checked by:
        <br><br><br>
        <span class="line">{{ $checked_by }}</span>
    </div>

</body>
</html>