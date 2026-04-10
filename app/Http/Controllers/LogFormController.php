<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LogFormController extends Controller
{
    public function index(){
        return view('LogForm.index');
    }
    public function lf_03_05(){

        $equipments = DB::table('lf_03_05')->paginate(10);

        return view('LogForm.lf_03_05',compact('equipments'));
    }
    public function store(Request $request){

        $equipment = DB::table('lf_03_05')->insert([
            'equipment' => $request->equipment,
            'model'  => $request->model,
            'equipment_no'  => $request->equipment_no,
            'location'  => $request->location,
            'month'  => $request->month,
            'year'  => $request->year,
        ]);

        return redirect()->back()->with('success', 'Equipment saved successfully!');
    }
    public function equipments($id)
    {
       $equipment = DB::table('lf_03_05')->where('id', $id)->first();

    $logs = DB::table('lf_03_05_logs')
        ->where('equipment_id', $id)
        ->orderBy('id', 'asc')
        ->get();
        return view('LogForm.equipments_logbook', compact('logs', 'id','equipment'));
    }
public function equipment_store(Request $request)
{
    $equipmentId = $request->equipment_id;
    $submittedIds = [];

    $totalRows = count($request->date ?? []);

    for ($i = 0; $i < $totalRows; $i++) {
        $logId                  = $request->log_id[$i] ?? null;
        $date                   = trim($request->date[$i] ?? '');
        $clean_equipment        = trim($request->clean_equipment[$i] ?? '');
        $check_powersupply      = trim($request->check_powersupply[$i] ?? '');
        $switchon_equipment     = trim($request->switchon_equipment[$i] ?? '');
        $shutdown_equipment     = trim($request->shutdown_equipment[$i] ?? '');
        $preventive_maintenance = trim($request->preventive_maintenance[$i] ?? '');
        $name_analyst           = trim($request->name_analyst[$i] ?? '');
        $analysis               = trim($request->analysis[$i] ?? '');
        $RLA_no                 = trim($request->RLA_no[$i] ?? '');
        $laboratory_code        = trim($request->laboratory_code[$i] ?? '');
        $remarks                = trim($request->remarks[$i] ?? '');

        $isEmpty =
            $date === '' &&
            $clean_equipment === '' &&
            $check_powersupply === '' &&
            $switchon_equipment === '' &&
            $shutdown_equipment === '' &&
            $preventive_maintenance === '' &&
            $name_analyst === '' &&
            $analysis === '' &&
            $RLA_no === '' &&
            $laboratory_code === '' &&
            $remarks === '';

        if ($isEmpty) {
            continue;
        }

        $data = [
            'equipment_id'           => $equipmentId,
            'date'                   => $date,
            'clean_equipment'        => $clean_equipment,
            'check_powersupply'      => $check_powersupply,
            'switchon_equipment'     => $switchon_equipment,
            'shutdown_equipment'     => $shutdown_equipment,
            'preventive_maintenance' => $preventive_maintenance,
            'name_analyst'           => $name_analyst,
            'analysis'               => $analysis,
            'RLA_no'                 => $RLA_no,
            'laboratory_code'        => $laboratory_code,
            'remarks'                => $remarks,
            'updated_at'             => now(),
        ];

        if (!empty($logId)) {
            DB::table('lf_03_05_logs')
                ->where('id', $logId)
                ->where('equipment_id', $equipmentId)
                ->update($data);

            $submittedIds[] = $logId;
        } else {
            $newId = DB::table('lf_03_05_logs')->insertGetId(array_merge($data, [
                'created_at' => now(),
            ]));

            $submittedIds[] = $newId;
        }
    }

    DB::table('lf_03_05_logs')
        ->where('equipment_id', $equipmentId)
        ->whereNotIn('id', $submittedIds)
        ->delete();

    return back()->with('success', 'Saved successfully!');
}

}
