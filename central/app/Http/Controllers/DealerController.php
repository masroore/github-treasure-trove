<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\TradeHistory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DealerController extends Controller
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

        return view('dealer', $data);
    }

    /**
     * get trade history.
     */
    public function getTradeList(Request $request): void
    {
        $symbol = $request->input('symbol');

        $trade_history = [];

        try {
            $trade_history = TradeHistory::leftjoin('ct_currencies', 'ct_currencies.id', '=', 'ct_trade_history.currency')
                ->where('ct_trade_history.currency', $symbol)
                ->where('ct_trade_history.status', config('constants.trade_status.settled'))
                ->where('ct_trade_history.type', config('constants.trade_type.dealer'))
                ->select('ct_trade_history.*', 'ct_currencies.currency as symbol', 'ct_currencies.amount_decimals')
                ->orderby('ct_trade_history.settled_at', 'desc')
                ->get()->toArray();

            for ($i = 0; $i < count($trade_history); ++$i) {
                $trade_history[$i]['settle_amount'] = _number_format($trade_history[$i]['settle_amount'], $trade_history[$i]['amount_decimals']);
                $trade_history[$i]['signal_str'] = $this->getOrderType($trade_history[$i]['signal']);
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            echo json_encode($trade_history);
            exit;
        }

        echo json_encode($trade_history);
    }
}
