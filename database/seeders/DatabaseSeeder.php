<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * The order matters because of the foreign keys:
     * districts and features first, then users, then eateries
     * (need districts + features), then reviews (need eateries + users).
     */
    public function run(): void
    {
        $this->call([
            DistrictSeeder::class,
            FeatureSeeder::class,
            UserSeeder::class,
            EaterySeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
