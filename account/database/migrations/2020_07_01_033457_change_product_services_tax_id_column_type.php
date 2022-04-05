<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProductServicesTaxIdColumnType extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(
            'product_services',
            function (Blueprint $table): void {
                $table->string('tax_id', '50')->nullable()->change();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'product_services',
            function (Blueprint $table): void {
                $table->dropColumn('tax_id');
            }
        );
    }
}
