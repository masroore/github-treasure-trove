<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateShippingsTableAddNewFields extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shippings', function (Blueprint $table): void {
            $table->bigInteger('parent_id')->unsigned()->after('id')->nullable();
            $table->string('city', 160)->after('country')->nullable();
            $table->float('radius')->after('city')->nullable();
            $table->double('latitude')->after('radius')->nullable();
            $table->double('longitude')->after('latitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shippings', function (Blueprint $table): void {
        });
    }
}
