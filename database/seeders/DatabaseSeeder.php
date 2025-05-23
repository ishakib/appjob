<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TenantSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            CandidateSeeder::class,
            JobPostSeeder::class,
            ApplicationSeeder::class,
            JobViewSeeder::class,
        ]);
    }
}
