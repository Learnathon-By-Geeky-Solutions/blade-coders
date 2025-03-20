<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AbilitySupportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
