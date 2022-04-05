<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaultsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vaults', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->integer('user_id')->unsigned();
            $table->text('name');
            $table->text('description')->nullable();
            $table->string('color', 20)->default('#000000');
            $table->string('icon', 20)->nullable();
            $table->string('background')->nullable();
            $table->text('password')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('is_fav')->default(false);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaults');
    }
}
