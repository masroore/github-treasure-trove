<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('invoices')) {
            Schema::create('invoices', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('order_prefix', 100)->nullable();
                $table->string('prefix', 191)->nullable();
                $table->string('postfix', 191)->nullable();
                $table->timestamps();
                $table->string('seal', 191)->nullable();
                $table->string('inv_start', 100)->nullable();
                $table->string('cod_prefix', 191)->nullable();
                $table->string('cod_postfix', 191)->nullable();
                $table->string('terms', 200)->nullable();
                $table->string('sign', 191)->nullable();
                $table->integer('user_id')->unsigned();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('invoices');
    }
}
