<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */
        $permissions = [
            'dashboard.view',

            // USERS
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // COUNTRIES
            'countries.view',
            'countries.create',
            'countries.edit',
            'countries.delete',

            // STATES
            'states.view',
            'states.create',
            'states.edit',
            'states.delete',

            // CITIES
            'cities.view',
            'cities.create',
            'cities.edit',
            'cities.delete',

            // ✅ TASKS (NEW)
            'tasks.view',
            'tasks.create',
            'tasks.edit',
            'tasks.delete',
            'tasks.work_update',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */
        $superAdmin = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $manager = Role::firstOrCreate([
            'name' => 'manager',
            'guard_name' => 'web',
        ]);

        $user = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ASSIGN PERMISSIONS
        |--------------------------------------------------------------------------
        */

        // 🔥 Super Admin → ALL permissions
        $superAdmin->syncPermissions(Permission::all());

        // ✅ Admin permissions
        $admin->syncPermissions([
            'dashboard.view',

            'users.view',
            'users.create',
            'users.edit',

            'countries.view',
            'countries.create',
            'countries.edit',
            'countries.delete',

            'states.view',
            'states.create',
            'states.edit',
            'states.delete',

            'cities.view',
            'cities.create',
            'cities.edit',
            'cities.delete',

            // TASKS (ADMIN)
            'tasks.view',
            'tasks.create',
            'tasks.edit',
            'tasks.delete',
        ]);

        // ✅ Manager permissions
        $manager->syncPermissions([
            'dashboard.view',

            'countries.view',
            'countries.create',

            'states.view',
            'states.create',

            'cities.view',
            'cities.create',
            // 🔥 TASKS 
            'tasks.view',
            'tasks.create',
            'tasks.edit',
            'tasks.delete',
        ]);

        // ✅ User permissions
        $user->syncPermissions([
            'tasks.view',
            'tasks.work_update',
        ]);
    }
}
