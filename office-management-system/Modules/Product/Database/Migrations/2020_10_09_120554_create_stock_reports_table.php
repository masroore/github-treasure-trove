<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockReportsTable extends Migration
{
    public function up(): void
    {
        Schema::create('stock_reports', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('houseable_id');
            $table->string('houseable_type');
            $table->date('stock_date');
            $table->unsignedBigInteger('product_sku_id');
            $table->string('stock')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_reports');
    }
}
