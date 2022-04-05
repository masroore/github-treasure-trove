<?php

namespace App\Http\Controllers;

use App\Models\PayMethod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PayMethodController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MAINTENANCE Pay Method
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        if (\Request::ajax()) {
            $PayMethod = PayMethod::all();

            return view('pay_methods.index', compact('PayMethod'));
        }

        return Redirect::to('home');
    }

    public function showRegister()
    {
        if (\Request::ajax()) {
            return view('pay_methods.create');
        }

        return Redirect::to('home');
    }

    public function create(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'name_pay_method.required' => __('Name: Required'),
                'name_pay_method.unique' => __('Pay Method already exists'),
                'name_pay_method.max' => __('Unsupported value length'),
            ];
            $validator = Validator::make($request->all(), [
                'name_pay_method' => 'required|max:200|unique:pay_methods,name_pay_method',
            ], $messages);
            if ($validator->fails()) {
                $result['title'] = __('Pay Method');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
            } else {
                try {
                    $PayMethod = new PayMethod();
                    $PayMethod->name_pay_method = $request->name_pay_method;
                    $PayMethod->user_id = Auth::user()->id;
                    $PayMethod->register_date = now();
                    $PayMethod->ip = \Request::ip();
                    $PayMethod->save();

                    $result['status'] = 1;
                    $result['title'] = __('');
                    $result['message'] = __('Stored');
                    $result['data'] = null;
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('pay_methods');
                } catch (Exception $e) {
                    $result['status'] = 0;
                    $result['title'] = __('Pay Method');
                    $result['message'] = $e->getMessage();
                    $result['type_message'] = 'error';
                    $result['redirect'] = route('pay_methods');
                }
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function showEdit($id)
    {
        if (\Request::ajax()) {
            $item = PayMethod::find($id)->toArray();

            return view('pay_methods.edit', compact('item'));
        }

        return Redirect::to('home');
    }

    public function edit(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'name_pay_method.required' => __('Name: Required'),
                'name_pay_method.unique' => __('Pay Method already exists'),
                'name_pay_method.max' => __('Unsupported value length'),
            ];

            $validator = Validator::make($request->all(), [
                'name_pay_method' => 'required|max:200|unique:pay_methods,name_pay_method,' . $request->id,
            ], $messages);

            if ($validator->fails()) {
                $result['title'] = __('Pay Method');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('pay_methods');
            } else {
                try {
                    $PayMethodUpdate = PayMethod::find($request->id);
                    $PayMethodUpdate->name_pay_method = $request->name_pay_method;
                    $PayMethodUpdate->user_id = Auth::user()->id;
                    $PayMethodUpdate->register_date = now();
                    $PayMethodUpdate->ip = \Request::ip();
                    $PayMethodUpdate->save();

                    $result['status'] = 1;
                    $result['title'] = __('Pay Method');
                    $result['message'] = __('Updated');
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('pay_methods');
                } catch (Exception $e) {
                    $result['status'] = 0;
                    $result['title'] = __('Pay Method');
                    $result['message'] = $e->getMessage();
                    $result['type_message'] = 'error';
                    $result['redirect'] = route('pay_methods');
                }
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function change_status_method_pay($id, $action)
    {
        if (\Request::ajax()) {
            try {
                $PayMethod = PayMethod::find($id);
                $PayMethod->status = $action;
                $PayMethod->save();
                $msg = $action == 0 ? __('Deleted') : __('Restored');

                $result['status'] = 1;
                $result['title'] = __('Pay Method');
                $result['message'] = $msg;
                $result['data'] = null;
                $result['type_message'] = 'success';
                $result['redirect'] = route('pay_methods');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Pay Method');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('pay_methods');
            }

            return $result;
        }

        return Redirect::to('home');
    }
}
