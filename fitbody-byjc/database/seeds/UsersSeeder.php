<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create admins
        DB::insert(
            "INSERT INTO `users` (`name`, `email`, `password`, `remember_token`, `role`, `status`, `created_at`, `updated_at`) VALUES
              ('Filip Jankoski', 'filip@agmedia.hr', '" . bcrypt('majamaja001') . "', '', 'admin', 1, NOW(), NOW()),
              ('Tomislav Jureša', 'tomislav@agmedia.hr', '" . bcrypt('bakanal') . "', '', 'admin', 1, NOW(), NOW())"
        );

        // create admins details
        DB::insert(
            "INSERT INTO `user_details` (`user_id`, `fname`, `lname`, `address`, `zip`, `city`, `avatar`, `bio`, `social`, `created_at`, `updated_at`) VALUES
              (1, 'Filip', 'Jankoski', 'Kovačića 23', '44320', 'Kutina', 'media/images/avatar.jpg', 'Lorem ipsum...', '790117367', NOW(), NOW()),
              (2, 'Tomislav', 'Jureša', 'Malešnica bb', '10000', 'Zagreb', 'media/images/avatar.jpg', 'Lorem ipsum...', '', NOW(), NOW())"
        );

        // Create App Settings
        DB::insert(
            'INSERT INTO `app_settings` (`id`, `user_id`, `sidebar_inverse`, `created_at`, `updated_at`) VALUES
                (1, 1, 1, NOW(), NOW()),
                (2, 2, 0, NOW(), NOW());'
        );

        // Set admin roles to default users
        $user1 = User::where('id', 1)->first();
        $user2 = User::where('id', 2)->first();

        Bouncer::assign('admin')->to($user1);
        Bouncer::assign('admin')->to($user2);
    }
}
