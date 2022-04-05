<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProvisionRatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('provision_rates', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('days')->nullable();
            $table->double('rate', 10, 2)->default(0.00);
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('provision_rates');
    }
}
