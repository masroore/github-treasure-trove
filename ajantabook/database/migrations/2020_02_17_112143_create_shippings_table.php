<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('shippings')) {
            Schema::create('shippings', function (Blueprint $table): void {
                $table->integer('id')->unsigned()->primary();
                $table->string('name', 191)->nullable();
                $table->float('price', 10, 0)->nullable();
                $table->string('free', 191)->nullable();
                $table->enum('login', ['0', '1']);
                $table->enum('default_status', ['0', '1']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('shippings');
    }
}
