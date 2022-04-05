<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->encodeCSV('csvs/students.csv', null);
    }

    public function encodeCSV($path, $campus_id): void
    {
        $students = [];
        $handle = fopen(storage_path($path), 'rb');
        while (($data = fgetcsv($handle)) !== false) {
            $students[] = $data;
        }
        foreach ($students as $key => $student) {
            $u = User::create([
                'campus_id' => $campus_id,
                'name' => ucwords(trim(strtolower($student[0] . ' ' . $student[1]))),
                'email' => strtolower($student[2]),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                // 'password' => bcrypt(base64_encode(explode(' ', trim($student[0]))[0])), // password
                'remember_token' => Str::random(10),
            ]);
            $u->roles()->attach(Role::find(2));
            $u->student()->create([
                'college_id' => null,
                'department_id' => null,
            ]);
        }
    }
}
