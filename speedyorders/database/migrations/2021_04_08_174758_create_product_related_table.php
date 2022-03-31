<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('description');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->longText('description')->nullable()->after('image');
        });

        Schema::table('product_option_values', function (Blueprint $table) {
            $table->dropColumn('price_prefix');
        });

        Schema::table('product_option_values', function (Blueprint $table) {
            $table->string('price_prefix', 1)->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_option_values', function (Blueprint $table) {
            $table->dropColumn('price_prefix');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
