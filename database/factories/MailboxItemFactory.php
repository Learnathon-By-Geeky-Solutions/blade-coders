<?php

namespace Database\Factories;

use App\Models\Mailbox;
use Illuminate\Database\Eloquent\Factories\Factory;

class MailboxItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'mailbox_id' => Mailbox::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'message' => $this->faker->paragraph(),
            'is_admin' => false,
        ];
    }
}
