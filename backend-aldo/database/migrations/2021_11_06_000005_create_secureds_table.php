<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecuredsTable extends Migration
{
    public function up(): void
    {
        Schema::create('secureds', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->integer('communal');
            $table->integer('individual');
            $table->integer('mck_user');
            $table->integer('qty_sr_pdpal');
            $table->string('year')->nullable();
            $table->timestamps();
        });
    }
}
