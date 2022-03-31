<?php

namespace Modules\AdminReport\Http\Controllers;

use App\Exports\CustomerOrderExport;
use App\Exports\CustomerTransactionExport;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\CustomerUser;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AdminReportController extends Controller
{
    public function customerOrderIndex()
    {
        $sdata = [
            'menu' => 'customerOrder',
        ];
        $customers = CustomerUser::select('id', 'email')->get();

        // $startDate = request()->startDate;
        // $endDate = request()->endDate;
        // $customer_id = request()->customer_id;
        // $invoice_number = request()->invoice_number;
        // $status = request()->status;

        $data = request()->only(['startDate', 'endDate', 'customer_id', 'invoice_number', 'status']);

        $orderProductsId = [];

        if (isset($data['customer_id'])) {
            $orderProductsId = Order::where('customer_user_id', $data['customer_id'])->pluck('id');
        }
        if (isset($data['invoice_number'])) {
            $orderProductsId = Order::where('invoice_number', $data['invoice_number'])->pluck('id');
        }

        $orderProducts = OrderProduct::when(isset($data['startDate']) && isset($data['endDate']), function ($query) use ($data) {
            return $query->where('created_at', '>=', $data['startDate'])->where('created_at', '<=', $data['endDate']);
        })
            ->when(isset($data['customer_id']), function ($query) use ($orderProductsId) {
            return $query->whereIn('order_id', $orderProductsId);
        })
            ->when(isset($data['invoice_number']), function ($query) use ($orderProductsId) {
            return $query->whereIn('order_id', $orderProductsId);
        })
            ->when(isset($data['status']), function ($query) use ($data) {
            return $query->where('status', $data['status']);
        })
            ->get();

        return view('adminreport::order-index', compact('orderProducts', 'customers', 'data'), $sdata);
    }

    public function customerOrderExport()
    {
        $data = request()->only(['startDate', 'endDate', 'customer_id', 'invoice_number', 'status']);

        return Excel::download(new CustomerOrderExport($data), 'transactions-' . Carbon::now() . '-' . uniqid() . '.xlsx');
    }

    public function customerTransactionIndex()
    {
        $sdata = [
            'menu' => 'customerTransaction',
        ];

        $customers = CustomerUser::select('id', 'email')->get();

        $data = request()->only(['startDate', 'endDate', 'customer_id', 'type']);

        $uTransactions = CustomerTransaction::when(isset($data['startDate']) && isset($data['endDate']), function ($query) use ($data) {
            return $query->where('created_at', '>=', $data['startDate'])->where('created_at', '<=', $data['endDate']);
        })
            ->when(isset($data['customer_id']), function ($query) use ($data) {
            return $query->where('customer_user_id', $data['customer_id']);
        })
            ->when(isset($data['type']), function ($query) use ($data) {
            return $query->where('type', $data['type']);
        })
            ->select('description', 'amount', 'customer_user_id', 'type')
            ->get();

        return view('adminreport::transaction-index', compact('uTransactions', 'customers', 'data'), $sdata);
    }

    public function customerTransactionExport()
    {
        $data = request()->only(['startDate', 'endDate', 'customer_id', 'type']);

        return Excel::download(new CustomerTransactionExport($data), 'transactions-' . Carbon::now() . '-' . uniqid() . '.xlsx');
    }

    public function taxIndex()
    {
        $sdata = [
            'menu' => 'tax',
        ];

        return view('adminreport::tax-index', $sdata);
    }
}
