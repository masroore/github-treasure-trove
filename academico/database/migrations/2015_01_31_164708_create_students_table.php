<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table): void {
            //$table->increments('id');
            $table->integer('id')->unsigned()->unique();
            $table->string('idnumber')->nullable();
            $table->string('address')->nullable();
            $table->integer('title_id')->nullable(); // can also be used for gender stats.
            $table->date('birthdate')->nullable();
            $table->timestamp('terms_accepted_at')->nullable();
            $table->timestamps();
            //$table->softDeletes();
        });

        Schema::table('students', function (Blueprint $table): void {
            $table->foreign('id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('students');
    }
}
