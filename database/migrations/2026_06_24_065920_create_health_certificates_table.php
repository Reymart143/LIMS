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
        Schema::create('health_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('rla_no');
            $table->string('health_certificate_no')->nullable();
            $table->string('interpretation')->nullable();

            // I. Consignor
            $table->string('shipper_name')->nullable();
            $table->text('shipper_address')->nullable();
            $table->string('company_facility_name')->nullable();
            $table->text('company_facility_address')->nullable();
            $table->string('shipper_telephone')->nullable();
            $table->string('shipper_registration_no')->nullable();

            // II. Commodity
            $table->string('commodity_description')->nullable();
            $table->string('scientific_name')->nullable();
            $table->string('quantity')->nullable();
            $table->string('location_of_source')->nullable();
            $table->string('wild_caught_culture')->nullable();
            $table->string('tank_number')->nullable();
            $table->string('pond_cage_number')->nullable();

            // III. Consignee
            $table->string('consignee_name')->nullable();
            $table->text('consignee_address')->nullable();
            $table->string('consignee_registration_no')->nullable();
            $table->string('consignee_telephone')->nullable();

            // IV. Shipment Details
            $table->string('place_of_loading')->nullable();
            $table->text('loading_address')->nullable();
            $table->date('date_of_departure')->nullable();
            $table->string('means_of_transport')->nullable();
            $table->string('port_of_destination')->nullable();

            // V. Declaration
            $table->string('sample_code')->nullable();
            $table->string('result')->nullable();
            $table->string('disease_toxin_microbes')->nullable();
            $table->date('analysis_date')->nullable();
            $table->string('issued_at')->nullable();
            $table->date('issued_date')->nullable();
            $table->string('certifying_officer')->nullable();
            $table->string('certifying_officer_position')->nullable();

            // Fees / OR Details
            $table->decimal('fees_collected', 10, 2)->nullable();
            $table->string('or_no')->nullable();
            $table->date('or_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_certificates');
    }
};
