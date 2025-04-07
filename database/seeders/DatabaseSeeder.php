<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
           "email" => "admin@shop.com",
           "password" => "shop2015",
           "role" => "ADMIN"
        ]);

        Category::create([
           "name" => "Электроника"
        ]);

        Category::create([
            "name" => "Одежда",
            "description" => "Все что связанно с одеждой. Верхняя , нижняя одежда, обувь и т. д."
        ]);
    }
}
