<?php

use Illuminate\Database\Migrations\Migration;

class AddAccountingToIncomeTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('other_income', function ($table): void {
            $table->integer('chart_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('other_income', function ($table): void {
            $table->dropColumn([
                'chart_id',
            ]);
        });
    }
}
