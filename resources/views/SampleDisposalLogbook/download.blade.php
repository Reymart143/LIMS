<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sample Storage and Disposal Logbook</title>
    <style>
        @page {
            margin: 12px 18px 20px 18px;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .header-table,
        .header-table td,
        .records-table,
        .records-table td,
        .records-table th {
            border: 1px solid #000;
        }

        .header-table td,
        .records-table td,
        .records-table th {
            padding: 3px 5px;
        }

        .header-table,
        .records-table {
            table-layout: fixed;
            width: 100%;
        }

        .records-table th,
        .records-table td {
            text-align: center;
            vertical-align: middle;
            font-size: 10px;
        }

        .records-table td.desc {
            text-align: left;
        }

        .title-cell {
            font-size: 15px;
            font-weight: bold;
            text-align: center;
        }

        .meta-label {
            font-size: 10px;
        }

        .meta-value {
            font-size: 12px;
            font-weight: bold;
        }

        .header-org {
            font-size: 13px;
            line-height: 1.2;
        }

        .lab-name {
            font-size: 15px;
            font-weight: bold;
        }

        .footer {
            margin-top: 35px;
            font-size: 12px;
        }

        .check-line {
            width: 230px;
            border-top: 1px solid #000;
            margin-top: 28px;
        }

        .page-break {
            page-break-after: always;
        }

        .row-height td {
            height: 16px;
        }
    </style>
</head>
<body>

@foreach($chunkedRecords as $pageIndex => $records)
    <table class="header-table" style="margin-bottom: 12px;">
        <tr>
            <td rowspan="3" style="width:15%; text-align:center;">
             <img src="{{ $logoSrc }}" width="120" alt="Logo">
            </td>
            <td colspan="4" style="width:85%;">
                <div class="header-org">
                    Republic of the Philippines<br>
                    Department of Agriculture<br>
                    BUREAU OF FISHERIES AND AQUATIC RESOURCES<br>
                    <span class="lab-name">REGIONAL FISHERIES LABORATORY XII</span><br>
                    J. Catolico St., Lagao, General Santos City
                </div>
            </td>
        </tr>
        <tr>
            <td style="width:24%;">
                <div class="meta-label">Document Type</div>
                <div class="meta-value">{{ $document_type }}</div>
            </td>
            <td style="width:12%;">
                <div class="meta-label">Revision No:</div>
                <div class="meta-value">{{ $revision_no }}</div>
            </td>
            <td style="width:24%;">
                <div class="meta-label">Date Adopted:</div>
                <div class="meta-value">{{ $date_adopted }}</div>
            </td>
            <td style="width:15%;">
                <div class="meta-label">Page No:</div>
                <div class="meta-value">Page {{ $pageIndex + 1 }} of {{ $chunkedRecords->count() }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="meta-label">Document Code:</div>
                <div class="meta-value">{{ $document_code }}</div>
            </td>
            <td colspan="3" class="title-cell">
                {{ $title }}
            </td>
        </tr>
    </table>

    <table class="records-table">
        <thead>
            <tr>
                <th rowspan="2" style="width:15%;">LABORATORY CODE</th>
                <th rowspan="2" style="width:36%;">SAMPLE DESCRIPTION</th>
                <th colspan="3" style="width:27%;">DATE</th>
                <th rowspan="2" style="width:11%;">DATE FOR DISPOSAL</th>
                <th rowspan="2" style="width:11%;">DISPOSED BY</th>
            </tr>
            <tr>
                <th>RECEIVED</th>
                <th>STORED</th>
                <th>ANALYZED</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr class="row-height">
                    <td>{{ $record->lab_code }}</td>
                    <td class="desc">{{ $record->sample_desc }}</td>
                    <td>{{ $record->date_received ? \Carbon\Carbon::parse($record->date_received)->format('F j, Y') : '' }}</td>
                    <td>{{ $record->date_stored ? \Carbon\Carbon::parse($record->date_stored)->format('F j, Y') : '' }}</td>
                    <td>{{ $record->date_analyzed ? \Carbon\Carbon::parse($record->date_analyzed)->format('F j, Y') : '' }}</td>
                    <td>{{ $record->date_disposal ? \Carbon\Carbon::parse($record->date_disposal)->format('F j, Y') : '' }}</td>
                    <td>{{ $record->disposed_by }}</td>
                </tr>
            @endforeach

            @for($i = $records->count(); $i < 20; $i++)
                <tr class="row-height">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            @endfor
        </tbody>
    </table>

    <div class="footer">
        Checked by:
        {{ $record->checked_by }}
        <div class="check-line"></div>
    </div>

    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach

</body>
</html>