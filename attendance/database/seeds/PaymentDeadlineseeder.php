<?php

use Illuminate\Database\Seeder;

class PaymentDeadlineseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deadline = new \App\Paymentdeadline([
            'date' => date('Y-m-d'),
            'deadline' => date('Y-m-d'),
        ]);
        $deadline->save();
    }
}
