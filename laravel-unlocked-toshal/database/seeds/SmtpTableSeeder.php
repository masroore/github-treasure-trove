<?php

use App\SmtpInformation;
use Illuminate\Database\Seeder;

class SmtpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usercount = SmtpInformation::where('from_email', 'developersd.shinedezign@gmail.com')->count();
        if ($usercount == 0) {
            SmtpInformation::create([
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'username' => 'developersd.shinedezign@gmail.com',
                'from_email' => 'developersd.shinedezign@gmail.com',
                'from_name' => 'Unlocked',
                'password' => 'sxfwuillpwapakep',
                'encryption' => 'tls',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
