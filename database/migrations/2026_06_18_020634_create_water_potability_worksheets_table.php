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
        Schema::create('water_potability_worksheets', function (Blueprint $table) {
            $table->id();
              $table->unsignedBigInteger('lf_06_02_id')->unique();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('rla_no')->nullable();
            $table->string('lab_code')->nullable();
            $table->string('date_time_started')->nullable();
            $table->string('date_time_finished')->nullable();

            // Heterotrophic Plate Count
            $table->json('hpc_dilution')->nullable();
            $table->json('hpc_r1')->nullable();
            $table->json('hpc_r2')->nullable();

            // Positive replicates
            $table->json('ds_lst_broth')->nullable();
            $table->json('bglb_broth')->nullable();
            $table->json('ec_broth')->nullable();
            $table->json('emb_plate')->nullable();
            $table->json('ds_azide_dextrose_broth')->nullable();
            $table->json('eva_broth')->nullable();

            // Counts / notes
            $table->string('hpc_result')->nullable();
            $table->string('tube_mpn')->nullable();
            $table->text('note')->nullable();
            $table->string('total_coliform_count')->nullable();
            $table->string('fecal_coliform_count')->nullable();
            $table->string('e_coli_count')->nullable();
            $table->string('enterococci_count')->nullable();

            // QC Results
            $table->json('qc_negative')->nullable();
            $table->json('qc_positive')->nullable();
            $table->json('qc_remarks')->nullable();

            // Bottom details
            $table->string('culture_media_batch_no')->nullable();
            $table->string('air_control')->nullable();
            $table->string('isolation_room')->nullable();
            $table->string('biosafety_cabinet')->nullable();
            $table->string('medium_control')->nullable();
            $table->string('diluent_control')->nullable();

            // Confirmatory Tests
            $table->json('confirm_lab_code')->nullable();
            $table->json('gram_reaction')->nullable();
            $table->json('indole_production')->nullable();
            $table->json('voges_proskauer')->nullable();
            $table->json('methyl_red')->nullable();
            $table->json('citrate_utilization')->nullable();
            $table->json('gas_production')->nullable();
            $table->json('confirm_result')->nullable();

            $table->text('calculations')->nullable();

            $table->string('analyzed_by')->nullable();
            $table->string('checked_by')->nullable();

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
        Schema::dropIfExists('water_potability_worksheets');
    }
};
