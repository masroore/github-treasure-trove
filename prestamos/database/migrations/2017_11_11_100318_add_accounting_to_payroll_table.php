<?php

use Illuminate\Database\Migrations\Migration;

class AddAccountingToPayrollTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payroll', function ($table): void {
            $table->integer('chart_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payroll', function ($table): void {
            $table->dropColumn([
                'chart_id',
            ]);
        });
    }
}
