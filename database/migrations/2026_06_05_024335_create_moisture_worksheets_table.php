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
        Schema::create('moisture_worksheets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lf_06_02_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('rla_no')->nullable();

            $table->dateTime('date_time_started')->nullable();
            $table->dateTime('date_time_finished')->nullable();

            $table->string('method')->nullable();
            $table->string('reference')->nullable();
            $table->string('oven_temperature')->nullable();
            $table->boolean('is_actual_temperature')->default(false);
            $table->string('drying_time')->nullable();

            $table->json('laboratory_code')->nullable();
            $table->json('trial')->nullable();
            $table->json('wt_pan')->nullable();
            $table->json('wt_sample_before_drying')->nullable();
            $table->json('wt_pan_sample_after_drying')->nullable();
            $table->json('wt_sample_after_drying')->nullable();
            $table->json('wt_lost_on_drying')->nullable();
            $table->json('moisture_content')->nullable();

            $table->json('average')->nullable();
            $table->json('remarks')->nullable();

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
        Schema::dropIfExists('moisture_worksheets');
    }
};
