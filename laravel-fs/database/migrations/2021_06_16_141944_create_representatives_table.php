<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepresentativesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('representatives', function (Blueprint $table): void {
            $table->id();
            $table->string('document', 20)->unique();
            $table->string('first_name', 200);
            $table->string('second_name', 200);
            $table->string('first_surname', 200);
            $table->string('second_surname', 200);
            $table->date('date_birth');
            $table->string('expiration_month');
            $table->string('expiration_year');
            $table->string('phone', 20);
            $table->string('email', 50);

            $table->unsignedBigInteger('type_document_id');
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('telephone_operator_id');

            $table->foreign('type_document_id')->references('id')->on('type_documents');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('telephone_operator_id')->references('id')->on('telephone_operators');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representatives');
    }
}
