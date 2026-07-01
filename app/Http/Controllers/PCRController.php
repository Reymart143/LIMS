<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;

class PCRController extends Controller
{
    public function storePcrWorksheet(Request $request, $id)
{
    $rla = DB::table('lf_06_02')
        ->where('id', $id)
        ->first();

    if (!$rla) {
        return back()->with('error', 'RLA not found.');
    }

    $existingWorksheet = DB::table('pcr_worksheets')
        ->where('lf_06_02_id', $id)
        ->first();

    $labCodes = json_decode($rla->laboratory_code ?? '[]', true) ?? [];
    $sampleDescriptions = json_decode($rla->sample_description ?? '[]', true) ?? [];

    $picturePath = $existingWorksheet->picture ?? null;

    if ($request->hasFile('picture')) {
        if ($picturePath && Storage::disk('public')->exists($picturePath)) {
            Storage::disk('public')->delete($picturePath);
        }

        $picturePath = $request->file('picture')->store('pcr_worksheets', 'public');
    }

    $data = [
        'lf_06_02_id' => $id,
        'user_id' => $request->user_id ?? $rla->user_id,
        'rla_no' => $request->rla_no ?? $rla->RLA_no,

        'test_method' => json_encode($request->test_method ?? []),
        'sample_type' => json_encode($request->sample_type ?? []),

        'total_no_of_sample' => $request->total_no_of_sample,
        'analysis' => $request->analysis,
        'date_time_started' => $request->date_time_started,
        'date_time_finished' => $request->date_time_finished,
        'kit_lot_no' => $request->kit_lot_no,

        'fish_pcr_premix' => $request->fish_pcr_premix,
        'fish_pcr_premix_result' => $request->fish_pcr_premix_result,
        'dnazyme_polymerase' => $request->dnazyme_polymerase,
        'dnazyme_polymerase_result' => $request->dnazyme_polymerase_result,

        'nested_pcr_premix' => $request->nested_pcr_premix,
        'nested_pcr_premix_result' => $request->nested_pcr_premix_result,
        'dnazyme_dna_polymerase' => $request->dnazyme_dna_polymerase,
        'dnazyme_dna_polymerase_result' => $request->dnazyme_dna_polymerase_result,

        'ems_ahpnd_premix' => $request->ems_ahpnd_premix,
        'ems_ahpnd_premix_result' => $request->ems_ahpnd_premix_result,
        'dnazyme_dna_polymerase_2' => $request->dnazyme_dna_polymerase_2,
        'dnazyme_dna_polymerase_2_result' => $request->dnazyme_dna_polymerase_2_result,

        'diagnosis_rla' => json_encode($request->diagnosis_rla ?? []),
        'diagnosis_lane_no' => json_encode($request->diagnosis_lane_no ?? []),
        'diagnosis_laboratory_code' => json_encode($request->diagnosis_laboratory_code ?? []),
        'diagnosis_50nm' => json_encode($request->diagnosis_50nm ?? []),
        'diagnosis_55nm' => json_encode($request->diagnosis_55nm ?? []),
        'diagnosis_result' => json_encode($request->diagnosis_result ?? []),

        'picture' => $picturePath,

        'analyzed_by' => $request->analyzed_by,
        'checked_by' => $request->checked_by,

        'updated_at' => now(),
    ];

    if ($existingWorksheet) {
        DB::table('pcr_worksheets')
            ->where('lf_06_02_id', $id)
            ->update($data);
    } else {
        $data['created_at'] = now();

        DB::table('pcr_worksheets')
            ->insert($data);
    }

    return redirect()
        ->back()
        ->with('success', 'PCR worksheet saved successfully.');
}
}
