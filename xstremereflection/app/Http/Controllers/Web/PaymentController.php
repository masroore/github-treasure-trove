<?php

namespace Vanguard\Http\Controllers\Web;

use Exception;

use Stripe\Charge;
use Stripe\Stripe;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Invoice;
use Vanguard\InvoicePayment;

class PaymentController extends Controller
{
    public function paymentProcess($id, $type)
    {
        $invoice = Invoice::find($id);

        if ($type == 1) {
            $amount = $invoice->deposit * 100;
        } elseif ($type == 2) {
            $amount = $invoice->total - $invoice->totalPaid * 100;
        }

        try {
            Stripe::setApiKey(env('stripeTestKey'));

            $token = $_POST['stripeToken'];
            $charge = Charge::create([
                'amount' => $amount,
                'currency' => 'usd',
                'description' => 'Example Charge',
                'source' => $token,
            ]);

            $paid = $invoice->totalPaid + $amount;

            $invoice->totalPaid = $paid;
            $invoice->save();

            $amount = number_format(($amount / 100), 2);

            $invoicePayment = new InvoicePayment();

            $invoicePayment->invoiceId = $invoice->id;
            $invoicePayment->pmtAmount = $amount;
            $invoicePayment->save();

            return view('invoice.summary', compact('invoice'));
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
