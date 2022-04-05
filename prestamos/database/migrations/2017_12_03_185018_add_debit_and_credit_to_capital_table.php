<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddDebitAndCreditToCapitalTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('capital', function ($table): void {
            $table->integer('credit_account_id')->nullable();
            $table->integer('debit_account_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('capital', function ($table): void {
            $table->dropColumn('credit_account_id');
            $table->dropColumn('debit_account_id');
        });
    }
}
