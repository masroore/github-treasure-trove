<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBorrowerGroupMembersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrower_group_members', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('borrower_group_id')->nullable();
            $table->integer('borrower_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('borrower_group_members');
    }
}
