<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomerOrderExport implements FromView, ShouldAutoSize
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $newData = $this->data;

        $orderProductsId = [];

        if (isset($newData['customer_id'])) {
            $orderProductsId = Order::where('customer_id', $newData['customer_id'])->pluck('id');
        }
        if (isset($newData['invoice_number'])) {
            $orderProductsId = Order::where('invoice_number', $newData['invoice_number'])->pluck('id');
        }

        return view(
            'adminreport::order-report',
            ['orderProducts' => OrderProduct::when(isset($newData['startDate']) && isset($newData['endDate']), function ($query) use ($newData) {
            return $query->where('created_at', '>=', $newData['startDate'])->where('created_at', '<=', $newData['endDate']);
        })
            ->when(isset($newData['customer_id']), function ($query) use ($orderProductsId) {
            return $query->where('order_id', $orderProductsId);
        })
            ->when(isset($data['invoice_number']), function ($query) use ($orderProductsId) {
            return $query->where('order_id', $orderProductsId);
        })
            ->when(isset($newData['status']), function ($query) use ($newData) {
            return $query->where('status', $newData['status']);
        })
            ->get(),
        ]
        );
    }
}
