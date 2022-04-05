<?php

namespace Modules\Stripe\Http\Controllers;

use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Account\Entities\ChartAccount;
use Modules\Sale\Repositories\SaleRepositoryInterface;

use Modules\Setting\Entities\PaymentGateway;
use Stripe;

class StripeController extends Controller
{
    private $stripeSecret;

    private $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->middleware('auth');
        $this->stripeSecret = PaymentGateway::findOrFail(1);
        Stripe\Stripe::setApiKey($this->stripeSecret->gateway_secret_key);

        $this->saleRepository = $saleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        $stripeKey = $this->stripeSecret->gateway_api_key;

        return view('stripe::index', compact('stripeKey'));
    }

    public function retrive()
    {
        return \Stripe\Charge::retrieve([
            'id' => 'ch_1HH4LQH0fV5JGUSfmgTUuANt',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function process(Request $request)
    {
        try {
            $chartOfAccount = ChartAccount::where('code', '03-30')->first();

            $amount = $request->amount;
            $id = $request->sale_id;
            $charge = Stripe\Charge::create([
                'amount' => $amount * 100,
                'currency' => app('general_setting')->currencyDetails->code,
                'source' => $request->stripeToken,
                'metadata' => ['order_id' => uniqid(), 'user_id' => Auth::id()],
                'description' => 'Stripe Paymant',
            ]);

            if ($charge) {
                DB::beginTransaction();

                $payments = [
                    'payment_method' => 'bank',
                    'amount' => $amount,
                    'account_id' => $chartOfAccount->id,
                    'bank_name' => 'Stripe',
                    'branch' => 'Stripe',
                ];

                $this->saleRepository->payments([$payments], $id);

                DB::commit();

                Toastr::success('Payment Success!');

                return redirect()->route('contact.my_details');
            }
            Toastr::error('Something went wrong!');

            return redirect()->route('contact.my_details');
        } catch (Exception $e) {
            Toastr::error('Something went wrong!');

            return redirect()->route('contact.my_details');
        }
    }
}
