<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsedCoupansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('used_coupans')) {
            Schema::create('used_coupans', function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('coupan_id')->unsigned()->nullable();
                $table->integer('user_id')->unsigned()->nullable();
                $table->integer('used_coupan')->unsigned()->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('used_coupans');
    }
}
