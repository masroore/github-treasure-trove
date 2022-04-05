<?php

namespace Database\Seeders;

use App\Models\RoleHierarchy;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UsersAndNotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $numberOfUsers = 10;
        $numberOfNotes = 100;
        $usersIds = [];
        $statusIds = [];
        $faker = Faker::create();
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        RoleHierarchy::create([
            'role_id' => $adminRole->id,
            'hierarchy' => 1,
        ]);
        $userRole = Role::create(['name' => 'user']);
        RoleHierarchy::create([
            'role_id' => $userRole->id,
            'hierarchy' => 2,
        ]);
        $guestRole = Role::create(['name' => 'guest']);
        RoleHierarchy::create([
            'role_id' => $guestRole->id,
            'hierarchy' => 3,
        ]);
        // insert status
        DB::table('status')->insert([
            'name' => 'ongoing',
            'class' => 'badge badge-pill badge-primary',
        ]);
        $statusIds[] = DB::getPdo()->lastInsertId();
        DB::table('status')->insert([
            'name' => 'stopped',
            'class' => 'badge badge-pill badge-secondary',
        ]);
        $statusIds[] = DB::getPdo()->lastInsertId();
        DB::table('status')->insert([
            'name' => 'completed',
            'class' => 'badge badge-pill badge-success',
        ]);
        $statusIds[] = DB::getPdo()->lastInsertId();
        DB::table('status')->insert([
            'name' => 'expired',
            'class' => 'badge badge-pill badge-warning',
        ]);
        $statusIds[] = DB::getPdo()->lastInsertId();
        // insert users
        /*
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'menuroles' => 'user,admin'
        ]);
        for($i = 0; $i<$numberOfUsers; $i++){
            DB::table('users')->insert([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'menuroles' => 'user'
            ]);
            array_push($usersIds, DB::getPdo()->lastInsertId());
        }
        */
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'menuroles' => 'user,admin',
        ]);
        $user->assignRole('admin');
        $user->assignRole('user');

        $user = User::create([
            'name' => $faker->name(),
            'email' => 'user1@user.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'menuroles' => 'user',
        ]);
        $user->assignRole('user');
        $usersIds[] = $user->id;

        $user = User::create([
            'name' => $faker->name(),
            'email' => 'user2@user.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'menuroles' => 'user',
        ]);
        $user->assignRole('user');
        $usersIds[] = $user->id;

        for ($i = 0; $i < $numberOfUsers; ++$i) {
            $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'menuroles' => 'user',
            ]);
            $user->assignRole('user');
            $usersIds[] = $user->id;
        }
        // insert notes
        for ($i = 0; $i < $numberOfNotes; ++$i) {
            $noteType = $faker->word();
            if (random_int(0, 1)) {
                $noteType .= ' ' . $faker->word();
            }
            DB::table('notes')->insert([
                'title' => $faker->sentence(4, true),
                'content' => $faker->paragraph(3, true),
                'status_id' => $statusIds[random_int(0, count($statusIds) - 1)],
                'note_type' => $noteType,
                'applies_to_date' => $faker->date(),
                'users_id' => $usersIds[random_int(0, $numberOfUsers - 1)],
            ]);
        }
    }
}
