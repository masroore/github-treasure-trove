<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryUploadsTable extends Migration
{
    public function up(): void
    {
        Schema::create('temporary_uploads', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('session_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temporary_uploads');
    }
}