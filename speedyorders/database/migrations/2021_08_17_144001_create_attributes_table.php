<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attributes', function (Blueprint $table): void {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('attribute_label')->nullable()->default(null);
            $table->string('input_type')->default('0')->comment('1=>Multiple Selection,0=>Single Selection')->nullable();
            $table->string('is_required')->default('0')->comment('1=>Required,0=>Not Required')->nullable();
            $table->string('attribute_code')->nullable()->default(null);
            $table->string('include_in_filter')->default('0')->comment('1=>Yes,0=>No')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
}
