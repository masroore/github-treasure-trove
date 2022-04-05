<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductValuesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('product_values')) {
            Schema::create('product_values', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('values', 191)->nullable();
                $table->string('atrr_id', 191);
                $table->string('unit_value', 191)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('product_values');
    }
}
