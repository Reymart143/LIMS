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
        Schema::create('lf_03_05', function (Blueprint $table) {
            $table->id();
            $table->string('equipment')->nullable();
            $table->string('model')->nullable();
            $table->string('equipment_no')->nullable();
            $table->string('location')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->string('date')->nullable();
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lf_03_05');
    }
};
