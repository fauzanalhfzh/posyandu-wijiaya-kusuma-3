<?php

namespace Database\Seeders;

use App\Models\Bidan;
use App\Models\Imunisasi;
use App\Models\PemeriksaanAnak;
use App\Models\User;
use App\Models\Vitamin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IbuSeeder::class,
            AnakSeeder::class,
            BidanSeeder::class,
            VitaminSeeder::class,
            ImunisasiSeeder::class,
            // PemeriksaanAnakSeeder::class,
            // PemeriksaanIbuSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
