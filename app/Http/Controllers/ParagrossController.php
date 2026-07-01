<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ParagrossController extends Controller
{
    public function storeParagrossWorksheet(Request $request, $id)
    {
        $rla = DB::table('lf_06_02')
            ->where('id', $id)
            ->first();

        if (!$rla) {
            return back()->with('error', 'RLA not found.');
        }

        $labCodes = json_decode($rla->laboratory_code ?? '[]', true) ?? [];
        $firstLabCode = is_array($labCodes) ? ($labCodes[0] ?? null) : null;

        $existingWorksheet = DB::table('paragross_worksheets')
            ->where('lf_06_02_id', $id)
            ->first();

        $data = [
            'lf_06_02_id' => $id,
            'user_id' => $request->user_id ?? $rla->user_id,

            'rla_no' => $request->rla_no ?? $rla->RLA_no,
            'lab_code' => $request->lab_code ?? $firstLabCode,

            'sample_type' => $request->sample_type,
            'date_started' => $request->date_started,
            'date_finished' => $request->date_finished,

            'test_method' => $request->test_method,
            'objective_used' => json_encode($request->objective_used ?? []),

            'length_cm' => $request->length_cm,
            'result' => $request->result,
            'remarks' => $request->remarks,

            'analyzed_by' => $request->analyzed_by,
            'checked_by' => $request->checked_by,

            'updated_at' => now(),
        ];

        if ($existingWorksheet) {
            DB::table('paragross_worksheets')
                ->where('lf_06_02_id', $id)
                ->update($data);
        } else {
            $data['created_at'] = now();

            DB::table('paragross_worksheets')
                ->insert($data);
        }

        return redirect()
            ->back()
            ->with('success', 'Parasitological / Gross worksheet saved successfully.');
    }
}
