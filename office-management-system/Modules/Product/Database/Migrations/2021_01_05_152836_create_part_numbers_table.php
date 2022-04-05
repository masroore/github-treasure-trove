<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartNumbersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('part_numbers', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('product_sku_id')->nullable();
            $table->unsignedBigInteger('product_item_detail_id')->nullable();
            $table->string('seiral_no')->unique()->nullable();
            $table->boolean('is_sold')->default(0);
            $table->boolean('is_returned')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part_numbers');
    }
}
