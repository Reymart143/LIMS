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
        Schema::create('sample_storage_logbooks', function (Blueprint $table) {
            $table->id();
            $table->string('lab_code')->nullable();
            $table->string('sample_desc')->nullable();
            $table->date('date_received')->nullable();
            $table->date('date_stored')->nullable();
            $table->date('date_analyzed')->nullable();
            $table->date('date_disposal')->nullable();
            $table->string('disposed_by')->nullable();
            $table->string('checked_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_storage_logbooks');
    }
};
