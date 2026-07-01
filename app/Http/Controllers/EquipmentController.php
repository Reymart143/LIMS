<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('Equipments.export', [
                'columns' => $columns,
                'equipments' => $equipments,
                'users' => $users,
                'filters' => $filters,
            ])->setPaper('a4', 'landscape');

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

            return redirect()->route('equipments.index')->with('success', 'Equipment added successfully!');
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

            return redirect()->route('equipments.index')->with('success', 'Equipment updated successfully!');
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

        return redirect()->route('equipments.index')->with('success', 'Equipment deleted successfully!');
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

    private function equipmentExportValue($equipment, string $key, $users): string
    {
        switch ($key) {
            case 'equipment':
            case 'equipment_no':
            case 'unit':
            case 'rfl_control_no':
            case 'description':
            case 'brand_model':
            case 'status_remarks':
            case 'location':
                return (string) ($equipment->{$key} ?? 'N/A');
            case 'qty':
            case 'received_quantity':
            case 'used_quantity':
            case 'balance_quantity':
                return (string) ($equipment->{$key} ?? 0);
            case 'unit_cost':
            case 'total_cost':
                return number_format((float) ($equipment->{$key} ?? 0), 2, '.', '');
            case 'date_acquired':
                return $equipment->date_acquired ? \Carbon\Carbon::parse($equipment->date_acquired)->format('Y-m-d') : 'N/A';
            case 'person_in_charge':
                $personInCharge = $equipment->person_in_charge;
                if (is_string($personInCharge)) {
                    $personInCharge = json_decode($personInCharge, true);
                }
                $personInCharge = is_array($personInCharge) ? $personInCharge : [];

                if (empty($personInCharge)) {
                    return 'N/A';
                }

                return collect($personInCharge)->map(function ($userId) use ($users) {
                    $user = $users->get($userId);

                    if (!$user) {
                        return (string) $userId;
                    }

                    return strtoupper(
                        ($user->f_name ? substr($user->f_name, 0, 1) : '') .
                        ($user->m_name ? substr($user->m_name, 0, 1) : '') .
                        ($user->l_name ? substr($user->l_name, 0, 1) : '')
                    );
                })->implode(', ');
            case 'updates':
                return trim(strip_tags((string) ($equipment->updates ?? 'N/A')));
            default:
                return (string) ($equipment->{$key} ?? 'N/A');
        }
    }

    private function downloadEquipmentExcel(array $columns, $equipments, $users, array $filters)
    {
        $headers = array_map(function ($column) {
            return $column['label'];
        }, $columns);

        $rows = $equipments->map(function ($equipment) use ($columns, $users) {
            return array_map(function ($column) use ($equipment, $users) {
                return $this->equipmentExportValue($equipment, $column['key'], $users);
            }, $columns);
        })->all();

        $tempFile = tempnam(sys_get_temp_dir(), 'equipment-xlsx-');
        $zip = new \ZipArchive();

        if ($zip->open($tempFile, \ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Unable to create Excel export.');
        }

        $zip->addFromString('[Content_Types].xml', $this->equipmentXlsxContentTypesXml());
        $zip->addFromString('_rels/.rels', $this->equipmentXlsxRootRelsXml());
        $zip->addFromString('docProps/app.xml', $this->equipmentXlsxAppXml());
        $zip->addFromString('docProps/core.xml', $this->equipmentXlsxCoreXml());
        $zip->addFromString('xl/workbook.xml', $this->equipmentXlsxWorkbookXml());
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->equipmentXlsxWorkbookRelsXml());
        $zip->addFromString('xl/styles.xml', $this->equipmentXlsxStylesXml());
        $zip->addFromString('xl/worksheets/sheet1.xml', $this->equipmentXlsxWorksheetXml($headers, $rows));
        $zip->close();

        $fileName = 'equipment-inventory-' . now()->format('Ymd-His') . '.xlsx';

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    private function equipmentXlsxContentTypesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '<Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>'
            . '<Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/>'
            . '</Types>';
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

    private function equipmentXlsxWorkbookXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '
            . 'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="Equipment Inventory" sheetId="1" r:id="rId1"/></sheets>'
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
            . '<fonts count="2">'
            . '<font><sz val="11"/><color rgb="FF000000"/><name val="Calibri"/></font>'
            . '<font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>'
            . '</fonts>'
            . '<fills count="2">'
            . '<fill><patternFill patternType="none"/></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FF1E3A5F"/><bgColor indexed="64"/></patternFill></fill>'
            . '</fills>'
            . '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="2">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0" applyAlignment="1"><alignment vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="1" fillId="1" borderId="0" xfId="0" applyFill="1" applyFont="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>'
            . '</cellXfs>'
            . '</styleSheet>';
    }

    private function equipmentXlsxWorksheetXml(array $headers, array $rows): string
    {
        $allRows = array_merge([$headers], $rows);
        $columnWidths = [];

        foreach ($allRows as $row) {
            foreach ($row as $index => $value) {
                $length = function_exists('mb_strlen') ? mb_strlen((string) $value) : strlen((string) $value);
                $columnWidths[$index] = max($columnWidths[$index] ?? 0, $length);
            }
        }

        $widthXml = '';
        foreach ($columnWidths as $index => $length) {
            $width = min(max($length + 2, 12), 40);
            $columnNumber = $index + 1;
            $widthXml .= '<col min="' . $columnNumber . '" max="' . $columnNumber . '" width="' . $width . '" customWidth="1"/>';
        }

        $sheetXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $sheetXml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">';
        $sheetXml .= '<sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews>';
        $sheetXml .= '<sheetFormatPr defaultRowHeight="18"/>';
        $sheetXml .= '<cols>' . $widthXml . '</cols>';
        $sheetXml .= '<sheetData>';

        foreach ($allRows as $rowIndex => $row) {
            $excelRow = $rowIndex + 1;
            $sheetXml .= '<row r="' . $excelRow . '" spans="1:' . count($row) . '">';

            foreach ($row as $columnIndex => $value) {
                $cellRef = $this->excelColumnName($columnIndex + 1) . $excelRow;
                if ($rowIndex === 0) {
                    $sheetXml .= '<c r="' . $cellRef . '" t="inlineStr" s="1"><is><t xml:space="preserve">' . $this->xmlEscape((string) $value) . '</t></is></c>';
                    continue;
                }

                if (is_numeric($value)) {
                    $sheetXml .= '<c r="' . $cellRef . '"><v>' . $this->xmlEscape((string) $value) . '</v></c>';
                } else {
                    $sheetXml .= '<c r="' . $cellRef . '" t="inlineStr"><is><t xml:space="preserve">' . $this->xmlEscape((string) $value) . '</t></is></c>';
                }
            }

            $sheetXml .= '</row>';
        }

        $sheetXml .= '</sheetData>';
        $sheetXml .= '<autoFilter ref="A1:' . $this->excelColumnName(count($headers)) . '1"/>';
        $sheetXml .= '</worksheet>';

        return $sheetXml;
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