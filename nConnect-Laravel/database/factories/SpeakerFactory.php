<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Speaker>
 */
class SpeakerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'picture' => $this->faker->imageUrl(),
            'short_desc' => $this->faker->sentence,
            'long_desc' => $this->faker->paragraph,
            'company' => $this->faker->company,
            'instagram' => $this->faker->userName,
            'linkedIn' => $this->faker->userName,
            'facebook' => $this->faker->userName,
            'twitter' => $this->faker->userName,
        ];
    }
}
