<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('processes', function (Blueprint $table): void {
            $table->id();
            $table->string('name_process', 50);
            $table->string('description', 200);
            $table->string('icon');
            $table->string('route', 50);
            $table->integer('order');
            $table->boolean('special_permission')->default(false);

            $table->unsignedBigInteger('menu_id');

            $table->foreign('menu_id')->references('id')->on('menus');
        });
        DB::table('processes')->insert([
            /*
          |--------------------------------------------------------------------------
          | Admin SISTEM 1 - 7
          |--------------------------------------------------------------------------
         */
            [
                'name_process' => 'Profiles',
                'description' => 'Profiles',
                'icon' => '',
                'route' => 'profiles',
                'order' => '1',
                'menu_id' => 1,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Users',
                'description' => 'Users',
                'icon' => '',
                'route' => 'users',
                'order' => '2',
                'menu_id' => 1,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Sessions Actives',
                'description' => 'Sessions Actives',
                'icon' => '',
                'route' => 'logged_users',
                'order' => '3',
                'menu_id' => 1,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Access Restricteds',
                'description' => 'Access Restricteds',
                'icon' => '',
                'route' => 'restricted_access',
                'order' => '4',
                'menu_id' => 1,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Monitoring of Login',
                'description' => 'Monitoring of Login',
                'icon' => '',
                'route' => 'access_history',
                'order' => '5',
                'menu_id' => 1,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Monitoring Attempts of Login',
                'description' => 'Monitoring Attempts of Login',
                'icon' => '',
                'route' => 'failed_login',
                'order' => '6',
                'menu_id' => 1,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Time Inactivity',
                'description' => 'Time of Inactivity',
                'icon' => '',
                'route' => 'time_inactivity',
                'order' => '7',
                'menu_id' => 1,
                'special_permission' => 0,
            ],
            /*
          |--------------------------------------------------------------------------
          | Admin MAINTENANCE 8 - 17
          |--------------------------------------------------------------------------
         */
            [
                'name_process' => 'Type of Coin',
                'description' => 'Type of Coin',
                'icon' => '',
                'route' => 'typeCoin',
                'order' => '1',
                'menu_id' => 2,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Type of Storage',
                'description' => 'Type of Storage',
                'icon' => '',
                'route' => 'typeStore',
                'order' => '2',
                'menu_id' => 2,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Storages',
                'description' => 'Storages',
                'icon' => '',
                'route' => 'storage',
                'order' => '3',
                'menu_id' => 2,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Trade Marks',
                'description' => 'Trade Marks',
                'icon' => '',
                'route' => 'trade_marks',
                'order' => '4',
                'menu_id' => 2,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Models',
                'description' => 'Models',
                'icon' => '',
                'route' => 'models',
                'order' => '5',
                'menu_id' => 2,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Account Type',
                'description' => 'Account Type',
                'icon' => '',
                'route' => 'type_account',
                'order' => '6',
                'menu_id' => 2,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Transactions Type',
                'description' => 'Transactions Type',
                'icon' => '',
                'route' => 'type_transactions',
                'order' => '7',
                'menu_id' => 2,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Transactions',
                'description' => 'Transactions',
                'icon' => '',
                'route' => 'transactions',
                'order' => '8',
                'menu_id' => 2,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Methods Pay',
                'description' => 'Methods Pay',
                'icon' => '',
                'route' => 'pay_methods',
                'order' => '9',
                'menu_id' => 2,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Franchises',
                'description' => 'Franchises',
                'icon' => '',
                'route' => 'franchise',
                'order' => '10',
                'menu_id' => 2,
                'special_permission' => 0,
            ],
            /*
          |--------------------------------------------------------------------------
          | Admin ADQUIRENCE 18 - 19
          |--------------------------------------------------------------------------
         */
            [
                'name_process' => 'Banks',
                'description' => 'Banks',
                'icon' => '',
                'route' => 'banks',
                'order' => '1',
                'menu_id' => 3,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Agencies',
                'description' => 'Agencies',
                'icon' => '',
                'route' => 'agency',
                'order' => '2',
                'menu_id' => 3,
                'special_permission' => 0,
            ],
            /*
          |--------------------------------------------------------------------------
          | Admin POS 20 - 26
          |--------------------------------------------------------------------------
         */
            [
                'name_process' => 'Register POS',
                'description' => 'Register points of sales to the system',
                'icon' => '',
                'route' => 'pos_register',
                'order' => '1',
                'menu_id' => 4,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Update Register Pos',
                'description' => 'Update Register points of sales to the system',
                'icon' => '',
                'route' => 'pos_register_edit',
                'order' => '2',
                'menu_id' => 4,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Request POS',
                'description' => 'Request POS',
                'icon' => '',
                'route' => 'pos_request',
                'order' => '3',
                'menu_id' => 4,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Send POS',
                'description' => 'Send POS',
                'icon' => '',
                'route' => 'pos_send_request',
                'order' => '4',
                'menu_id' => 4,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Reception POS',
                'description' => 'Reception POS',
                'icon' => '',
                'route' => 'pos_reception',
                'order' => '5',
                'menu_id' => 4,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Adaptation POS',
                'description' => 'Adaptation POS',
                'icon' => '',
                'route' => 'pos_adaptation',
                'order' => '6',
                'menu_id' => 4,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Configuration POS',
                'description' => 'Configuration POS',
                'icon' => '',
                'route' => 'pos_configuration',
                'order' => '7',
                'menu_id' => 4,
                'special_permission' => 0,
            ],
            /*
          |--------------------------------------------------------------------------
          | Admin CLIENT 27 - 31
          |--------------------------------------------------------------------------
         */
            [
                'name_process' => 'Register Client',
                'description' => 'Register Client',
                'icon' => '',
                'route' => 'client',
                'order' => '1',
                'menu_id' => 5,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Update Client',
                'description' => 'Update Client',
                'icon' => '',
                'route' => 'client_edit',
                'order' => '2',
                'menu_id' => 5,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Pre Opening Accounts',
                'description' => 'Pre Opening Accounts',
                'icon' => '',
                'route' => 'pre_opening_account',
                'order' => '3',
                'menu_id' => 5,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'POS Assignment',
                'description' => 'POS Assignment',
                'icon' => '',
                'route' => 'pos_assignment',
                'order' => '4',
                'menu_id' => 5,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Pay POS',
                'description' => 'Pay POS',
                'icon' => '',
                'route' => 'charge_pos',
                'order' => '5',
                'menu_id' => 5,
                'special_permission' => 0,
            ],
            /*
          |--------------------------------------------------------------------------
          | Admin CONSULT 31 - 33
          |--------------------------------------------------------------------------
         */
            [
                'name_process' => 'Consult POS',
                'description' => 'consult Pos',
                'icon' => '',
                'route' => 'consult',
                'order' => '1',
                'menu_id' => 6,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Consult Request POS',
                'description' => 'Consult Request POS',
                'icon' => '',
                'route' => 'consult2',
                'order' => '2',
                'menu_id' => 6,
                'special_permission' => 0,
            ],
            [
                'name_process' => 'Consult Client',
                'description' => 'Consult client',
                'icon' => '',
                'route' => 'consult_client',
                'order' => '3',
                'menu_id' => 6,
                'special_permission' => 0,
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processes');
    }
}
