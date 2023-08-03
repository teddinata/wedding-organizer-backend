<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorLimitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('vendor_limits')->insert([
            [
                'name' => 'Green',
                'amount_limit' => 100000000,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Yellow',
                'amount_limit' => 25000000,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Red',
                'amount_limit' => 10000000,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Black',
                'amount_limit' => 5000000,
                'created_by' => 1,
                'created_at' => now(),
            ]
            // Tambahkan data lain sesuai kebutuhan
        ]);
    }
}
