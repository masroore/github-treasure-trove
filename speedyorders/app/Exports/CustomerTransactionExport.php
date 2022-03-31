<?php

namespace App\Exports;

use App\Models\CustomerTransaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomerTransactionExport implements FromView, ShouldAutoSize
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $newData = $this->data;

        return view(
            'adminreport::transaction-report',
            ['uTransactions' => CustomerTransaction::select('description', 'amount', 'customer_user_id', 'type')
            ->when(isset($newData['startDate']) && isset($newData['endDate']), function ($query) use ($newData) {
            return $query->where('created_at', '>=', $newData['startDate'])->where('created_at', '<=', $newData['endDate']);
        })
            ->when(isset($newData['customer_id']), function ($query) use ($newData) {
            return $query->where('customer_user_id', $newData['customer_id']);
        })
            ->when(isset($newData['type']), function ($query) use ($newData) {
            return $query->where('type', $newData['type']);
        })
            ->get(),
        ]
        );
    }
}
