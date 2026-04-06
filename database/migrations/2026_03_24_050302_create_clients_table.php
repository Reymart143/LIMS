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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('source_sample')->nullable();
            $table->string('sample_description')->nullable();
            $table->string('sample_code')->nullable();
            $table->string('analysis_requested')->nullable();
            $table->integer('status')->default(0);
            $table->string('species')->nullable();
            $table->date('date')->nullable();
            $table->string('classification')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
