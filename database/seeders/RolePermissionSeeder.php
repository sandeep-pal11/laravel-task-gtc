<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Admin;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ========================================
        // 🔹 ADMIN GUARD PERMISSIONS & ROLES
        // ========================================
        $adminPermissions = [
            'view-users', 'create-users', 'edit-users', 'delete-users',
            'view-cities', 'create-cities', 'edit-cities', 'delete-cities',
            'view-states', 'create-states', 'edit-states', 'delete-states',
            'view-countries', 'create-countries', 'edit-countries', 'delete-countries',
        ];

        foreach ($adminPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin'
            ]);
        }

        // Admin Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'admin']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'admin']);

        // Super Admin ko saare permissions
        $superAdmin->syncPermissions(Permission::where('guard_name', 'admin')->get());

        // Admin ko limited permissions
        $admin->syncPermissions([
            'view-users', 'view-cities', 'view-states', 'view-countries',
            'create-cities', 'edit-cities'
        ]);

        // Manager ko kuch permissions
        $manager->syncPermissions([
            'view-users', 'create-users', 'edit-users',
            'view-cities', 'create-cities'
        ]);

        // ========================================
        // 🔹 WEB GUARD ROLES (FOR NORMAL USERS)
        // ========================================
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // ========================================
        // 🔹 CREATE DEFAULT ADMIN USERS (admin guard)
        // ========================================
        $superAdminUser = Admin::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );
        // ✅ Use setGuard() before assigning role
        $superAdminUser->guard_name = 'admin';
        $superAdminUser->assignRole('super-admin');

        $adminUser = Admin::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );
        $adminUser->guard_name = 'admin';
        $adminUser->assignRole('admin');

        $managerUser = Admin::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager User',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );
        $managerUser->guard_name = 'admin';
        $managerUser->assignRole('manager');

        // ========================================
        // 🔹 CREATE DEFAULT NORMAL USER (web guard)
        // ========================================
        $normalUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Normal User',
                'password' => bcrypt('password123'),
                'is_otp_verified' => true,
            ]
        );
        // ✅ User already has guard_name = 'web' in model
        $normalUser->assignRole('user');

        $this->command->info('✅ Roles & Permissions created successfully!');
    }
}
