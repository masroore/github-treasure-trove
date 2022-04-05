<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name_user', 200);
            $table->string('surname_user', 200);
            $table->string('username', 20)->unique();
            $table->string('password', 60);
            $table->string('document', 20)->unique();
            $table->string('phone', 20);
            $table->string('email', 50)->unique();
            $table->boolean('special_permission')->default(false);
            $table->boolean('sensitive_info')->default(false);
            $table->boolean('change_password')->default(false);
            $table->boolean('locked')->default(false);
            $table->string('time_inactivity', 255);
            $table->string('avatar', 20)->default('0001');

            $table->unsignedBigInteger('type_document_id');
            $table->unsignedBigInteger('telephone_operator_id');
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('theme_id');

            $table->BigInteger('user_id');
            $table->timestamp('date_register')->nullable();
            $table->string('ip', 20);

            $table->foreign('type_document_id')->references('id')->on('type_documents');
            $table->foreign('telephone_operator_id')->references('id')->on('telephone_operators');
            $table->foreign('profile_id')->references('id')->on('profiles');
            $table->foreign('theme_id')->references('id')->on('themes');

            $table->index('username');
        });

        DB::table('users')->insert([
            [
                'name_user' => 'Administrador',
                'surname_user' => 'Administrador Master',
                'username' => 'puropago',
                'password' => Hash::make('Puropago.1'),
                'document' => '99999999',
                'phone' => '2329356',
                'email' => 'admin@firstswitch.com',
                'special_permission' => 1,
                'sensitive_info' => 1,
                'change_password' => 0,
                'locked' => 0,
                'time_inactivity' => 18000,
                'type_document_id' => 1,
                'telephone_operator_id' => 1,
                'profile_id' => 1,
                'theme_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_user' => 'Miguel',
                'surname_user' => 'Rivero',
                'username' => 'mrivero',
                'password' => Hash::make('Puropago.1'),
                'document' => '16345339',
                'phone' => '2329356',
                'email' => 'mrivero@puropago.com',
                'special_permission' => 1,
                'sensitive_info' => 1,
                'change_password' => 0,
                'locked' => 0,
                'time_inactivity' => 180,
                'type_document_id' => 1,
                'telephone_operator_id' => 1,
                'profile_id' => 1,
                'theme_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_user' => 'Laura ',
                'surname_user' => 'Sionchez',
                'username' => 'lsionchez',
                'password' => Hash::make('Puropago.1'),
                'document' => '20824432',
                'phone' => '2329356',
                'email' => 'lsionchez@puropago.com',
                'special_permission' => 1,
                'sensitive_info' => 1,
                'change_password' => 0,
                'locked' => 0,
                'time_inactivity' => 180,
                'type_document_id' => 1,
                'telephone_operator_id' => 1,
                'profile_id' => 1,
                'theme_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_user' => 'Fernando',
                'surname_user' => 'vieira',
                'username' => 'fvieira',
                'password' => Hash::make('Puropago.1'),
                'document' => '25232641',
                'phone' => '2329356',
                'email' => 'fvieira@puropago.com',
                'special_permission' => 1,
                'sensitive_info' => 1,
                'change_password' => 0,
                'locked' => 0,
                'time_inactivity' => 180,
                'type_document_id' => 1,
                'telephone_operator_id' => 1,
                'profile_id' => 1,
                'theme_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_user' => 'Yosmel',
                'surname_user' => 'Carrillo',
                'username' => 'ycarrillo',
                'password' => Hash::make('Puropago.1'),
                'document' => '22031381',
                'phone' => '2329356',
                'email' => 'ycarrillo@puropago.com',
                'special_permission' => 1,
                'sensitive_info' => 1,
                'change_password' => 0,
                'locked' => 0,
                'time_inactivity' => 180,
                'type_document_id' => 1,
                'telephone_operator_id' => 1,
                'profile_id' => 1,
                'theme_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_user' => 'Miriangely',
                'surname_user' => 'Chilquito',
                'username' => 'mchiquito',
                'password' => Hash::make('Puropago.1'),
                'document' => '25213269',
                'phone' => '2329356',
                'email' => 'mchiquito@puropago.com',
                'special_permission' => 1,
                'sensitive_info' => 1,
                'change_password' => 0,
                'locked' => 0,
                'time_inactivity' => 180,
                'type_document_id' => 1,
                'telephone_operator_id' => 1,
                'profile_id' => 1,
                'theme_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_user' => 'Ysaias',
                'surname_user' => 'Gonzalez',
                'username' => 'ygonzalez',
                'password' => Hash::make('Puropago.1'),
                'document' => '20701047',
                'phone' => '2329356',
                'email' => 'ygonzalez@puropago.com',
                'special_permission' => 1,
                'sensitive_info' => 1,
                'change_password' => 0,
                'locked' => 0,
                'time_inactivity' => 180,
                'type_document_id' => 1,
                'telephone_operator_id' => 1,
                'profile_id' => 1,
                'theme_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_user' => 'Diana',
                'surname_user' => 'Altuve',
                'username' => 'd.altuve',
                'password' => Hash::make('Puropago.1'),
                'document' => '23778230',
                'phone' => '9141572',
                'email' => 'daltuve@puropago.com',
                'special_permission' => 1,
                'sensitive_info' => 1,
                'change_password' => 0,
                'locked' => 0,
                'time_inactivity' => 180000,
                'type_document_id' => 1,
                'telephone_operator_id' => 1,
                'profile_id' => 1,
                'theme_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_user' => 'Thailys',
                'surname_user' => 'Paraco',
                'username' => 'tparaco',
                'password' => Hash::make('Puropago.1'),
                'document' => '1234567',
                'phone' => '1234567',
                'email' => 'tparaco@sitca-ve.com',
                'special_permission' => 1,
                'sensitive_info' => 1,
                'change_password' => 1,
                'locked' => 0,
                'time_inactivity' => 180,
                'type_document_id' => 1,
                'telephone_operator_id' => 1,
                'profile_id' => 1,
                'theme_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_user' => 'Victor',
                'surname_user' => 'Zapata',
                'username' => 'vzapata',
                'password' => Hash::make('Puropago.1'),
                'document' => '1234568',
                'phone' => '1234568',
                'email' => 'vzapata@sitca-ve.com',
                'special_permission' => 1,
                'sensitive_info' => 1,
                'change_password' => 1,
                'locked' => 0,
                'time_inactivity' => 180,
                'type_document_id' => 1,
                'telephone_operator_id' => 1,
                'profile_id' => 1,
                'theme_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_user' => 'Seguridad',
                'surname_user' => 'Informacion',
                'username' => 'sinformacion',
                'password' => Hash::make('Puropago.1'),
                'document' => '123456789',
                'phone' => '1234569',
                'email' => 'seguridad.info@puropago.com',
                'special_permission' => 1,
                'sensitive_info' => 1,
                'change_password' => 1,
                'locked' => 0,
                'time_inactivity' => 180,
                'type_document_id' => 1,
                'telephone_operator_id' => 1,
                'profile_id' => 2,
                'theme_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_user' => 'Carlos',
                'surname_user' => 'Velasquez',
                'username' => 'cvelasquez',
                'password' => Hash::make('Puropago.1'),
                'document' => '22040152',
                'phone' => '1234569',
                'email' => 'cvelasquez@sitca-ve.com',
                'special_permission' => 1,
                'sensitive_info' => 1,
                'change_password' => 1,
                'locked' => 0,
                'time_inactivity' => 180,
                'type_document_id' => 1,
                'telephone_operator_id' => 1,
                'profile_id' => 2,
                'theme_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
