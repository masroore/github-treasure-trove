<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddComplstatusToStudentinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('studentinfos', function (Blueprint $table) {
            $table->string('completstatus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('studentinfos', 'completstatus')) {
            Schema::table('studentinfos', function (Blueprint $table) {
                $table->dropColumn('completstatus');
            });
        }
    }
}
