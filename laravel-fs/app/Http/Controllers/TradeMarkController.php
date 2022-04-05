<?php

namespace App\Http\Controllers;

//cargar

use App\Models\TradeMark;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TradeMarkController extends Controller
{
/*
|--------------------------------------------------------------------------
| MAINTENANCE Trade Mark
|--------------------------------------------------------------------------
*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Request::ajax()) {
            $trade_marks = TradeMark::all();

            return view('trade_marks.index', compact('trade_marks'));
        }

        return Redirect::to('home');
    }

    public function showRegister()
    {
        if (\Request::ajax()) {
            return view('trade_marks.create');
        }

        return Redirect::to('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [

                'name_trade_mark.required' => __('Name TradeMark: Required'),
                'name_trade_mark.unique' => __('Name TradeMark already exists'),
                'name_trade_mark.max' => __('Name TradeMark: Unsupported value length'),

            ];
            $validator = Validator::make($request->all(), [
                'name_trade_mark' => 'required|max:200|unique:trade_marks,name_trade_mark',

            ], $messages);
            if ($validator->fails()) {
                $result['title'] = __('Trade Marks');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('trade_marks');
            } else {
                try {
                    $TradeMark = new TradeMark();
                    $TradeMark->name_trade_mark = $request->name_trade_mark;
                    // $TradeMark->status        = 1;
                    $TradeMark->user_id = Auth::user()->id;
                    $TradeMark->date_register = now();
                    $TradeMark->ip = \Request::ip();
                    $TradeMark->save();

                    $result['status'] = 1;
                    $result['title'] = __('');
                    $result['message'] = __('Stored');
                    $result['data'] = null;
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('trade_marks');
                } catch (Exception $e) {
                    $result['status'] = 0;
                    $result['title'] = __('Trade Marks');
                    $result['message'] = $e->getMessage();
                    $result['type_message'] = 'error';
                    $result['redirect'] = route('trade_marks');
                }
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function showEdit($id)
    {
        if (\Request::ajax()) {
            $item = TradeMark::find($id)->toArray();

            return view('trade_marks.edit', compact('item'));
        }

        return Redirect::to('home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [

                'name_trade_mark.required' => __('Name TradeMark: Required'),
                'name_trade_mark.unique' => __('Name TradeMark already exists'),
                'name_trade_mark.max' => __('Name TradeMark: Unsupported value length'),

            ];

            $validator = Validator::make($request->all(), [
                'name_trade_mark' => 'required|max:200|unique:trade_marks,name_trade_mark,' . $request->id,

            ], $messages);

            if ($validator->fails()) {
                $result['title'] = __('Trade Marks');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('trade_marks');
            } else {
                try {
                    $TradeMarktUpdate = TradeMark::find($request->id);
                    $TradeMarktUpdate->name_trade_mark = $request->name_trade_mark;
                    $TradeMarktUpdate->user_id = Auth::user()->id;
                    $TradeMarktUpdate->date_register = date('Y-m-d H-i-s');
                    $TradeMarktUpdate->ip = $request->ip();
                    $TradeMarktUpdate->save();

                    $result['status'] = 1;
                    $result['title'] = __('Trade Marks');
                    $result['message'] = __('Updated');
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('trade_marks');
                } catch (Exception $e) {
                    $result['status'] = 0;
                    $result['title'] = __('Trade Marks');
                    $result['message'] = $e->getMessage();
                    $result['type_message'] = 'error';
                    $result['redirect'] = route('trade_marks');
                }
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function change_status_trade_marks($id, $action)
    {
        if (\Request::ajax()) {
            try {
                $TradeMark = TradeMark::find($id);
                $TradeMark->status = $action;
                $TradeMark->save();
                $msg = $action == 0 ? __('Deleted') : __('Restored');

                $result['status'] = 1;
                $result['title'] = __('Trade Marks');
                $result['message'] = $msg;
                $result['data'] = null;
                $result['type_message'] = 'success';
                $result['redirect'] = route('trade_marks');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Trade Marks');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('trade_marks');
            }

            return $result;
        }

        return Redirect::to('home');
    }
}
