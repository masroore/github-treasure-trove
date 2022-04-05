<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZonesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('zones')) {
            Schema::create('zones', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('title', 191)->nullable();
                $table->integer('country_id')->unsigned()->nullable();
                $table->text('name', 65535)->nullable();
                $table->string('code', 191)->nullable();
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
        Schema::drop('zones');
    }
}
