<?php

namespace Modules\Account\Repositories;

use Carbon\Carbon;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\Transaction;
use Modules\Contact\Entities\ContactModel;

class AccountBalanceRepository implements AccountBalanceRepositoryInterface
{
    public function getIncome($start_date = null, $end_date = null)
    {
        $ChartAccount = ChartAccount::where('type', 4)->pluck('id');

        $previousDate = Carbon::parse($start_date ?? Carbon::now()->format('Y-m-d'))->subDays(1)->format('Y-m-d');

        $previousIncome = Transaction::whereIn('account_id', $ChartAccount)->where('created_at', '<=', $previousDate . ' 23:59:59')->get();

        if ($start_date != null && $end_date != null) {
            $transaction = Transaction::whereIn('account_id', $ChartAccount)->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->get();
        } else {
            $transaction = Transaction::whereIn('account_id', $ChartAccount)->whereBetween('created_at', [Carbon::now()->format('Y-m-d') . ' 00:00:00', Carbon::now()->format('Y-m-d') . ' 23:59:59'])->get();
        }

        $ChartAccount = ChartAccount::with('transactions')->where('type', 4)->get();
        $data = [
            'transaction' => $transaction,
            'previousDate' => $previousDate,
            'ChartAccount' => $ChartAccount,
        ];

        return $data;
    }

    public function getExpense($start_date = null, $end_date = null)
    {
        $ChartAccount = ChartAccount::where('type', 3)->pluck('id');

        $previousDate = Carbon::parse($start_date ?? Carbon::now()->format('Y-m-d'))->subDays(1)->format('Y-m-d');

        $previous = Transaction::whereIn('account_id', $ChartAccount)->where('created_at', '<=', $previousDate . ' 23:59:59')->get();

        if ($start_date != null && $end_date != null) {
            $transaction = Transaction::whereIn('account_id', $ChartAccount)->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->get();
        } else {
            $transaction = Transaction::whereIn('account_id', $ChartAccount)->whereBetween('created_at', [Carbon::now()->format('Y-m-d') . ' 00:00:00', Carbon::now()->format('Y-m-d') . ' 23:59:59'])->get();
        }

        $ChartAccount = ChartAccount::with('transactions')->where('type', 3)->get();
        $data = [
            'transaction' => $transaction,
            'previousDate' => $previousDate,
            'ChartAccount' => $ChartAccount,
        ];

        return $data;
    }

    public function getAsset($start_date = null, $end_date = null)
    {
        $ChartAccount = ChartAccount::where('type', 1)->pluck('id');

        $previousDate = Carbon::parse($start_date ?? Carbon::now()->format('Y-m-d'))->subDays(1)->format('Y-m-d');

        $previous = Transaction::whereIn('account_id', $ChartAccount)->where('created_at', '<=', $previousDate . ' 23:59:59')->get();

        if ($start_date != null && $end_date != null) {
            $transaction = Transaction::whereIn('account_id', $ChartAccount)->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->get();
        } else {
            $transaction = Transaction::whereIn('account_id', $ChartAccount)->whereBetween('created_at', [Carbon::now()->format('Y-m-d') . ' 00:00:00', Carbon::now()->format('Y-m-d') . ' 23:59:59'])->get();
        }

        $ChartAccount = ChartAccount::with('transactions')->where('type', 1)->get();
        $data = [
            'transaction' => $transaction,
            'previousDate' => $previousDate,
            'ChartAccount' => $ChartAccount,
        ];

        return $data;
    }

