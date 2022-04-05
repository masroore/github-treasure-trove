<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailAdsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('detail_ads')) {
            Schema::create('detail_ads', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('top_heading', 191)->nullable();
                $table->string('hcolor', 100)->nullable();
                $table->string('sheading', 191)->nullable();
                $table->string('scolor', 191)->nullable();
                $table->string('adimage', 191)->nullable();
                $table->string('linkby', 100);
                $table->string('btn_text', 191)->nullable();
                $table->string('btn_txt_color', 100)->nullable();
                $table->string('btn_bg_color', 100)->nullable();
                $table->text('adsensecode', 65535)->nullable();
                $table->text('url', 65535)->nullable();
                $table->string('position', 100);
                $table->integer('pro_id')->unsigned()->nullable();
                $table->integer('linked_id')->unsigned()->nullable();
                $table->integer('cat_id')->unsigned()->nullable();
                $table->integer('status')->nullable();
                $table->integer('show_btn')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('detail_ads');
    }
}
