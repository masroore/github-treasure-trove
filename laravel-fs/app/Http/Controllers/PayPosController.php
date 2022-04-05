<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientPos;
use App\Models\PayMethod;
use App\Models\PayPos;
use App\Models\TypeDocument;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Validator;

class PayPosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Request::ajax()) {
            $type_document = TypeDocument::pluck('abbreviation', 'id');

            return view('pay_pos.pay_pos_index', compact('type_document'));
        }

        return Redirect::to('home');
    }

    /**
     * search client exist.
     */
    public function search_client(Request $request)
    {
        if (\Request::ajax()) {
            $code_account = [];
            $client_pos = [];
            $client_pos_model = [];
            $client_pos_exonerate = [];
            $client_pos_price = [];
            $sum = [];
            if ($request->check == 1) {
                $validator = Validator::make($request->all(), [
                    'code' => 'required',
                ]);
                if ($validator->fails()) {
                    $result['status'] = 0;
                    $result['title'] = __('');
                    $result['message'] = __('Wrong Data');
                    $result['type_message'] = 'error';
                } else {
                    $client = $this->getClient($request->code);
                    if ($client == null) {
                        $result['status'] = 0;
                        $result['type_message'] = 'error';
                        $result['message'] = __('No data found');

                        return $result;
                    }
                    $cta = $client->code_accounts->toArray();
                    $pos_pay = [];
                    foreach ($cta as $value1) {
                        foreach ($value1['client_pos'] as $key2 => $value2) {
                            $pos_pay[$key2]['price'] = (int) $value2['price'];
                            $pos_pay[$key2]['pagado'] = 0;
                            foreach ($value2['pay_pos'] as $value3) {
                                $pos_pay[$key2]['pagado'] += $value3['amount'];
                            }
                            $pos_pay[$key2]['deu'] = $pos_pay[$key2]['price'] - $pos_pay[$key2]['pagado'];
                        }
                    }
                    foreach ($client->code_accounts[0]->client_pos as $key1 => $value1) {
                        $client_pos_model[$key1] = $value1->pos_model;
                        $client_pos_exonerate[$key1] = $value1->exonerate;
                        if ($client_pos_exonerate[$key1] == 1) {
                            $client_pos_exonerate[$key1] = 'SI';
                        } else {
                            $client_pos_exonerate[$key1] = 'NO';
                        }
                        $client_pos_price[$key1] = $value1->price;
                    }

                    $result['status'] = 1;
                    $result['type_message'] = 'success';
                    $result['rif'] = $client->rif;
                    $result['name_client'] = $client->name_client;
                    $result['client_pos'] = $client['code_accounts'][0]['client_pos'];
                    $result['client_pos_model'] = $client_pos_model;
                    $result['client_pos_exonerate'] = $client_pos_exonerate;
                    $result['client_pos_price'] = $client_pos_price;
                    $result['pos_pay'] = $pos_pay;
                    $result['message'] = __('Data Found');
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'type_document' => 'required',
                    'document' => 'required',
                ]);
                if ($validator->fails()) {
                    $result['status'] = 0;
                    $result['title'] = __('');
                    $result['message'] = __('No data found');
                    $result['type_message'] = 'error';
                    $result['redirect'] = '';
                } else {
                    $client = $this->getClientBank($request->type_document, $request->document);
                    $client_rif = [];
                    $client_name = [];
                    $clients_pos = [];
                    if ($client == null) {
                        $result['status'] = 0;
                        $result['type_message'] = 'error';
                        $result['message'] = __('No data found');

                        return $result;
                    }
                    foreach ($client as $key => $value) {
                        $client_rif = $value->rif;
                        $client_name = $value->name_client;
                        $pos_pay = [];
                        $cta2 = $client[$key]->code_accounts->toArray();
                        foreach ($cta2 as $value2) {
                            foreach ($value2['client_pos'] as $key2 => $value3) {
                                $pos_pay[$key2]['price'] = (int) $value3['price'];
                                $pos_pay[$key2]['pagado'] = 0;
                                foreach ($value3['pay_pos'] as $value4) {
                                    $pos_pay[$key2]['pagado'] += $value4['amount'];
                                }
                                $pos_pay[$key2]['deu'] = $pos_pay[$key2]['price'] - $pos_pay[$key2]['pagado'];
                            }
                        }
                        foreach ($client[$key]->code_accounts[0]->client_pos as $key1 => $value1) {
                            $client_pos_model[$key1] = $value1->pos_model;
                            $client_pos_exonerate[$key1] = $value1->exonerate;
                            if ($client_pos_exonerate[$key1] == 1) {
                                $client_pos_exonerate[$key1] = 'SI';
                            } else {
                                $client_pos_exonerate[$key1] = 'NO';
                            }
                            $client_pos_price[$key1] = $value1->price;
                        }
                    }
                    $result['status'] = 1;
                    $result['rif'] = $client_rif;
                    $result['type_message'] = 'success';
                    $result['name_client'] = $client_name;
                    $result['client_pos'] = $client[$key]->code_accounts[0]->client_pos;
                    $result['client_pos_model'] = $client_pos_model;
                    $result['client_pos_exonerate'] = $client_pos_exonerate;
                    $result['client_pos_price'] = $client_pos_price;
                    $result['pos_pay'] = $pos_pay;
                    $result['message'] = __('Data Found');
                }
            }

            return $result;
        }

        return Redirect::to('home');
    }

    /**
     * search pay client.
     */
    public function search_pay($id)
    {
        if (\Request::ajax()) {
            $search_client_pos = ClientPos::find($id);
            $amount = 0;
            foreach ($search_client_pos->pay_pos as $key => $value) {
                $amount += $value['amount'];
            }
            $pays = PayPos::where('client_pos_id', $search_client_pos->id)->get();
            $payss = [];
            foreach ($pays as $key => $value) {
                $payss[$key]['pay_method_id'] = $value['pay_method'];
                $payss[$key]['pay_date'] = $value['register_date'];
                $payss[$key]['reference'] = $value['reference'];
                $payss[$key]['amount'] = $value['amount'];
            }

            try {
                $pay_method = PayMethod::where('status', 1)->pluck('name_pay_method', 'id');
                $result['status'] = 1;
                $result['message'] = __('Success');
                $result['pay_method'] = $pay_method;
                $result['pays'] = $payss;
                $result['type_message'] = 'success';
                $result['redirect'] = '';
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['message'] = __('Failed, contact the administrator.');
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChargePos  $chargePos
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ChargePos $chargePos)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChargePos  $chargePos
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ChargePos $chargePos)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\ChargePos  $chargePos
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChargePos $chargePos)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChargePos  $chargePos
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChargePos $chargePos)
    {

    }
}
