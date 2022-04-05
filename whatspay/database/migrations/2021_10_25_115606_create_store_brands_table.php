<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreBrandsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('store_brands', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('store_id')->unsigned()->comment('belongs to stores table pk');
            $table->bigInteger('brand_id')->unsigned()->comment('belongs to brands table pk');
            $table->enum('status', [0, 1])->default(1);
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_brands');
    }
}
