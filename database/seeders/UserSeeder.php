<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 2 hand-made users + 10 factory users = 12 users.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Chris Roldan Perez',
            'email' => 'perez@kaonta.test',
            'password' => Hash::make('kaonta2026'),
        ]);

        User::create([
            'name' => 'Tita Perez',
            'email' => 'tita.perez@kaonta.test',
            'password' => Hash::make('kaonta2026'),
        ]);

        // the default UserFactory that comes with Laravel
        User::factory()->count(10)->create();
    }
}
