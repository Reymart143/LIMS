<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use DB;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
    {
        $search = $request->input('search');

        $clients = DB::table('clients')
            ->when($search, function ($query, $search) {
                return $query->where('company_name', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        return view('clients.index', compact('clients'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $client = new Client();
        $client->company_name = $request->company_name;
        $client->address = $request->address;
        $client->contact_no = $request->contact_no;
        $client->source_sample = $request->source_sample;
        $client->sample_description = $request->sample_description;
        $client->sample_code = $request->sample_code;
        $client->analysis_requested = $request->analysis_requested;
        $client->species = $request->species;
        $client->date = $request->date;
        $client->classification = $request->classification;
        $client->status = 0; 
        $client->save();

        return redirect()->back()->with('success', 'Client information saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client = DB::table('clients')->where('id', $id)->first();
    
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
         $client = Client::findOrFail($request->client_id);
        // dd($client);
            $client->company_name = $request->company_name;
            $client->address = $request->address;
            $client->contact_no = $request->contact_no;
            $client->source_sample = $request->source_sample;
            $client->sample_description = $request->sample_description;
            $client->sample_code = $request->sample_code;
            $client->analysis_requested = $request->analysis_requested;
            $client->species = $request->species;
            $client->date = $request->date;
            $client->classification = $request->classification;

            if ($request->has('status')) {
                $client->status = $request->status;
            }

            $client->save();

            return redirect()->back()->with('success', 'Client information updated successfully!');
    }
    public function kiosk(){
        return view('kiosk');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function delete($id){
        return view('confirm-delete', ['id'=> $id]);
    }

    public function hardDelete($id){
        try{
            $client = Client::findOrFail($id);
            $client->delete();
            // ActivityLog::create([
            //     'user_id' => Auth::user()->id,
            //     'activity' => 'Deleted the User Name'. $user->f_name . '' .  $user->l_name,
            //     'time' => now('Asia/Manila'),
            //     'date' => now()->toDateString(), 
            // ]);
            return redirect()->route('clients')->with('success', 'Client Information Deleted Successfully!');
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response()->json(['error' => 'client not found'], 404);
        }
        catch(\Exception $e){
            return response()->json(['error'=> 'An error occured while deleting the client'], 500);
        }
    } 
    public function kiosk_forms(){
        return view('clients.kioskform');
    }
}
