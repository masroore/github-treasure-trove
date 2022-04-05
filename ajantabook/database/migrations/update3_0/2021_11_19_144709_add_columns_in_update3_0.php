<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('simple_products', function (Blueprint $table): void {
            if (!Schema::hasColumn('simple_products', 'size_chart')) {
                $table->integer('size_chart')->unsigned()->nullable();
            }

            if (!Schema::hasColumn('simple_products', 'other_cats')) {
                $table->longText('other_cats')->nullable();
            }
        });

        Schema::table('simple_products', function (Blueprint $table): void {
            if (Schema::hasColumn('simple_products', 'simple_pro_id')) {
                $table->integer('simple_pro_id')->nullable()->change();
            }
        });

        Schema::table('users', function (Blueprint $table): void {
            if (Schema::hasColumn('users', 'id')) {
                $table->bigIncrements('id')->change();
            }
        });

        Schema::table('products', function (Blueprint $table): void {
            if (!Schema::hasColumn('products', 'size_chart')) {
                $table->integer('size_chart')->unsigned()->nullable();
            }

            if (!Schema::hasColumn('products', 'other_cats')) {
                $table->longText('other_cats')->nullable();
            }
        });
    }
};
