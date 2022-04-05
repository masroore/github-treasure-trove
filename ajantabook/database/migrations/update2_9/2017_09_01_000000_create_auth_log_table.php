<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthLogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('auth_log')) {
            Schema::create('auth_log', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->morphs('authenticatable');
                $table->string('ip_address', 45)->nullable();
                $table->text('platform')->nullable();
                $table->text('browser')->nullable();
                $table->timestamp('login_at')->nullable();
                $table->timestamp('logout_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_log');
    }
}
