<?php

namespace Vanguard\Http\Controllers\Web;

use Carbon\Carbon;
use DB;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Vanguard\Charts\MonthlyIncomeChart;
use Vanguard\Customer;
use Vanguard\Estimate;
use Vanguard\EstimateStatus;
use Vanguard\EstimateTracking;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Invoice;
use Vanguard\WorkOrder;

class DashboardController extends Controller
{
    /**
     * Displays the application dashboard.
     *
     * @return Factory|View
     */
    public function index()
    {
        if (session()->has('verified')) {
            session()->flash('success', __('E-Mail verified successfully.'));
        }

        $estimates = Estimate::where('companyId', Auth()->user()->companyId)->orderBy('status')->get();

        $workorders = WorkOrder::where('companyId', Auth()->user()->companyId)->get();

        $invoices = Customer::where('companyId', Auth()->user()->companyId)->whereHas('invoice', function ($q): void {
            $q->where('status', '<=', 2);
            $q->where('status', '!=', 98);
        })->get();
        //TODO must figure out how to add tip functionality.
        $invoiceYTD = Invoice::whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])
            ->where('companyId', Auth()->user()->companyId)
            ->where('status', '!=', 98)
            ->get();

        $invoiceTotal = $invoiceYTD->sum('total');
        $invoiceOutstanding = $invoiceTotal - $invoiceYTD->sum('totalPaid');
        $leads = count($estimates->where('status', 0));
        $leadPercent = ($leads ?? 0) / 10 * 100;
        $estimate = count($estimates->where('status', 1));
        $workorder = count($workorders->where('status', '<', 8));
        $unpaidInvoices = count($invoiceYTD->where('status', 1));

        $estimateHistory = EstimateTracking::whereHas('estimate', function ($q): void {
                $q->where('companyId', Auth()->user()->companyId);
            })
                ->orderBy('created_at', 'desc')->take('10')->get();

        $estimateStatus = EstimateStatus::get();
        $start = Carbon::now()->startOfYear();
        $end = Carbon::now()->endOfYear();
        $invoiceChart = Invoice::whereBetween('dateofService', [$start, $end])
                ->where('companyId', Auth()->user()->companyId)
                ->groupBy(DB::raw('monthname(dateofService)'))
                ->orderBy(DB::raw('month(dateofService)'))
                ->get([DB::raw('SUM(totalPaid) as count'), DB::raw('monthname(dateofService) as date')])->pluck('date', 'count');

        $chart = new MonthlyIncomeChart();
        $chart->labels($invoiceChart->values())
            ->dataset('Income', 'bar', $invoiceChart->keys())->options(
                [
                    'backgroundColor' => '#ff9e27',

                ]
            );

        return view('dashboard.dashboard', compact('estimates', 'workorders', 'invoices', 'estimateStatus', 'invoiceYTD', 'invoiceTotal', 'invoiceOutstanding', 'leads', 'leadPercent', 'estimate', 'workorder', 'unpaidInvoices', 'estimateHistory', 'invoiceChart', 'invoiceTotal', 'chart'));
    }

    public function manage()
    {
        if (session()->has('verified')) {
            session()->flash('success', __('E-Mail verified successfully.'));
        }

        $estimates = Estimate::where('companyId', Auth()->user()->companyId)->get();

        $workorders = WorkOrder::where('companyId', Auth()->user()->companyId)->get();

        $invoices = Invoice::where('companyId', Auth()->user()->companyId)
                ->where('status', 1)
                ->get();

        $invoiceYTD = Invoice::whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])
            ->where('companyId', Auth()->user()->companyId)
            ->get();

        $estimateStatus = EstimateStatus::get();

        return view('dashboard.index', compact('estimates', 'workorders', 'invoices', 'estimateStatus', 'invoiceYTD'));
    }
}
