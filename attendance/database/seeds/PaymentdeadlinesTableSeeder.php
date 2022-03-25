<?php

use Illuminate\Database\Seeder;

class PaymentdeadlinesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
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
