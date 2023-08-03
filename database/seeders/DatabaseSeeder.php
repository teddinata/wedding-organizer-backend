<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ChecklistCategoriesSeeder::class);
        $this->call(BankAccountTableSeeder::class);
        $this->call(SalesTableSeeder::class);
        $this->call(VendorGradesTableSeeder::class);
        $this->call(VendorLimitsTableSeeder::class);
        $this->call(VendorMembershipsTableSeeder::class);
        $this->call(DecorationAreaTableSeeder::class);
    }
}
