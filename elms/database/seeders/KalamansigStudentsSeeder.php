<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KalamansigStudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->encodeCSV('csvs/masterlist/kalamansig/BEED.csv', 33, 11);
        $this->encodeCSV('csvs/masterlist/kalamansig/BFT.csv', 35, 12);
        $this->encodeCSV('csvs/masterlist/kalamansig/BS-CRIM.csv', 36, 13);
        $this->encodeCSV('csvs/masterlist/kalamansig/BSBIO.csv', 34, 12);
        $this->encodeCSV('csvs/masterlist/kalamansig/BSED-ENG.csv', 32, 11);
        $this->encodeCSV('csvs/masterlist/kalamansig/BSED-FIL.csv', 32, 11);
        $this->encodeCSV('csvs/masterlist/kalamansig/BSED-SCI.csv', 32, 11);
        $this->encodeCSV('csvs/masterlist/kalamansig/BSF-NEWCurr.csv', 35, 12);
        $this->encodeCSV('csvs/masterlist/kalamansig/BSF-OLDCURR.csv', 35, 12);
        $this->encodeCSV('csvs/masterlist/kalamansig/BSIT-NewCurr.csv', 37, 14);
        $this->encodeCSV('csvs/masterlist/kalamansig/BSIT-OLDCUrr.csv', 37, 14);
        $this->encodeCSV('csvs/masterlist/kalamansig/DIT.csv', 31, 11);
    }

    public function encodeCSV($path, $department_id, $college_id): void
    {
        $students = [];
        $handle = fopen(storage_path($path), 'rb');
        while (($data = fgetcsv($handle)) !== false) {
            $students[] = $data;
        }
        foreach ($students as $key => $student) {
            $name = explode(', ', $student[1]);
            $u = User::create([
                'campus_id' => 4,
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
                'department_id' => $department_id,
            ]);
        }
    }
}
