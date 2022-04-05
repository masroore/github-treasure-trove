<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDownload;
use App\Order;
use App\OrderActivityLog;
use App\PendingPayout;
use Auth;
use Illuminate\Http\Request;

class QuickConfirmOrderController extends Controller
{
    public function quickconfirmfullorder($orderid, Request $request)
    {
        $order = Order::find($orderid);

        if (isset($order)) {
            foreach ($order->invoices as $key => $invoice) {
                $inv = InvoiceDownload::findOrFail($invoice->id);

                $inv->status = $request->status;
                $inv->save();
                $inv_cus = Invoice::first();
                $status = ucfirst($request->status);

                $newpendingpay = PendingPayout::where('orderid', '=', $inv->id)->first();

                if (isset($newpendingpay)) {
                    $newpendingpay->delete();
                }

                $create_activity = new OrderActivityLog();

                $create_activity->order_id = $inv->order_id;
                $create_activity->inv_id = $inv->id;
                $create_activity->user_id = Auth::user()->id;
                $create_activity->variant_id = $inv->variant_id;
                $create_activity->log = $status;

                $create_activity->save();
            }

            return back()->with('added', __('Order confirmed successfully !'));
        }

        return back()->with('delete', __('Order not found or deleted !'));
    }
}
