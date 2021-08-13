<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 records of customers

        $this->call([
            UserSeeder::class,
            RealtionUserSeeder::class,
            PageSeeder::class,
            GroupSeeder::class,
            HashtagSeeder::class,
            HashtagUserSeeder::class,
            PageUserSeeder::class,
            GroupUserSeeder::class,
            LikeSeeder::class
        ]);
    }
}
