<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountListsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_lists', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('account_name');
            $table->integer('initial_balance');
            $table->string('account_number');
            $table->string('branch_code');
            $table->string('bank_branch');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_lists');
    }
}
