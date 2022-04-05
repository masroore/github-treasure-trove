<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('menu_id');
            $table->enum('type', ['item', 'divider'])->default('item');
            $table->integer('parent_id')->nullable();
            $table->integer('order')->nullable();
            $table->string('title')->nullable();
            $table->string('divider_title')->nullable();
            $table->string('url')->nullable();
            $table->string('target')->default('_self');
            $table->string('icon_class')->nullable();
            $table->timestamps();

            $table->foreign('menu_id')
                ->references('id')
                ->on('menus')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
}
