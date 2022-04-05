<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table): void {
            $table->unsignedBigInteger('id')->autoIncrement();

            $table->unsignedBigInteger('faq_category_id')->default(null)->nullable();
            $table->text('question')->default(null)->nullable();
            $table->longtext('answer')->default(null)->nullable();
            $table->integer('sort_order')->default(null)->nullable();
            $table->string('status')->default('1')->comment('1=>Active,0=>Inactive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('faqs');
    }
}
