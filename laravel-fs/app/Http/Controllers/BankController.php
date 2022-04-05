<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Country;
use App\Models\Ica;
use App\Models\IcaBin;
use App\Models\IcaIdProcess;
use App\Models\TelephoneOperator;
use App\Models\TypeCoin;
use App\Models\TypeDocument;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;

class BankController extends Controller
{
    public function index()
    {
        if (\Request::ajax()) {
            $bank = Bank::get();
            $document_type = TypeDocument::pluck('abbreviation', 'id');
            $country = Country::pluck('code_phone', 'id');
            $operator = TelephoneOperator::pluck('code', 'id');

            foreach ($bank as $key => $value) {
                $ica[$key] = Ica::where('bank_id', $bank[$key]['id'])->pluck('code', 'id');
                $bank[$key]['number_ica'] = count($ica[$key]);
            }
            $restringer = 0;

            return view('banks.banks_index', compact('bank', 'document_type', 'country', 'operator', 'restringer'));
        }

        return Redirect::to('home');
    }

    /*
    public function searchBank(Request $request)
    {
        if(\Request::ajax()){
            $bank  = Bank::find($request->id);
            if($bank!=null){
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message']      = __('Bank already exists');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }else{
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] =  __('');
                $result['type_message'] = 'success';
                $result['redirect'] = route('banks');
            }
        }else{
            return Redirect::to('home');
        }
    }
    */
    public function searchIca(Request $request)
    {
        if (\Request::ajax()) {
            $ica = Ica::where('code', $request->code_ica)->where('type_coin_id', $request->type_coin)->first();
            if ($ica == null) {
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('');
                $result['type_message'] = 'success';
                $result['redirect'] = '';
            } else {
                $result['status'] = 0;
                $result['message'] = __('ICA Exists for type of Currency.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function searchIcaBin(Request $request)
    {
        if (\Request::ajax()) {
            $ica_bin = IcaBin::where('code', $request->code_bin)->where('ica_id', $request->code_ica_bin)->first();
            if ($ica_bin == null) {
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('');
                $result['type_message'] = 'success';
                $result['redirect'] = '';
            } else {
                $result['status'] = 0;
                $result['message'] = __('Bin exists for ICA Selected.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function searchIcaProcess(Request $request)
    {
        if (\Request::ajax()) {
            $ica_bin = IcaIdProcess::where('code', $request->code_process)->where('ica_id', $request->code_ica_process)->first();
            if ($ica_bin == null) {
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('');
                $result['type_message'] = 'success';
                $result['redirect'] = '';
            } else {
                $result['status'] = 0;
                $result['message'] = __('Id Process existe para Ica Seleccionado');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function create(Request $request)
    {
        if (\Request::ajax()) {
            $document_type = TypeDocument::pluck('abbreviation', 'id');
            $country = Country::pluck('code_phone', 'id');
            $operator = TelephoneOperator::pluck('code', 'id');
            $type_coin = TypeCoin::pluck('name_coin', 'id');

            return view('banks.banks_create', compact('document_type', 'country', 'operator', 'type_coin'));
        }

        return Redirect::to('home');
    }

    public function icaProcess(Request $request)
    {
        if (\Request::ajax()) {
            $bank = Bank::find($request->id);
            $ica = Ica::where('bank_id', $bank['id'])->pluck('code', 'id');
            $ica_bin_process = Ica::where('bank_id', $bank['id'])->get()->toArray();

            return view('banks.icaBin_create', compact('ica', 'ica_bin_process'));
        }

        return Redirect::to('home');
    }

    public function store(Request $request)
    {
        $messages = [
            'name_bank.required' => __('Username Required'),
            'code_bank.required' => __('Code Bank Required'),
            'code_bank.max' => __('Maximum document length is 4 digits'),
            'name_fantasy.required' => __('Name fantasy Required'),
            'document.required' => __('Document Required'),
            'document.max' => __('Maximum document length is 7 digits'),
            'document.min' => __('Minimum code length is 10 digits'),
            'email.required' => __('Email Required'),
            'email.email' => __('form email no valid'),
            'phone.required' => __('Phone Required'),
            'phone.numeric' => __('Phone numeric'),
        ];

        $validator = Validator::make($request->all(), [
            'name_bank' => 'required',
            'code_bank' => 'required|max:5',
            'name_fantasy' => 'required',
            'document' => 'required|min:7|max:10',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            $result['status'] = 0;
            $result['title'] = __('Bank');
            $result['message'] = '';
            foreach ($validator->errors()->all() as $key => $value) {
                $result['message'] .= $value . '<br/>';
            }
            $result['data'] = null;
            $result['type_message'] = 'error';

            return $result;
        }
        $bank = Bank::where('code', $request->code_bank)->first();
        if ($bank === null) {
            $item = new Bank();
            $item->name_bank = $request->name_bank;
            $item->code = $request->code_bank;
            $item->name_fantasy = $request->name_fantasy;
            $item->type_document_id = $request->type_documents;
            $item->document = $request->document;
            $item->email = $request->email;
            $item->phone = $request->phone;
            $item->telephone_operator_id = $request->telephone_operators;
            $item->address_id = '2';
            $item->responsible_id = '2';
            $item->status = '1';

            try {
                $item->save();
                $detail = $request->detail;
                if ($detail != null) {
                    foreach ($detail as $key => $value) {
                        $ica = new Ica();
                        $ica->code = $detail[$key]['code_ica'];
                        $ica->status = 1;
                        $ica->bank_id = $item->id;
                        $ica->type_coin_id = $detail[$key]['type_coin'];
                        $ica->user_id = Auth::user()->id;
                        $ica->register_date = now();
                        $ica->ip = \Request::ip();
                        $ica->save();
                    }
                }
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('Successfully stored');
                $result['type_message'] = 'success';
                $result['redirect'] = route('banks');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = __('Failed to register customer data, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }
        $result['status'] = 0;
        $result['title'] = __('');
        $result['message'] = __('Failed to log data. The Bank with code ' . $request->code_bank . ' it already exists');
        $result['type_message'] = 'error';
        $result['redirect'] = '';

        return $result;
    }

    public function storeBinProcess(Request $request)
    {
        if ($request->all() != null) {
            if ($request->detail_bin != null) {
                $detail_bin = $request->detail_bin;
                foreach ($detail_bin as $key => $value) {
                    $bin = new IcaBin();
                    $bin->code = $detail_bin[$key]['code_bin'];
                    $bin->description_bin = $detail_bin[$key]['description_bin'];
                    $bin->status = 1;
                    $bin->ica_id = $detail_bin[$key]['code_ica_bin'];
                    $bin->user_id = Auth::user()->id;
                    $bin->register_date = now();
                    $bin->ip = \Request::ip();
                    $bin->save();
                }
            }
            if ($request->detail_process != null) {
                $detail_process = $request->detail_process;
                foreach ($detail_process as $key => $value) {
                    $process = new IcaIdProcess();
                    $process->code = $detail_process[$key]['code_process'];
                    $process->description_process = $detail_process[$key]['description_process'];
                    $process->status = 1;
                    $process->ica_id = $detail_process[$key]['code_ica_process'];
                    $process->user_id = Auth::user()->id;
                    $process->register_date = now();
                    $process->ip = \Request::ip();
                    $process->save();
                }
            }

            try {
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('Register Success');
                $result['type_message'] = 'success';
                $result['redirect'] = route('banks');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('');
                $result['message'] = __('Failed to register customer data, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return __('There is no data to be stored');
    }

    public function edit(Request $request)
    {
        if (\Request::ajax()) {
            $item = Bank::find($request->id);
            $document_type = TypeDocument::pluck('abbreviation', 'id');
            $country = Country::pluck('code_phone', 'id');
            $operator = TelephoneOperator::pluck('code', 'id');
            $ica = Ica::where('bank_id', $item['id'])->get()->toArray();
            $coin = TypeCoin::pluck('name_coin', 'id');

            return view('banks.banks_edit', compact('item', 'document_type', 'country', 'operator', 'ica', 'coin'));
        }

        return Redirect::to('home');
    }

    public function editIca(Request $request)
    {
        if (\Request::ajax()) {
            $ica = Ica::find($request->id);

            try {
                $result['status'] = 1;
                $result['title'] = __('');
                $result['data'] = ['type_coin' => $ica['type_coin'], 'code_ica' => $ica['code'], 'ica_modif' => $ica['id']];
                $result['message'] = __('');
                $result['type_message'] = 'success';
                $result['redirect'] = '';

                return $result;
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Ica not found');
                $result['message'] = __('Failed to register customer data, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }
        } else {
            return Redirect::to('home');
        }
    }

    public function update(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'name_bank_edit.required' => __('Username Required'),
                'name_fantasy_edit.required' => __('Name Fantasy Required'),
                'document_edit.required' => __('Document Required'),
                'document_edit.max' => __('Maximum document length is 7 digits'),
                'document_edit.min' => __('Minimum code length is 10 digits'),
                'email_edit.required' => __('Email Required'),
                'email_edit.email' => __('Email format no valid'),
                'phone_edit.required' => __('Phone Required'),
                'phone_edit.numeric' => __('Phone numeric'),
            ];

            $validator = Validator::make($request->all(), [
                'name_bank_edit' => 'required',
                'name_fantasy_edit' => 'required',
                'document_edit' => 'required|min:7|max:10',
                'email_edit' => 'required|email',
                'phone_edit' => 'required|numeric',
            ], $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Bank');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';

                return $result;
            }
            $item = Bank::find($request->id);
            $item->name_bank = $request->name_bank_edit;
            $item->name_fantasy = $request->name_fantasy_edit;
            $item->type_document_id = $request->type_documents_edit;
            $item->document = $request->document_edit;
            $item->email = $request->email_edit;
            $item->telephone_operator_id = $request->telephone_operators_edit;
            $item->phone = $request->phone_edit;

            try {
                $item->save();
                $detail = $request->detail;
                if ($detail != null) {
                    foreach ($detail as $key => $value) {
                        $ica = new Ica();
                        $ica->code = $detail[$key]['code_ica'];
                        $ica->bank_id = $item->id;
                        $ica->status = 1;
                        $ica->type_coin_id = $detail[$key]['type_coin'];
                        $ica->user_id = Auth::user()->id;
                        $ica->register_date = now();
                        $ica->ip = \Request::ip();
                        $ica->save();
                    }
                }
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('Update');
                $result['type_message'] = 'success';
                $result['redirect'] = route('banks');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function updateIca(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'type_coin.required' => __('Type Coin Required'),
            ];
            $validator = Validator::make($request->all(), [
                'type_coin' => 'required',
            ], $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Bank');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';

                return $result;
            }
            $ica = ica::find($request->id);
            $ica->code = $request->code_ica;
            $ica->type_coin_id = $request->type_coin;
            $ica->user_id = Auth::user()->id;
            $ica->register_date = now();
            $ica->ip = \Request::ip();

            try {
                $ica->save();
                $clear = $request->id;
                $fila = '<tr id="ica_' . $request->id . '" class="text-center">' . '<td>' . $ica->type_coin . '</td>' . '<td>' . $ica->code . '</td>' . '<td><button type="button" class="btn-moderation" onClick="edit(\'' . $request->id . '\', \'' . $ica->type_coin_id . '\', \'' . $ica->code . '\')"> <i class="fa fa-pen"></i>' . __(' Edit') . '</button></td>' . '</tr>';

                $result['status'] = 1;
                $result['title'] = __('');
                $result['data'] = $fila;
                $result['clear'] = $clear;
                $result['message'] = __('Update');
                $result['type_message'] = 'success';
                $result['redirect'] = '';
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = __('Failed to register customer data, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function updateIcaBin(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'code_ica_bin.required' => __('Code Ica Required'),
            ];
            $validator = Validator::make($request->all(), [
                'code_ica_bin' => 'required',
            ], $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Bank');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';

                return $result;
            }
            $bin = IcaBin::find($request->id);
            $bin->code = $request->code_bin;
            $bin->description_bin = $request->Description_bin;
            $bin->ica_id = $request->code_ica_bin;
            $bin->user_id = Auth::user()->id;
            $bin->register_date = now();
            $bin->ip = \Request::ip();

            try {
                $bin->save();
                $clear = $request->id;
                $ica_bin = Ica::where('id', $bin->ica_id)->first();
                $fila = '<tr id="bin_' . $request->id . '" class="text-center">' . '<td>' . $ica_bin['code'] . '</td>' . '<td>' . $bin->code . '</td>' . '<td>' . $bin->description_bin . '</td>' . '<td><button type="button" class="btn-moderation" onClick="edit_bin(\'' . $request->id . '\', \'' . $bin->ica_id . '\', \'' . $bin->code . '\', \'' . $bin->description_bin . '\')"> <i class="fa fa-pen"></i>' . __(' Edit') . '</button></td>' . '</tr>';

                $result['status'] = 1;
                $result['title'] = __('');
                $result['data'] = $fila;
                $result['clear'] = $clear;
                $result['message'] = __('Update');
                $result['type_message'] = 'success';
                $result['redirect'] = '';
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = __('Failed to register customer data, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function updateIcaProcess(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'code_ica_process.required' => __('Code Ica Required'),
                'Description_process.required' => __('Code Ica Required'),
                'code_process.required' => __('Code Ica Required'),
            ];
            $validator = Validator::make($request->all(), [
                'code_ica_process' => 'required',
                'Description_process' => 'required',
                'code_process' => 'required',
            ], $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Bank');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';

                return $result;
            }
            $process = IcaIdProcess::find($request->id);
            $process->code = $request->code_process;
            $process->description_process = $request->Description_process;
            $process->ica_id = $request->code_ica_process;
            $process->user_id = Auth::user()->id;
            $process->register_date = now();
            $process->ip = \Request::ip();

            try {
                $process->save();
                $clear = $request->id;
                $ica_process = Ica::where('id', $process->ica_id)->first();
                $fila = '<tr id="bin_' . $request->id . '" class="text-center">' . '<td>' . $ica_process['code'] . '</td>' . '<td>' . $process->code . '</td>' . '<td>' . $process->description_process . '</td>' . '<td><button type="button" class="btn-moderation" onClick="edit_bin(\'' . $request->id . '\', \'' . $process->ica_id . '\', \'' . $process->code . '\', \'' . $process->description_process . '\')"> <i class="fa fa-pen"></i>' . __(' Edit') . '</button></td>' . '</tr>';

                $result['status'] = 1;
                $result['title'] = __('');
                $result['data'] = $fila;
                $result['clear'] = $clear;
                $result['message'] = __('Update');
                $result['type_message'] = 'success';
                $result['redirect'] = '';
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = __('Failed to register customer data, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function delete($id)
    {
        if (\Request::ajax()) {
            try {
                $item = Bank::find($id);
                $item->status = 0;
                $item->save();
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('desincorporation Success');
                $result['type_message'] = 'success';
                $result['redirect'] = route('banks');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = __('Failed to register customer data, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function deleteIca($id)
    {
        if (\Request::ajax()) {
            try {
                $item = Ica::find($id);
                $item->status = 0;
                $item->save();
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('desincorporation Success');
                $result['type_message'] = 'success';
                $result['redirect'] = route('banks.edit', $id);
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = __('Failed to register customer data, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function deleteBin($id)
    {
        if (\Request::ajax()) {
            try {
                $item = IcaBin::find($id);
                $item->status = 0;
                $item->save();
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('desincorporation Success');
                $result['type_message'] = 'success';
                $result['redirect'] = route('banks.icaProcess', $id);
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = __('Failed to register customer data, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function deleteProcess($id)
    {
        if (\Request::ajax()) {
            try {
                $item = IcaIdProcess::find($id);
                $item->status = 0;
                $item->save();
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('desincorporation Success');
                $result['type_message'] = 'success';
                $result['redirect'] = route('banks.icaProcess', $id);
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = __('Failed to register customer data, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function reactivate($id)
    {
        if (\Request::ajax()) {
            try {
                $item = Bank::find($id);
                $item->status = 1;
                $item->save();
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('Restored');
                $result['type_message'] = 'success';
                $result['redirect'] = route('banks');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = __('Failed to register customer data, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function reactivateIca($id)
    {
        if (\Request::ajax()) {
            try {
                $item = Ica::find($id);
                $item->status = 1;
                $item->save();
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('Restored');
                $result['type_message'] = 'success';
                $result['redirect'] = route('banks.edit', $id);
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = __('Failed to register customer data, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function reactivateBin($id)
    {
        if (\Request::ajax()) {
            try {
                $item = IcaBin::find($id);
                $item->status = 1;
                $item->save();
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('Restored');
                $result['type_message'] = 'success';
                $result['redirect'] = route('banks.icaProcess', $id);
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = __('Failed to register customer data, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function reactivateProcess($id)
    {
        if (\Request::ajax()) {
            try {
                $item = IcaIdProcess::find($id);
                $item->status = 1;
                $item->save();
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('Restored');
                $result['type_message'] = 'success';
                $result['redirect'] = route('banks.icaProcess', $id);
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = __('Failed to register customer data, contact the administrator.');
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }
}
