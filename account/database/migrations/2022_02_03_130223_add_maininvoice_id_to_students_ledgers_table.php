<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaininvoiceIdToStudentsLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students_ledgers', function (Blueprint $table) {
            $table->integer('maininvoice_id')->default(0)->after('journal_entries_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students_ledgers', function (Blueprint $table) {

        });
    }
}
