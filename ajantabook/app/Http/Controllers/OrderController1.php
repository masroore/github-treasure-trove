<?php

namespace App\Http\Controllers;

use App\Address;
use App\CanceledOrders;
use App\FullOrderCancelLog;
use App\Invoice;
use App\InvoiceDownload;
use App\Mail\PreOrderNotification;
use App\Notifications\SendOrderStatus;
use App\Order;
use App\User;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use View;

class OrderController1 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('order.view'), 403, __('User does not have the right permissions.'));

        $all_orders = Order::with(['user' => function ($q) {
            return $q->select('id', 'name');
        }])->whereHas('user')->where('orders.status', '=', 1);

        $inv_cus = Invoice::first();

        if ($request->ajax()) {
            return DataTables::of($all_orders)
                ->editColumn('checkbox', function ($row) {
                    return "<div class='inline'>
                                <input type='checkbox' form='bulk_delete_form' class='filled-in material-checkbox-input' name='checked[]'' value='$row->id' id='checkbox$row->id'>
                                <label for='checkbox$row->id' class='material-checkbox'></label>
                                </div>";
                })
                ->addIndexColumn()
                ->addColumn('order_type', function ($row) {
                    if ('COD' != $row->payment_method && 'BankTransfer' != $row->payment_method) {
                        return '<label class="badge badge-success">' . __('PREPAID') . '</label>';
                    }
                    if ('BankTransfer' == $row->payment_method) {
                        return '<label class="badge badge-info">' . __('PREPAID') . '</label>';
                    }

                    return '<label class="badge badge-primary">' . __('COD') . '</label>';
                })
                ->addColumn('order_id', function ($row) {
                    $html = '#<b>' . $row->order_id . '</b>';
                    $html .= '<p></p>';
                    $html .= '<small><a title="View Order" href="' . route('show.order', $row->order_id) . '">View Order</a></small> | <small><a title="Edit Order" href="' . route('admin.order.edit', $row->order_id) . '">Edit Order</a></small>';

                    return $html;
                })
                ->addColumn('customer_dtl', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('total_qty', function ($row) {
                    return $row->qty_total;
                })
                ->editColumn('total_amount', function ($row) {
                    return '<b>' . $row->paid_in_currency . ' ' . (price_format($row->order_total + $row->handlingcharge)) . '</b>';
                })
                ->addColumn('order_date', function ($row) {
                    return date('d-m-Y @ h:i A', strtotime($row->created_at));
                })
                ->editColumn('action', 'admin.order.dbTableColumn.action')
                ->rawColumns(['checkbox', 'order_type', 'order_id', 'customer_dtl', 'total_amount', 'order_date', 'action'])
                ->make(true);
        }

        return view('admin.order.index', compact('all_orders', 'inv_cus'));
    }

    public function bulkdelete(Request $request)
    {
        abort_if(!auth()->user()->can('order.delete'), 403, __('User does not have the right permissions.'));

        $validator = Validator::make($request->all(), ['checked' => 'required']);

        if ($validator->fails()) {
            return back()->with('warning', __('Please select one of them to delete'));
        }

        $orders = Order::whereIn('id', $request->checked)->with('invoices')->get();

        $orders->each(function ($item): void {
            $item->invoices()->delete();

            $item->delete();
        });

        notify()->success(__('Selected Orders Deleted Successfully !'), 'Success');

        return redirect()
            ->route('order.index');
    }

    public function viewUserOrder($orderid)
    {
        require_once 'price.php';

        $order = Order::where('order_id', $orderid)->with(['shippingaddress', 'invoices', 'invoices.variant', 'invoices.simple_product'])->whereHas('invoices')->orderBy('id', 'desc')->where('user_id', auth()->user()->id)->where('status', '1')->first();

        if (!isset($order)) {
            notify()->error(__('Order not found or has been deleted !'));

            return redirect('/');
        }

        $inv_cus = Invoice::first();
        $address = $order->shippingaddress;

        if (Auth::check()) {
            $user = Auth::user();

            return view('user.viewfullorder', compact('conversion_rate', 'order', 'user', 'address', 'inv_cus'));
        }

        notify()->error('Unauthorized', '401');

        return redirect('/');
    }

    public function getUserInvoice($invid)
    {
        $inv_cus = Invoice::first();
        $getInvoice = InvoiceDownload::findOrFail($invid);
        $address = Address::findOrFail($getInvoice->order->delivery_address);
        $invSetting = Invoice::where('user_id', $getInvoice->vender_id)->first();
        $design = @file_get_contents(storage_path() . '/app/emart/invoice_design.json');
        $design = json_decode($design);

        if (Auth::check()) {
            if ('a' == Auth::user()->role_id || Auth::user()->id == $getInvoice->order->user_id) {
                if ('delivered' == $getInvoice->status || 'return_request' == $getInvoice->status) {
                    if (0 == selected_lang()->rtl_available) {
                        return view('user.userinvoice_ltr', compact('invSetting', 'getInvoice', 'inv_cus', 'address', 'design'));
                    }

                    return view('user.userinvoice_rtl', compact('invSetting', 'getInvoice', 'inv_cus', 'address', 'design'));
                }

                notify()->error(__('Invoice not available yet !'));

                return back();
            }

            return abort(404);
        }

        return abort(404);
    }

    public function getCancelOrders()
    {
        abort_if(!auth()->user()->can('order.view'), 403, __('User does not have the right permissions.'));

        $inv_cus = Invoice::first();

        $cOrders = CanceledOrders::with(['singleOrder.order', 'singleOrder.order.user', 'singleOrder', 'singleOrder.variant', 'singleOrder.variant.products', 'singleOrder.variant.variantimages'])->whereHas('singleOrder.order')->whereHas('singleOrder.order.user')->whereHas('singleOrder')->latest()->get();

        $comOrder = FullOrderCancelLog::with(['getorderinfo', 'user', 'getorderinfo.invoices', 'getorderinfo.invoices.variant'])->whereHas('getorderinfo.invoices.variant')->whereHas('user')->whereHas('getorderinfo')->latest()->get();

        $partialcount = CanceledOrders::where('read_at', '=', null)->count();
        $fullcount = FullOrderCancelLog::where('read_at', '=', null)->count();

        return view('admin.order.canorderindex', compact('cOrders', 'comOrder', 'inv_cus', 'partialcount', 'fullcount'));
    }

    public function pendingorder()
    {
        abort_if(!auth()->user()->can('order.view'), 403, __('User does not have the right permissions.'));

        $inv_cus = Invoice::first();

        $pendingorders = Order::join('invoice_downloads', 'orders.id', '=', 'invoice_downloads.order_id')->join('users', 'users.id', '=', 'orders.user_id')->where('invoice_downloads.status', '=', 'pending')->where('orders.status', '=', '1')->select('orders.id as id', 'orders.order_id as orderid', 'orders.paid_in as paid_in', 'order_total as total', 'users.name as customername', 'users.id as userid', 'orders.payment_method as payment_method', 'orders.created_at as orderdate', 'orders.handlingcharge as handlingcharge')->latest('orders.id')->get();

        $orders = $pendingorders->unique('id');

        return view('admin.order.pendingorder', compact('orders', 'inv_cus'));
    }

    public function QuickOrderDetails(Request $request)
    {
        abort_if(!auth()->user()->can('order.view'), 403, __('User does not have the right permissions.'));

        $order = Order::where('id', $request->orderid)
            ->whereHas('invoices')
            ->whereHas('user')
            ->first();

        $inv_cus = Invoice::first();

        if (isset($order)) {
            return response()->json(['orderview' => View::make('admin.order.quickorder', compact('order', 'inv_cus'))->render()], 200);
        }

        return response()->json(['code' => 404, 'msg' => 'No Orders Found !']);
    }

    public function show($id)
    {
        abort_if(!auth()->user()->can('order.view'), 403, __('User does not have the right permissions.'));

        $order = Order::where('order_id', $id)->whereHas('invoices')->whereHas('user')->where('status', '=', '1')->first();

        $inv_cus = Invoice::first();

        return view('admin.order.show', compact('order', 'inv_cus'));
    }

    public function editOrder($orderid)
    {
        abort_if(!auth()->user()->can('order.edit'), 403, __('User does not have the right permissions.'));

        $order = Order::where('order_id', $orderid)->whereHas('invoices')->whereHas('user')->where('status', '=', '1')->first();

        $inv_cus = Invoice::first();

        return view('admin.order.edit', compact('order', 'inv_cus'));
    }

    public function printOrder($id)
    {
        abort_if(!auth()->user()->can('order.view'), 403, __('User does not have the right permissions.'));

        $order = Order::find($id);

        $inv_cus = Invoice::first();

        return view('admin.order.printorder', compact('inv_cus', 'order'));
    }

    public function printInvoice($orderID, $id)
    {
        $getInvoice = InvoiceDownload::where('id', $id)->first();
        $inv_cus = Invoice::first();
        $address = Address::findOrFail($getInvoice
            ->order
            ->delivery_address);
        $invSetting = Invoice::where('user_id', $getInvoice->vender_id)
            ->first();

        $design = @file_get_contents(storage_path() . '/app/emart/invoice_design.json');
        $design = json_decode($design);

        if (0 == selected_lang()->rtl_available) {
            return view('admin.order.printinvoices_ltr', compact('invSetting', 'address', 'getInvoice', 'inv_cus', 'design'));
        }

        return view('admin.order.printinvoices_rtl', compact('invSetting', 'address', 'getInvoice', 'inv_cus', 'design'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $data = Order::create($input);
        $data->save();

        return back()
            ->with('updated', __('Order has been updated'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('order.edit'), 403, __('User does not have the right permissions.'));

        $order = Order::findOrFail($id);
        $order_status = order::all();

        return view('admin.order.edit', compact('order', 'order_status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('order.edit'), 403, __('User does not have the right permissions.'));

        $order = Order::findOrFail($id);
        $input = $request->all();
        $order->update($input);

        $sub = new Order();
        $obj = $sub->find($id);
        $obj->updated_at = date('Y-m-d h:i:s');
        $value = $obj->save();

        if ('pending' == $request->order_status) {

            // Sending to user
            User::find($order->user_id)
                ->notify(new SendOrderStatus($order));
            // END
        }

        if ('processed' == $request->order_status) {

            // Sending to user
            User::find($order->user_id)
                ->notify(new SendOrderStatus($order));
            // END
        }

        if ('dispatched' == $request->order_status) {

            // Sending to user
            User::find($order->user_id)
                ->notify(new SendOrderStatus($order));
            // END
        }

        if ('shipped' == $request->order_status) {

            // Sending to user
            User::find($order->user_id)
                ->notify(new SendOrderStatus($order));
            // END
        }

        if ('delivered' == $request->order_status) {

            // Sending to user
            User::find($order->user_id)
                ->notify(new SendOrderStatus($order));
            // END
        }

        if ('cancelled' == $request->order_status) {

            // Sending to user
            User::find($order->user_id)
                ->notify(new SendOrderStatus($order));
            // END
        }

        return redirect('admin/order')->with('updated', __('Order Status has been updated !'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('order.delete'), 403, __('User does not have the right permissions.'));

        $order = Order::findorFail($id);

        $order->status = 0;

        $order->save();

        session()
            ->flash('deleted', __('Order has been deleted'));

        return redirect('admin/order');
    }

    public function pending()
    {
        $orders = Order::where('order_status', 'pending')->get();

        return view('admin.order.index', compact('orders'));
    }

    public function deliverd()
    {
        $orders = Order::where('order_status', 'delivered')->get();

        return view('admin.order.index', compact('orders'));
    }

    public function downloadDigitalProduct(Request $request, $id)
    {
        abort_if(!auth()->check(), 403, __('Download permission denied !'));

        $order = InvoiceDownload::findorfail($id);

        if ('delivered' != $order->status) {
            notify()->error(__('Download permission denied !'));

            return back();
        }

        $product = $order->simple_product;
        $filename = $product->product_file;

        if (1 == env('DEMO_LOCK')) {
            notify()->error(__('This action is disabled in demo !'));

            return back();
        }

        if (!$request->hasValidSignature()) {
            notify()->error(__('Download Link is invalid or expired !'));

            return back();
        }

        $filePath = storage_path() . '/digitalproducts/files/' . $filename;

        $fileContent = @file_get_contents($filePath);

        if (!$fileContent) {
            notify()->error(__('File not found contact your seller with order id !'));

            return back();
        }

        return response($fileContent, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function preorders(Request $request)
    {
        $preorders = InvoiceDownload::join('orders', 'orders.id', '=', 'invoice_downloads.order_id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'invoice_downloads.*',
                'users.name as customer',
                'orders.payment_method',
                'orders.order_id',
                'orders.paid_in_currency'
            )
            ->where('invoice_downloads.status', '=', 'pending')
            ->where('invoice_downloads.type', '=', 'pre_order');

        if ($request->ajax()) {
            return DataTables::of($preorders)
                ->editColumn('checkbox', function ($row) {
                    return "<div class='inline'>
                                <input type='checkbox' form='bulk_form_notify' class='filled-in material-checkbox-input' name='checked[]'' value='$row->id' id='checkbox$row->id'>
                                <label for='checkbox$row->id' class='material-checkbox'></label>
                                </div>";
                })
                ->addIndexColumn()
                ->addColumn('invoice_id', function ($row) {
                    return '#<b>' . $row->inv_no . '</b>';
                })
                ->addColumn('order_id', function ($row) {
                    return '#<b>' . $row->order_id . '</b>';
                })
                ->addColumn('order_type', function ($row) {
                    if ('COD' != $row->payment_method && 'BankTransfer' != $row->payment_method) {
                        return '<label class="badge badge-success">' . __('PREPAID') . '</label>';
                    }
                    if ('BankTransfer' == $row->payment_method) {
                        return '<label class="badge badge-info">' . __('PREPAID') . '</label>';
                    }

                    return '<label class="badge badge-primary">' . __('COD') . '</label>';
                })
                ->editColumn('paid_amount', function ($row) {
                    $html = $row->paid_in_currency . ' ';
                    $html .= price_format(($row->price * $row->qty) + $row->tax_amount + $row->shipping + $row->handlingcharge);

                    return $html;
                })
                ->editColumn('remaining_paid_amount', function ($row) {
                    return $row->paid_in_currency . ' ' . price_format($row->remaning_amount);
                })
                ->addColumn('customer_name', function ($row) {
                    return $row->customer;
                })
                ->addColumn('total_qty', function ($row) {
                    return $row->qty;
                })
                ->addColumn('total_amount', function ($row) {
                    $html = $row->paid_in_currency . ' ';
                    $html .= price_format(($row->price * $row->qty) + $row->tax_amount + $row->shipping + $row->handlingcharge + $row->remaning_amount);

                    return $html;
                })
                ->addColumn('order_date', function ($row) {
                    return date('d-m-Y | h:i A', strtotime($row->created_at));
                })
                ->rawColumns(['checkbox', 'invoice_id', 'order_id', 'order_type', 'paid_amount', 'remaining_paid_amount', 'customer_name', 'total_qty', 'total_amount', 'order_date', 'action'])
                ->make(true);
        }

        return view('admin.order.preorder');
    }

    /** This function is used to notify about preorder notification */
    public function preordernotify(Request $request)
    {
        $get_pre_orders = InvoiceDownload::whereIn('id', $request->checked)
            ->whereHas('order')
            ->whereHas('order.user')
            ->with(['order', 'order.user'])
            ->get();

        $get_pre_orders->each(function ($value): void {
            Mail::to($value->order->user->email)->send(new PreOrderNotification($value));
        });

        return back()->with('added', __('Preorder customers has been notified with link !'));
    }
}
