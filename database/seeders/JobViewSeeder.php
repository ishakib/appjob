<?php

namespace Database\Seeders;

use App\Enums\JobViewEnum;
use App\Models\JobPost;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        $views = [];

        // Get all job posts to associate views
        $jobPosts = JobPost::all();

        foreach ($jobPosts as $jobPost) {
            for ($i = 0; $i < 10; $i++) {
                $views[] = [
                    'uid' => Str::uuid()->toString(),
                    'job_post_id' => $jobPost->id,
                    'ip_address' => $faker->ipv4(),
                    'status' => JobViewEnum::DRAFT->value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('job_views')->insert($views);
    }
}
