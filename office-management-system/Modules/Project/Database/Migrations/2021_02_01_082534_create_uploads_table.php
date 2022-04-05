<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('uploads', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('module')->nullable();
            $table->integer('module_id')->nullable();
            $table->uuid('upload_token')->nullable();
            $table->string('user_filename')->nullable();
            $table->string('filename')->nullable();
            $table->string('file_type')->nullable();
            $table->boolean('is_temp_delete')->default(0);
            $table->boolean('status')->default(0);
            $table->text('options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uploads', function (Blueprint $table): void {
            $table->dropForeign('uploads_user_id_foreign');
        });
        Schema::dropIfExists('uploads');
    }
}
