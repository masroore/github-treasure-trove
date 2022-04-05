<?php

namespace App\Http\Controllers;

use App\Models\Models;
use App\Models\PosBoxe;
use App\Models\PosInventory;
use App\Models\PosInventoryKardex;
use App\Models\PosRequest;
use App\Models\PosShipment;
use App\Models\PosShipmentDetail;
use App\Models\Storage;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDF;

class PosShipmentController extends Controller
{
    public function pos_send_request()
    {
        if (\Request::ajax()) {
            $PosRequest = PosRequest::join('pos_request_details', 'pos_request_details.pos_request_id', '=', 'pos_requests.id')
                ->whereIn('pos_requests.storage_request_id', Auth::user()->list_storage_id)
                ->select('pos_requests.id', DB::raw('sum(distinct(pos_request_details.quantity)) AS cant'))
                ->groupBy('pos_requests.id')
                ->get()
                    //->toArray()
;
            $pos_request = [];
            foreach ($PosRequest as $key => $value) {
                $PosShipment = PosShipment::join('pos_shipment_details', 'pos_shipment_details.pos_shipments_id', '=', 'pos_shipments.id')
                    ->join('pos_boxes', 'pos_boxes.id', '=', 'pos_shipment_details.pos_boxes_id')
                    ->join('models', 'models.id', '=', 'pos_boxes.model_id')
                    ->where('pos_shipments.pos_request_id', $value->id)
                    ->select(DB::raw('sum(models.quantity) AS cant'))
                    ->first()
                                //->toArray()
;
                if ($PosShipment->cant >= $value->cant) {
                    unset($PosRequest[$key]);
                } else {
                    $pos_request[$value->id] = $this->FullSerial($value->id);
                }
            }

            $last_send = PosShipment::orderBy('id', 'desc')->get();
            $nro_send = count($last_send) + 1;

            $respond = Auth::user()->name_user . ' ' . Auth::user()->surname_user;

            return view('pos_shipments.send_pos', compact('pos_request', 'nro_send', 'respond'));
        }

        return Redirect::to('home');
    }

    public function show_consult_available()
    {
        if (\Request::ajax()) {
            $models = Models::get();
            //dd($models);
            return view('pos_shipments.consult_models', compact('models'));
        }

        return Redirect::to('home');
    }

    public function pos_reception()
    {
        if (\Request::ajax()) {
            $num_request = PosRequest::join('pos_shipments', 'pos_shipments.pos_request_id', 'pos_requests.id')
                ->join('pos_shipment_details', 'pos_shipment_details.pos_shipments_id', 'pos_shipments.id')
                ->select('pos_requests.id')
                ->whereIn('storage_id', Auth::user()->list_storage_id)
                ->whereNull('pos_shipment_details.recived')
                ->groupBy('pos_requests.id')
                ->get()
            //->pluck('pos_requests.id')
            //->toSql()
;
            $num_request2 = [];
            foreach ($num_request as $key => $value) {
                $num_request2[$value->id] = $this->FullSerial($value->id);
            }
            //dd($num_request2);
            $responsible = Auth::user()->name_user . ' ' . Auth::user()->surname_user;

            return view('pos_shipments.reception_pos', compact('num_request2', 'responsible'));
        }

        return Redirect::to('home');
    }

