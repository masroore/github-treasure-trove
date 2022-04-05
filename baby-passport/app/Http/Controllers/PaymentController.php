<?php

namespace App\Http\Controllers;

use App\Events\MomEvent;
use App\Mail\SendPayment;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\User;
use Auth;
use Config;
use DB;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;
use Mail;
use Openpay;
use OpenpayApiAuthError;
use OpenpayApiConnectionError;
use OpenpayApiError;
use OpenpayApiRequestError;
use OpenpayApiTransactionError;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PPConnectionException;
use PayPal\Rest\ApiContext;
use PDF;
use Session;
use URL;

class PaymentController extends Controller
{
    public function __construct()
    {
        // PayPal api context
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret']
        ));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function generatePurchaseReceipt($cartId): void
    {
        $cart = Cart::find($cartId);
        $payment = $cart->payments()->first();

        $receiptUrl = asset('storage/moms/' . $cart->user->id . '/' . $payment->id . '.pdf');
        $path = storage_path() . '/app/public/moms/' . $cart->user->id . '/' . $payment->id . '.pdf';
        $pdf = PDF::loadView('formats/payment_receipt', ['payment' => $payment]);
        $pdf->save($path);

        $payment->update([
            'receipt' => $payment->id . '.pdf',
        ]);
    }

    public function getPaymentHistory($cartId)
    {
        $cart = Cart::find($cartId);

        if (empty($cart)) {
            return response()->json(['message' => 'Paquete no encontrado'], 404);
        }

        $receiptPath = url('storage/moms/' . $cart->user_id . '/');

        $payments = $cart->payments()->select(
            'payment_uuid',
            'description',
            DB::raw('FORMAT(old_balance,2) as old_balance'),
            DB::raw('FORMAT(subtotal,2) as subtotal'),
            DB::raw('FORMAT(new_balance,2) as new_balance'),
            DB::raw('FORMAT(old_balance,2) as old_balance'),
            DB::raw('CONCAT("' . $receiptPath . '","/",receipt) as receipt')
        )
            ->get();

        return response()->json([
            'history' => $payments,
        ]);
    }

    public function downloadBankReference(Request $request)
    {
        $cart = Cart::find($request['cart_id']);

        if (empty($cart)) {
            abort(404, 'No se encontró el paquete seleccionado');
        }

        $pdf = PDF::loadView('formats/bank_reference', [
            'amount' => $request['amount'],
            'exchange_rate' => $request['exchange_rate'],
            'userId' => strtotime($cart->user->created_at->format('Y-m-d H:i:s')),
            'package' => $request['item'],
        ]);

        return $pdf->download('ficha-deposito-babypassport.pdf');
    }

    public function generateReceipt($cartId, Request $request)
    {
        $cart = Cart::find($cartId);

        if (empty($cart)) {
            abort(404, 'No se encontró el pago');
        }

        $path = storage_path() . '/app/public/moms/' . $cart->user_id . '/' . $cart->id . '.pdf';
        $pdf = PDF::loadView('formats/payment_receipt', ['cart' => $cart]);
        $pdf->save($path);

        $newStatus = $cart->status == 'pending' ? 'sold' : 'deposit_sold';

        try {
            if ($cart->status == 'deposit_pending') {
                $this->savePackageBalance($cart);
            }

            $cart->update([
                'status' => $newStatus,
                'payment_type' => 'transferencia_bancaria',
                'payment_uuid' => 'TBID-' . uniqid(),
            ]);

            $request->session()->flash('success', 'Recibo generado correctamente');

            return back();
        } catch (QueryException $e) {
            $request->session()->flash('error', 'Hubo un error al generar el recibo, intente más tare');

            return back();
        }
    }

    public function payWithOpenPay(Request $request)
    {
        $cart = Cart::find($request['cart_id']);

        if (empty($cart)) {
            abort(404, 'No se encontró el paquete');
        }

        try {
            $openpay = Openpay::getInstance('mxqd0md6sxov3pmg4xew', 'sk_3fce417709534c979f76eb6f06339d1a');

            $customer = [
                'name' => $cart->user->name,
                'last_name' => '',
                'email' => $cart->user->email,
            ];

            //Create card charge
            $chargeData = [
                'method' => 'card',
                'source_id' => $request['token_id'],
                'amount' => (float) $request['total'],
                'description' => $request['description'],
                'device_session_id' => $request['deviceIdHiddenFieldName'],
                'currency' => 'USD',
                'customer' => $customer,
            ];

            $charge = $openpay->charges->create($chargeData);

            //Create Cart Payment
            $payment = $cart->payments()->create([
                'payment_type' => $charge->card->brand,
                'payment_uuid' => $charge->id,
                'description' => $request['description'],
                'old_balance' => $cart->balance,
                'subtotal' => $request['subtotal'],
                'iva' => $request['iva'],
                'total' => $request['total'],
                'new_balance' => $cart->balance - $request['subtotal'],
                'receipt' => '',
            ]);

            //Update cart balance
            $cart->update([
                'balance' => $cart->balance - $request['subtotal'],
            ]);

            //Create pdf

            $receiptUrl = asset('storage/moms/' . $cart->user->id . '/' . $payment->id . '.pdf');
            $path = storage_path() . '/app/public/moms/' . $cart->user->id . '/' . $payment->id . '.pdf';
            $pdf = PDF::loadView('formats/payment_receipt', ['payment' => $payment]);
            $pdf->save($path);

            $payment->update([
                'receipt' => $payment->id . '.pdf',
            ]);

            // $cart->user()->update(["step" => "parcial_payment"]);

            //Send Receipt via Email
            Mail::send(new SendPayment([
                'email' => $cart->user->email,
                'payDate' => Date::now()->format('d F Y h:i a'),
                'paymentId' => $charge->id,
                'authCode' => $charge->authorization,
                'concept' => $charge->description,
                'price' => number_format($charge->amount, 2, '.', ',') . ' USD',
                'cardType' => $charge->card->brand,
                'cardNumber' => $charge->card->card_number,
                'holderName' => $charge->card->holder_name,
                'receipt' => $path,
            ]));

            return response()->json([
                'receipt_url' => $receiptUrl,
                'message' => 'Pago realizado correctamente', ]);
        } catch (OpenpayApiTransactionError $e) {
            return response()->json(['open_pay_code' => $e->getCode()], 500);
        } catch (OpenpayApiRequestError $e) {
            return response()->json(['open_pay_message' => $e->getCode()], 500);
        } catch (OpenpayApiConnectionError $e) {
            return response()->json(['open_pay_message' => $e->getCode()], 500);
        } catch (OpenpayApiAuthError $e) {
            return response()->json(['open_pay_message' => $e->getCode()], 500);
        } catch (OpenpayApiError $e) {
            return response()->json(['open_pay_message' => $e->getCode()], 500);
        } catch (Exception $e) {
            return response()->json(['open_pay_message' => $e->getMessage()], 500);
        }
    }

    public function payWithPaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName($request['item'])
            /** item name */
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request['amount']);

        /** unit price */
        $item_list = new ItemList();
        $item_list->setItems([$item_1]);
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request['amount']);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($request['item']);
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('web.savePaypalPurchase'))
            /** Specify return URL */
            ->setCancelUrl(URL::route('web.cancelPaypal'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions([$transaction]);
        /** dd($payment->create($this->_api_context));exit; */
        try {
            $payment->create($this->_api_context);
        } catch (PPConnectionException $ex) {
            if (Config::get('app.debug')) {
                Session::put('error', 'Connection timeout');

                return redirect()->route('web.paypal');
            }
            Session::put('error', 'Some error occur, sorry for inconvenient');

            return redirect()->route('web.paypal');
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();

                break;
            }
        }
        /** add payment ID to session */
        Session::put('paypalPayment', [
            'paypalTransaction' => $payment,
            'cart_id' => $request['cart_id'],
            'item' => $request['item'],
            'totals' => [
                'subtotal' => $request['subtotal'],
                'iva' => $request['iva'],
                'amount' => $request['amount'],
            ],
        ]);
        if (isset($redirect_url)) {
            /** redirect to paypal */
            return redirect()->away($redirect_url);
        }
        Session::put('error', 'Unknown error occurred');

        return redirect()->route('paywithpaypal');
    }

    public function savePaypalPurchase(Request $request)
    {
        $paymentSession = Session::get('paypalPayment');

        try {
            $cart = Cart::find($paymentSession['cart_id']);

            //Create Cart Payment
            $payment = $cart->payments()->create([
                'payment_type' => 'paypal',
                'payment_uuid' => $paymentSession['paypalTransaction']->id,
                'description' => $paymentSession['item'],
                'old_balance' => $cart->balance,
                'subtotal' => $paymentSession['totals']['subtotal'],
                'iva' => $paymentSession['totals']['iva'],
                'total' => $paymentSession['totals']['amount'],
                'new_balance' => $cart->balance - $paymentSession['totals']['subtotal'],
                'receipt' => '',
            ]);

            //Update cart balance
            $cart->update([
                'balance' => $cart->balance - $paymentSession['totals']['subtotal'],
            ]);

            //GENERATE PURCHASE PDF
            $receiptUrl = asset('storage/moms/' . Auth::user()->id . '/' . $payment->id . '.pdf');
            $path = storage_path() . '/app/public/moms/' . Auth::user()->id . '/' . $payment->id . '.pdf';
            $pdf = PDF::loadView('formats/payment_receipt', ['payment' => $payment]);
            $pdf->save($path);

            $payment->update([
                'receipt' => $payment->id . '.pdf',
            ]);

            $cart->user()->update(['step' => 'parcial_payment']);

            //Send Receipt via Email
            Mail::send(new SendPayment([
                'email' => Auth::user()->email,
                'payDate' => Date::now()->format('d F Y h:i a'),
                'paymentId' => $payment->payment_uuid,
                'authCode' => 'NA',
                'concept' => $paymentSession['paypalTransaction']->transactions[0]->description,
                'price' => number_format($paymentSession['paypalTransaction']->transactions[0]->amount->total, 2, '.', ',') . ' USD',
                'cardType' => 'paypal',
                'cardNumber' => 'NA',
                'holderName' => 'NA',
                'receipt' => $path,
            ]));

            $notification = [
                'description' => 'El usuario ' . $cart->user->name . ' ha realizado el pago de ' . $paymentSession['paypalTransaction']->transactions[0]->description,
                'url' => route('users.profile', [$cart->user_id]),
                'user_id' => null,
                'receiver' => 'superadmin',
            ];

            $notification = Notification::create($notification);

            /*
            event(new MomEvent([
                "id"          => $notification->id,
                "url"         => $notification->url,
                "description" => $notification->description,
                "date"        => $notification->created_at->format('d F Y h:i a')
            ]));*/

            Session::flash('success', 'Hemos recibido el pago de tu depósito correctamente');

            return redirect()->route('web.getMomProfile', [Auth::user()->id]);
        } catch (QueryException $e) {
            Session::flash('error', 'Hubo un error al procesar su pago,intente más tarde ' . $e->getMessage());

            return redirect()->route('web.getMomProfile', [Auth::user()->id]);
        }
    }

    public function getPaymentStatus()
    {
        $payment_id = Session::get('paypal_payment_id');

        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            Session::flash('error', 'Payment failed');

            return redirect()->route('/');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            Session::flash('success', 'Payment success');

            return redirect()->route('/');
        }
        Session::flash('error', 'Payment failed');

        return redirect()->route('/');
    }

    public function cancelPaypal()
    {
        return view('cancelPaypal');
    }
}
