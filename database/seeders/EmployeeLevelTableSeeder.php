<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employee_levels')->insert([
            [
                'name' => 'Intern',
                'from' => 0,
                'until' => 25,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Junior',
                'from' => 26,
                'until' => 50,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Senior',
                'from' => 51,
                'until' => 100,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Pro',
                'from' => 101,
                'until' => 200,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Maestro',
                'from' => 201,
                'until' => 300,
                'created_by' => 1,
                'created_at' => now(),
            ]
        ]);
    }
}
