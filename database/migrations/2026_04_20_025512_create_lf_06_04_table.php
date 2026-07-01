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
        Schema::create('lf_06_04', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('lf_06_02_id')->unique();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('RLA_no')->nullable();
            $table->string('laboratory_code')->nullable();
            $table->string('sample')->nullable();

            // Receiving
            $table->date('receiving_in_date')->nullable();
            $table->time('receiving_in_time')->nullable();
            $table->date('receiving_out_date')->nullable();
            $table->time('receiving_out_time')->nullable();
            $table->string('receiving_remarks')->nullable();
            $table->string('receiving_initials')->nullable();

            // Laboratory
            $table->date('prep_in_date')->nullable();
            $table->time('prep_in_time')->nullable();
            $table->date('prep_out_date')->nullable();
            $table->time('prep_out_time')->nullable();
            $table->string('prep_results')->nullable();
            $table->string('prep_recovery')->nullable();
            $table->string('prep_initials')->nullable();
            //analysis 1
            $table->string('analysis_1')->nullable();
            $table->string('analysis_2')->nullable();
            $table->string('analysis_3')->nullable();
            $table->string('analysis_4')->nullable();
            $table->string('analysis_results')->nullable();
            $table->string('analysis_recovery')->nullable();
            $table->string('analysis_initials')->nullable();

            // analysis 2
            $table->string('name_analysis_2')->nullable();
            $table->string('analysis_2_2')->nullable();
            $table->string('analysis_2_3')->nullable();
            $table->string('analysis_2_4')->nullable();
            $table->string('analysis_2_5')->nullable();
            $table->string('analysis_results_2')->nullable();
            $table->string('analysis_recovery_2')->nullable();
            $table->string('analysis_initials_2')->nullable();

            // analysis 3
            $table->string('name_analysis_3')->nullable();
            $table->string('analysis_3_2')->nullable();
            $table->string('analysis_3_3')->nullable();
            $table->string('analysis_3_4')->nullable();
            $table->string('analysis_3_5')->nullable();
            $table->string('analysis_results_3')->nullable();
            $table->string('analysis_recovery_3')->nullable();
            $table->string('analysis_initials_3')->nullable();

            // analysis 4
            $table->string('name_analysis_4')->nullable();
            $table->string('analysis_4_2')->nullable();
            $table->string('analysis_4_3')->nullable();
            $table->string('analysis_4_4')->nullable();
            $table->string('analysis_4_5')->nullable();
            $table->string('analysis_results_4')->nullable();
            $table->string('analysis_recovery_4')->nullable();
            $table->string('analysis_initials_4')->nullable();

            // analysis 5
            $table->string('name_analysis_5')->nullable();
            $table->string('analysis_5_2')->nullable();
            $table->string('analysis_5_3')->nullable();
            $table->string('analysis_5_4')->nullable();
            $table->string('analysis_5_5')->nullable();
            $table->string('analysis_results_5')->nullable();
            $table->string('analysis_recovery_5')->nullable();
            $table->string('analysis_initials_5')->nullable();
            // analysis 6
            $table->string('name_analysis_6')->nullable();
            $table->string('analysis_6_2')->nullable();
            $table->string('analysis_6_3')->nullable();
            $table->string('analysis_6_4')->nullable();
            $table->string('analysis_6_5')->nullable();
            $table->string('analysis_results_6')->nullable();
            $table->string('analysis_recovery_6')->nullable();
            $table->string('analysis_initials_6')->nullable();

            $table->date('lab_row3_in_date')->nullable();
            $table->time('lab_row3_in_time')->nullable();
            $table->date('lab_row3_out_date')->nullable();
            $table->time('lab_row3_out_time')->nullable();
            $table->string('lab_row3_results')->nullable();
            $table->string('lab_row3_recovery')->nullable();
            $table->string('lab_row3_initials')->nullable();

            $table->date('lab_row4_in_date')->nullable();
            $table->time('lab_row4_in_time')->nullable();
            $table->date('lab_row4_out_date')->nullable();
            $table->time('lab_row4_out_time')->nullable();
            $table->string('lab_row4_results')->nullable();
            $table->string('lab_row4_recovery')->nullable();
            $table->string('lab_row4_initials')->nullable();

            $table->date('lab_row5_in_date')->nullable();
            $table->time('lab_row5_in_time')->nullable();
            $table->date('lab_row5_out_date')->nullable();
            $table->time('lab_row5_out_time')->nullable();
            $table->string('lab_row5_results')->nullable();
            $table->string('lab_row5_recovery')->nullable();
            $table->string('lab_row5_initials')->nullable();

            $table->text('remarks')->nullable();
            $table->string('checked_by')->nullable();
            $table->date('checked_date')->nullable();

            // Preparation of report
            $table->date('report_in_date')->nullable();
            $table->time('report_in_time')->nullable();
            $table->date('report_out_date')->nullable();
            $table->time('report_out_time')->nullable();
            $table->string('report_remarks')->nullable();
            $table->string('report_initials')->nullable();
            $table->date('date_approved_release')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lf_06_04');
    }
};
