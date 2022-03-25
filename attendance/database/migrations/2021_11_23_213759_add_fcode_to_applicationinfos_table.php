<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFcodeToApplicationinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicationinfos', function (Blueprint $table) {
            $table->string('fcode')->nullable();
            $table->string('scode')->nullable();
            $table->string('tcode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('applicationinfos', 'fcode')) {
            Schema::table('applicationinfos', function (Blueprint $table) {
                $table->dropColumn('fcode');
            });
        }

        if (Schema::hasColumn('applicationinfos', 'scode')) {
            Schema::table('applicationinfos', function (Blueprint $table) {
                $table->dropColumn('scode');
            });
        }

        if (Schema::hasColumn('applicationinfos', 'tcode')) {
            Schema::table('applicationinfos', function (Blueprint $table) {
                $table->dropColumn('tcode');
            });
        }
    }
}
