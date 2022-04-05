<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attributes', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('title');
            $table->string('suffix')->nullable();
            $table->string('slug')->unique();
            $table->tinyInteger('data_type')->default(1)->comment('Type field for values attribute');
            $table->tinyInteger('purpose')->default(1)->comment('Purpose for attribute values: product card, products facet filter, all');
            $table->integer('weight')->default(0);
            $table->json('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
}
