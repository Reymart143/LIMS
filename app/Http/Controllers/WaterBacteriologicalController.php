<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class WaterBacteriologicalController extends Controller
{
    public function storeWaterBacteriologyWorksheet(Request $request, $id)
    {
        $rla = DB::table('lf_06_02')
            ->where('id', $id)
            ->first();

        if (!$rla) {
            return back()->with('error', 'RLA not found.');
        }

        $existingWorksheet = DB::table('water_bacteriology_worksheets')
            ->where('lf_06_02_id', $id)
            ->first();

        $labCodes = json_decode($rla->laboratory_code ?? '[]', true) ?? [];
        $firstLabCode = is_array($labCodes) ? ($labCodes[0] ?? '') : '';

        $sampleDescriptions = json_decode($rla->sample_description ?? '[]', true) ?? [];
        $firstSampleDescription = is_array($sampleDescriptions) ? ($sampleDescriptions[0] ?? '') : '';

        $data = [
            'lf_06_02_id' => $id,
            'user_id' => $request->user_id ?? $rla->user_id,

            'rla_no' => $request->rla_no ?? $rla->RLA_no,
            'lab_code' => $request->lab_code ?? $firstLabCode,
            'sample_type' => $request->sample_type ?? $firstSampleDescription,
            'date_started' => $request->date_started,
            'date_finished' => $request->date_finished,

            'test_name' => json_encode($request->test_name ?? []),

            'dilution_100_r1' => json_encode($request->dilution_100_r1 ?? []),
            'dilution_100_r2' => json_encode($request->dilution_100_r2 ?? []),

            'dilution_101_r1' => json_encode($request->dilution_101_r1 ?? []),
            'dilution_101_r2' => json_encode($request->dilution_101_r2 ?? []),

            'dilution_102_r1' => json_encode($request->dilution_102_r1 ?? []),
            'dilution_102_r2' => json_encode($request->dilution_102_r2 ?? []),

            'dilution_103_r1' => json_encode($request->dilution_103_r1 ?? []),
            'dilution_103_r2' => json_encode($request->dilution_103_r2 ?? []),

            'results' => json_encode($request->results ?? []),

            'batch_no_prepared_culture_media' => $request->batch_no_prepared_culture_media,
            'air_control' => $request->air_control,
            'medium_control_tcbs' => $request->medium_control_tcbs,
            'diluent_sterile_sea_water' => $request->diluent_sterile_sea_water,

            'calculations' => $request->calculations,

            'analyzed_by' => $request->analyzed_by,
            'checked_by' => $request->checked_by,

            'updated_at' => now(),
        ];

        if ($existingWorksheet) {
            DB::table('water_bacteriology_worksheets')
                ->where('lf_06_02_id', $id)
                ->update($data);
        } else {
            $data['created_at'] = now();

            DB::table('water_bacteriology_worksheets')
                ->insert($data);
        }

        return redirect()
            ->back()
            ->with('success', 'Water Bacteriology worksheet saved successfully.');
    }
}
