<?php

namespace App\Http\Controllers;

use App\Models\Disposable;
use App\Models\UserBalance;
use App\Models\Withdraw;
use App\Modules\CryptoCurrencyAPI;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
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
        $user = Auth::user();

        $cryptocurrency_list = $this->getCryptocurrencyListWithBalance();

        try {
            $deposit_wallet_list = Disposable::where('user_id', $user->id)->get()->toArray();

            if (empty($deposit_wallet_list)) {
                $insert_data = [];
                foreach ($cryptocurrency_list as $cryptocurrency_info) {
                    if ($cryptocurrency_info['use_deposit'] == config('constants.use_deposit.disable')) {
                        continue;
                    }

                    $wallet_info = CryptoCurrencyAPI::call_generate_key($cryptocurrency_info['currency'], COIN_NET);
                    if (isset($wallet_info['detail'])) {
                        $insert_data[] = [
                            'user_id' => $user->id,
                            'currency' => $cryptocurrency_info['currency'],
                            'wallet_address' => $wallet_info['detail']['adr'],
                            'wallet_privkey' => $wallet_info['detail']['pri'],
                            'status' => config('constants.disposable_status.valid'),
                        ];
                    }
                }

                $res = Disposable::insert($insert_data);
                $deposit_wallet_list = $insert_data;
            } else {
                $insert_data = [];
                foreach ($cryptocurrency_list as $cryptocurrency_info) {
                    $key = array_search($cryptocurrency_info['currency'], array_column($deposit_wallet_list, 'currency'));
                    if ($key === 0) {
                        continue;
                    }

                    if (empty($key) && $cryptocurrency_info['use_deposit'] == config('constants.use_deposit.enable')) {
                        $wallet_info = CryptoCurrencyAPI::call_generate_key($cryptocurrency_info['currency'], COIN_NET);
                        if (isset($wallet_info['detail'])) {
                            $insert_data[] = [
                                'user_id' => $user->id,
                                'currency' => $cryptocurrency_info['currency'],
                                'wallet_address' => $wallet_info['detail']['adr'],
                                'wallet_privkey' => $wallet_info['detail']['pri'],
                                'status' => config('constants.disposable_status.valid'),
                            ];
                        }
                    }
                }
                $res = Disposable::insert($insert_data);
                $deposit_wallet_list = array_merge($deposit_wallet_list, $insert_data);
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
        }

        for ($i = 0; $i < count($cryptocurrency_list); ++$i) {
            $key = array_search($cryptocurrency_list[$i]['currency'], array_column($deposit_wallet_list, 'currency'));
            $cryptocurrency_list[$i]['deposit_addr'] = $deposit_wallet_list[$key]['wallet_address'];
        }

        $data['cryptocurrency_list'] = $cryptocurrency_list;

        return view('payment', $data);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function withdraw(Request $request)
    {
        $data = $request->all();

        if (empty($data['currency_url']) || empty($data['currency'])) {
            return redirect()->back()->withInput()->withErrors(['failed' => trans('payment.invalid_currency_msg')]);
        }

        $available_balance = $this->getAvailableBalanceFromCurrency($data['currency']);
        $crypto_setting = $this->getCryptocurrencySetting($data['currency']);
        if (empty($crypto_setting)) {
            $min_amount = 0;
        } else {
            $min_amount = _number_format2($crypto_setting['min_withdraw'], $crypto_setting['rate_decimals']);
        }

        $validator = Validator::make($data, [
            $data['currency_url'] . '_destination' => 'required|max:225',
            $data['currency_url'] . '_amount' => 'required|numeric|min:' . $min_amount . '|max:' . _number_format2($available_balance['available_balance'], $available_balance['decimals']),
            'currency' => 'required',
            'currency_url' => 'required',
        ], [
        ], [
            $data['currency_url'] . '_destination' => trans('payment.withdraw_address'),
            $data['currency_url'] . '_amount' => trans('payment.withdraw_amount'),
        ]);

        if (!CryptoCurrencyAPI::CheckWalletAddress($data[$data['currency_url'] . '_destination'], '', $data['currency'])) {
            $validator->errors()->add($data['currency_url'] . '_destination', trans('common.invalid_addr'));
            $errors = $validator->errors();

            return redirect()->back()->withInput()->withErrors($errors);
        }

        if ($validator->fails()) {
            $errors = $validator->errors();

            return redirect()->back()->withInput()->withErrors($errors);
        }

        $user = Auth::user();

        try {
            $balance_info = UserBalance::where('user_id', $user->id)
                ->where('currency', $data['currency'])
                ->lockForUpdate()
                ->first();
            if (null === $balance_info) {
                return redirect()->back()->withInput()->withErrors(['failed' => trans('payment.withdraw_failed_msg')]);
            }

            $balance_info->balance = $balance_info->balance - $data[$data['currency_url'] . '_amount'];
            $balance_info->save();

            $res = Withdraw::insert([
                'user_id' => $user->id,
                'currency' => $data['currency'],
                'destination' => $data[$data['currency_url'] . '_destination'],
                'type' => config('constants.withdraw_type.crypto'),
                'amount' => $data[$data['currency_url'] . '_amount'],
                'status' => config('constants.withdraw_status.requested'),
            ]);

            if (!$res) {
                return redirect()->back()->withInput()->withErrors(['failed' => trans('payment.withdraw_failed_msg')]);
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(['failed' => trans('payment.withdraw_failed_msg')]);
        }

        return redirect()->route('payment')->with('success', trans('payment.withdraw_success_msg'));
    }
}
