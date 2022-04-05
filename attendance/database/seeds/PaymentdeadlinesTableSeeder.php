<?php

use Illuminate\Database\Seeder;

class PaymentdeadlinesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {

        //\DB::table('paymentdeadlines')->delete();

        \DB::table('paymentdeadlines')->insert([
            0 => [
                'id' => 1,
                'acdemicyear' => '2020-2021',
                'semester' => 'First Semester',
                'date' => '2021-11-10',
                'deadline' => '2021-11-30',
            ],
        ]);
    }
}
