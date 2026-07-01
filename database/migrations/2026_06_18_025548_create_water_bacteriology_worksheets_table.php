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
        Schema::create('water_bacteriology_worksheets', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('lf_06_02_id')->unique();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('rla_no')->nullable();
            $table->string('lab_code')->nullable();
            $table->string('sample_type')->nullable();
            $table->string('date_started')->nullable();
            $table->string('date_finished')->nullable();

            $table->json('test_name')->nullable();

            $table->json('dilution_100_r1')->nullable();
            $table->json('dilution_100_r2')->nullable();

            $table->json('dilution_101_r1')->nullable();
            $table->json('dilution_101_r2')->nullable();

            $table->json('dilution_102_r1')->nullable();
            $table->json('dilution_102_r2')->nullable();

            $table->json('dilution_103_r1')->nullable();
            $table->json('dilution_103_r2')->nullable();

            $table->json('results')->nullable();

            $table->string('batch_no_prepared_culture_media')->nullable();
            $table->string('air_control')->nullable();
            $table->string('medium_control_tcbs')->nullable();
            $table->string('diluent_sterile_sea_water')->nullable();

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
        Schema::dropIfExists('water_bacteriology_worksheets');
    }
};
