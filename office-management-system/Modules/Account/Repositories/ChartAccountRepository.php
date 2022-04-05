<?php

namespace Modules\Account\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\TimePeriodAccount;

class ChartAccountRepository implements ChartAccountRepositoryInterface
{
    public function parentNullAccountList()
    {
        return ChartAccount::whereNull('parent_id')
            ->with('childrenCategories', 'transactions')
            ->with('childrenCategories.transactions')
            ->latest()
            ->get();
    }

    public function parent_category()
    {
        return ChartAccount::with('chart_accounts')
            ->where('parent_id', null)
            ->orWhere('is_group', 1)
            ->latest()
            ->get();
    }

    public function parent_all()
    {
        return ChartAccount::with('chart_accounts')
            ->where('parent_id', null)
            ->where('status', 1)
            ->latest()
            ->get();
    }

    public function all($start_date = null, $end_date = null)
    {
        if ($start_date == null) {
            return ChartAccount::latest()->get();
        }

        return ChartAccount::wherehas('transactions', function ($query) use ($start_date, $end_date): void {
            $query->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        })->with(['transactions' => function ($query) use ($start_date, $end_date): void {
            $query->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        }])->latest()->get();
    }

    public function getAllContacts()
    {
        return ChartAccount::where('contactable_type', 'Modules\Contact\Entities\ContactModel')->latest()->get();
    }

    public function getFirst($type, $id)
    {
        return ChartAccount::where('contactable_type', $type)
            ->where('contactable_id', $id)
            ->first();
    }

    public function create(array $data)
    {
        $charAccount = new ChartAccount();

        if (isset($data['as_sub_category']) && $data['as_sub_category'] == 1) {
            $parent_account = $this->find($data['parent_id']);
            $data = Arr::add($data, 'level', $parent_account ? ($parent_account->level + 1) : 1);
            $data = Arr::add($data, 'parent_id', $data['parent_id']);
            $data = Arr::set($data, 'type', $parent_account ? $parent_account->type : $data['type']);
        } else {
            $data = Arr::add($data, 'level', 1);
            $data = Arr::set($data, 'parent_id', null);
        }
        $charAccount->fill($data)->save();
        if (isset($data['as_sub_category'])) {
            $parent_account = $this->find($data['parent_id']);
            $charAccount->update([
                'type' => $parent_account ? $parent_account->type : $data['type'],
                'code' => $parent_account ? ($parent_account->code . '-' . leadingZeroTwo($charAccount->id)) : leadingZeroTwo($charAccount->id),
            ]);
        } else {
            $charAccount->update([
                'code' => '0' . $data['type'] . '-' . leadingZeroTwo($charAccount->id),
            ]);
        }

        return $charAccount;
    }

    public function find($id)
    {
        return ChartAccount::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $charAccount = ChartAccount::findOrFail($id);
        if (isset($data['as_sub_category']) && $data['as_sub_category'] == 1) {
            $data = Arr::add($data, 'parent_id', $data['parent_id']);
        } else {
            $data = Arr::set($data, 'parent_id', null);
        }

        return $charAccount->update($data);
    }

    public function delete($id)
    {
        return ChartAccount::findOrFail($id)->delete();
    }

    public function incomeAccounts()
    {
        return ChartAccount::IncomeAccounts()->latest()->get();
    }

    public function getPaymentAccountList()
    {
        $accountList = ChartAccount::where('is_group', 0)->latest()->get();

        $filteredList = $accountList->filter(function ($account, $key) {
            return in_array($account->configuration_group_id, [1, 2]) ? false : true;
        });

        return $filteredList->all();

        $finalList = $accountList->where('configuration_group_id', '!=', 1);

        return $finalList->merge($finalList->where('configuration_group_id', '!=', 2));
    }

    public function expenseAccountList($timePeriod = null)
    {
        if ($timePeriod == null) {
            ChartAccount::with('transactions')->where('type', 3)->where('is_group', 0)->latest()->get();
        }
        $accountingPeriod = TimePeriodAccount::findOrFail($timePeriod);
        if ($accountingPeriod->is_closed == 0) {
            $last_date = Carbon::now()->endOfDay()->toDateTimeString();

            return ChartAccount::where('type', 3)->wherehas('transactions', function ($query) use ($accountingPeriod, $last_date): void {
                $query->whereBetween('created_at', [$accountingPeriod->start_date . ' 00:00:00', $last_date]);
            })->with(['transactions' => function ($query) use ($accountingPeriod, $last_date): void {
                $query->whereBetween('created_at', [$accountingPeriod->start_date . ' 00:00:00', $last_date]);
            }])->get();
        } else {
            return ChartAccount::where('type', 3)->wherehas('transactions', function ($query) use ($accountingPeriod): void {
                $query->whereBetween('created_at', [$accountingPeriod->start_date . ' 00:00:00', $accountingPeriod->end_date . ' 23:59:59']);
            })->with(['transactions' => function ($query) use ($accountingPeriod): void {
                $query->whereBetween('created_at', [$accountingPeriod->start_date . ' 00:00:00', $accountingPeriod->end_date . ' 23:59:59']);
            }])->get();
        }
    }

