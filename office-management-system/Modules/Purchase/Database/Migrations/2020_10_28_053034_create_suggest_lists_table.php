<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuggestListsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suggest_lists', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('houseable_id');
            $table->string('houseable_type');
            $table->unsignedBigInteger('product_sku_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggest_lists');
    }
}
