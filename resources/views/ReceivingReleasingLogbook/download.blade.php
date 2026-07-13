<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order of Payment</title>
    <style>
        @page {
            margin: 10px 14px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            border: 1px solid black;
            padding: 3px 5px;
            vertical-align: middle;
            line-height: 1.05;
        }

        .no-border td, .no-border th {
            border: none !important;
            padding: 0;
        }

        .center { text-align: center; }
        .bold { font-weight: bold; }

        .header-wrap td {
              font-size: 12px;
        }
/* 
        .header-title {
            text-align: center;
            line-height: 1.15;
              font-size: 12px;
        }

        .header-title .big {
            font-weight: bold;
              font-size: 12px;
        } */

        .doc-table td {
              font-size: 12px;
            height: 26px;
        }

        .info-table td {
            border: none !important;
            padding: 2px 0;
            font-size: 12px;
        }

        .items-table th,
        .items-table td {
            font-size: 9px;
            padding: 4px 7px;
            line-height: 1.0;
        }

        .items-table th {
            text-align: center;
            font-weight: bold;
        }

        .section-row th {
            text-align: center;
            font-weight: bold;
            font-size: 8.8px;
            letter-spacing: .3px;
        }

        .footer-table td {
            font-size: 8.5px;
            height: 52px;
            vertical-align: top;
        }

        .sig-img {
            height: 24px;
            max-width: 90px;
            display: block;
            margin-top: 8px;
            margin-bottom: 2px;
        }

        .spacer {
            height: 4px;
        }
          .header-title {
            /* text-align: center; */
            line-height: 1.12;
            font-size: 9px;
        }

        .big {
            font-weight: bold;
            font-size: 9px;
        }

        .section-title {
            text-align: center;
            font-weight: bold;
            vertical-align: middle !important;
            font-size: 11px;
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

    </style>
</head>
<body>

<table class="bordered mb-1">
        <colgroup>
            <col style="width: 78px;">
            <col>
        </colgroup>
        <tr>
            <td class="logo-cell">
                 <img src="{{ $logoSrc }}" width="120" alt="Logo">
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

<table class="doc-table" style="margin-top:0.5mm">
    <tr>
        <td style="width:28%;">Document Type<br><b>Laboratory Form</b></td>
        <td style="width:18%;">Revision No:<br>0</td>
        <td style="width:25%;">Date Adopted:<br>13 Aug 2019</td>
        <td style="width:29%;">Page No.<br>Page 1 of 2</td>
    </tr>
    <tr>
        <td>Document Code:<br><b>LF 06-06</b></td>
        <td colspan="3" class="center bold"> SAMPLE RECEIVING AND RELEASING LOGBOOK</td>
    </tr>
</table>
<table class="items-table" style="margin-top: 8px;">
    <thead>
        <tr>
            <th style="width:4%;">NO.</th>
            <th style="width:8%;">RLA<br>NUMBER</th>
            <th style="width:18%;">CUSTOMER</th>
            <th style="width:10%;">SAMPLE<br>DESCRIPTION</th>
            <th style="width:9%;">SAMPLE CODE</th>
            <th style="width:12%;">LABORATORY<br>CODE</th>
            <th style="width:8%;">RECEIVED<br>BY</th>
            <th style="width:8%;">DATE<br>RECEIVED</th>
            <th style="width:10%;">REPORT OF<br>TEST NO.</th>
            <th style="width:7%;">OFFICIAL<br>RECEIPT NO.</th>
            <th style="width:8%;">DATE<br>RELEASED</th>
            <th style="width:8%;">RELEASED TO</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($rla as $index => $r)
            <tr>
                <td class="center">{{ $index + 1 }}</td>

                <td class="center">{{ $r->RLA_no ?? '' }}</td>

                <td>{{ $r->company_name ?? '' }}</td>

                <td>
                    {{ $r->sample_description[0] ?? '' }}
                </td>

                <td>
                    @foreach ($r->sample_code as $code)
                        <div style="white-space: nowrap;">{{ $code }}</div>
                    @endforeach
                </td>

                <td>
                    @foreach ($r->laboratory_code as $code)
                        <div style="white-space: nowrap;">{{ $code }}</div>
                    @endforeach
                </td>

                <td class="center">{{ $r->sample_received_by ?? '' }}</td>

                <td class="center">
                    {{ $r->date_received ? \Carbon\Carbon::parse($r->date_received)->format('m/d/Y') : '' }}
                </td>

                <td>
                    @foreach ($r->report_test_no as $reportNo)
                        <div style="white-space: nowrap;">{{ $reportNo }}</div>
                    @endforeach
                </td>

                <td class="center">{{ $r->or_no ?? '' }}</td>

                <td class="center">
                    {{ $r->date_approved_release ? \Carbon\Carbon::parse($r->date_approved_release)->format('m/d/Y') : '' }}
                </td>

                <td class="center">{{ $r->sample_received_by ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<table style="width:100%;margin-top:40px;border:none;">
    <tr>
        <td style="border:none;"></td>

        <td style="border:none;text-align:right;width:220px;">

            @if(!empty($signature))
                <img src="{{ $signature }}"
                     style="height:70px;">
            @endif

            <div style="margin-top:5px;">
                ______________________
            </div>

            <div>
                Signature
            </div>

        </td>
    </tr>
</table>

</body>
</html>