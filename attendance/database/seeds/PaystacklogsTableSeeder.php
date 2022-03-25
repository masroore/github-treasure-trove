<?php

use Illuminate\Database\Seeder;

class PaystacklogsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {

      //  \DB::table('paystacklogs')->delete();

        \DB::table('paystacklogs')->insert([
            0 => [
                'id' => 1,
                'pid' => '2',
                'type' => 'action',
                'message' => 'Attempted to pay with mobile money',
                'time' => '16',
            ],
            1 => [
                'id' => 2,
                'pid' => '3',
                'type' => 'action',
                'message' => 'Attempted to pay with mobile money',
                'time' => '13',
            ],
            2 => [
                'id' => 3,
                'pid' => '3',
                'type' => 'action',
                'message' => 'Attempted to pay with mobile money',
                'time' => '23',
            ],
            3 => [
                'id' => 4,
                'pid' => '3',
                'type' => 'action',
                'message' => 'Attempted to pay with mobile money',
                'time' => '42',
            ],
            4 => [
                'id' => 5,
                'pid' => '3',
                'type' => 'action',
                'message' => 'Attempted to pay with mobile money',
                'time' => '69',
            ],
            5 => [
                'id' => 6,
                'pid' => '3',
                'type' => 'success',
                'message' => 'Successfully paid with mobile_money',
                'time' => '74',
            ],
            6 => [
                'id' => 7,
                'pid' => '4',
                'type' => 'action',
                'message' => 'Set payment method to: card',
                'time' => '6',
            ],
            7 => [
                'id' => 8,
                'pid' => '4',
                'type' => 'action',
                'message' => 'Attempted to pay with card',
                'time' => '10',
            ],
            8 => [
                'id' => 9,
                'pid' => '4',
                'type' => 'error',
                'message' => 'Error: Declined',
                'time' => '15',
            ],
            9 => [
                'id' => 10,
                'pid' => '4',
                'type' => 'action',
                'message' => 'Set payment method to: mobile_money',
                'time' => '21',
            ],
            10 => [
                'id' => 11,
                'pid' => '4',
                'type' => 'action',
                'message' => 'Attempted to pay with mobile money',
                'time' => '25',
            ],
            11 => [
                'id' => 12,
                'pid' => '4',
                'type' => 'action',
                'message' => 'Set payment method to: card',
                'time' => '39',
            ],
            12 => [
                'id' => 13,
                'pid' => '4',
                'type' => 'action',
                'message' => 'Attempted to pay with card',
                'time' => '43',
            ],
            13 => [
                'id' => 14,
                'pid' => '4',
                'type' => 'auth',
                'message' => 'Authentication Required: 3DS',
                'time' => '45',
            ],
            14 => [
                'id' => 15,
                'pid' => '4',
                'type' => 'action',
                'message' => 'Set payment method to: mobile_money',
                'time' => '52',
            ],
            15 => [
                'id' => 16,
                'pid' => '4',
                'type' => 'action',
                'message' => 'Set payment method to: card',
                'time' => '53',
            ],
            16 => [
                'id' => 17,
                'pid' => '4',
                'type' => 'input',
                'message' => 'Filled this field: card number',
                'time' => '82',
            ],
            17 => [
                'id' => 18,
                'pid' => '4',
                'type' => 'input',
                'message' => 'Filled this field: card expiry',
                'time' => '93',
            ],
            18 => [
                'id' => 19,
                'pid' => '4',
                'type' => 'input',
                'message' => 'Filled this field: card cvv',
                'time' => '104',
            ],
            19 => [
                'id' => 20,
                'pid' => '4',
                'type' => 'action',
                'message' => 'Attempted to pay with card',
                'time' => '104',
            ],
            20 => [
                'id' => 21,
                'pid' => '4',
                'type' => 'success',
                'message' => 'Successfully paid with card',
                'time' => '105',
            ],
        ]);
    }
}
