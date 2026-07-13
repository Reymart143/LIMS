<?php

namespace Tests\Feature;

use App\Http\Controllers\EquipmentController;
use App\Models\Equipment;
use Barryvdh\DomPDF\Facade\Pdf;
use ReflectionMethod;
use Tests\TestCase;
use ZipArchive;

class EquipmentExportTest extends TestCase
{
    public function test_export_rows_and_pdf_view_handle_array_json_and_all_selectable_columns(): void
    {
        [$controller, $users, $equipment, $columns] = $this->equipmentExportFixture();

        $exportRowsMethod = new ReflectionMethod(EquipmentController::class, 'equipmentExportRows');
        $exportRowsMethod->setAccessible(true);
        $rows = $exportRowsMethod->invoke($controller, $columns, collect([$equipment]), $users);

        $pdfColumnsMethod = new ReflectionMethod(EquipmentController::class, 'equipmentPdfColumns');
        $pdfColumnsMethod->setAccessible(true);
        $pdfColumns = $pdfColumnsMethod->invoke($controller, $columns);

        $pdfRowsMethod = new ReflectionMethod(EquipmentController::class, 'equipmentPdfRows');
        $pdfRowsMethod->setAccessible(true);
        $pdfRows = $pdfRowsMethod->invoke($controller, $pdfColumns, collect([$equipment]), $users);

        $pdfMetaMethod = new ReflectionMethod(EquipmentController::class, 'equipmentPdfMeta');
        $pdfMetaMethod->setAccessible(true);
        $pdfMeta = $pdfMetaMethod->invoke($controller, collect([$equipment]), $columns, ['search' => '']);

        $html = view('Equipments.export', [
            'columns' => $pdfColumns,
            'equipments' => collect([$equipment]),
            'rows' => $rows,
            'pdfRows' => $pdfRows,
            'pdfMeta' => $pdfMeta,
            'pdfAssets' => ['logo' => null, 'watermark' => null, 'signature' => null],
            'users' => $users,
            'filters' => [],
        ])->render();

        $this->assertStringContainsString('Active, In Use', $html);
        $this->assertStringContainsString('AMS, BLC, fallback: Laptop, Monitor', $html);
        $this->assertStringContainsString('Calibrated, Ready for use', $html);

        $pdf = Pdf::loadView('Equipments.export', [
            'columns' => $pdfColumns,
            'equipments' => collect([$equipment]),
            'rows' => $rows,
            'pdfRows' => $pdfRows,
            'pdfMeta' => $pdfMeta,
            'pdfAssets' => ['logo' => null, 'watermark' => null, 'signature' => null],
            'users' => $users,
            'filters' => [],
        ])->setPaper('a4', 'landscape')
            ->setWarnings(false)
            ->setOption([
                'dpi' => 150,
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
            ]);

        $decorationsMethod = new ReflectionMethod(EquipmentController::class, 'addEquipmentPdfPageDecorations');
        $decorationsMethod->setAccessible(true);
        $decorationsMethod->invoke($controller, $pdf, $pdfMeta);

        $this->assertStringStartsWith('%PDF', $pdf->output());
    }

