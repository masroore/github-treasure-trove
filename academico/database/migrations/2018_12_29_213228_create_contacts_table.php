<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('student_id')->unsigned();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('idnumber');
            $table->string('address');
            $table->string('email')->nullable(); // if null; look in the users table
            $table->integer('relationship_id')->nullable()->unsigned();
            $table->timestamps();
            //$table->softDeletes();
        });

        Schema::table('contacts', function (Blueprint $table): void {
            $table->foreign('student_id')
                ->references('id')->on('students')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('contacts');
    }
}
