<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionenquiriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admissionenquiries', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('fullname');
            $table->string('gender');
            $table->string('phone');
            $table->string('email');
            $table->string('location');
            $table->string('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissionenquiries');
    }
}
