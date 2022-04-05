<?php

namespace App\Http\Controllers;

use App\Models\Storage;
use App\Models\TypeStorage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class StorageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name_storage.required' => __('Name: Required'),
            'phone.required' => __('Phone: Required'),
            'email.required' => __('Email: Required'),
            'bank.required' => __('Bank: Required'),
            'operator.required' => __('Operator number: Required'),

        ];
        $validator = Validator::make($request->all(), [
            'name_storage' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'bank' => 'required',
            'operator' => 'required',

        ], $messages);
        if ($validator->fails()) {
            $result['status'] = 0;
            $result['message'] = '';
            foreach ($validator->errors()->all() as $key => $value) {
                $result['message'] .= $value . '<br/>';
            }
            $result['data'] = null;
            $result['type_message'] = 'error';

            return $result;
        }
        if ($request->agency == 2) {//agency
            $agen = Storage::where('code', $request->codea)->where('bank_id', $request->bank)->get();
            if (count($agen) === 0) {
                $agency = new Storage();
                $agency->code = $request->codea;
                $agency->name_storage = $request->name_storage;
                $agency->telephone_operator_id = $request->operator;
                $agency->phone = $request->phone;
                $agency->email = $request->email;
                $agency->bank_id = $request->bank;
                $agency->address_id = '1';
                $agency->status = 1;
                $agency->responsible_id = '1';
                $agency->type_storage_id = $request->agency;
                $agency->user_id = Auth::user()->id;
                $agency->register_date = now();
                $agency->ip = \Request::ip();
                $agency->save();

                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('Agency Register Success');
                $result['data'] = null;
                $result['type_message'] = 'success';
                $result['redirect'] = route('agency');
            } else {
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Agencia ya existe para Banco Seleccionado');
                $result['type_message'] = 'error';
            }

            return $result;
        }
        $result['status'] = 0;
        $result['title'] = __('');
        $result['message'] = __('Error al registrar datos. Comuniquese con el administrador');
        $result['type_message'] = 'error';

        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Storage $storage)
    {
        $messages = [
            'name_storage.required' => __('Name: Required'),
            'phone.required' => __('Phone: Required'),
            'email.required' => __('Email: Required'),
            'codea.required' => __('Code: Required'),
        ];
        $validator = Validator::make($request->all(), [
            'name_storage' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'codea' => 'required',
        ], $messages);
        if ($validator->fails()) {
            $result['status'] = 0;
            $result['message'] = '';
            foreach ($validator->errors()->all() as $key => $value) {
                $result['message'] .= $value . '<br/>';
            }
            $result['data'] = null;
            $result['type_message'] = 'error';

            return $result;
        }
        $StoragetUpdate = Storage::find($request->id);
        $StoragetUpdate->code = $request->codea;
        $StoragetUpdate->name_storage = $request->name_storage;
        $StoragetUpdate->telephone_operator_id = $request->telephone_operator_id;
        $StoragetUpdate->phone = $request->phone;
        $StoragetUpdate->email = $request->email;
        $StoragetUpdate->save();

        if ($request->agency == 2) {
            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Agency Update Success');
            $result['data'] = null;
            $result['type_message'] = 'success';
            $result['redirect'] = route('agency');

            return $result;
        }

        $result['status'] = 0;
        $result['title'] = __('');
        $result['message'] = __('Error');
        $result['type_message'] = 'error';

        return $result;
    }

    public function change_status($id, $action)
    {
        if (\Request::ajax()) {
            try {
                $item = Storage::find($id);
                $item->status = $action;
                $item->save();
                $msg = $action == 0 ? __('Deleted') : __('Restored');

                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = $msg;
                $result['type_message'] = 'success';
                $result['redirect'] = route('agency');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('agency');
            }

            return $result;
        }

        return Redirect::to('home');
    }

    /*
    |--------------------------------------------------------------------------
    | MAINTENANCE Storages
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
            $storages = Storage::where('type_storage_id', '!=', $this->idStorageAgency)->get();

            return view('storages.index', compact('storages'));
        }

        return Redirect::to('home');
    }

    public function showRegister()
    {
        if (\Request::ajax()) {
            $Cod = Storage::orderBy('id', 'desc')->first();
            $Cde = $Cod['id'] + 1;
            $Code = $this->FullSerial($Cde, 4);

            $typeStorages = TypeStorage::where('id', '!=', $this->idStorageAgency)->pluck('description', 'id');

            return view('storages.create', compact('typeStorages', 'Code'));
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
                'code.numeric' => __('The Code must be Numeric'),
                'name_storage.required' => __('Name: Required'),
                'name_storage.unique' => __('Name Storage already exists'),
                'name_storage.max' => __('Unsupported value length'),
                'phone.required' => __('Phone number is Required'),
                'phone.min' => __('length of minimum unsupported for phone'),
                'phone.max' => __('length of maximum unsupported for phone'),
                'operator.required' => __('Operator number: Required'),

            ];
            $validator = Validator::make($request->all(), [
                'code' => 'numeric',
                'name_storage' => 'required|max:50|unique:storages,name_storage',
                'phone' => 'required|min:7|max:7',
                'operator' => 'required',

            ], $messages);
            if ($validator->fails()) {
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('storage');
            } else {
                try {
                    $storage = new Storage();
                    $code = $storage->code = FullSerial($storage->id, 4);
                    $storage->code = $request->code;
                    $storage->name_storage = $request->name_storage;
                    $storage->telephone_operator_id = $request->operator;
                    $storage->phone = $request->phone;
                    $storage->bank_id = 1;
                    $storage->address_id = 1;
                    $storage->responsible_id = 1;
                    $storage->type_storage_id = $request->type_storage;
                    $storage->user_id = Auth::user()->id;
                    $storage->register_date = now();
                    $storage->ip = \Request::ip();
                    $storage->save();

                    $result['status'] = 1;
                    $result['title'] = __('');
                    $result['message'] = __('Stored');
                    $result['data'] = null;
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('storage');
                } catch (Exception $e) {
                    $result['status'] = 0;
                    $result['title'] = __('Storages');
                    $result['message'] = $e->getMessage();
                    $result['type_message'] = 'error';
                    $result['redirect'] = route('storage');
                }
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function showEdit($id)
    {
        if (\Request::ajax()) {
            $Cod = Storage::orderBy('id', 'desc')->get();
            $Cde = count($Cod) + 1;
            $Code = $this->FullSerial($Cde, 4);

            $typeStorages = TypeStorage::where('id', '!=', $this->idStorageAgency)->pluck('description', 'id');

            $item = Storage::find($id)->toArray();

            return view('storages.edit', compact('item', 'typeStorages', 'Code'));
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
                'name_storage.required' => __('Name: Required'),
                'name_storage.unique' => __('Name Storage already exists'),
                'name_storage.max' => __('Unsupported value length'),
                'phone.required' => __('Phone number is Required'),
                'phone.min' => __('length of minimum unsupported for phone'),
                'phone.max' => __('length of maximum unsupported for phone'),
            ];

            $validator = Validator::make($request->all(), [
                'name_storage' => 'required|max:50|unique:storages,name_storage,' . $request->id,
                'phone' => 'required|min:7|max:7',
            ], $messages);

            if ($validator->fails()) {
                $result['title'] = __('Storages');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('storage');
            } else {
                try {
                    $StoragetUpdate = Storage::find($request->id);
                    $StoragetUpdate->name_storage = $request->name_storage;
                    $StoragetUpdate->telephone_operator_id = $request->telephone_operator_id;
                    $StoragetUpdate->phone = $request->phone;
                    $StoragetUpdate->type_storage_id = $request->type_storage_id;
                    $StoragetUpdate->user_id = Auth::user()->id;
                    $StoragetUpdate->register_date = date('Y-m-d H-i-s');
                    $StoragetUpdate->ip = $request->ip();
                    $StoragetUpdate->save();

                    $result['status'] = 1;
                    $result['title'] = __('Storages');
                    $result['message'] = __('Updated');
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('storage');
                } catch (Exception $e) {
                    $result['status'] = 0;
                    $result['title'] = __('Storages');
                    $result['message'] = $e->getMessage();
                    $result['type_message'] = 'error';
                    $result['redirect'] = route('storage');
                }
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function change_status_Storages($id, $action)
    {
        if (\Request::ajax()) {
            try {
                $Storage = Storage::find($id);
                $Storage->status = $action;
                $Storage->save();
                $msg = $action == 0 ? __('Deleted') : __('Restored');

                $result['status'] = 1;
                $result['title'] = __('Storages');
                $result['message'] = $msg;
                $result['data'] = null;
                $result['type_message'] = 'success';
                $result['redirect'] = route('storage');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Storages');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('storage');
            }

            return $result;
        }

        return Redirect::to('home');
    }
}
