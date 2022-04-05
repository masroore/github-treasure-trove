<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Shop\Order;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home(Request $request)
    {
        $this->authorize('dashboard.home.read');

        $orders = Order::with('txStatus', 'products')->withCount('products')
            ->whereNotNull('ordered_at')
            ->where('type', Order::TYPE_ORDER)
            ->orderBy('id', 'desc')->limit(15)->get();

        $dateStart = \Carbon\Carbon::now()->subDays($request->get('sub_days', 30));
        $dateEnd = \Carbon\Carbon::now();

        $chartOrders = Order::whereNotNull('ordered_at')->where(function ($o): void {
            $o->where('status', 'order_new')
                ->orWhere('status', 'order_accept');
        })->where(function ($o) use ($dateStart, $dateEnd): void {
            $o->whereDate('created_at', '>=', $dateStart)->whereDate('created_at', '<=', $dateEnd);
        })
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(status) as amount'), 'status')
            ->groupBy('date', 'status')
            ->orderBy('date', 'asc')
            ->get();

        $chartData = [];
        while ($dateStart->lt($dateEnd)) {
            $order = $chartOrders->where('date', $dateStart->format('Y-m-d'));
            $chartData[] = [
                'y' => $dateStart->toDateString(),
                'new' => optional($order->where('status', 'order_new')->first())->amount ?? 0,
                'success' => optional($order->where('status', 'order_accept')->first())->amount ?? 0,
            ];
            $dateStart->addDay();
        }

        $orderNewCount = Order::whereNotNull('ordered_at')->where('status', 'order_new')->count();
        $orderAcceptCount = Order::whereNotNull('ordered_at')->where('status', 'order_accept')->count();
        $clientCount = User::role('client')->count();
        $webFormCount = Form::where('status', Form::STATUS_NEW)->count();

        $chartData = [
            'data' => $chartData,
            'labels' => ['Новые', 'Подтвержденные'],
        ];

        return view('admin.home', compact('orders', 'chartData', 'orderNewCount', 'orderAcceptCount', 'clientCount', 'webFormCount'));
    }
}
