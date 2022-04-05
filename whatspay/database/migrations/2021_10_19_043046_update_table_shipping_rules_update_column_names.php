<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableShippingRulesUpdateColumnNames extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shipping_rules', function (Blueprint $table): void {
            $table->renameColumn('from', 'min');
            $table->renameColumn('to', 'max');
            $table->renameColumn('price', 'charges');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipping_rules', function (Blueprint $table): void {
        });
    }
}
