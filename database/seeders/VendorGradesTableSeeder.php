<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorGradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('vendor_grades')->insert([
            [
                'name' => 'Priority',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Grade A',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Grade B',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Grade C',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'No Grade',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Catering',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'WO & EO',
                'created_by' => 1,
                'created_at' => now(),
            ]
            // Tambahkan data lain sesuai kebutuhan
        ]);
    }
}
