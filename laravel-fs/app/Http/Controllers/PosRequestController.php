<?php

namespace App\Http\Controllers;

use App\Models\Models;
use App\Models\PosRequest;
use App\Models\PosRequestDetail;
use App\Models\Storage;
use Auth;
use DB;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;
use PDF;

class PosRequestController extends Controller
{
    public function pos_request()
    {
        if (\Request::ajax()) {
            $model = Models::where('status', 1)->get();
            $models = [];
            $increments = [];
            $store_request = Storage::where('id', '!=', Auth::user()->storage_id)->pluck('name_storage', 'id');

            foreach ($model as $key => $value) {
                $models[$value->id] = $value->getTradeMark->name_trade_mark . ' ' . $value->serial;
            }

            // increments of 10 up to 500
            for ($i = 1; $i <= 50; ++$i) {
                $increments[$i * 10] = $i * 10;
            }

            $last_send = PosRequest::orderBy('id', 'desc')->get();
            $num_send = count($last_send) + 1;
            $responsible = Auth::user()->name_user . ' ' . Auth::user()->surname_user;

            return view('pos_request.pos_request', compact('models', 'num_send', 'responsible', 'store_request', 'increments'));
        }

        return Redirect::to('home');
    }

    public function pos_request_store(Request $request)
    {
        if (\Request::ajax()) {
            try {
                if (is_array($request->models)) {
                    $PosRequest = new PosRequest();
                    //  $item->number_request    =$request->request_num;
                    $PosRequest->user_id = Auth::user()->id;
                    $PosRequest->date_register = now();
                    $PosRequest->ip = \Request::ip();
                    $PosRequest->storage_id = Auth::user()->storage_id;
                    $PosRequest->storage_request_id = $request->store_hidden;
                    $PosRequest->save();

                    foreach ($request->models as $key => $value) {
                        $PosRequestDetail = new PosRequestDetail();
                        $PosRequestDetail->model_id = $value['model_id'];
                        $PosRequestDetail->quantity = $value['amount'];
                        $PosRequestDetail->pos_request_id = $PosRequest->id;

                        $PosRequestDetail->save();
                    }

                    $last_send = PosRequest::orderBy('id', 'desc')->get();
                    $num_send = count($last_send);
                    $responsible = Auth::user()->name_user . ' ' . Auth::user()->surname_user;
                    $info_mail = ['request' => $num_send, 'responsible' => $responsible, 'date' => $PosRequest->date_register, 'model' => $request->models];
                    $mail_administration = $this->getUsersByStorage($PosRequest->storage_request_id);

                    if (count($mail_administration) > 0) {
                        foreach ($mail_administration as $key => $value) {
                            $this->send_mail($value['email'], 'pos_request.request_mail', $info_mail);
                        }
                    }
                    $result['status'] = 1;
                    $result['title'] = __('');
                    $result['message'] = __('Successfully stored');
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('pos_request.containerPDF', $PosRequest->crypt_id);
                } else {
                    $result['status'] = 0;
                    $result['title'] = __('Search error');
                    $result['message'] = __('You must enter at least one model');
                    $result['type_message'] = 'error';
                    $result['redirect'] = '';
                }
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

    public function show_consult_available($store)
    {
        if (\Request::ajax()) {
            $model = Models::join('trade_marks', 'trade_marks.id', '=', 'models.trade_mark_id')
                ->join('pos_boxes', 'pos_boxes.model_id', '=', 'models.id')
                ->where('models.status', 1)
                ->where('pos_boxes.storage_id', $store)
                ->where('pos_boxes.processing', 0)
                ->select(DB::raw('concat(trade_marks.name_trade_mark, models.serial) as full_model'), DB::raw('count(pos_boxes.id) as amount_boxes'), DB::raw('sum(models.quantity) as amount_pos'))
                ->groupBy('full_model')
                ->get();

            return view('pos_request.consult_models', compact('model'));
        }

        return Redirect::to('home');
    }

    public function containerPDF($id)
    {
        if (\Request::ajax()) {
            $Request = PosRequest::find($id);

            return view('pos_request.containerPDF', compact('Request'));
        }

        return Redirect::to('home');
    }

    public function pos_request_viewPDF($id)
    {
        $Request = PosRequest::find($id)->toArray();
        //dd($Request);
        // instantiate and use the dompdf class
        //$dompdf->loadHtml('hello world');

        //$pdf->loadHtml('prueba');

        // (Optional) Setup the paper size and orientation
        // $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        // $dompdf->render();
        // $dompdf->loadview('pos_request.pos_request');
        // Output the generated PDF to Browser
        $pdf = new Dompdf();
        //$data = Models::where('status', 1)->get()->toArray();
        //  dd($data);
        // $data = [
        // 'titulo' => 'Prueba Titulo',
        // 'variable1' => 'Prueba var1',
        // 'variable2' => 'Prueba var2',
        // 'variable3' => 'Prueba var3'
        // ];
        $pdf = PDF::loadView('pos_request.pdf_view', ['data' => $Request]);

        return $pdf->stream('prueba', ['Attachment' => 0]);
    }
}

    // function pos_request_viewPDF($id) {

    //     // instantiate and use the dompdf class
    //     $pdf = new Dompdf();
    //     //$dompdf->loadHtml('hello world');

    //     //$dompdf->loadHtml('prueba');

    //     // (Optional) Setup the paper size and orientation
    //    // $dompdf->setPaper('A4', 'landscape');

    //     // Render the HTML as PDF
    //    // $dompdf->render();
    //     // Output the generated PDF to Browser

    //     $data = [
    //     'titulo' => 'Prueba Titulo',
    //     'variable1' => 'Prueba var1',
    //     'variable2' => 'Prueba var2',
    //     'variable3' => 'Prueba var3'
    //     ];

    //     $pdf = \PDF::loadView('pos_request.pdf_view')
    //             ->stream("prueba", array("Attachment" => 0));
    // }
