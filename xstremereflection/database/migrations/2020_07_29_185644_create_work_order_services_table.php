<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderServicesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_order_services', function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
            $table->integer('qty');
            $table->integer('estimateId');
            $table->integer('invoiceId')->nullable();
            $table->integer('serviceId');
            $table->string('description')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('discountType')->nullable();
            $table->decimal('listPrice', 8, 2);
            $table->decimal('chargedPrice', 8, 2);
            $table->integer('status')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_services');
    }
}
