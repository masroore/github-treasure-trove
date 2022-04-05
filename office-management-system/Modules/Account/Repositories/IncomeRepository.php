<?php

namespace Modules\Account\Repositories;

use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\Income;
use Modules\Account\Entities\Voucher;
use Session;

class IncomeRepository implements IncomeRepositoryInterface
{
    public function expenceList()
    {
        if (auth()->user()->role->type == 'system_user') {
            return Income::with('showroom', 'voucher')->latest()->get();
        }

        return Income::with('showroom', 'voucher')->where('showroom_id', Session::get('showroom_id'))->latest()->get();
    }

    public function expenceAccount()
    {
        return ChartAccount::where('type', 4)->orWhere('parent_id', 3)->get();
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
            'account_id' => $data['account_id'],
            'account_type' => 4,
        ]);

        $Voucher->transactions()->createMany($transactions);

        foreach ($Voucher->transactions as $transaction) {
            $transaction->fromAccounts()->attach($data['account_id']);
        }
        $Voucher->update(['tx_id' => 'INC-' . $Voucher->id]);

        $income = Income::create([
            'showroom_id' => Session::get('showroom_id'),
            'voucher_id' => $Voucher->id,
            'account_id' => $data['account_id'],
            'status' => 1,
        ]);

        $Voucher->referable_id = $income->id;
        $Voucher->referable_type = 'Modules\Account\Entities\Income';
        $Voucher->save();

        return $Voucher->load('transactions');
    }

    protected function trranactionEntry($data)
    {
        $type = 'Cr';
        if ($data['account_type'] == 'debit') {
            $type = 'Dr';
        }

        return [[
            'account_id' => $data['account_id'],
            'type' => $type,
            'amount' => $data['amount'],
            'narration' => $data['note'],
        ]];
    }

    public function find($id)
    {
        return Income::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $Voucher = '';
        $income = Income::findOrFail($id);
        $transactions = $this->trranactionEntry($data);
        $Voucher = $income->voucher;
        $Voucher->update([
            'amount' => $data['amount'],
            'date' => $data['date'],
            'narration' => $data['narration'],
            'voucher_type' => $data['voucher_type'],
            'payment_type' => $data['payment_type'],
            'account_id' => $data['account_id'],
        ]);

        foreach ($Voucher->transactions as $key => $transaction) {
            $transaction->delete($transaction->id);
        }

        $Voucher->transactions()->createMany($transactions);
        foreach ($Voucher->transactions as $transaction) {
            $transaction->fromAccounts()->attach($data['account_id']);
        }

        $Voucher->update(['tx_id' => $data['voucher_type'] . '-' . $Voucher->id]);

        return $Voucher->load('transactions');
    }

    public function delete($id)
    {
        $income = Income::findOrFail($id);
        $Voucher = $income->voucher;
        foreach ($Voucher->transactions as $transaction) {
            $transaction->fromAccounts()->detach();
            $transaction->delete();
        }
        $Voucher->delete();

        return $income->delete();
    }
}
