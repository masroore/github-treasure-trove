<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shippings', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->string('shipping_name')->nullable();
            $table->string('shipping_ref')->nullable();
            $table->date('date')->nullable();
            $table->string('booking_slip')->nullable();
            $table->string('prove_of_delivery')->nullable();
            $table->string('received_by')->nullable();
            $table->date('received_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
}
