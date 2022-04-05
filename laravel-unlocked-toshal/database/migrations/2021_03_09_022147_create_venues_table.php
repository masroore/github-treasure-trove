<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('venues', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('location')->nullable();
            $table->string('contact')->nullable();
            $table->string('building_type')->nullable();
            $table->text('amenities_detail')->nullable();
            $table->text('other_information')->nullable();
            $table->tinyInteger('is_featured')->default(0);
            $table->integer('total_room')->nullable();
            $table->integer('booking_price')->nullable();
            $table->tinyInteger('is_available')->default(1);
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('No Action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
}
