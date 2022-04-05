<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInversionOrdernPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orden_purchases', function (Blueprint $table): void {
            $table->bigInteger('inversion_id')->unsigned()->nullable();
            $table->foreign('inversion_id')->references('id')->on('inversions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orden_purchases', function (Blueprint $table): void {
            $table->dropForeign(['inversion_id']);
        });
    }
}
