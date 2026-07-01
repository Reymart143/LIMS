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
        Schema::create('pcr_worksheets', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('lf_06_02_id')->unique();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('rla_no')->nullable();

            $table->json('test_method')->nullable();
            $table->json('sample_type')->nullable();

            $table->string('total_no_of_sample')->nullable();
            $table->string('analysis')->nullable();
            $table->string('date_time_started')->nullable();
            $table->string('date_time_finished')->nullable();
            $table->string('kit_lot_no')->nullable();

            // Reagent preparation
            $table->string('fish_pcr_premix')->nullable();
            $table->string('fish_pcr_premix_result')->nullable();
            $table->string('dnazyme_polymerase')->nullable();
            $table->string('dnazyme_polymerase_result')->nullable();

            $table->string('nested_pcr_premix')->nullable();
            $table->string('nested_pcr_premix_result')->nullable();
            $table->string('dnazyme_dna_polymerase')->nullable();
            $table->string('dnazyme_dna_polymerase_result')->nullable();

            $table->string('ems_ahpnd_premix')->nullable();
            $table->string('ems_ahpnd_premix_result')->nullable();
            $table->string('dnazyme_dna_polymerase_2')->nullable();
            $table->string('dnazyme_dna_polymerase_2_result')->nullable();

            $table->json('diagnosis_rla')->nullable();
            $table->json('diagnosis_lane_no')->nullable();
            $table->json('diagnosis_laboratory_code')->nullable();
            $table->json('diagnosis_50nm')->nullable();
            $table->json('diagnosis_55nm')->nullable();
            $table->json('diagnosis_result')->nullable();

            $table->string('picture')->nullable();

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
        Schema::dropIfExists('pcr_worksheets');
    }
};
