<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReportProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('report_products')) {
            Schema::create('report_products', function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('pro_id')->unsigned();
                $table->string('title', 191);
                $table->string('email', 191);
                $table->text('des', 65535);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('report_products');
    }
}
