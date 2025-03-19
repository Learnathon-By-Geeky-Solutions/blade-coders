<?php

namespace Database\Factories;

use App\Models\EventType;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'short_brief' => $this->faker->words(3, true),
            'price' => $this->faker->numberBetween(100, 1000),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'location' => $this->faker->word(),
            'button_text' => $this->faker->text(),
            'title' => $this->faker->word(),
            'about' => $this->faker->word(),
            'youtube_link' => $this->faker->url(),
            'agenda' => ['1' => ['title' => $this->faker->word(), 'start_time' => $this->faker->dateTime()->format('Y-m-d\TH:i'), 'end_time' => $this->faker->dateTime()->format('Y-m-d\TH:i')]],
            'meeting_link' => $this->faker->url(),
            'status' => $this->faker->word(),

            'service_id' => Service::factory(),
            'event_type_id' => EventType::factory(),
        ];
    }
}
