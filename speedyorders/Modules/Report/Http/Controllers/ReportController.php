<?php

namespace Modules\Report\Http\Controllers;

use App\Models\Agent;
use App\Models\AirlineCarrier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdminTicket\Exports\TicketsExport;
use Modules\Report\Exports\StatementExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'menu' => 'report',
            'sub_menu' => 'sales',
        ];

        $data['airlines'] = AirlineCarrier::all();
        $data['agents'] = Agent::where('status', '1')->get();

        if ($request->has('exportTicket')) {
            if (null == $request->get('from_date') || null == $request->get('to_date')) {
                session()->flash('error_message', 'Please provide Date Range.');

                return redirect()->route('admin.reports.index');
            }

            if (Carbon::parse($request->get('from_date'))->format('Y-m-d') > Carbon::parse($request->get('to_date'))->format('Y-m-d')) {
                session()->flash('error_message', 'Invalid Date Range. Please check From Date and To Date.');

                return redirect()->route('admin.reports.index');
            }

            $from_date = Carbon::parse($request->get('from_date'));
            $to_date = Carbon::parse($request->get('to_date'));
            if ($to_date->diffInMonths($from_date) > 2) {
                session()->flash('error_message', 'Maximum 3 months allowed. Please generate partial reports.');

                return redirect()->route('admin.reports.index');
            }

            return (new TicketsExport($request))->download('ticket-' . date('Y-m-d') . '-' . time() . '.xlsx');
        }

        return view('report::index', $data);
    }

    public function statements(Request $request)
    {
        $data = [
            'menu' => 'report',
            'sub_menu' => 'statement',
        ];

        $data['agents'] = Agent::where('status', '1')->get();

        if ($request->has('exportTicket')) {
            if (null == $request->get('from_date') || null == $request->get('to_date')) {
                session()->flash('error_message', 'Please provide Date Range.');

                return redirect()->route('admin.reports.statements');
            }

            if (Carbon::parse($request->get('from_date'))->format('Y-m-d') > Carbon::parse($request->get('to_date'))->format('Y-m-d')) {
                session()->flash('error_message', 'Invalid Date Range. Please check From Date and To Date.');

                return redirect()->route('admin.reports.statements');
            }

            $from_date = Carbon::parse($request->get('from_date'));
            $to_date = Carbon::parse($request->get('to_date'));
            if ($to_date->diffInMonths($from_date) > 2) {
                session()->flash('error_message', 'Maximum 3 months allowed. Please generate partial reports.');

                return redirect()->route('admin.reports.statements');
            }

            return (new StatementExport($request))->download('statement-' . date('Y-m-d') . '-' . time() . '.xlsx');
        }

        return view('report::statements', $data);
    }
}
