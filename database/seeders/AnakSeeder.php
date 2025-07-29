<?php

namespace Database\Seeders;

use App\Models\Anak;
use App\Models\Ibu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Ibu::count() < 10) {
            \App\Models\Ibu::factory()->count(10)->create();
        }

        Anak::factory()->count(100)->create();
    }
}
