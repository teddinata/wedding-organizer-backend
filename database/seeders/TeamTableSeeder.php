<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('teams')->insert([
            [
                'name' => 'Andri Team',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Japong Team',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Jono Team',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Kimen Team',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Toing Team',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Uri Team',
                'created_by' => 1,
                'created_at' => now(),
            ]
        ]);
    }
}
