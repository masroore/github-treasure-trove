<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserbanksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('userbanks')) {
            Schema::create('userbanks', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('bankname', 191);
                $table->bigInteger('acno');
                $table->string('acname', 191);
                $table->string('ifsc', 191);
                $table->integer('user_id')->unsigned();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('userbanks');
    }
}
