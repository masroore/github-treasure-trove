<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class PaypalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $client;

    public function __construct()
    {
        $environment = new SandboxEnvironment(env('PAYPAL_SANDBOX_CLIENT_ID'), env('PAYPAL_SANDBOX_CLIENT_SECRET'));
        $this->client = new PayPalHttpClient($environment);
        // dd($this->client);
    }

    public function payment(Request $request)
    {
        // if ($request->paypal_deposit_amt > 1) {
        //     if (!auth()->user()->paypal_email) {
        //         return redirect()->back()->with('error', 'Your Paypal is not verify kindly verify it first!');
        //     }
        // }
        // dd($request->all());
        $amt = $request->paypal_deposit_amt;
        $request = new OrdersCreateRequest();
        $request->headers['prefer'] = 'return=representation';
        $request->body = self::checkoutData($amt);
        $response = $this->client->execute($request);
        // dd($response);
        if (201 == $response->statusCode) {
            foreach ($response->result->links as $link) {
                if ('approve' == $link->rel) {
                    return redirect($link->href);
                }
            }
        } else {
            abort(500);
        }
    }

    public function cancel(): void
    {
        dd('Your payment is canceled. You can create cancel page here.');
    }

    /**
     * Responds with a welcome message with instructions.
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        $req = new OrdersCaptureRequest($request->token);
        $response = $this->client->execute($req);
        // dd($response);
        if (201 == $response->statusCode && 'COMPLETED' == $response->result->status) {
            $transaction = TransactionController::store($response);
            if ($transaction) {
                if (1 == $transaction->gross_amt) {
                    return redirect('/')->with('message', 'Your Payment Method is Verified!');
                }

                return redirect('/')->with('message', 'Transaction is completed!');
            }
            abort(500);
        }
        // dd($response);
    }

    public static function checkoutData($amt)
    {
        return [
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('payment.success'),
                'cancel_url' => route('payment.cancel'),
            ],
            'purchase_units' => [
                0 => [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $amt,
                    ],
                ],
            ],
        ];
    }

    // Fixed Project
    public function paymentFixed(Request $request, $amount)
    {
        // if ($request->paypal_deposit_amt > 1) {
        //     if (!auth()->user()->paypal_email) {
        //         return redirect()->back()->with('error', 'Your Paypal is not verify kindly verify it first!');
        //     }
        // }
        // dd($request->all());
        $amt = $request->paypal_deposit_amt;
        $request = new OrdersCreateRequest();
        $request->headers['prefer'] = 'return=representation';
        $request->body = self::checkoutDataFixed($amt);
        $response = $this->client->execute($request);
        // dd($response);
        if (201 == $response->statusCode) {
            foreach ($response->result->links as $link) {
                if ('approve' == $link->rel) {
                    return redirect($link->href);
                }
            }
        } else {
            abort(500);
        }
    }

    public function cancelFixed()
    {
        return redirect('proposals')->with('error', 'Your Payment cannot completed please try angain');
        // dd('Your payment is canceled. You can create cancel page here.');
    }

    /**
     * Responds with a welcome message with instructions.
     *
     * @return \Illuminate\Http\Response
     */
    public function successFixed(Request $request)
    {
        $req = new OrdersCaptureRequest($request->token);
        $response = $this->client->execute($req);
        // dd($response);
        if (201 == $response->statusCode && 'COMPLETED' == $response->result->status) {
            $transaction = TransactionController::store($response);
            if ($transaction) {
                if (1 == $transaction->gross_amt) {
                    return redirect('/ongoing-jobs')->with('message', 'Your Payment Method is Verified!');
                }

                return redirect('/ongoing-jobs')->with('message', 'Transaction is completed!');
            }
            abort(500);
        }
        // dd($response);
    }

    public static function checkoutDataFixed($amt)
    {
        return [
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('payment.successFixed'),
                'cancel_url' => route('payment.cancelFixed'),
            ],
            'purchase_units' => [
                0 => [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $amt,
                    ],
                ],
            ],
        ];
    }
}
