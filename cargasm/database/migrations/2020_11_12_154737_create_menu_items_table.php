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
            $table->string('name');
            $table->string('type');
            $table->string('path')->nullable();
            $table->nullableMorphs('model');
            $table->string('target')->nullable();
            $table->integer('weight')->default(0);
            $table->string('class')->nullable();
            $table->string('rel')->nullable();
            $table->string('img')->nullable();

            $table->string('lang', 10);
            $table->uuid('translation_uuid')->nullable();

            $table->foreignId('menu_id')
                ->constrained()
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
