<?php

namespace App\Http\Controllers;

use App\Models\CoinTransaction;
use App\Models\TypeCoin;
use App\Models\TypeTransaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Request::ajax()) {
            $model = CoinTransaction::all()->toArray();

            return view('transaction.transactions', compact('model'));
        }

        return Redirect::to('home');
    }

    public function create()
    {
        if (\Request::ajax()) {
            $typeCoin = TypeCoin::pluck('name_coin', 'id');
            $typeTransaction = TypeTransaction::pluck('name_transaction', 'id');

            return view('transaction.transactions_create', compact('typeTransaction', 'typeCoin'));
        }

        return Redirect::to('home');
    }

    public function store(Request $request)
    {
        $messages = [
            'coin_type.required' => __('Type Coin Required'),
            'type_transaction.required' => __('Type Transaction Required'),
        ];
        $validator = Validator::make($request->all(), [

            'coin_type' => 'required',
            'type_transaction' => 'required',

        ], $messages);
        if ($validator->fails()) {
            $result['status'] = 0;
            $result['message'] = '';
            foreach ($validator->errors()->all() as $key => $value) {
                $result['message'] .= $value . '<br/>';
            }
            $result['data'] = null;
            $result['type_message'] = 'error';
            $result['redirect'] = route('transaction');

            return $result;
        }

        try {
            $item = new CoinTransaction();
            $item->type_coin_id = $request->coin_type;
            $item->type_transactions_id = $request->type_transaction;
            $item->user_id = Auth::user()->id;
            $item->register_date = date('Y-m-d H-i-s');
            $item->ip = $request->ip();
            $item->save();

            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Stored');
            $result['data'] = null;
            $result['type_message'] = 'success';
            $result['redirect'] = route('transactions');
        } catch (Exception $e) {
            $result['status'] = 0;
            $result['title'] = __('Transaction');
            $result['message'] = $e->getMessage();
            $result['type_message'] = 'error';
            $result['redirect'] = route('transactions');
        }

        return $result;
    }

    public function edit($id)
    {
        if (\Request::ajax()) {
            $item = CoinTransaction::where('id', $id)->get()->toArray();
            $typeCoin = TypeCoin::pluck('name_coin', 'id');
            $typeTransaction = TypeTransaction::pluck('name_transaction', 'id');

            return view('transaction.transactions_edit', compact('item', 'typeCoin', 'typeTransaction'));
        }

        return Redirect::to('home');
    }

    public function update(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'coin_type_update.required' => __('Type Coin Required'),
                'type_transaction_update.required' => __('Type Transaction Required'),
            ];

            $validator = Validator::make($request->all(), [
                'coin_type_update' => 'required',
                'type_transaction_update' => 'required',

            ], $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Transaction');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('transactions');

                return $result;
            }

            try {
                $item = new CoinTransaction();
                $item->type_coin_id = $request->coin_type_update;
                $item->type_transactions_id = $request->type_transaction_update;
                $item->user_id = Auth::user()->id;
                $item->register_date = date('Y-m-d H-i-s');
                $item->ip = $request->ip();
                $item->save();

                $result['status'] = 1;
                $result['title'] = __('Transaction');
                $result['message'] = __('Updated');
                $result['type_message'] = 'success';
                $result['redirect'] = route('transactions');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Transaction');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('transactions');
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function change_status($id, $type)
    {
        if (\Request::ajax()) {
            $item = CoinTransaction::find($id);
            $item->status = $type;
            $item->save();
            $msg = $type == 0 ? 'Deleted' : 'Restored';

            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Transaction ' . $msg);
            $result['type_message'] = 'success';
            $result['redirect'] = route('transactions');

            return $result;
        }

        return Redirect::to('home');
    }
}
