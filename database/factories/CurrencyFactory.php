<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'label' => $this->faker->word(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
