<?php

namespace App\Http\Controllers;

use App\Models\Models;
use App\Models\TradeMark;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ModelController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MAINTENANCE Models
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
            $models = Models::all();

            return view('models.index', compact('models'));
        }

        return Redirect::to('home');
    }

    public function showRegister()
    {
        if (\Request::ajax()) {
            $TradeMark = TradeMark::where('status', $this->statusAvailable)->pluck('name_trade_mark', 'id');

            return view('models.create', compact('TradeMark'));
        }

        return Redirect::to('home');
    }

    public function create(Request $request)
    {
        $messages = [

            'serial.required' => __('Serial: Required'),
            'serial.numeric' => __('The Serial must be Numeric'),
            'serial.unique' => __('Name Serial already exists'),
            'quantity.required' => __('Quantity: Required'),
            'quantity.numeric' => __('The Quantity must be Numeric'),
            'price.required' => __('Price: Required'),
            'weight.required' => __('Weight is Required'),
            'weight.max' => __('Weight: Unsupported value length'),
            'color.required' => __('Color is Required'),
            'color.max' => __('Color: Unsupported value length'),
        ];
        $validator = Validator::make($request->all(), [

            'serial' => 'required|numeric|unique:models,serial',
            'quantity' => 'required|numeric',
            'price' => 'required',
            'weight' => 'required|max:100',
            'color' => 'required|max:100',

        ], $messages);
        if ($validator->fails()) {
            $result['status'] = 0;
            $result['message'] = '';
            foreach ($validator->errors()->all() as $key => $value) {
                $result['message'] .= $value . '<br/>';
            }
            $result['data'] = null;
            $result['type_message'] = 'error';
            $result['redirect'] = route('models');

            return $result;
        }

        try {
            $Models = new Models();
            $Models->serial = $request->serial;
            $Models->weight = $request->weight;
            $Models->color = $request->color;
            $Models->quantity = $request->quantity;
            $Models->price = $request->price;
            $Models->trade_mark_id = $request->trade_mark_id;
            $Models->user_id = Auth::user()->id;
            $Models->date_register = now();
            $Models->ip = \Request::ip();
            $Models->save();

            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Stored');
            $result['data'] = null;
            $result['type_message'] = 'success';
            $result['redirect'] = route('models');
        } catch (Exception $e) {
            $result['status'] = 0;
            $result['title'] = __('Models');
            $result['message'] = $e->getMessage();
            $result['type_message'] = 'error';
            $result['redirect'] = route('models');
        }

        return $result;
    }

    public function showEdit($id)
    {
        if (\Request::ajax()) {
            $TradeMark = TradeMark::where('status', $this->statusAvailable)->pluck('name_trade_mark', 'id');

            $item = Models::find($id);

            return view('models.edit', compact('item', 'TradeMark'));
        }

        return Redirect::to('home');
    }

    public function edit(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'serial.required' => __('Serial: Required'),
                'serial.numeric' => __('The serial must be Numeric'),
                'serial.unique' => __('Name Serial already exists'),
                'quantity.required' => __('Quantity: Required'),
                'quantity.numeric' => __('The Quantity must be Numeric'),
                'price.required' => __('Price: Required'),
                'weight.required' => __('Weight is Required'),
                'weight.max' => __('Unsupported value length'),
                'color.required' => __('Color is Required'),
            ];

            $validator = Validator::make($request->all(), [

                'serial' => 'required|numeric|unique:models,serial,' . $request->id,
                'quantity' => 'required|numeric',
                'price' => 'required',
                'weight' => 'required|max:100',
                'color' => 'required|max:100',

            ], $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Models');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('models');

                return $result;
            }

            try {
                $ModelstUpdate = Models::find($request->id);
                $ModelstUpdate->serial = $request->serial;
                $ModelstUpdate->weight = $request->weight;
                $ModelstUpdate->color = $request->color;
                $ModelstUpdate->quantity = $request->quantity;
                $ModelstUpdate->price = $request->price;
                $ModelstUpdate->trade_mark_id = $request->trade_mark_id;
                $ModelstUpdate->user_id = Auth::user()->id;
                $ModelstUpdate->date_register = now();
                $ModelstUpdate->ip = \Request::ip();
                $ModelstUpdate->save();

                $result['status'] = 1;
                $result['title'] = __('Models');
                $result['message'] = __('Updated');
                $result['type_message'] = 'success';
                $result['redirect'] = route('models');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Models');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('models');
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function change_status_models($id, $action)
    {
        if (\Request::ajax()) {
            try {
                $Models = Models::find($id);
                $Models->status = $action;
                $Models->save();
                $msg = $action == 0 ? __('Deleted') : __('Restored');

                $result['status'] = 1;
                $result['title'] = __('Models');
                $result['message'] = $msg;
                $result['data'] = null;
                $result['type_message'] = 'success';
                $result['redirect'] = route('models');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Models');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('models');
            }

            return $result;
        }

        return Redirect::to('home');
    }
}
