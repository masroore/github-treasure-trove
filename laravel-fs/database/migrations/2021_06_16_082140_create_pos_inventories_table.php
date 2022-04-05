<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pos_inventories', function (Blueprint $table): void {
            $table->id();
            $table->string('serial', 20);
            $table->string('mac_address', 20)->nullable();
            $table->string('firmware', 100)->nullable();
            $table->string('observations', 255)->nullable();

            $table->boolean('operative')->default(true);
            $table->boolean('avaliable')->default(false);
            $table->boolean('assigned')->default(false);
            $table->boolean('status')->default(true);

            $table->boolean('adequacy')->nullable();
            $table->boolean('configured')->nullable();

            $table->unsignedBigInteger('pos_box_id');
            $table->unsignedBigInteger('storage_id');

            $table->unsignedBigInteger('user_id');
            $table->timestamp('date_register')->nullable();
            $table->string('ip', 20);

            $table->foreign('pos_box_id')->references('id')->on('pos_boxes');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('storage_id')->references('id')->on('storages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_inventories');
    }
}
