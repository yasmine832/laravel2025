<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\News;
use App\Models\Contact;
use App\Models\FAQCategory;
use App\Models\FAQItem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::create([
            'name' => 'admin',
            'email' => 'admin@ehb.be',
            'password' => Hash::make('Password!321'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);


        $categories = FAQCategory::factory(5)->create();

        foreach ($categories as $category) {
            for ($i = 0; $i < 4; $i++) {
                FAQItem::create([
                    'f_a_q_category_id' => $category->id,
                    'question' => fake()->sentence() . '?',
                    'answer' => fake()->paragraph(),
                ]);
            }
        }
        
        Contact::factory(15)->create();
    }
}