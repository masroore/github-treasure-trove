<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_questions', function (Blueprint $table): void {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('product_id')->default(null)->nullable();
            $table->unsignedBigInteger('customer_id')->default(null)->nullable();
            $table->string('name')->default(null)->nullable();
            $table->text('description')->default(null)->nullable();
            $table->string('email')->default(null)->nullable();
            $table->string('status')->default('0')->comment('1=>active,0=>inactive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('product_questions');
    }
}
