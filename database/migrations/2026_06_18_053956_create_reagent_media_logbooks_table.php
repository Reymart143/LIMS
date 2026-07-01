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
        Schema::create('reagent_media_logbooks', function (Blueprint $table) {
            $table->id();
            $table->string('media_batch_no')->nullable();
            $table->date('date_prepared')->nullable();
            $table->string('chemical_media')->nullable();
            $table->string('manufacturer_batch_lot_no')->nullable();
            $table->string('quantity_used')->nullable();
            $table->string('quantity_prepared')->nullable();

            $table->string('ph_required')->nullable();
            $table->string('ph_pre_sterilization')->nullable();
            $table->string('ph_post_sterilization')->nullable();

            $table->string('expiry')->nullable();
            $table->string('physical_appearance')->nullable();
            $table->string('prepared_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reagent_media_logbooks');
    }
};
