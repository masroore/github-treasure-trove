<?php

namespace Modules\Paypal\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Account\Entities\ChartAccount;

use Modules\Sale\Repositories\SaleRepositoryInterface;
use Modules\Setting\Entities\PaymentGateway;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;

use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class PaypalController extends Controller
{
    protected $apiContext;

    public $info = [];

    public $total;

    public $paypal;

    public $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
        $paypalSecret = PaymentGateway::findOrFail(2);
        $this->paypal = $paypalSecret;

        $this->middleware('auth');
        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $paypalSecret->gateway_api_key,
                $paypalSecret->gateway_secret_key
            )
        );
    }

    public function process(Request $request)
    {
        $amount = (int) $request->amount;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item1 = new Item();
        $item1->setName('PayPal payment')
            ->setCurrency(app('general_setting')->currencyDetails->code)
            ->setQuantity(1)
            ->setSku('123123') // Similar to `item_number` in Classic API
            ->setPrice($amount);

        $itemList = new ItemList();
        $itemList->setItems([$item1]);

        $details = new Details();
        $details->setShipping(0)
            ->setTax(0)
            ->setSubtotal($amount);

        $amountPay = new Amount();
        $amountPay->setCurrency(app('general_setting')->currencyDetails->code)
            ->setTotal($amount)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amountPay)
            ->setItemList($itemList)
            ->setDescription('Payment description')
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("{$this->paypal->redirect_url}/paypal/execute")
            ->setCancelUrl("{$this->paypal->redirect_url}/paypal/cancel");

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        $payment->create($this->apiContext);

        $approvalUrl = $payment->getApprovalLink();

        // pass package info by session

        session(['amount' => $amount]);
        session(['sale_id' => $request->sale_id]);

        return redirect($approvalUrl);
    }

    public function execute()
    {
        $amount = session()->get('amount');
        $id = session()->get('sale_id');

        $paymentId = request()->paymentId;
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(request()->PayerID);

        $transaction = new Transaction();
        $amountPay = new Amount();
        $details = new Details();

        $details->setShipping(0)
            ->setTax(0)
            ->setSubtotal($amount);

        $amountPay->setCurrency(app('general_setting')->currencyDetails->code);
        $amountPay->setTotal($amount);
        $amountPay->setDetails($details);
        $transaction->setAmount($amountPay);

        $execution->addTransaction($transaction);

        $result = $payment->execute($execution, $this->apiContext);

        if ($result) {
            DB::beginTransaction();

            $chartOfAccount = ChartAccount::where('code', '03-31')->first();

            $payments = [
                'payment_method' => 'bank',
                'amount' => $amount,
                'account_id' => $chartOfAccount->id,
                'bank_name' => 'Paypal',
                'branch' => 'Paypal',
            ];

            $this->saleRepository->payments([$payments], $id);

            DB::commit();

            Toastr::success('Payment Success!');

            return redirect()->route('contact.my_details');
        }
        Toastr::error('Something went wrong!');

        return redirect()->route('contact.my_details');
    }

    public function cancel()
    {
        return redirect()->to('/page/membership');
    }
}
