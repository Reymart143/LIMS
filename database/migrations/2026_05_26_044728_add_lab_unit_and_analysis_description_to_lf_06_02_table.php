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
        Schema::table('lf_06_02', function (Blueprint $table) {
            $table->json('lab_unit')->nullable()->after('sample_code');
            $table->json('analysis_description')->nullable()->after('lab_unit');
        });
    }

    public function down(): void
    {
        Schema::table('lf_06_02', function (Blueprint $table) {
            $table->dropColumn(['lab_unit', 'analysis_description']);
        });
    }
};
