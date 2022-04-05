<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->integer('division')->default(1);
            $table->string('type')->default('img');
            $table->string('title')->nullable();
            $table->string('file_name')->nullable();
            $table->string('link')->nullable();
            $table->string('visits')->default(0);
            $table->string('status')->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
}
