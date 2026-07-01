<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HistamineController extends Controller
{
public function storeHistamineWorksheet(Request $request, $id)
{
    $rla = DB::table('lf_06_02')
        ->where('id', $id)
        ->first();

    if (!$rla) {
        return back()->with('error', 'RLA not found.');
    }

    $existingWorksheet = DB::table('histamine_worksheets')
        ->where('lf_06_02_id', $id)
        ->first();

    $data = [
        'lf_06_02_id' => $id,
        'user_id' => $request->user_id ?? $rla->user_id,
        'rla_no' => $request->rla_no ?? $rla->RLA_no,

        'date_time_started' => $request->date_time_started,
        'date_time_finished' => $request->date_time_finished,

        'reagent_no' => $request->reagent_no,
        'mass_of_standard' => $request->mass_of_standard,

        'calibration_target_concentration' => json_encode($request->calibration_target_concentration ?? []),
        'calibration_actual_concentration' => json_encode($request->calibration_actual_concentration ?? []),
        'calibration_rfu' => json_encode($request->calibration_rfu ?? []),

        'equation_of_line' => $request->equation_of_line,
        'r_value' => $request->r_value,

        'qc_label' => json_encode($request->qc_label ?? []),
        'qc_mass_sample' => json_encode($request->qc_mass_sample ?? []),
        'qc_rfu' => json_encode($request->qc_rfu ?? []),
        'qc_histamine_from_curve' => json_encode($request->qc_histamine_from_curve ?? []),
        'qc_corrected_histamine' => json_encode($request->qc_corrected_histamine ?? []),
        'qc_histamine_on_sample' => json_encode($request->qc_histamine_on_sample ?? []),
        'qc_average_histamine_conc' => json_encode($request->qc_average_histamine_conc ?? []),
        'qc_remarks' => json_encode($request->qc_remarks ?? []),

        'sample_laboratory_code' => json_encode($request->sample_laboratory_code ?? []),
        'sample_mass_sample' => json_encode($request->sample_mass_sample ?? []),
        'sample_rfu' => json_encode($request->sample_rfu ?? []),
        'sample_histamine_from_curve' => json_encode($request->sample_histamine_from_curve ?? []),
        'sample_corrected_histamine' => json_encode($request->sample_corrected_histamine ?? []),
        'sample_histamine_on_sample' => json_encode($request->sample_histamine_on_sample ?? []),
        'sample_average_histamine_conc' => json_encode($request->sample_average_histamine_conc ?? []),
        'sample_remarks' => json_encode($request->sample_remarks ?? []),

        'notes' => $request->notes,
        'calculated_by' => $request->calculated_by,

        'analyst' => $request->analyst,
        'checked_by' => $request->checked_by,

        'updated_at' => now(),
    ];

    if ($existingWorksheet) {
        DB::table('histamine_worksheets')
            ->where('lf_06_02_id', $id)
            ->update($data);
    } else {
        $data['created_at'] = now();

        DB::table('histamine_worksheets')
            ->insert($data);
    }

    return redirect()
        ->route('analysis_worksheet.create', $id)
        ->with('success', 'Histamine worksheet saved successfully.');
}
}
