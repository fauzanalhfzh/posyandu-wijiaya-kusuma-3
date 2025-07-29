<?php

namespace Database\Factories;

use App\Models\Anak;
use App\Models\Bidan;
use App\Models\Imunisasi;
use App\Models\Vitamin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PemeriksaanAnak>
 */
class PemeriksaanAnakFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'anak_id' => Anak::inRandomOrder()->first()?->id ?? Anak::factory(),
            'bidan_id' => Bidan::inRandomOrder()->first()?->id ?? Bidan::factory(),
            'imunisasi_id' => Imunisasi::inRandomOrder()->first()?->id ?? Imunisasi::factory(),
            'vitamin_id' => Vitamin::inRandomOrder()->first()?->id ?? Vitamin::factory(),

            'tanggal_pemeriksaan' => $this->faker->date(),
            'usia_balita' => $this->faker->numberBetween(0, 60), // usia dalam bulan
            'berat_badan' => $this->faker->numberBetween(5, 25), // dalam kg
            'saran' => $this->faker->optional()->sentence(),
        ];
    }
}
