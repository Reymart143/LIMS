<?php

namespace App\Http\Controllers;

use App\Models\WaterQualityWorksheet;
use Illuminate\Http\Request;
use DB;
class WaterQualityWorksheetController extends Controller
{
    public function WaterQualityWorksheet(Request $request, $id)
    {
        $rla = DB::table('lf_06_02')
            ->where('id', $id)
            ->first();

        if (!$rla) {
            return back()->with('error', 'RLA not found.');
        }

        /*
            Check if naa nay existing worksheet ani nga RLA.
            If naa = update.
            If wala = insert.
        */
        $existingWorksheet = DB::table('water_quality_worksheets')
            ->where('lf_06_02_id', $id)
            ->first();

        $data = [
            'lf_06_02_id' => $id,
            'user_id' => $request->user_id ?? $rla->user_id,
            'rla_no' => $request->rla_no ?? $rla->RLA_no,

            'date_time_started' => $request->date_time_started,
            'date_time_finished' => $request->date_time_finished,

            'sample_code' => json_encode($request->sample_code ?? []),
            'sampling_site' => json_encode($request->sampling_site ?? []),

            'analysis_requested' => json_encode($request->analysis_requested ?? []),
            'results' => json_encode($request->results ?? []),

            'analyzed_by_1' => $request->analyzed_by_1,
            'analyzed_by_2' => $request->analyzed_by_2,
            'checked_by' => $request->checked_by,

            'updated_at' => now(),
        ];

        if ($existingWorksheet) {
            DB::table('water_quality_worksheets')
                ->where('lf_06_02_id', $id)
                ->update($data);
        } else {
            $data['created_at'] = now();

            DB::table('water_quality_worksheets')
                ->insert($data);
        }

        return redirect()
            ->route('analysis_worksheet.create', $id)
            ->with('success', 'Analysis worksheet saved successfully.');
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
    public function show(WaterQualityWorksheet $waterQualityWorksheet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WaterQualityWorksheet $waterQualityWorksheet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WaterQualityWorksheet $waterQualityWorksheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WaterQualityWorksheet $waterQualityWorksheet)
    {
        //
    }
}
