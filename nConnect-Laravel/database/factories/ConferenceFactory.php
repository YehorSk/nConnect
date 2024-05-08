<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conference>
 */
class ConferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'year' => $this->faker->year,
            'name' => $this->faker->words(3, true),
            'address' => $this->faker->address,
            'is_current' => $this->faker->boolean(0),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'desc' => $this->faker->paragraph,
            'picture' => $this->faker->imageUrl(),
        ];
    }
}
