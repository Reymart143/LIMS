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
        Schema::create('citizen_charter_surveys', function (Blueprint $table) {
            $table->id();
            $table->string('control_no')->nullable();
            $table->string('pinuntahang_opisina')->nullable();
            $table->string('serbisyong_natanggap')->nullable();

            $table->string('uri_ng_kliyente')->nullable(); 
            // Mamamayan / Negosyo / Gobyerno

            $table->string('ikaw_ba_ay')->nullable(); 
            // Kliyente sa labas ng kawanihan / Empleyado ng BFAR

            $table->date('petsa')->nullable();
            $table->string('kasarian')->nullable(); 
            // Lalaki / Babae

            $table->integer('edad')->nullable();
            $table->string('rehiyon_ng_tirahan')->nullable();

            // Citizen Charter
            $table->boolean('cc1_alam_ko_ang_cc')->default(false);
            $table->boolean('cc1_alam_ko_hindi_ko_nakita')->default(false);
            $table->boolean('cc1_nalaman_ko_lang_ngayon')->default(false);
            $table->boolean('cc1_hindi_ko_alam')->default(false);

            $table->string('cc2_visibility')->nullable();
            // Madaling makita / Medyo madaling makita / Mahirap makita / Hindi makita / Hindi angkop

            $table->string('cc3_helpfulness')->nullable();
            // Sobrang nakatulong / Medyo nakatulong / Hindi nakatulong / Hindi angkop

            // Survey Questions - individual columns, dili JSON
            $table->tinyInteger('sqd0')->nullable();
            $table->tinyInteger('sqd1')->nullable();
            $table->tinyInteger('sqd2')->nullable();
            $table->tinyInteger('sqd3')->nullable();
            $table->tinyInteger('sqd4')->nullable();
            $table->tinyInteger('sqd5')->nullable();
            $table->tinyInteger('sqd6')->nullable();
            $table->tinyInteger('sqd7')->nullable();
            $table->tinyInteger('sqd8')->nullable();
             $table->string('language_version')->default('tagalog');
            // 1 to 5, then 0 = N/A

            $table->text('mungkahi_komento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizen_charter_surveys');
    }
};
