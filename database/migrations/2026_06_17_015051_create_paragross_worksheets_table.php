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
        Schema::create('paragross_worksheets', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('lf_06_02_id')->unique();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('rla_no')->nullable();
            $table->string('lab_code')->nullable();

            $table->string('sample_type')->nullable();
            $table->string('date_started')->nullable();
            $table->string('date_finished')->nullable();

            $table->string('test_method')->nullable();
            $table->json('objective_used')->nullable();

            $table->string('length_cm')->nullable();
            $table->text('result')->nullable();
            $table->text('remarks')->nullable();

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
        Schema::dropIfExists('paragross_worksheets');
    }
};
