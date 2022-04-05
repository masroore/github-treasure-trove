<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->integer('category_id');
            $table->text('description')->nullable();
            $table->float('amount')->nullable();
            $table->date('date')->nullable();
            $table->unsignedBigInteger('project')->default('0');
            $table->unsignedBigInteger('user_id')->default('0');
            $table->string('attachment')->nullable();
            $table->integer('created_by')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
}
