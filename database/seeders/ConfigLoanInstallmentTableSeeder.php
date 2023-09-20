<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigLoanInstallmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('config_loan_installments')->insert([
            [
                'nominal' => 100000,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'nominal' => 150000,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'nominal' => 200000,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'nominal' => 250000,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'nominal' => 300000,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'nominal' => 350000,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'nominal' => 400000,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'nominal' => 450000,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'nominal' => 500000,
                'created_by' => 1,
                'created_at' => now(),
            ]
            // Tambahkan data lain sesuai kebutuhan
        ]);
    }
}
