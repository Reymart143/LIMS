<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->equipmentQuery($request);

        $equipments = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $totalItems = Equipment::count();
        $availableCount = Equipment::where(function ($builder) {
            $builder->whereNull('status_remarks')
                ->orWhereRaw("LOWER(COALESCE(status_remarks, '')) LIKE ?", ['%available%']);
        })->count();
        $inUseCount = Equipment::whereRaw("LOWER(COALESCE(status_remarks, '')) LIKE ?", ['%in use%'])->count();
        $underMaintenanceCount = Equipment::whereRaw("LOWER(COALESCE(status_remarks, '')) LIKE ?", ['%maintenance%'])->count();
        $equipmentDropdown = DB::table('lf_03_05')
            ->select('id', 'equipment', 'model', 'equipment_no', 'location', 'year', 'date')
            ->get();
        $users = DB::table('users')->select('id', 'f_name', 'm_name', 'l_name')->get();
        $equipmentTableColumns = $this->equipmentTableColumns();
        
        return view('Equipments.index', compact('equipments', 'equipmentDropdown', 'users', 'totalItems', 'availableCount', 'inUseCount', 'underMaintenanceCount', 'equipmentTableColumns'));
    }

    public function export(Request $request)
    {
        $format = strtolower((string) $request->input('format', 'xlsx'));
        $columns = $this->resolveEquipmentColumns($request->input('columns', []));
        $equipments = $this->equipmentQuery($request)->orderBy('id', 'desc')->get();
        $users = DB::table('users')->select('id', 'f_name', 'm_name', 'l_name')->get()->keyBy('id');
        $filters = [
            'search' => trim((string) $request->input('search', '')),
        ];

        $rows = $this->equipmentExportRows($columns, $equipments, $users);

        if ($format === 'pdf') {
            $pdfColumns = $this->equipmentPdfColumns($columns);
            $pdfRows = $this->equipmentPdfRows($pdfColumns, $equipments, $users);
            $pdfMeta = $this->equipmentPdfMeta($equipments, $columns, $filters);
            $pdfAssets = $this->equipmentPdfAssets();

            $pdf = Pdf::loadView('Equipments.export', [
                'columns' => $pdfColumns,
                'equipments' => $equipments,
                'rows' => $rows,
                'pdfRows' => $pdfRows,
                'pdfMeta' => $pdfMeta,
                'pdfAssets' => $pdfAssets,
                'users' => $users,
                'filters' => $filters,
            ])->setPaper('a4', 'landscape')
                ->setWarnings(false)
                ->setOption([
                    'dpi' => 150,
                    'defaultFont' => 'DejaVu Sans',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => false,
                ]);

            $this->addEquipmentPdfPageDecorations($pdf, $pdfMeta);

            return $pdf->download('equipment-inventory-' . now()->format('Ymd-His') . '.pdf');
        }

        return $this->downloadEquipmentExcel($columns, $equipments, $users, $filters);
    }

    public function create()
    {
        return view('Equipments.create');
    }

    public function store(StoreEquipmentRequest $request)
    {
        try {
            $validated = $request->validated();

            $validated['total_cost'] = ($validated['qty'] ?? 0) * ($validated['unit_cost'] ?? 0);
            $validated['balance_quantity'] = max(0, ($validated['received_quantity'] ?? 0) - ($validated['used_quantity'] ?? 0));
            $validated['person_in_charge'] = array_values(array_map('intval', $validated['person_in_charge'] ?? []));

            $equipment = Equipment::create($validated);

            return redirect()->route('equipments.index')->with('success', 'Record created successfully.');
        } catch (\Exception $e) {
            Log::error('Equipment creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['save' => 'Failed to add equipment. Please review the form and try again.'])
                ->withInput();
        }
    }

    public function show(string $id)
    {
        $equipment = Equipment::findOrFail($id);
        return response()->json($equipment);
    }

    public function edit(string $id)
    {
        $equipment = Equipment::findOrFail($id);

        $equipmentDropdown = DB::table('lf_03_05')
            ->select('id', 'equipment', 'model', 'equipment_no', 'location', 'year', 'date')
            ->get();

        $users = DB::table('users')->select('id', 'f_name', 'm_name', 'l_name')->get();

        return view('Equipments.edit', compact('equipment', 'equipmentDropdown', 'users'));
    }

    public function update(UpdateEquipmentRequest $request, string $id)
    {
        try {
            $equipment = Equipment::findOrFail($id);

            $validated = $request->validated();

            $validated['total_cost'] = ($validated['qty'] ?? 0) * ($validated['unit_cost'] ?? 0);
            $validated['balance_quantity'] = max(0, ($validated['received_quantity'] ?? 0) - ($validated['used_quantity'] ?? 0));
            $validated['person_in_charge'] = array_values(array_map('intval', $validated['person_in_charge'] ?? []));

            $equipment->update($validated);

            return redirect()->route('equipments.index')->with('success', 'Changes have been saved.');
        } catch (\Exception $e) {
            Log::error('Equipment update failed: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['save' => 'Failed to update equipment. Please review the form and try again.'])
                ->withInput();
        }
    }

    public function destroy(string $id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->route('equipments.index')->with('success', 'Record deleted successfully.');
    }

    public function getEquipmentDetails($id)
    {
        $equipment = DB::table('lf_03_05')
            ->select('id', 'equipment', 'model', 'equipment_no', 'location', 'year', 'date')
            ->where('id', $id)
            ->first();

        if (!$equipment) {
            return response()->json(['error' => 'Equipment not found'], 404);
        }

        return response()->json([
            'id' => $equipment->id,
            'equipment' => $equipment->equipment,
            'model' => $equipment->model,
            'equipment_no' => $equipment->equipment_no,
            'location' => $equipment->location,
            'year' => $equipment->year,
            'date' => $equipment->date,
        ]);
    }

    public function searchEquipment(Request $request)
    {
        $search = $request->input('q');
        
        $equipments = DB::table('lf_03_05')
            ->select('id', 'equipment', 'model', 'equipment_no', 'location', 'year', 'date')
            ->where('equipment', 'like', '%' . $search . '%')
            ->orWhere('model', 'like', '%' . $search . '%')
            ->limit(20)
            ->get();

        return response()->json($equipments);
    }

    public function getUsers(Request $request)
    {
        $search = $request->input('q', '');
        
        $users = DB::table('users')
            ->select('id', 'f_name', 'm_name', 'l_name')
            ->where(function ($query) use ($search) {
                $query->where('f_name', 'like', '%' . $search . '%')
                    ->orWhere('l_name', 'like', '%' . $search . '%');
            })
            ->limit(20)
            ->get()
            ->map(function ($user) {
                $initials = strtoupper(
                    ($user->f_name ? substr($user->f_name, 0, 1) : '') .
                    ($user->m_name ? substr($user->m_name, 0, 1) : '') .
                    ($user->l_name ? substr($user->l_name, 0, 1) : '')
                );
                return [
                    'id' => $user->id,
                    'initials' => $initials,
                ];
            });

        return response()->json($users);
    }

    private function equipmentQuery(Request $request)
    {
        $query = Equipment::query();

        if ($search = trim((string) $request->input('search', ''))) {
            $query->where(function ($builder) use ($search) {
                $builder->where('equipment', 'like', '%' . $search . '%')
                    ->orWhere('equipment_no', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('brand_model', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%')
                    ->orWhere('status_remarks', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }

    private function equipmentTableColumns(): array
    {
        return [
            ['key' => 'equipment', 'label' => 'Equipment', 'default_visible' => true, 'type' => 'text'],
            ['key' => 'equipment_no', 'label' => 'Equipment No.', 'default_visible' => true, 'type' => 'text'],
            ['key' => 'qty', 'label' => 'QTY', 'default_visible' => true, 'type' => 'number'],
            ['key' => 'unit', 'label' => 'Unit', 'default_visible' => true, 'type' => 'text'],
            ['key' => 'rfl_control_no', 'label' => 'RFL Control No.', 'default_visible' => false, 'type' => 'text'],
            ['key' => 'description', 'label' => 'Description', 'default_visible' => true, 'type' => 'text'],
            ['key' => 'brand_model', 'label' => 'Brand', 'default_visible' => false, 'type' => 'text'],
            ['key' => 'date_acquired', 'label' => 'Date Acquired', 'default_visible' => false, 'type' => 'date'],
            ['key' => 'unit_cost', 'label' => 'Unit Cost', 'default_visible' => false, 'type' => 'number'],
            ['key' => 'total_cost', 'label' => 'Total Cost', 'default_visible' => false, 'type' => 'number'],
            ['key' => 'status_remarks', 'label' => 'Status/Remarks', 'default_visible' => true, 'type' => 'text'],
            ['key' => 'received_quantity', 'label' => 'Received Quantity', 'default_visible' => false, 'type' => 'number'],
            ['key' => 'used_quantity', 'label' => 'Used Quantity', 'default_visible' => false, 'type' => 'number'],
            ['key' => 'balance_quantity', 'label' => 'Balance Quantity', 'default_visible' => false, 'type' => 'number'],
            ['key' => 'location', 'label' => 'Location', 'default_visible' => false, 'type' => 'text'],
            ['key' => 'person_in_charge', 'label' => 'Person In-Charge', 'default_visible' => false, 'type' => 'text'],
            ['key' => 'updates', 'label' => 'Updates', 'default_visible' => false, 'type' => 'html'],
        ];
    }

    private function resolveEquipmentColumns(array $requestedColumns): array
    {
        $definitions = $this->equipmentTableColumns();
        $requestedColumns = array_values(array_filter(array_map('strval', $requestedColumns)));

        if (empty($requestedColumns)) {
            return array_values(array_filter($definitions, function ($definition) {
                return !empty($definition['default_visible']);
            }));
        }

        $definitionMap = collect($definitions)->keyBy('key');

        return collect($requestedColumns)
            ->map(function ($key) use ($definitionMap) {
                return $definitionMap->get($key);
            })
            ->filter()
            ->values()
            ->all();
    }

    private function equipmentExportRows(array $columns, $equipments, $users): array
    {
        return $equipments->map(function ($equipment) use ($columns, $users) {
            return array_map(function ($column) use ($equipment, $users) {
                return $this->equipmentExportValue($equipment, $column['key'], $users);
            }, $columns);
        })->all();
    }

    private function equipmentPdfColumns(array $columns): array
    {
        $layoutMap = [
            'equipment' => ['weight' => 16, 'align' => 'left', 'wrap' => true],
            'equipment_no' => ['weight' => 10, 'align' => 'center', 'wrap' => true],
            'qty' => ['weight' => 6, 'align' => 'right', 'wrap' => false],
            'unit' => ['weight' => 6, 'align' => 'center', 'wrap' => false],
            'rfl_control_no' => ['weight' => 10, 'align' => 'center', 'wrap' => true],
            'description' => ['weight' => 20, 'align' => 'left', 'wrap' => true],
            'brand_model' => ['weight' => 12, 'align' => 'left', 'wrap' => true],
            'date_acquired' => ['weight' => 9, 'align' => 'center', 'wrap' => false],
            'unit_cost' => ['weight' => 9, 'align' => 'right', 'wrap' => false],
            'total_cost' => ['weight' => 10, 'align' => 'right', 'wrap' => false],
            'status_remarks' => ['weight' => 14, 'align' => 'center', 'wrap' => true],
            'received_quantity' => ['weight' => 8, 'align' => 'right', 'wrap' => false],
            'used_quantity' => ['weight' => 8, 'align' => 'right', 'wrap' => false],
            'balance_quantity' => ['weight' => 8, 'align' => 'right', 'wrap' => false],
            'location' => ['weight' => 12, 'align' => 'left', 'wrap' => true],
            'person_in_charge' => ['weight' => 12, 'align' => 'center', 'wrap' => true],
            'updates' => ['weight' => 20, 'align' => 'left', 'wrap' => true],
        ];

        $columns = array_map(function ($column) use ($layoutMap) {
            $layout = $layoutMap[$column['key']] ?? ['weight' => 12, 'align' => 'left', 'wrap' => true];

            return array_merge($column, $layout);
        }, $columns);

        $totalWeight = max(1, array_sum(array_column($columns, 'weight')));

        return array_map(function ($column) use ($totalWeight) {
            $column['width'] = number_format(($column['weight'] / $totalWeight) * 100, 2, '.', '') . '%';

            return $column;
        }, $columns);
    }

    private function equipmentPdfRows(array $columns, $equipments, $users): array
    {
        return $equipments->map(function ($equipment) use ($columns, $users) {
            $group = $this->formatExportValue($equipment->location ?? null);

            return [
                'group' => $group === 'N/A' ? 'Unassigned Location' : $group,
                'status_class' => $this->equipmentStatusClass($equipment->status_remarks ?? null),
                'cells' => array_map(function ($column) use ($equipment, $users) {
                    return [
                        'key' => $column['key'],
                        'value' => $this->equipmentExportValue($equipment, $column['key'], $users),
                    ];
                }, $columns),
            ];
        })->all();
    }

    private function equipmentPdfMeta($equipments, array $columns, array $filters): array
    {
        $total = $equipments->count();
        $available = 0;
        $inUse = 0;
        $maintenance = 0;

        foreach ($equipments as $equipment) {
            $status = strtolower($this->formatExportValue($equipment->status_remarks ?? null));

            if ($status === 'n/a' || str_contains($status, 'available')) {
                $available++;
            }

            if (str_contains($status, 'in use')) {
                $inUse++;
            }

            if (str_contains($status, 'maintenance')) {
                $maintenance++;
            }
        }

        return [
            'title' => 'Equipment Inventory',
            'subtitle' => 'Controlled export of laboratory equipment records',
            'document_code' => 'LIMS-EQ-EXP',
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'search' => $filters['search'] ?: 'None',
            'organization' => [
                'republic' => 'Republic of the Philippines',
                'department' => 'Department of Agriculture',
                'agency' => 'Bureau of Fisheries and Aquatic Resources',
                'office' => 'Regional Fisheries Laboratory XII',
                'address' => 'J. Catolico St., Lagao, General Santos City',
            ],
            'summary' => [
                ['label' => 'Records', 'value' => number_format($total), 'tone' => 'primary'],
                ['label' => 'Columns', 'value' => number_format(count($columns)), 'tone' => 'neutral'],
                ['label' => 'Available', 'value' => number_format($available), 'tone' => 'success'],
                ['label' => 'In Use', 'value' => number_format($inUse), 'tone' => 'info'],
                ['label' => 'Maintenance', 'value' => number_format($maintenance), 'tone' => 'danger'],
            ],
        ];
    }

    private function equipmentPdfAssets(): array
    {
        $logo = public_path('assets/images/bfarlogo.png');
        $signature = public_path('assets/images/signature.png');

        return [
            'logo' => is_file($logo) ? $logo : null,
            'watermark' => is_file($logo) ? $logo : null,
            'signature' => is_file($signature) ? $signature : null,
        ];
    }

    private function addEquipmentPdfPageDecorations($pdf, array $pdfMeta): void
    {
        $pdf->render();

        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($pdfMeta) {
            $font = $fontMetrics->getFont('DejaVu Sans');
            $bold = $fontMetrics->getFont('DejaVu Sans', 'bold');
            $pageWidth = $canvas->get_width();
            $pageHeight = $canvas->get_height();

            $watermark = 'CONTROLLED COPY';
            $watermarkSize = 42;
            $watermarkWidth = $fontMetrics->getTextWidth($watermark, $bold, $watermarkSize);
            $canvas->text(
                ($pageWidth - $watermarkWidth) / 2,
                ($pageHeight / 2) + 28,
                $watermark,
                $bold,
                $watermarkSize,
                [0.72, 0.78, 0.86, 'alpha' => 0.18],
                0,
                0,
                -18
            );

            $footerY = $pageHeight - 42;
            $canvas->line(30, $footerY, $pageWidth - 30, $footerY, [0.12, 0.23, 0.37], 0.6);

            $leftText = ($pdfMeta['document_code'] ?? 'LIMS-EQ-EXP') . ' | Generated ' . ($pdfMeta['generated_at'] ?? now()->format('Y-m-d H:i:s'));
            $canvas->text(30, $footerY + 12, $leftText, $font, 7.5, [0.28, 0.33, 0.40]);

            $pageText = "Page {$pageNumber} of {$pageCount}";
            $pageTextWidth = $fontMetrics->getTextWidth($pageText, $font, 7.5);
            $canvas->text($pageWidth - 30 - $pageTextWidth, $footerY + 12, $pageText, $font, 7.5, [0.28, 0.33, 0.40]);
        });
    }

    private function equipmentStatusClass(mixed $status): string
    {
        $status = strtolower($this->formatExportValue($status));

        if (str_contains($status, 'maintenance')) {
            return 'status-maintenance';
        }

        if (str_contains($status, 'in use')) {
            return 'status-in-use';
        }

        if ($status === 'n/a' || str_contains($status, 'available')) {
            return 'status-available';
        }

        return 'status-review';
    }

    private function equipmentExportValue($equipment, string $key, $users): string
    {
        $raw = $equipment->{$key} ?? null;

        switch ($key) {
            case 'equipment':
            case 'equipment_no':
            case 'unit':
            case 'rfl_control_no':
            case 'description':
            case 'brand_model':
            case 'status_remarks':
            case 'location':
                return $this->formatExportValue($raw);
            case 'qty':
            case 'received_quantity':
            case 'used_quantity':
            case 'balance_quantity':
                if ($this->isEmptyExportValue($raw)) {
                    return '0';
                }

                return is_numeric($raw) ? (string) $raw : $this->formatExportValue($raw);
            case 'unit_cost':
            case 'total_cost':
                if ($this->isEmptyExportValue($raw)) {
                    return number_format(0, 2, '.', '');
                }

                return is_numeric($raw) ? number_format((float) $raw, 2, '.', '') : $this->formatExportValue($raw);
            case 'date_acquired':
                if ($this->isEmptyExportValue($raw)) {
                    return 'N/A';
                }

                if ($raw instanceof \DateTimeInterface || is_scalar($raw)) {
                    try {
                        return \Carbon\Carbon::parse($raw)->format('Y-m-d');
                    } catch (\Throwable $exception) {
                        return $this->formatExportValue($raw);
                    }
                }

                return $this->formatExportValue($raw);
            case 'person_in_charge':
                $personInCharge = $raw;
                if (is_string($personInCharge)) {
                    $personInCharge = json_decode($personInCharge, true);
                }
                if ($personInCharge instanceof Collection) {
                    $personInCharge = $personInCharge->all();
                }
                $personInCharge = is_array($personInCharge) ? $personInCharge : [];

                if (empty($personInCharge)) {
                    return 'N/A';
                }

                return collect($personInCharge)->map(function ($person) use ($users) {
                    $userId = $this->extractUserId($person);

                    if ($userId === null) {
                        return $this->formatExportValue($person);
                    }

                    $user = $users->get($userId);

                    if (!$user) {
                        return $this->formatExportValue($userId);
                    }

                    return strtoupper(
                        ($user->f_name ? substr($user->f_name, 0, 1) : '') .
                        ($user->m_name ? substr($user->m_name, 0, 1) : '') .
                        ($user->l_name ? substr($user->l_name, 0, 1) : '')
                    );
                })->filter(function ($value) {
                    return $value !== '';
                })->implode(', ') ?: 'N/A';
            case 'updates':
                return $this->formatExportValue($raw);
            default:
                return $this->formatExportValue($raw);
        }
    }

    private function extractUserId(mixed $person): int|string|null
    {
        if (is_int($person) || is_string($person)) {
            return $person;
        }

        if ($person instanceof Arrayable) {
            $person = $person->toArray();
        }

        if (is_array($person)) {
            $userId = $person['id'] ?? $person['user_id'] ?? null;

            return is_int($userId) || is_string($userId) ? $userId : null;
        }

        if (is_object($person)) {
            $userId = $person->id ?? $person->user_id ?? null;

            return is_int($userId) || is_string($userId) ? $userId : null;
        }

        return null;
    }

    private function formatExportValue(mixed $value): string
    {
        if ($value instanceof Collection) {
            $value = $value->all();
        }

        if ($value instanceof Arrayable) {
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
                $formatted = $this->formatExportValue($itemValue);

                if ($formatted === '') {
                    continue;
                }

                $items[] = $isList ? $formatted : str_replace('_', ' ', (string) $itemKey) . ': ' . $formatted;
            }

            return $items ? implode(', ', $items) : 'N/A';
        }

        if (is_object($value)) {
            if (method_exists($value, '__toString')) {
                return $this->formatExportValue((string) $value);
            }

            return $this->formatExportValue(get_object_vars($value));
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

        $decoded = $this->decodeJsonExportValue($value);

        if ($decoded !== null) {
            return $this->formatExportValue($decoded);
        }

        return $value;
    }

    private function decodeJsonExportValue(string $value): mixed
    {
        $firstCharacter = $value[0] ?? '';

        if (!in_array($firstCharacter, ['[', '{'], true)) {
            return null;
        }

        $decoded = json_decode($value, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
    }

    private function isEmptyExportValue(mixed $value): bool
    {
        if ($value instanceof Collection) {
            return $value->isEmpty();
        }

        if ($value instanceof Arrayable) {
            $value = $value->toArray();
        }

        return $value === null || $value === '' || (is_array($value) && empty($value));
    }

    private function downloadEquipmentExcel(array $columns, $equipments, $users, array $filters)
    {
        $xlsxColumns = $this->equipmentPdfColumns($columns);
        $xlsxRows = $this->equipmentXlsxRows($xlsxColumns, $equipments, $users);
        $xlsxMeta = $this->equipmentPdfMeta($equipments, $columns, $filters);
        $xlsxAssets = $this->equipmentPdfAssets();
        $logo = $this->equipmentXlsxImage($xlsxAssets['logo'] ?? null);
        $layout = $this->equipmentXlsxLayout($xlsxColumns, $xlsxRows);

        $tempFile = tempnam(sys_get_temp_dir(), 'equipment-xlsx-');
        $zip = new \ZipArchive();

        if ($zip->open($tempFile, \ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Unable to create Excel export.');
        }

        $zip->addFromString('[Content_Types].xml', $this->equipmentXlsxContentTypesXml($logo));
        $zip->addFromString('_rels/.rels', $this->equipmentXlsxRootRelsXml());
        $zip->addFromString('docProps/app.xml', $this->equipmentXlsxAppXml());
        $zip->addFromString('docProps/core.xml', $this->equipmentXlsxCoreXml());
        $zip->addFromString('xl/workbook.xml', $this->equipmentXlsxWorkbookXml($layout));
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->equipmentXlsxWorkbookRelsXml());
        $zip->addFromString('xl/styles.xml', $this->equipmentXlsxStylesXml());
        $zip->addFromString('xl/worksheets/sheet1.xml', $this->equipmentXlsxWorksheetXml($xlsxColumns, $xlsxRows, $xlsxMeta, $layout, $logo));

        if ($logo) {
            $zip->addFromString('xl/worksheets/_rels/sheet1.xml.rels', $this->equipmentXlsxWorksheetRelsXml());
            $zip->addFromString('xl/drawings/drawing1.xml', $this->equipmentXlsxDrawingXml());
            $zip->addFromString('xl/drawings/_rels/drawing1.xml.rels', $this->equipmentXlsxDrawingRelsXml($logo));
            $zip->addFile($logo['path'], 'xl/media/' . $logo['filename']);
        }

        $zip->close();

        $fileName = 'equipment-inventory-' . now()->format('Ymd-His') . '.xlsx';

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    private function equipmentXlsxRows(array $columns, $equipments, $users): array
    {
        return $equipments->map(function ($equipment) use ($columns, $users) {
            $group = $this->formatExportValue($equipment->location ?? null);

            return [
                'group' => $group === 'N/A' ? 'Unassigned Location' : $group,
                'status_class' => $this->equipmentStatusClass($equipment->status_remarks ?? null),
                'cells' => array_map(function ($column) use ($equipment, $users) {
                    return $this->equipmentXlsxCellValue($equipment, $column, $users);
                }, $columns),
            ];
        })->all();
    }

    private function equipmentXlsxCellValue($equipment, array $column, $users): array
    {
        $key = $column['key'];
        $raw = $equipment->{$key} ?? null;

        return match ($key) {
            'qty', 'received_quantity', 'used_quantity', 'balance_quantity' => [
                'key' => $key,
                'value' => $this->isEmptyExportValue($raw) ? 0 : (int) $raw,
                'type' => 'number',
                'format' => 'integer',
            ],
            'unit_cost', 'total_cost' => [
                'key' => $key,
                'value' => $this->isEmptyExportValue($raw) ? 0 : (float) $raw,
                'type' => 'number',
                'format' => 'currency',
            ],
            'date_acquired' => $this->equipmentXlsxDateCell($key, $raw),
            default => [
                'key' => $key,
                'value' => $this->equipmentExportValue($equipment, $key, $users),
                'type' => 'string',
                'format' => 'text',
            ],
        };
    }

    private function equipmentXlsxDateCell(string $key, mixed $raw): array
    {
        if (!$this->isEmptyExportValue($raw)) {
            try {
                $date = \Carbon\Carbon::parse($raw)->startOfDay();
                $excelEpoch = \Carbon\Carbon::create(1899, 12, 30)->startOfDay();

                return [
                    'key' => $key,
                    'value' => $excelEpoch->diffInDays($date, false),
                    'type' => 'number',
                    'format' => 'date',
                ];
            } catch (\Throwable $exception) {
                return [
                    'key' => $key,
                    'value' => $this->formatExportValue($raw),
                    'type' => 'string',
                    'format' => 'text',
                ];
            }
        }

        return [
            'key' => $key,
            'value' => 'N/A',
            'type' => 'string',
            'format' => 'text',
        ];
    }

    private function equipmentXlsxLayout(array $columns, array $rows): array
    {
        $sheetColumnCount = max(count($columns), 8);
        $tableHeaderRow = 11;
        $dataStartRow = $tableHeaderRow + 1;
        $lastRow = $tableHeaderRow;
        $currentGroup = null;

        foreach ($rows as $row) {
            if (!empty($row['group']) && $currentGroup !== $row['group']) {
                $lastRow++;
                $currentGroup = $row['group'];
            }

            $lastRow++;
        }

        return [
            'sheet_name' => 'Equipment Inventory',
            'sheet_column_count' => $sheetColumnCount,
            'table_column_count' => max(1, count($columns)),
            'table_header_row' => $tableHeaderRow,
            'data_start_row' => $dataStartRow,
            'last_row' => max($lastRow, $dataStartRow),
        ];
    }

    private function equipmentXlsxImage(?string $path): ?array
    {
        if (!$path || !is_file($path)) {
            return null;
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $contentTypes = [
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
        ];

        if (!isset($contentTypes[$extension])) {
            return null;
        }

        return [
            'path' => $path,
            'extension' => $extension,
            'content_type' => $contentTypes[$extension],
            'filename' => 'equipment-logo.' . $extension,
        ];
    }

    private function equipmentXlsxContentTypesXml(?array $logo = null): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $xml .= '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">';
        $xml .= '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>';
        $xml .= '<Default Extension="xml" ContentType="application/xml"/>';

        if ($logo) {
            $xml .= '<Default Extension="' . $this->xmlEscape($logo['extension']) . '" ContentType="' . $this->xmlEscape($logo['content_type']) . '"/>';
            $xml .= '<Override PartName="/xl/drawings/drawing1.xml" ContentType="application/vnd.openxmlformats-officedocument.drawing+xml"/>';
        }

        $xml .= '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>';
        $xml .= '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>';
        $xml .= '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>';
        $xml .= '<Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>';
        $xml .= '<Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/>';
        $xml .= '</Types>';

        return $xml;
    }

    private function equipmentXlsxRootRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>';
    }

    private function equipmentXlsxAppXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties" '
            . 'xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">'
            . '<Application>Laravel</Application>'
            . '</Properties>';
    }

    private function equipmentXlsxCoreXml(): string
    {
        $createdAt = now()->toAtomString();

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" '
            . 'xmlns:dc="http://purl.org/dc/elements/1.1/" '
            . 'xmlns:dcterms="http://purl.org/dc/terms/" '
            . 'xmlns:dcmitype="http://purl.org/dc/dcmitype/" '
            . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">'
            . '<dc:creator>Laravel</dc:creator>'
            . '<cp:lastModifiedBy>Laravel</cp:lastModifiedBy>'
            . '<dcterms:created xsi:type="dcterms:W3CDTF">' . $createdAt . '</dcterms:created>'
            . '<dcterms:modified xsi:type="dcterms:W3CDTF">' . $createdAt . '</dcterms:modified>'
            . '</cp:coreProperties>';
    }

    private function equipmentXlsxWorkbookXml(array $layout): string
    {
        $sheetName = $this->xlsxSheetName($layout['sheet_name']);
        $lastColumn = $this->excelColumnName($layout['sheet_column_count']);
        $tableHeaderRow = $layout['table_header_row'];
        $lastRow = $layout['last_row'];

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '
            . 'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="' . $this->xmlEscape($layout['sheet_name']) . '" sheetId="1" r:id="rId1"/></sheets>'
            . '<definedNames>'
            . '<definedName name="_xlnm.Print_Titles" localSheetId="0">' . $sheetName . '!$' . $tableHeaderRow . ':$' . $tableHeaderRow . '</definedName>'
            . '<definedName name="_xlnm.Print_Area" localSheetId="0">' . $sheetName . '!$A$1:$' . $lastColumn . '$' . $lastRow . '</definedName>'
            . '</definedNames>'
            . '</workbook>';
    }

    private function equipmentXlsxWorkbookRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>';
    }

    private function equipmentXlsxStylesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<numFmts count="3">'
            . '<numFmt numFmtId="164" formatCode="#,##0"/>'
            . '<numFmt numFmtId="165" formatCode="#,##0.00"/>'
            . '<numFmt numFmtId="166" formatCode="yyyy-mm-dd"/>'
            . '</numFmts>'
            . '<fonts count="9">'
            . '<font><sz val="10"/><color rgb="FF1F2937"/><name val="DejaVu Sans"/></font>'
            . '<font><b/><sz val="18"/><color rgb="FF173A5E"/><name val="DejaVu Sans"/></font>'
            . '<font><sz val="9"/><color rgb="FF475569"/><name val="DejaVu Sans"/></font>'
            . '<font><b/><sz val="9"/><color rgb="FFFFFFFF"/><name val="DejaVu Sans"/></font>'
            . '<font><b/><sz val="8"/><color rgb="FF64748B"/><name val="DejaVu Sans"/></font>'
            . '<font><b/><sz val="13"/><color rgb="FF0F172A"/><name val="DejaVu Sans"/></font>'
            . '<font><b/><sz val="9"/><color rgb="FF173A5E"/><name val="DejaVu Sans"/></font>'
            . '<font><b/><sz val="9"/><color rgb="FF334155"/><name val="DejaVu Sans"/></font>'
            . '<font><b/><sz val="9"/><color rgb="FF991B1B"/><name val="DejaVu Sans"/></font>'
            . '</fonts>'
            . '<fills count="11">'
            . '<fill><patternFill patternType="none"/></fill>'
            . '<fill><patternFill patternType="gray125"/></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FF173A5E"/><bgColor indexed="64"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFF8FAFC"/><bgColor indexed="64"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFE8F0F8"/><bgColor indexed="64"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFF8FAFC"/><bgColor indexed="64"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFF0FDF4"/><bgColor indexed="64"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFEFF7FF"/><bgColor indexed="64"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFFFF1F1"/><bgColor indexed="64"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFFFFBEB"/><bgColor indexed="64"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFEEF5FB"/><bgColor indexed="64"/></patternFill></fill>'
            . '</fills>'
            . '<borders count="4">'
            . '<border><left/><right/><top/><bottom/><diagonal/></border>'
            . '<border><left style="thin"><color rgb="FFD7E0EA"/></left><right style="thin"><color rgb="FFD7E0EA"/></right><top style="thin"><color rgb="FFD7E0EA"/></top><bottom style="thin"><color rgb="FFD7E0EA"/></bottom><diagonal/></border>'
            . '<border><left style="thin"><color rgb="FF173A5E"/></left><right style="thin"><color rgb="FF173A5E"/></right><top style="thin"><color rgb="FF173A5E"/></top><bottom style="thin"><color rgb="FF173A5E"/></bottom><diagonal/></border>'
            . '<border><left/><right/><top style="thin"><color rgb="FF334155"/></top><bottom/><diagonal/></border>'
            . '</borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="27">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0" applyAlignment="1"><alignment vertical="top"/></xf>'
            . '<xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0" applyFont="1" applyAlignment="1"><alignment vertical="center" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="2" fillId="0" borderId="0" xfId="0" applyFont="1" applyAlignment="1"><alignment vertical="center" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="6" fillId="10" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="4" fillId="3" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="5" fillId="3" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="3" fillId="2" borderId="2" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="6" fillId="4" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment horizontal="left" vertical="top" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="top" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment horizontal="right" vertical="top"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="5" borderId="1" xfId="0" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="left" vertical="top" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="5" borderId="1" xfId="0" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="top" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="5" borderId="1" xfId="0" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="right" vertical="top"/></xf>'
            . '<xf numFmtId="164" fontId="0" fillId="0" borderId="1" xfId="0" applyNumberFormat="1" applyBorder="1" applyAlignment="1"><alignment horizontal="right" vertical="top"/></xf>'
            . '<xf numFmtId="164" fontId="0" fillId="5" borderId="1" xfId="0" applyNumberFormat="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="right" vertical="top"/></xf>'
            . '<xf numFmtId="165" fontId="0" fillId="0" borderId="1" xfId="0" applyNumberFormat="1" applyBorder="1" applyAlignment="1"><alignment horizontal="right" vertical="top"/></xf>'
            . '<xf numFmtId="165" fontId="0" fillId="5" borderId="1" xfId="0" applyNumberFormat="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="right" vertical="top"/></xf>'
            . '<xf numFmtId="166" fontId="0" fillId="0" borderId="1" xfId="0" applyNumberFormat="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="top"/></xf>'
            . '<xf numFmtId="166" fontId="0" fillId="5" borderId="1" xfId="0" applyNumberFormat="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="top"/></xf>'
            . '<xf numFmtId="0" fontId="7" fillId="6" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="7" fillId="7" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="8" fillId="8" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="7" fillId="9" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="3" borderId="1" xfId="0" applyFill="1" applyBorder="1" applyAlignment="1"><alignment vertical="top" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="7" fillId="0" borderId="3" xfId="0" applyFont="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="6" fillId="0" borderId="0" xfId="0" applyFont="1" applyAlignment="1"><alignment vertical="center"/></xf>'
            . '</cellXfs>'
            . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            . '</styleSheet>';
    }

    private function equipmentXlsxWorksheetXml(array $columns, array $rows, array $meta, array $layout, ?array $logo = null): string
    {
        $sheetColumnCount = $layout['sheet_column_count'];
        $tableColumnCount = $layout['table_column_count'];
        $tableHeaderRow = $layout['table_header_row'];
        $lastSheetColumn = $this->excelColumnName($sheetColumnCount);
        $lastTableColumn = $this->excelColumnName($tableColumnCount);
        $lastRow = $layout['last_row'];
        $merges = [
            'C1:' . $lastSheetColumn . '1',
            'C2:' . $lastSheetColumn . '2',
            'C3:' . $lastSheetColumn . '3',
            'C4:' . $lastSheetColumn . '4',
            'A9:' . $lastSheetColumn . '9',
        ];
        $sheetRows = [];

        $this->addEquipmentXlsxHeaderRows($sheetRows, $meta, $sheetColumnCount);
        $this->addEquipmentXlsxSummaryRows($sheetRows, $meta);
        $this->addEquipmentXlsxTitleRow($sheetRows, 9, 'Equipment Records');
        $this->addEquipmentXlsxTableHeaderRow($sheetRows, $columns, $tableHeaderRow);

        $currentExcelRow = $tableHeaderRow + 1;
        $currentGroup = null;
        $dataIndex = 0;

        foreach ($rows as $row) {
            if (!empty($row['group']) && $currentGroup !== $row['group']) {
                $sheetRows[$currentExcelRow] = [
                    'height' => 20,
                    'cells' => [
                        1 => ['value' => 'Location: ' . $row['group'], 'type' => 'string', 'style' => 7],
                    ],
                ];
                $merges[] = 'A' . $currentExcelRow . ':' . $lastTableColumn . $currentExcelRow;
                $currentGroup = $row['group'];
                $currentExcelRow++;
            }

            $isZebra = $dataIndex % 2 === 1;
            $cells = [];

            foreach ($columns as $columnIndex => $column) {
                $cell = $row['cells'][$columnIndex] ?? ['value' => '', 'type' => 'string', 'format' => 'text'];
                $cells[$columnIndex + 1] = [
                    'value' => $cell['value'] ?? '',
                    'type' => $cell['type'] ?? 'string',
                    'style' => $this->equipmentXlsxDataStyle($column, $cell, $isZebra, $row['status_class'] ?? 'status-review'),
                ];
            }

            $sheetRows[$currentExcelRow] = [
                'height' => 24,
                'cells' => $cells,
            ];
            $currentExcelRow++;
            $dataIndex++;
        }

        if (empty($rows)) {
            $sheetRows[$currentExcelRow] = [
                'height' => 24,
                'cells' => [
                    1 => ['value' => 'No inventory data matched the current filters.', 'type' => 'string', 'style' => 24],
                ],
            ];
            $merges[] = 'A' . $currentExcelRow . ':' . $lastTableColumn . $currentExcelRow;
        }

        $sheetXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $sheetXml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">';
        $sheetXml .= '<sheetPr><pageSetUpPr fitToPage="1"/></sheetPr>';
        $sheetXml .= '<dimension ref="A1:' . $lastSheetColumn . $lastRow . '"/>';
        $sheetXml .= '<sheetViews><sheetView showGridLines="0" workbookViewId="0"><pane ySplit="' . $tableHeaderRow . '" topLeftCell="A' . ($tableHeaderRow + 1) . '" activePane="bottomLeft" state="frozen"/><selection pane="bottomLeft" activeCell="A' . ($tableHeaderRow + 1) . '" sqref="A' . ($tableHeaderRow + 1) . '"/></sheetView></sheetViews>';
        $sheetXml .= '<sheetFormatPr defaultRowHeight="18"/>';
        $sheetXml .= '<cols>' . $this->equipmentXlsxColumnXml($columns, $sheetColumnCount) . '</cols>';
        $sheetXml .= '<sheetData>';

        foreach ($sheetRows as $excelRow => $row) {
            $height = isset($row['height']) ? ' ht="' . $row['height'] . '" customHeight="1"' : '';
            $sheetXml .= '<row r="' . $excelRow . '" spans="1:' . $sheetColumnCount . '"' . $height . '>';

            foreach ($row['cells'] as $columnIndex => $cell) {
                $sheetXml .= $this->equipmentXlsxCellXml($this->excelColumnName($columnIndex) . $excelRow, $cell);
            }

            $sheetXml .= '</row>';
        }

        $sheetXml .= '</sheetData>';
        $sheetXml .= '<autoFilter ref="A' . $tableHeaderRow . ':' . $lastTableColumn . $lastRow . '"/>';
        $sheetXml .= '<mergeCells count="' . count($merges) . '">';
        foreach ($merges as $merge) {
            $sheetXml .= '<mergeCell ref="' . $merge . '"/>';
        }
        $sheetXml .= '</mergeCells>';
        $sheetXml .= '<printOptions horizontalCentered="1"/>';
        $sheetXml .= '<pageMargins left="0.25" right="0.25" top="0.65" bottom="0.55" header="0.25" footer="0.25"/>';
        $sheetXml .= '<pageSetup paperSize="9" orientation="landscape" fitToWidth="1" fitToHeight="0"/>';
        $sheetXml .= '<headerFooter>'
            . '<oddHeader>' . $this->xmlEscape('&L' . ($meta['document_code'] ?? 'LIMS-EQ-EXP') . '&C' . ($meta['title'] ?? 'Equipment Inventory') . '&RGenerated ' . ($meta['generated_at'] ?? now()->format('Y-m-d H:i:s'))) . '</oddHeader>'
            . '<oddFooter>' . $this->xmlEscape('&L' . ($meta['organization']['office'] ?? 'Regional Fisheries Laboratory XII') . '&CControlled export&RPage &P of &N') . '</oddFooter>'
            . '</headerFooter>';
        if ($logo) {
            $sheetXml .= '<drawing r:id="rId1"/>';
        }
        $sheetXml .= '</worksheet>';

        return $sheetXml;
    }

    private function addEquipmentXlsxHeaderRows(array &$sheetRows, array $meta, int $sheetColumnCount): void
    {
        $sheetRows[1] = [
            'height' => 24,
            'cells' => [
                3 => ['value' => $meta['title'] ?? 'Equipment Inventory', 'type' => 'string', 'style' => 1],
                $sheetColumnCount => ['value' => $meta['document_code'] ?? 'LIMS-EQ-EXP', 'type' => 'string', 'style' => 3],
            ],
        ];
        $sheetRows[2] = [
            'height' => 18,
            'cells' => [
                3 => ['value' => ($meta['organization']['republic'] ?? 'Republic of the Philippines') . ' | ' . ($meta['organization']['department'] ?? 'Department of Agriculture'), 'type' => 'string', 'style' => 2],
            ],
        ];
        $sheetRows[3] = [
            'height' => 18,
            'cells' => [
                3 => ['value' => ($meta['organization']['agency'] ?? 'Bureau of Fisheries and Aquatic Resources') . ' - ' . ($meta['organization']['office'] ?? 'Regional Fisheries Laboratory XII'), 'type' => 'string', 'style' => 2],
            ],
        ];
        $sheetRows[4] = [
            'height' => 18,
            'cells' => [
                3 => ['value' => 'Generated: ' . ($meta['generated_at'] ?? now()->format('Y-m-d H:i:s')) . ' | Search: ' . ($meta['search'] ?? 'None'), 'type' => 'string', 'style' => 2],
            ],
        ];
    }

    private function addEquipmentXlsxSummaryRows(array &$sheetRows, array $meta): void
    {
        $summary = array_values($meta['summary'] ?? []);
        $labelCells = [];
        $valueCells = [];

        foreach ($summary as $index => $item) {
            $column = $index + 1;
            $labelCells[$column] = ['value' => $item['label'] ?? '', 'type' => 'string', 'style' => 4];
            $valueCells[$column] = ['value' => $item['value'] ?? '', 'type' => 'string', 'style' => 5];
        }

        $sheetRows[6] = ['height' => 18, 'cells' => $labelCells];
        $sheetRows[7] = ['height' => 24, 'cells' => $valueCells];
    }

    private function addEquipmentXlsxTitleRow(array &$sheetRows, int $rowNumber, string $title): void
    {
        $sheetRows[$rowNumber] = [
            'height' => 22,
            'cells' => [
                1 => ['value' => $title, 'type' => 'string', 'style' => 26],
            ],
        ];
    }

    private function addEquipmentXlsxTableHeaderRow(array &$sheetRows, array $columns, int $rowNumber): void
    {
        $cells = [];

        foreach ($columns as $index => $column) {
            $cells[$index + 1] = [
                'value' => $column['label'],
                'type' => 'string',
                'style' => 6,
            ];
        }

        $sheetRows[$rowNumber] = [
            'height' => 24,
            'cells' => $cells,
        ];
    }

    private function equipmentXlsxColumnXml(array $columns, int $sheetColumnCount): string
    {
        $xml = '';

        for ($index = 1; $index <= $sheetColumnCount; $index++) {
            $column = $columns[$index - 1] ?? null;
            $width = $column ? $this->equipmentXlsxColumnWidth($column) : 12;
            $xml .= '<col min="' . $index . '" max="' . $index . '" width="' . $width . '" customWidth="1"/>';
        }

        return $xml;
    }

    private function equipmentXlsxColumnWidth(array $column): float|int
    {
        return match ($column['key']) {
            'equipment' => 22,
            'equipment_no', 'rfl_control_no' => 16,
            'qty', 'unit' => 10,
            'description', 'updates' => 34,
            'brand_model', 'status_remarks', 'location', 'person_in_charge' => 20,
            'date_acquired' => 14,
            'unit_cost', 'total_cost' => 15,
            'received_quantity', 'used_quantity', 'balance_quantity' => 14,
            default => 16,
        };
    }

    private function equipmentXlsxDataStyle(array $column, array $cell, bool $isZebra, string $statusClass): int
    {
        if (($column['key'] ?? '') === 'status_remarks') {
            return match ($statusClass) {
                'status-available' => 20,
                'status-in-use' => 21,
                'status-maintenance' => 22,
                default => 23,
            };
        }

        if (($cell['format'] ?? null) === 'integer') {
            return $isZebra ? 15 : 14;
        }

        if (($cell['format'] ?? null) === 'currency') {
            return $isZebra ? 17 : 16;
        }

        if (($cell['format'] ?? null) === 'date') {
            return $isZebra ? 19 : 18;
        }

        return match ($column['align'] ?? 'left') {
            'center' => $isZebra ? 12 : 9,
            'right' => $isZebra ? 13 : 10,
            default => $isZebra ? 11 : 8,
        };
    }

    private function equipmentXlsxCellXml(string $cellRef, array $cell): string
    {
        $style = (int) ($cell['style'] ?? 0);
        $value = $cell['value'] ?? '';

        if (($cell['type'] ?? 'string') === 'number' && is_numeric($value)) {
            return '<c r="' . $cellRef . '" s="' . $style . '"><v>' . $this->xmlEscape((string) $value) . '</v></c>';
        }

        return '<c r="' . $cellRef . '" t="inlineStr" s="' . $style . '"><is><t xml:space="preserve">' . $this->xmlEscape((string) $value) . '</t></is></c>';
    }

    private function equipmentXlsxWorksheetRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/drawing" Target="../drawings/drawing1.xml"/>'
            . '</Relationships>';
    }

    private function equipmentXlsxDrawingXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<xdr:wsDr xmlns:xdr="http://schemas.openxmlformats.org/drawingml/2006/spreadsheetDrawing" xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<xdr:twoCellAnchor editAs="oneCell">'
            . '<xdr:from><xdr:col>0</xdr:col><xdr:colOff>80000</xdr:colOff><xdr:row>0</xdr:row><xdr:rowOff>80000</xdr:rowOff></xdr:from>'
            . '<xdr:to><xdr:col>2</xdr:col><xdr:colOff>0</xdr:colOff><xdr:row>4</xdr:row><xdr:rowOff>0</xdr:rowOff></xdr:to>'
            . '<xdr:pic>'
            . '<xdr:nvPicPr><xdr:cNvPr id="1" name="BFAR Logo"/><xdr:cNvPicPr><a:picLocks noChangeAspect="1"/></xdr:cNvPicPr></xdr:nvPicPr>'
            . '<xdr:blipFill><a:blip r:embed="rId1"/><a:stretch><a:fillRect/></a:stretch></xdr:blipFill>'
            . '<xdr:spPr><a:prstGeom prst="rect"><a:avLst/></a:prstGeom></xdr:spPr>'
            . '</xdr:pic>'
            . '<xdr:clientData/>'
            . '</xdr:twoCellAnchor>'
            . '</xdr:wsDr>';
    }

    private function equipmentXlsxDrawingRelsXml(array $logo): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="../media/' . $this->xmlEscape($logo['filename']) . '"/>'
            . '</Relationships>';
    }

    private function xlsxSheetName(string $name): string
    {
        return "'" . str_replace("'", "''", $name) . "'";
    }

    private function excelColumnName(int $index): string
    {
        $name = '';

        while ($index > 0) {
            $index--;
            $name = chr(65 + ($index % 26)) . $name;
            $index = intdiv($index, 26);
        }

        return $name;
    }

    private function xmlEscape(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_COMPAT, 'UTF-8');
    }
}
