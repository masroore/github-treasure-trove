<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\TypeAccount;
use App\Models\TypeCoin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TypeAccountController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MAINTENANCE Type Account
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        if (\Request::ajax()) {
            $TypeAcount = TypeAccount::all();

            return view('type_account.index', compact('TypeAcount'));
        }

        return Redirect::to('home');
    }

    public function showRegister()
    {
        if (\Request::ajax()) {
            $typeCoin = TypeCoin::where('status', $this->statusAvailable)->get()->pluck('name_coin', 'id');

            $bank = Bank::where('status', $this->statusAvailable)->get()->pluck('name_bank', 'id');

            return view('type_account.create', compact('typeCoin', 'bank'));
        }

        return Redirect::to('home');
    }

    public function create(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'name_product.required' => __('Name: Required'),
                'name_product.unique' => __('Name Product already exists'),
                'name_product.max' => __('Unsupported value length'),
                'type_coin_id.required' => __('Type Coin Required'),
                'bank_id.required' => __('Bank: Required'),

            ];
            $validator = Validator::make($request->all(), [
                'name_product' => 'required|max:150|unique:type_accounts,name_product',
                'type_coin_id' => 'required',
                'bank_id' => 'required',

            ], $messages);
            if ($validator->fails()) {
                $result['title'] = __('Type Account');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
            } else {
                try {
                    $TypeAccount = new TypeAccount();
                    $TypeAccount->name_product = $request->name_product;
                    $TypeAccount->type_coin_id = $request->type_coin_id;
                    $TypeAccount->bank_id = $request->bank_id;
                    $TypeAccount->user_id = Auth::user()->id;
                    $TypeAccount->register_date = now();
                    $TypeAccount->ip = \Request::ip();
                    $TypeAccount->save();

                    $result['status'] = 1;
                    $result['title'] = __('');
                    $result['message'] = __('Stored');
                    $result['data'] = null;
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('type_account');
                } catch (Exception $e) {
                    $result['status'] = 0;
                    $result['title'] = __('Type Account');
                    $result['message'] = $e->getMessage();
                    $result['type_message'] = 'error';
                    $result['redirect'] = route('type_account');
                }
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function showEdit($id)
    {
        if (\Request::ajax()) {
            $typeCoin = TypeCoin::where('status', $this->statusAvailable)->get()->pluck('name_coin', 'id');

            $bank = Bank::where('status', $this->statusAvailable)->get()->pluck('name_bank', 'id');

            $item = TypeAccount::find($id)->toArray();

            return view('type_account.edit', compact('typeCoin', 'bank', 'item'));
        }

        return Redirect::to('home');
    }

    public function edit(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'name_product.required' => __('Name: Required'),
                'name_product.unique' => __('Name Product already exists'),
                'name_product.max' => __('Unsupported value length'),
                'type_coin_id.required' => __('Type Coin Required'),
                'bank_id.required' => __('Bank: Required'),
            ];

            $validator = Validator::make($request->all(), [
                'name_product' => 'required|max:150|unique:type_accounts,name_product,' . $request->id,
                'type_coin_id' => 'required',
                'bank_id' => 'required',
            ], $messages);

            if ($validator->fails()) {
                $result['title'] = __('Type Account');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('type_account');
            } else {
                try {
                    $TypeAccountUpdate = TypeAccount::find($request->id);
                    $TypeAccountUpdate->name_product = $request->name_product;
                    $TypeAccountUpdate->type_coin_id = $request->type_coin_id;
                    $TypeAccountUpdate->bank_id = $request->bank_id;
                    $TypeAccountUpdate->user_id = Auth::user()->id;
                    $TypeAccountUpdate->register_date = now();
                    $TypeAccountUpdate->ip = \Request::ip();
                    $TypeAccountUpdate->save();

                    $result['status'] = 1;
                    $result['title'] = __('Type Account');
                    $result['message'] = __('Updated');
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('type_account');
                } catch (Exception $e) {
                    $result['status'] = 0;
                    $result['title'] = __('Type Account');
                    $result['message'] = $e->getMessage();
                    $result['type_message'] = 'error';
                    $result['redirect'] = route('type_account');
                }
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function change_status_account($id, $action)
    {
        if (\Request::ajax()) {
            try {
                $TypeAccount = TypeAccount::find($id);
                $TypeAccount->status = $action;
                $TypeAccount->save();
                $msg = $action == 0 ? __('Deleted') : __('Restored');

                $result['status'] = 1;
                $result['title'] = __('Type Account');
                $result['message'] = $msg;
                $result['data'] = null;
                $result['type_message'] = 'success';
                $result['redirect'] = route('type_account');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Type Account');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('type_account');
            }

            return $result;
        }

        return Redirect::to('home');
    }
}