    public function search($num_request)
    {
        if (\Request::ajax()) {
            $model = PosRequest::find($num_request)->toArray();
            if (count($model['details']) > 0) {
                $model2 = PosShipment::join('pos_shipment_details', 'pos_shipment_details.pos_shipments_id', '=', 'pos_shipments.id')
                    ->whereNull('pos_shipment_details.recived')
                    ->where('pos_request_id', $num_request)
                    ->select('pos_shipments.id')
                    ->where('pos_shipment_details.recived')
                    ->groupBy('pos_shipments.id')
                    ->get();
                $model3 = [];
                foreach ($model2 as $key => $value) {
                    $model3[$value->id] = $this->FullSerial($value->id);
                }
                $result['status'] = 1;
                $result['data'] = $model['details'];
                $result['number_send'] = $model3;
                $result['redirect'] = '';
                $result['redirect'] = '';
            } else {
                $result['status'] = 0;
                $result['title'] = __('POS Reception');
                $result['message'] = __('No data found');
                $result['type_message'] = 'info';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function shipment_search($shipment)
    {
        if (\Request::ajax()) {
            $result['status'] = 1;
            $result['data'] = PosShipment::find($shipment)->toArray();
            $result['redirect'] = '';

            return $result;
        }

        return Redirect::to('home');
    }

    public function store(Request $request)
    {
        if (\Request::ajax()) {
            try {
                if (is_array($request->boxes)) {
                    $name_storage = Storage::where('id', Auth::user()->storage_id)->pluck('name_storage');
                    foreach ($request->boxes as $key => $value) {
                        DB::table('pos_shipment_details')->where('pos_boxes_id', $value['id'])->update(['recived' => $value['recived']]);
                        DB::table('pos_boxes')->where('id', $value['id'])->where('model_id', $value['model'])->update(['storage_id' => Auth::user()->storage_id, 'processing' => 0]);

                        $box = PosBoxe::where('id', $value['id'])->first();
                        $pos_update_storage = PosInventory::where('pos_box_id', $box['id'])->get();

                        foreach ($pos_update_storage as $key => $value) {
                            DB::table('pos_inventories')->where('id', $pos_update_storage[$key]['id'])->update(['storage_id' => Auth::user()->storage_id]);
                            $pos_karden_date_update = PosInventoryKardex::where('pos_inventory_id', $pos_update_storage[$key]['id'])->update(['date_until' => now()]);
                            $pos_karden_date_create = new PosInventoryKardex();
                            $pos_karden_date_create->pos_inventory_id = $pos_update_storage[$key]['id'];
                            $pos_karden_date_create->actions = __('Entrada a almacen ' . $name_storage); // this is the first register on table "actions"
                            $pos_karden_date_create->date_from = now();
                            $pos_karden_date_create->save();
                        }
                    }
                    DB::table('pos_shipments')->where('id', $request->num_send)->update(['totally_received' => 1]);

                    $PosShipment = PosShipment::where('pos_request_id', $request->num_petition)->get()->toArray();
                    $Shipment = [];
                    foreach ($PosShipment as $key => $value) {
                        foreach ($value['detail_shipment'] as $value2) {
                            if (isset($Shipment[$value2['boxes']['model_id']])) {
                                $Shipment[$value2['boxes']['model_id']] += $value2['boxes']['quantity_pos'];
                            } else {
                                $Shipment[$value2['boxes']['model_id']] = $value2['boxes']['quantity_pos'];
                            }
                        }
                    }
                    $Request = [];
                    $PosRequest = PosRequest::find($request->num_petition)->toArray()['details'];
                    $sum = 0;
                    foreach ($PosRequest as $value) {
                        $Request[$value['model_id']] = $value['quantity'];
                        if (isset($Shipment[$value['model_id']])) {
                            $Request[$value['model_id']] -= $Shipment[$value['model_id']];
                        }
                        $sum += $Request[$value['model_id']];
                    }
                    if ($sum == 0) {
                        DB::table('pos_requests')->where('id', $request->num_petition)->update(['totally_delivered' => 1]);
                    }

                    $result['status'] = 1;
                    $result['title'] = __('POS Reception');
                    $result['message'] = __('Successfully Stored');
                    $result['type_message'] = 'success';
                    $result['redirect'] = '';
                } else {
                    $result['status'] = 0;
                    $result['title'] = __('POS Reception');
                    $result['message'] = __('You must check at least one shipping');
                    $result['type_message'] = 'info';
                    $result['redirect'] = '';
                }
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('POS Reception');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function list_requested_data($pos_request)
    {
        if (\Request::ajax()) {
            try {
                $list_data = PosRequest::find($pos_request)->toArray();
                $array_pos = [];
                foreach ($list_data['details'] as $key => $value) {
                    $array_pos[$key]['model_id'] = $value['model_id'];
                    $array_pos[$key]['model_request'] = $value['model'];
                    $array_pos[$key]['quantity_request'] = $value['quantity'];

                    $quantitySend = PosShipment::join('pos_shipment_details', 'pos_shipment_details.pos_shipments_id', '=', 'pos_shipments.id')
                        ->join('pos_boxes', 'pos_boxes.id', '=', 'pos_shipment_details.pos_boxes_id')
                        ->join('models', 'models.id', '=', 'pos_boxes.model_id')
                        ->where('pos_shipments.pos_request_id', $pos_request)
                        ->where('pos_boxes.model_id', $value['model_id'])
                        ->sum('models.quantity');
                    //->get()->toArray();

                    //$total_send = PosBoxe::where('model_id',$value['model_id'])->where('processing', 1)->count();

                    $total_send = $quantitySend;
                    $array_pos[$key]['quantity_send'] = $total_send;
                }

                $result['status'] = 1;
                $result['data'] = $array_pos;
                $result['redirect'] = '';
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('POS Shipment');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function searchBox(Request $request)
    {
        if (\Request::ajax()) {
            try {
                $search = $this->get_boxes($request->nro_box);
                $model = PosBoxe::where('processing', 0)->whereIn('number_box', $search)->where('model_id', $request->model)->get()->toArray();
                if (count($model) === 0) {
                    $result['status'] = 2;
                    $result['message'] = __('Caja de Modelo Especificado no encontrado');
                }
                $result['status'] = 1;
                $result['data'] = $model;
                $result['redirect'] = '';
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('POS Shipment');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function registerShipmentPos(Request $request)
    {
        //dd($request->all());
        if (\Request::ajax()) {
            //try{
            if (is_array($request->nro_box)) {
                $PosShipment = new PosShipment();

                $PosShipment->pos_request_id = $request->nro_petition;
                $PosShipment->user_id = Auth::user()->id;
                $PosShipment->date_register = now();
                $PosShipment->ip = \Request::ip();
                $PosShipment->save();

                $Shipments_id = $PosShipment->id;
                $Shipments_cryp = $PosShipment->crypt_id;

                foreach ($request->nro_box as $value) {
                    $PosShipmentDetail = new PosShipmentDetail();
                    $PosShipmentDetail->pos_shipments_id = $Shipments_id;
                    //$PosShipmentDetail->recived          = 0;
                    $PosShipmentDetail->pos_boxes_id = $value['id'];
                    $PosShipmentDetail->save();

                    $PosBoxe = PosBoxe::find($value['id']);
                    $PosBoxe->processing = 1;
                    $PosBoxe->save();
                }

                $result['status'] = 1;
                $result['title'] = __('POS Shipment');
                $result['message'] = __('Successfully Stored');
                $result['type_message'] = 'success';
                $result['redirect'] = route('pos_send_request.shipmentContainerPDF', $Shipments_cryp);
            } else {
                $result['status'] = 0;
                $result['title'] = __('POS Shipment');
                $result['message'] = __('You must check at least one shipping');
                $result['type_message'] = 'info';
                $result['redirect'] = '';
            }
            /*} catch (Exception $e) {
                $result['status']       = 0;
                $result['title']        = __('POS Shipment');
                $result['message']      = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect']     = '';
            }*/
            return $result;
        }

        return Redirect::to('home');
    }

    public function containerPDF($id)
    {
        if (\Request::ajax()) {
            $Request = PosShipment::find($id);

            return view('pos_shipments.shipmentContainerPDF', compact('Request'));
        }

        return Redirect::to('home');
    }

    public function pos_send_viewPDF($id)
    {
        $Request = PosShipment::find($id);
        $boxes = [];
        $array_pdf = [];
        $array_quantity = [];
        $array_pdf['name_storage'] = $Request->pos_request->storage_name;
        $array_pdf['name_storage_request'] = $Request->pos_request->storage_request_name;
        $array_pdf['name_user'] = $Request->pos_request->user_name;
        $array_pdf['date_register'] = $Request->date_register;
        $array_pdf['delivery_number'] = $Request->id;
        foreach ($Request->pos_request->details as $key => $value) {
            $array_quantity[$key]['model_request'] = $value->model;
            $array_quantity[$key]['quantity_request'] = $value->quantity;

            $quantitySend = PosShipment::join('pos_shipment_details', 'pos_shipment_details.pos_shipments_id', '=', 'pos_shipments.id')
                ->join('pos_boxes', 'pos_boxes.id', '=', 'pos_shipment_details.pos_boxes_id')
                ->join('models', 'models.id', '=', 'pos_boxes.model_id')
                ->where('pos_shipments.id', $id)
                                        //->where('pos_shipments.pos_request_id', $Request->pos_request_id)
                ->where('pos_boxes.model_id', $value->model_id)
                ->sum('models.quantity');

            //$total_send = PosBoxe::where('model_id',$value['model_id'])->where('processing', 1)->count();
            $total_send = $quantitySend;
            $array_quantity[$key]['quantity_send'] = $total_send;
        }
        $array_pdf['quantity'] = $array_quantity;
        foreach ($Request->detail_shipment as $value) {
            $pos = PosInventory::where('pos_box_id', $value->pos_boxes_id)->get()->toArray();
            $boxes[$value->boxes->model][] = $pos;
        }
        $pdf = new Dompdf();
        $pdf = PDF::loadView('pos_shipments.shipmentPDF', ['data' => $array_pdf], ['boxes' => $boxes]);

        return $pdf->stream('prueba', ['Attachment' => 0]);
    }
}
