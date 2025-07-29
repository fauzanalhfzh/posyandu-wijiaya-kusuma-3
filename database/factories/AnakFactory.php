<?php

namespace Database\Factories;

use App\Models\Ibu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anak>
 */
class AnakFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ibu_id' => Ibu::inRandomOrder()->first()->id ?? Ibu::factory(), // pastikan ibu ada
            'nama_lengkap' => $this->faker->name(),
            'tgl_lahir' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
