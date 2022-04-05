<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\OrderHistory;
use App\Models\TradeHistory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ExchangeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [];

        try {
            $symbol_list = Currency::where('status', config('constants.currency_status.valid'))
                ->get()->toArray();

            $data = $symbol_list[0];

            $priceData = $this->getDayDataByCurrency($data['id']);
            $data['lastPrice'] = empty($priceData[config('constants.daily_fluct.YESTERDAY_CLOSING_PRICE')]) ? 0 : $priceData[config('constants.daily_fluct.YESTERDAY_CLOSING_PRICE')];
        } catch (QueryException $e) {
            Log::error($e->getMessage());
        }

        $data['currency_list'] = $this->getCryptocurrencyList();

        return view('exchange', $data);
    }

    /**
     * get balance list.
     */
    public function getCurrentBalance(Request $request): void
    {
        $this->middleware('auth');

        $balance_list = $this->getBalance();

        echo json_encode($balance_list);
    }

    /**
     * get order history.
     */
    public function getOrderHistory(Request $request): void
    {
        $this->middleware('auth');

        $symbol = $request->input('symbol');

        $order_history = [];

        $user = Auth::user();

        try {
            $order_history = OrderHistory::leftjoin('ct_currencies', 'ct_currencies.id', '=', 'ct_order_history.currency')
                ->where('ct_order_history.user_id', $user->id)
                ->where('ct_order_history.currency', $symbol)
                ->where(function ($query): void {
                    $query->where('ct_order_history.status', config('constants.order_status.pending'))
                        ->orWhere('ct_order_history.status', config('constants.order_status.canceling'));
                })
                ->select('ct_order_history.*', 'ct_currencies.currency as symbol', 'ct_currencies.amount_decimals', 'ct_currencies.price_decimals')
                ->orderby('ct_order_history.ordered_at', 'desc')
                ->get()->toArray();

            for ($i = 0; $i < count($order_history); ++$i) {
                $order_history[$i]['order_amount'] = _number_format($order_history[$i]['order_amount'], $order_history[$i]['amount_decimals']);
                $order_history[$i]['order_price'] = _number_format($order_history[$i]['order_price'], $order_history[$i]['price_decimals']);

                $order_history[$i]['type1'] = $this->getTradeType($order_history[$i]['type1']);
                $order_history[$i]['signal'] = $this->getOrderType($order_history[$i]['signal']);
                $order_history[$i]['status_str'] = $this->getOrderStatus($order_history[$i]['status']);
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            echo json_encode($order_history);
            exit;
        }

        echo json_encode($order_history);
    }

    /**
     * get trade history.
     */
    public function getTradeHistory(Request $request): void
    {
        $this->middleware('auth');

        $symbol = $request->input('symbol');

        $trade_history = [];

        $user = Auth::user();

        try {
            $trade_history = TradeHistory::leftjoin('ct_currencies', 'ct_currencies.id', '=', 'ct_trade_history.currency')
                ->where('ct_trade_history.user_id', $user->id)
                ->where('ct_trade_history.currency', $symbol)
                ->select('ct_trade_history.*', 'ct_currencies.currency as symbol', 'ct_currencies.amount_decimals', 'ct_currencies.price_decimals')
                ->orderby('ct_trade_history.settled_at', 'desc')
                ->get()->toArray();

            for ($i = 0; $i < count($trade_history); ++$i) {
                $trade_history[$i]['settle_amount'] = _number_format($trade_history[$i]['settle_amount'], $trade_history[$i]['amount_decimals']);
                $trade_history[$i]['settle_price'] = _number_format($trade_history[$i]['settle_price'], $trade_history[$i]['price_decimals']);
                $trade_history[$i]['fee'] = _number_format($trade_history[$i]['fee'], $trade_history[$i]['amount_decimals']) . '(' . $trade_history[$i]['fee_currency'] . ')';

                $trade_history[$i]['type'] = $this->getTradeType($trade_history[$i]['type']);
                $trade_history[$i]['signal'] = $this->getOrderType($trade_history[$i]['signal']);
                $trade_history[$i]['status'] = $this->getTradeStatue($trade_history[$i]['status']);
                if ($trade_history[$i]['remark'] == config('constants.trade_remark.not_enough_balance')) {
                    $trade_history[$i]['remark'] = trans('exchange.balance_error_msg');
                } elseif ($trade_history[$i]['remark'] == config('constants.trade_remark.market_order_cancel')) {
                    $trade_history[$i]['remark'] = trans('exchange.market_order_cancel');
                }
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            echo json_encode($trade_history);
            exit;
        }

        echo json_encode($trade_history);
    }

    /**
     * order.
     */
    public function order(Request $request): void
    {
        $this->middleware('auth');

        $user = Auth::user();
        $data = $request->all();

        $res = [
            'status' => 0,
        ];

        $currency_info = $this->getCurrencyInfo($data['currency']);
        if (empty($currency_info)) {
            echo json_encode($res);
            exit;
        }

        $validator = Validator::make($data, [
            'currency' => 'required|exists:mysql2.ct_currencies,id',
            'order_price' => 'required',
            'order_amount' => 'required|numeric|min:' . $currency_info['min_order_amount'] . '|max:' . $currency_info['max_order_amount'],
            'signal' => 'required',
            'type1' => 'required',
            'type2' => 'required',
        ], [
        ], [
            'order_price' => trans('exchange.price'),
            'order_amount' => trans('exchange.amount'),
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['errors'] = $errors;
            echo json_encode($res);
            exit;
        }

        $currencies = explode('/', $currency_info['currency']);
        if ($data['signal'] == config('constants.order_type.sell')) {
            $balance = $this->getAvailableBalanceFromCurrency($currencies[0]);
            if ($data['order_amount'] > $balance['available_balance']) {
                $validator->errors()->add('order_amount', trans('exchange.balance_error_msg'));
                $errors = $validator->errors();
                $res['errors'] = $errors;
                echo json_encode($res);
                exit;
            }
        } elseif ($data['signal'] == config('constants.order_type.buy')) {
            $balance = $this->getAvailableBalanceFromCurrency($currencies[1]);
            if ($data['order_amount'] * $data['order_price'] > $balance['available_balance']) {
                $validator->errors()->add('order_amount', trans('exchange.balance_error_msg'));
                $errors = $validator->errors();
                $res['errors'] = $errors;
                echo json_encode($res);
                exit;
            }
        } else {
            $validator->errors()->add('order_amount', trans('exchange.balance_error_msg'));
            $errors = $validator->errors();
            $res['errors'] = $errors;
            echo json_encode($res);
            exit;
        }

        $order_at = time();
        $result = '';
        $order_id = '';

        try {
            DB::connection('mysql2')->statement(
                'call NewOrder(?, ?, ?, ?, ?, ?, ?, ?, @result, @id);',
                [$user->id, $data['currency'], $data['order_price'], $data['order_amount'], $data['signal'], $order_at, $data['type1'], $data['type2']]
            );
            $orderResult = DB::connection('mysql2')->select('select @result as result, @id as order_id');
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            echo json_encode($res);
            exit;
        }

        if (empty($orderResult) || $orderResult[0]->result != 1) {
            $res['status'] = 0;
        } else {
            $res['status'] = $orderResult[0]->result;
            $res['order_id'] = $orderResult[0]->order_id;
        }

        echo json_encode($res);
    }

    /**
     * order cancel.
     */
    public function orderCancel(Request $request): void
    {
        $order_id = $request->input('order_id');
        $amount = $request->input('amount');

        $res = [
            'status' => 0,
        ];

        if (null === $order_id || null === $amount) {
            echo json_encode($res);
            exit;
        }

        DB::connection('mysql2')->statement(
            'call CancelOrder(?, ?, @result);',
            [$order_id, $amount]
        );
        $cancelResult = DB::connection('mysql2')->select('select @result as result');

        if (empty($cancelResult) || $cancelResult[0]->result != 1) {
            $res['status'] = 0;
        } else {
            $res['status'] = $cancelResult[0]->result;
        }

        echo json_encode($res);
    }
}
