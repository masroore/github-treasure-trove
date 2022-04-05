<?php

use Illuminate\Database\Migrations\Migration;

class AddTypeToCapitalTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('capital', function ($table): void {
            $table->enum('type', ['withdrawal', 'deposit'])->default('deposit');
            $table->integer('loan_id')->nullable();
            $table->integer('expense_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('capital', function ($table): void {
            $table->dropColumn([
                'type',
                'loan_id',
                'expense_id',
            ]);
        });
    }
}
