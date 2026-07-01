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
            font-family: Cambria, "Times New Roman", serif;
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

        .no-border td, 
        .no-border th {
            border: none !important;
            padding: 0;
        }

        .center { 
            text-align: center; 
        }

        .bold { 
            font-weight: bold; 
        }

        .header-wrap td {
            font-size: 12px;
        }

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
            font-size: 13px;
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
            line-height: 1.12;
            font-size: 9px;
        }

        .big {
            font-weight: bold;
            font-size: 10px;
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

        /* FIXED CHECKBOX FOR DOMPDF */
        .pdf-check {
            display: inline-block;
            width: 8px;
            height: 8px;
            border: 1px solid #000;
            margin-right: 4px;
            vertical-align: middle;
        }

        .pdf-check.checked {
            background-color: #000;
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

<table class="doc-table" style="margin-top:0.5mm">
    <tr>
        <td style="width:28%;">Document Type<br><b>Laboratory Form</b></td>
        <td style="width:18%;">Revision No:<br>0</td>
        <td style="width:25%;">Date Adopted:<br>13 Aug 2019</td>
        <td style="width:29%;">RLA No.<br>{{ $payment->RLA_no ?? '' }}</td>
    </tr>
    <tr>
        <td>Document Code:<br><b>LF 06-03</b></td>
        <td colspan="3" class="center bold">ORDER OF PAYMENT</td>
    </tr>
</table>

<div class="spacer"></div>

<table class="info-table">
    <tr>
        <td><b>CUSTOMER:</b> {{ $payment->company_name ?? '' }}</td>
    </tr>
    <tr>
        <td><b>ADDRESS:</b> {{ $displayAddress ?? '' }}</td>
    </tr>
    <tr>
        <td><b>SAMPLE:</b> {{ $sample ?? '' }}</td>
    </tr>
    <tr>
        <td><b>LABORATORY CODE:</b> {{ $payment->laboratory_code ?? '' }}</td>
    </tr>
</table>

<div class="spacer"></div>

@php
    function getItem($items, $name) {
        foreach ($items as $item) {
            if (($item['name'] ?? '') === $name) {
                return $item;
            }
        }

        return null;
    }

    function mark($i) {
        return ($i && !empty($i['checked']))
            ? '<span class="pdf-check checked"></span>'
            : '<span class="pdf-check"></span>';
    }

    function qty($i) {
        return ($i && !empty($i['checked']) && !empty($i['qty'])) 
            ? $i['qty'] 
            : '';
    }

    function totalVal($i) {
        return ($i && !empty($i['checked']) && isset($i['total']) && (float)$i['total'] > 0)
            ? number_format((float)$i['total'], 2)
            : '';
    }
@endphp

<table class="items-table">
    <tr>
        <th style="width:55%;">CHEMICAL ANALYSIS</th>
        <th style="width:15%;">Quantity</th>
        <th style="width:15%;">Unit Cost</th>
        <th style="width:15%;">Total</th>
    </tr>

    {{-- CHEMICAL --}}
    <tr>
        @php $i = getItem($items, 'Histamine'); @endphp
        <td>{!! mark($i) !!} Histamine</td>
        <td>{{ qty($i) }}</td>
        <td>450</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    <tr>
        @php $i = getItem($items, 'Moisture'); @endphp
        <td>{!! mark($i) !!} Moisture</td>
        <td>{{ qty($i) }}</td>
        <td>85</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    {{-- MICROBIO --}}
    <tr class="section-row">
        <th>MICROBIOLOGICAL ANALYSIS</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>

    <tr>
        @php $i = getItem($items, 'Aerobic Plate Count (APC)'); @endphp
        <td>{!! mark($i) !!} Aerobic Plate Count (APC)</td>
        <td>{{ qty($i) }}</td>
        <td>200</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    <tr>
        @php $i = getItem($items, 'Heterotrophic Plate Count (HPC)'); @endphp
        <td>{!! mark($i) !!} Heterotrophic Plate Count(HPC)</td>
        <td>{{ qty($i) }}</td>
        <td>200</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    <tr>
        @php $i = getItem($items, 'Coliform'); @endphp
        <td>{!! mark($i) !!} Coliform</td>
        <td>{{ qty($i) }}</td>
        <td>250</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    <tr>
        @php $i = getItem($items, 'E.coli'); @endphp
        <td>{!! mark($i) !!} E.coli</td>
        <td>{{ qty($i) }}</td>
        <td>350</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    <tr>
        @php $i = getItem($items, 'Salmonella'); @endphp
        <td>{!! mark($i) !!} Salmonella</td>
        <td>{{ qty($i) }}</td>
        <td>400</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    <tr>
        @php $i = getItem($items, 'Shigella'); @endphp
        <td>{!! mark($i) !!} Shigella</td>
        <td>{{ qty($i) }}</td>
        <td>400</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    <tr>
        @php $i = getItem($items, 'Staph. aureus'); @endphp
        <td>{!! mark($i) !!} Staph. aureus</td>
        <td>{{ qty($i) }}</td>
        <td>300</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    <tr>
        @php $i = getItem($items, 'Enterococci'); @endphp
        <td>{!! mark($i) !!} Enterococci</td>
        <td>{{ qty($i) }}</td>
        <td>350</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    <tr>
        @php $i = getItem($items, 'Fecal coliform'); @endphp
        <td>{!! mark($i) !!} Fecal coliform</td>
        <td>{{ qty($i) }}</td>
        <td>250</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    {{-- MOLECULAR --}}
    <tr class="section-row">
        <th>MOLECULAR DIAGNOSIS</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>

    <tr>
        @php $i = getItem($items, 'WSSV'); @endphp
        <td>{!! mark($i) !!} WSSV</td>
        <td>{{ qty($i) }}</td>
        <td>600</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    <tr>
        @php $i = getItem($items, 'EMS/AHPND'); @endphp
        <td>{!! mark($i) !!} EMS/AHPND</td>
        <td>{{ qty($i) }}</td>
        <td>600</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    {{-- BIOLOGICAL --}}
    <tr class="section-row">
        <th>BIOLOGICAL / BACTERIAL ANALYSIS</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>

    <tr>
        @php $i = getItem($items, 'Parasite Examination'); @endphp
        <td>{!! mark($i) !!} Parasite Examination</td>
        <td>{{ qty($i) }}</td>
        <td>75</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    <tr>
        @php $i = getItem($items, 'Gross/Microscopic Examination'); @endphp
        <td>{!! mark($i) !!} Gross/Microscopic Examination</td>
        <td>{{ qty($i) }}</td>
        <td>100</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    <tr>
        @php $i = getItem($items, 'Bacterial Count'); @endphp
        <td>{!! mark($i) !!} Bacterial Count</td>
        <td>{{ qty($i) }}</td>
        <td>100</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    {{-- PRODUCT CERTIFICATE --}}
    <tr class="section-row">
        <th>PRODUCT QUALITY CERTIFICATE</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>

    <tr>
        @php $i = getItem($items, 'Health Certificate'); @endphp
        <td>{!! mark($i) !!} Health Certificate</td>
        <td>{{ qty($i) }}</td>
        <td>50</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    <tr>
        @php $i = getItem($items, 'OTHERS'); @endphp
        <td>{!! mark($i) !!} OTHERS</td>
        <td>{{ qty($i) }}</td>
        <td>{{ $i ? number_format((float)($i['unit'] ?? 0), 2) : '0.00' }}</td>
        <td>{{ totalVal($i) }}</td>
    </tr>

    <tr>
        <td colspan="3" class="bold center">Grand Total</td>
        <td>{{ number_format((float)($payment->grand_total ?? 0), 2) }}</td>
    </tr>
</table>

<div class="spacer"></div>

<table class="footer-table">
    <tr>
        <td style="width:50%;">
            <b>ISSUED BY:</b><br>

            @if(!empty($payment->signature))
                <img src="{{ $payment->signature }}" class="sig-img">
            @else
                <div style="height:28px;"></div>
            @endif

            {{ $payment->issued_by ?? '' }}<br>
            Customer Service Officer
        </td>

        <td style="width:50%;">
            <b>DATE ISSUED:</b><br><br>
            {{ $payment->date_issued ?? '' }}
        </td>
    </tr>
</table>

</body>
</html>