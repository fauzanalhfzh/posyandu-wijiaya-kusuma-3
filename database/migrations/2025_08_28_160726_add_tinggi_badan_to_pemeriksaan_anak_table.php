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
        Schema::table('pemeriksaan_anak', function (Blueprint $table) {
            $table->integer('tinggi_badan')->nullable()->after('berat_badan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeriksaan_anak', function (Blueprint $table) {
            // Menghapus kolom tinggi_badan jika migration dibatalkan
            $table->dropColumn('tinggi_badan');
        });
    }
};
