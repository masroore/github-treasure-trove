<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWidgetFootersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('widget_footers')) {
            Schema::create('widget_footers', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('widget_name', 191)->nullable();
                $table->string('widget_position', 191)->nullable();
                $table->string('menu_name', 191)->nullable();
                $table->string('url', 191)->nullable();
                $table->enum('status', ['0', '1']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('widget_footers');
    }
}
