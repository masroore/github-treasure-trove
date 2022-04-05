<?php

use Illuminate\Database\Migrations\Migration;

class AddBankAccountsToCapitalTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('capital', function ($table): void {
            $table->integer('bank_account_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('capital', function ($table): void {
            $table->dropColumn([
                'bank_account_id',
            ]);
        });
    }
}
