<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Job Routing Form</title>
    <style>
      @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 2;
            font-family: "Times New Roman", serif;
            color: #000;
            font-size: 12px;
        }

        .page {
            width: 210mm;
            height: 297mm;
            position: relative;
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .sheet {
            width: 250mm;
            margin: 14mm auto 0 auto;
        }

        .sheet-second {
            width: 135mm;
            margin: 18mm auto 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        td, th {
            border: 1px solid #000;
            padding: 3px 4px;
            vertical-align: middle;
            word-break: break-word;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 15px;
            line-height: 1.1;
            background-color: #d9d9d9;
        }

        .subtitle {
            display: block;
            font-style: italic;
            font-weight: normal;
            font-size: 10px;
            margin-top: 1px;
        }

        .center { text-align: center; }
        .bold { font-weight: bold; }

        .h22 td, .h22 th { height: 22px; }
        .h26 td, .h26 th { height: 26px; }
        .h30 td, .h30 th { height: 30px; }

        .remarks-box {
            height: 72px;
            vertical-align: top;
            padding-top: 6px;
        }

        .sig-row td {
            height: 42px;
            vertical-align: top;
        }

        .line {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 120px;
            height: 12px;
            line-height: 12px;
            vertical-align: bottom;
        }

        .top-space {
            margin-top: 10px;
        }
    </style>
    </style>
</head>
<body>
@php
use Carbon\Carbon;
@endphp

<div class="sheet">
    <table>
        <colgroup>
            <col style="width: 18%;">
            <col style="width: 8.5%;">
            <col style="width: 8.5%;">
            <col style="width: 8.5%;">
            <col style="width: 8.5%;">
            <col style="width: 11%;">
            <col style="width: 11%;">
            <col style="width: 9%;">
        </colgroup>

        {{-- RECEIVING --}}
        <tr>
            <td colspan="8" class="title">
                RECEIVING
                <span class="subtitle">(To be filled-up by the Customer Service Officer)</span>
            </td>
        </tr>

        <tr class="tight">
            <td rowspan="2" class="center bold">Process / Action</td>
            <td colspan="2" class="center bold">IN</td>
            <td colspan="2" class="center bold">OUT</td>
            <td rowspan="2" class="center bold">Remarks</td>
            <td rowspan="2" colspan="2" class="center bold">Initials</td>
        </tr>
        <tr class="tight">
            <td class="center">Date</td>
            <td class="center">Time</td>
            <td class="center">Date</td>
            <td class="center">Time</td>
        </tr>

        <tr class="h18">
            <td>Sample Reception</td>
            <td>{{ $routingForm->receiving_in_date ? Carbon::parse($routingForm->receiving_in_date)->format('F d, Y') : '' }}</td>
            <td>{{ $routingForm->receiving_in_time ?? '' }}</td>
            <td>{{ $routingForm->receiving_out_date ? Carbon::parse($routingForm->receiving_out_date)->format('F d, Y') : '' }}</td>
            <td>{{ $routingForm->receiving_out_time ?? '' }}</td>
            <td>{{ $routingForm->receiving_remarks ?? '' }}</td>
            <td colspan="2">{{ $routingForm->receiving_initials ?? '' }}</td>
        </tr>

        <tr class="h16">
            <td>RLA No.</td>
            <td colspan="7">{{ $RLA_no }}</td>
        </tr>
        <tr class="h16">
            <td>Laboratory Code</td>
            <td colspan="7">{{ $laboratory_code }}</td>
        </tr>
        <tr class="h16">
            <td>Sample Type</td>
            <td colspan="7">{{ $sample }}</td>
        </tr>

        {{-- LABORATORY --}}
        <tr>
            <td colspan="8" class="title">
                LABORATORY
                <span class="subtitle">(To be filled-up by the Laboratory Analyst)</span>
            </td>
        </tr>

        <tr class="tight">
            <td rowspan="2" class="center bold">Process / Action</td>
            <td colspan="2" class="center bold">IN</td>
            <td colspan="2" class="center bold">OUT</td>
            <td rowspan="2" class="center bold">Results</td>
            <td rowspan="2" class="center bold">% Recovery</td>
            <td rowspan="2" class="center bold">Initials</td>
        </tr>
        <tr class="tight">
            <td class="center">Date</td>
            <td class="center">Time</td>
            <td class="center">Date</td>
            <td class="center">Time</td>
        </tr>

        <tr class="h16">
            <td>I. Sample preparation</td>
            <td>{{ $routingForm->prep_in_date ? Carbon::parse($routingForm->prep_in_date)->format('F d, Y') : '' }}</td>
            <td>{{ $routingForm->prep_in_time ?? '' }}</td>
            <td>{{ $routingForm->prep_out_date ? Carbon::parse($routingForm->prep_out_date)->format('F d, Y') : '' }}</td>
            <td>{{ $routingForm->prep_out_time ?? '' }}</td>
            <td>{{ $routingForm->prep_results ?? '' }}</td>
            <td>{{ $routingForm->prep_recovery ?? '' }}</td>
            <td>{{ $routingForm->prep_initials ?? '' }}</td>
        </tr>

      <tr class="h16">
        <td>II. Analysis</td>
        <td>{{ $routingForm->analysis_1 ?? '' }}</td>
        <td>{{ $routingForm->analysis_2 ?? '' }}</td>
        <td>{{ $routingForm->analysis_3 ?? '' }}</td>
        <td>{{ $routingForm->analysis_4 ?? '' }}</td>
        <td>{{ $routingForm->analysis_results ?? '' }}</td>
        <td>{{ $routingForm->analysis_recovery ?? '' }}</td>
        <td>{{ $routingForm->analysis_initials ?? '' }}</td>
    </tr>

    <tr class="h16">
        <td>{{ $routingForm->name_analysis_2 ?? '' }}</td>
        <td>{{ $routingForm->analysis_2_2 ?? '' }}</td>
        <td>{{ $routingForm->analysis_2_3 ?? '' }}</td>
        <td>{{ $routingForm->analysis_2_4 ?? '' }}</td>
        <td>{{ $routingForm->analysis_2_5 ?? '' }}</td>
        <td>{{ $routingForm->analysis_results_2 ?? '' }}</td>
        <td>{{ $routingForm->analysis_recovery_2 ?? '' }}</td>
        <td>{{ $routingForm->analysis_initials_2 ?? '' }}</td>
    </tr>

    <tr class="h16">
        <td>{{ $routingForm->name_analysis_3 ?? '' }}</td>
        <td>{{ $routingForm->analysis_3_2 ?? '' }}</td>
        <td>{{ $routingForm->analysis_3_3 ?? '' }}</td>
        <td>{{ $routingForm->analysis_3_4 ?? '' }}</td>
        <td>{{ $routingForm->analysis_3_5 ?? '' }}</td>
        <td>{{ $routingForm->analysis_results_3 ?? '' }}</td>
        <td>{{ $routingForm->analysis_recovery_3 ?? '' }}</td>
        <td>{{ $routingForm->analysis_initials_3 ?? '' }}</td>
    </tr>

    <tr class="h16">
        <td>{{ $routingForm->name_analysis_4 ?? '' }}</td>
        <td>{{ $routingForm->analysis_4_2 ?? '' }}</td>
        <td>{{ $routingForm->analysis_4_3 ?? '' }}</td>
        <td>{{ $routingForm->analysis_4_4 ?? '' }}</td>
        <td>{{ $routingForm->analysis_4_5 ?? '' }}</td>
        <td>{{ $routingForm->analysis_results_4 ?? '' }}</td>
        <td>{{ $routingForm->analysis_recovery_4 ?? '' }}</td>
        <td>{{ $routingForm->analysis_initials_4 ?? '' }}</td>
    </tr>

    <tr class="h16">
        <td>{{ $routingForm->name_analysis_5 ?? '' }}</td>
        <td>{{ $routingForm->analysis_5_2 ?? '' }}</td>
        <td>{{ $routingForm->analysis_5_3 ?? '' }}</td>
        <td>{{ $routingForm->analysis_5_4 ?? '' }}</td>
        <td>{{ $routingForm->analysis_5_5 ?? '' }}</td>
        <td>{{ $routingForm->analysis_results_5 ?? '' }}</td>
        <td>{{ $routingForm->analysis_recovery_5 ?? '' }}</td>
        <td>{{ $routingForm->analysis_initials_5 ?? '' }}</td>
    </tr>

    <tr class="h16">
        <td>{{ $routingForm->name_analysis_6 ?? '' }}</td>
        <td>{{ $routingForm->analysis_6_2 ?? '' }}</td>
        <td>{{ $routingForm->analysis_6_3 ?? '' }}</td>
        <td>{{ $routingForm->analysis_6_4 ?? '' }}</td>
        <td>{{ $routingForm->analysis_6_5 ?? '' }}</td>
        <td>{{ $routingForm->analysis_results_6 ?? '' }}</td>
        <td>{{ $routingForm->analysis_recovery_6 ?? '' }}</td>
        <td>{{ $routingForm->analysis_initials_6 ?? '' }}</td>
    </tr>



        <tr>
            <td colspan="8" class="remarks-box">
                <span class="bold">REMARKS</span><br>
                {{ $routingForm->remarks ?? '' }}
            </td>
        </tr>

        <tr class="h18">
            <td colspan="4">
                <span class="bold">Checked By:</span>
                <span class="line">{{ $routingForm->checked_by ?? '' }}</span>
            </td>
            <td colspan="4">
                <span class="bold">Date:</span>
                <span class="line">
                    {{ $routingForm->checked_date ? Carbon::parse($routingForm->checked_date)->format('F d, Y') : '' }}
                </span>
            </td>
        </tr>

        {{-- REPORT --}}
        <tr>
            <td colspan="8" class="title">
                PREPARATION OF REPORT OF TEST
            </td>
        </tr>

        <tr class="h16">
            <td>Preparation of Test Report</td>
            <td>{{ $routingForm->report_in_date ? Carbon::parse($routingForm->report_in_date)->format('F d, Y') : '' }}</td>
            <td>{{ $routingForm->report_in_time ?? '' }}</td>
            <td>{{ $routingForm->report_out_date ? Carbon::parse($routingForm->report_out_date)->format('F d, Y') : '' }}</td>
            <td>{{ $routingForm->report_out_time ?? '' }}</td>
            <td>{{ $routingForm->report_remarks ?? '' }}</td>
            <td colspan="2">{{ $routingForm->report_initials ?? '' }}</td>
        </tr>

        <tr class="h16">
            <td>Date Approved for Release</td>
            <td colspan="7">
                {{ $routingForm->date_approved_release ? Carbon::parse($routingForm->date_approved_release)->format('F d, Y') : '' }}
            </td>
        </tr>

    </table>
</div>
</body>
</html>