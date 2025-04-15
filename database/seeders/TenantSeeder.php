<?php

namespace Database\Seeders;

use App\Enums\TenantStatusEnum;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::create([
            'uid' => (string) Str::uuid(),
            'name' => 'Default Tenant',
            'domain' => 'defaulttenant.com',
            'url' => 'https://defaulttenant.com',
            'locale' => 'en',
            'status' => TenantStatusEnum::ACTIVE->value
        ]);
    }
}
