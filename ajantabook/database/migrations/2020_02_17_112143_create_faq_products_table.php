<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFaqProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('faq_products')) {
            Schema::create('faq_products', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('pro_id', 191)->nullable();
                $table->text('question', 65535)->nullable();
                $table->text('answer', 65535)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('faq_products');
    }
}
