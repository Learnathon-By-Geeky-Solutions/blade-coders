<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OurProcessFactory extends Factory
{
    public function definition(): array
    {
        return [
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'is_active' => $this->faker->boolean(),
            'description' => $this->faker->text(),
            'name' => $this->faker->name(),
        ];
    }
}
