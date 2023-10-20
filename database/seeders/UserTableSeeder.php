<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user account for super admin
        $user = User::create([
            'name'      => 'Angela Sherly',
            'email'     => 'angelasherly@goodsoneid.com',
            'password'  => bcrypt('password123'),
            'created_by'  => 1,
        ]);

        //get all permissions
        $permissions = Permission::all();

        //get role super admin
        $role = Role::find(1);

        //assign permission to role
        $role->syncPermissions($permissions);

        //assign role to user
        $user->assignRole($role);

        // user account for manager
        $user = User::create([
            'name'      => 'Manager Test',
            'email'     => 'manager@gmail.com',
            'password'  => bcrypt('password'),
            'created_by'  => 1,
        ]);

        //get all permissions
        $permissions = Permission::all();

        //get role manager
        $role = Role::find(2);

        //assign role to user
        $user->assignRole($role);

        // user account for admin vendor
        $user = User::create([
            'name'      => 'Angela Developer',
            'email'     => 'developer@goodsoneid.com',
            'password'  => bcrypt('password123'),
            'created_by'  => 1,
        ]);

        //get all permissions
        $permissions = Permission::all();

        //get role manager
        $role = Role::find(3);

        //assign role to user
        $user->assignRole($role);
    }
}
