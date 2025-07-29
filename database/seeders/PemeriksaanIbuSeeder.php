<?php

namespace Database\Seeders;

use App\Models\PemeriksaanIbu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemeriksaanIbuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PemeriksaanIbu::factory()->count(10)->create();
    }
}
