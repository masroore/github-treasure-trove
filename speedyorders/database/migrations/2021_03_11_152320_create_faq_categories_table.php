<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFaqCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('faq_categories', function (Blueprint $table): void {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('name')->default(null)->nullable();
            $table->string('meta_tag')->default(null)->nullable();
            $table->integer('sort_order')->default(0)->nullable();
            $table->string('status')->default('1')->comment('1=>Active,0=>Inactive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('faq_categories');
    }
}
