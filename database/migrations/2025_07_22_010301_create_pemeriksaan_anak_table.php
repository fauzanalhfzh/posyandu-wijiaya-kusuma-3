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
        Schema::create('pemeriksaan_anak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anak')->onDelete('cascade');
            $table->foreignId('bidan_id')->constrained('bidan')->onDelete('cascade');
            $table->foreignId('imunisasi_id')->constrained('imunisasi')->onDelete('cascade');
            $table->foreignId('vitamin_id')->constrained('vitamin')->onDelete('cascade');
            $table->date('tanggal_pemeriksaan');
            $table->integer('usia_balita');
            $table->integer('berat_badan');
            $table->string('saran')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_anak');
    }
};
