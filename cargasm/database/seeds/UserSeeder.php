<?php

use App\Models\User as UserAlias;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@app.com',
                'phone' => '0671111111',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'name' => 'Optimus',
                'surname' => 'Prime',
                'nickname' => 'admin',
                'role' => 'admin',
                'status' => \App\Models\User::STATUS_APPROVED,
                'domain' => \App\Models\Domain::inRandomOrder()->first()->url,
                'email_verified_at' => now(),
                'privacy' => [
                    'fio' => 'true',
                    'phone' => 'true',
                    'email' => 'true',
                ],
                'social' => [
                    'vk' => 'https://vk.com/feed',
                    'youtube' => '',
                    'facebook' => 'https://www.facebook.com',
                    'ok' => '',
                ],
            ],
            [
                'email' => 'partner@app.com',
                'phone' => '0672222222',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'name' => 'Partner',
                'surname' => 'Prime',
                'nickname' => 'partner',
                'role' => 'partner',
                'status' => \App\Models\User::STATUS_APPROVED,
                'domain' => \App\Models\Domain::inRandomOrder()->first()->url,
                'email_verified_at' => now(),
                'privacy' => [
                    'fio' => 'true',
                    'phone' => 'true',
                    'email' => 'true',
                ],
                'social' => [
                    'vk' => 'https://vk.com/feed',
                    'youtube' => '',
                    'facebook' => 'https://www.facebook.com',
                    'ok' => '',
                ],
            ],

            [
                'email' => 'user@app.com',
                'phone' => '0673333333',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'name' => 'Yarik',
                'surname' => 'Man',
                'nickname' => 'yarikman',
                'role' => 'user',
                'status' => \App\Models\User::STATUS_APPROVED,
                'domain' => \App\Models\Domain::inRandomOrder()->first()->url,
                'email_verified_at' => now(),
                'privacy' => [
                    'fio' => 'true',
                    'phone' => 'true',
                    'email' => 'true',
                ],
                'social' => [
                    'vk' => 'https://vk.com/feed',
                    'youtube' => '',
                    'facebook' => 'https://www.facebook.com',
                    'ok' => '',
                ],
            ],
        ];

        foreach ($users as $user) {
            UserAlias::create($user);
        }
    }
}
