<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisingTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('advertising', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('title')->unique();
            $table->text('content');
            $table->string('image');
            $table->string('url');
            $table->dateTime('published_at');
            $table->dateTime('expires_at')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertising');
    }
}
