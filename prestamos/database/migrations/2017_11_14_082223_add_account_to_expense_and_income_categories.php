<?php

use Illuminate\Database\Migrations\Migration;

class AddAccountToExpenseAndIncomeCategories extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('expense_types', function ($table): void {
            $table->integer('account_id')->nullable();
        });
        Schema::table('other_income_types', function ($table): void {
            $table->integer('account_id')->nullable();
        });
        Schema::table('expenses', function ($table): void {
            $table->integer('account_id')->nullable();
        });
        Schema::table('other_income', function ($table): void {
            $table->integer('account_id')->nullable();
        });
        Schema::table('capital', function ($table): void {
            $table->integer('account_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('expense_types', function ($table): void {
            $table->dropColumn([
                'account_id',
            ]);
        });
        Schema::table('other_income_types', function ($table): void {
            $table->dropColumn([
                'account_id',
            ]);
        });
        Schema::table('expenses', function ($table): void {
            $table->dropColumn([
                'account_id',
            ]);
        });
        Schema::table('other_income', function ($table): void {
            $table->dropColumn([
                'account_id',
            ]);
        });
        Schema::table('capital', function ($table): void {
            $table->dropColumn([
                'account_id',
            ]);
        });
    }
}
