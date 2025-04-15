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
            'uid' => '1e8f0e7a-77dc-4151-be08-9e98350c780b',
            'name' => 'Default Tenant',
            'domain' => 'defaulttenant.com',
            'url' => 'https://defaulttenant.com',
            'locale' => 'en',
            'status' => TenantStatusEnum::ACTIVE->value
        ]);
    }
}
