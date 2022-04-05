<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'deposits',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->integer('account_id');
                $table->integer('amount');
                $table->date('date');
                $table->integer('income_category_id');
                $table->integer('payer_id');
                $table->integer('payment_type_id');
                $table->string('referal_id')->nullable();
                $table->text('description')->nullable();
                $table->integer('created_by');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
}
