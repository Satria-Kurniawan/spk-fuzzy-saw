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
        Schema::create('fuzzys', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan');
            $table->string('operator');
            $table->integer('nilai_start')->default(null);
            $table->integer('nilai_end')->default(null);
            $table->integer('nilai_persyaratan')->default(null);
            $table->float('nilai_fuzzy');
            $table->bigInteger('id_kriteria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuzzys');
    }
};
