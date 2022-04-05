<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLoanOverduePenaltiesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_overdue_penalties', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('name')->nullable();
            $table->enum('type', ['fixed', 'percentage']);
            $table->decimal('amount', 65, 2)->nullable();
            $table->integer('days')->default(10);
            $table->tinyInteger('active')->default(1);
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('loan_overdue_penalties');
    }
}
