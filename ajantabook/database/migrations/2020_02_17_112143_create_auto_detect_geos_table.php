<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAutoDetectGeosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('auto_detect_geos')) {
            Schema::create('auto_detect_geos', function (Blueprint $table): void {
                $table->increments('id');
                $table->enum('enabel_multicurrency', ['0', '1'])->default('0');
                $table->enum('auto_detect', ['0', '1'])->nullable();
                $table->string('default_geo_location', 191)->nullable();
                $table->enum('currency_by_country', ['0', '1'])->nullable();
                $table->enum('enable_cart_page', ['0', '1'])->nullable();
                $table->enum('checkout_currency', ['0', '1'])->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('auto_detect_geos');
    }
}
