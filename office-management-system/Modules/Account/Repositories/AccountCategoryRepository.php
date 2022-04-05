<?php

namespace Modules\Account\Repositories;

use Modules\Account\Entities\AccountCategory;
use Modules\Account\Entities\ChartAccount;

class AccountCategoryRepository implements AccountCategoryRepositoryInterface
{
    public function all()
    {
        return AccountCategory::all();
    }

    public function create(array $data)
    {
        foreach ($data['account_category_id'] as $acc_cat_id) {
            $acc_cat = AccountCategory::findOrFail($acc_cat_id);
            foreach ($acc_cat->chart_accounts as $chart_account) {
                $chart_account = ChartAccount::findOrFail($chart_account->id);
                $chart_account->configuration_group_id = 0;
                $chart_account->save();
            }
            if ($acc_cat->id == 1) {
                foreach ($data['cash_acc_cat_id'] as $chart_account_id) {
                    $chart_account = ChartAccount::findOrFail($chart_account_id);
                    $chart_account->configuration_group_id = $acc_cat_id;
                    $chart_account->save();
                }
            }
            if ($acc_cat->id == 2) {
                foreach ($data['bank_acc_cat_id'] as $chart_account_id) {
                    $chart_account = ChartAccount::findOrFail($chart_account_id);
                    $chart_account->configuration_group_id = $acc_cat_id;
                    $chart_account->save();
                }
            }
            if ($acc_cat->id == 3) {
                foreach ($data['acc_recievable_id'] as $chart_account_id) {
                    $chart_account = ChartAccount::findOrFail($chart_account_id);
                    $chart_account->configuration_group_id = $acc_cat_id;
                    $chart_account->save();
                }
            }
            if ($acc_cat->id == 4) {
                $chart_account = ChartAccount::findOrFail($data['acc_payable_id']);
                $chart_account->configuration_group_id = $acc_cat_id;
                $chart_account->save();
            }
            if ($acc_cat->id == 5) {
                $chart_account = ChartAccount::findOrFail($data['acc_equity_id']);
                $chart_account->configuration_group_id = $acc_cat_id;
                $chart_account->save();
            }
        }

        return $chart_account;
    }
}
