<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDucumentUploadsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'ducument_uploads',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('role');
                $table->string('document');
                $table->text('description')->nullable();
                $table->integer('created_by')->default(0);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ducument_uploads');
    }
}
