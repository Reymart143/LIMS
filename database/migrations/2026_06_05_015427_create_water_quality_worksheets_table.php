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
        Schema::create('water_quality_worksheets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lf_06_02_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('rla_no')->nullable();

            $table->string('date_time_started')->nullable();
            $table->string('date_time_finished')->nullable();

            $table->json('sample_code')->nullable();
            $table->json('sampling_site')->nullable();
            $table->json('analysis_requested')->nullable();
            $table->json('results')->nullable();

            $table->string('analyzed_by_1')->nullable();
            $table->string('analyzed_by_2')->nullable();
            $table->string('checked_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_quality_worksheets');
    }
};
