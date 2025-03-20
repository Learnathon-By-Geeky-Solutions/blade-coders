<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MailboxFactory extends Factory
{
    public function definition(): array
    {
        return [
            'subject' => $this->faker->sentence(),
            'read' => false,
            'replied' => false,
        ];
    }
}
