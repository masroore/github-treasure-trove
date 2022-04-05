<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWidgetsettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('widgetsettings')) {
            Schema::create('widgetsettings', function (Blueprint $table): void {
                $table->increments('id')->unsigned();
                $table->string('name', 191);
                $table->enum('home', ['0', '1']);
                $table->enum('shop', ['0', '1']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('widgetsettings');
    }
}
