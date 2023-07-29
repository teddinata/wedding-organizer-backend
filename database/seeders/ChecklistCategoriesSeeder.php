<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChecklistCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('checklist_categories')->insert([
            [
                'name' => 'Pohon',
                'created_at' => now(),
            ],
            [
                'name' => 'Gazebo',
                'created_at' => now(),
            ],
            [
                'name' => 'Lighting',
                'created_at' => now(),
            ],
            [
                'name' => 'Melamin',
                'created_at' => now(),
            ]
            // Tambahkan data lain sesuai kebutuhan
        ]);

    }
}
