<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('add_product_variants')) {
            Schema::create('add_product_variants', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('attr_name', 191)->nullable();
                $table->string('attr_value', 191)->nullable();
                $table->integer('pro_id');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('add_product_variants');
    }
}
