<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DecorationAreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('decoration_areas')->insert([
            [
                'name' => 'Stage Area',
                'created_at' => now(),
            ],
            [
                'name' => 'Ballroom Area',
                'created_at' => now(),
            ],
            [
                'name' => 'Foyer Area',
                'created_at' => now(),
            ],
            [
                'name' => 'Lighting',
                'created_at' => now(),
            ]
            // Tambahkan data lain sesuai kebutuhan
        ]);
    }
}
