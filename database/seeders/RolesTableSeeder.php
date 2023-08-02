<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Manager']);
        Role::create(['name' => 'Admin Vendor']);
        Role::create(['name' => 'Coordinator']);
        Role::create(['name' => 'PIC']);
        Role::create(['name' => 'Tukang']);
    }
}
