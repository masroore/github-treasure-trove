<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRelatedTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table): void {
            $table->dropColumn('description');
        });

        Schema::table('categories', function (Blueprint $table): void {
            $table->longText('description')->nullable()->after('image');
        });

        Schema::table('product_option_values', function (Blueprint $table): void {
            $table->dropColumn('price_prefix');
        });

        Schema::table('product_option_values', function (Blueprint $table): void {
            $table->string('price_prefix', 1)->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_option_values', function (Blueprint $table): void {
            $table->dropColumn('price_prefix');
        });

        Schema::table('categories', function (Blueprint $table): void {
            $table->dropColumn('description');
        });
    }
}