    public function incomeAccountList($timePeriod = null)
    {
        if ($timePeriod == null) {
            ChartAccount::with('transactions')->where('type', 4)->where('is_group', 0)->get();
        }

        $accountingPeriod = TimePeriodAccount::findOrFail($timePeriod);
        if ($accountingPeriod->is_closed == 0) {
            $last_date = Carbon::now()->endOfDay()->toDateTimeString();

            return ChartAccount::where('type', 4)->wherehas('transactions', function ($query) use ($accountingPeriod, $last_date): void {
                $query->whereBetween('created_at', [$accountingPeriod->start_date . ' 00:00:00', $last_date]);
            })->with(['transactions' => function ($query) use ($accountingPeriod, $last_date): void {
                $query->whereBetween('created_at', [$accountingPeriod->start_date . ' 00:00:00', $last_date]);
            }])->get();
        } else {
            return ChartAccount::where('type', 4)->wherehas('transactions', function ($query) use ($accountingPeriod): void {
                $query->whereBetween('created_at', [$accountingPeriod->start_date . ' 00:00:00', $accountingPeriod->end_date . ' 23:59:59']);
            })->with(['transactions' => function ($query) use ($accountingPeriod): void {
                $query->whereBetween('created_at', [$accountingPeriod->start_date . ' 00:00:00', $accountingPeriod->end_date . ' 23:59:59']);
            }])->get();
        }
    }

    public function incomeAccountByDate($form_date, $to_date)
    {
        return ChartAccount::where('type', 4)->wherehas('transactions', function ($query) use ($form_date, $to_date): void {
            $query->whereBetween('created_at', [$form_date . ' 00:00:00', $to_date . ' 23:59:59']);
        })->with(['transactions' => function ($query) use ($form_date, $to_date): void {
            $query->whereBetween('created_at', [$form_date . ' 00:00:00', $to_date . ' 23:59:59']);
        }])->get();
    }

    public function expenseAccountByDate($form_date, $to_date)
    {
        return ChartAccount::where('type', 3)->wherehas('transactions', function ($query) use ($form_date, $to_date): void {
            $query->whereBetween('created_at', [$form_date . ' 00:00:00', $to_date . ' 23:59:59']);
        })->with(['transactions' => function ($query) use ($form_date, $to_date): void {
            $query->whereBetween('created_at', [$form_date . ' 00:00:00', $to_date . ' 23:59:59']);
        }])->get();
    }

    public function assetAccountList($timePeriod = null)
    {
        if ($timePeriod == null) {
            ChartAccount::with('transactions')->where('type', 1)->where('is_group', 0)->get();
        }
        $accountingPeriod = TimePeriodAccount::findOrFail($timePeriod);
        if ($accountingPeriod->is_closed == 0) {
            $last_date = Carbon::now()->endOfDay()->toDateTimeString();

            return ChartAccount::whereBetween('type', 1)->wherehas('transactions', function ($query) use ($accountingPeriod, $last_date): void {
                $query->whereBetween('created_at', '>=', $accountingPeriod->start_date . ' 00:00:00', $last_date);
            })->with(['transactions' => function ($query) use ($accountingPeriod, $last_date): void {
                $query->whereBetween('created_at', [$accountingPeriod->start_date . ' 00:00:00', $last_date]);
            }])->get();
        } else {
            return ChartAccount::where('type', 1)->wherehas('transactions', function ($query) use ($accountingPeriod): void {
                $query->whereBetween('created_at', [$accountingPeriod->start_date . ' 00:00:00', $accountingPeriod->end_date . ' 23:59:59']);
            })->with(['transactions' => function ($query) use ($accountingPeriod): void {
                $query->whereBetween('created_at', [$accountingPeriod->start_date . ' 00:00:00', $accountingPeriod->end_date . ' 23:59:59']);
            }])->get();
        }
    }

    public function liabilityAccountList($timePeriod = null)
    {
        if ($timePeriod == null) {
            ChartAccount::with('transactions')->where('type', 2)->where('is_group', 0)->get();
        }
        $accountingPeriod = TimePeriodAccount::findOrFail($timePeriod);
        if ($accountingPeriod->is_closed == 0) {
            $last_date = Carbon::now()->endOfDay()->toDateTimeString();

            return ChartAccount::where('type', 2)->wherehas('transactions', function ($query) use ($accountingPeriod): void {
                $query->where('created_at', '>=', $accountingPeriod->start_date . ' 00:00:00');
            })->with(['transactions' => function ($query) use ($accountingPeriod, $last_date): void {
                $query->whereBetween('created_at', [$accountingPeriod->start_date . ' 00:00:00', $last_date]);
            }])->get();
        } else {
            return ChartAccount::where('type', 2)->wherehas('transactions', function ($query) use ($accountingPeriod): void {
                $query->whereBetween('created_at', [$accountingPeriod->start_date . ' 00:00:00', $accountingPeriod->end_date . ' 23:59:59']);
            })->with(['transactions' => function ($query) use ($accountingPeriod): void {
                $query->whereBetween('created_at', [$accountingPeriod->start_date . ' 00:00:00', $accountingPeriod->end_date . ' 23:59:59']);
            }])->get();
        }
    }

    public function dailyExpense($date)
    {
        return ChartAccount::where('type', 3)->wherehas('transactions', function ($query) use ($date): void {
            $query->whereDate('created_at', $date);
        })->get();
    }

    public function dailyIncome($date)
    {
        return ChartAccount::with(['transactions' => function ($q) use ($date): void {
            $q->whereDate('created_at', $date);
        }])->where('type', 4)->wherehas('transactions')->get();

        return ChartAccount::where('type', 4)->wherehas('transactions', function ($query) use ($date): void {
            $query->whereDate('created_at', $date);
        })->get();
    }

    public function rename_account(array $data)
    {
        $charAccount = ChartAccount::findOrFail($data['account_id']);

        return $charAccount->update($data);
    }
}
