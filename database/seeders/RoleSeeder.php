<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['id'=>1, 'name'=>'Super Admin', 'slug'=>'super-admin'],
            ['id'=>2, 'name'=>'Admin',       'slug'=>'admin'],
            ['id'=>3, 'name'=>'Manager',     'slug'=>'manager'],
            ['id'=>4, 'name'=>'User',        'slug'=>'user'],
        ]);
    }
}
