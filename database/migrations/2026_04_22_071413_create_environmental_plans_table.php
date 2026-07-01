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
        Schema::create('environmental_plans', function (Blueprint $table) {
            $table->id();
            $table->string('area')->nullable();
            $table->string('laboratory_name')->nullable();

            $table->date('date')->nullable();

            $table->decimal('temperature_am', 5, 2)->nullable();
            $table->decimal('temperature_pm', 5, 2)->nullable();

            $table->decimal('humidity_am', 5, 2)->nullable();
            $table->decimal('humidity_pm', 5, 2)->nullable();

            $table->text('remarks')->nullable();
            $table->string('analyst')->nullable();
            $table->string('checked_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('environmental_plans');
    }
};
