<?php

namespace Database\Seeders;

use App\Enums\ApplicationStatusEnum;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\JobPost;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        $applications = [];

        // Get all job posts to associate applications with them
        $jobPosts = JobPost::all();

        foreach ($jobPosts as $jobPost) {
            for ($i = 0; $i < 10; $i++) {
                $applications[] = [
                    'job_post_id' => $jobPost->id,
                    'uid' => Str::uuid()->toString(),
                    'name' => $faker->name(),
                    'email' => $faker->unique()->safeEmail(),
                    'status' => ApplicationStatusEnum::PENDING->value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('applications')->insert($applications);
    }
}
