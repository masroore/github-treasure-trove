<?php

namespace App\Http\Controllers;

use App\Models\TypeTransaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TypeTransactionController extends Controller
{
    public function index()
    {
        $model = TypeTransaction::all()->toArray();

        return view('type_transactions.index', compact('model'));
    }

    public function create()
    {
        if (\Request::ajax()) {
            return view('type_transactions.create');
        }

        return Redirect::to('home');
    }

    public function store(Request $request)
    {
        $messages = [
            'name_transaction.required' => __('Name Transaction: Required'),
            'name_transaction.string' => __('Name Transaction: Must be a string'),
            'name_transaction.unique' => __('Name Transaction: Already exists'),
            'obligatory.required' => __('Obligatory: Required'),
        ];
        $validator = Validator::make($request->all(), [

            'name_transaction' => 'required|string|max:100|unique:type_transactions,name_transaction',
            'obligatory.required' => __('Obligatory: Required'),

        ], $messages);
        if ($validator->fails()) {
            $result['status'] = 0;
            $result['message'] = '';
            foreach ($validator->errors()->all() as $key => $value) {
                $result['message'] .= $value . '<br/>';
            }
            $result['data'] = null;
            $result['type_message'] = 'error';
            $result['redirect'] = route('type_transactions');

            return $result;
        }

        try {
            $item = new TypeTransaction();
            $item->name_transaction = $request->name_transaction;
            $item->obligatory = $request->obligatory;
            $item->user_id = Auth::user()->id;
            $item->date_register = date('Y-m-d H-i-s');
            $item->ip = $request->ip();
            $item->save();

            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Stored');
            $result['data'] = null;
            $result['type_message'] = 'success';
            $result['redirect'] = route('type_transactions');
        } catch (Exception $e) {
            $result['status'] = 0;
            $result['title'] = __('Type Transaction');
            $result['message'] = $e->getMessage();
            $result['type_message'] = 'error';
            $result['redirect'] = route('type_transactions');
        }

        return $result;
    }

    public function edit($id)
    {
        if (\Request::ajax()) {
            $item = TypeTransaction::where('id', $id)->get()->toArray();

            return view('type_transactions.edit', compact('item'));
        }

        return Redirect::to('home');
    }

    public function update(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'name_transaction.required' => __('Name Transaction: Required'),
                'name_transaction.string' => __('Name Transaction: Must be a string'),
                'name_transaction.unique' => __('Name Transaction: Already exists'),
                'obligatory.required' => __('Obligatory: Required'),
            ];

            $validator = Validator::make($request->all(), [
                'name_transaction' => 'required|string|max:100|unique:type_transactions,name_transaction,' . $request->id,
                'obligatory' => 'required',
            ], $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Type Transaction');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('type_transactions');

                return $result;
            }

            try {
                $item = TypeTransaction::find($request->id);
                $item->name_transaction = $request->name_transaction;
                $item->obligatory = $request->obligatory;
                $item->user_id = Auth::user()->id;
                $item->date_register = date('Y-m-d H-i-s');
                $item->ip = $request->ip();
                $item->save();

                $result['status'] = 1;
                $result['title'] = __('Type Transaction');
                $result['message'] = __('Updated');
                $result['type_message'] = 'success';
                $result['redirect'] = route('type_transactions');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Type Transaction');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('type_transactions');
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function change_status($id, $type)
    {
        if (\Request::ajax()) {
            $item = TypeTransaction::find($id);
            $item->status = $type;
            $item->save();
            $msg = $type == 0 ? 'Deleted' : 'Restored';

            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Type Transaction ' . $msg);
            $result['type_message'] = 'success';
            $result['redirect'] = route('type_transactions');

            return $result;
        }

        return Redirect::to('home');
    }
}
