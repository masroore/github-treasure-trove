<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('revenues', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->date('date');
            $table->float('amount', 15, 2)->default('0.00');
            $table->integer('account_id');
            $table->integer('customer_id');
            $table->integer('category_id');
            $table->integer('payment_method');
            $table->string('reference');
            $table->text('description');
            $table->integer('created_by')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenues');
    }
}
