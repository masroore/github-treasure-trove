<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientPosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_pos', function (Blueprint $table): void {
            $table->id();
            $table->string('price', 20);
            $table->boolean('status')->default(true);
            $table->boolean('exonerate')->default(false);
            $table->boolean('charged')->default(false);
            $table->string('observations', 20)->nullable();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('pos_inventory_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('register_date')->nullable();
            $table->string('ip', 20);

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('pos_inventory_id')->references('id')->on('pos_inventories');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_pos');
    }
}
