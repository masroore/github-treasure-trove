<?php

namespace App\Traits;

use App\Charts\DailyProfit;
use App\Charts\MonthlyProfit;
use App\Charts\ProductQuantity;
use App\Charts\SalesChart;
use App\Charts\WeeklyProfit;
use App\Charts\YearlyProfit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\TimePeriodAccount;
use Modules\Account\Repositories\ChartAccountRepository;
use Modules\Report\Repositories\IncomeStatementReportRepository;

trait Dashboard
{
    public function calendarEvents()
    {
        $holidays = $this->holidayRepository->all();

        if (Auth::user()->role->type == 'system_user') {
            $events = $this->eventRepository->all();
        } else {
            $events = $this->eventRepository->roleWiseEvents();
        }

        $calendar_events = [];
        $count_event = 0;
        foreach ($holidays as $k => $holiday) {
            $calendar_events[$k]['title'] = $holiday->name;
            $calendar_events[$k]['url'] = null;
            $calendar_events[$k]['description'] = $holiday->name;

            if ($holiday->type == 0) {
                $calendar_events[$k]['date'] = $holiday->date;
            } else {
                $types = explode(',', $holiday->date);
                $calendar_events[$k]['start'] = $types[0];
                $calendar_events[$k]['end'] = Carbon::parse($types[1])->addDays(1)->format('Y-m-d');
            }
            $count_event = $k;
            ++$count_event;
        }

        foreach ($events as $k => $event) {
            $calendar_events[$count_event]['title'] = $event->title;

            $calendar_events[$count_event]['start'] = $event->from_date;

            $calendar_events[$count_event]['end'] = Carbon::parse($event->to_date)->addDays(1)->format('Y-m-d');
            $calendar_events[$count_event]['description'] = $event->description;
            $calendar_events[$count_event]['url'] = $event->image;

            ++$count_event;
        }

        return $calendar_events;
    }

    public function monthlySales()
    {
        getThemeColor('base_color');
        $yearly_sales = new SalesChart();
        $sales = $this->saleRepository->dailySales();
        $yearly_sales->labels($sales->pluck('day'));
        $yearly_sales->dataset(trans('dashboard.Current Month Sales'), 'line', $sales->pluck('total_sell'))->color(getThemeColor('gradient_1', '#7c32ff'));

        return $yearly_sales;
    }

    public function yearlySales()
    {
        $monthly_sales = new SalesChart();
        $sales = $this->saleRepository->monthlySales();
        $monthly_sales->labels($sales->pluck('month_name'));
        $monthly_sales->dataset(trans('dashboard.Current Year Sales'), 'line', $sales->pluck('total_sell'))->color(getThemeColor('gradient_1', '#7c32ff'));

        return $monthly_sales;
    }

    public function currentShowroom()
    {
        if (session()->get('showroom_id') == 1) {
            $showrooms = $this->showRoomRepository->all();
            $ids = [];
            foreach ($showrooms as $showroom) {
                $ids[] = $showroom->contact->id;
            }
        } else {
            $showroom = $this->showRoomRepository->find(session()->get('showroom_id'));
            $ids = $showroom->contact->id;
        }

        return $ids;
    }

    public function dailyProfit()
    {
        $daily_profit = new DailyProfit();
        $daily_sales = $this->voucherRepository->dailyProfit($this->currentShowroom());
        $daily_profit->labels([Carbon::now()->format('Y-m-d')]);
        $main_amounts = $daily_sales['main_amount']->pluck('sale_amount')->toArray();
        $total_amounts = $daily_sales['total_amount']->pluck('sale_amount')->toArray();
        $daily_profit->dataset(trans('dashboard.Main Amount'), 'bar', $main_amounts)->color(getThemeColor('gradient_1', '#7c32ff'))->backgroundColor(getThemeColor('gradient_1', '#7c32ff'));
        $daily_profit->dataset(trans('dashboard.Sale Amount'), 'bar', $total_amounts)->color(getThemeColor('base_color', '#415094'))->backgroundColor(getThemeColor('base_color', '#415094'));

        return $daily_profit;
    }

    public function weeklyProfit()
    {
        $weeklyProfit = new WeeklyProfit();
        $weekly_sales = $this->voucherRepository->weeklyProfit($this->currentShowroom());
        $weeklyProfit->labels($weekly_sales['main_amount']->pluck('date')->toArray());
        $main_amounts = $weekly_sales['main_amount']->pluck('sale_amount')->toArray();
        $total_amounts = $weekly_sales['total_amount']->pluck('sale_amount')->toArray();
        $weeklyProfit->dataset(trans('dashboard.Main Amount'), 'bar', $main_amounts)->color(getThemeColor('gradient_1', '#7c32ff'))->backgroundColor(getThemeColor('gradient_1', '#7c32ff'));
        $weeklyProfit->dataset(trans('dashboard.Sale Amount'), 'bar', $total_amounts)->color(getThemeColor('base_color', '#415094'))->backgroundColor(getThemeColor('base_color', '#415094'));

        return $weeklyProfit;
    }

