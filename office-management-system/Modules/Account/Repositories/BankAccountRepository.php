<?php

namespace Modules\Account\Repositories;

use Carbon\Carbon;
use Importer;
use Modules\Account\Entities\BankAccount;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\TimePeriodAccount;

class BankAccountRepository implements BankAccountRepositoryInterface
{
    public function all($start_date = null, $end_date = null)
    {
        if ($start_date == null) {
            return BankAccount::with('chartAccount')->latest()->get();
        }

        return BankAccount::with('chartAccount')->wherehas('transactions', function ($query) use ($start_date, $end_date): void {
            $query->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        })->with(['transactions' => function ($query) use ($start_date, $end_date): void {
            $query->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        }])->latest()->get();
    }

    public function create(array $data): void
    {
        $chart_account = new ChartAccount();
        $chart_account->level = 2;
        $chart_account->is_group = 0;
        $chart_account->name = $data['bank_name'];
        $chart_account->type = 1; // asset
        $chart_account->parent_id = 3;
        $chart_account->status = $data['status'];
        $chart_account->configuration_group_id = 2;
        $chart_account->save();

        $bankAccount = new BankAccount();
        $bankAccount->chart_account_id = $chart_account->id;
        $bankAccount->bank_name = !empty($data['bank_name']) ? $data['bank_name'] : '';
        $bankAccount->branch_name = !empty($data['branch_name']) ? $data['branch_name'] : '';
        $bankAccount->account_name = !empty($data['account_name']) ? $data['account_name'] : '';
        $bankAccount->account_no = !empty($data['account_no']) ? $data['account_no'] : '';
        $bankAccount->description = !empty($data['description']) ? $data['description'] : '';
        $bankAccount->save();
        $chart_account->update(['code' => '03-' . $chart_account->id]);
    }

    public function find($id)
    {
        return BankAccount::with('transactions')->findOrFail($id);
    }

    public function update(array $data): void
    {
        $bankAccount = BankAccount::find($data['id']);
        $bankAccount->bank_name = !empty($data['bank_name']) ? $data['bank_name'] : '';
        $bankAccount->branch_name = !empty($data['branch_name']) ? $data['branch_name'] : '';
        $bankAccount->account_name = !empty($data['account_name']) ? $data['account_name'] : '';
        $bankAccount->account_no = !empty($data['account_no']) ? $data['account_no'] : '';
        $bankAccount->description = !empty($data['description']) ? $data['description'] : '';
        $bankAccount->save();

        $bankAccount->chartAccount()->update(['name' => $data['bank_name'], 'status' => $data['status']]);
    }

    public function delete($id)
    {
        $bankAccount = BankAccount::find($id);
        ChartAccount::destroy($bankAccount->chart_account_id);

        return $bankAccount->delete();
    }

    public function csv_upload_bank_account($data): void
    {
        if (!empty($data['file'])) {
            ini_set('max_execution_time', 0);
            $a = $data['file']->getRealPath();
            $column_name = Importer::make('Excel')->load($a)->getCollection()->take(1)->first();
            foreach (Importer::make('Excel')->load($a)->getCollection()->skip(1) as $ke => $row) {
                $bankAccount = BankAccount::create([
                    $column_name[0] => $row[0],
                    $column_name[1] => $row[1],
                    $column_name[2] => $row[2],
                    $column_name[3] => $row[3],
                    $column_name[4] => $row[4],
                    $column_name[5] => $row[5],
                ]);
                $chart_account = ChartAccount::create([
                    'level' => 2,
                    'configuration_group_id' => 2,
                    'is_group' => 0,
                    'name' => $bankAccount->bank_name,
                    'type' => 1,
                    'parent_id' => 3,
                    'status' => 1,
                    'contactable_id' => $bankAccount->id,
                    'contactable_type' => 'Modules\Account\Entities\BankAccount',
                ]);
                $chart_account->update([
                    'code' => '03-' . $chart_account->id,
                ]);

                $bankAccount->chart_account_id = $chart_account->id;
                $bankAccount->save();

                $this->create_chart_account($bankAccount, $chart_account);
            }
        }
    }

    public function create_chart_account($bankAccount, $chart_account): void
    {
        if ($bankAccount->openning_balance != null && $bankAccount->openning_balance > 0) {
            $repo = new OpeningBalanceHistoryRepository();
            $repo->createForUser([
                'asset_account_id' => $chart_account->id,
                'asset_amount' => $bankAccount->openning_balance,
                'date' => Carbon::now()->format('Y-m-d'),
                'time_period_id' => TimePeriodAccount::where('is_closed', 0)->latest()->first()->id,
                'liability_account_id' => ChartAccount::where('code', '02-09-11')->first()->id,
                'liability_amount' => $bankAccount->openning_balance,
            ]);
            $repo->createForHistory([
                'account_id' => $chart_account->id,
                'type' => 'bank',
                'amount' => $bankAccount->openning_balance,
            ]);
        }
    }
}
