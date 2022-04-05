<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserActivityTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_activity', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('description');
            $table->unsignedInteger('user_id');
            $table->string('ip_address', 45);
            $table->text('user_agent');
            $table->timestamp('created_at')->nullable();
        });

        Schema::table('user_activity', function (Blueprint $table): void {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() != 'sqlite') {
            Schema::table('user_activity', function (Blueprint $table): void {
                $table->dropForeign('user_activity_user_id_foreign');
            });
        }

        Schema::drop('user_activity');

        \DB::table('permissions')->where('name', 'users.activity')->delete();
    }
}
