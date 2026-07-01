<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class WaterPotabilityController extends Controller
{
    public function storeWaterPotabilityWorksheet(Request $request, $id)
{
    $rla = DB::table('lf_06_02')
        ->where('id', $id)
        ->first();

    if (!$rla) {
        return back()->with('error', 'RLA not found.');
    }

    $existingWorksheet = DB::table('water_potability_worksheets')
        ->where('lf_06_02_id', $id)
        ->first();

    $labCodes = json_decode($rla->laboratory_code ?? '[]', true) ?? [];
    $firstLabCode = is_array($labCodes) ? ($labCodes[0] ?? '') : '';

    $data = [
        'lf_06_02_id' => $id,
        'user_id' => $request->user_id ?? $rla->user_id,

        'rla_no' => $request->rla_no ?? $rla->RLA_no,
        'lab_code' => $request->lab_code ?? $firstLabCode,
        'date_time_started' => $request->date_time_started,
        'date_time_finished' => $request->date_time_finished,

        'hpc_dilution' => json_encode($request->hpc_dilution ?? []),
        'hpc_r1' => json_encode($request->hpc_r1 ?? []),
        'hpc_r2' => json_encode($request->hpc_r2 ?? []),

        'ds_lst_broth' => json_encode($request->ds_lst_broth ?? []),
        'bglb_broth' => json_encode($request->bglb_broth ?? []),
        'ec_broth' => json_encode($request->ec_broth ?? []),
        'emb_plate' => json_encode($request->emb_plate ?? []),
        'ds_azide_dextrose_broth' => json_encode($request->ds_azide_dextrose_broth ?? []),
        'eva_broth' => json_encode($request->eva_broth ?? []),

        'hpc_result' => $request->hpc_result,
        'tube_mpn' => $request->tube_mpn,
        'note' => $request->note,
        'total_coliform_count' => $request->total_coliform_count,
        'fecal_coliform_count' => $request->fecal_coliform_count,
        'e_coli_count' => $request->e_coli_count,
        'enterococci_count' => $request->enterococci_count,

        'qc_negative' => json_encode($request->qc_negative ?? []),
        'qc_positive' => json_encode($request->qc_positive ?? []),
        'qc_remarks' => json_encode($request->qc_remarks ?? []),

        'culture_media_batch_no' => $request->culture_media_batch_no,
        'air_control' => $request->air_control,
        'isolation_room' => $request->isolation_room,
        'biosafety_cabinet' => $request->biosafety_cabinet,
        'medium_control' => $request->medium_control,
        'diluent_control' => $request->diluent_control,

        'confirm_lab_code' => json_encode($request->confirm_lab_code ?? []),
        'gram_reaction' => json_encode($request->gram_reaction ?? []),
        'indole_production' => json_encode($request->indole_production ?? []),
        'voges_proskauer' => json_encode($request->voges_proskauer ?? []),
        'methyl_red' => json_encode($request->methyl_red ?? []),
        'citrate_utilization' => json_encode($request->citrate_utilization ?? []),
        'gas_production' => json_encode($request->gas_production ?? []),
        'confirm_result' => json_encode($request->confirm_result ?? []),

        'calculations' => $request->calculations,

        'analyzed_by' => $request->analyzed_by,
        'checked_by' => $request->checked_by,

        'updated_at' => now(),
    ];

    if ($existingWorksheet) {
        DB::table('water_potability_worksheets')
            ->where('lf_06_02_id', $id)
            ->update($data);
    } else {
        $data['created_at'] = now();

        DB::table('water_potability_worksheets')
            ->insert($data);
    }

    return redirect()
        ->back()
        ->with('success', 'Water Potability worksheet saved successfully.');
}
}
