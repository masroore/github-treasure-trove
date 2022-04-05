<?php

namespace App\Http\Controllers;

use App\FailedTranscations;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Paystack;

class PaystackController extends Controller
{
    public function pay(Request $request)
    {
        if ('NGN' != Session::get('currency')['id']) {
            notify()->error(__('Paystack only support NGN currency.'));

            return redirect(route('order.review'));
        }

        // If Payment is valid than redirect to thier Paystack Payment Page
        try {
            return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (Exception $e) {
            notify()->error($e->getMessage());

            return redirect(route('order.review'));
        }
    }

    public function callback()
    {
        $paymentDetails = Paystack::getPaymentData();

        if ('success' == $paymentDetails['data']['status']) {
            $txn_id = $paymentDetails['data']['id'];

            $payment_status = 'yes';

            $checkout = new PlaceOrderController();

            return $checkout->placeorder($txn_id, 'Paystack', session()->get('order_id'), $payment_status);
        }
        $failedTranscations = new FailedTranscations();
        $failedTranscations->order_id = session()->get('order_id');
        $failedTranscations->txn_id = 'PAYSTACK_FAILED_' . Str::uuid();
        $failedTranscations->user_id = auth()->id();
        $failedTranscations->save();
        notify()->error($paymentDetails['data']['message']);

        return redirect(route('order.review'));
    }
}
