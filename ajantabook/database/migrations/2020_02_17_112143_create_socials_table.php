<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSocialsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('socials')) {
            Schema::create('socials', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('url', 191)->nullable();
                $table->string('icon', 191)->nullable();
                $table->enum('status', ['0', '1']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('socials');
    }
}
