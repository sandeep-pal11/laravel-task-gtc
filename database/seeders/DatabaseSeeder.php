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
        // 🔥 PEHLE ROLES SEED KARO
        $this->call(RoleSeeder::class);

        // ❌ Koi default user yahan create NAHI karna
        // User register ya admin panel se banenge
    }
}
