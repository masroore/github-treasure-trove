<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Entities\PaymentGateway;
use Toastr;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $data['paymeny_gateways'] = PaymentGateway::all();

        return view('setting::payment-method', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $paymentGateway = PaymentGateway::findOrFail($id);
            $paymentGateway->gateway_name = $request->gateway_name;
            $paymentGateway->gateway_username = $request->gateway_username;
            $paymentGateway->gateway_api_key = $request->gateway_api_key;
            $paymentGateway->gateway_secret_key = $request->gateway_secret_key;
            $paymentGateway->redirect_url = $request->redirect_url;
            $paymentGateway->save();

            return redirect()->back();
            Toastr::success('Operation successful', 'Success');
        } catch (Exception $e) {
            Toastr::error('Operation Failed', 'Failed');

            return redirect()->back();
        }
    }

    public function updateActive(Request $request)
    {
        try {
            $allPaymentGateWay = PaymentGateway::all();

            $reqArr = $request->gateways;

            if (null === $reqArr) {
                foreach ($allPaymentGateWay as $key => $value) {
                    PaymentGateway::where('id', $value->id)->update(['active_status' => 0]);
                }
            } else {
                foreach ($allPaymentGateWay as $key => $value) {
                    if (in_array($value->id, $reqArr)) {
                        PaymentGateway::where('id', $value->id)->update(['active_status' => 1]);
                    } else {
                        PaymentGateway::where('id', $value->id)->update(['active_status' => 0]);
                    }
                }
            }

            return redirect()->back();
            Toastr::success('Operation successful', 'Success');
        } catch (Exception $e) {
            Toastr::error('Operation Failed', 'Failed');

            return redirect()->back();
        }
    }
}
