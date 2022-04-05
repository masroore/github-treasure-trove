<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('title')->index();
            $table->string('subtitle')->nullable();
            $table->float('price', 15, 4)->nullable();
            $table->string('price_per')->nullable();
            $table->string('tags')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
}
