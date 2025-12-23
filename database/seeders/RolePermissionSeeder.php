<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //PERMISSIONS
     
        $permissions = [
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
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
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        //ROLES
   
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
        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        // ASSIGN PERMISSIONS

        // Super Admin ALL
        $superAdmin->syncPermissions(Permission::all());

        // Admin: Full CRUD except user delete
        $admin->syncPermissions([
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
        ]);

        // Manager  View and Create only
        $manager->syncPermissions([
            'countries.view',
            'countries.create',
            'states.view',
            'states.create',
            'cities.view',
            'cities.create',
        ]);  
    }
}
