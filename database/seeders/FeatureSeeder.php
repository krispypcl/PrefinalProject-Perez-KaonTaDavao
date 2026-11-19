<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * The 5 required features plus Free WiFi as my extra choice.
     */
    public function run(): void
    {
        $features = ['Suki ni Perez', 'Budget Meal', 'Halal', 'Open 24 Hours', 'Aircon', 'Free WiFi'];

        foreach ($features as $name) {
            Feature::create(['name' => $name]);
        }
    }
}
