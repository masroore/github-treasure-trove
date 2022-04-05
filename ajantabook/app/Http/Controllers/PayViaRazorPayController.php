<?php

namespace App\Http\Controllers;

use App\FailedTranscations;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class PayViaRazorPayController extends Controller
{
    public function payment(Request $request)
    {
        //Input items of form
        require_once 'price.php';
        $input = $request->all();

        $cart_table = Auth::user()->cart;
        $total = 0;

        $total = getcarttotal();

        $total = sprintf('%.2f', $total * $conversion_rate);

        if (round($request->actualtotal, 2) != $total) {
            notify()->error(__('Payment has been modifed !'), __('Please try again !'));

            return redirect(route('order.review'));
        }

        //get API Configuration
        $api = new Api(env('RAZOR_PAY_KEY'), env('RAZOR_PAY_SECRET'));

        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        require_once 'price.php';

        if (\count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api
                    ->payment
                    ->fetch($input['razorpay_payment_id'])->capture([
                        'amount' => $payment['amount'],
                    ]);

                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                $txn_id = $payment->id;

                $payment_status = 'yes';

                $checkout = new PlaceOrderController();

                return $checkout->placeorder($txn_id, 'Razorpay', session()->get('order_id'), $payment_status);
            } catch (Exception $e) {
                notify()->error($e->getMessage());
                $sentfromlastpage = 0;
                $failedTranscations = new FailedTranscations();
                $failedTranscations->order_id = $input['razorpay_payment_id'];
                $failedTranscations->txn_id = $input['razorpay_payment_id'];
                $failedTranscations->user_id = Auth::user()->id;
                $failedTranscations->save();

                return redirect()->route('order.review');
            }
        }
    }
}
