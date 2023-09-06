<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sales')->insert([
            [
                'name' => 'Ai Dessire',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Chandra Hosen',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Devi Sartika',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Funin',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Indah',
                'created_by' => 1,
                'created_at' => now(),
            ]
            // Tambahkan data lain sesuai kebutuhan
        ]);
    }
}
