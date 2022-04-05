<?php

namespace Modules\Account\Repositories;

use Carbon\Carbon;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\OpeningBalanceHistory;
use Modules\Account\Entities\TimePeriodAccount;
use Modules\Account\Entities\TypeOpeningBalance;

class OpeningBalanceHistoryRepository implements OpeningBalanceHistoryRepositoryInterface
{
    public function all()
    {
        return TimePeriodAccount::latest()->get();
    }

    public function activeInterval()
    {
        return TimePeriodAccount::where('end_date', null)->latest()->get();
    }

    public function assetAccountsAll()
    {
        return ChartAccount::where('type', 1)->latest()->get();
    }

    public function liabilityAccountsAll()
    {
        return ChartAccount::where('type', 2)->latest()->get();
    }

    public function create(array $data): void
    {
        $openingBalance = new OpeningBalanceHistory();
        $openingBalance->account_id = $data['account_id'];
        $openingBalance->amount = $data['amount'];
        $openingBalance->date = Carbon::parse($data['date'])->format('Y-m-d');
        $openingBalance->acc_type = $data['type'];
        $openingBalance->save();
    }

    public function find($id)
    {
        return TimePeriodAccount::findOrFail($id);
    }

    public function update(array $data, $id): void
    {
        $timePeriod = TimePeriodAccount::findOrFail($id);
        foreach ($timePeriod->openning_balance_histories as $history) {
            $history->delete($history->id);
        }
        foreach ($data['asset_account_id'] as $key => $asset) {
            $openingBalance = new OpeningBalanceHistory();
            $openingBalance->account_id = $data['asset_account_id'][$key];
            $openingBalance->time_period_account_id = $id;
            $openingBalance->amount = $data['asset_amount'][$key];
            $openingBalance->date = Carbon::parse($data['date'])->format('Y-m-d');
            $openingBalance->acc_type = 'asset';
            $openingBalance->save();
        }
        foreach ($data['liability_account_id'] as $k => $asset) {
            $openingBalance = new OpeningBalanceHistory();
            $openingBalance->account_id = $data['liability_account_id'][$k];
            $openingBalance->time_period_account_id = $id;
            $openingBalance->amount = $data['liability_amount'][$k];
            $openingBalance->date = Carbon::parse($data['date'])->format('Y-m-d');
            $openingBalance->acc_type = 'liability';
            $openingBalance->save();
        }
    }

    public function closeStatement($id): void
    {
        $timePeriod = TimePeriodAccount::findOrFail($id);
        $timePeriod->end_date = Carbon::now()->toDateTimeString();
        $timePeriod->is_closed = '1';
        $timePeriod->save();
    }

    public function createForUser(array $data): void
    {
        if (!empty($data['asset_account_id'])) {
            $openingBalance = new OpeningBalanceHistory();
            $openingBalance->account_id = $data['asset_account_id'];
            $openingBalance->amount = $data['asset_amount'];
            $openingBalance->date = Carbon::parse($data['date'])->format('Y-m-d');
            $openingBalance->acc_type = 'asset';
            $openingBalance->save();
        }
        if ($data['liability_account_id']) {
            $openingBalance = new OpeningBalanceHistory();
            $openingBalance->account_id = $data['liability_account_id'];
            $openingBalance->amount = $data['liability_amount'];
            $openingBalance->date = Carbon::parse($data['date'])->format('Y-m-d');
            $openingBalance->acc_type = 'liability';
            $openingBalance->save();
        }
    }

    public function createForHistory(array $data): void
    {
        $history = new TypeOpeningBalance();
        $history->account_id = $data['account_id'];
        $history->type = $data['type'];
        $history->amount = $data['amount'];
        $history->save();
    }

    public function individualUpdate(array $data, $id): void
    {
        foreach ($data as $key => $asset) {
            if ($asset['acc_type'] == 'asset') {
                $openingBalance = new OpeningBalanceHistory();
                $openingBalance->account_id = $asset['asset_account_id'];
                $openingBalance->time_period_account_id = $id;
                $openingBalance->amount = $asset['asset_amount'];
                $openingBalance->date = $asset['date'];
                $openingBalance->is_default = $asset['is_default'];
                $openingBalance->acc_type = $asset['acc_type'];
                $openingBalance->save();
            } else {
                $openingBalance = new OpeningBalanceHistory();
                $openingBalance->account_id = $asset['liability_account_id'];
                $openingBalance->time_period_account_id = $id;
                $openingBalance->amount = $asset['liability_amount'];
                $openingBalance->date = $asset['date'];
                $openingBalance->is_default = $asset['is_default'];
                $openingBalance->acc_type = $asset['acc_type'];
                $openingBalance->save();
            }
        }
    }

    public function OpeningBalanceHistory($timePeriod = null)
    {
        if ($timePeriod != null) {
            return OpeningBalanceHistory::where('time_period_account_id', $timePeriod)->get();
        }
    }

    public function closedBalanceList($is_default, $date)
    {
        if ($date != null) {
            return OpeningBalanceHistory::where('is_default', true)
                ->whereDate('date', $date)
                ->latest()->get();
        }
    }
}
