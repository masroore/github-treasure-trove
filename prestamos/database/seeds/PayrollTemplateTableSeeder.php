<?php

use Illuminate\Database\Seeder;

class PayrollTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('payroll_templates')->insert([
            [

                'name' => 'Default',
                'notes' => 'Default Payroll Template',
                'picture' => 'default_payroll_template',
            ],

        ]);
    }
}
