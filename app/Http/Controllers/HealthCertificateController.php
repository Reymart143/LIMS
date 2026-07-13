<?php

namespace App\Http\Controllers;

use App\Models\HealthCertificate;
use Illuminate\Http\Request;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
 use Illuminate\Support\Facades\Auth;
class HealthCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function healthcertificate_index()
    {
        $clients = DB::table('clients')->get();

        $rla = DB::table('lf_06_02')
           
            ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
            ->leftJoin('health_certificates', 'health_certificates.rla_no', '=', 'lf_06_02.RLA_no')
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
                 'health_certificates.rla_no as health_certificate_id',
                'lf_06_02.status',
                'clients.company_name'
            )->orderBy('lf_06_02.id', 'desc')
             ->where('lf_06_02.status',8)
            ->paginate(10);

        return view('HealthCertificate.index', compact('clients', 'rla'));
    }

    /**
     * Show the form for creating a new resource.
     */
      public function create($id)
    {
        $rla = DB::table('lf_06_02')
            ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
            ->select(
                'lf_06_02.*',
                'lf_06_02.id as rla_id',
                'lf_06_02.RLA_no',
                'clients.id as client_id',
                'clients.company_name',
                'clients.address',
                'clients.contact_no'
            )
            ->where('lf_06_02.id', $id)
            ->first();

        if (!$rla) {
            abort(404);
        }

        $certificate = DB::table('health_certificates')
            ->where('rla_no', $rla->RLA_no)
            ->first();

        $sampleCodes = json_decode($rla->sample_code ?? '[]', true);

        if (!is_array($sampleCodes)) {
            $sampleCodes = [];
        }

        $firstSampleCode = $sampleCodes[0] ?? '';
        $allSampleCodes = implode(', ', $sampleCodes);

        $sampleDescriptions = json_decode($rla->sample_description ?? '[]', true);

        if (!is_array($sampleDescriptions)) {
            $sampleDescriptions = [];
        }

        $firstSampleDescription = $sampleDescriptions[0] ?? '';

        return view('HealthCertificate.create', compact(
            'rla',
            'certificate',
            'firstSampleCode',
            'allSampleCodes',
            'firstSampleDescription'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rla_no' => 'required',
            'user_id' => 'required',
        ]);

        $data = [
            'health_certificate_no' => $request->health_certificate_no,
            'interpretation' => $request->interpretation,
            'user_id' => $request->user_id,
            'rla_no' => $request->rla_no,

            'shipper_name' => $request->shipper_name,
            'shipper_address' => $request->shipper_address,
            'company_facility_name' => $request->company_facility_name,
            'company_facility_address' => $request->company_facility_address,
            'shipper_telephone' => $request->shipper_telephone,
            'shipper_registration_no' => $request->shipper_registration_no,

            'commodity_description' => $request->commodity_description,
            'scientific_name' => $request->scientific_name,
            'quantity' => $request->quantity,
            'location_of_source' => $request->location_of_source,
            'wild_caught_culture' => $request->wild_caught_culture,
            'tank_number' => $request->tank_number,
            'pond_cage_number' => $request->pond_cage_number,

            'consignee_name' => $request->consignee_name,
            'consignee_address' => $request->consignee_address,
            'consignee_registration_no' => $request->consignee_registration_no,
            'consignee_telephone' => $request->consignee_telephone,

            'place_of_loading' => $request->place_of_loading,
            'loading_address' => $request->loading_address,
            'date_of_departure' => $request->date_of_departure ?: null,
            'means_of_transport' => $request->means_of_transport,
            'port_of_destination' => $request->port_of_destination,

            'sample_code' => $request->sample_code,
            'result' => $request->result,
            'disease_toxin_microbes' => $request->disease_toxin_microbes,
            'analysis_date' => $request->analysis_date ?: null,
            'issued_at' => $request->issued_at,
            'issued_date' => $request->issued_date ?: null,
            'certifying_officer' => $request->certifying_officer,
            'certifying_officer_position' => $request->certifying_officer_position,

            'fees_collected' => $request->fees_collected ?: null,
            'or_no' => $request->or_no,
            'or_date' => $request->or_date ?: null,

            'updated_at' => now(),
        ];

        $existing = DB::table('health_certificates')
            ->where('rla_no', $request->rla_no)
            ->first();

        if ($existing) {
            DB::table('health_certificates')
                ->where('rla_no', $request->rla_no)
                ->update($data);

            $message = 'Health Certificate updated successfully.';
        } else {
            $data['created_at'] = now();

            DB::table('health_certificates')->insert($data);

            $message = 'Health Certificate saved successfully.';
        }

        return redirect()
            ->route('healthcertificate.index')
            ->with('success', $message);
    }
    public function downloadPdfHC($id)
    {
       // $id = lf_06_02 / RLA table ID

    $rla = DB::table('lf_06_02')
        ->where('id', $id)
        ->first();

    if (!$rla) {
        return back()->with('error', 'RLA not found.');
    }

    $certificate = DB::table('health_certificates')
        ->where('rla_no', $rla->RLA_no)
        ->first();
    
    if (!$certificate) {
        return back()->with('error', 'Please add Health Certificate first before downloading.');
    }

    $pdf = Pdf::loadView('HealthCertificate.download', [
        'certificate' => $certificate,
        'rla' => $rla,
    ])->setPaper('legal', 'portrait');

    return $pdf->stream('health-certificate-' . $rla->RLA_no . '.pdf');
    }
    /**
     * Store a newly created resource in storage.
     */
 
    /**
     * Display the specified resource.
     */
    public function show(HealthCertificate $healthCertificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HealthCertificate $healthCertificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HealthCertificate $healthCertificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HealthCertificate $healthCertificate)
    {
        //
    }
}