    public function test_excel_export_uses_pdf_branding_and_native_excel_layout_features(): void
    {
        [$controller, $users, $equipment, $columns] = $this->equipmentExportFixture();

        $method = new ReflectionMethod(EquipmentController::class, 'downloadEquipmentExcel');
        $method->setAccessible(true);

        $response = $method->invoke($controller, $columns, collect([$equipment]), $users, ['search' => '']);
        $path = $response->getFile()->getPathname();

        $zip = new ZipArchive();
        $this->assertTrue($zip->open($path) === true);

        $sheet = $zip->getFromName('xl/worksheets/sheet1.xml');
        $styles = $zip->getFromName('xl/styles.xml');
        $workbook = $zip->getFromName('xl/workbook.xml');
        $contentTypes = $zip->getFromName('[Content_Types].xml');

        $this->assertStringContainsString('<mergeCells', $sheet);
        $this->assertStringContainsString('<autoFilter ref="A11:', $sheet);
        $this->assertStringContainsString('orientation="landscape"', $sheet);
        $this->assertStringContainsString('fitToWidth="1"', $sheet);
        $this->assertStringContainsString('<pane ySplit="11"', $sheet);
        $this->assertStringContainsString('<headerFooter>', $sheet);
        $this->assertStringContainsString('Location: Microbiology', $sheet);
        $this->assertStringContainsString('AMS, BLC, fallback: Laptop, Monitor', $sheet);

        $this->assertStringContainsString('<numFmt numFmtId="165" formatCode="#,##0.00"/>', $styles);
        $this->assertStringContainsString('FF173A5E', $styles);
        $this->assertStringContainsString('FFF8FAFC', $styles);

        $this->assertStringContainsString('_xlnm.Print_Titles', $workbook);
        $this->assertStringContainsString('_xlnm.Print_Area', $workbook);

        if (is_file(public_path('assets/images/bfarlogo.png'))) {
            $this->assertStringContainsString('/xl/drawings/drawing1.xml', $contentTypes);
            $this->assertNotFalse($zip->locateName('xl/drawings/drawing1.xml'));
            $this->assertNotFalse($zip->locateName('xl/worksheets/_rels/sheet1.xml.rels'));
            $this->assertNotFalse($zip->locateName('xl/media/equipment-logo.png'));
        }

        $zip->close();
        @unlink($path);
    }

    private function equipmentExportFixture(): array
    {
        $users = collect([
            (object) [
                'id' => 1,
                'f_name' => 'Alice',
                'm_name' => 'Marie',
                'l_name' => 'Santos',
            ],
            (object) [
                'id' => 2,
                'f_name' => 'Brian',
                'm_name' => 'Lee',
                'l_name' => 'Cruz',
            ],
        ])->keyBy('id');

        $equipment = new Equipment([
            'equipment' => 'Microscope',
            'equipment_no' => 'EQ-ARRAY-001',
            'qty' => 1,
            'unit' => 'set',
            'rfl_control_no' => 'RFL-001',
            'description' => 'Compound microscope',
            'brand_model' => 'Acme X1',
            'date_acquired' => '2026-07-03',
            'unit_cost' => 1250,
            'total_cost' => 1250,
            'status_remarks' => json_encode(['Active', 'In Use']),
            'received_quantity' => 1,
            'used_quantity' => 0,
            'balance_quantity' => 1,
            'location' => 'Microbiology',
            'person_in_charge' => [
                1,
                ['id' => 2],
                ['fallback' => ['Laptop', 'Monitor']],
            ],
            'updates' => json_encode(['Calibrated', 'Ready for use']),
        ]);

        $columns = [
            ['key' => 'equipment', 'label' => 'Equipment'],
            ['key' => 'equipment_no', 'label' => 'Equipment No.'],
            ['key' => 'qty', 'label' => 'QTY'],
            ['key' => 'unit', 'label' => 'Unit'],
            ['key' => 'rfl_control_no', 'label' => 'RFL Control No.'],
            ['key' => 'description', 'label' => 'Description'],
            ['key' => 'brand_model', 'label' => 'Brand'],
            ['key' => 'date_acquired', 'label' => 'Date Acquired'],
            ['key' => 'unit_cost', 'label' => 'Unit Cost'],
            ['key' => 'total_cost', 'label' => 'Total Cost'],
            ['key' => 'status_remarks', 'label' => 'Status/Remarks'],
            ['key' => 'received_quantity', 'label' => 'Received Quantity'],
            ['key' => 'used_quantity', 'label' => 'Used Quantity'],
            ['key' => 'balance_quantity', 'label' => 'Balance Quantity'],
            ['key' => 'location', 'label' => 'Location'],
            ['key' => 'person_in_charge', 'label' => 'Person In-Charge'],
            ['key' => 'updates', 'label' => 'Updates'],
        ];

        return [new EquipmentController(), $users, $equipment, $columns];
    }
}
