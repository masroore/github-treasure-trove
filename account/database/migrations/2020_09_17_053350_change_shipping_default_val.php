<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeShippingDefaultVal extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(
            'customers',
            function (Blueprint $table): void {
                $table->string('shipping_name')->nullable()->change();
                $table->string('shipping_country')->nullable()->change();
                $table->string('shipping_state')->nullable()->change();
                $table->string('shipping_city')->nullable()->change();
                $table->string('shipping_phone')->nullable()->change();
                $table->string('shipping_zip')->nullable()->change();
                $table->string('shipping_address')->nullable()->change();
            }
        );

        Schema::table(
            'venders',
            function (Blueprint $table): void {
                $table->string('shipping_name')->nullable()->change();
                $table->string('shipping_country')->nullable()->change();
                $table->string('shipping_state')->nullable()->change();
                $table->string('shipping_city')->nullable()->change();
                $table->string('shipping_phone')->nullable()->change();
                $table->string('shipping_zip')->nullable()->change();
                $table->string('shipping_address')->nullable()->change();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'venders',
            function (Blueprint $table): void {
                $table->dropColumn('shipping_name');
                $table->dropColumn('shipping_country');
                $table->dropColumn('shipping_state');
                $table->dropColumn('shipping_city');
                $table->dropColumn('shipping_phone');
                $table->dropColumn('shipping_zip');
                $table->dropColumn('shipping_address');
            }
        );

        Schema::table(
            'customers',
            function (Blueprint $table): void {
                $table->dropColumn('shipping_name');
                $table->dropColumn('shipping_country');
                $table->dropColumn('shipping_state');
                $table->dropColumn('shipping_city');
                $table->dropColumn('shipping_phone');
                $table->dropColumn('shipping_zip');
                $table->dropColumn('shipping_address');
            }
        );
    }
}
