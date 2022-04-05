<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('user_addresses', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->bigInteger('user_id',20)->unsigned();
        //     $table->string('title',100);
        //     $table->string('phone',100);
        //     $table->string('country',60);
        //     $table->string('city',60);
        //     $table->text('address');
        //     $table->tinyInteger('is_default')->unsigned()->default(0);
        //     // $table->foreign('user_id')
        //     //         ->references('id')
        //     //         ->on('users')
        //     //         ->onCascade('delete');
        //     $table->timestamps();
        // });

        // Schema::table('user_addresses', function($table) {
        //     $table->foreign('user_id')->references('id')->on('users');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
}
