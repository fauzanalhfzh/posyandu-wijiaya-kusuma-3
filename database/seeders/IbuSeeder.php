<?php

namespace Database\Seeders;

use App\Models\Ibu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IbuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ibu::factory()->count(50)->create();
    }
}
