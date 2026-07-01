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
        Schema::create('lf_06_03', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lf_06_02_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('RLA_no')->nullable();
            $table->string('company_name')->nullable();
            $table->string('laboratory_code')->nullable();
            $table->json('items')->nullable();
            $table->decimal('grand_total', 12, 2)->default(0);
            $table->string('issued_by')->nullable();
            $table->date('date_issued')->nullable();
            $table->longText('signature')->nullable();
            // $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lf_06_03');
    }
};
