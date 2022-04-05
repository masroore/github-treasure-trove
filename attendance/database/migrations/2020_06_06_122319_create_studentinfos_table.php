<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentinfosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('studentinfos', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('fullname')->nullable();
            $table->string('gender')->nullable();
            $table->string('dateofbirth')->nullable();
            $table->string('religion')->nullable();
            $table->string('denomination')->nullable();
            $table->string('placeofbirth')->nullable();
            $table->string('nationality')->nullable();
            $table->string('hometown')->nullable();
            $table->string('region')->nullable();
            $table->string('disability')->nullable();
            $table->string('postcode')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('maritalstutus')->nullable();
            $table->string('entrylevel')->nullable();
            $table->string('session')->nullable();
            $table->string('programme')->nullable();
            $table->string('type')->nullable();
            $table->string('currentlevel')->nullable();
            $table->string('indexnumber')->nullable();
            $table->string('gurdianname')->nullable();
            $table->string('relationship')->nullable();
            $table->string('occupation')->nullable();
            $table->string('mobile')->nullable();
            $table->string('employed')->nullable();
            $table->string('status')->nullable();
            $table->string('admitted')->nullable();
            $table->string('completion')->nullable();
            $table->string('academic_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studentinfos');
    }
}