    public function monthlyProfit()
    {
        $monthly_profit = new MonthlyProfit();
        $monthly_profit_sales = $this->voucherRepository->monthlyProfit($this->currentShowroom());
        $monthly_profit->labels($monthly_profit_sales['main_amount']->pluck('day')->toArray());
        $main_amounts = $monthly_profit_sales['main_amount']->pluck('sale_amount')->toArray();
        $total_amounts = $monthly_profit_sales['total_amount']->pluck('sale_amount')->toArray();
        $monthly_profit->dataset(trans('dashboard.Main Amount'), 'bar', $main_amounts)->color(getThemeColor('gradient_1', '#7c32ff'))->backgroundColor(getThemeColor('gradient_1', '#7c32ff'));
        $monthly_profit->dataset(trans('dashboard.Sale Amount'), 'bar', $total_amounts)->color(getThemeColor('base_color', '#415094'))->backgroundColor(getThemeColor('base_color', '#415094'));

        return $monthly_profit;
    }

    public function yearlyProfit()
    {
        $monthly_profit = new YearlyProfit();
        $monthly_profit_sales = $this->voucherRepository->yearlyProfit($this->currentShowroom());
        $monthly_profit->labels($monthly_profit_sales['main_amount']->pluck('month_name')->toArray());
        $main_amounts = $monthly_profit_sales['main_amount']->pluck('sale_amount')->toArray();
        $total_amounts = $monthly_profit_sales['total_amount']->pluck('sale_amount')->toArray();
        $monthly_profit->dataset(trans('dashboard.Main Amount'), 'bar', $main_amounts)->color(getThemeColor('gradient_1', '#7c32ff'))->backgroundColor(getThemeColor('gradient_1', '#7c32ff'));
        $monthly_profit->dataset(trans('dashboard.Sale Amount'), 'bar', $total_amounts)->color(getThemeColor('base_color', '#415094'))->backgroundColor(getThemeColor('base_color', '#415094'));

        return $monthly_profit;
    }

    public function productQuantity()
    {
        $quantity = new ProductQuantity();
        $showroom_products = $this->showRoomRepository->all();
        $labels = [];
        foreach ($showroom_products as $key => $showroom) {
            $labels[] = $showroom->name . '(' . $showroom->total_stock . ')';
        }
        $quantity->labels($labels);
        $quantity->dataset(trans('dashboard.ShowRoom Wise Product Quantity'), 'bar', $showroom_products->pluck('total_stock'))->color(getThemeColor('gradient_1', '#7c32ff'))->backgroundColor(getThemeColor('gradient_1', '#7c32ff'));

        return $quantity;
    }

    public function totalBank($type): int
    {
        $chart_account = $this->chartAccountRepository->find(3);
        $total = 0;
        foreach ($chart_account->chart_accounts as $key => $account) {
            $total += $account->getBalanceAmountByDate($type);
        }

        return $total;
    }

    public function totalCash($type): int
    {
        $chart_account = $this->chartAccountRepository->find(1);
        $total = 0;
        foreach ($chart_account->chart_accounts->where('contactable_id', session()->get('showroom_id'))->where('contactable_type', 'Modules\\Inventory\\Entities\\ShowRoom') as $key => $account) {
            $total += $account->getBalanceAmountByDate($type);
        }

        return $total;
    }

    public function totalIncome()
    {
        if (session()->get('showroom_id') == 1) {
            $incomeStatementRepositories = new IncomeStatementReportRepository();
            $total_statement = $incomeStatementRepositories->TransactionBalance(15, 'Cr') - $incomeStatementRepositories->TransactionBalance(19, 'Dr');
            $account = new ChartAccountRepository();
            $accountingPeriod = TimePeriodAccount::where('is_closed', 0)->first();
            $expense_account_list = $account->expenseAccountList($accountingPeriod->id)->whereNotIn('code', ['03-23', '03-19']);
            $total_expense = 0;
            foreach ($expense_account_list as $expense_account) {
                $total_expense += $expense_account->BalanceAmount;
            }
            $income_account_list = $account->incomeAccountList($accountingPeriod->id)->whereNotIn('code', ['04-24', '04-15']);
            $total_income = 0;
            foreach ($income_account_list as $income_account) {
                $total_income += $income_account->BalanceAmount;
            }

            return round($total_statement - $total_expense + $total_income);
        }

        $incomeStatementRepositories = new IncomeStatementReportRepository();
        $total_statement = $incomeStatementRepositories->TransactionBalanceBranch(15, 'Cr') - $incomeStatementRepositories->TransactionBalanceBranch(19, 'Dr');

        return $total_statement;
    }
}
