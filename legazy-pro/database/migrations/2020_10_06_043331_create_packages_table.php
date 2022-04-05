<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table): void {
            $table->bigIncrements('id')->unsigned();
            $table->string('name');
            // $table->bigInteger('group_id')->unsigned();
            // $table->foreign('group_id')->references('id')->on('groups');
            $table->double('price')->default(0);
            // $table->double('minimum_deposit')->default(0)->comment('deposito minimo');
            $table->date('expired')->nullable()->comment('Fecha de vencimiento del paquete');
            $table->text('description')->nullable();
            $table->enum('status', [0, 1])->default(1)->comment('0 - desactivado, 1 - activado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
}
