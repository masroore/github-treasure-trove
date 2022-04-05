<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassengersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('passengers', function (Blueprint $table): void {
            $table->id();
            $table->string('surname');
            $table->string('first_name');
            $table->string('second_name')->default('-')->nullable();
            $table->string('passport_series', 4);
            $table->string('passport_number', 6);
            $table->string('phone', 11)->unique();
            $table->boolean('deleted')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
}
