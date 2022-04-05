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
            $table->increments('id');
            $table->string('key')->index();
            $table->text('value')->nullable();
//                $table->string('description')->nullable();
            $table->string('locale')->nullable();

            $table->unique(['key', 'locale']);
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
