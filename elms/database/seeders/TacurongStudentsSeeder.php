<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TacurongStudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->encodeCSV('csvs/masterlist/tacurong/artsci.csv', 9);
        $this->encodeCSV('csvs/masterlist/tacurong/cbah.csv', 10);
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
                'campus_id' => 3,
                'name' => ucwords(trim(strtolower($student[1] . ' ' . $student[0]))),
                'email' => str_replace('ñ', 'n', str_replace(' ', '', strtolower(str_replace(['JR.', 'III', 'IV', 'II'], '', $student[1]) . $student[0] . '@sksu.edu.ph'))),
                'email_verified_at' => now(),
                // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'password' => bcrypt(base64_encode(explode(' ', trim(strtolower($student[1])))[0])), // password
                'remember_token' => Str::random(10),
            ]);
            $u->roles()->attach(Role::find(2));
            $u->student()->create([
                'college_id' => $college_id,
                'department_id' => $this->getDepartment($student[9]),
            ]);
        }
    }

    public function getDepartment($dep)
    {
        if (str_contains($dep, 'AB-Econ')) {
            return 21;
        }
        if (str_contains($dep, 'AB-PolSci')) {
            return 22;
        }
        if (str_contains($dep, 'Biology')) {
            return 23;
        }
        if (str_contains($dep, 'Environmental Science')) {
            return 24;
        }
        if (str_contains($dep, 'Entrepreneurship')) {
            return 25;
        }
        if (str_contains($dep, 'Accountancy')) {
            return 26;
        }
        if (str_contains($dep, 'Management Accounting')) {
            return 27;
        }
        if (str_contains($dep, 'Hospitality Management')) {
            return 28;
        }
        if (str_contains($dep, 'Accounting Information System')) {
            return 29;
        }
        if (str_contains($dep, 'Tourism Management')) {
            return 30;
        }
    }
}
