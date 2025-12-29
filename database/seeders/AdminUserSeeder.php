<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web'
        ]);

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $managerRole = Role::firstOrCreate([
            'name' => 'manager',
            'guard_name' => 'web'
        ]);

        // Super Admin User
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'is_otp_verified' => true,
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_otp_verified' => true,
            ]
        );
        $admin->assignRole($adminRole);

        // Manager User
        $manager = User::firstOrCreate(
            ['email' => 'manager@gmail.com'],
            [
                'name' => 'Manager',
                'password' => Hash::make('password'),
                'is_otp_verified' => true,
            ]
        );
        $manager->assignRole($managerRole);
    }
}
