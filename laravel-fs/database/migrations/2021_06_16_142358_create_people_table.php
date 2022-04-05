<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table): void {
            $table->id();
            $table->string('first_name', 50);
            $table->string('second_name', 50);
            $table->string('first_surname', 50);
            $table->string('second_surname', 50);
            $table->date('date_birth');
            $table->string('expiration_month');
            $table->string('expiration_year');
            $table->string('phone_house', 20);
            $table->string('phone_cell', 20);
            $table->string('email', 50);

            $table->unsignedBigInteger('telephone_house_operator_id');
            $table->unsignedBigInteger('telephone_cell_operator_id');
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('nationality_id');
            $table->unsignedBigInteger('client_id');

            $table->foreign('telephone_house_operator_id')->references('id')->on('telephone_operators');
            $table->foreign('telephone_cell_operator_id')->references('id')->on('telephone_operators');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('nationality_id')->references('id')->on('nationalities');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
}
