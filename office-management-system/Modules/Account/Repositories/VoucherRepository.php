<?php

namespace Modules\Account\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Account\Entities\AccountCategory;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\Document;
use Modules\Account\Entities\Voucher;
use Modules\Sale\Entities\Sale;

class VoucherRepository implements VoucherRepositoryInterface
{
    public function voucher_payment_all()
    {
        return Voucher::where('payment_type', 'voucher_payment')->latest()->get();
    }

    public function voucher_recieve_all()
    {
        return Voucher::where('payment_type', 'voucher_recieve')->latest()->get();
    }

    public function voucher_list_all()
    {
        return Voucher::latest()->get();
    }

    public function create($data)
    {
        $Voucher = '';
        $transactions = $this->trranactionEntry($data);
        $Voucher = Voucher::create([
            'amount' => $data['amount'],
            'date' => $data['date'],
            'narration' => $data['narration'],
            'voucher_type' => $data['voucher_type'],
            'payment_type' => $data['payment_type'],
            'is_approve' => $data['is_approve'],
        ]);
        if ($data['voucher_type'] == 'BV') {
            $document = Document::create([
                'voucher_id' => $Voucher->id,
                'bank_branch' => $data['bank_branch'],
                'bank_name' => $data['bank_name'],
                'cheque_date' => $data['cheque_date'],
                'cheque_no' => $data['cheque_no'],
            ]);
        }
        $Voucher->transactions()->createMany($transactions);
        foreach ($Voucher->transactions as $transaction) {
            if ($transaction->type == 'Cr') {
                $transaction->fromAccounts()->attach($data['debit_account_id']);
            } else {
                $transaction->fromAccounts()->attach($data['credit_account_id']);
            }
        }
        if (!empty($data['sale_id']) && !empty($data['sale_class'])) {
            $Voucher->update(['tx_id' => $data['voucher_type'] . '-' . $Voucher->id, 'referable_id' => $data['sale_id'], 'referable_type' => $data['sale_class']]);
        } elseif (!empty($data['invoice_id']) && $data['invoice_id'] != null) {
            $Voucher->update(['tx_id' => $data['voucher_type'] . '-' . $Voucher->id, 'referable_id' => $data['invoice_id'], 'referable_type' => 'Modules\Sale\Entities\Sale']);
        } else {
            $Voucher->update(['tx_id' => $data['voucher_type'] . '-' . $Voucher->id]);
        }

        $Voucher->load('transactions');

        return $Voucher;
    }

    protected function trranactionEntry($data)
    {
        if (is_array($data['debit_account_id'])) {
            $conver_date = [];
            for ($i = 0; $i < count($data['debit_account_id']); ++$i) {
                array_push($conver_date, [
                    'account_id' => $data['debit_account_id'][$i],
                    'type' => 'Dr',
                    'amount' => $data['debit_account_amount'][$i],
                    'narration' => $data['debit_account_narration'][$i],
                ]);
            }
            array_push($conver_date, [
                'account_id' => $data['credit_account_id'],
                'type' => 'Cr',
                'amount' => $data['credit_account_amount'],
            ]);

            return $conver_date;
        } elseif (is_array($data['credit_account_id'])) {
            $conver_date = [];
            for ($i = 0; $i < count($data['credit_account_id']); ++$i) {
                array_push($conver_date, [
                    'account_id' => $data['credit_account_id'][$i],
                    'type' => 'Dr',
                    'amount' => $data['credit_account_amount'][$i],
                    'narration' => $data['credit_account_narration'][$i],
                ]);
            }
            array_push($conver_date, [
                'account_id' => $data['debit_account_id'],
                'type' => 'Cr',
                'amount' => $data['debit_account_amount'],
            ]);

            return $conver_date;
        }

        return
                [
                    [
                        'account_id' => $data['debit_account_id'],
                        'from_account_id' => $data['credit_account_id'],
                        'type' => 'Dr',
                        'amount' => $data['amount'],
                    ],
                    [
                        'account_id' => $data['credit_account_id'],
                        'from_account_id' => $data['debit_account_id'],
                        'type' => 'Cr',
                        'amount' => $data['amount'],
                    ],
                ];
    }

