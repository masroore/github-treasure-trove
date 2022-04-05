<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempCustomerTransactionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('temp_customer_transaction', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('php_session_id', 255)->default(null)->nullable();
            $table->text('description')->default(null)->nullable();
            $table->string('amount', 255)->default(null)->nullable();
            $table->string('type', 255)->default(null)->nullable();
            $table->string('status', 255)->default(null)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_customer_transaction');
    }
}
