<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommercesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commerces', function (Blueprint $table): void {
            $table->id();
            $table->string('business_name', 100);
            $table->string('trade_name', 100);
            $table->string('email', 50);
            $table->string('phone', 20);

            $table->unsignedBigInteger('telephone_operator_id');
            $table->unsignedBigInteger('franchise_id')->nullable();
            $table->unsignedBigInteger('client_id');

            $table->foreign('telephone_operator_id')->references('id')->on('telephone_operators');
            $table->foreign('franchise_id')->references('id')->on('franchises');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commerces');
    }
}
