<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estimates', function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
            $table->integer('companyId');
            $table->integer('customerId');
            $table->string('serviceAddress')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->time('arrivalTime')->nullable();
            $table->time('estimatedCompleteTime')->nullable();
            $table->integer('status')->default('1');
            $table->year('vehicleYear')->nullable();
            $table->string('vehicleMake')->nullable();
            $table->string('vehicleModel')->nullable();
            $table->string('vehicleColor')->nullable();
            $table->string('vehicleVin')->nullable();
            $table->integer('vehicleCondition')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
}
