<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAbusedsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('abuseds')) {
            Schema::create('abuseds', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('name', 191);
                $table->string('rep', 191);
                $table->enum('status', ['0', '1', '']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('abuseds');
    }
}
