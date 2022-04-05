<?php

namespace Modules\Account\Repositories;

use Modules\Account\Entities\AccountCategory;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\Document;
use Modules\Account\Entities\Voucher;

class TransferRepository implements TransferRepositoryInterface
{
    public function all()
    {
        return ChartAccount::with('chart_accounts')
            ->where('status', 1)
            ->where('type', 1)
            ->get();
    }

    public function allShowroomAccounts()
    {
        return ChartAccount::with('chart_accounts')
            ->where('contactable_type', 'Modules\Inventory\Entities\ShowRoom')
            ->where('type', 1)
            ->get();
    }

    public function category()
    {
        return AccountCategory::where('name', 'Account for Cash')->orWhere('name', 'Account for Bank')->get();
    }

    public function indexList()
    {
        return Voucher::where('is_transfer', 1)->latest()->get();
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
            'is_transfer' => $data['is_transfer'],
        ]);
        if ($data['cheque_no'] != null && $data['bank_name']) {
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
            'payment_type' => $data['payment_type'],
            'is_approve' => $data['is_approve'],
            'is_transfer' => $data['is_transfer'],
        ]);
        if ($data['cheque_no'] != null && $data['bank_name']) {
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
        }

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
}
