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
        Schema::create('lf_w01_mic_03', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lf_06_02_id')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('RLA_no')->nullable();
            $table->string('laboratory_code')->nullable();
            $table->date('date_started')->nullable();
            $table->time('time_started')->nullable();
            $table->date('date_finish')->nullable();
            $table->time('time_finish')->nullable(); 
            $table->string('aerobic_plate_count_result')->nullable();
            $table->string('total_col_count_result')->nullable();
            $table->string('fecal_col_count_result')->nullable();
            $table->string('esc_coli_count_result')->nullable(); 
            $table->string('staphy_aureus_count_result')->nullable(); 
            $table->string('salmonella_result')->nullable(); 
            $table->string('shigella_result')->nullable(); 
            $table->string('qc_result')->nullable(); 
            $table->text('formula')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lf_w01_mic_03');
    }
};
