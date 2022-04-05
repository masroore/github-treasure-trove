<?php

namespace Modules\Report\Exports;

use App\Models\AgentTransaction;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StatementExport implements FromCollection, Responsable, WithHeadings
{
    use Exportable;

    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = AgentTransaction::query();

        $from_date = Carbon::parse($this->request->from_date)->setTime(0, 0, 0);
        $to_date = Carbon::parse($this->request->to_date)->setTime(23, 59, 59);

        $query->where('created_at', '>=', $from_date);
        $query->where('created_at', '<=', $to_date);

        if (null != $this->request->agent_id) {
            $query->where('agent_id', $this->request->agent_id);
        }

        $collections = $query->with(['agent'])->orderBy('id', 'desc')->get();

        $response = [];

        if ($collections->count() > 0) {
            foreach ($collections as $key => $collection) {
                $tempCollection = [
                    'sn' => $key + 1,
                    'date' => Carbon::parse($collection->created_at ?? null)->format('Y-m-d H:i'),
                    'agent' => $collection->agent->name ?? null,
                    'transaction_ref_id' => $collection->transaction_id,
                    'remarks' => $collection->remarks,
                    'currency' => $collection->account_type,
                    'debit' => null,
                    'credit' => null,
                    'balance' => $collection->closing_balance,
                    'status' => $collection->status,
                ];

                if ('debit' == $collection->type) {
                    $tempCollection['debit'] = $collection->transaction_amount;
                } elseif ('credit' == $collection->type) {
                    $tempCollection['credit'] = $collection->transaction_amount;
                }

                $response[] = $tempCollection;
            }
        }

        return collect($response);
    }

    /**
     * {@inheritDoc}
     */
    public function headings(): array
    {
        return [
            'S.N',
            'Date',
            'Agent Name',
            'Transaction ID',
            'Remarks',
            'Currency',
            'Debit',
            'Credit',
            'Balance',
            'Status',
        ];
    }
}
