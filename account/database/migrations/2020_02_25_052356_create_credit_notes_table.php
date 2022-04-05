<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditNotesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'credit_notes',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->integer('invoice')->default('0');
                $table->integer('customer')->default('0');
                $table->float('amount', 15, 2)->default('0.00');
                $table->date('date');
                $table->text('description')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_notes');
    }
}
