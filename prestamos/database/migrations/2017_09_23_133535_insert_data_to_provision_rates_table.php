<?php

use Illuminate\Database\Migrations\Migration;

class InsertDataToProvisionRatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::table('provision_rates')->insert([
            [
                'days' => '0',
                'name' => 'Current',
                'rate' => '0.00',
            ],
            [
                'days' => '31',
                'name' => 'Especially Mentioned',
                'rate' => '5.00',
            ],
            [
                'days' => '61',
                'name' => 'Substandard',
                'rate' => '10.00',
            ],
            [
                'days' => '91',
                'name' => 'Doubtful',
                'rate' => '50.00',
            ],
            [
                'days' => '181',
                'name' => 'Loss',
                'rate' => '100.00',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}
