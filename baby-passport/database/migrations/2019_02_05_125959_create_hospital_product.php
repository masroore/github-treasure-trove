<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalProduct extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hospital_product', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('hospital_id');
            $table->unsignedInteger('product_id');
            $table->decimal('price', 10, 2);
            $table->decimal('deposit', 10, 2)->nullable();

            $table->timestamps();

            $table->foreign('hospital_id')
                ->references('id')->on('hospital')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')->on('product')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_product');
    }
}
