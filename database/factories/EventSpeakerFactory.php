<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventSpeakerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'designation' => $this->faker->word(),
            'about' => $this->faker->word(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
