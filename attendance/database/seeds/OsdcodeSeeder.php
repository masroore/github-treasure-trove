<?php

use Illuminate\Database\Seeder;

class OsdcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $osdcode = new \App\Osncode([
            'firstname' => 'Ahmed',
            'lastname'  => 'Ahia',
             'othernames'  => 'lamere',
             'email'  => 'ogua.ahmed18@gmail.com',
             'phone'  => '0272185090',
             'programme'  => 'Degree Programme',
             'amount'  => '200',
             'status'  => '0',
              'year'  => '2020',
              'code' => '8kUbFI0lR1itWnXYdK',
        ]);
        $osdcode->save();

        $osdcode = new \App\Osncode([
            'firstname' => 'Sarah',
            'lastname'  => 'Ahia',
             'othernames'  => 'lamere',
             'email'  => 'ogua.ahmed19@gmail.com',
             'phone'  => '0272185090',
             'programme'  => 'Diploma Programme',
             'amount'  => '200',
             'status'  => '0',
              'year'  => '2020',
              'code' => '8kUbFIAJKLitWnXYdK',
        ]);
        $osdcode->save();
    }
}
