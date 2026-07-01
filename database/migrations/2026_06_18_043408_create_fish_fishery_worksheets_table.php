<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fish_fishery_worksheets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lf_06_02_id')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('rla_no', 100)->nullable();
            $table->string('lab_code', 100)->nullable();
            $table->string('sample_type', 150)->nullable();
            $table->string('date_time_started', 100)->nullable();
            $table->string('date_time_finished', 100)->nullable();
            $table->text('apc_10_1_r1')->nullable();
            $table->text('apc_10_1_r2')->nullable();
            $table->text('apc_10_2_r1')->nullable();
            $table->text('apc_10_2_r2')->nullable();
            $table->text('apc_10_3_r1')->nullable();
            $table->text('apc_10_3_r2')->nullable();
            $table->text('apc_10_4_r1')->nullable();
            $table->text('apc_10_4_r2')->nullable();
            $table->text('apc_10_5_r1')->nullable();
            $table->text('apc_10_5_r2')->nullable();
            $table->text('apc_10_6_r1')->nullable();
            $table->text('apc_10_6_r2')->nullable();
            $table->text('apc_result')->nullable();
            $table->text('tc_10_1_lst_broth')->nullable();
            $table->text('tc_10_1_bglb_broth')->nullable();
            $table->text('tc_10_2_lst_broth')->nullable();
            $table->text('tc_10_2_bglb_broth')->nullable();
            $table->text('tc_10_3_lst_broth')->nullable();
            $table->text('tc_10_3_bglb_broth')->nullable();
            $table->text('tc_result')->nullable();
            $table->text('fc_10_1_lst_broth')->nullable();
            $table->text('fc_10_1_bglb_broth')->nullable();
            $table->text('fc_10_1_ec_broth')->nullable();
            $table->text('fc_10_2_lst_broth')->nullable();
            $table->text('fc_10_2_bglb_broth')->nullable();
            $table->text('fc_10_2_ec_broth')->nullable();
            $table->text('fc_10_3_lst_broth')->nullable();
            $table->text('fc_10_3_bglb_broth')->nullable();
            $table->text('fc_10_3_ec_broth')->nullable();
            $table->text('fc_result')->nullable();
            $table->text('ecoli_10_1_lst_broth')->nullable();
            $table->text('ecoli_10_1_bglb_broth')->nullable();
            $table->text('ecoli_10_1_ec_broth')->nullable();
            $table->text('ecoli_10_1_l_emb_agar')->nullable();
            $table->text('ecoli_10_1_confirmed_tests')->nullable();
            $table->text('ecoli_10_2_lst_broth')->nullable();
            $table->text('ecoli_10_2_bglb_broth')->nullable();
            $table->text('ecoli_10_2_ec_broth')->nullable();
            $table->text('ecoli_10_2_l_emb_agar')->nullable();
            $table->text('ecoli_10_2_confirmed_tests')->nullable();
            $table->text('ecoli_10_3_lst_broth')->nullable();
            $table->text('ecoli_10_3_bglb_broth')->nullable();
            $table->text('ecoli_10_3_ec_broth')->nullable();
            $table->text('ecoli_10_3_l_emb_agar')->nullable();
            $table->text('ecoli_10_3_confirmed_tests')->nullable();
            $table->text('ecoli_result')->nullable();
            $table->text('staph_10_1_r1_03ml')->nullable();
            $table->text('staph_10_1_r2_03ml')->nullable();
            $table->text('staph_10_1_r3_04ml')->nullable();
            $table->text('staph_10_1_coagulase_test')->nullable();
            $table->text('staph_10_1_catalase_test')->nullable();
            $table->text('staph_10_2_r1_03ml')->nullable();
            $table->text('staph_10_2_r2_03ml')->nullable();
            $table->text('staph_10_2_r3_04ml')->nullable();
            $table->text('staph_10_2_coagulase_test')->nullable();
            $table->text('staph_10_2_catalase_test')->nullable();
            $table->text('staph_10_3_r1_03ml')->nullable();
            $table->text('staph_10_3_r2_03ml')->nullable();
            $table->text('staph_10_3_r3_04ml')->nullable();
            $table->text('staph_10_3_coagulase_test')->nullable();
            $table->text('staph_10_3_catalase_test')->nullable();
            $table->text('staph_result')->nullable();
            $table->text('salmonella_ph')->nullable();
            $table->text('salmonella_room_temperature')->nullable();
            $table->text('salmonella_time_started')->nullable();
            $table->text('salmonella_time_ended')->nullable();
            $table->text('salmonella_tsi_agar_slant_rv_bs_agar')->nullable();
            $table->text('salmonella_tsi_agar_slant_rv_xld_agar')->nullable();
            $table->text('salmonella_tsi_agar_slant_rv_he_agar')->nullable();
            $table->text('salmonella_tsi_agar_slant_tt_bs_agar')->nullable();
            $table->text('salmonella_tsi_agar_slant_tt_xld_agar')->nullable();
            $table->text('salmonella_tsi_agar_slant_tt_he_agar')->nullable();
            $table->text('salmonella_tsi_agar_butt_rv_bs_agar')->nullable();
            $table->text('salmonella_tsi_agar_butt_rv_xld_agar')->nullable();
            $table->text('salmonella_tsi_agar_butt_rv_he_agar')->nullable();
            $table->text('salmonella_tsi_agar_butt_tt_bs_agar')->nullable();
            $table->text('salmonella_tsi_agar_butt_tt_xld_agar')->nullable();
            $table->text('salmonella_tsi_agar_butt_tt_he_agar')->nullable();
            $table->text('salmonella_lia_butt_rv_bs_agar')->nullable();
            $table->text('salmonella_lia_butt_rv_xld_agar')->nullable();
            $table->text('salmonella_lia_butt_rv_he_agar')->nullable();
            $table->text('salmonella_lia_butt_tt_bs_agar')->nullable();
            $table->text('salmonella_lia_butt_tt_xld_agar')->nullable();
            $table->text('salmonella_lia_butt_tt_he_agar')->nullable();
            $table->text('salmonella_biochemical_rv_bs_agar')->nullable();
            $table->text('salmonella_biochemical_rv_xld_agar')->nullable();
            $table->text('salmonella_biochemical_rv_he_agar')->nullable();
            $table->text('salmonella_biochemical_tt_bs_agar')->nullable();
            $table->text('salmonella_biochemical_tt_xld_agar')->nullable();
            $table->text('salmonella_biochemical_tt_he_agar')->nullable();
            $table->text('salmonella_result')->nullable();
            $table->text('shigella_isolation_mcconkey_agar_plate')->nullable();
            $table->text('shigella_biochemical_tests_api')->nullable();
            $table->text('shigella_result')->nullable();
            $table->text('qc_apc_check')->nullable();
            $table->text('qc_apc_negative')->nullable();
            $table->text('qc_apc_positive')->nullable();
            $table->text('qc_presumptive_check')->nullable();
            $table->text('qc_presumptive_negative')->nullable();
            $table->text('qc_presumptive_positive')->nullable();
            $table->text('qc_total_coliform_check')->nullable();
            $table->text('qc_total_coliform_negative')->nullable();
            $table->text('qc_total_coliform_positive')->nullable();
            $table->text('qc_fecal_coliform_check')->nullable();
            $table->text('qc_fecal_coliform_negative')->nullable();
            $table->text('qc_fecal_coliform_positive')->nullable();
            $table->text('qc_ecoli_check')->nullable();
            $table->text('qc_ecoli_negative')->nullable();
            $table->text('qc_ecoli_positive')->nullable();
            $table->text('qc_staph_check')->nullable();
            $table->text('qc_staph_negative')->nullable();
            $table->text('qc_staph_positive')->nullable();
            $table->text('qc_salmonella_check')->nullable();
            $table->text('qc_salmonella_negative')->nullable();
            $table->text('qc_salmonella_positive')->nullable();
            $table->text('qc_shigella_check')->nullable();
            $table->text('qc_shigella_negative')->nullable();
            $table->text('qc_shigella_positive')->nullable();
            $table->text('batch_no_prepared_culture_media')->nullable();
            $table->text('air_control')->nullable();
            $table->text('medium_control')->nullable();
            $table->text('diluent_control')->nullable();
            $table->text('calculations')->nullable();
            $table->string('analyzed_by', 150)->nullable();
            $table->string('checked_by', 150)->nullable();
            $table->timestamps();
            $table->foreign('lf_06_02_id')
                ->references('id')
                ->on('lf_06_02')
                ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fish_fishery_worksheets');
    }
};
