<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmtpInformationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('smtp_information')) {
            Schema::create('smtp_information', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('host');
                $table->string('port');
                $table->string('username')->nullable();
                $table->string('from_email');
                $table->string('from_name');
                $table->string('password');
                $table->string('encryption');
                $table->tinyInteger('status');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smtp_information');
    }
}
