<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospital extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hospital', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('rating_id');
            $table->unsignedInteger('city_id');
            $table->string('name');
            $table->string('photo');
            $table->time('appointment_duration');
            $table->text('about')->nullable();
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();

            $table->foreign('rating_id')
                ->references('id')->on('rating')
                ->onDelete('cascade');

            $table->foreign('city_id')
                ->references('id')->on('city')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital');
    }
}
