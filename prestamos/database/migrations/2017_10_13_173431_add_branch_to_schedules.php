<?php

use Illuminate\Database\Migrations\Migration;

class AddBranchToSchedules extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('loan_schedules', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
        Schema::table('savings_transactions', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_schedules', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
        Schema::table('savings_transactions', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
    }
}
