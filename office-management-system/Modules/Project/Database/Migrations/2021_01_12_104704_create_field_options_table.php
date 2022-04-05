<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldOptionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('field_options', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('field_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('field_id')->on('fields')->references('id')->onDelete('cascade');

            $table->string('color', 50)->nullable();
            $table->string('option')->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('field_options', function (Blueprint $table): void {
            $table->dropForeign('fields_field_id_foreign');
        });
        Schema::dropIfExists('field_options');
    }
}
