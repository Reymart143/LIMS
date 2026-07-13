<?php

namespace App\Http\Controllers;

use App\Models\CitizenCharterSurvey;
use Illuminate\Http\Request;
use DB;

class CitizenCharterSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function download($id)
    {
        $survey = DB::table('citizen_charter_surveys')
            ->where('id', $id)
            ->first();

        if (!$survey) {
            abort(404);
        }

        $pdf = \PDF::loadView('citizen_charter_survey.download', compact('survey'))
            ->setPaper('legal', 'portrait');

        return $pdf->download('citizen-charter-survey-' . $survey->id . '.pdf');
    }
     public function index()
    {
        $surveys = DB::table('citizen_charter_surveys')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('citizen_charter_survey.index', compact('surveys'));
    }
    public function arta()
    {
        $survey = null;

        return view('citizen_charter_survey.clientsurvey', compact('survey'));
    }
    public function create()
    {
        $survey = null;

        return view('citizen_charter_survey.create', compact('survey'));
    }

    public function store(Request $request)
    {
        $this->validateSurvey($request);

        DB::table('citizen_charter_surveys')->insert($this->surveyData($request));

        return redirect()
            ->back()
            ->with('success', 'Survey successfully saved.');
    }

    public function edit($id)
    {
        $survey = DB::table('citizen_charter_surveys')
            ->where('id', $id)
            ->first();

        if (!$survey) {
            abort(404);
        }

        return view('citizen_charter_survey.create', compact('survey'));
    }

    public function update(Request $request, $id)
    {
        $existing = DB::table('citizen_charter_surveys')
            ->where('id', $id)
            ->first();

        if (!$existing) {
            abort(404);
        }

        $this->validateSurvey($request);

        DB::table('citizen_charter_surveys')
            ->where('id', $id)
            ->update($this->surveyData($request, true));

        return redirect()
            ->route('citizen-charter-survey.index')
            ->with('success', 'Survey successfully updated.');
    }

    public function destroy($id)
    {
        DB::table('citizen_charter_surveys')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('citizen-charter-survey.index')
            ->with('success', 'Survey successfully deleted.');
    }

    private function validateSurvey(Request $request)
    {
        return $request->validate([
            'control_no' => 'nullable|string|max:255',
            'pinuntahang_opisina' => 'nullable|string|max:255',
            'serbisyong_natanggap' => 'nullable|string|max:255',
            'uri_ng_kliyente' => 'nullable|string|max:255',
            'ikaw_ba_ay' => 'nullable|string|max:255',
            'petsa' => 'nullable|date',
            'kasarian' => 'nullable|string|max:255',
            'edad' => 'nullable|integer',
            'rehiyon_ng_tirahan' => 'nullable|string|max:255',

            'cc2_visibility' => 'nullable|string|max:255',
            'cc3_helpfulness' => 'nullable|string|max:255',

            'sqd0' => 'nullable|integer|min:0|max:5',
            'sqd1' => 'nullable|integer|min:0|max:5',
            'sqd2' => 'nullable|integer|min:0|max:5',
            'sqd3' => 'nullable|integer|min:0|max:5',
            'sqd4' => 'nullable|integer|min:0|max:5',
            'sqd5' => 'nullable|integer|min:0|max:5',
            'sqd6' => 'nullable|integer|min:0|max:5',
            'sqd7' => 'nullable|integer|min:0|max:5',
            'sqd8' => 'nullable|integer|min:0|max:5',

            'mungkahi_komento' => 'nullable|string',
        ]);
    }

    private function surveyData(Request $request, $isUpdate = false)
    {
        $data = [
            'control_no' => $request->control_no,
            'language_version' => $request->language_version ?? 'tagalog',

            'pinuntahang_opisina' => $request->pinuntahang_opisina,
            'serbisyong_natanggap' => $request->serbisyong_natanggap,

            'uri_ng_kliyente' => $request->uri_ng_kliyente,
            'ikaw_ba_ay' => $request->ikaw_ba_ay,
            'petsa' => $request->petsa,
            'kasarian' => $request->kasarian,
            'edad' => $request->edad,
            'rehiyon_ng_tirahan' => $request->rehiyon_ng_tirahan,

            'cc1_alam_ko_ang_cc' => $request->has('cc1_alam_ko_ang_cc') ? 1 : 0,
            'cc1_alam_ko_hindi_ko_nakita' => $request->has('cc1_alam_ko_hindi_ko_nakita') ? 1 : 0,
            'cc1_nalaman_ko_lang_ngayon' => $request->has('cc1_nalaman_ko_lang_ngayon') ? 1 : 0,
            'cc1_hindi_ko_alam' => $request->has('cc1_hindi_ko_alam') ? 1 : 0,

            'cc2_visibility' => $request->cc2_visibility,
            'cc3_helpfulness' => $request->cc3_helpfulness,

            'sqd0' => $request->sqd0,
            'sqd1' => $request->sqd1,
            'sqd2' => $request->sqd2,
            'sqd3' => $request->sqd3,
            'sqd4' => $request->sqd4,
            'sqd5' => $request->sqd5,
            'sqd6' => $request->sqd6,
            'sqd7' => $request->sqd7,
            'sqd8' => $request->sqd8,

            'mungkahi_komento' => $request->mungkahi_komento,
            'updated_at' => now(),
        ];

        if (!$isUpdate) {
            $data['created_at'] = now();
        }

        return $data;
    }
}
