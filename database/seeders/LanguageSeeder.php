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
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'locale' => 'bn',
                'name' => 'Bangla',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
