<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_categories')->insert([
            [
                'name' => 'Carpet',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Cover Gazebo',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Cover Lorong',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Customize',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Gate',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Gazebo',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Kain',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Lantai Kaca',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Lighting',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Melamin',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Modul Stage',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Pohon',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Properties',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Tangga',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Triblok',
                'created_by' => 1,
                'created_at' => now(),
            ]
        ]);
    }
}
