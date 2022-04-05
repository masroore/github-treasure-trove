<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalContact extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hospital_contact', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('hospital_id');
            $table->string('contact');
            $table->enum('type', ['home_phone', 'cell_phone', 'office_phone', 'email', 'web']);
            $table->timestamps();

            $table->foreign('hospital_id')
                ->references('id')->on('hospital')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_contact');
    }
}
