<?php

namespace Database\Seeders;

use App\Models\PemeriksaanAnak;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemeriksaanAnakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PemeriksaanAnak::factory()->count(10)->create();
    }
}
