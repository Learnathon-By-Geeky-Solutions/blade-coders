<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('languages')->exists()) {
            return;
        }

        DB::table('languages')->insert([
            [
                'locale' => 'en',
                'name' => 'English',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'locale' => 'bn',
                'name' => 'Bangla',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
