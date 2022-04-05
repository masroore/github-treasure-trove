<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSavingsFeesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('savings_fees', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->text('savings_products')->nullable();
            $table->decimal('amount', 10, 2)->nullable()->default(0);
            $table->string('fees_posting')->nullable();
            $table->string('fees_adding')->nullable();
            $table->enum('new_fee_type', ['full', 'pro_rata'])->nullable()->default('full');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('savings_fees');
    }
}
