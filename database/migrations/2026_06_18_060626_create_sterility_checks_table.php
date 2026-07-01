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
        Schema::create('sterility_checks', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('batch_no')->nullable();
            $table->string('temperature_time_pressure')->nullable();
            $table->string('autoclave_tape')->nullable();
            $table->string('biological_indicator')->nullable();
            $table->string('checked_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sterility_checks');
    }
};
