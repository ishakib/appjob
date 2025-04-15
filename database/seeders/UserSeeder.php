<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            User::factory()->create([
                'name' => $faker->name, // Use faker for the name
                'email' => $faker->unique()->safeEmail(), // Ensure unique email
                'password' => bcrypt('password'), // Set default password
            ]);
        }
    }
}
