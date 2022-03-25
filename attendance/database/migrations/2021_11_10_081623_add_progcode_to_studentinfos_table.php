<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProgcodeToStudentinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('studentinfos', function (Blueprint $table) {
            $table->string('progcode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('studentinfos', 'progcode')) {
            Schema::table('studentinfos', function (Blueprint $table) {
                $table->dropColumn('progcode');
            });
        }
    }
}
