<?php

namespace Database\Seeders;

use App\Models\Vitamin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VitaminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vitamin::factory()->count(10)->create();
    }
}
