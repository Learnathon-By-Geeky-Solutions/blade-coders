<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MediaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'type' => $this->faker->word(),
            'mediable_id' => $this->faker->word(),
            'mediable_type' => $this->faker->word(),
            'size' => $this->faker->word(),
            'mime_type' => $this->faker->word(),
            'path' => $this->faker->word(),
            'filename' => $this->faker->word(),
        ];
    }
}
