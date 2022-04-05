<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariablesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableName = config('variables.table_name');

        Schema::create($tableName, function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('key')->index();
            $table->text('value')->nullable();
            $table->string('langcode', 10)->nullable();
            $table->unique(['key', 'langcode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = config('variables.table_name');

        Schema::drop($tableName);
    }
}
