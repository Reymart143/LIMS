<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class FishFisheryController extends Controller
{
    public function storeFishFisheryWorksheet(Request $request, $id)
{
    $rla = DB::table('lf_06_02')
        ->where('id', $id)
        ->first();

    if (!$rla) {
        return back()->with('error', 'RLA not found.');
    }

    $existingWorksheet = DB::table('fish_fishery_worksheets')
        ->where('lf_06_02_id', $id)
        ->first();

    $labCodes = json_decode($rla->laboratory_code ?? '[]', true) ?? [];
    $firstLabCode = is_array($labCodes) ? ($labCodes[0] ?? '') : '';

    $sampleDescriptions = json_decode($rla->sample_description ?? '[]', true) ?? [];
    $firstSampleDescription = is_array($sampleDescriptions) ? ($sampleDescriptions[0] ?? '') : '';

    $data = [
        'lf_06_02_id' => $id,
        'user_id' => $request->user_id ?? $rla->user_id,

        'rla_no' => $request->rla_no ?? $rla->RLA_no,
        'lab_code' => $request->lab_code ?? $firstLabCode,
        'sample_type' => $request->sample_type ?? $firstSampleDescription,
        'date_time_started' => $request->date_time_started,
        'date_time_finished' => $request->date_time_finished,

        /*
        |--------------------------------------------------------------------------
        | AEROBIC PLATE COUNT
        |--------------------------------------------------------------------------
        */
        'apc_10_1_r1' => $request->apc_10_1_r1,
        'apc_10_1_r2' => $request->apc_10_1_r2,
        'apc_10_2_r1' => $request->apc_10_2_r1,
        'apc_10_2_r2' => $request->apc_10_2_r2,
        'apc_10_3_r1' => $request->apc_10_3_r1,
        'apc_10_3_r2' => $request->apc_10_3_r2,
        'apc_10_4_r1' => $request->apc_10_4_r1,
        'apc_10_4_r2' => $request->apc_10_4_r2,
        'apc_10_5_r1' => $request->apc_10_5_r1,
        'apc_10_5_r2' => $request->apc_10_5_r2,
        'apc_10_6_r1' => $request->apc_10_6_r1,
        'apc_10_6_r2' => $request->apc_10_6_r2,
        'apc_result' => $request->apc_result,

        /*
        |--------------------------------------------------------------------------
        | TOTAL COLIFORM COUNT
        |--------------------------------------------------------------------------
        */
        'tc_10_1_lst_broth' => $request->tc_10_1_lst_broth,
        'tc_10_1_bglb_broth' => $request->tc_10_1_bglb_broth,
        'tc_10_2_lst_broth' => $request->tc_10_2_lst_broth,
        'tc_10_2_bglb_broth' => $request->tc_10_2_bglb_broth,
        'tc_10_3_lst_broth' => $request->tc_10_3_lst_broth,
        'tc_10_3_bglb_broth' => $request->tc_10_3_bglb_broth,
        'tc_result' => $request->tc_result,

        /*
        |--------------------------------------------------------------------------
        | FECAL COLIFORM COUNT
        |--------------------------------------------------------------------------
        */
        'fc_10_1_lst_broth' => $request->fc_10_1_lst_broth,
        'fc_10_1_bglb_broth' => $request->fc_10_1_bglb_broth,
        'fc_10_1_ec_broth' => $request->fc_10_1_ec_broth,

        'fc_10_2_lst_broth' => $request->fc_10_2_lst_broth,
        'fc_10_2_bglb_broth' => $request->fc_10_2_bglb_broth,
        'fc_10_2_ec_broth' => $request->fc_10_2_ec_broth,

        'fc_10_3_lst_broth' => $request->fc_10_3_lst_broth,
        'fc_10_3_bglb_broth' => $request->fc_10_3_bglb_broth,
        'fc_10_3_ec_broth' => $request->fc_10_3_ec_broth,

        'fc_result' => $request->fc_result,

        /*
        |--------------------------------------------------------------------------
        | E. COLI
        |--------------------------------------------------------------------------
        */
        'ecoli_10_1_lst_broth' => $request->ecoli_10_1_lst_broth,
        'ecoli_10_1_bglb_broth' => $request->ecoli_10_1_bglb_broth,
        'ecoli_10_1_ec_broth' => $request->ecoli_10_1_ec_broth,
        'ecoli_10_1_l_emb_agar' => $request->ecoli_10_1_l_emb_agar,
        'ecoli_10_1_confirmed_tests' => $request->ecoli_10_1_confirmed_tests,

        'ecoli_10_2_lst_broth' => $request->ecoli_10_2_lst_broth,
        'ecoli_10_2_bglb_broth' => $request->ecoli_10_2_bglb_broth,
        'ecoli_10_2_ec_broth' => $request->ecoli_10_2_ec_broth,
        'ecoli_10_2_l_emb_agar' => $request->ecoli_10_2_l_emb_agar,
        'ecoli_10_2_confirmed_tests' => $request->ecoli_10_2_confirmed_tests,

        'ecoli_10_3_lst_broth' => $request->ecoli_10_3_lst_broth,
        'ecoli_10_3_bglb_broth' => $request->ecoli_10_3_bglb_broth,
        'ecoli_10_3_ec_broth' => $request->ecoli_10_3_ec_broth,
        'ecoli_10_3_l_emb_agar' => $request->ecoli_10_3_l_emb_agar,
        'ecoli_10_3_confirmed_tests' => $request->ecoli_10_3_confirmed_tests,

        'ecoli_result' => $request->ecoli_result,

        /*
        |--------------------------------------------------------------------------
        | STAPHYLOCOCCUS AUREUS
        |--------------------------------------------------------------------------
        */
        'staph_10_1_r1_03ml' => $request->staph_10_1_r1_03ml,
        'staph_10_1_r2_03ml' => $request->staph_10_1_r2_03ml,
        'staph_10_1_r3_04ml' => $request->staph_10_1_r3_04ml,
        'staph_10_1_coagulase_test' => $request->staph_10_1_coagulase_test,
        'staph_10_1_catalase_test' => $request->staph_10_1_catalase_test,

        'staph_10_2_r1_03ml' => $request->staph_10_2_r1_03ml,
        'staph_10_2_r2_03ml' => $request->staph_10_2_r2_03ml,
        'staph_10_2_r3_04ml' => $request->staph_10_2_r3_04ml,
        'staph_10_2_coagulase_test' => $request->staph_10_2_coagulase_test,
        'staph_10_2_catalase_test' => $request->staph_10_2_catalase_test,

        'staph_10_3_r1_03ml' => $request->staph_10_3_r1_03ml,
        'staph_10_3_r2_03ml' => $request->staph_10_3_r2_03ml,
        'staph_10_3_r3_04ml' => $request->staph_10_3_r3_04ml,
        'staph_10_3_coagulase_test' => $request->staph_10_3_coagulase_test,
        'staph_10_3_catalase_test' => $request->staph_10_3_catalase_test,

        'staph_result' => $request->staph_result,

        /*
        |--------------------------------------------------------------------------
        | SALMONELLA
        |--------------------------------------------------------------------------
        */
        'salmonella_ph' => $request->salmonella_ph,
        'salmonella_room_temperature' => $request->salmonella_room_temperature,
        'salmonella_time_started' => $request->salmonella_time_started,
        'salmonella_time_ended' => $request->salmonella_time_ended,

        'salmonella_tsi_agar_slant_rv_bs_agar' => $request->salmonella_tsi_agar_slant_rv_bs_agar,
        'salmonella_tsi_agar_slant_rv_xld_agar' => $request->salmonella_tsi_agar_slant_rv_xld_agar,
        'salmonella_tsi_agar_slant_rv_he_agar' => $request->salmonella_tsi_agar_slant_rv_he_agar,
        'salmonella_tsi_agar_slant_tt_bs_agar' => $request->salmonella_tsi_agar_slant_tt_bs_agar,
        'salmonella_tsi_agar_slant_tt_xld_agar' => $request->salmonella_tsi_agar_slant_tt_xld_agar,
        'salmonella_tsi_agar_slant_tt_he_agar' => $request->salmonella_tsi_agar_slant_tt_he_agar,

        'salmonella_tsi_agar_butt_rv_bs_agar' => $request->salmonella_tsi_agar_butt_rv_bs_agar,
        'salmonella_tsi_agar_butt_rv_xld_agar' => $request->salmonella_tsi_agar_butt_rv_xld_agar,
        'salmonella_tsi_agar_butt_rv_he_agar' => $request->salmonella_tsi_agar_butt_rv_he_agar,
        'salmonella_tsi_agar_butt_tt_bs_agar' => $request->salmonella_tsi_agar_butt_tt_bs_agar,
        'salmonella_tsi_agar_butt_tt_xld_agar' => $request->salmonella_tsi_agar_butt_tt_xld_agar,
        'salmonella_tsi_agar_butt_tt_he_agar' => $request->salmonella_tsi_agar_butt_tt_he_agar,

        'salmonella_lia_butt_rv_bs_agar' => $request->salmonella_lia_butt_rv_bs_agar,
        'salmonella_lia_butt_rv_xld_agar' => $request->salmonella_lia_butt_rv_xld_agar,
        'salmonella_lia_butt_rv_he_agar' => $request->salmonella_lia_butt_rv_he_agar,
        'salmonella_lia_butt_tt_bs_agar' => $request->salmonella_lia_butt_tt_bs_agar,
        'salmonella_lia_butt_tt_xld_agar' => $request->salmonella_lia_butt_tt_xld_agar,
        'salmonella_lia_butt_tt_he_agar' => $request->salmonella_lia_butt_tt_he_agar,

        'salmonella_biochemical_rv_bs_agar' => $request->salmonella_biochemical_rv_bs_agar,
        'salmonella_biochemical_rv_xld_agar' => $request->salmonella_biochemical_rv_xld_agar,
        'salmonella_biochemical_rv_he_agar' => $request->salmonella_biochemical_rv_he_agar,
        'salmonella_biochemical_tt_bs_agar' => $request->salmonella_biochemical_tt_bs_agar,
        'salmonella_biochemical_tt_xld_agar' => $request->salmonella_biochemical_tt_xld_agar,
        'salmonella_biochemical_tt_he_agar' => $request->salmonella_biochemical_tt_he_agar,

        'salmonella_result' => $request->salmonella_result,

        /*
        |--------------------------------------------------------------------------
        | SHIGELLA
        |--------------------------------------------------------------------------
        */
        'shigella_isolation_mcconkey_agar_plate' => $request->shigella_isolation_mcconkey_agar_plate,
        'shigella_biochemical_tests_api' => $request->shigella_biochemical_tests_api,
        'shigella_result' => $request->shigella_result,

        /*
        |--------------------------------------------------------------------------
        | QC
        |--------------------------------------------------------------------------
        */
        'qc_apc_check' => $request->qc_apc_check,
        'qc_apc_negative' => $request->qc_apc_negative,
        'qc_apc_positive' => $request->qc_apc_positive,

        'qc_presumptive_check' => $request->qc_presumptive_check,
        'qc_presumptive_negative' => $request->qc_presumptive_negative,
        'qc_presumptive_positive' => $request->qc_presumptive_positive,

        'qc_total_coliform_check' => $request->qc_total_coliform_check,
        'qc_total_coliform_negative' => $request->qc_total_coliform_negative,
        'qc_total_coliform_positive' => $request->qc_total_coliform_positive,

        'qc_fecal_coliform_check' => $request->qc_fecal_coliform_check,
        'qc_fecal_coliform_negative' => $request->qc_fecal_coliform_negative,
        'qc_fecal_coliform_positive' => $request->qc_fecal_coliform_positive,

        'qc_ecoli_check' => $request->qc_ecoli_check,
        'qc_ecoli_negative' => $request->qc_ecoli_negative,
        'qc_ecoli_positive' => $request->qc_ecoli_positive,

        'qc_staph_check' => $request->qc_staph_check,
        'qc_staph_negative' => $request->qc_staph_negative,
        'qc_staph_positive' => $request->qc_staph_positive,

        'qc_salmonella_check' => $request->qc_salmonella_check,
        'qc_salmonella_negative' => $request->qc_salmonella_negative,
        'qc_salmonella_positive' => $request->qc_salmonella_positive,

        'qc_shigella_check' => $request->qc_shigella_check,
        'qc_shigella_negative' => $request->qc_shigella_negative,
        'qc_shigella_positive' => $request->qc_shigella_positive,

        /*
        |--------------------------------------------------------------------------
        | CONTROLS / CALCULATIONS / SIGNATURE
        |--------------------------------------------------------------------------
        */
        'batch_no_prepared_culture_media' => $request->batch_no_prepared_culture_media,
        'air_control' => $request->air_control,
        'medium_control' => $request->medium_control,
        'diluent_control' => $request->diluent_control,

        'calculations' => $request->calculations,

        'analyzed_by' => $request->analyzed_by,
        'checked_by' => $request->checked_by,

        'updated_at' => now(),
    ];

    if ($existingWorksheet) {
        DB::table('fish_fishery_worksheets')
            ->where('lf_06_02_id', $id)
            ->update($data);
    } else {
        $data['created_at'] = now();

        DB::table('fish_fishery_worksheets')
            ->insert($data);
    }

    return redirect()
        ->back()
        ->with('success', 'Fish and Fishery Products worksheet saved successfully.');
}
}
