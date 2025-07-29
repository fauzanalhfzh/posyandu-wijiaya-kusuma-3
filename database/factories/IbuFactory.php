<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ibu>
 */
class IbuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_lengkap' => $this->faker->name('female'),
            'tgl_lahir' => $this->faker->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
            'tinggi_badan' => $this->faker->numberBetween(145, 175) . ' cm',
            'berat_badan' => $this->faker->numberBetween(45, 90) . ' kg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
