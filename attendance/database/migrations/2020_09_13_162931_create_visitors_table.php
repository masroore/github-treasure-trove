<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('fullname')->nullable();
            $table->string('phone')->nullable();
            $table->string('idcard')->nullable();
            $table->string('numofpersons')->nullable();
            $table->string('purpose')->nullable();
            $table->string('intime')->nullable();
            $table->string('outtime')->nullable();
            $table->string('note')->nullable();
            $table->string('doc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
}
