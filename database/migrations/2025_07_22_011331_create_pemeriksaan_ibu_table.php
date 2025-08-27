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
        Schema::create('pemeriksaan_ibu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ibu_id')->constrained('ibu')->onDelete('cascade');
            $table->foreignId('bidan_id')->constrained('bidan')->onDelete('cascade');
            $table->date('tanggal_pemeriksaan');
            $table->string('keluhan')->nullable();
            $table->string('berat_badan')->nullable();
            $table->string('tinggi_badan')->nullable();
            $table->string('tekanan_darah')->nullable();
            $table->integer('usia_kehamilan')->nullable();
            $table->integer('tinggi_fundus')->nullable();
            $table->string('letak_janin')->nullable();
            $table->string('denyut_jantung_janin')->nullable();
            $table->string('keterangan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_ibu');
    }
};
