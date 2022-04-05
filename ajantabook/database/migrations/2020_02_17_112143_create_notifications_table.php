<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table): void {
                $table->char('id', 36)->primary();
                $table->string('type', 191);
                $table->string('notifiable_type', 191);
                $table->bigInteger('notifiable_id')->unsigned();
                $table->text('data', 65535);
                $table->string('n_type', 191)->nullable();
                $table->string('url', 191)->nullable();
                $table->dateTime('read_at')->nullable();
                $table->timestamps();
                $table->index(['notifiable_type', 'notifiable_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('notifications');
    }
}
