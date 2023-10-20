<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            [
                'name' => 'Office',
                'payroll_type' => 2,
                'is_has_schedule' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Operational',
                'payroll_type' => 1,
                'is_has_schedule' => 0,
                // 'clock_in' => '13:00',
                // 'clock_out' => '19:00',
                'created_by' => 1,
                'created_at' => now(),
            ]
            // Tambahkan data lain sesuai kebutuhan
        ]);
    }
}
