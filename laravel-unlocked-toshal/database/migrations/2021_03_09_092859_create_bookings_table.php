<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('venue_id');
            $table->unsignedBigInteger('user_id');
            $table->string('booking_name');
            $table->string('booking_email');
            $table->date('date');
            $table->tinyInteger('status')->default(0)->comment('0: New Booking; 1:Confirmed Booking; 2: Rejected Booking');
            $table->tinyInteger('is_deleted')->default(0);
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
}
