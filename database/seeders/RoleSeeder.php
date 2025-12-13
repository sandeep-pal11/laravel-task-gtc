<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;   // 👈 YAHAN likhna hai

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'id' => 1,
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Admin',
                'slug' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Manager',
                'slug' => 'manager',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'User',
                'slug' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
