<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashbacksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('cashbacks')) {
            Schema::create('cashbacks', function (Blueprint $table): void {
                $table->id();
                $table->integer('enable')->default(1)->unsigned();
                $table->integer('product_id')->unsigned()->nullable();
                $table->integer('simple_product_id')->unsigned()->nullable();
                $table->string('cashback_type');
                $table->string('discount_type');
                $table->double('discount');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashbacks');
    }
}
