<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocaleFieldToTables extends Migration
{
    protected $tables = [
        'terms',
        'products',
        'attributes',
        'values',
        'sales',
        'pages',
        'news',
        'orders',
        'forms',
        'menu_items',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table): void {
                $table->string('locale')->nullable();
            });
        }
        Schema::table('url_aliases', function (Blueprint $table): void {
            $table->dropUnique('url_aliases_model_type_model_id_unique');
            $table->dropUnique('url_aliases_alias_unique');
        });

        Schema::table('products', function (Blueprint $table): void {
            $table->dropUnique('products_sku_unique');
            $table->index(['sku', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('url_aliases', function (Blueprint $table): void {
            $table->unique('alias');
            $table->unique('url_aliases_model_type_model_id_unique');
        });
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table): void {
                $table->dropColumn('locale');
            });
        }
    }
}
