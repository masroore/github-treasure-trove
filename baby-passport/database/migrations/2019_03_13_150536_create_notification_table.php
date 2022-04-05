<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notification', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('description');
            $table->string('url', 255);
            $table->unsignedInteger('user_id')->nullable();
            $table->enum('receiver', ['pacient', 'superadmin', 'main_doctor'])->default('superadmin');
            $table->boolean('read')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification');
    }
}
