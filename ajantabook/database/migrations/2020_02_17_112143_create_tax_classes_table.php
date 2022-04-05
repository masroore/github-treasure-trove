<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxClassesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('tax_classes')) {
            Schema::create('tax_classes', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('title', 191)->nullable();
                $table->string('des', 191)->nullable();
                $table->text('taxRate_id', 65535)->nullable();
                $table->string('priority', 191)->nullable();
                $table->string('based_on', 191)->nullable();
                $table->timestamps();
                $table->enum('status', ['0', '1'])->default('0');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('tax_classes');
    }
}
