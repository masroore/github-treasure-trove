<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'transfers',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->integer('from_account')->default('0');
                $table->integer('to_account')->default('0');
                $table->float('amount', 15, 2)->default('0');
                $table->date('date');
                $table->integer('payment_method')->default('0');
                $table->string('reference')->nullable();
                $table->text('description');
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
        Schema::dropIfExists('transfers');
    }
}
