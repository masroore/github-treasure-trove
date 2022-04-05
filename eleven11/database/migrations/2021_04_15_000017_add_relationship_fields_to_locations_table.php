<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLocationsTable extends Migration
{
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table): void {
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id', 'company_fk_3556290')->references('id')->on('companies');
        });
    }
}
