<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Nwidart\Modules\Facades\Module;

class PaymentProcessController extends Controller
{
    /** This function is used to process the payment */
    /** @param $request */
    /** @param $request->amount */
    /** @param $request->detail */
    /** @param $request->name */
    /** @param $request->currency */
    /** @param $request->email */
    /** @param $request->phone */
    /** @param $request->payment_method */
    /** @param $request->actual_total */
    /** @return to payment page */
    public function processPayement(Request $request)
    {
        $amount = round(Crypt::decrypt($request->amount), 2);
        $actualtotal = $request->actualtotal;
        $order_id = uniqid();
        $purpose = __('Payment for order :orderid', ['orderid' => $order_id]);
        $address = Address::findorfail(session()->get('address'));
        $currency = session()->get('currency')['id'];
        $payment_method = $request->payment_method;
        $email = $address->email;
        $phone = $address->phone;
        $name = $address->name;

        require_once 'price.php';

        $total = getcarttotal();

        $total = sprintf('%.2f', $total * $conversion_rate);

        $type = 'order';

        session()->put('payment_type', $type);

        session()->save();

        if (round($actualtotal, 2) != $total) {
            notify()->error(__('Payment has been modifed !'), __('Please try again !'));

            return redirect(route('order.review'));
        }

        if ('Instamojo' == $payment_method) {
            $instamojo = new InstamojoController();

            return $instamojo->payment($order_id, $amount, $name, $email, $phone, $purpose, $error = route('order.review'));
        }

        if ('Paypal' == $payment_method) {
            $paypal = new PaymentController();

            return $paypal->payWithpaypal($order_id, $amount, $name, $email, $phone, $purpose, $error = route('order.review'));
        }

        if ('Paytm' == $payment_method) {
            $paytm = new PaytmController();

            return $paytm->payProcess($order_id, $amount, $name, $email, $phone, $purpose, $error = route('order.review'));
        }

        if ('Cashfree' == $payment_method) {
            $cf = new CashfreeController();

            return $cf->pay($order_id, $amount, $name, $email, $phone, $purpose, $error = route('order.review'));
        }

        if ('Payu' == $payment_method) {
            $payu = new PayuController();

            return $payu->payment($order_id, $amount, $name, $email, $phone, $purpose, $error = route('order.review'));
        }

        // Addon DPO Payment

        if ('DPOPayment' == $payment_method && Module::has('DPOPayment') && Module::find('DPOPayment')->isEnabled()) {
            $dpo = new \Modules\DPOPayment\Http\Controllers\DPOPaymentController();

            return $dpo->createToken($order_id, $amount, $name, $email, $phone, $purpose, $error = route('order.review'));
        }

        if ('Onepay' == $payment_method && Module::has('Onepay') && Module::find('onepay')->isEnabled()) {
            $onepay = new \Modules\Onepay\Http\Controllers\OnepayController();

            return $onepay->dopayment($order_id, $amount, $name, $email, $phone, $purpose, $error = route('order.review'));
        }
    }
}
