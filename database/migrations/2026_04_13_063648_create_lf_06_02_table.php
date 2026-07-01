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
        Schema::create('lf_06_02', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('source_sample')->nullable();
            $table->string('RLA_no');
            $table->date('date_collected')->nullable();
            $table->string('sample')->nullable();
            $table->json('laboratory_code')->nullable();
            $table->json('sample_description')->nullable();
            
            $table->json('sample_code')->nullable();
            $table->json('analysis_requested')->nullable();
            $table->json('test_method')->nullable();
            $table->string('sample_received_by')->nullable();
            $table->string('service_officer')->nullable();
            $table->date('date_received')->nullable();
            $table->string('payment')->nullable();
            $table->date('date_payment')->nullable();
            $table->string('or_no')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('status')->default(0);
            $table->string('terms_accepted')->nullable();
            $table->json('report_test_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lf_06_02');
    }
};
