<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Inventory Export</title>
    <style>
        @page {
            margin: 18px 18px 22px 18px;
        }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10px;
            color: #1f2937;
        }
        .header {
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 2px solid #1e3a5f;
        }
        .title {
            margin: 0;
            font-size: 18px;
            color: #1e3a5f;
        }
        .subtitle {
            margin: 4px 0 0 0;
            color: #6b7280;
        }
        .filters {
            margin: 10px 0 14px 0;
            padding: 8px 10px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
        }
        .filters strong {
            display: inline-block;
            margin-right: 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        thead th {
            background: #1e3a5f;
            color: #fff;
            font-weight: 700;
            font-size: 9px;
            text-align: left;
            padding: 7px 6px;
            border: 1px solid #1e3a5f;
            word-wrap: break-word;
        }
        tbody td {
            border: 1px solid #d1d5db;
            padding: 6px;
            vertical-align: top;
            word-wrap: break-word;
        }
        tbody tr:nth-child(even) td {
            background: #f9fafb;
        }
        .empty {
            text-align: center;
            color: #6b7280;
            padding: 18px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Equipment Inventory</h1>
        <p class="subtitle">Filtered export generated on {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    @if(!empty($filters['search']))
        <div class="filters">
            <strong>Applied filters:</strong>
            Search = {{ $filters['search'] }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                @foreach($columns as $column)
                    <th>{{ $column['label'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($equipments as $equipment)
                <tr>
                    @foreach($columns as $column)
                        @php
                            $key = $column['key'];
                            $value = match ($key) {
                                'equipment', 'equipment_no', 'unit', 'rfl_control_no', 'description', 'brand_model', 'status_remarks', 'location' => (string) ($equipment->{$key} ?? 'N/A'),
                                'qty', 'received_quantity', 'used_quantity', 'balance_quantity' => (string) ($equipment->{$key} ?? 0),
                                'unit_cost', 'total_cost' => number_format((float) ($equipment->{$key} ?? 0), 2, '.', ''),
                                'date_acquired' => $equipment->date_acquired ? \Carbon\Carbon::parse($equipment->date_acquired)->format('Y-m-d') : 'N/A',
                                'person_in_charge' => collect(json_decode((string) $equipment->person_in_charge, true) ?: [])->map(function ($userId) use ($users) {
                                    $user = $users->get($userId);
                                    if (!$user) {
                                        return (string) $userId;
                                    }
                                    return strtoupper(
                                        ($user->f_name ? substr($user->f_name, 0, 1) : '') .
                                        ($user->m_name ? substr($user->m_name, 0, 1) : '') .
                                        ($user->l_name ? substr($user->l_name, 0, 1) : '')
                                    );
                                })->implode(', ') ?: 'N/A',
                                'updates' => trim(strip_tags((string) ($equipment->updates ?? 'N/A'))),
                                default => (string) ($equipment->{$key} ?? 'N/A'),
                            };
                        @endphp
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td class="empty" colspan="{{ count($columns) }}">No inventory data matched the current filters.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
