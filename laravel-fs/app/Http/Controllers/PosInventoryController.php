<?php

namespace App\Http\Controllers;

use App\Models\PosBoxe;
use App\Models\PosInventory;
use App\Models\PosInventoryKardex;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PosInventoryController extends Controller
{
    public function pos_adaptation()
    {
        if (\Request::ajax()) {
            return view('pos_inventory.pos_adequacy');
        }

        return Redirect::to('home');
    }

    public function pos_configuration()
    {
        if (\Request::ajax()) {
            return view('pos_inventory.pos_configuration');
        }

        return Redirect::to('home');
    }

    public function search($boxes)
    {
        if (\Request::ajax()) {
            $search = $this->get_boxes($boxes);
            // $model = PosBoxe::join('pos_inventories', 'pos_inventories.pos_box_id', '=', 'pos_boxes.id')->where('pos_boxes.processing', 0)->where('pos_inventories.adequacy', null)->whereIn('number_box', $search)->groupBy('id')->get();

            // $model =    DB::table('pos_boxes')
            //                 ->join('pos_inventories', 'pos_boxes.id', '=', 'pos_inventories.pos_box_id')
            //                 ->whereIn('pos_boxes.number_box',$search)
            //                 ->where('pos_boxes.processing', 0)
            //                 ->where('pos_inventories.adequacy', null)
            //                 ->groupBy('pos_boxes.initial_serial')
            //             ->toSql();

            $model = PosBoxe::where('processing', 0)->whereIn('number_box', $search)->get()->toArray();

            return $model;
        }

        return Redirect::to('home');
    }

    public function SearchForConfig($boxes)
    {
        if (\Request::ajax()) {
            $search = $this->get_boxes($boxes);
            $model = PosBoxe::join('pos_inventories', 'pos_inventories.pos_box_id', '=', 'pos_boxes.id')->whereNotNull('pos_inventories.adequacy')->whereIn('number_box', $search)->get()->toArray();

            return $model;
        }

        return Redirect::to('home');
    }

    public function serial_search($id)
    {
        if (\Request::ajax()) {
            $model = PosInventory::where('id', $id)->first()->toArray();
            if (count($model) > 0) {
                $result['status'] = 1;
                $result['data'] = $model;
            } else {
                $result['status'] = 0;
                $result['title'] = __('POS Adequacy');
                $result['message'] = __('Serial not found');
                $result['type_message'] = 'info';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function get_pos($serial)
    {
        if (\Request::ajax()) {
            $model = PosInventory::where('assigned', false)->where('serial', $serial)->first();

            return $model == null ? [] : $model;
        }

        return Redirect::to('home');
    }

    public function show_serial($serial)
    {
        if (\Request::ajax()) {
            $model = PosInventory::where('serial', 'like', '%' . $serial . '%')->get()->toArray();

            $array_serial = [];
            foreach ($model as $key => $value) {
                $array_serial[$key]['id'] = $value['crypt_id'];
                $array_serial[$key]['label'] = $value['model_serial'];
                $array_serial[$key]['model'] = $value['model'];
                $array_serial[$key]['value'] = $value['model_serial'];
            }

            return $array_serial;
        }

        return Redirect::to('home');
    }

    public function store(Request $request)
    {
        if (\Request::ajax()) {
            try {
                if (is_array($request->boxes)) {
                    foreach ($request->boxes as $key => $value) {
                        $messages = [
                            'adequacy.required' => __('Adequacy is Required'),
                            'adequacy.in' => __('Format Incorrect'),
                        ];
                        $validator = Validator::make($value, [
                            'adequacy' => 'required|in:0,1',
                        ], $messages);

                        if ($validator->fails()) {
                            $result['status'] = 0;
                            $result['title'] = __('POS Adequacy');
                            $result['message'] = '';
                            foreach ($validator->errors()->all() as $key => $value) {
                                $result['message'] .= $value . '<br/>';
                            }
                            $result['data'] = null;
                            $result['type_message'] = 'error';
                            $result['redirect'] = '';

                            return $result;
                        }

                        DB::table('pos_inventories')->where('pos_box_id', $value['id'])->update(['adequacy' => (int) $value['adequacy']]);
                        $inventory = PosInventory::where('pos_box_id', $value['id'])->get()->toArray();
                        foreach ($inventory as $value2) {
                            DB::table('pos_inventory_kardexes')->where('pos_inventory_id', $value2['id'])->whereNull('date_until')->update(['date_until' => now()]);
                        }
                        $kardex = new PosInventoryKardex();
                        $kardex->pos_inventory_id = $value['id'];
                        $kardex->actions = __('POS Adecuado'); // this is the second register on table "actions"
                        $kardex->date_from = now();
                        $kardex->save();
                    }
                    $result['status'] = 1;
                    $result['title'] = __('POS Adequacy');
                    $result['message'] = __('Stored');
                    $result['type_message'] = 'success';
                    $result['redirect'] = '';
                } else {
                    $result['status'] = 0;
                    $result['title'] = __('POS Adequacy');
                    $result['message'] = __('You must add at least one POS');
                    $result['type_message'] = 'info';
                    $result['redirect'] = '';
                }
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('POS Adequacy');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function detailed_store(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'serial.required' => __('Serial is Required'),
                'serial.min' => __('Minimum length of unsupported serial values'),
                'serial.max' => __('Maximum length of unsupported serial values'),
                'adequacy.required' => __('Adequacy is Required'),
            ];
            $validator = Validator::make($request->all(), [
                'serial' => 'required|min:6|max:10',
                'adequacy' => 'required',
            ], $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('POS Adequacy');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = '';

                return $result;
            }

            try {
                $item = PosInventory::find($request->id);
                if ($item != null) {
                    $item->adequacy = isset($request->adequacy[null]) ? 1 : 0;
                    $item->observations = $request->observations;
                    $item->save();

                    $result['status'] = 1;
                    $result['title'] = __('POS Adequacy');
                    $result['message'] = __('Stored');
                    $result['type_message'] = 'success';
                    $result['redirect'] = '';
                } else {
                    $result['status'] = 0;
                    $result['title'] = __('POS Adequacy');
                    $result['message'] = __('Serial not found');
                    $result['type_message'] = 'error';
                    $result['redirect'] = '';
                }
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('POS Adequacy');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function configured_store(Request $request)
    {
        if (\Request::ajax()) {
            try {
                if (is_array($request->boxes)) {
                    foreach ($request->boxes as $key => $value) {
                        $messages = [
                            'configured.required' => __('Configured is Required'),
                            'configured.in' => __('Format Incorrect'),
                        ];
                        $validator = Validator::make($value, [
                            'configured' => 'required|in:0,1',
                        ], $messages);

                        if ($validator->fails()) {
                            $result['status'] = 0;
                            $result['title'] = __('POS Configuration');
                            $result['message'] = '';
                            foreach ($validator->errors()->all() as $key => $value) {
                                $result['message'] .= $value . '<br/>';
                            }
                            $result['data'] = null;
                            $result['type_message'] = 'error';
                            $result['redirect'] = '';

                            return $result;
                        }
                        DB::table('pos_inventories')->where('pos_box_id', $value['id'])->update(['configured' => (int) $value['configured']]);
                        $inventory = PosInventory::where('pos_box_id', $value['id'])->get()->toArray();
                        foreach ($inventory as $value2) {
                            DB::table('pos_inventory_kardexes')->where('pos_inventory_id', $value2['id'])->whereNull('date_until')->update(['date_until' => now()]);
                        }
                        $kardex = new PosInventoryKardex();
                        $kardex->pos_inventory_id = $value['id'];
                        $kardex->actions = __('POS Configurado'); // this is the thirb register on table "actions"
                        $kardex->date_from = now();
                        $kardex->save();
                    }
                    $result['status'] = 1;
                    $result['title'] = __('POS Configuration');
                    $result['message'] = __('Stored');
                    $result['type_message'] = 'success';
                    $result['redirect'] = '';
                } else {
                    $result['status'] = 0;
                    $result['title'] = __('POS Configuration');
                    $result['message'] = __('You must add at least one POS');
                    $result['type_message'] = 'info';
                    $result['redirect'] = '';
                }
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('POS Configuration');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }
}
