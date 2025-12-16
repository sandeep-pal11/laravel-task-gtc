<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Roles FIRST
        $this->call(RolePermissionSeeder::class);

        // (optional) future seeders yahan
    }
}
