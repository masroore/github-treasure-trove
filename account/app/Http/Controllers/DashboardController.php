<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\Bill;
use App\Goal;
use App\Invoice;
use App\LandingPageSection;
use App\Order;
use App\Payment;
use App\Plan;
use App\ProductServiceCategory;
use App\ProductServiceUnit;
use App\Revenue;
use App\Tax;
use App\Utility;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            if ('super admin' == \Auth::user()->type) {
                $user = \Auth::user();
                $user['total_user'] = $user->countCompany();
                $user['total_paid_user'] = $user->countPaidCompany();
                $user['total_orders'] = Order::total_orders();
                $user['total_orders_price'] = Order::total_orders_price();
                $user['total_plan'] = Plan::total_plan();
                $user['most_purchese_plan'] = (!empty(Plan::most_purchese_plan()) ? Plan::most_purchese_plan()->total : 0);
                $chartData = $this->getOrderChart(['duration' => 'week']);

                return view('dashboard.super_admin', compact('user', 'chartData'));
            }

            if (\Auth::user()->can('show dashboard')) {
                $data['latestIncome'] = Revenue::where('created_by', '=', \Auth::user()->creatorId())->orderBy('id', 'desc')->limit(5)->get();
                $data['latestExpense'] = Payment::where('created_by', '=', \Auth::user()->creatorId())->orderBy('id', 'desc')->limit(5)->get();

                $incomeCategory = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 1)->get();
                $inColor = [];
                $inCategory = [];
                $inAmount = [];
                for ($i = 0; $i < \count($incomeCategory); $i++) {
                    $inColor[] = '#' . $incomeCategory[$i]->color;
                    $inCategory[] = $incomeCategory[$i]->name;
                    $inAmount[] = $incomeCategory[$i]->incomeCategoryRevenueAmount();
                }

                $data['incomeCategoryColor'] = $inColor;
                $data['incomeCategory'] = $inCategory;
                $data['incomeCatAmount'] = $inAmount;

                $expenseCategory = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 2)->get();
                $exColor = [];
                $exCategory = [];
                $exAmount = [];
                for ($i = 0; $i < \count($expenseCategory); $i++) {
                    $exColor[] = '#' . $expenseCategory[$i]->color;
                    $exCategory[] = $expenseCategory[$i]->name;
                    $exAmount[] = $expenseCategory[$i]->expenseCategoryAmount();
                }

                $data['expenseCategoryColor'] = $exColor;
                $data['expenseCategory'] = $exCategory;
                $data['expenseCatAmount'] = $exAmount;

                $data['incExpBarChartData'] = \Auth::user()->getincExpBarChartData();
                $data['incExpLineChartData'] = \Auth::user()->getIncExpLineChartDate();

                $data['currentYear'] = date('Y');
                $data['currentMonth'] = date('M');

                $constant['taxes'] = Tax::where('created_by', \Auth::user()->creatorId())->count();
                $constant['category'] = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())->count();
                $constant['units'] = ProductServiceUnit::where('created_by', \Auth::user()->creatorId())->count();
                $constant['bankAccount'] = BankAccount::where('created_by', \Auth::user()->creatorId())->count();
                $data['constant'] = $constant;
                $data['bankAccountDetail'] = BankAccount::where('created_by', '=', \Auth::user()->creatorId())->get();
                $data['recentInvoice'] = Invoice::where('created_by', '=', \Auth::user()->creatorId())->orderBy('id', 'desc')->limit(5)->get();
                $data['weeklyInvoice'] = \Auth::user()->weeklyInvoice();
                $data['monthlyInvoice'] = \Auth::user()->monthlyInvoice();
                $data['recentBill'] = Bill::where('created_by', '=', \Auth::user()->creatorId())->orderBy('id', 'desc')->limit(5)->get();
                $data['weeklyBill'] = \Auth::user()->weeklyBill();
                $data['monthlyBill'] = \Auth::user()->monthlyBill();
                $data['goals'] = Goal::where('created_by', '=', \Auth::user()->creatorId())->where('is_display', 1)->get();
            } else {
                $data = [];
            }

            return view('dashboard.index', $data);
        }

        if (!file_exists(storage_path() . '/installed')) {
            header('location:install');
            exit;
        }

        $settings = Utility::settings();
        if ('on' == $settings['display_landing_page']) {
            $plans = Plan::get();
            $get_section = LandingPageSection::orderBy('section_order', 'ASC')->get();

            return view('layouts.landing', compact('plans', 'get_section'));
        }

        return redirect('login');
    }

    public function getOrderChart($arrParam)
    {
        $arrDuration = [];
        if ($arrParam['duration']) {
            if ('week' == $arrParam['duration']) {
                $previous_week = strtotime('-2 week +1 day');
                for ($i = 0; $i < 14; $i++) {
                    $arrDuration[date('Y-m-d', $previous_week)] = date('d-M', $previous_week);
                    $previous_week = strtotime(date('Y-m-d', $previous_week) . ' +1 day');
                }
            }
        }

        $arrTask = [];
        $arrTask['label'] = [];
        $arrTask['data'] = [];
        foreach ($arrDuration as $date => $label) {
            $data = Order::select(\DB::raw('count(*) as total'))->whereDate('created_at', '=', $date)->first();
            $arrTask['label'][] = $label;
            $arrTask['data'][] = $data->total;
        }

        return $arrTask;
    }
}
