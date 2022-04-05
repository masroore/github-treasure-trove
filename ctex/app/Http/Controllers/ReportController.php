<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\TradeHistory;
use App\Models\Withdraw;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('report');
    }

    /**
     * get trade history.
     */
    public function getTradeHistory(Request $request): void
    {
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $type = $request->input('type');

        $history_list = [];

        try {
            $query = TradeHistory::leftjoin('ct_currencies', 'ct_currencies.id', '=', 'ct_trade_history.currency')
                ->select(
                    'ct_trade_history.trade_id',
                    'ct_trade_history.settled_at',
                    'ct_trade_history.type',
                    'ct_trade_history.signal',
                    'ct_trade_history.settle_price',
                    'ct_trade_history.settle_amount',
                    'ct_trade_history.fee',
                    'ct_trade_history.fee_currency',
                    'ct_trade_history.status',
                    'ct_trade_history.remark',
                    'ct_trade_history.remark',
                    'ct_currencies.currency',
                    'ct_currencies.amount_decimals',
                    'ct_currencies.price_decimals'
                )
                ->orderby('ct_trade_history.settled_at', 'desc');

            if (!empty($from_date)) {
                $query->where('ct_trade_history.settled_at', '>=', $from_date);
            }
            if (!empty($to_date)) {
                $query->where('ct_trade_history.settled_at', '<=', $to_date);
            }
            if (!empty($type)) {
                $query->where('ct_trade_history.type', $type);
            }

            $history_list = $query->get()->toArray();

            for ($i = 0; $i < count($history_list); ++$i) {
                $history_list[$i]['settle_amount'] = _number_format($history_list[$i]['settle_amount'], $history_list[$i]['amount_decimals']);
                $history_list[$i]['settle_price'] = _number_format($history_list[$i]['settle_price'], $history_list[$i]['price_decimals']);
                $history_list[$i]['fee'] = _number_format($history_list[$i]['fee'], $history_list[$i]['amount_decimals']) . '(' . $history_list[$i]['fee_currency'] . ')';

                $history_list[$i]['type'] = $this->getTradeType($history_list[$i]['type']);
                $history_list[$i]['signal'] = $this->getOrderType($history_list[$i]['signal']);
                $history_list[$i]['status'] = $this->getTradeStatue($history_list[$i]['status']);
                if ($history_list[$i]['remark'] == config('constants.trade_remark.not_enough_balance')) {
                    $history_list[$i]['remark'] = trans('exchange.balance_error_msg');
                } elseif ($history_list[$i]['remark'] == config('constants.trade_remark.market_order_cancel')) {
                    $history_list[$i]['remark'] = trans('exchange.market_order_cancel');
                }
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            echo json_encode($history_list);
            exit;
        }

        echo json_encode($history_list);
    }

    /**
     * get deposit history.
     */
    public function getDepositHistory(Request $request): void
    {
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        $history_list = [];

        try {
            $query = Deposit::select('updated_at', 'currency', 'amount', 'wallet_addr', 'tx_id', 'status')->orderby('updated_at', 'desc');

            if (!empty($from_date)) {
                $query->where('updated_at', '>=', $from_date);
            }
            if (!empty($to_date)) {
                $query->where('updated_at', '<=', $to_date);
            }

            $history_list = $query->get()->toArray();

            $cryptocurrency_list = $this->getCryptocurrencyList();

            for ($i = 0; $i < count($history_list); ++$i) {
                $key = array_search($history_list[$i]['currency'], array_column($cryptocurrency_list, 'currency'));
                $history_list[$i]['amount'] = _number_format($history_list[$i]['amount'], $cryptocurrency_list[$i]['rate_decimals']);
                $history_list[$i]['status'] = $this->getDepositStatue($history_list[$i]['status']);
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            echo json_encode($history_list);
            exit;
        }

        echo json_encode($history_list);
    }

    /**
     * get withdraw history.
     */
    public function getWithdrawHistory(Request $request): void
    {
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        $history_list = [];

        try {
            $query = Withdraw::select('updated_at', 'currency', 'amount', 'destination', 'tx_id', 'status', 'remark')->orderby('updated_at', 'desc');

            if (!empty($from_date)) {
                $query->where('updated_at', '>=', $from_date);
            }
            if (!empty($to_date)) {
                $query->where('updated_at', '<=', $to_date);
            }

            $history_list = $query->get()->toArray();

            $cryptocurrency_list = $this->getCryptocurrencyList();

            for ($i = 0; $i < count($history_list); ++$i) {
                $key = array_search($history_list[$i]['currency'], array_column($cryptocurrency_list, 'currency'));
                $history_list[$i]['amount'] = _number_format($history_list[$i]['amount'], $cryptocurrency_list[$i]['rate_decimals']);
                $history_list[$i]['status'] = $this->getWithdrawStatue($history_list[$i]['status']);
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            echo json_encode($history_list);
            exit;
        }

        echo json_encode($history_list);
    }
}
