<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CareerLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('career_levels')->insert([
            [
                'career_level' => 'Supervisor',
                'description' => 'Supervisor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'career_level' => 'Manager',
                'description' => 'Manager',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'career_level' => 'Staff',
                'description' => 'Staff',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            // Tambahkan data lain sesuai kebutuhan
        ]);
    }
}
