<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToRandomCodesTable extends Migration
{
    public function up()
    {
        Schema::table('random_codes', function (Blueprint $table) {
            $table->unsignedBigInteger('location_code_id');
            $table->foreign('location_code_id', 'location_code_fk_3563124')->references('id')->on('locations');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id', 'company_fk_3563316')->references('id')->on('companies');
        });
    }
}
