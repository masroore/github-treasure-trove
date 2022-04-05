<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->integer('ccat_id')->default(9);

            $table->integer('ref_id')->nullable();
            // $table->integer('depth')->default(1);
            $table->integer('order')->default(0);

            $table->string('name');
            $table->string('password');
            $table->string('email')->default('');
            $table->string('homepage')->default('');
            $table->string('title');
            $table->text('content');
            $table->integer('visits')->default(0);
            $table->string('user_ip');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
}
