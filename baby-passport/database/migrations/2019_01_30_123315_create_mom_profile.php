<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMomProfile extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mom_profile', function (Blueprint $table): void {
            $table->unsignedInteger('user_id');
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('job')->nullable();
            $table->string('pregnancy_week')->nullable();
            $table->text('how_found')->nullable();
            $table->text('about_me')->nullable();

            $table->primary('user_id');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mom_profile');
    }
}
