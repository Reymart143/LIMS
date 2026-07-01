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
        Schema::create('equipment_maintenance_plans', function (Blueprint $table) {
            $table->id();
            $table->string('unit')->nullable();
            $table->string('equipment_code')->nullable();
            $table->string('equipment_name')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('brand_model_no')->nullable();
            $table->date('date_of_maintenance')->nullable();
            $table->string('service_report_no')->nullable();
            $table->string('maintenance_type')->nullable(); 
            $table->string('maintenance_provider')->nullable();
            $table->string('maintenance_technician')->nullable();
            $table->string('maintenance_hours')->nullable();
            $table->json('issues_reported')->nullable();
            $table->text('issue_other')->nullable();
            $table->json('actions_taken')->nullable();
            $table->text('action_other')->nullable();
            $table->text('tools_used')->nullable();
            $table->json('operational_status')->nullable();
            $table->json('equipment_status')->nullable();
            $table->date('next_maintenance_due')->nullable();
            $table->json('frequency')->nullable();
            $table->text('technician_notes')->nullable();
            $table->text('manager_feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_maintenance_plans');
    }
};
