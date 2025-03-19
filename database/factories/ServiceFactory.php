<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'short_brief' => $this->faker->word(),
            'price' => $this->faker->numberBetween(1000, 10000),
            'button_link' => $this->faker->url(),
            'button_text' => $this->faker->text(),
            'title' => $this->faker->word(),
            'about' => $this->faker->word(),
            'youtube_link' => $this->faker->url(),
            'status' => $this->faker->word(),
        ];
    }
}
