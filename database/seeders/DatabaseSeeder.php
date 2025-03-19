<?php

namespace Database\Seeders;

use App\Models\AbilitySupport;
use App\Models\Benefit;
use App\Models\Event;
use App\Models\EventSpeaker;
use App\Models\EventType;
use App\Models\MailboxItem;
use App\Models\OurProcess;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            LanguageSeeder::class,
            SettingSeeder::class,
            CurrencySeeder::class,
            FaqSeeder::class,
        ]);

        if (! App::environment('production')) {
            Benefit::factory(10)->create();
            AbilitySupport::factory(10)->create();
            OurProcess::factory(10)->create();
            Service::factory(10)->create();
            EventSpeaker::factory(10)->create();
            EventType::factory(10)->create();
            Event::factory(10)->create();
            MailboxItem::factory(count: 20)->create();
        }
    }
}
