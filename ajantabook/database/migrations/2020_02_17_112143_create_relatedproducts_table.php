<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelatedproductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('relatedproducts')) {
            Schema::create('relatedproducts', function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('product_id')->unsigned()->nullable();
                $table->text('related_pro', 65535)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('relatedproducts');
    }
}
