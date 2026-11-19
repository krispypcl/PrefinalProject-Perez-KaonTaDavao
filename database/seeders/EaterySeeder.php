<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ===== 1. My own eatery, made by hand (not with the factory) =====
        $poblacion = District::where('name', 'Poblacion')->first();
        $name = 'Carinderia ni Perez';

        $myEatery = Eatery::create([
            'district_id' => $poblacion->id,
            'name' => $name,
            'slug' => Str::slug($name), // carinderia-ni-perez
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        // the permit is created through the hasOne relationship,
        // so Laravel fills in eatery_id for us
        $myEatery->permit()->create([
            'permit_no' => 'DVO-2026-0904',
            'expires_on' => '2027-09-04', // my birthday in 2027
        ]);

        // exactly 3 dishes, created through the hasMany relationship
        $myEatery->dishes()->createMany([
            ['name' => 'Tinolang Manok', 'price' => 85.00, 'is_bestseller' => true],
            ['name' => 'Kinilaw na Tuna', 'price' => 120.00, 'is_bestseller' => false],
            ['name' => 'Durian Shake', 'price' => 75.00, 'is_bestseller' => false],
        ]);

        // sync() makes the pivot rows exactly these two features
        $featureIds = Feature::whereIn('name', ['Suki ni Perez', 'Budget Meal'])->pluck('id');
        $myEatery->features()->sync($featureIds);

        // ===== 2. 14 other eateries from the factory: 11 open + 3 closed =====
        $openEateries = Eatery::factory()->count(11)->create();
        $closedEateries = Eatery::factory()->count(3)->closed()->create();

        $factoryEateries = $openEateries->concat($closedEateries);

        foreach ($factoryEateries as $index => $eatery) {
            // 1 permit each; the first one is expired so at least one
            // eatery shows "Permit expired"
            if ($index == 0) {
                $eatery->permit()->save(Permit::factory()->expired()->make());
            } else {
                $eatery->permit()->save(Permit::factory()->make());
            }

            // 2 to 5 dishes each
            $eatery->dishes()->saveMany(Dish::factory()->count(rand(2, 5))->make());

            // 1 to 3 random features, added to the pivot with attach()
            $randomFeatures = Feature::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $eatery->features()->attach($randomFeatures);
        }
    }
}
