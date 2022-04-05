<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmNotesTable extends Migration
{
    public function up(): void
    {
        Schema::create('crm_notes', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
