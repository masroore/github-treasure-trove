<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher = User::create([
            'first_name' => 'Kenneth',
            'last_name' => 'Antatino',
            'email' => 'kennethantatino@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $teacher->roles()->attach(Role::find(1));
        $student = User::create([
            'first_name' => 'Sample',
            'last_name' => 'Student 1',
            'email' => 'studentsample1@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $student->roles()->attach(Role::find(2));
        $student = User::create([
            'first_name' => 'Sample',
            'last_name' => 'Student 2',
            'email' => 'studentsample2@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $student->roles()->attach(Role::find(2));
        $student = User::create([
            'first_name' => 'Sample',
            'last_name' => 'Student 3',
            'email' => 'studentsample3@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $student->roles()->attach(Role::find(2));
        $student = User::create([
            'first_name' => 'Sample',
            'last_name' => 'Student 4',
            'email' => 'studentsample4@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $student->roles()->attach(Role::find(2));
        $student = User::create([
            'first_name' => 'Sample',
            'last_name' => 'Student 5',
            'email' => 'studentsample5@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $student->roles()->attach(Role::find(2));
    }
}
