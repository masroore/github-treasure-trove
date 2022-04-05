<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizeChartValuesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('size_chart_values')) {
            Schema::create('size_chart_values', function (Blueprint $table): void {
                $table->id();
                $table->string('value');

                $table->unsignedBigInteger('option_id');
                $table->foreign('option_id')->references('id')->on('size_chart_options');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('size_chart_values');
    }
}
