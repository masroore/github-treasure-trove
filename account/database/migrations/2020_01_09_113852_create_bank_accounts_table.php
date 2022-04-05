<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'bank_accounts',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('holder_name');
                $table->string('bank_name');
                $table->string('account_number');
                $table->float('opening_balance', 15, 2)->default('0.00');
                $table->string('contact_number');
                $table->text('bank_address');
                $table->integer('created_by')->default('0');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
}
