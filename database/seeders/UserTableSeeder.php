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
        $user = User::create([
            'name'      => 'Administrator',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('password'),
        ]);

        //get all permissions
        $permissions = Permission::all();

        //get role super admin
        $role = Role::find(1);

        //assign permission to role
        $role->syncPermissions($permissions);

        //assign role to user
        $user->assignRole($role);

        // user create for manager
        $user = User::create([
            'name'      => 'Chandra',
            'email'     => 'manager@gmail.com',
            'password'  => bcrypt('password'),
        ]);

        //get role manager
        $role = Role::find(2);

        //assign role to user
        $user->assignRole($role);
    }
}
