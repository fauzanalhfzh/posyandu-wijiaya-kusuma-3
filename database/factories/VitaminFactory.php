<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vitamin>
 */
class VitaminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jenis_vitamin' => $this->faker->randomElement([
                'Vitamin A',
                'Vitamin B1',
                'Vitamin B6',
                'Vitamin B12',
                'Vitamin C',
                'Vitamin D',
                'Vitamin E'
            ]),
            'keterangan' => $this->faker->optional()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
