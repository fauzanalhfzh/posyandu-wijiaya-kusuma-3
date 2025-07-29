<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Imunisasi>
 */
class ImunisasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jenis_imunisasi' => $this->faker->randomElement([
                'BCG',
                'DPT-HB-Hib',
                'Polio',
                'Campak',
                'Hepatitis B',
                'COVID-19',
                'MR (Measles Rubella)',
            ]),
            'keterangan' => $this->faker->optional()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
