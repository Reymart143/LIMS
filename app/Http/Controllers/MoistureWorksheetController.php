<?php

namespace App\Http\Controllers;

use App\Models\MoistureWorksheet;
use Illuminate\Http\Request;
use DB;

class MoistureWorksheetController extends Controller
{
   public function MoistureWorksheet(Request $request, $id)
    {
        $rla = DB::table('lf_06_02')
            ->where('id', $id)
            ->first();

        if (!$rla) {
            return back()->with('error', 'RLA not found.');
        }

        $existingWorksheet = DB::table('moisture_worksheets')
            ->where('lf_06_02_id', $id)
            ->first();

        $data = [
            'lf_06_02_id' => $id,
            'user_id' => $request->user_id ?? $rla->user_id,
            'rla_no' => $request->rla_no ?? $rla->RLA_no,

            'date_time_started' => $request->date_time_started,
            'date_time_finished' => $request->date_time_finished,

            'method' => $request->method,
            'reference' => $request->reference,
            'oven_temperature' => $request->oven_temperature,
            'is_actual_temperature' => $request->has('is_actual_temperature') ? 1 : 0,
            'drying_time' => $request->drying_time,

            'laboratory_code' => json_encode($request->laboratory_code ?? []),
            'trial' => json_encode($request->trial ?? []),
            'wt_pan' => json_encode($request->wt_pan ?? []),
            'wt_sample_before_drying' => json_encode($request->wt_sample_before_drying ?? []),
            'wt_pan_sample_after_drying' => json_encode($request->wt_pan_sample_after_drying ?? []),
            'wt_sample_after_drying' => json_encode($request->wt_sample_after_drying ?? []),
            'wt_lost_on_drying' => json_encode($request->wt_lost_on_drying ?? []),
            'moisture_content' => json_encode($request->moisture_content ?? []),

            'average' => json_encode($request->average ?? []),
            'remarks' => json_encode($request->remarks ?? []),

            'analyzed_by_1' => $request->analyzed_by_1,
            'analyzed_by_2' => $request->analyzed_by_2,
            'checked_by' => $request->checked_by,

            'updated_at' => now(),
        ];

        if ($existingWorksheet) {
            DB::table('moisture_worksheets')
                ->where('lf_06_02_id', $id)
                ->update($data);
        } else {
            $data['created_at'] = now();

            DB::table('moisture_worksheets')
                ->insert($data);
        }

        return redirect()
            ->back()
            ->with('success', 'Moisture worksheet saved successfully.');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MoistureWorksheet $moistureWorksheet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MoistureWorksheet $moistureWorksheet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MoistureWorksheet $moistureWorksheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MoistureWorksheet $moistureWorksheet)
    {
        //
    }
}
