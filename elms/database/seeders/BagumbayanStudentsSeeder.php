<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BagumbayanStudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->encodeCSV('csvs/masterlist/bagumbayan.csv', 5);
    }

    public function encodeCSV($path, $college_id): void
    {
        $students = [];
        $handle = fopen(storage_path($path), 'rb');
        while (($data = fgetcsv($handle)) !== false) {
            $students[] = $data;
        }
        array_splice($students, 0, 1);
        foreach ($students as $key => $student) {
            $u = User::create([
                'campus_id' => 5,
                'name' => ucwords(trim(strtolower($student[1] . ' ' . $student[0]))),
                'email' => str_replace('ñ', 'n', str_replace(' ', '', strtolower(str_replace(['JR.', 'III', 'IV', 'II'], '', $student[1]) . $student[0] . '@sksu.edu.ph'))),
                'email_verified_at' => now(),
                // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'password' => bcrypt(base64_encode(explode(' ', trim(strtolower($student[1])))[0])), // password
                'remember_token' => Str::random(10),
            ]);
            $u->roles()->attach(Role::find(2));
            $u->student()->create([
                'college_id' => 15,
                'department_id' => $this->getDepartment($student[9]),
            ]);
        }
    }

    public function getDepartment($dep)
    {
        if (str_contains($dep, 'Agribusiness')) {
            return 38;
        }
        if (str_contains($dep, 'Agri-Fishery')) {
            return 39;
        }
    }
}
