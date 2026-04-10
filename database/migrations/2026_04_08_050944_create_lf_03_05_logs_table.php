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
        Schema::create('lf_03_05_logs', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_id')->nullable();
            $table->string('date')->nullable();
            $table->string('clean_equipment')->nullable();
            $table->string('check_powersupply')->nullable();
            $table->string('switchon_equipment')->nullable();
            $table->string('shutdown_equipment')->nullable();
            $table->string('preventive_maintenance')->nullable();
    
            $table->string('name_analyst')->nullable();
            $table->string('analysis')->nullable();
            $table->string('RLA_no')->nullable();
            $table->string('laboratory_code')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lf_03_05_logs');
    }
};
