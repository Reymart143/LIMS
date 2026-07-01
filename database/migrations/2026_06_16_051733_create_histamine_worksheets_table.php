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
        Schema::create('histamine_worksheets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lf_06_02_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('rla_no')->nullable();
            $table->dateTime('date_time_started')->nullable();
            $table->dateTime('date_time_finished')->nullable();
            $table->string('reagent_no')->nullable();
            $table->string('mass_of_standard')->nullable();

            // Calibration curve rows
            $table->json('calibration_target_concentration')->nullable();
            $table->json('calibration_actual_concentration')->nullable();
            $table->json('calibration_rfu')->nullable();

            $table->string('equation_of_line')->nullable();
            $table->string('r_value')->nullable();

            // Spiked Sample / CCV table
            $table->json('qc_label')->nullable();
            $table->json('qc_mass_sample')->nullable();
            $table->json('qc_rfu')->nullable();
            $table->json('qc_histamine_from_curve')->nullable();
            $table->json('qc_corrected_histamine')->nullable();
            $table->json('qc_histamine_on_sample')->nullable();
            $table->json('qc_average_histamine_conc')->nullable();
            $table->json('qc_remarks')->nullable();

            // Analysis of Sample table
            $table->json('sample_laboratory_code')->nullable();
            $table->json('sample_mass_sample')->nullable();
            $table->json('sample_rfu')->nullable();
            $table->json('sample_histamine_from_curve')->nullable();
            $table->json('sample_corrected_histamine')->nullable();
            $table->json('sample_histamine_on_sample')->nullable();
            $table->json('sample_average_histamine_conc')->nullable();
            $table->json('sample_remarks')->nullable();
            $table->string('calculation')->nullable();
            $table->string('analyst')->nullable();
            $table->string('analyst_2')->nullable();
            $table->string('checked_by')->nullable();
            $table->text('notes')->nullable();
            $table->string('calculated_by')->nullable();
            $table->foreign('lf_06_02_id')
                ->references('id')
                ->on('lf_06_02')
                ->onDelete('cascade');
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histamine_worksheets');
    }
};
