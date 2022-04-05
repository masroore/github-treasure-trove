<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHotdealsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('hotdeals')) {
            Schema::create('hotdeals', function (Blueprint $table): void {
                $table->increments('id')->unsigned();
                $table->integer('pro_id')->unsigned()->nullable();
                $table->enum('status', ['0', '1']);
                $table->timestamps();
                $table->date('start');
                $table->date('end');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('hotdeals');
    }
}
