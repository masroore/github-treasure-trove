<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table): void {
            $table->id();
            $table->string('document', 20);
            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('type_document_id');
            $table->unsignedBigInteger('operative_id');
            $table->unsignedBigInteger('storage_id');

            $table->unsignedBigInteger('user_id');
            $table->timestamp('date_register')->nullable();
            $table->string('ip', 20);

            $table->foreign('type_document_id')->references('id')->on('type_documents');
            $table->foreign('operative_id')->references('id')->on('operatives');
            $table->foreign('storage_id')->references('id')->on('storages');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
}
