<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('faq_categories')->exists()) {
            return;
        }

        DB::table('faq_categories')->insert([
            [
                'id' => 1,
                'name' => 'General FAQs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Events FAQs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


        if (DB::table('faqs')->exists()) {
            return;
        }

        DB::table('faqs')->insert([
            [
                'faq_category_id' => 1,
                'question' => 'What is Faq',
                'answer' => "The database for a customer reviews and ratings platform must efficiently manage user information, product details, reviews, and comments. Users should be able to leave reviews and ratings for products and interact with other users' reviews through comments. The database should also support features such as user authentication, product management, and reporting.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 2,
                'question' => 'FAQ question 2',
                'answer' => "The database for a customer reviews and ratings platform must efficiently manage user information, product details, reviews, and comments. Users should be able to leave reviews and ratings for products and interact with other users' reviews through comments. The database should also support features such as user authentication, product management, and reporting.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
