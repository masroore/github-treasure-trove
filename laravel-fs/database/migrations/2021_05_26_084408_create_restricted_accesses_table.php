<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestrictedAccessesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restricted_accesses', function (Blueprint $table): void {
            $table->id();
            $table->timestamp('date_in')->nullable();
            $table->string('ip', 20);

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('process_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('process_id')->references('id')->on('processes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restricted_accesses');
    }
}
