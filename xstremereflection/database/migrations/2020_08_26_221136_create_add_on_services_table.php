<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddOnServicesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('add_on_services', function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
            $table->integer('serviceId');
            $table->string('description')->nullable();
            $table->decimal('price', 7, 2);
            $table->boolean('show')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_on_services');
    }
}
