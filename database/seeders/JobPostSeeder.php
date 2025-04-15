<?php

namespace Database\Seeders;

use App\Models\JobPost;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Factory::create();

        $jobPosts = [];

        for ($i = 0; $i < 10; $i++) {
            $jobPosts[] = [
                'tenant_id' => 1,
                'uid' => Str::uuid()->toString(),
                'title' => $faker->jobTitle,
                'slug' => Str::slug($faker->unique()->sentence(3)),
                'description' => $faker->paragraph(3),
                'view_count' => 0,
                'application_count' => 0,
                'status' => \App\Enums\JobStatusEnum::ACTIVE->value,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('job_posts')->insert($jobPosts);
    }
}
