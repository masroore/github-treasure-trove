<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFrontCatsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('front_cats')) {
            Schema::create('front_cats', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('name', 191)->nullable();
                $table->enum('status', ['0', '1'])->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('front_cats');
    }
}
