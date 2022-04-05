<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommonVariantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('common_variants')) {
            Schema::create('common_variants', function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('cm_attr_id')->unsigned();
                $table->integer('cm_attr_val')->unsigned();
                $table->integer('pro_id')->unsigned();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('common_variants');
    }
}
