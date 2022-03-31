<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('category_id')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('slug')->unique()->nullable()->default(null);
            $table->string('image')->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
            $table->string('is_featured')->default('1')->comment('1=>Featured,0=>Not-Featured')->nullable();
            $table->string('show_on_homepage')->default('1')->comment('1=>Show,0=>Dont Show')->nullable();
            $table->string('status')->default('1')->comment('1=>Active,0=>Inactive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
