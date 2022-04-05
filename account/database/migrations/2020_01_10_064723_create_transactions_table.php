<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'transactions',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->integer('user_id');
                $table->string('user_type');
                $table->integer('account');
                $table->string('type');
                $table->float('amount')->default('0.00');
                $table->text('description');
                $table->date('date');
                $table->integer('created_by')->default('0');
                $table->integer('payment_id')->default('0');
                $table->string('category');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}
