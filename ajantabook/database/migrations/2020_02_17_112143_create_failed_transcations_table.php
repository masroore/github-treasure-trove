<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFailedTranscationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('failed_transcations')) {
            Schema::create('failed_transcations', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('order_id', 191)->nullable();
                $table->string('txn_id', 191);
                $table->string('user_id', 191);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('failed_transcations');
    }
}