    public function find($id)
    {
        return Voucher::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $Voucher = '';
        $transactions = $this->trranactionEntry($data);
        $Voucher = Voucher::findOrFail($id);
        $Voucher->update([
            'amount' => $data['amount'],
            'date' => $data['date'],
            'narration' => $data['narration'],
            'voucher_type' => $data['voucher_type'],
            'is_approve' => $data['is_approve'],
        ]);
        if ($data['voucher_type'] == 'BV') {
            if ($Voucher->document != null) {
                $Voucher->document->update([
                    'voucher_id' => $Voucher->id,
                    'bank_branch' => $data['bank_branch'],
                    'bank_name' => $data['bank_name'],
                    'cheque_date' => $data['cheque_date'],
                    'cheque_no' => $data['cheque_no'],
                ]);
            } else {
                $document = Document::create([
                    'voucher_id' => $Voucher->id,
                    'bank_branch' => $data['bank_branch'],
                    'bank_name' => $data['bank_name'],
                    'cheque_date' => $data['cheque_date'],
                    'cheque_no' => $data['cheque_no'],
                ]);
            }
        } elseif ($data['voucher_type'] == 'CV') {
            if ($Voucher->document != null) {
                $Voucher->document->delete($Voucher->id);
            }
        }

        foreach ($Voucher->transactions as $key => $transaction) {
            $transaction->delete($transaction->id);
        }
        $Voucher->transactions()->createMany($transactions);
        foreach ($Voucher->transactions as $transaction) {
            if ($transaction->type == 'Cr') {
                $transaction->fromAccounts()->attach($data['debit_account_id']);
            } else {
                $transaction->fromAccounts()->attach($data['credit_account_id']);
            }
        }
        $Voucher->update(['tx_id' => $data['voucher_type'] . '-' . $Voucher->id]);

        $Voucher->load('transactions');

        return $Voucher;
    }

    public function delete($id)
    {
        $Voucher = Voucher::findOrFail($id);
        foreach ($Voucher->transactions as $transaction) {
            $transaction->fromAccounts()->detach();
            $transaction->delete();
        }

        return $Voucher->delete();
    }

    public function category()
    {
        return AccountCategory::where('name', 'Account for Cash')->orWhere('name', 'Account for Bank')->get();
    }

    public function recieveCategoryAccounts()
    {
        $customer_id_list = ChartAccount::where('parent_id', 5)->where('is_group', 0)->orWhere('configuration_group_id', 3)->pluck('id');
        $income_accounts = ChartAccount::where('type', 4)->where('is_group', 0)->whereNotIn('code', ['04-16-17', '04-24'])->pluck('id');
        $ids = $customer_id_list->merge($income_accounts);

        return ChartAccount::whereIn('id', $ids)->get();
    }

    public function get_recieveByAccount_account()
    {
        return ChartAccount::select('*')
            ->whereIn('configuration_group_id', [1, 2])
            ->get();
    }

    public function get_chart_account()
    {
        return ChartAccount::where('is_group', 0)->get();
    }

    public function get_account(array $data)
    {
        return AccountCategory::where('id', $data['id'])->first();
    }

    public function BankPaymentAccount()
    {
        return ChartAccount::BankPaymentAccounts()->get();
    }

    public function CashPaymentAccount()
    {
        return ChartAccount::CashPaymentAccounts()->get();
    }

    public function LiabilityAccount()
    {
        return ChartAccount::LiabilityAccount()->get();
    }

    public function findChartAccount(array $data)
    {
        return ChartAccount::findOrFail($data['id']);
    }

    public function status_approval(array $data)
    {
        $voucher = Voucher::findOrFail($data['id']);
        $voucher->is_approve = $data['status'];
        $voucher->save();

        return $voucher;
    }

    public function get_voucher_details(array $data)
    {
        return Voucher::findOrFail($data['id']);
    }

    public function allApproved()
    {
        return Voucher::where('is_approve', 0)->update(['is_approve' => 1]);
    }

    public function expenses($type)
    {
        if (session()->get('showroom_id') == 1) {
            return Voucher::where('is_approve', 1)->Expense($type)->whereHas('expense')->sum('amount');
        }

        return Voucher::where('is_approve', 1)->Expense($type)->whereHasMorph('referable', [Sale::class], function ($query): void {
            $query->where('saleable_id', session()->get('showroom_id'));
        })->whereHas('expense')->sum('amount');
    }

