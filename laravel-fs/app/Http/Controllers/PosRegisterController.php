<?php

namespace App\Http\Controllers;

use App\Helpers\Encryptor;
use App\Models\Models;
use App\Models\PosBoxe;
use App\Models\PosInventory;
use App\Models\PosInventoryKardex;
use App\Models\PosRegister;
use App\Models\Provider;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Validator;

class PosRegisterController extends Controller
{
    public function pos_register2()
    {
        if (\Request::ajax()) {
            $provider = Provider::pluck('name_provider', 'id');

            return view('pos_register.pos_register2', compact('provider'));
        }

        return Redirect::to('home');
    }

    public function pos_register_store2(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'provider.required' => __('Provider Required'),
                'invoice_number.required' => __('Invoice number Required'),
            ];

            $validator = Validator::make($request->all(), [
                'provider' => 'required',
                'invoice_number' => 'required',
            ], $messages);
            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('POS Register');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';

                return $result;
            }
            $PosRegister = new PosRegister();
            $PosRegister->provider_id = $request->provider;
            $PosRegister->number_control = $request->invoice_number;
            $PosRegister->user_id = Auth::user()->id;
            $PosRegister->date_register = now();
            $PosRegister->ip = \Request::ip();
            $PosBoxe->storage_id = Auth::User()->storage_id;
            $PosRegister->save();

            $result['status'] = 1;
            $result['title'] = __('POS Register');
            $result['message'] = 'Ok';

            $result['data'] = null;
            $result['type_message'] = 'success';
            $result['redirect'] = route('pos_register.store_detail', $PosRegister->crypt_id);

            return $result;
        }

        return Redirect::to('home');
    }

    public function store_detail(Request $request, $id)
    {
        $models = Models::where('status', 1)->pluck('serial', 'id');

        if ($request->isMethod('post')) {
            dd($request->all());
            $boxs = [];
            $serials = [];
            $model = Models::find($request->model_id);
            $sum = 0;
            for ($i = 0; $i < $request->amo_box; ++$i) {
                $boxs[] = $request->num_box + $i;

                for ($j = 0; $j < $model->quantity; ++$j) {
                    $serials[] = (int) $model->serial . $this->FullSerial($request->ini_serial + $sum);
                    ++$sum;
                }
            }

            $is_boxs = PosBoxe::where('model_id', $request->model_id)->whereIn('number_box', $boxs)->count();
            $is_serials = PosInventory::whereIn('serial', $serials)->count();

            if ($is_boxs == 0 && $is_serials == 0) {
                foreach ($boxs as $value) {
                    $PosBoxe = new PosBoxe();
                    $PosBoxe->number_box = $value;
                    $PosBoxe->model_id = $request->model_id;
                    $PosBoxe->initial_serial = $model->serial . $this->FullSerial($boxes[$key]->initial_serial, 6);
                    $PosBoxe->number_lot = $boxes[$key]->number_lot;
                    $PosBoxe->pos_register_id = $id_provider;
                    $PosBoxe->storage_id = Auth::User()->storage_id;
                    $PosBoxe->save();
                }
            }

        }

        $PosRegister = PosRegister::find(Encryptor::decrypt($id))->toArray();
        //dd($PosRegister);
        return view('pos_register.store_detail', compact('PosRegister', 'models'));
    }

    public function pos_register()
    {
        if (\Request::ajax()) {
            $provider = Provider::pluck('name_provider', 'id');
            $model = Models::where('status', 1)->get();
            $models = [];
            $models_quantity = [];
            $worksheet = [];
            $statistics = [];
            foreach ($model as $key => $value) {
                $models[$value->id] = $value->getTradeMark->name_trade_mark . ' ' . $value->serial;
                $models_quantity[$value->id] = ['data-quantity' => $value->quantity, 'data-serial' => $value->serial];
            }
            $boxe = PosBoxe::pluck('number_box', 'initial_serial', 'number_lot');

            return view('pos_register.pos_register', compact('provider', 'models', 'boxe', 'models_quantity', 'worksheet', 'statistics'));
        }

        return Redirect::to('home');
    }

    public function pos_register_store(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'provider.required' => __('Provider Required'),
                'invoice_number.required' => __('Invoice number Required'),
            ];

            $validator = Validator::make($request->all(), [
                'provider' => 'required',
                'invoice_number' => 'required',
            ], $messages);
            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('POS Register');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';

                return $result;
            }

            try {
                $boxes = json_decode($request->boxes);
                $oldPostRegister = PosRegister::where('provider_id', '=', $request->provider)->where('number_control', '=', $request->invoice_number)->count();
                if ($oldPostRegister == 0) {

                        // $bxs  = [];
                    // $seri = [];
                    // foreach($boxes as $value) {

                    //     $model       = Models::find($value->model_id);

                    //     $bxs[$value->model_id][]=$value->number_box;

                    //     for ($i=0; $i < $model->quantity ; $i++) {
                    //         $seri[]=$model->serial.$this->FullSerial($value->initial_serial + $i,6);
                    //     }
                    // }

                    // $oldPostBoxe = PosBoxe::where('number_box','=',$boxes[$key]->number_box)->where('model_id','=',$boxes[$key]->model_id)->where('initial_serial', '=',$model->serial.$this->FullSerial($boxes[$key]->initial_serial,6))->count();

                    // dd($bxs);

                    foreach ($boxes as $value) {
                        $model_validate = Models::find($value->model_id);

                        $oldPostBoxe = PosBoxe::where('number_box', '=', $value->number_box)->where('model_id', '=', $value->model_id)->where('initial_serial', '=', $model_validate->serial . $this->FullSerial($value->initial_serial, 6))->count();

                        for ($i = 0; $i < $model_validate->quantity; ++$i) {
                            $oldPosInventory = PosInventory::where('serial', $model_validate->serial . $this->FullSerial($value->initial_serial + $i, 6))->count();
                        }
                    }
                    if ($oldPostBoxe == 0 && $oldPosInventory == 0) {
                        $PosRegister = new PosRegister();
                        $PosRegister->provider_id = $request->provider;
                        $PosRegister->number_control = $request->invoice_number;
                        $PosRegister->user_id = Auth::user()->id;
                        $PosRegister->date_register = now();
                        $PosRegister->ip = \Request::ip();

                        $PosRegister->save();

                        $id_provider = $PosRegister->id;

                        foreach ($boxes as $value) {
                            $model = Models::find($value->model_id);

                            $PosBoxe = new PosBoxe();
                            $PosBoxe->number_box = $value->number_box;
                            $PosBoxe->model_id = $value->model_id;
                            $PosBoxe->initial_serial = $model->serial . $this->FullSerial($value->initial_serial, 6);
                            $PosBoxe->number_lot = $value->number_lot;
                            $PosBoxe->pos_register_id = $id_provider;
                            $PosBoxe->storage_id = Auth::User()->storage_id;

                            $PosBoxe->save();

                            for ($i = 0; $i < $model->quantity; ++$i) {
                                $PosInventory = new PosInventory();
                                $PosInventory->pos_box_id = $PosBoxe['id'];
                                $PosInventory->serial = $model->serial . $this->FullSerial($value->initial_serial + $i, 6);
                                $PosInventory->user_id = Auth::user()->id;
                                $PosInventory->date_register = now();
                                $PosInventory->ip = \Request::ip();
                                $PosInventory->storage_id = Auth::User()->storage_id;
                                $PosInventory->save();

                                $kardex = new PosInventoryKardex();
                                $kardex->pos_inventory_id = $PosInventory->id;
                                $kardex->actions = __('Entrada a inventario Principal'); // this is the first register on table "actions"
                                $kardex->date_from = now();
                                $kardex->save();
                            }
                        }

                        $result['status'] = 1;
                        $result['title'] = __('');
                        $result['message'] = __('Successfully stored');
                        $result['type_message'] = 'success';
                        $result['redirect'] = route('pos_register');
                    } else {
                        $result['status'] = 0;
                        $result['title'] = __('');
                        $result['message'] = __('Box Number or Pos Serial Already Exists');
                        $result['type_message'] = 'error';
                        $result['redirect'] = '';
                    }
                } else {
                    $result['status'] = 0;
                    $result['title'] = __('');
                    $result['message'] = __('Invoice number already exists for this provider');
                    $result['type_message'] = 'error';
                    $result['redirect'] = '';
                }
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search Error');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function save_excel(Request $request)
    {
        //dd($request->all());
        $messages = [
            //'excel.required'               => __('excel requerido'),
        ];
        $validator = Validator::make($request->all(), [
            // 'excel'            => 'required',
        ], $messages);

        if ($validator->fails()) {
            $result['status'] = 0;
            $result['title'] = __('Excel file upload');
            $result['message'] = '';
            foreach ($validator->errors()->all() as $key => $value) {
                $result['message'] .= $value . '<br/>';
            }
            $result['data'] = null;
            $result['type_message'] = 'error';

            return $result;
        }

        try {
            $inputFileName = $request->add_excel;

            $folder_name = $inputFileName->getClientOriginalName();

            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);

            $spreadsheet = $reader->load($inputFileName);

            $worksheet = $spreadsheet->getActiveSheet()->toArray();

            // $request->file('excel')->storeAs('public/Pos_register_excel', date("Y_m_d_H_i_s").'_'.$folder_name);

          //dd($worksheet);
        } catch (Exception $e) {
            $result['status'] = 0;
            $result['title'] = __('Excel file upload');
            $result['message'] = $e->getMessage();
            $result['data'] = null;
            $result['type_message'] = 'error';

            return $result;
        }

        // return view('pos_register.pos_register', compact('worksheet'));
        $before = 0;
        $data = [];
        //dd($worksheet);
        foreach ($worksheet as $key => $value) {
            if ($key != 0) {
                $data[$key][0] = $value[0];
                $m_act = (int) ($value[0] / 1000000);
                if ($key == 1) {
                    $m_prev = $m_act;
                } else {
                    $m_prev = (int) ($worksheet[$key - 1][0] / 1000000);
                }

                if ($value[1] == null && $m_act == $m_prev) {
                    $data[$key][1] = $before;
                } else {
                    $data[$key][1] = $value[1];
                    $before = $value[1];
                }
            }
        }
        //dd($data);

        $statistics = [];
        $list_models = [];
        foreach ($data as $key => $value) {
            $model = (int) ($value[0] / 1000000);
            $list_models[] = $model;
            if (isset($statistics[$model][$value[1]])) {
                ++$statistics[$model][$value[1]];
            } else {
                $statistics[$model][$value[1]] = 1;
            }
        }

        $Models = Models::whereIn('serial', $list_models)->pluck('serial');
        //dd($Models);

        //dd($statistics);
        return response()->json(['statistics' => $statistics, 'models_good' => $Models]);
    }

    public function pos_register_edit(Request $request)
    {
        if (\Request::ajax()) {
            $models = Models::where('status', $this->statusAvailable)->get()->pluck('name_model', 'id')->toArray();

            return view('pos_register.pos_register_edit', compact('models'));
        }

        return Redirect::to('home');
    }

    public function consult_boxes_search(Request $request)
    {
        $messages = [
            'model.required' => __('The model Is required'),
            'num_box.required' => __('The box number is required'),
        ];
        $validator = Validator::make($request->all(), [
            'model' => 'required',
            'num_box' => 'required',
        ], $messages);

        if ($validator->fails()) {
            $result['status'] = 0;
            $result['message'] = '';
            foreach ($validator->errors()->all() as $key => $value) {
                $result['message'] .= $value . '<br/>';
            }
            $result['data'] = null;
            $result['type_message'] = 'error';
        } else {
            $searchBox = $this->get_boxes($request->num_box);

            $model = PosBoxe::where('model_id', $request->model)
                ->where('storage_id', '=', 1)
                ->where('processing', '=', 0)
                ->whereIn('number_box', $searchBox)
                ->get()->toArray();
            if (count($model) > 0) {
                $result['message'] = __('Data Found');
                $result['status'] = 1;
                $result['data'] = $model;
                $result['type_message'] = 'success';
            } else {
                $result['message'] = __('Data no found');
                $result['status'] = 0;
                $result['data'] = $model;
                $result['type_message'] = 'error';
            }
        }

        return $result;
    }

    public function updateRegisterBoxes($id)
    {
        if (\Request::ajax()) {
            $PosInventory = PosInventory::where('pos_box_id', $id)->select('id')->get();
            foreach ($PosInventory as $value) {
                $Kardex = PosInventoryKardex::where('pos_inventory_id', $value->id)->delete();
            }
            PosInventory::where('pos_box_id', $id)->delete();
            PosBoxe::find($id)->delete();

            $result['status'] = 1;
            $result['title'] = __('Update Register Pos');
            $result['message'] = __('Stored');
            $result['type_message'] = 'success';

            return $result;
        }

        return Redirect::to('home');
    }

    public function clearAll(Request $request)
    {
        foreach ($request->ids as $value) {
            $this->updateRegisterBoxes(Encryptor::decrypt($value));
        }
        $result['status'] = 1;
        $result['title'] = __('Update Register Pos');
        $result['message'] = __('Stored');
        $result['type_message'] = 'success';

        return $result;
    }
}
