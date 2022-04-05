<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('store_id')->unsigned();
            $table->string('name', 100)->nullable();
            $table->string('icon', 100)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
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
        Schema::dropIfExists('categories');
        Schema::table('categories', function (Blueprint $table): void {
            $table->dropSoftDeletes();
        });
    }
}