    public function getLiabilities($start_date = null, $end_date = null)
    {
        $ChartAccount = ChartAccount::where('type', 2)->pluck('id');

        $previousDate = Carbon::parse($start_date ?? Carbon::now()->format('Y-m-d'))->subDays(1)->format('Y-m-d');

        $previous = Transaction::whereIn('account_id', $ChartAccount)->where('created_at', '<=', $previousDate . ' 23:59:59')->get();

        if ($start_date != null && $end_date != null) {
            $transaction = Transaction::whereIn('account_id', $ChartAccount)->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->get();
        } else {
            $transaction = Transaction::whereIn('account_id', $ChartAccount)->whereBetween('created_at', [Carbon::now()->format('Y-m-d') . ' 00:00:00', Carbon::now()->format('Y-m-d') . ' 23:59:59'])->get();
        }

        $ChartAccount = ChartAccount::with('transactions')->where('type', 2)->get();
        $data = [
            'transaction' => $transaction,
            'previousDate' => $previousDate,
            'ChartAccount' => $ChartAccount,
        ];

        return $data;
    }

    public function getEquity($start_date = null, $end_date = null)
    {
        $ChartAccount = ChartAccount::where('type', 5)->pluck('id');

        $previousDate = Carbon::parse($start_date ?? Carbon::now()->format('Y-m-d'))->subDays(1)->format('Y-m-d');

        $previous = Transaction::whereIn('account_id', $ChartAccount)->where('created_at', '<=', $previousDate . ' 23:59:59')->get();

        if ($start_date != null && $end_date != null) {
            $transaction = Transaction::whereIn('account_id', $ChartAccount)->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->get();
        } else {
            $transaction = Transaction::whereIn('account_id', $ChartAccount)->whereBetween('created_at', [Carbon::now()->format('Y-m-d') . ' 00:00:00', Carbon::now()->format('Y-m-d') . ' 23:59:59'])->get();
        }

        $ChartAccount = ChartAccount::with('transactions')->where('type', 5)->get();
        $data = [
            'transaction' => $transaction,
            'previousDate' => $previousDate,
            'ChartAccount' => $ChartAccount,
        ];

        return $data;
    }

    public function getIncomeByCustomer($start_date = null, $end_date = null)
    {
        $customer = ContactModel::customer()->pluck('id');

        $customerChartAccount = ChartAccount::where('contactable_type', 'Modules\Contact\Entities\ContactModel')->whereIn('contactable_id', $customer)->get();

        return $customerChartAccount;
    }

    public function getExpenseBySupplier($start_date = null, $end_date = null)
    {
        $supplier = ContactModel::supplier()->pluck('id');

        $supplierChartAccount = ChartAccount::where('contactable_type', 'Modules\Contact\Entities\ContactModel')->whereIn('contactable_id', $supplier)->get();

        return $supplierChartAccount;
    }

    public function saleTax($start_date = null, $end_date = null)
    {
        $taxChartAccount = ChartAccount::where('contactable_type', 'Modules\Setup\Entities\Tax')->get()->pluck('id');

        $taxChartAccount[] = ChartAccount::where('code', '02-12-13')->first()->id;

        if ($start_date == null && $end_date == null) {
            $transaction = Transaction::whereIn('account_id', $taxChartAccount)->where('type', 'Cr')->get();
        } else {
            $transaction = Transaction::whereIn('account_id', $taxChartAccount)->where('type', 'Cr')->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->get();
        }

        return $transaction;
    }

    public function income($start_date = null, $end_date = null)
    {
        $ChartAccount = ChartAccount::whereIn('configuration_group_id', [1, 2])->pluck('id');

        if ($start_date == null && $end_date == null) {
            $transaction = Transaction::whereIn('account_id', $ChartAccount)->where('type', 'Dr')->get();
        } else {
            $transaction = Transaction::whereIn('account_id', $ChartAccount)->where('type', 'Dr')->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->get();
        }

        return $transaction;
    }

    public function expense($start_date = null, $end_date = null)
    {
        $ChartAccount = ChartAccount::whereIn('configuration_group_id', [1, 2])->pluck('id');
        if ($start_date == null && $end_date == null) {
            $transaction = Transaction::whereIn('account_id', $ChartAccount)->where('type', 'Cr')->get();
        } else {
            $transaction = Transaction::whereIn('account_id', $ChartAccount)->where('type', 'Cr')->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->get();
        }

        return $transaction;
    }
}
