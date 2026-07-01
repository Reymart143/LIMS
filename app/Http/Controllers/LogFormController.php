<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
 use Illuminate\Support\Facades\Auth;

class LogFormController extends Controller
{
     private function getAddressFromCoordinates($value)
        {
            $value = trim($value ?? '');

            if (!preg_match('/^-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?$/', $value)) {
                return $value;
            }

            [$lat, $lng] = array_map('trim', explode(',', $value));

            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'LIMS-RFL12/1.0',
                ])->timeout(10)->get('https://nominatim.openstreetmap.org/reverse', [
                    'format' => 'json',
                    'lat' => $lat,
                    'lon' => $lng,
                    'zoom' => 18,
                    'addressdetails' => 1,
                ]);

                if (!$response->successful()) {
                    return $value;
                }

                $data = $response->json();

                if (!empty($data['display_name'])) {
                    return $data['display_name'];
                }

                return $value;

            } catch (\Exception $e) {
                return $value;
            }
        }
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
    //RLA
  public function generateRlaNo()
    {
        $year = date('Y');

        $latest = DB::table('lf_06_02')
            ->whereYear('created_at', $year)
            ->whereNotNull('RLA_no')
            ->orderByDesc('id')
            ->value('RLA_no');
     
        if ($latest) {
            $lastNumber = (int) $latest;
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $newRlaNo = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        while (
            DB::table('lf_06_02')
                ->whereYear('created_at', $year)
                ->where('RLA_no', $newRlaNo)
                ->exists()
        ) {
            $nextNumber++;
            $newRlaNo = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        return response()->json([
            'success' => true,
            'RLA_no' => $newRlaNo
        ]);
    }

//  public function lf_06_02()
//     {
//         $clients = DB::table('clients')->get();

//         $rla = DB::table('lf_06_02')
//             ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
//             ->select(
//                 'lf_06_02.id',
//                 'lf_06_02.user_id',
//                 'lf_06_02.RLA_no',
//                 'lf_06_02.payment',
//                 'lf_06_02.date_collected',
//                 'lf_06_02.sample',
//                 'clients.address',
//                 'clients.contact_no',
//                 'lf_06_02.source_sample',
//                 'lf_06_02.sample_received_by',
//                 'lf_06_02.service_officer',
//                 'lf_06_02.date_received',
//                 'lf_06_02.date_payment',
//                 'lf_06_02.or_no',
//                 'lf_06_02.remarks',
//                 'lf_06_02.status',
//                 'clients.company_name'
//             )
//             ->orderBy('lf_06_02.id', 'desc')
//             ->get();

//         $rla = $rla->map(function ($item) {
//             $item->display_address = $this->getAddressFromCoordinates($item->address ?? '');
//             return $item;
//         });

//         return view('RLA.lf_06_02', compact('clients', 'rla'));
//     }
   public function lf_06_02()
    {
        $clients = DB::table('clients')->get();

        $rla = DB::table('lf_06_02')
            ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
            ->select(
                'lf_06_02.id',
                'lf_06_02.user_id',
                'lf_06_02.RLA_no',
                'lf_06_02.payment',
                'lf_06_02.date_collected',
                'lf_06_02.sample',
                'clients.address',
                'clients.contact_no',
                'lf_06_02.source_sample',
                'lf_06_02.sample_received_by',
                'lf_06_02.service_officer',
                'lf_06_02.date_received',
                'lf_06_02.date_payment',
                'lf_06_02.or_no',
                'lf_06_02.remarks',
                'lf_06_02.status',
                'clients.company_name'
            )->orderBy('lf_06_02.id', 'desc')
            ->paginate(10);
        $users = DB::table('users')->get();
        return view('RLA.lf_06_02', compact('clients', 'rla','users'));
    }
 public function getLatestLaboratoryCode()
{
    $year = date('y');
    $prefix = 'RFL12-' . $year . '-';

    $records = DB::table('lf_06_02')
        ->whereNotNull('laboratory_code')
        ->pluck('laboratory_code');

    $highestNumber = 0;
    $latestCode = null;

    foreach ($records as $record) {
        $codes = json_decode($record, true);

        if (!is_array($codes)) {
            continue;
        }

        foreach ($codes as $code) {
            if (!is_string($code)) {
                continue;
            }

            $code = trim($code);

            /*
                Exact match only:
                RFL12-26-001
                RFL12-26-013
                Dili niya i-apil ang lain format.
            */
            if (preg_match('/^' . preg_quote($prefix, '/') . '(\d{3})$/', $code, $match)) {
                $number = (int) $match[1];

                if ($number > $highestNumber) {
                    $highestNumber = $number;
                    $latestCode = $code;
                }
            }
        }
    }

    $nextNumber = $highestNumber + 1;

    return response()->json([
        'success' => true,
        'latest_code' => $latestCode,
        'highest_number' => $highestNumber,
        'next_code' => $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT),
        'next_number' => $nextNumber,
        'prefix' => $prefix,
    ]);
}   
    public function getUserInfo($id){
        $Client = DB::table('clients')->find($id);

        if (!$Client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json([
            'company_name' => $Client->company_name ?? '',
            'contact_no' => $Client->contact_no ?? '',
            'address' => $Client->address ?? '',
            'source_sample' => $Client->source_sample ?? '',
        ]);
    }
     public function lf_06_02_store(Request $request)
        {
            // dd($request->all());

            $labCodes = $request->laboratory_code ?? [];
            $descriptions = $request->sample_description ?? [];
            $sampleCodes = $request->sample_code ?? [];
            $labUnits = $request->lab_unit ?? [];
            $analysisDescriptions = $request->analysis_description ?? [];
            $analyses = $request->analysis_requested ?? [];
            $methods = $request->test_method ?? [];

            $finalLabCodes = [];
            $finalDescriptions = [];
            $finalSampleCodes = [];
            $finalLabUnits = [];
            $finalAnalysisDescriptions = [];
            $finalAnalyses = [];
            $finalMethods = [];

            $rowCount = max(
                count($labCodes),
                count($descriptions),
                count($sampleCodes),
                count($labUnits),
                count($analysisDescriptions),
                count($analyses),
                count($methods)
            );

            for ($i = 0; $i < $rowCount; $i++) {
                $lab = $labCodes[$i] ?? null;
                $desc = $descriptions[$i] ?? null;
                $sample = $sampleCodes[$i] ?? null;
                $labUnit = $labUnits[$i] ?? null;
                $analysisDescription = $analysisDescriptions[$i] ?? null;
                $analysis = $analyses[$i] ?? [];
                $method = $methods[$i] ?? null;

                /*
                    analysis_requested is multiple select:
                    Example:
                    analysis_requested[0][] = APC, E COLI
                    So per row, it should be array.
                */
                if (!is_array($analysis)) {
                    $analysis = $analysis ? [$analysis] : [];
                }

                $analysis = array_values(array_filter($analysis, function ($value) {
                    return $value !== null && $value !== '';
                }));

                if (
                    empty($lab) &&
                    empty($desc) &&
                    empty($sample) &&
                    empty($labUnit) &&
                    empty($analysisDescription) &&
                    empty($analysis) &&
                    empty($method)
                ) {
                    continue;
                }

                $finalLabCodes[] = $lab;
                $finalDescriptions[] = $desc;
                $finalSampleCodes[] = $sample;
                $finalLabUnits[] = $labUnit;
                $finalAnalysisDescriptions[] = $analysisDescription;
                $finalAnalyses[] = $analysis;
                $finalMethods[] = $method;
            }

            DB::table('lf_06_02')->insert([
                'user_id' => $request->user_id,
                'RLA_no' => $request->RLA_no,
                'terms_accepted' => $request->terms_accepted,
                'source_sample' => $request->source_sample,
                'sample' => $request->sample,
                'date_collected' => $request->date_collected,

                'laboratory_code' => json_encode($finalLabCodes),
                'sample_description' => json_encode($finalDescriptions),
                'sample_code' => json_encode($finalSampleCodes),
                'lab_unit' => json_encode($finalLabUnits),
                'analysis_description' => json_encode($finalAnalysisDescriptions),
                'analysis_requested' => json_encode($finalAnalyses),
                'test_method' => json_encode($finalMethods),

                'sample_received_by' => $request->sample_received_by,
                'service_officer' => $request->service_officer,
                'date_received' => $request->date_received,
                'payment' => $request->payment,
                'date_payment' => $request->date_payment,
                'or_no' => $request->or_no,
                'remarks' => $request->remarks,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Saved successfully.');
        }
  public function edit($id)
    {
        $rla = DB::table('lf_06_02')->where('id', $id)->first();

        if (!$rla) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found.'
            ], 404);
        }

        $client = DB::table('clients')->where('id', $rla->user_id)->first();

        $laboratoryCodes = !empty($rla->laboratory_code) 
            ? json_decode($rla->laboratory_code, true) 
            : [];

        $sampleDescriptions = !empty($rla->sample_description) 
            ? json_decode($rla->sample_description, true) 
            : [];

        $sampleCodes = !empty($rla->sample_code) 
            ? json_decode($rla->sample_code, true) 
            : [];

        $labUnits = !empty($rla->lab_unit) 
            ? json_decode($rla->lab_unit, true) 
            : [];

        $analysisDescriptions = !empty($rla->analysis_description) 
            ? json_decode($rla->analysis_description, true) 
            : [];

        $analysisRequested = !empty($rla->analysis_requested) 
            ? json_decode($rla->analysis_requested, true) 
            : [];

        $testMethods = !empty($rla->test_method) 
            ? json_decode($rla->test_method, true) 
            : [];

        $rows = [];

        $maxRows = max(
            count($laboratoryCodes),
            count($sampleDescriptions),
            count($sampleCodes),
            count($labUnits),
            count($analysisDescriptions),
            count($analysisRequested),
            count($testMethods)
        );

        for ($i = 0; $i < $maxRows; $i++) {
            $analysis = $analysisRequested[$i] ?? [];

            if (!is_array($analysis)) {
                $analysis = !empty($analysis) ? [$analysis] : [];
            }

            $rows[] = [
                'laboratory_code' => $laboratoryCodes[$i] ?? '',
                'sample_description' => $sampleDescriptions[$i] ?? '',
                'sample_code' => $sampleCodes[$i] ?? '',
                'lab_unit' => $labUnits[$i] ?? '',
                'analysis_description' => $analysisDescriptions[$i] ?? '',
                'analysis_requested' => $analysis,
                'test_method' => $testMethods[$i] ?? '',
            ];
        }

        $payment = DB::table('lf_06_03')
            ->where('lf_06_02_id', $id)
            ->first();

        return response()->json([
            'status' => true,
            'id' => $rla->id,
            'edit_user_id' => $rla->user_id ?? '',
            'edit_company_name' => $client->company_name ?? '',
            'edit_RLA_no' => $rla->RLA_no ?? '',
            'edit_location' => $client->address ?? '',
            'edit_contact_no' => $client->contact_no ?? '',
            'edit_source_sample' => $rla->source_sample ?? '',
            'edit_sample' => $rla->sample ?? '',
            'edit_date_collected' => $rla->date_collected ?? '',
            'edit_sample_received_by' => $rla->sample_received_by ?? '',
            'edit_service_officer' => $rla->service_officer ?? '',
            'edit_date_received' => $rla->date_received ?? '',
            'edit_payment' => isset($payment->grand_total)
                ? number_format($payment->grand_total, 2)
                : '0.00',
            'edit_date_payment' => $rla->date_payment ?? '',
            'edit_or_no' => $rla->or_no ?? '',
            'edit_remarks' => $rla->remarks ?? '',
            'rows' => $rows,
        ]);
    }
   public function update(Request $request, $id)
    {
        $rla = DB::table('lf_06_02')->where('id', $id)->first();

        if (!$rla) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        $labCodes = $request->edit_laboratory_code ?? [];
        $descriptions = $request->edit_sample_description ?? [];
        $sampleCodes = $request->edit_sample_code ?? [];
        $labUnits = $request->edit_lab_unit ?? [];
        $analysisDescriptions = $request->edit_analysis_description ?? [];
        $analyses = $request->edit_analysis_requested ?? [];
        $methods = $request->edit_test_method ?? [];

        $finalLabCodes = [];
        $finalDescriptions = [];
        $finalSampleCodes = [];
        $finalLabUnits = [];
        $finalAnalysisDescriptions = [];
        $finalAnalyses = [];
        $finalMethods = [];

        $rowCount = max(
            count($labCodes),
            count($descriptions),
            count($sampleCodes),
            count($labUnits),
            count($analysisDescriptions),
            count($analyses),
            count($methods)
        );

        for ($i = 0; $i < $rowCount; $i++) {
            $lab = $labCodes[$i] ?? null;
            $desc = $descriptions[$i] ?? null;
            $sample = $sampleCodes[$i] ?? null;
            $labUnit = $labUnits[$i] ?? null;
            $analysisDescription = $analysisDescriptions[$i] ?? null;
            $analysis = $analyses[$i] ?? [];
            $method = $methods[$i] ?? null;

            if (!is_array($analysis)) {
                $analysis = !empty($analysis) ? [$analysis] : [];
            }

            $analysis = array_values(array_filter($analysis, function ($value) {
                return $value !== null && $value !== '';
            }));

            if (
                empty($lab) &&
                empty($desc) &&
                empty($sample) &&
                empty($labUnit) &&
                empty($analysisDescription) &&
                empty($analysis) &&
                empty($method)
            ) {
                continue;
            }

            $finalLabCodes[] = $lab;
            $finalDescriptions[] = $desc;
            $finalSampleCodes[] = $sample;
            $finalLabUnits[] = $labUnit;
            $finalAnalysisDescriptions[] = $analysisDescription;
            $finalAnalyses[] = $analysis;
            $finalMethods[] = $method;
        }

        DB::table('lf_06_02')->where('id', $id)->update([
            'user_id' => $request->edit_user_id,
            'RLA_no' => $request->edit_RLA_no,
            'source_sample' => $request->edit_source_sample,
            'sample' => $request->edit_sample,
            'date_collected' => $request->edit_date_collected,

            'laboratory_code' => json_encode($finalLabCodes),
            'sample_description' => json_encode($finalDescriptions),
            'sample_code' => json_encode($finalSampleCodes),
            'lab_unit' => json_encode($finalLabUnits),
            'analysis_description' => json_encode($finalAnalysisDescriptions),
            'analysis_requested' => json_encode($finalAnalyses),
            'test_method' => json_encode($finalMethods),

            'sample_received_by' => $request->edit_sample_received_by,
            'service_officer' => $request->edit_service_officer,
            'date_received' => $request->edit_date_received,
            'payment' => $request->edit_payment,
            'date_payment' => $request->edit_date_payment,
            'or_no' => $request->edit_or_no,
            'remarks' => $request->edit_remarks,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'RLA updated successfully.');
    }
       
      public function downloadPdf($id)
        {
            $rla = DB::table('lf_06_02')->where('id', $id)->first();

            if (!$rla) {
                return redirect()->back()->with('error', 'Record not found.');
            }

            $client = DB::table('clients')->where('id', $rla->user_id)->first();

            $laboratoryCodes = json_decode($rla->laboratory_code ?? '[]', true) ?? [];
            $sampleDescriptions = json_decode($rla->sample_description ?? '[]', true) ?? [];
            $sampleCodes = json_decode($rla->sample_code ?? '[]', true) ?? [];
            $analysisRequested = json_decode($rla->analysis_requested ?? '[]', true) ?? [];
            $testMethods = json_decode($rla->test_method ?? '[]', true) ?? [];

            $maxRows = max(
                count($laboratoryCodes),
                count($sampleDescriptions),
                count($sampleCodes),
                count($analysisRequested),
                count($testMethods)
            );

            $rows = [];

            for ($i = 0; $i < $maxRows; $i++) {
                $analysis = $analysisRequested[$i] ?? '';

                if (is_array($analysis)) {
                    $analysis = implode(', ', array_filter($analysis));
                }

                $rows[] = [
                    'laboratory_code' => $laboratoryCodes[$i] ?? '',
                    'sample_description' => $sampleDescriptions[$i] ?? '',
                    'sample_code' => $sampleCodes[$i] ?? '',
                    'analysis_requested' => $analysis,
                    'test_method' => $testMethods[$i] ?? '',
                ];
            }

           $displayAddress = $this->getAddressFromCoordinates($client->address ?? '');
            // dd( $displayAddress );
            $data = [
                'rla' => $rla,
                'client' => $client,
                'rows' => $rows,
                'displayAddress' => $displayAddress 
            ];

            $pdf = Pdf::loadView('RLA.lf_06_02_download', $data)
                ->setPaper('a4', 'portrait');

            return $pdf->download('RLA-' . $rla->RLA_no . '.pdf');
        }
        public function delete($id){
            return view('confirm-delete', ['id'=> $id]);
        }

        public function rladelete($id){
            try{
                $rla = DB::table('lf_06_02')->where('id', $id)->delete();
                // $rla->delete();
                // ActivityLog::create([
                //     'user_id' => Auth::user()->id,
                //     'activity' => 'Deleted the User Name'. $user->f_name . '' .  $user->l_name,
                //     'time' => now('Asia/Manila'),
                //     'date' => now()->toDateString(), 
                // ]);
              return redirect()->back()->with('success', 'RLA Deleted successfully.');
            }
            catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
                return response()->json(['error' => 'RLA not found'], 404);
            }
            catch(\Exception $e){
                return response()->json(['error'=> 'An error occured while deleting the RLA'], 500);
            }
        } 
        //status
       public function updateStatusRLA($id)
        {
            DB::table('lf_06_02')
                ->where('id', $id)
                ->update(['status' => 1]);

            return redirect()->back()->with('success', 'Successfully Update Status');
        }
        public function updateStatusOP($id)
        {
            DB::table('lf_06_02')
                ->where('id', $id)
                ->update(['status' => 2]);

            return redirect()->back()->with('success', 'Successfully Update Status');
        }
        public function updateStatusJRF($id)
        {
            DB::table('lf_06_02')
                ->where('id', $id)
                ->update(['status' => 3]);

            return redirect()->back()->with('success', 'Successfully Update Status');
        }
        public function updateStatusAW($id)
        {
            DB::table('lf_06_02')
                ->where('id', $id)
                ->update(['status' => 4]);

            return redirect()->back()->with('success', 'Successfully Update Status');
        }
        
        //Order Payment
        public function lf_06_03(){
          $clients = DB::table('clients')->get();

            $rla = DB::table('lf_06_02')
                ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
                ->select(
                    'lf_06_02.id',
                    'lf_06_02.user_id',
                    'lf_06_02.RLA_no',
                    'lf_06_02.payment',
                    'lf_06_02.date_collected',
                    'lf_06_02.sample',
                    'clients.address',
                    'clients.contact_no',
                    'lf_06_02.source_sample',
                    'lf_06_02.sample_received_by',
                    'lf_06_02.service_officer',
                    'lf_06_02.date_received',
                    'lf_06_02.date_payment',
                    'lf_06_02.or_no',
                    'lf_06_02.remarks',
                    'lf_06_02.status',
                    'clients.company_name'
                )->orderBy('lf_06_02.id', 'desc')
                ->paginate(10);
        
            return view('OrderPayment.lf_06_03',compact('clients','rla'));
        }
        public function payment($id)
            {
                $rla = DB::table('lf_06_02')->where('id', $id)->first();

                if (!$rla) {
                    return response()->json([
                        'status' => false,
                        'message' => 'RLA not found.'
                    ], 404);
                }

                $client = DB::table('clients')->where('id', $rla->user_id)->first();

                $labCodes = json_decode($rla->laboratory_code ?? '[]', true) ?? [];
                $sampleDesc = json_decode($rla->sample_description ?? '[]', true) ?? [];

                $payment = DB::table('lf_06_03')
                    ->where('lf_06_02_id', $id)
                    ->first();

                $savedItems = [];

                if ($payment && !empty($payment->items)) {
                    $savedItems = json_decode($payment->items, true) ?? [];
                }

                $allLabCodes = '';

                if ($payment && !empty($payment->laboratory_code)) {
                    $paymentLabCodes = json_decode($payment->laboratory_code, true);

                    if (is_array($paymentLabCodes)) {
                        $allLabCodes = implode(', ', array_filter($paymentLabCodes));
                    } else {
                        $allLabCodes = $payment->laboratory_code;
                    }
                } else {
                    $allLabCodes = implode(', ', array_filter($labCodes));
                }

                
                $firstSampleDescription = '';

                if ($payment && !empty($payment->sample_description)) {
                    $paymentSampleDesc = json_decode($payment->sample_description, true);

                    if (is_array($paymentSampleDesc)) {
                        $firstSampleDescription = $paymentSampleDesc[0] ?? '';
                    } else {
                        $firstSampleDescription = $payment->sample_description;
                    }
                } else {
                    $firstSampleDescription = $sampleDesc[0] ?? '';
                }

                return response()->json([
                    'status' => true,
                    'id' => $rla->id,
                    'user_id' => $rla->user_id ?? '',
                    'company_name' => $payment->company_name ?? ($client->company_name ?? ''),
                    'location' => $payment->address ?? ($client->address ?? ''),
                    'RLA_no' => $payment->RLA_no ?? ($rla->RLA_no ?? ''),
                    'sample' => $payment->sample ?? ($rla->sample ?? ''),

                    // Laboratory code = tanan
                    'first_lab_code' => $allLabCodes,

                    // Sample description = first/isa ra
                    'first_sample_desc' => $firstSampleDescription,

                    'issued_by' => $payment->issued_by ?? '',
                    'date_issued' => $payment->date_issued ?? '',
                    'grand_total' => $payment->grand_total ?? '',
                    'signature' => $payment->signature ?? '',

                    'items' => $savedItems,
                    'has_existing_payment' => $payment ? true : false,
                    'payment_id' => $payment->id ?? null,
                ]);
            }
      public function lf_06_03_store(Request $request, $id)
        {
            $rla = DB::table('lf_06_02')->where('id', $id)->first();

            if (!$rla) {
                return redirect()->back()->with('error', 'RLA record not found.');
            }

            $items = [];

            foreach (($request->items ?? []) as $item) {
                $items[] = [
                    'section' => $item['section'] ?? '',
                    'name' => $item['name'] ?? '',
                    'checked' => !empty($item['checked']),
                    'qty' => (float)($item['qty'] ?? 0),
                    'unit' => (float)($item['unit'] ?? 0),
                    'total' => (float)($item['total'] ?? 0),
                ];
            }

            $existing = DB::table('lf_06_03')
                ->where('lf_06_02_id', $id)
                ->first();

            $data = [
                'lf_06_02_id' => $id,
                'user_id' => $request->user_id ?: ($rla->user_id ?? null),
                'RLA_no' => $request->RLA_no,
                'company_name' => $request->company_name,
                'laboratory_code' => $request->laboratory_code,
                'items' => json_encode($items),
                'grand_total' => (float)($request->grand_total ?? 0),
                'issued_by' => $request->issued_by,
                'date_issued' => $request->date_issued,
                'signature' => $request->signature,
                'updated_at' => now(),
            ];
            
            if ($existing) {
                DB::table('lf_06_03')
                    ->where('lf_06_02_id', $id)
                    ->update($data);

                return redirect()->back()->with('success', 'Order of Payment updated successfully.');
            } else {
                $data['created_at'] = now();

                DB::table('lf_06_03')->insert($data);

                return redirect()->back()->with('success', 'Order of Payment saved successfully.');
            }
        }
  public function downloadPdfOP($id)
    {
        $payment = DB::table('lf_06_03')
            ->where('lf_06_02_id', $id)
            ->first();

        if (!$payment) {
            return back()->with('error', 'No payment record found.');
        }

        $rla = DB::table('lf_06_02')
            ->where('id', $id)
            ->first();

        $clientId = $payment->user_id ?? ($rla->user_id ?? null);

        $client = null;
        if ($clientId) {
            $client = DB::table('clients')
                ->where('id', $clientId)
                ->first();
        }
        $sampleDesc = json_decode($rla->sample_description, true);
        $items = json_decode($payment->items ?? '[]', true);
        $displayAddress = $this->getAddressFromCoordinates($client->address ?? '');
        // dd( $displayAddress );
        $data = [
            'payment' => $payment,
            'client' => $client,
            'displayAddress' => $displayAddress ,
            'rla' => $rla,
            'items' => $items,
            'sample' => $sampleDesc[0] ?? '',
        ];
    // dd($data);
        $pdf = Pdf::loadView('OrderPayment.lf_06_03_download', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download('Order of Payment-' . ($payment->RLA_no ?? 'record') . '.pdf');
    }
    //Job Routing Form
    public function lf_06_04(Request $request)
    {
        $clients = DB::table('clients')->get();

        $userRole = Auth::user()->role;

        $query = DB::table('lf_06_02')
            ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
            ->select(
                'lf_06_02.id',
                'lf_06_02.user_id',
                'lf_06_02.RLA_no',
                'lf_06_02.payment',
                'lf_06_02.date_collected',
                'lf_06_02.sample',
                'clients.address',
                'clients.contact_no',
                'lf_06_02.source_sample',
                'lf_06_02.sample_received_by',
                'lf_06_02.service_officer',
                'lf_06_02.date_received',
                'lf_06_02.date_payment',
                'lf_06_02.or_no',
                'lf_06_02.remarks',
                'lf_06_02.status',
                'clients.company_name',
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(lf_06_02.laboratory_code, '$[0]')) as lab_code"),
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(lf_06_02.sample_description, '$[0]')) as sample_desc"),
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(lf_06_02.lab_unit, '$[0]')) as lab_unit")
            );

        if ($userRole == 2 || $userRole == 4) {
            // FIS only
            $query->whereRaw("JSON_CONTAINS(lf_06_02.lab_unit, '\"FIS\"')");
        } elseif ($userRole == 3) {
            // MIC only
            $query->whereRaw("JSON_CONTAINS(lf_06_02.lab_unit, '\"MIC\"')");
        } elseif ($userRole == 7) {
            // CHEM only
            $query->whereRaw("JSON_CONTAINS(lf_06_02.lab_unit, '\"CHEM\"')");
        } elseif ($userRole == 0) {
            // role 0 can view all
        } else {
            $query->whereRaw("1 = 0");
        }

        $rla = $query->orderBy('lf_06_02.id', 'desc')->paginate(10);

        return view('JobRoutingForm.lf_06_04', compact('clients', 'rla'));
    }
   
        public function lf_06_04_store(Request $request, $id)
        {
            $rla = DB::table('lf_06_02')->where('id', $id)->first();

            if (!$rla) {
                return response()->json([
                    'status' => false,
                    'message' => 'RLA not found.'
                ], 404);
            }

            $validated = $request->validate([
                'user_id' => 'nullable',
                'RLA_no' => 'nullable|string|max:255',
                'laboratory_code' => 'nullable|string|max:255',
                'sample' => 'nullable|string|max:255',
                'receiving_in_date' => 'nullable|date',
                'receiving_in_time' => 'nullable',
                'receiving_out_date' => 'nullable|date',
                'receiving_out_time' => 'nullable',
                'receiving_remarks' => 'nullable|string|max:255',
                'receiving_initials' => 'nullable|string|max:255',
                'prep_in_date' => 'nullable|date',
                'prep_in_time' => 'nullable',
                'prep_out_date' => 'nullable|date',
                'prep_out_time' => 'nullable',
                'prep_results' => 'nullable|string|max:255',
                'prep_recovery' => 'nullable|string|max:255',
                'prep_initials' => 'nullable|string|max:255',
                // analysis 1
                'analysis_1' => 'nullable|string|max:255',
                'analysis_2' => 'nullable|string|max:255',
                'analysis_3' => 'nullable|string|max:255',
                'analysis_4' => 'nullable|string|max:255',
                'analysis_results' => 'nullable|string|max:255',
                'analysis_recovery' => 'nullable|string|max:255',
                'analysis_initials' => 'nullable|string|max:255',
                // analysis 2
                'name_analysis_2' => 'nullable|string|max:255',
                'analysis_2_2' => 'nullable|string|max:255',
                'analysis_2_3' => 'nullable|string|max:255',
                'analysis_2_4' => 'nullable|string|max:255',
                'analysis_2_5' => 'nullable|string|max:255',
                'analysis_results_2' => 'nullable|string|max:255',
                'analysis_recovery_2' => 'nullable|string|max:255',
                'analysis_initials_2' => 'nullable|string|max:255',
                // analysis 3
                'name_analysis_3' => 'nullable|string|max:255',
                'analysis_3_2' => 'nullable|string|max:255',
                'analysis_3_3' => 'nullable|string|max:255',
                'analysis_3_4' => 'nullable|string|max:255',
                'analysis_3_5' => 'nullable|string|max:255',
                'analysis_results_3' => 'nullable|string|max:255',
                'analysis_recovery_3' => 'nullable|string|max:255',
                'analysis_initials_3' => 'nullable|string|max:255',
                // analysis 4
                'name_analysis_4' => 'nullable|string|max:255',
                'analysis_4_2' => 'nullable|string|max:255',
                'analysis_4_3' => 'nullable|string|max:255',
                'analysis_4_4' => 'nullable|string|max:255',
                'analysis_4_5' => 'nullable|string|max:255',
                'analysis_results_4' => 'nullable|string|max:255',
                'analysis_recovery_4' => 'nullable|string|max:255',
                'analysis_initials_4' => 'nullable|string|max:255',
                // analysis 5
                'name_analysis_5' => 'nullable|string|max:255',
                'analysis_5_2' => 'nullable|string|max:255',
                'analysis_5_3' => 'nullable|string|max:255',
                'analysis_5_4' => 'nullable|string|max:255',
                'analysis_5_5' => 'nullable|string|max:255',
                'analysis_results_5' => 'nullable|string|max:255',
                'analysis_recovery_5' => 'nullable|string|max:255',
                'analysis_initials_5' => 'nullable|string|max:255',
                // analysis 6
                'name_analysis_6' => 'nullable|string|max:255',
                'analysis_6_2' => 'nullable|string|max:255',
                'analysis_6_3' => 'nullable|string|max:255',
                'analysis_6_4' => 'nullable|string|max:255',
                'analysis_6_5' => 'nullable|string|max:255',
                'analysis_results_6' => 'nullable|string|max:255',
                'analysis_recovery_6' => 'nullable|string|max:255',
                'analysis_initials_6' => 'nullable|string|max:255',
                'remarks' => 'nullable|string',
                'checked_by' => 'nullable|string|max:255',
                'checked_date' => 'nullable|date',
                'report_in_date' => 'nullable|date',
                'report_in_time' => 'nullable',
                'report_out_date' => 'nullable|date',
                'report_out_time' => 'nullable',
                'report_remarks' => 'nullable|string|max:255',
                'report_initials' => 'nullable|string|max:255',
                'date_approved_release' => 'nullable|date',
            ]);

            $labCodes = json_decode($rla->laboratory_code ?? '[]', true) ?? [];

            $data = array_merge($validated, [
                'lf_06_02_id' => $rla->id,
                'user_id' => $request->user_id ?? $rla->user_id ?? null,
                'RLA_no' => $request->RLA_no ?? $rla->RLA_no ?? null,
                'sample' => $request->sample ?? $rla->sample ?? null,
                'laboratory_code' => $request->laboratory_code ?? ($labCodes[0] ?? null),
            ]);

            $existing = DB::table('lf_06_04')->where('lf_06_02_id', $id)->first();

            if ($existing) {
                DB::table('lf_06_04')
                    ->where('lf_06_02_id', $id)
                    ->update(array_merge($data, [
                        'updated_at' => now()
                    ]));

                $message = 'Routing form updated successfully.';
            } else {
                DB::table('lf_06_04')->insert(array_merge($data, [
                    'created_at' => now(),
                    'updated_at' => now()
                ]));

                $message = 'Routing form saved successfully.';
            }
            if (!empty($request->date_approved_release)) {
                DB::table('lf_06_02')
                    ->where('id', $id)
                    ->update([
                        'status' => 8,
                        'updated_at' => now()
                    ]);
            }
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        }
        public function jobrouting($id)
        {
            $rla = DB::table('lf_06_02')->where('id', $id)->first();

            if (!$rla) {
                return response()->json([
                    'status' => false,
                    'message' => 'RLA not found.'
                ], 404);
            }

            $client = DB::table('clients')->where('id', $rla->user_id)->first();
            $labCodes = json_decode($rla->laboratory_code ?? '[]', true) ?? [];

            $payment = DB::table('lf_06_03')
                ->where('lf_06_02_id', $id)
                ->first();

            $savedItems = [];
            if ($payment && !empty($payment->items)) {
                $savedItems = json_decode($payment->items, true) ?? [];
            }
        
            $routingForm = DB::table('lf_06_04')->where('lf_06_02_id', $id)->first();
            
            $rlaSample = json_decode($rla->sample_description ?? '[]', true) ?? [];
        
            // dd($rlaSample[0]);
            return response()->json([
                'status' => true,
                'job_status' => $rla->status,
                'id' => $rla->id,
                'user_id' => $rla->user_id ?? '',
                'company_name' => $payment->company_name ?? ($client->company_name ?? ''),
                'location' => $payment->address ?? ($client->address ?? ''),
                'RLA_no' => $routingForm->RLA_no ?? ($payment->RLA_no ?? ($rla->RLA_no ?? '')),              
                'sample_desc' => !empty($rlaSample) ? $rlaSample[0] : '',
                'first_lab_code' => $routingForm->laboratory_code ?? ($payment->laboratory_code ?? ($labCodes[0] ?? '')),
                'issued_by' => $payment->issued_by ?? '',
                'date_issued' => $payment->date_issued ?? '',
                'grand_total' => $payment->grand_total ?? '',
                'signature' => $payment->signature ?? '',
                'items' => $savedItems,
                'has_existing_payment' => $payment ? true : false,
                'payment_id' => $payment->id ?? null,            
                'routing_form' => $routingForm,
                'has_existing_routing' => $routingForm ? true : false,
            ]);
        }
    public function downloadPdfRoutingForm($id)
    {
        $rla = DB::table('lf_06_02')->where('id', $id)->first();

        if (!$rla) {
            abort(404, 'RLA not found.');
        }

        $client = DB::table('clients')->where('id', $rla->user_id)->first();
        $labCodes = json_decode($rla->laboratory_code ?? '[]', true) ?? [];

        $payment = DB::table('lf_06_03')
            ->where('lf_06_02_id', $id)
            ->first();

        $routingForm = DB::table('lf_06_04')
            ->where('lf_06_02_id', $id)
            ->first();
         $sampleDesc = json_decode($rla->sample_description?? '[]', true) ?? [];
        //   $rlaSample = json_decode($rla->sample_description ?? '[]', true) ?? [];
        $data = [
            'rla' => $rla,
            'client' => $client,
            'payment' => $payment,
            'routingForm' => $routingForm,
            'RLA_no' => $routingForm->RLA_no ?? ($payment->RLA_no ?? ($rla->RLA_no ?? '')),
            'sample' => $sampleDesc[0] ?? '',
            'laboratory_code' => $routingForm->laboratory_code ?? ($payment->laboratory_code ?? ($labCodes[0] ?? '')),
            'user_id' => $rla->user_id ?? '',
        ];

        $pdf = Pdf::loadView('JobRoutingForm.lf_06_04_download', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download('Job Routing Form-' . ($data['RLA_no'] ?: $id) . '.pdf');
    }
    //Sample disposal logbook
    public function sample_disposal_logbook_index()
    {
        $samples = DB::table('sample_storage_logbooks')->orderBy('id', 'desc')->paginate(10);

        return view('SampleDisposalLogbook.index', compact('samples' ));
    }
    public function getRLAInfo($id)
    {
        $data = DB::table('lf_06_02')->where('id', $id)->first();

        return response()->json([
            'sample_description' => json_decode($data->sample_description, true)[0] ?? ''
        ]);
    }

    public function sample_disposal_logbook_create(){
        
        $RLA = DB::table('lf_06_02')->where('status', 4)->get()->map(function ($item) {
            $item->laboratory_code = json_decode($item->laboratory_code, true);
            $item->sample_description = json_decode($item->sample_description, true);
            return $item;
        });

        return view('SampleDisposalLogbook.create',compact('RLA'));
    }
    public function sample_disposal_logbook_store(Request $request){
        // dd($request->all());
        $logbook = DB::table('sample_storage_logbooks')->insert([
           'lab_code' => $request->lab_code,
           'sample_desc'  => $request->sample_desc,
           'date_received'  => $request->date_received,
           'date_stored'  => $request->date_stored,
           'date_analyzed'  => $request->date_analyzed,
           'date_disposal' => $request->date_disposal,
           'disposed_by' => $request->disposed_by,
           'checked_by' => $request->checked_by,
        ]);
        DB::table('lf_06_02')->where('id',$request->lf_06_02_id)->update([
            'status' => 7,

        ]);
        return redirect()->route('sample_logbook')->with('success', 'Logbook Save Successfully');
    }
  public function edit_sample($id)
    {
        $sample = DB::table('sample_storage_logbooks')->where('id', $id)->first();

        if (!$sample) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        $RLA = DB::table('lf_06_02')->get()->map(function ($item) {
            $decoded = json_decode($item->laboratory_code, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $item->lab_code_display = $decoded[0] ?? '';
            } else {
                $item->lab_code_display = $item->laboratory_code ?? '';
            }

            return $item;
        });

        return view('SampleDisposalLogbook.edit', compact('sample', 'RLA'));
    }
    public function update_sample(Request $request)
    {
        // dd($request->all());
        DB::table('sample_storage_logbooks')
            ->where('id', $request->id)
            ->update([
                'lab_code' => $request->lab_code,
                'sample_desc' => $request->sample_desc,
                'date_received' => $request->date_received,
                'date_stored' => $request->date_stored,
                'date_analyzed' => $request->date_analyzed,
                'date_disposal' => $request->date_disposal,
                'disposed_by' => $request->disposed_by,
                'checked_by' => $request->checked_by,
                'updated_at' => now(),
            ]);

        return redirect()->route('sample_logbook')->with('success', 'Record updated successfully.');
    }
    public function deleteSample($id){
        return view('confirm-delete', ['id'=> $id]);
    }

    public function hardDelete_sample($id){
        try{
            $sample = DB::table('sample_storage_logbooks')->where('id',$id)->delete();

            // ActivityLog::create([
            //     'user_id' => Auth::user()->id,
            //     'activity' => 'Deleted the User Name'. $user->f_name . '' .  $user->l_name,
            //     'time' => now('Asia/Manila'),
            //     'date' => now()->toDateString(), 
            // ]);
            return redirect()->route('sample_logbook')->with('success', 'Sample Storage & Disposal Logbook Deleted Successfully!');
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response()->json(['error' => 'client not found'], 404);
        }
        catch(\Exception $e){
            return response()->json(['error'=> 'An error occured while deleting the client'], 500);
        }
    } 
    public function downloadPdfSample()
        {
            $records = DB::Table('sample_storage_logbooks')->orderBy('date_received', 'asc')->get();
             if ($records->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No data available to download.'
                ], 404);
            }
            $logoPath = public_path('assets/images/bfarlogo.png');
            $logoSrc = null;
            

            if (file_exists($logoPath)) {
                $logoData = base64_encode(file_get_contents($logoPath));
                $logoSrc = 'data:image/png;base64,' . $logoData;
            }

            $chunkedRecords = $records->chunk(18);

            $data = [
                'records' => $records,
                'chunkedRecords' => $chunkedRecords,
                'logoSrc' => $logoSrc,
                'date_adopted' => '13 Aug 2019',
                'document_type' => 'Laboratory Record',
                'revision_no' => '0',
                'document_code' => 'LF 07-FIS-01',
                'title' => 'SAMPLE STORAGE AND DISPOSAL LOGBOOK',
            ];

            $pdf = Pdf::loadView('SampleDisposalLogbook.download', $data)
                ->setPaper('a4', 'landscape')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isPhpEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'Times New Roman',
                ]);

            return $pdf->download('Sample Storage and Disposal Logbook.pdf');
    }
    //equipment usage 
    public function equipments_usage(){
        $equipments = DB::table('lf_03_05')->paginate(10);

        return view('LogForm.lf_03_05',compact('equipments'));
    }
    //equipments plan
    // public function equipment_plan_index(){
    //     return view('EquipmentPlan.index');
    // }
    // public function equipment_plan_create(){
    //     return view('EquipmentPlan.create');
    // }
    // public function equipment_plan_store(Request $request)
    // {
    //     $data = [
    //         'unit' => $request->unit ?: null,
    //         'equipment_code' => $request->equipment_code ?: null,
    //         'equipment_name' => $request->equipment_name ?: null,
    //         'manufacturer' => $request->manufacturer ?: null,
    //         'brand_model_no' => $request->brand_model_no ?: null,

    //         'date_of_maintenance' => $request->date_of_maintenance ?: null,
    //         'service_report_no' => $request->service_report_no ?: null,

    //         'maintenance_type' => $request->maintenance_type ?: null,
    //         'maintenance_provider' => $request->maintenance_provider ?: null,
    //         'maintenance_technician' => $request->maintenance_technician ?: null,
    //         'maintenance_hours' => $request->maintenance_hours ?: null,

    //         'issues_reported' => !empty($request->issues_reported)
    //             ? json_encode($request->issues_reported)
    //             : json_encode([]),

    //         'issue_other' => $request->issue_other ?: null,

    //         'actions_taken' => !empty($request->actions_taken)
    //             ? json_encode($request->actions_taken)
    //             : json_encode([]),

    //         'action_other' => $request->action_other ?: null,

    //         'tools_used' => $request->tools_used ?: null,

    //         'operational_status' => !empty($request->operational_status)
    //             ? json_encode($request->operational_status)
    //             : json_encode([]),

    //         'equipment_status' => !empty($request->equipment_status)
    //             ? json_encode($request->equipment_status)
    //             : json_encode([]),

    //         'next_maintenance_due' => $request->next_maintenance_due ?: null,

    //         'frequency' => !empty($request->frequency)
    //             ? json_encode($request->frequency)
    //             : json_encode([]),

    //         'technician_notes' => $request->technician_notes ?: null,
    //         'manager_feedback' => $request->manager_feedback ?: null,

    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ];

    //     DB::table('equipment_maintenance_plans')->insert($data);

    //     return redirect()
    //         ->back()
    //         ->with('success', 'Equipment maintenance plan saved successfully.');
    // }
    //ENVIRONMENTAL CONDITION FORM
    public function environmental_plan_index()
    {
        $environmentals = DB::table('environmental_plans')->latest()->paginate(10);
         $laboratories = DB::table('environmental_plans')
            ->select('laboratory_name')
            ->whereNotNull('laboratory_name')
            ->where('laboratory_name', '!=', '')
            ->distinct()
            ->orderBy('laboratory_name')
            ->get();
        return view('EnvironmentalConditions.index', compact('environmentals','laboratories'));
    }
    public function environmental_plan_create()
    {
        return view('EnvironmentalConditions.create');
    }

    public function environmental_plan_store(Request $request)
    {
        $validated = $request->validate([
            'area' => 'nullable|string|max:255',
            'laboratory_name' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'temperature_am' => 'nullable|numeric',
            'temperature_pm' => 'nullable|numeric',
            'humidity_am' => 'nullable|numeric',
            'humidity_pm' => 'nullable|numeric',
            'remarks' => 'nullable|string',
            'analyst' => 'nullable|string|max:255',
            'checked_by' => 'nullable|string|max:255',
        ]);

        DB::Table('environmental_plans')->insert($validated);

        return redirect()->route('environmental_plan/index')
            ->with('success', 'Environmental record created successfully.');
    }
    public function edit_environmental($id)
    {
        $environmental = DB::table('environmental_plans')->where('id', $id)->first();

        if (!$environmental) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        return view('EnvironmentalConditions.edit', compact('environmental'));
    }
    public function update_environmental(Request $request)
    {
        $request->validate([
            'area' => 'nullable|string|max:255',
            'laboratory_name' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'temperature_am' => 'nullable|numeric',
            'temperature_pm' => 'nullable|numeric',
            'humidity_am' => 'nullable|numeric',
            'humidity_pm' => 'nullable|numeric',
            'remarks' => 'nullable|string',
            'analyst' => 'nullable|string|max:255',
            'checked_by' => 'nullable|string|max:255',
        ]);

        $updated = DB::table('environmental_plans')
            ->where('id', $request->id)
            ->update([
                'area' => $request->area,
                'laboratory_name' => $request->laboratory_name,
                'date' => $request->date,
                'temperature_am' => $request->temperature_am,
                'temperature_pm' => $request->temperature_pm,
                'humidity_am' => $request->humidity_am,
                'humidity_pm' => $request->humidity_pm,
                'remarks' => $request->remarks,
                'analyst' => $request->analyst,
                'checked_by' => $request->checked_by,
                'updated_at' => now(),
            ]);

        if (!$updated) {
            return redirect()->back()->with('warning', 'No changes were made.');
        }

        return redirect()->route('environmental_plan/index')->with('success', 'Environmental Condition Form updated successfully.');
    }
    public function deleteEnvi($id){
        return view('confirm-delete', ['id'=> $id]);
    }

    public function hardDelete_environmental($id){
        try{
            $envi = DB::table('environmental_plans')->where('id',$id)->delete();
            // ActivityLog::create([
            //     'user_id' => Auth::user()->id,
            //     'activity' => 'Deleted the User Name'. $user->f_name . '' .  $user->l_name,
            //     'time' => now('Asia/Manila'),
            //     'date' => now()->toDateString(), 
            // ]);
            return redirect()->route('environmental_plan/index')->with('success', 'Environmental Condition Form Deleted Successfully!');
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response()->json(['error' => 'client not found'], 404);
        }
        catch(\Exception $e){
            return response()->json(['error'=> 'An error occured while deleting the Environmental Condition Form'], 500);
        }
    } 
    public function downloadPdfEnvironmental(Request $request)
    {
        $request->validate([
            'laboratory_name' => 'required|string'
        ]);

        $laboratoryName = $request->laboratory_name;

        $records = DB::table('environmental_plans')
            ->where('laboratory_name', $laboratoryName)
            ->orderBy('date', 'asc')
            ->get();

        if ($records->isEmpty()) {
            return redirect()->back()->with('error', 'No records found for the selected laboratory.');
        }

        $firstRecord = $records->first();

        $pdf = Pdf::loadView('EnvironmentalConditions.download', [
            'records' => $records,
            'laboratoryName' => $laboratoryName,
            'area' => $firstRecord->area ?? '',
            'checked_by' => $firstRecord->checked_by ?? '',
        ])->setPaper('a4', 'landscape');

        return $pdf->download('environmental-monitoring-' . str_replace(' ', '-', strtolower($laboratoryName)) . '.pdf');
    }
    public function ReportTest(){
        $clients = DB::table('clients')->get();

        $rla = DB::table('lf_06_02')
           
            ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
            ->select(
                'lf_06_02.id',
                'lf_06_02.user_id',
                'lf_06_02.RLA_no',
                'lf_06_02.payment',
                'lf_06_02.date_collected',
                'lf_06_02.sample',
                'clients.address',
                'clients.contact_no',
                'lf_06_02.source_sample',
                'lf_06_02.sample_received_by',
                'lf_06_02.service_officer',
                'lf_06_02.date_received',
                'lf_06_02.date_payment',
                'lf_06_02.or_no',
                'lf_06_02.remarks',
                'lf_06_02.status',
                'clients.company_name'
            )->orderBy('lf_06_02.id', 'desc')
             ->where('lf_06_02.status',8)
            ->paginate(10);

        return view('ReportTest.index', compact('clients', 'rla'));
    }
    //analyst worksheet
    public function analyst_worksheet()
    {
        $clients = DB::table('clients')->get();

        $userRole = Auth::user()->role;

        $query = DB::table('lf_06_02')
            ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
            ->select(
                'lf_06_02.id',
                'lf_06_02.user_id',
                'lf_06_02.RLA_no',
                'lf_06_02.payment',
                'lf_06_02.date_collected',
                'lf_06_02.sample',
                'clients.address',
                'clients.contact_no',
                'lf_06_02.source_sample',
                'lf_06_02.sample_received_by',
                'lf_06_02.service_officer',
                'lf_06_02.date_received',
                'lf_06_02.date_payment',
                'lf_06_02.or_no',
                'lf_06_02.remarks',
                'lf_06_02.status',
                'clients.company_name',
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(lf_06_02.sample_description, '$[0]')) as sample_desc"),
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(lf_06_02.lab_unit, '$[0]')) as lab_unit")
            );
   
        if ($userRole == 2 || $userRole == 4) { 
            $query->whereRaw("JSON_CONTAINS(lf_06_02.lab_unit, '\"FIS\"')");
        } elseif ($userRole == 3) {
            $query->whereRaw("JSON_CONTAINS(lf_06_02.lab_unit, '\"MIC\"')");
        } elseif ($userRole == 7) {
            $query->whereRaw("JSON_CONTAINS(lf_06_02.lab_unit, '\"CHEM\"')");
        } elseif ($userRole == 0) {
            
        } else {
      
            $query->whereRaw("1 = 0");
        }

        $rla = $query->orderBy('lf_06_02.id', 'desc')->paginate(10);

        return view('analyst_worksheet.LF-W01-MIC-03', compact('clients', 'rla'));
    }
    public function create($id)
    {
        $rla = DB::table('lf_06_02')
            ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
            ->select(
                'lf_06_02.*',
                'clients.company_name',
                'clients.address',
                'clients.contact_no'
            )
            ->where('lf_06_02.id', $id)
            ->first();

        if (!$rla) {
            return back()->with('error', 'RLA not found.');
        }

        $labUnits = json_decode($rla->lab_unit ?? '[]', true);
        $analysisDescriptions = json_decode($rla->analysis_description ?? '[]', true);

        $labUnit = is_array($labUnits)
            ? ($labUnits[0] ?? '')
            : ($rla->lab_unit ?? '');

        $analysisDescription = is_array($analysisDescriptions)
            ? ($analysisDescriptions[0] ?? '')
            : ($rla->analysis_description ?? '');

        $labUnit = strtoupper(trim($labUnit));
        $analysisDescription = strtoupper(trim($analysisDescription));

        $view = null;
        $worksheet = null;
        /*
        |--------------------------------------------------------------------------
        | FIS WORKSHEETS
        |--------------------------------------------------------------------------
        */
        if ($labUnit === 'FIS') {
            if ($analysisDescription === 'PCR') {
                $view = 'Fis_worksheet.PCR';
                $worksheet = DB::table('pcr_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                /*
                    Puhon kung naa na kay PCR table:
                    $worksheet = DB::table('pcr_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                */

            } elseif ($analysisDescription === 'PARASITOLOGICAL EXAMINATION') {
                $view = 'Fis_worksheet.paragross';

                /*
                    Puhon:
                    $worksheet = DB::table('parasitological_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                */
                $worksheet = DB::table('paragross_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
            } elseif ($analysisDescription === 'GROSS EXAMINATION') {
                 $view = 'Fis_worksheet.paragross';
                 $worksheet = DB::table('paragross_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                /*
                    Puhon:
                    $worksheet = DB::table('gross_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                */
            }
        }
        /*
        |--------------------------------------------------------------------------
        | CHEM WORKSHEETS
        |--------------------------------------------------------------------------
        */
        elseif ($labUnit === 'CHEM') {
            if ($analysisDescription === 'HISTAMINE') {
                $view = 'Chem_worksheet.histamine';
                $worksheet = DB::table('histamine_worksheets')
                
                    ->where('lf_06_02_id', $id)
                    ->first();
        

            } elseif ($analysisDescription === 'MOISTURE CONTENT') {
                $view = 'Chem_worksheet.moisture';

                /*
                    Puhon:
                    $worksheet = DB::table('moisture_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                */
                 $worksheet = DB::table('moisture_worksheets')
                    ->where('lf_06_02_id', $id)
                    ->first();
            } elseif ($analysisDescription === 'WATER QUALITY') {
                $view = 'Chem_worksheet.waterquality';

                /*
                    Mao ni imong giuna karon.
                    Automatic retrieve saved water quality worksheet for this RLA.
                */
                $worksheet = DB::table('water_quality_worksheets')
                    ->where('lf_06_02_id', $id)
                    ->first();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | MICRO WORKSHEETS
        |--------------------------------------------------------------------------
        */
        elseif ($labUnit === 'MICRO' || $labUnit === 'MIC') {
            if ($analysisDescription === 'FISH AND FISHERY PRODUCTS') {
                $view = 'Micro_worksheet.fish_product';

                /*
                    Puhon:
                    $worksheet = DB::table('micro_fish_product_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                */
                $worksheet = DB::table('fish_fishery_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
            } elseif ($analysisDescription === 'WATER POTABILITY') {
                $view = 'Micro_worksheet.waterpotability';

                /*
                    Puhon:
                    $worksheet = DB::table('water_potability_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                */
                $worksheet = DB::table('water_potability_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
            } elseif ($analysisDescription === 'WATER BACTERIOLOGY') {
                $view = 'Micro_worksheet.bacteriology';

                /*
                    Puhon:
                    $worksheet = DB::table('water_bacteriology_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                */
                $worksheet = DB::table('water_bacteriology_worksheets')
                    ->where('lf_06_02_id', $id)
                    ->first();
            }
        }

        if (!$view) {
            return back()->with(
                'error',
                'No worksheet found for Lab Unit: ' . $labUnit . ' and Analysis Description: ' . $analysisDescription
            );
        }

        if (!view()->exists($view)) {
            return back()->with('error', 'Worksheet blade file does not exist: ' . $view);
        }

        /*
            Users for signature dropdown.
            Ayaw na pag-query sa users sulod sa Blade.
        */
        $users = DB::table('users')
            ->orderBy('f_name', 'asc')
            ->get();

        return view($view, compact(
            'rla',
            'labUnit',
            'analysisDescription',
            'worksheet',
            'users'
        ));
    }   

    // public function analyst_worksheet(){
    //     $clients = DB::table('clients')->get();

    //     $rla = DB::table('lf_06_02')
    //         ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
    //         ->select(
    //             'lf_06_02.id',
    //             'lf_06_02.user_id',
    //             'lf_06_02.RLA_no',
    //             'lf_06_02.payment',
    //             'lf_06_02.date_collected',
    //             'lf_06_02.sample',
    //             'clients.address',
    //             'clients.contact_no',
    //             'lf_06_02.source_sample',
    //             'lf_06_02.sample_received_by',
    //             'lf_06_02.service_officer',
    //             'lf_06_02.date_received',
    //             'lf_06_02.date_payment',
    //             'lf_06_02.or_no',
    //             'lf_06_02.remarks',
    //             'lf_06_02.status',
    //             'clients.company_name',
    //             DB::raw("JSON_UNQUOTE(JSON_EXTRACT(lf_06_02.sample_description, '$[0]')) as sample_desc"),
    //             DB::raw("JSON_UNQUOTE(JSON_EXTRACT(lf_06_02.lab_unit, '$[0]')) as lab_unit")
    //         )->orderBy('lf_06_02.id', 'desc')
    //         ->get();

    //     return view('analyst_worksheet.LF-W01-MIC-03',compact('clients', 'rla'));
    // }
    // public function analysis_worksheet_create($id)
    // {
    //     $rla = DB::table('lf_06_02')->where('id', $id)->first();

    //     $labCodes = json_decode($rla->laboratory_code, true);
    //     $firstLabCode = is_array($labCodes) ? ($labCodes[0] ?? null) : null;

    //     $worksheet = DB::table('lf_w01_mic_03')
    //         ->where('lf_06_02_id', $id)
    //         ->first();

    //     return view('analyst_worksheet.create', compact(
    //         'rla',
    //         'firstLabCode',
    //         'id',
    //         'worksheet'
    //     ));
    // }
    
    // public function analysis_worksheet_store(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'RLA_no' => 'nullable|string',
    //         'laboratory_code' => 'nullable|string',
    //         'date_started' => 'nullable|date',
    //         'time_started' => 'nullable',
    //         'date_finish' => 'nullable|date',
    //         'time_finish' => 'nullable',

    //         'aerobic_plate_count_result' => 'nullable|string',
    //         'total_col_count_result' => 'nullable|string',
    //         'fecal_col_count_result' => 'nullable|string',
    //         'esc_coli_count_result' => 'nullable|string',
    //         'staphy_aureus_count_result' => 'nullable|string',
    //         'salmonella_result' => 'nullable|string',
    //         'shigella_result' => 'nullable|string',
    //         'formula' => 'nullable|string',
    //     ]);

    //     $validated['lf_06_02_id'] = $id;
    //     $validated['updated_at'] = now();

    //     DB::table('lf_w01_mic_03')->updateOrInsert(
    //         ['lf_06_02_id' => $id],
    //         array_merge($validated, [
    //             'created_at' => DB::raw('COALESCE(created_at, NOW())'),
    //         ])
    //     );
    //      DB::table('lf_06_02')->where('id',$id)->update([
    //         'status' => 4,

    //     ]);
    //     return redirect()
    //         ->route('analysis_worksheet.create', $id)
    //         ->with('success', 'Analysis worksheet saved successfully.');
    // }

        public function downloadPdfAnalysis($id)
        {
            $rla = DB::table('lf_06_02')
                ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
                ->select(
                    'lf_06_02.*',
                    'clients.company_name',
                    'clients.address',
                    'clients.contact_no'
                )
                ->where('lf_06_02.id', $id)
                ->first();

            if (!$rla) {
                abort(404);
            }

            $labCodes = json_decode($rla->laboratory_code ?? '[]', true);
            $firstLabCode = is_array($labCodes) ? ($labCodes[0] ?? null) : null;

            $labUnits = json_decode($rla->lab_unit ?? '[]', true);
            $analysisDescriptions = json_decode($rla->analysis_description ?? '[]', true);

            $labUnit = is_array($labUnits)
                ? ($labUnits[0] ?? '')
                : ($rla->lab_unit ?? '');

            $analysisDescription = is_array($analysisDescriptions)
                ? ($analysisDescriptions[0] ?? '')
                : ($rla->analysis_description ?? '');

            $labUnit = strtoupper(trim($labUnit));
            $analysisDescription = strtoupper(trim($analysisDescription));

            $downloadView = null;
            $worksheet = null;

            /*
            |--------------------------------------------------------------------------
            | FIS DOWNLOAD VIEWS
            |--------------------------------------------------------------------------
            */
            if ($labUnit === 'FIS') {
                if ($analysisDescription === 'PCR') {
                    
                   $downloadView = 'Fis_worksheet.pcrdownload';
                    $worksheet = DB::table('pcr_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                } elseif ($analysisDescription === 'PARASITOLOGICAL EXAMINATION') {
                    
                    $downloadView = 'Fis_worksheet.paragrossdownload';
                    $worksheet = DB::table('paragross_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                } elseif ($analysisDescription === 'GROSS EXAMINATION') {
                    
                    $downloadView = 'Fis_worksheet.paragrossdownload';
                     $worksheet = DB::table('paragross_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                }
            }

            /*
            |--------------------------------------------------------------------------
            | CHEM DOWNLOAD VIEWS
            |--------------------------------------------------------------------------
            */
            elseif ($labUnit === 'CHEM') {
                if ($analysisDescription === 'HISTAMINE') {
                  
                     $downloadView = 'Chem_worksheet.histaminedownload';

                    $worksheet = DB::table('histamine_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                } elseif ($analysisDescription === 'MOISTURE CONTENT') {
                    
                     $downloadView = 'Chem_worksheet.moisturedownload';

                        $worksheet = DB::table('moisture_worksheets')
                            ->where('lf_06_02_id', $id)
                            ->first();
                } elseif ($analysisDescription === 'WATER QUALITY') {
                   
                    $downloadView = 'Chem_worksheet.waterqualitydownload';

                    $worksheet = DB::table('water_quality_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                }
            }

            /*
            |--------------------------------------------------------------------------
            | MICRO DOWNLOAD VIEWS
            |--------------------------------------------------------------------------
            */
            elseif ($labUnit === 'MICRO' || $labUnit === 'MIC') {
                if ($analysisDescription === 'FISH AND FISHERY PRODUCTS') {
                        $downloadView = 'Micro_worksheet.fishfisherydownload';

                        $worksheet = DB::table('fish_fishery_worksheets')
                            ->where('lf_06_02_id', $id)
                            ->first();
                } elseif ($analysisDescription === 'WATER POTABILITY') {
                       $downloadView = 'Micro_worksheet.waterpotabilitydownload';

                        $worksheet = DB::table('water_potability_worksheets')
                            ->where('lf_06_02_id', $id)
                            ->first();
                } elseif ($analysisDescription === 'WATER BACTERIOLOGY') {
                    $downloadView = 'Micro_worksheet.waterbacteriologydownload';

                    $worksheet = DB::table('water_bacteriology_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                            }
            }

            if (!$downloadView) {
                return back()->with(
                    'error',
                    'No download worksheet found for Lab Unit: ' . $labUnit . ' and Analysis Description: ' . $analysisDescription
                );
            }

            if (!view()->exists($downloadView)) {
                return back()->with('error', 'Download blade file does not exist: ' . $downloadView);
            }

            $pdf = Pdf::loadView($downloadView, compact(
                'rla',
                'firstLabCode',
                'id',
                'worksheet',
                'labUnit',
                'analysisDescription'
            ))->setPaper('a4', 'portrait');

            $displayAnalysisName = ucwords(strtolower($analysisDescription));
            $rlaNumber = $rla->RLA_no ?? $worksheet->rla_no ?? $id;

               $fileName = 'Analysis Worksheet' .' - '. $displayAnalysisName . '('. $rlaNumber . ')'. '.pdf';
            $fileName = preg_replace('/[\/\\\\:*?"<>|]/', '-', $fileName);



            return $pdf->download($fileName);
        }
        public function ReporttestdownloadPdf($id)
        {
            $rla = DB::table('lf_06_02')
                ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
                ->select(
                    'lf_06_02.*',
                    'clients.company_name',
                    'clients.address',
                    'clients.contact_no'
                )
                ->where('lf_06_02.id', $id)
                ->first();

            if (!$rla) {
                abort(404);
            }

            /*
            |--------------------------------------------------------------------------
            | JSON DECODER
            |--------------------------------------------------------------------------
            */
            $decodeJsonArray = function ($value) {
                if (empty($value)) {
                    return [];
                }

                if (is_array($value)) {
                    return $value;
                }

                $decoded = json_decode($value, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    return $decoded;
                }

                return [$value];
            };

            /*
            |--------------------------------------------------------------------------
            | SAMPLE ROWS
            |--------------------------------------------------------------------------
            */
            $laboratoryCodes = $decodeJsonArray($rla->laboratory_code ?? null);
            $sampleCodes = $decodeJsonArray($rla->sample_code ?? null);
            $sampleDescriptions = $decodeJsonArray($rla->sample_description ?? null);

            $rowCount = max(
                count($laboratoryCodes),
                count($sampleCodes),
                count($sampleDescriptions),
                1
            );

            $samples = [];

            for ($i = 0; $i < $rowCount; $i++) {
                $samples[] = [
                    'lab_code' => $laboratoryCodes[$i] ?? '',
                    'sample_code' => $sampleCodes[$i] ?? '',
                    'sample_type' => $sampleDescriptions[$i] ?? '',
                ];
            }

            $firstLabCode = $samples[0]['lab_code'] ?? '';

            /*
            |--------------------------------------------------------------------------
            | LAB UNIT AND ANALYSIS DESCRIPTION
            |--------------------------------------------------------------------------
            */
            $labUnits = $decodeJsonArray($rla->lab_unit ?? null);
            $analysisDescriptions = $decodeJsonArray($rla->analysis_description ?? null);

            $labUnit = $labUnits[0] ?? '';
            $analysisDescription = $analysisDescriptions[0] ?? '';

            $labUnit = strtoupper(trim($labUnit));
            $analysisDescription = strtoupper(trim($analysisDescription));

            /*
            |--------------------------------------------------------------------------
            | ANALYSIS REQUESTED
            | Dili fixed. Kung unsay naa sa DB, mao ra mugawas sa result columns.
            |--------------------------------------------------------------------------
            */
            $analysisRequestedRaw = $decodeJsonArray($rla->analysis_requested ?? null);

            $flattenArray = function ($items) use (&$flattenArray) {
                $result = [];

                foreach ($items as $item) {
                    if (is_array($item)) {
                        $result = array_merge($result, $flattenArray($item));
                    } else {
                        $result[] = $item;
                    }
                }

                return $result;
            };

            $analysisRequestedFlat = $flattenArray($analysisRequestedRaw);

            $analysisRequested = [];

            foreach ($analysisRequestedFlat as $item) {
                if (!empty($item)) {
                    $parts = explode(',', $item);

                    foreach ($parts as $part) {
                        $value = trim($part);

                        if ($value !== '') {
                            $analysisRequested[] = $value;
                        }
                    }
                }
            }

            $analysisRequested = array_values(array_unique($analysisRequested));

            /*
            |--------------------------------------------------------------------------
            | SELECT DOWNLOAD VIEW
            |--------------------------------------------------------------------------
            */
            $downloadView = null;
            $worksheet = null;

            if ($labUnit === 'FIS') {
                if ($analysisDescription === 'PCR') {
                    $downloadView = 'ReportTestFis.molecular';

                    $worksheet = DB::table('pcr_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();

                } elseif ($analysisDescription === 'PARASITOLOGICAL EXAMINATION') {
                    $downloadView = 'ReportTestFis.parasitological';

                    $worksheet = DB::table('paragross_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();

                } elseif ($analysisDescription === 'GROSS EXAMINATION') {
                    $downloadView = 'ReportTestFis.gross';

                    $worksheet = DB::table('paragross_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                }
            }

            elseif ($labUnit === 'CHEM') {
                if ($analysisDescription === 'HISTAMINE') {
                    $downloadView = 'ReportTestChem.histamine';

                    $worksheet = DB::table('histamine_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();

                } elseif ($analysisDescription === 'MOISTURE CONTENT') {
                    $downloadView = 'ReportTestChem.moisture';

                    $worksheet = DB::table('moisture_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();

                } elseif ($analysisDescription === 'WATER QUALITY') {
                    $downloadView = 'ReportTestChem.waterquality';

                    $worksheet = DB::table('water_quality_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                }
            }

            elseif ($labUnit === 'MICRO' || $labUnit === 'MIC') {
                if ($analysisDescription === 'FISH AND FISHERY PRODUCTS') {
                    $downloadView = 'ReportTestMic.fishfishery';

                    $worksheet = DB::table('fish_fishery_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();

                } elseif ($analysisDescription === 'WATER POTABILITY') {
                    $downloadView = 'ReportTestMic.waterpota';

                    $worksheet = DB::table('water_potability_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();

                } elseif ($analysisDescription === 'WATER BACTERIOLOGY') {
                    $downloadView = 'ReportTestMic.waterbacteriology';

                    $worksheet = DB::table('water_bacteriology_worksheets')
                        ->where('lf_06_02_id', $id)
                        ->first();
                }
            }

            if (!$downloadView) {
                return back()->with(
                    'error',
                    'No download worksheet found for Lab Unit: ' . $labUnit . ' and Analysis Description: ' . $analysisDescription
                );
            }

            if (!view()->exists($downloadView)) {
                return back()->with('error', 'Download blade file does not exist: ' . $downloadView);
            }

            /*
            |--------------------------------------------------------------------------
            | REPORT TEST NO
            |--------------------------------------------------------------------------
            */
            $year = date('y');

            $prefix = match ($labUnit) {
                'CHEM' => 'CHE',
                'MICRO', 'MIC' => 'MIC',
                'FIS' => 'FIS',
                default => abort(400, 'Invalid Lab Unit.'),
            };

            $reportNo = 'BFAR12-' . $prefix . '-' . $year . '-' . $rla->RLA_no;

            $existingReportNos = json_decode($rla->report_test_no ?? '[]', true);

            if (!is_array($existingReportNos)) {
                $existingReportNos = [];
            }

            if (!in_array($reportNo, $existingReportNos)) {
                $existingReportNos[] = $reportNo;

                DB::table('lf_06_02')
                    ->where('id', $id)
                    ->update([
                        'report_test_no' => json_encode($existingReportNos),
                        'updated_at' => now(),
                    ]);
            }

            /*
            |--------------------------------------------------------------------------
            | PDF
            |--------------------------------------------------------------------------
            */
            $pdf = Pdf::loadView($downloadView, compact(
                'rla',
                'firstLabCode',
                'samples',
                'laboratoryCodes',
                'sampleCodes',
                'sampleDescriptions',
                'analysisRequested',
                'id',
                'worksheet',
                'reportNo',
                'labUnit',
                'analysisDescription'
            ))->setPaper('a4', 'portrait');

            $displayAnalysisName = ucwords(strtolower($analysisDescription));
            $rlaNumber = $rla->RLA_no ?? $id;

            $fileName = 'Report of Test' .' - '. $displayAnalysisName . '('. $rlaNumber . ')'. '.pdf';
            $fileName = preg_replace('/[\/\\\\:*?"<>|]/', '-', $fileName);

            return $pdf->download($fileName);
        }
//   public function ReporttestdownloadPdf(Request $request)
//     {
//         $rlaId = $request->rla_id;
//         $reportType = $request->report_type;
//         $formType = $request->form_type;

//         $rla = DB::table('lf_06_02')
//             ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
//             ->select(
//                 'lf_06_02.*',
//                 'clients.company_name',
//                 'clients.address',
//                 'clients.contact_no'
//             )
//             ->where('lf_06_02.id', $rlaId)
//             ->first();

//         if (!$rla) {
//             abort(404, 'RLA record not found.');
//         }
    
//         $laboratoryCodes = json_decode($rla->laboratory_code ?? '[]', true);
//         $sampleDescriptions = json_decode($rla->sample_description ?? '[]', true);
//         $sampleCodes = json_decode($rla->sample_code ?? '[]', true);

//         $year = date('y');

//         $reportNo = match ($reportType) {
//             'CHEM' => 'BFAR12-CHE-' . $year . '-' . $rla->RLA_no,
//             'MICRO' => 'BFAR12-MIC-' . $year . '-' . $rla->RLA_no,
//             'FIS' => 'BFAR12-FIS-' . $year . '-' . $rla->RLA_no,
//             default => abort(400, 'Invalid report type.'),
//         };
//        $existingReportNos = json_decode($rla->report_test_no ?? '[]', true);

//         if (!is_array($existingReportNos)) {
//             $existingReportNos = [];
//         }

//         if (!in_array($reportNo, $existingReportNos)) {
//             $existingReportNos[] = $reportNo;
//         }

//         DB::table('lf_06_02')
//             ->where('id', $rlaId)
//             ->update([
//                 'report_test_no' => json_encode($existingReportNos),
//                 'updated_at' => now(),
//             ]);
//         $view = match ($formType) {
//             'histamine' => 'ReportTest.histamine',
//             'moisture' => 'ReportTest.moisture',
//             'physico_chem_water' => 'ReportTest.physico_chem_water',

//             'meat' => 'ReportTest.meat',
//             'water' => 'ReportTest.bacterial_water',
//             // 'bacterial_water' => 'ReportTest.bacterial_water',

//             'molecular' => 'ReportTest.molecular',
//             'gross_parasitology' => 'ReportTest.gross_parasitology',

//             default => abort(400, 'Invalid form type.'),
//         };
    
//         $filename = strtoupper($reportType) . '-' . strtoupper($formType) . '-' . $reportNo . '.pdf';

//         $pdf = Pdf::loadView($view, [
//             'rla' => $rla,
//             'reportNo' => $reportNo,
//             'laboratoryCodes' => $laboratoryCodes,
//             'sampleDescriptions' => $sampleDescriptions,
//             'sampleCodes' => $sampleCodes,
//         ])->setPaper('a4', 'portrait');
        
//         return $pdf->download($filename);
//     }
    // Releasing receiving logbook
    public function releasing() 
    {
        $clients = DB::table('clients')->get();

        $rla = DB::table('lf_06_02')
            ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
            ->leftJoin('lf_06_04', 'lf_06_02.id', '=', 'lf_06_04.lf_06_02_id')
            ->select(
                'lf_06_02.id',
                'lf_06_02.user_id',
                'lf_06_02.RLA_no',
                'lf_06_02.payment',
                'lf_06_02.date_collected',
                'lf_06_02.sample',
                'lf_06_02.source_sample',
                'lf_06_02.sample_received_by',
                'lf_06_02.service_officer',
                'lf_06_02.date_received',
                'lf_06_02.date_payment',
                'lf_06_02.or_no',
                'lf_06_02.remarks',
                'lf_06_02.status',
                'clients.company_name',
                'clients.address',
                'clients.contact_no',
                'lf_06_02.laboratory_code',
                'lf_06_02.sample_description',
                'lf_06_02.sample_code',
                'lf_06_02.report_test_no',
                'lf_06_04.date_approved_release',
                'lf_06_04.RLA_no as release_RLA_no'
            )
            ->orderBy('lf_06_02.RLA_no', 'ASC')
            ->where('lf_06_02.status', 8)
            ->paginate(20);

        $rla->getCollection()->transform(function ($item) {

            $decodeJson = function ($value) {
                if (empty($value)) {
                    return [];
                }

                $decoded = json_decode($value, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    return $decoded;
                }

                return [$value];
            };

            $item->laboratory_code = $decodeJson($item->laboratory_code);
            $item->sample_description = $decodeJson($item->sample_description);
            $item->sample_code = $decodeJson($item->sample_code);
            $item->report_test_no = $decodeJson($item->report_test_no);

            return $item;
        });

        return view('ReceivingReleasingLogbook.index', compact('rla', 'clients'));
    }
   public function downloadPdfReleasing()
    {
        $rla = DB::table('lf_06_02')
            ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
            ->leftJoin('lf_06_04', 'lf_06_02.id', '=', 'lf_06_04.lf_06_02_id')
            ->select(
                'lf_06_02.id',
                'lf_06_02.RLA_no',
                'lf_06_02.sample_received_by',
                'lf_06_02.date_received',
                'lf_06_02.or_no',
                'lf_06_02.status',
                'lf_06_02.laboratory_code',
                'lf_06_02.sample_description',
                'lf_06_02.sample_code',
                'lf_06_02.report_test_no',
                'clients.company_name',
                'lf_06_04.date_approved_release',
                
            )
            ->where('lf_06_02.status', 8)
            ->orderBy('lf_06_02.RLA_no', 'ASC')
            ->get()
            ->map(function ($item) {
                $decodeJson = function ($value) {
                    if (empty($value)) {
                        return [];
                    }

                    $decoded = json_decode($value, true);

                    return is_array($decoded) ? $decoded : [$value];
                };

                $item->laboratory_code = $decodeJson($item->laboratory_code);
                $item->sample_description = $decodeJson($item->sample_description);
                $item->sample_code = $decodeJson($item->sample_code);
                $item->report_test_no = $decodeJson($item->report_test_no);

                return $item;
            });
        $logoPath = public_path('assets/images/bfarlogo.png');
            $logoSrc = null;
            

            if (file_exists($logoPath)) {
                $logoData = base64_encode(file_get_contents($logoPath));
                $logoSrc = 'data:image/png;base64,' . $logoData;
            }
        $pdf = Pdf::loadView('ReceivingReleasingLogbook.download', [
                'rla' => $rla,
                'logoSrc' => $logoSrc,
            ])
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
            ]);

        return $pdf->download('SAMPLE RECEIVING AND RELEASING LOGBOOK.pdf');
    }
}
