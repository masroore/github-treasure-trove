<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSavingsProductTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('savings_products', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->tinyInteger('allow_overdraw')->default(0);
            $table->decimal('interest_rate', 10, 2)->nullable();
            $table->integer('minimum_balance')->nullable()->default(0);
            $table->string('interest_posting')->nullable();
            $table->string('interest_adding')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('savings_products');
    }
}
