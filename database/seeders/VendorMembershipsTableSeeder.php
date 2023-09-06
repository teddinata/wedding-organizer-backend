<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorMembershipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('memberships')->insert([
            [
                'name' => 'None',
                'from' => 0,
                'until' => 9999999,
                'point' => 0,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Bronze',
                'from' => 10000000,
                'until' => 100999999,
                'point' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Silver',
                'from' => 101000000,
                'until' => 250999999,
                'point' => 2,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Gold',
                'from' => 251000000,
                'until' => 400999999,
                'point' => 3,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Platinum',
                'from' => 401000000,
                'until' => 600999999,
                'point' => 4,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Diamond',
                'from' => 601000000,
                'until' => 999999999,
                'point' => 5,
                'created_by' => 1,
                'created_at' => now(),
            ]
        ]);
    }
}
