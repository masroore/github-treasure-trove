<?php

namespace Modules\AdminDashboard\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'menu' => 'dashboard',
            'sub_menu' => 'dashboard',
        ];

        $data['customerCount'] = Customer::get()->count();
        $data['orderCount'] = Order::where('status', '!=', 'completed')->get()->count();
        $data['saleCount'] = Order::where('status', 'completed')->get()->count();
        $data['todayOrder'] = Order::where('created_at', '>=', Carbon::today())->get()->count();
        $data['todayIncome'] = 0;
        if ($data['todayOrder'] > 0) {
            $data['todayIncome'] = OrderProduct::where('created_at', '>=', Carbon::today())->sum('price');
        }
        $data['lastestOrders'] = Order::orderBy('id', 'desc')->take(5)->get();

        return view('admindashboard::index', $data);
    }

    public function getFrequencyData($frequency)
    {
        $orders = OrderProduct::select('id', 'quantity', 'price', 'created_at')
            ->where('status', '!=', 'completed')
            ->whereYear('created_at', date('Y'))
            ->when('Week' == $frequency, function ($query) {
            return $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        })
            ->when('Month' == $frequency, function ($query) {
            return $query->whereMonth('created_at', Carbon::now()->month);
        })
            ->get()
            ->when('Month' == $frequency, function ($query) {
            return $query->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('d'); // grouping by month day
            });
        })
            ->when('Week' == $frequency, function ($query) {
            return $query->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('w'); // grouping by week day
            });
        })
            ->when('Year' == $frequency, function ($query) {
                return $query->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('n'); // grouping by months
                });
            });

        $sales = OrderProduct::select('id', 'quantity', 'price', 'created_at')
            ->where('status', 'completed')
            ->whereYear('created_at', date('Y'))
            ->when('Week' == $frequency, function ($query) {
            return $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        })
            ->when('Month' == $frequency, function ($query) {
            return $query->whereMonth('created_at', Carbon::now()->month);
        })
            ->get()
            ->when('Month' == $frequency, function ($query) {
            return $query->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('d'); // grouping by day
            });
        })
            ->when('Week' == $frequency, function ($query) {
                return $query->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('w'); // grouping by week day
                });
            })
            ->when('Year' == $frequency, function ($query) {
                return $query->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('n'); // grouping by months
                });
            });

        $ordersData = [];
        $salesData = [];

        foreach ($orders as $key => $value) {
            $oTotal = 0;
            foreach ($value as $val) {
                $oTotal += ($val->price * $val->quantity);
            }
            $ordersData[$key] = $oTotal;
        }

        foreach ($sales as $key => $value) {
            $sTotal = 0;
            foreach ($value as $val) {
                $sTotal += ($val->price * $val->quantity);
            }
            $salesData[$key] = $sTotal;
        }

        return response()->json([
            'frequency' => $frequency,
            'totalDaysInMonth' => date('t'),
            'oData' => $ordersData,
            'sData' => $salesData,
        ]);
    }
}
