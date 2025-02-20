<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('settings')->exists()) {
            return;
        }

        $items = [
            [
                'key' => 'app_name',
                'value' => config('app.name'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'app_locale',
                'value' => config('app.locale'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'app_timezone',
                'value' => config('app.timezone'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'pagination_limit',
                'value' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('settings')->insert($items);
    }
}
