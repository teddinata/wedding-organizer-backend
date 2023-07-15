<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         //permission dashboard
         Permission::create(['name' => 'dashboard.index', 'guard_name' => 'web']);
         Permission::create(['name' => 'dashboard.sales_chart', 'guard_name' => 'web']);

         //permission users
         Permission::create(['name' => 'users.index', 'guard_name' => 'web']);
         Permission::create(['name' => 'users.create', 'guard_name' => 'web']);
         Permission::create(['name' => 'users.edit', 'guard_name' => 'web']);
         Permission::create(['name' => 'users.delete', 'guard_name' => 'web']);

         //permission roles
         Permission::create(['name' => 'roles.index', 'guard_name' => 'web']);
         Permission::create(['name' => 'roles.create', 'guard_name' => 'web']);
         Permission::create(['name' => 'roles.edit', 'guard_name' => 'web']);
         Permission::create(['name' => 'roles.delete', 'guard_name' => 'web']);

         //permission permissions
         Permission::create(['name' => 'permissions.index', 'guard_name' => 'web']);

        //  permission vendor
        Permission::create(['name' => 'vendors.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'vendors.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'vendors.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'vendors.delete', 'guard_name' => 'web']);

        // permission vendor limit
        Permission::create(['name' => 'vendor_limits.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'vendor_limits.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'vendor_limits.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'vendor_limits.delete', 'guard_name' => 'web']);

        // permission vendor grade
        Permission::create(['name' => 'vendor_grades.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'vendor_grades.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'vendor_grades.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'vendor_grades.delete', 'guard_name' => 'web']);

        // permission product items
        Permission::create(['name' => 'product_items.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'product_items.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'product_items.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'product_items.delete', 'guard_name' => 'web']);

        // permission product checklists
        Permission::create(['name' => 'product_checklists.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'product_checklists.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'product_checklists.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'product_checklists.delete', 'guard_name' => 'web']);

        // order event this week
        Permission::create(['name' => 'order_events.index', 'guard_name' => 'web']);

        // order list
        Permission::create(['name' => 'orders.index', 'guard_name' => 'web']);

        // invoice
        Permission::create(['name' => 'invoices.index', 'guard_name' => 'web']);

        // employee - departement
        Permission::create(['name' => 'employee_departements.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'employee_departements.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'employee_departements.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'employee_departements.delete', 'guard_name' => 'web']);

        // employee - position
        Permission::create(['name' => 'employee_positions.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'employee_positions.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'employee_positions.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'employee_positions.delete', 'guard_name' => 'web']);

        // employee teams
        Permission::create(['name' => 'employee_teams.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'employee_teams.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'employee_teams.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'employee_teams.delete', 'guard_name' => 'web']);

        // employee list
        Permission::create(['name' => 'employees.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'employees.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'employees.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'employees.delete', 'guard_name' => 'web']);

        // attendance
        Permission::create(['name' => 'attendances.index', 'guard_name' => 'web']);

        // loan management
        Permission::create(['name' => 'employee_loans.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'team_loans.index', 'guard_name' => 'web']);

        // payroll
        Permission::create(['name' => 'payrolls.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'payrolls.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'payrolls.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'payrolls.delete', 'guard_name' => 'web']);

        // rewards and redeem managements
        Permission::create(['name' => 'rewards.index', 'guard_name' => 'web']);
        // redeem list
        Permission::create(['name' => 'redeems.index', 'guard_name' => 'web']);

        // site setting
        Permission::create(['name' => 'site_settings.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'site_settings.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'site_settings.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'site_settings.delete', 'guard_name' => 'web']);


    }
}
