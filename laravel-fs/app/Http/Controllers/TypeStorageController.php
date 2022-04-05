<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\TypeStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TypeStorageController extends Controller
{
    public function index()
    {
        if (\Request::ajax()) {
            $type_storages = TypeStorage::orderBy('description')->get()->toArray();

            return view('type_storages.index', compact('type_storages'));
        }

        return Redirect::to('home');
    }

    public function create()
    {
        if (\Request::ajax()) {
            $bank = Bank::where('status', 1)->pluck('name_bank', 'id');

            return view('type_storages.create', compact('bank'));
        }

        return Redirect::to('home');
    }

    public function store(Request $request)
    {
        if (\Request::ajax()) {
            $campos = [
                'description' => 'required|string|max:50|unique:type_storages',
                'bank' => 'required',
            ];
            $mensaje = [
                'description.unique' => __(' Description already exists'),
                'required' => 'The :attribute is required', ];
            $validator = Validator::make($request->all(), $campos, $mensaje);
            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Error ');
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = '';

                return $result;
            }

            $type_storages = new TypeStorage();
            $type_storages->description = $request->description;
            $type_storages->bank_id = $request->bank;
            $type_storages->user_id = Auth::user()->id;
            $type_storages->ip = $request->ip();
            $type_storages->register_date = date('Y-m-d H-i-s');
            $type_storages->save();

            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Type Of Storage Register');
            $result['data'] = null;
            $result['type_message'] = 'success';
            $result['redirect'] = route('typeStore');

            return $result;
        }

        return Redirect::to('home');
    }

    public function edit($id)
    {
        if (\Request::ajax()) {
            $bank = Bank::where('status', 1)->pluck('name_bank', 'id');
            $typeStorages = TypeStorage::where('id', $id)->get()->toArray();

            return view('type_storages.edit', compact('bank', 'typeStorages'));
        }

        return Redirect::to('home');
    }

    public function update(Request $request)
    {
        if (\Request::ajax()) {
            $campos = [

                __('description') => 'required|string|max:50|unique:type_storages,description,' . $request->id,
                __('bank') => 'required',

            ];
            $mensaje = [

                'description.unique' => __(' Description already exists'),
                'required' => 'The :attribute is required',

            ];

            $validator = Validator::make($request->all(), $campos, $mensaje);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Error ');

                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = '';

                return $result;
            }

            $type_storages = TypeStorage::find($request->id);
            $type_storages->description = $request->description;
            $type_storages->bank_id = $request->bank;
            $type_storages->save();

            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Type Of Storage Update');
            $result['data'] = null;
            $result['type_message'] = 'success';
            $result['redirect'] = route('typeStore');

            return $result;
        }

        return Redirect::to('home');
    }

    public function change_status($id, $action)
    {
        if (\Request::ajax()) {
            $Storage = TypeStorage::find($id);
            $Storage->status = $action;
            $Storage->save();
            $msg = $action == 0 ? 'Deleted' : 'Restored';

            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Type Of Storage ' . $msg);
            $result['data'] = null;
            $result['type_message'] = 'success';
            $result['redirect'] = route('typeStore');

            return $result;
        }

        return Redirect::to('home');
    }
}
