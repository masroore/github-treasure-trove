<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpecialOffersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('special_offers')) {
            Schema::create('special_offers', function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('pro_id')->unsigned();
                $table->timestamps();
                $table->enum('status', ['0', '1'])->nullable()->default('0');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('special_offers');
    }
}
