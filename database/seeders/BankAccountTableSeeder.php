<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankAccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('bank_account')->insert([
            [
                'bank' => 'BCA',
                'account_holder' => 'Chandra Hosen',
                'account_number' => '757 040 2719',
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'bank' => 'BCA',
                'account_holder' => 'Lie Her Fin',
                'account_number' => '594 038 6791',
                'created_by' => 1,
                'created_at' => now(),
            ]
        ]);
    }
}
