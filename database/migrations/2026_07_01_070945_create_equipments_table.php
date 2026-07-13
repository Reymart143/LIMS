<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('equipment');
            $table->string('equipment_no')->unique();
            $table->integer('qty')->default(0);
            $table->string('unit')->nullable();
            $table->string('rfl_control_no')->nullable();
            $table->text('description')->nullable();
            $table->string('brand_model')->nullable();
            $table->date('date_acquired')->nullable();
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->text('status_remarks')->nullable();
            $table->integer('received_quantity')->default(0);
            $table->integer('used_quantity')->default(0);
            $table->integer('balance_quantity')->default(0);
            $table->string('location')->nullable();
            $table->json('person_in_charge')->nullable();
            $table->text('updates')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};