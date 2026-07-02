<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Equipment Inventory Export</title>
    <style>
        @page {
            margin: 108px 30px 66px 30px;
        }

        body {
            margin: 0;
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 8.8px;
            line-height: 1.34;
            color: #1f2937;
            background: #ffffff;
        }

        .pdf-header {
            position: fixed;
            top: -84px;
            left: 0;
            right: 0;
            height: 72px;
            border-bottom: 2px solid #173a5e;
        }

        .brand-table,
        .summary-table,
        .meta-table,
        .inventory-table,
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .logo-cell {
            width: 66px;
            vertical-align: middle;
            text-align: left;
        }

        .logo {
            width: 76px;
            height: 56px;
        }

        .logo-fallback {
            width: 52px;
            height: 52px;
            border: 2px solid #173a5e;
            color: #173a5e;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            line-height: 52px;
        }

        .agency {
            margin: 0;
            color: #64748b;
            font-size: 7.5px;
            text-transform: uppercase;
        }

        .title {
            margin: 1px 0 0;
            font-size: 18px;
            font-weight: bold;
            line-height: 1.08;
            color: #173a5e;
        }

        .subtitle {
            margin-top: 3px;
            color: #475569;
            font-size: 8.4px;
        }

        .header-meta {
            width: 178px;
            vertical-align: top;
            text-align: right;
            color: #475569;
            font-size: 7.7px;
            line-height: 1.45;
        }

        .doc-code {
            display: inline-block;
            padding: 3px 7px;
            border: 1px solid #9bb3cc;
            background: #eef5fb;
            color: #173a5e;
            font-weight: bold;
        }

        .watermark-logo {
            position: fixed;
            top: 178px;
            left: 315px;
            width: 210px;
            opacity: 0.045;
            z-index: -1;
        }

        .accent-bar {
            height: 5px;
            margin-bottom: 10px;
            background: #173a5e;
        }

        .section-title {
            margin: 0 0 7px;
            color: #0f172a;
            font-size: 11px;
            font-weight: bold;
        }

        .section-title .rule {
            display: inline-block;
            width: 52px;
            height: 2px;
            margin-left: 7px;
            background: #d7a642;
        }

        .summary-table {
            margin-bottom: 10px;
            table-layout: fixed;
        }

        .summary-table td {
            padding: 7px 8px;
            border: 1px solid #d7e0ea;
            background: #f8fafc;
            vertical-align: top;
        }

        .summary-label {
            color: #64748b;
            font-size: 7.2px;
            text-transform: uppercase;
        }

        .summary-value {
            margin-top: 2px;
            color: #0f172a;
            font-size: 12px;
            font-weight: bold;
        }

        .tone-primary { border-top: 3px solid #173a5e !important; }
        .tone-neutral { border-top: 3px solid #64748b !important; }
        .tone-success { border-top: 3px solid #15803d !important; }
        .tone-info { border-top: 3px solid #0369a1 !important; }
        .tone-danger { border-top: 3px solid #b91c1c !important; }

        .meta-table {
            margin-bottom: 12px;
        }

        .meta-table td {
            padding: 6px 8px;
            border: 1px solid #d7e0ea;
            vertical-align: top;
        }

        .meta-label {
            color: #64748b;
            font-weight: bold;
        }

        .divider {
            height: 1px;
            margin: 11px 0;
            background: #cbd5e1;
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .inventory-table thead {
            display: table-header-group;
        }

        .inventory-table tr {
            page-break-inside: avoid;
        }

        .inventory-table th {
            padding: 7px 5px;
            border: 1px solid #173a5e;
            background: #173a5e;
            color: #ffffff;
            font-size: 7.4px;
            font-weight: 700;
            line-height: 1.2;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }

        .inventory-table td {
            padding: 6px 5px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
            word-wrap: break-word;
        }

        .inventory-table tbody tr:nth-child(even) td {
            background: #f8fafc;
        }

        .group-row td {
            padding: 6px 8px;
            border-color: #b9cbe0;
            background: #e8f0f8 !important;
            color: #173a5e;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-maintenance td:first-child { border-left: 4px solid #b91c1c; }
        .status-in-use td:first-child { border-left: 4px solid #0369a1; }
        .status-available td:first-child { border-left: 4px solid #15803d; }
        .status-review td:first-child { border-left: 4px solid #d7a642; }

        .status-pill {
            display: inline-block;
            padding: 2px 5px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            font-size: 7px;
            font-weight: bold;
        }

        .status-pill.status-maintenance {
            border-color: #f2b8b8;
            background: #fff1f1;
            color: #991b1b;
        }

        .status-pill.status-in-use {
            border-color: #b8d8f2;
            background: #eff7ff;
            color: #075985;
        }

        .status-pill.status-available {
            border-color: #b8e2c5;
            background: #f0fdf4;
            color: #166534;
        }

        .status-pill.status-review {
            border-color: #f3d797;
            background: #fffbeb;
            color: #92400e;
        }

        .align-left { text-align: left; }
        .align-center { text-align: center; }
        .align-right { text-align: right; }
        .wrap { white-space: normal; word-wrap: break-word; }
        .nowrap { white-space: nowrap; }

        .empty {
            padding: 22px 0;
            color: #64748b;
            text-align: center;
        }

        .notes {
            margin-top: 11px;
            padding: 8px 10px;
            border: 1px solid #d7e0ea;
            background: #f8fafc;
            page-break-inside: avoid;
        }

        .notes-title {
            color: #173a5e;
            font-weight: bold;
        }

        .signature-panel {
            margin-top: 16px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-table td {
            width: 33.33%;
            padding: 20px 14px 0;
            text-align: center;
            vertical-align: bottom;
        }

        .signature-img {
            width: 122px;
            height: 42px;
        }

        .signature-line {
            border-top: 1px solid #334155;
            padding-top: 5px;
            color: #334155;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    @php
        $pdfMeta = array_replace_recursive([
            'title' => 'Equipment Inventory',
            'subtitle' => 'Controlled export of laboratory equipment records',
            'document_code' => 'LIMS-EQ-EXP',
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'search' => $filters['search'] ?? 'None',
            'organization' => [
                'republic' => 'Republic of the Philippines',
                'department' => 'Department of Agriculture',
                'agency' => 'Bureau of Fisheries and Aquatic Resources',
                'office' => 'Regional Fisheries Laboratory XII',
                'address' => 'J. Catolico St., Lagao, General Santos City',
            ],
            'summary' => [],
        ], $pdfMeta ?? []);

        $pdfAssets = array_merge([
            'logo' => null,
            'watermark' => null,
            'signature' => null,
        ], $pdfAssets ?? []);

        $renderExportCell = function ($value) use (&$renderExportCell) {
            if ($value instanceof \Illuminate\Support\Collection) {
                $value = $value->all();
            }

            if ($value instanceof \Illuminate\Contracts\Support\Arrayable) {
                $value = $value->toArray();
            }

            if ($value instanceof \DateTimeInterface) {
                return $value->format('Y-m-d');
            }

            if (is_array($value)) {
                if (empty($value)) {
                    return 'N/A';
                }

                $items = [];
                $isList = array_is_list($value);

                foreach ($value as $itemKey => $itemValue) {
                    $formatted = $renderExportCell($itemValue);

                    if ($formatted === '') {
                        continue;
                    }

                    $items[] = $isList ? $formatted : str_replace('_', ' ', (string) $itemKey) . ': ' . $formatted;
                }

                return $items ? implode(', ', $items) : 'N/A';
            }

            if (is_object($value)) {
                if (method_exists($value, '__toString')) {
                    return $renderExportCell((string) $value);
                }

                return $renderExportCell(get_object_vars($value));
            }

            if ($value === null || $value === '') {
                return 'N/A';
            }

            if (is_bool($value)) {
                return $value ? 'Yes' : 'No';
            }

            $value = trim(strip_tags((string) $value));

            if ($value === '') {
                return 'N/A';
            }

            $firstCharacter = $value[0] ?? '';

            if (in_array($firstCharacter, ['[', '{'], true)) {
                $decoded = json_decode($value, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    return $renderExportCell($decoded);
                }
            }

            return $value;
        };

        $toCells = function ($row) use ($columns, $renderExportCell) {
            if ($row instanceof \Illuminate\Support\Collection) {
                $row = $row->all();
            }

            if ($row instanceof \Illuminate\Contracts\Support\Arrayable) {
                $row = $row->toArray();
            }

            if (is_object($row)) {
                $row = get_object_vars($row);
            }

            return array_map(function ($column, $columnIndex) use ($row, $renderExportCell) {
                $value = is_array($row)
                    ? ($row[$columnIndex] ?? $row[$column['key']] ?? null)
                    : null;

                return [
                    'key' => $column['key'],
                    'value' => $renderExportCell($value),
                ];
            }, $columns, array_keys($columns));
        };

        $exportRows = $pdfRows ?? collect($rows ?? [])->map(function ($row) use ($toCells) {
            return [
                'group' => null,
                'status_class' => 'status-review',
                'cells' => $toCells($row),
            ];
        })->all();

        $columnCount = max(1, count($columns));
        $currentGroup = null;
    @endphp

    <div class="pdf-header">
        <table class="brand-table">
            <tr>
                <td class="logo-cell">
                    @if($pdfAssets['logo'])
                        <img class="logo" src="{{ $pdfAssets['logo'] }}" alt="Logo">
                    @else
                        <div class="logo-fallback">LIMS</div>
                    @endif
                </td>
                <td>
                    <p class="agency">{{ $pdfMeta['organization']['republic'] }} | {{ $pdfMeta['organization']['department'] }}</p>
                    <h1 class="title">{{ $pdfMeta['title'] }}</h1>
                    <div class="subtitle">
                        {{ $pdfMeta['organization']['agency'] }} - {{ $pdfMeta['organization']['office'] }}<br>
                        {{ $pdfMeta['organization']['address'] }}
                    </div>
                </td>
                <td class="header-meta">
                    <span class="doc-code">{{ $pdfMeta['document_code'] }}</span><br>
                    Generated: {{ $pdfMeta['generated_at'] }}<br>
                    Search: {{ $pdfMeta['search'] }}
                </td>
            </tr>
        </table>
    </div>

    @if($pdfAssets['watermark'])
        <img class="watermark-logo" src="{{ $pdfAssets['watermark'] }}" alt="Watermark">
    @endif

    <div class="accent-bar"></div>

    <!-- <h2 class="section-title">Export Summary <span class="rule"></span></h2>
    <table class="summary-table">
        <tr>
            @forelse($pdfMeta['summary'] as $item)
                <td class="tone-{{ $item['tone'] ?? 'neutral' }}">
                    <div class="summary-label">{{ $item['label'] }}</div>
                    <div class="summary-value">{{ $item['value'] }}</div>
                </td>
            @empty
                <td class="tone-primary">
                    <div class="summary-label">Records</div>
                    <div class="summary-value">{{ count($exportRows) }}</div>
                </td>
            @endforelse
        </tr>
    </table> -->

    <!-- <table class="meta-table">
        <tr>
            <td>
                <span class="meta-label">Layout:</span>
                A4 landscape, controlled margins, repeated table headers, grouped rows, fixed-width columns
            </td>
            <td>
                <span class="meta-label">Selected columns:</span>
                {{ collect($columns)->pluck('label')->implode(', ') }}
            </td>
        </tr>
    </table> -->

    <div class="divider"></div>

    <h2 class="section-title">Equipment Records <span class="rule"></span></h2>
    <table class="inventory-table">
        <colgroup>
            @foreach($columns as $column)
                <col style="width: {{ $column['width'] ?? number_format(100 / $columnCount, 2, '.', '') . '%' }};">
            @endforeach
        </colgroup>
        <thead>
            <tr>
                @foreach($columns as $column)
                    <th>{{ $column['label'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($exportRows as $row)
                @if(!empty($row['group']) && $currentGroup !== $row['group'])
                    @php $currentGroup = $row['group']; @endphp
                    <tr class="group-row">
                        <td colspan="{{ $columnCount }}">Location: {{ $row['group'] }}</td>
                    </tr>
                @endif

                <tr class="{{ $row['status_class'] ?? 'status-review' }}">
                    @foreach($columns as $columnIndex => $column)
                        @php
                            $cell = $row['cells'][$columnIndex] ?? [];
                            $value = $renderExportCell($cell['value'] ?? null);
                            $align = $column['align'] ?? 'left';
                            $wrap = ($column['wrap'] ?? true) ? 'wrap' : 'nowrap';
                        @endphp
                        <td class="align-{{ $align }} {{ $wrap }}">
                            @if(($column['key'] ?? '') === 'status_remarks')
                                <span class="status-pill {{ $row['status_class'] ?? 'status-review' }}">{{ $value }}</span>
                            @else
                                {!! nl2br(e($value)) !!}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td class="empty" colspan="{{ $columnCount }}">No inventory data matched the current filters.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- <div class="notes">
        <span class="notes-title">Legend:</span>
        Green left border = available, blue = in use, red = maintenance, amber = needs review or uncategorized.
        Long values and JSON fields are wrapped and converted to readable text before rendering.
    </div> -->

    <!-- <div class="signature-panel">
        <table class="signature-table">
            <tr>
                <td>
                    @if($pdfAssets['signature'])
                        <img class="signature-img" src="{{ $pdfAssets['signature'] }}" alt="Prepared signature">
                    @endif
                    <div class="signature-line">Prepared By</div>
                </td>
                <td>
                    <div class="signature-line">Reviewed By</div>
                </td>
                <td>
                    <div class="signature-line">Approved By</div>
                </td>
            </tr>
        </table>
    </div> -->
</body>
</html>
