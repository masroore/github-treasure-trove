<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->enum('type', ['pacient', 'main_doctor', 'superadmin'])->default('pacient');
            $table->enum('step', ['lead', 'profile', 'maternity_package', 'payment', 'appointment', 'format_appointment', 'tracing', 'done'])->default('lead');
            $table->enum('status', ['active', 'on_revision', 'inactive', 'active_subscription'])->default('active');
            $table->timestamp('email_verified_at')->nullable();
            $table->text('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
