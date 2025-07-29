<?php

namespace Database\Factories;

use App\Models\Bidan;
use App\Models\Ibu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PemeriksaanIbu>
 */
class PemeriksaanIbuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ibu_id' => Ibu::inRandomOrder()->first()?->id ?? Ibu::factory(),
            'bidan_id' => Bidan::inRandomOrder()->first()?->id ?? Bidan::factory(),
            'tanggal_pemeriksaan' => $this->faker->date(),
            'keluhan' => $this->faker->sentence(),
            'berat_badan' => $this->faker->numberBetween(45, 90) . ' kg',
            'tinggi_badan' => $this->faker->numberBetween(145, 180) . ' cm',
            'tekanan_darah' => $this->faker->numberBetween(90, 140) . '/' . $this->faker->numberBetween(60, 90),
            'usia_kehamilan' => $this->faker->numberBetween(1, 40),
            'tinggi_fundus' => $this->faker->numberBetween(15, 40),
            'letak_janin' => $this->faker->randomElement(['Kepala di bawah', 'Melintang', 'Sungsang']),
            'denyut_jantung_janin' => $this->faker->numberBetween(120, 160) . ' bpm',
            'keterangan' => $this->faker->optional()->sentence(),
        ];
    }
}
