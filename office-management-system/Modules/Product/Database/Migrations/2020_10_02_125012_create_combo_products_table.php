<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComboProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('combo_products', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('showroom_id');
            $table->string('name', 255)->nullable();
            $table->double('price', 16, 2)->default(0);
            $table->double('total_purchase_price', 16, 2)->default(0);
            $table->double('total_regular_price', 16, 2)->default(0);
            $table->string('image_source')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(1);
            $table->string('barcode_id', 255)->nullable();
            $table->string('barcode_type', 255)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->on('users')->references('id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combo_products');
    }
}
