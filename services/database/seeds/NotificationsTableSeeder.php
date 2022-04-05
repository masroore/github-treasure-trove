<?php
/*
 * File name: NotificationsTableSeeder.php
 * Last modified: 2021.03.01 at 21:24:33
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('notifications')->delete();
    }
}
