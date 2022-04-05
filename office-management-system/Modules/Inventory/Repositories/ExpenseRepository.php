<?php

namespace Modules\Inventory\Repositories;

use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\Document;
use Modules\Account\Entities\Voucher;
use Modules\Inventory\Entities\Expense;
use Session;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    public function expenceList()
    {
        if (auth()->user()->role->type == 'system_user' || permissionCheck('expenses.show')) {
            return Expense::with('showroom', 'voucher')->latest()->get();
        }

        return Expense::with('showroom', 'voucher')->where('showroom_id', Session::get('showroom_id'))->latest()->get();
    }

    public function expenceAccount()
    {
        return ChartAccount::where('type', 3)->get();
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
                $transaction->fromAccounts()->attach($data['sub_account_id']);
            } else {
                $transaction->fromAccounts()->attach($data['account_id']);
            }
        }
        $Voucher->update(['tx_id' => $data['voucher_type'] . '-' . $Voucher->id]);

        $expense = new Expense();
        $expense->showroom_id = Session::get('showroom_id');
        $expense->voucher_id = $Voucher->id;
        $expense->status = 0;
        $expense->save();

        return $Voucher->load('transactions');
    }

    protected function trranactionEntry($data)
    {
        if ($data['account_type'] == 'debit') {
            if (is_array($data['sub_account_id'])) {
                $conver_date = [];
                for ($i = 0; $i < count($data['sub_account_id']); ++$i) {
                    array_push($conver_date, [
                        'account_id' => $data['sub_account_id'][$i],
                        'type' => 'Cr',
                        'amount' => $data['sub_amount'][$i],
                        'narration' => $data['sub_narration'][$i],
                    ]);
                }
                array_push($conver_date, [
                    'account_id' => $data['account_id'],
                    'type' => 'Dr',
                    'amount' => $data['main_amount'],
                ]);

                return $conver_date;
            }
        } else {
            if (is_array($data['sub_account_id'])) {
                $conver_date = [];
                for ($i = 0; $i < count($data['sub_account_id']); ++$i) {
                    array_push($conver_date, [
                        'account_id' => $data['sub_account_id'][$i],
                        'type' => 'Dr',
                        'amount' => $data['sub_amount'][$i],
                        'narration' => $data['sub_narration'][$i],
                    ]);
                }
                array_push($conver_date, [
                    'account_id' => $data['account_id'],
                    'type' => 'Cr',
                    'amount' => $data['main_amount'],
                ]);

                return $conver_date;
            }
        }
    }

    public function find($id)
    {
        return Expense::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $Voucher = '';
        $expense = Expense::findOrFail($id);
        $transactions = $this->trranactionEntry($data);
        $Voucher = $expense->voucher;
        $Voucher->update([
            'amount' => $data['amount'],
            'date' => $data['date'],
            'narration' => $data['narration'],
            'voucher_type' => $data['voucher_type'],
            'payment_type' => $data['payment_type'],
        ]);

        foreach ($Voucher->transactions as $key => $transaction) {
            $transaction->delete($transaction->id);
        }

        $Voucher->transactions()->createMany($transactions);
        foreach ($Voucher->transactions as $transaction) {
            if ($transaction->type == 'Cr') {
                $transaction->fromAccounts()->attach($data['sub_account_id']);
            } else {
                $transaction->fromAccounts()->attach($data['account_id']);
            }
        }

        $Voucher->update(['tx_id' => $data['voucher_type'] . '-' . $Voucher->id]);

        return $Voucher->load('transactions');
    }

    public function delete($id)
    {
        $expense = Expense::findOrFail($id);
        $Voucher = $expense->voucher;
        foreach ($Voucher->transactions as $transaction) {
            $transaction->fromAccounts()->detach();
            $transaction->delete();
        }
        $Voucher->delete();

        return $expense->delete();
    }
}