    public function dailyProfit($id)
    {
        $main_amount = Voucher::whereHas('transactions', function ($query): void {
            $query->where('account_id', 19)->where('type', 'Dr');
        })->select(
            DB::raw('MONTHNAME(date) as month'),
            DB::raw('YEAR(date) as year'),
            DB::raw('DAY(date) as day'),
            DB::raw('SUM(amount) as sale_amount'),
            'id',
            'date'
        )->whereDate('date', Carbon::today())
            ->groupBy('day')->orderBy('day', 'asc')->get();

        $total_amount = Voucher::whereHas('transactions', function ($query) use ($id): void {
            $query->where('type', 'Dr')->Account($id);
        })->select(
            DB::raw('MONTHNAME(date) as month'),
            DB::raw('YEAR(date) as year'),
            DB::raw('DAY(date) as day'),
            DB::raw('SUM(amount) as sale_amount'),
            'id',
            'date'
        )->whereDate('date', Carbon::today())
            ->groupBy('day')->orderBy('day', 'asc')->get();

        return [
            'main_amount' => $main_amount,
            'total_amount' => $total_amount,
        ];
    }

    public function weeklyProfit($id)
    {
        $main_amount = Voucher::whereHas('transactions', function ($query): void {
            $query->where('account_id', 19)->where('type', 'Dr');
        })->select(
            'id',
            DB::raw('MONTHNAME(date) as month'),
            DB::raw('YEAR(date) as year'),
            DB::raw('DAY(date) as day'),
            DB::raw('SUM(amount) as sale_amount'),
            'date'
        )->groupBy('day')->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('day', 'asc')->get();

        $total_amount = Voucher::whereHas('transactions', function ($query) use ($id): void {
            $query->where('type', 'Dr')->Account($id);
        })->select(
            DB::raw('MONTHNAME(date) as month'),
            DB::raw('YEAR(date) as year'),
            DB::raw('DAY(date) as day'),
            DB::raw('SUM(amount) as sale_amount'),
            'id',
            'date'
        )->groupBy('day')->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->orderBy('day', 'asc')->get();

        return [
            'main_amount' => $main_amount,
            'total_amount' => $total_amount,
        ];
    }

    public function monthlyProfit($id)
    {
        $main_amount = Voucher::whereHas('transactions', function ($query): void {
            $query->where('account_id', 19)->where('type', 'Dr');
        })->select(
            DB::raw('MONTHNAME(date) as month'),
            DB::raw('YEAR(date) as year'),
            DB::raw('DAY(date) as day'),
            DB::raw('SUM(amount) as sale_amount'),
            'id',
            'date'
        )->whereMonth('date', Carbon::now())->whereYear('date', Carbon::now())
            ->groupBy('day')->orderBy('day', 'asc')->get();

        $total_amount = Voucher::whereHas('transactions', function ($query) use ($id): void {
            $query->where('type', 'Dr')->Account($id);
        })->select(
            DB::raw('MONTHNAME(date) as month'),
            DB::raw('YEAR(date) as year'),
            DB::raw('DAY(date) as day'),
            DB::raw('SUM(amount) as sale_amount'),
            'id',
            'date'
        )->whereMonth('date', Carbon::now())->whereYear('date', Carbon::now())
            ->groupBy('day')->orderBy('day', 'asc')->get();

        return [
            'main_amount' => $main_amount,
            'total_amount' => $total_amount,
        ];
    }

    public function yearlyProfit($id)
    {
        $main_amount = Voucher::whereHas('transactions', function ($query): void {
            $query->where('account_id', 19)->where('type', 'Dr');
        })->select(
            DB::raw('MONTHNAME(date) as month_name'),
            DB::raw('MONTH(date) as month'),
            DB::raw('YEAR(date) as year'),
            DB::raw('SUM(amount) as sale_amount'),
            'id',
            'date'
        )->whereYear('date', Carbon::now())->groupBy('month')
            ->orderBy('month', 'asc')->get();

        $total_amount = Voucher::whereHas('transactions', function ($query) use ($id): void {
            $query->where('type', 'Dr')->Account($id);
        })->select(
            DB::raw('MONTHNAME(date) as month_name'),
            DB::raw('MONTH(date) as month'),
            DB::raw('YEAR(date) as year'),
            DB::raw('SUM(amount) as sale_amount'),
            'id',
            'date'
        )->whereYear('date', Carbon::now())->groupBy('month')
            ->orderBy('month', 'asc')->get();

        return [
            'main_amount' => $main_amount,
            'total_amount' => $total_amount,
        ];
    }
}
