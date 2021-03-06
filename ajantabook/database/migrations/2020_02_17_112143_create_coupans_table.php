<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoupansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('coupans')) {
            Schema::create('coupans', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('code', 191);
                $table->string('distype', 100);
                $table->string('amount', 191);
                $table->string('link_by', 100);
                $table->integer('pro_id')->unsigned()->nullable();
                $table->integer('cat_id')->unsigned()->nullable();
                $table->integer('is_login')->unsigned()->default(0);
                $table->integer('maxusage')->unsigned()->nullable();
                $table->float('minamount', 10, 0)->nullable();
                $table->dateTime('expirydate');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('coupans');
    }
}
