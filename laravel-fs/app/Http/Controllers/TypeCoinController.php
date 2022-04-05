<?php

namespace App\Http\Controllers;

use App\Models\TypeCoin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TypeCoinController extends Controller
{
    public function index()
    {
        if (\Request::ajax()) {
            $coin = TypeCoin::all()->toArray();

            return view('coin_type.coin_type', compact('coin'));
        }

        return Redirect::to('home');
    }

    public function create()
    {
        if (\Request::ajax()) {
            return view('coin_type.create_coin');
        }

        return Redirect::to('home');
    }

    public function store(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'symbol.required' => __('Symbol Required'),
                'symbol_edit.max' => __('Maximum length of symbol values not supported'),
                'symbol.unique' => __('Symbol already exists'),
                'name_coin.unique' => __('Description already exists'),
                'name_coin.required' => __('Name Required'),
            ];

            $validator = Validator::make($request->all(), [
                'symbol' => 'required|max:5|unique:type_coins',
                'name_coin' => 'required|max:50|unique:type_coins',
            ], $messages);

            if ($validator->fails()) {
                $result['title'] = __('Coin type');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('typeCoin');
            } else {
                try {
                    $item = new TypeCoin();
                    $item->symbol = $request->symbol;
                    $item->name_coin = $request->name_coin;
                    $item->user_id = Auth::user()->id;
                    $item->register_date = date('Y-m-d H-i-s');
                    $item->ip = $request->ip();
                    $item->save();

                    $result['status'] = 1;
                    $result['title'] = __('Coin type');
                    $result['message'] = __('Stored');
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('typeCoin');
                } catch (Exception $e) {
                    $result['status'] = 0;
                    $result['title'] = __('Coin type');
                    $result['message'] = $e->getMessage();
                    $result['type_message'] = 'error';
                    $result['redirect'] = route('typeCoin');
                }
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function edit($id)
    {
        if (\Request::ajax()) {
            $item = TypeCoin::find($id)->toArray();

            return view('coin_type.edit_coin', compact('item'));
        }

        return Redirect::to('home');
    }

    public function update(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'symbol_edit.required' => __('Symbol Required'),
                'symbol.unique' => __('Symbol already exists'),
                'name_coin_edit.unique' => __('Description already exists'),
                'symbol_edit.max' => __('Maximum length of symbol values not supported'),
                'name_coin_edit.required' => __('Name Required'),
            ];

            $validator = Validator::make($request->all(), [
                'symbol_edit' => 'required|max:5|unique:type_coins,symbol,' . $request->id,
                'name_coin_edit' => 'required|max:50|unique:type_coins,name_coin,' . $request->id,
            ], $messages);

            if ($validator->fails()) {
                $result['title'] = __('Coin type');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('typeCoin');
            } else {
                try {
                    $item = TypeCoin::find($request->id);
                    $item->symbol = $request->symbol_edit;
                    $item->name_coin = $request->name_coin_edit;
                    $item->user_id = Auth::user()->id;
                    $item->register_date = date('Y-m-d H-i-s');
                    $item->ip = $request->ip();
                    $item->save();

                    $result['status'] = 1;
                    $result['title'] = __('Coin type');
                    $result['message'] = __('Updated');
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('typeCoin');
                } catch (Exception $e) {
                    $result['status'] = 0;
                    $result['title'] = __('Coin type');
                    $result['message'] = $e->getMessage();
                    $result['type_message'] = 'error';
                    $result['redirect'] = route('typeCoin');
                }
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function change_status($id, $action)
    {
        if (\Request::ajax()) {
            try {
                $item = TypeCoin::find($id);
                $item->status = $action;
                $item->save();
                $msg = $action == 0 ? __('Deleted') : __('Restored');

                $result['status'] = 1;
                $result['title'] = __('Coin type');
                $result['message'] = $msg;
                $result['type_message'] = 'success';
                $result['redirect'] = route('typeCoin');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Coin type');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('typeCoin');
            }

            return $result;
        }

        return Redirect::to('home');
    }
}
