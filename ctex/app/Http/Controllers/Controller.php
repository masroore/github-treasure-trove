<?php

namespace App\Http\Controllers;

use App\Models\CountryList;
use App\Models\CryptoSettings;
use App\Models\Currency;
use App\Models\DailyFluct;
use App\Models\Identity;
use App\Models\News;
use App\Models\Notifications;
use App\Models\OrderHistory;
use App\Models\UserBalance;
use App\Models\Withdraw;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Get Crypto Currency Setting List.
     *
     * @return array
     */
    protected function getCryptocurrencyList()
    {
        $cryptocurrency_list = [];

        try {
            $cryptocurrency_list = CryptoSettings::leftjoin('lk_crypto_usages', 'lk_crypto_settings.currency', '=', 'lk_crypto_usages.currency')
                ->where('lk_crypto_settings.status', config('constants.crypto_setting_status.valid'))
                ->select('lk_crypto_settings.*', 'lk_crypto_usages.use_deposit', 'lk_crypto_usages.use_withdraw')
                ->get()->toArray();
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $cryptocurrency_list;
        }

        for ($i = 0; $i < count($cryptocurrency_list); ++$i) {
            $cryptocurrency_list[$i]['cashback'] = _number_format($cryptocurrency_list[$i]['cashback'], $cryptocurrency_list[$i]['rate_decimals']);
            $cryptocurrency_list[$i]['min_deposit'] = _number_format($cryptocurrency_list[$i]['min_deposit'], $cryptocurrency_list[$i]['rate_decimals']);
            $cryptocurrency_list[$i]['min_withdraw'] = _number_format($cryptocurrency_list[$i]['min_withdraw'], $cryptocurrency_list[$i]['rate_decimals']);
            $cryptocurrency_list[$i]['transfer_fee'] = _number_format($cryptocurrency_list[$i]['transfer_fee'], $cryptocurrency_list[$i]['rate_decimals']);
            $cryptocurrency_list[$i]['gas_price'] = _number_format($cryptocurrency_list[$i]['gas_price'], $cryptocurrency_list[$i]['rate_decimals']);
            $cryptocurrency_list[$i]['gas_limit'] = _number_format($cryptocurrency_list[$i]['gas_limit'], $cryptocurrency_list[$i]['rate_decimals']);
            $cryptocurrency_list[$i]['gas'] = _number_format($cryptocurrency_list[$i]['gas'], $cryptocurrency_list[$i]['gas']);

            if ($cryptocurrency_list[$i]['currency'] == 'BTC') {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/btc.svg');
            } elseif ($cryptocurrency_list[$i]['currency'] == 'ETH') {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/eth.svg');
            } elseif ($cryptocurrency_list[$i]['currency'] == 'XRP') {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/xrp.svg');
            } elseif ($cryptocurrency_list[$i]['currency'] == 'LTC') {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/ltc.svg');
            } elseif ($cryptocurrency_list[$i]['currency'] == 'USDT') {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/usdt.svg');
            } elseif ($cryptocurrency_list[$i]['currency'] == 'ADAB') {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/ada.svg');
            } elseif ($cryptocurrency_list[$i]['currency'] == 'WCP') {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/wiz+.svg');
            } else {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/btc.svg');
            }
        }

        return $cryptocurrency_list;
    }

    /**
     * Get Crypto Setting Info from currency.
     *
     * @param $currency
     *
     * @return array
     */
    protected function getCryptocurrencySetting($currency)
    {
        $crypto_setting = [];

        try {
            $crypto_info = CryptoSettings::where('currency', $currency)->first();
            if (null === $crypto_info) {
                return $crypto_setting;
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $crypto_setting;
        }

        $crypto_setting = $crypto_info->toArray();

        return $crypto_setting;
    }

    /**
     * Get crypto currency list with balance.
     *
     * @return array
     */
    protected function getCryptocurrencyListWithBalance()
    {
        $user = Auth::user();
        $cryptocurrency_list = [];

        try {
            $cryptocurrency_list = CryptoSettings::leftjoin('lk_crypto_usages', 'lk_crypto_settings.currency', '=', 'lk_crypto_usages.currency')
                ->where('lk_crypto_settings.status', config('constants.crypto_setting_status.valid'))
                ->select('lk_crypto_settings.*', 'lk_crypto_usages.use_deposit', 'lk_crypto_usages.use_withdraw')
                ->get()->toArray();
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $cryptocurrency_list;
        }

        for ($i = 0; $i < count($cryptocurrency_list); ++$i) {
            $available_balance = $this->getAvailableBalanceFromCurrency($cryptocurrency_list[$i]['currency']);
            $cryptocurrency_list[$i]['available_balance'] = _number_format($available_balance['available_balance'], $cryptocurrency_list[$i]['rate_decimals']);
            $cryptocurrency_list[$i]['balance'] = _number_format($available_balance['balance'], $cryptocurrency_list[$i]['rate_decimals']);
            $cryptocurrency_list[$i]['cashback'] = _number_format($cryptocurrency_list[$i]['cashback'], $cryptocurrency_list[$i]['rate_decimals']);
            $cryptocurrency_list[$i]['min_deposit'] = _number_format($cryptocurrency_list[$i]['min_deposit'], $cryptocurrency_list[$i]['rate_decimals']);
            $cryptocurrency_list[$i]['min_withdraw'] = _number_format($cryptocurrency_list[$i]['min_withdraw'], $cryptocurrency_list[$i]['rate_decimals']);
            $cryptocurrency_list[$i]['transfer_fee'] = _number_format($cryptocurrency_list[$i]['transfer_fee'], $cryptocurrency_list[$i]['rate_decimals']);
            $cryptocurrency_list[$i]['gas_price'] = _number_format($cryptocurrency_list[$i]['gas_price'], $cryptocurrency_list[$i]['rate_decimals']);
            $cryptocurrency_list[$i]['gas_limit'] = _number_format($cryptocurrency_list[$i]['gas_limit'], $cryptocurrency_list[$i]['rate_decimals']);
            $cryptocurrency_list[$i]['gas'] = _number_format($cryptocurrency_list[$i]['gas'], $cryptocurrency_list[$i]['rate_decimals']);

            if ($cryptocurrency_list[$i]['currency'] == 'BTC') {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/btc.svg');
            } elseif ($cryptocurrency_list[$i]['currency'] == 'ETH') {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/eth.svg');
            } elseif ($cryptocurrency_list[$i]['currency'] == 'XRP') {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/xrp.svg');
            } elseif ($cryptocurrency_list[$i]['currency'] == 'LTC') {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/ltc.svg');
            } elseif ($cryptocurrency_list[$i]['currency'] == 'USDT') {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/usdt.svg');
            } elseif ($cryptocurrency_list[$i]['currency'] == 'ADAB') {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/ada.svg');
            } elseif ($cryptocurrency_list[$i]['currency'] == 'WCP') {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/wiz+.svg');
            } else {
                $cryptocurrency_list[$i]['ico'] = asset('/icons/btc.svg');
            }
        }

        return $cryptocurrency_list;
    }

    /**
     * Get User's Balance List.
     *
     * @return array
     */
    protected function getBalance()
    {
        $user = Auth::user();

        $balance_list = [];

        try {
            $balance_list = UserBalance::leftjoin('lk_main_db.lk_crypto_settings', 'lk_crypto_settings.currency', '=', 'ct_users_balance.currency')
                ->where('ct_users_balance.user_id', $user->id)
                ->where('ct_users_balance.status', config('constants.balance_status.valid'))
                ->select('ct_users_balance.user_id', 'ct_users_balance.currency', 'ct_users_balance.balance', 'lk_crypto_settings.rate_decimals')
                ->get()->toArray();
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $balance_list;
        }

        for ($i = 0; $i < count($balance_list); ++$i) {
            $available_balance = $this->getAvailableBalanceFromCurrency($balance_list[$i]['currency']);
            $balance_list[$i]['available_balance'] = _number_format2($available_balance['available_balance'], $balance_list[$i]['rate_decimals']);
            $balance_list[$i]['balance_amount'] = _number_format2($balance_list[$i]['balance'], $balance_list[$i]['rate_decimals']);
            $balance_list[$i]['balance'] = _number_format($balance_list[$i]['balance'], $balance_list[$i]['rate_decimals']);
        }

        return $balance_list;
    }

    /**
     * Get User's balance from currency.
     *
     * @param $currency
     *
     * @return array
     */
    protected function getBalanceFromCurrency($currency)
    {
        $user = Auth::user();

        $balance = [
            'balance' => 0,
            'decimals' => 0,
        ];

        try {
            $balance_info = UserBalance::leftjoin('lk_main_db.lk_crypto_settings', 'lk_crypto_settings.currency', '=', 'ct_users_balance.currency')
                ->where('ct_users_balance.user_id', $user->id)
                ->where('ct_users_balance.currency', $currency)
                ->where('ct_users_balance.status', config('constants.balance_status.valid'))
                ->select('ct_users_balance.user_id', 'ct_users_balance.currency', 'ct_users_balance.balance', 'lk_crypto_settings.rate_decimals')
                ->first();

            if (null === $balance_info) {
                return $balance;
            }

            $balance['balance'] = $balance_info->balance;
            $balance['decimals'] = $balance_info->rate_decimals;
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $balance;
        }

        return $balance;
    }

    /**
     * get available balance from currency.
     *
     * @param $currency
     *
     * @return array
     */
    protected function getAvailableBalanceFromCurrency($currency)
    {
        $user = Auth::user();

        $balance = $this->getBalanceFromCurrency($currency);
        $balance['available_balance'] = $balance['balance'];

        try {
            $order_pending_list = OrderHistory::leftjoin('ct_currencies', 'ct_currencies.id', '=', 'ct_order_history.currency')
                ->where('ct_order_history.user_id', $user->id)
                ->where('ct_currencies.currency', 'like', '%' . $currency . '%')
                ->where(function ($query): void {
                    $query->where('ct_order_history.status', config('constants.order_status.pending'))
                        ->orWhere('ct_order_history.status', config('constants.order_status.canceling'));
                })
                ->get()->toArray();

            $order_pending_amount = 0;
            foreach ($order_pending_list as $order_pending_info) {
                $currencies = explode('/', $order_pending_info['currency']);

                if ($currencies['0'] == $currency && $order_pending_info['signal'] == config('constants.order_type.sell')) {
                    $order_pending_amount = $order_pending_amount + $order_pending_info['order_amount'];
                } elseif ($currencies['1'] == $currency && $order_pending_info['signal'] == config('constants.order_type.buy')) {
                    $order_pending_amount = $order_pending_amount + ($order_pending_info['order_amount'] * $order_pending_info['order_price']);
                }
            }

            $balance['available_balance'] = $balance['available_balance'] - $order_pending_amount;
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $balance;
        }

        return $balance;
    }

    /**
     * get currency list.
     *
     * @return array
     */
    public static function getCurrencyList()
    {
        $currency_list = [];

        try {
            $currency_list = Currency::where('status', config('constants.currency_status.valid'))
                ->get()->toArray();
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $currency_list;
        }

        for ($i = 0; $i < count($currency_list); ++$i) {
            $currencies = explode('/', $currency_list[$i]['currency']);

            if ($currencies[0] == 'BTC') {
                $currency_list[$i]['ico'] = asset('/icons/btc.svg');
            } elseif ($currencies[0] == 'ETH') {
                $currency_list[$i]['ico'] = asset('/icons/eth.svg');
            } elseif ($currencies[0] == 'XRP') {
                $currency_list[$i]['ico'] = asset('/icons/xrp.svg');
            } elseif ($currencies[0] == 'LTC') {
                $currency_list[$i]['ico'] = asset('/icons/ltc.svg');
            } elseif ($currencies[0] == 'USDT') {
                $currency_list[$i]['ico'] = asset('/icons/usdt.svg');
            } elseif ($currencies[0] == 'ADAB') {
                $currency_list[$i]['ico'] = asset('/icons/ada.svg');
            } elseif ($currencies[0] == 'WCP') {
                $currency_list[$i]['ico'] = asset('/icons/wiz+.svg');
            } else {
                $currency_list[$i]['ico'] = asset('/icons/btc.svg');
            }
        }

        return $currency_list;
    }

    /**
     * get currency info from id.
     *
     * @param $id
     *
     * @return array
     */
    protected function getCurrencyInfo($id)
    {
        $currency_info = [];

        try {
            $currency_info = Currency::where('id', $id)->first()->toArray();
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $currency_info;
        }

        $currency_info['min_order_amount'] = _number_format2($currency_info['min_order_amount'], $currency_info['amount_decimals']);
        $currency_info['max_order_amount'] = _number_format2($currency_info['max_order_amount'], $currency_info['amount_decimals']);

        return $currency_info;
    }

    /**
     * get last news.
     *
     * @return array
     */
    protected function getLastNews()
    {
        $news_list = [];

        $locale = app()->getLocale();

        try {
            $news_list = News::where('lang', $locale)
                ->where('status', config('constants.news_status.valid'))
                ->orderby('updated_at', 'desc')
                ->take(config('constants.last_news_count'))
                ->get()->toArray();
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $news_list;
        }

        for ($i = 0; $i < count($news_list); ++$i) {
            $news_list[$i]['updated_at'] = date('Y-m-d h:i:s', strtotime($news_list[$i]['updated_at']));
        }

        return $news_list;
    }

    /**
     * get last notifications.
     *
     * @return array
     */
    public static function getLastNotifications()
    {
        $user = Auth::user();

        $notification_list = [];

        try {
            $notification_list = Notifications::leftjoin('ct_users_notifications_detail', 'ct_users_notifications.id', '=', 'ct_users_notifications_detail.notify_id')
                ->where('ct_users_notifications_detail.user_id', $user->id)
                ->orderby('ct_users_notifications.updated_at', 'desc')
                ->select('ct_users_notifications.*', 'ct_users_notifications_detail.status', 'ct_users_notifications_detail.user_id')
                ->take(config('constants.last_notification_count'))
                ->get()->toArray();
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $notification_list;
        }

        for ($i = 0; $i < count($notification_list); ++$i) {
            $notification_list[$i]['updated_at'] = date('Y-m-d h:i:s', strtotime($notification_list[$i]['updated_at']));
        }

        return $notification_list;
    }

    /**
     * get deposit status.
     *
     * @param $status
     *
     * @return null|array|\Illuminate\Contracts\Translation\Translator|string
     */
    protected function getDepositStatue($status)
    {
        $deposit_status = config('constants.deposit_status');
        if ($status == $deposit_status['confirmed']) {
            return trans('common.deposit_status.confirmed');
        } elseif ($status == $deposit_status['completed']) {
            return trans('common.deposit_status.completed');
        } elseif ($status == $deposit_status['processing']) {
            return trans('common.deposit_status.processing');
        } elseif ($status == $deposit_status['failed']) {
            return trans('common.deposit_status.failed');
        }

        return '';
    }

    /**
     * get withdraw status label.
     *
     * @param $status
     *
     * @return null|array|\Illuminate\Contracts\Translation\Translator|string
     */
    protected function getWithdrawStatue($status)
    {
        $withdraw_status = config('constants.withdraw_status');
        if ($status == $withdraw_status['requested']) {
            return trans('common.withdraw_status.requested');
        } elseif ($status == $withdraw_status['completed']) {
            return trans('common.withdraw_status.completed');
        } elseif ($status == $withdraw_status['processing']) {
            return trans('common.withdraw_status.processing');
        } elseif ($status == $withdraw_status['failed']) {
            return trans('common.withdraw_status.failed');
        } elseif ($status == $withdraw_status['canceled']) {
            return trans('common.withdraw_status.canceled');
        }

        return '';
    }

    /**
     * get trade type label.
     *
     * @param $type
     *
     * @return null|array|\Illuminate\Contracts\Translation\Translator|string
     */
    protected function getTradeType($type)
    {
        $trade_type = config('constants.trade_type');
        if ($type == $trade_type['exchange']) {
            return trans('common.trade_type.exchange');
        } elseif ($type == $trade_type['dealer']) {
            return trans('common.trade_type.dealer');
        }

        return '';
    }

    /**
     * get order type label.
     *
     * @param $type
     *
     * @return null|array|\Illuminate\Contracts\Translation\Translator|string
     */
    protected function getOrderType($type)
    {
        $order_type = config('constants.order_type');
        if ($type == $order_type['sell']) {
            return trans('common.order_type.sell');
        } elseif ($type == $order_type['buy']) {
            return trans('common.order_type.buy');
        }

        return '';
    }

    /**
     * get order status label.
     *
     * @param $status
     *
     * @return null|array|\Illuminate\Contracts\Translation\Translator|string
     */
    public function getOrderStatus($status)
    {
        $order_status = config('constants.order_status');
        if ($status == $order_status['pending']) {
            return trans('common.order_status.pending');
        } elseif ($status == $order_status['settled']) {
            return trans('common.order_status.settled');
        } elseif ($status == $order_status['settlement']) {
            return trans('common.order_status.settlement');
        } elseif ($status == $order_status['canceled']) {
            return trans('common.order_status.canceled');
        } elseif ($status == $order_status['canceling']) {
            return trans('common.order_status.canceling');
        }

        return '';
    }

    /**
     * get trade status label.
     *
     * @param $status
     *
     * @return null|array|\Illuminate\Contracts\Translation\Translator|string
     */
    protected function getTradeStatue($status)
    {
        $trade_status = config('constants.trade_status');
        if ($status == $trade_status['settled']) {
            return trans('common.trade_status.settled');
        } elseif ($status == $trade_status['canceled']) {
            return trans('common.trade_status.canceled');
        }

        return '';
    }

    /**
     * get Daily Data.
     *
     * @param int $currency
     *
     * @return array
     */
    protected function getDayDataByCurrency($currency = 0)
    {
        $daily_data = [];

        try {
            $query = DailyFluct::orderby('id', 'asc');

            if (empty($currency)) {
                $daily_data = $query->select('option', 'currency', 'value')->get()->toArray();
            } else {
                $daily_data = $query->where('currency', $currency)->pluck('value', 'option')->toArray();
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $daily_data;
        }

        return $daily_data;
    }

    /**
     * get kyc docs.
     *
     * @return array
     */
    protected function getKYCInfo()
    {
        $user = Auth::user();

        $kyc_infos = [];

        try {
            $kyc_infos = Identity::where('user_id', $user->id)
                ->get()->toArray();
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $kyc_infos;
        }

        return $kyc_infos;
    }

    /**
     * get country list.
     *
     * @return array
     */
    protected function getCountryList()
    {
        $country_list = [];

        try {
            $country_list = CountryList::orderby('name', 'asc')
                ->get()->toArray();
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $country_list;
        }

        return $country_list;
    }
}
