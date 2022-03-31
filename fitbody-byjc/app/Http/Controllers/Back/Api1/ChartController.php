<?php

namespace App\Http\Controllers\Back\Api1;

use App\Http\Controllers\Controller;
use App\Models\Back\Chart;
use App\Models\Back\Orders\OrderStats;
use App\Models\Back\Product\ProductStats;
use App\Models\Back\Stats;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    /**
     * @var Chart
     */
    protected $chart;

    /**
     * ChartController constructor.
     */
    public function __construct()
    {
        $this->chart = new Chart();
    }

    /**
     * Get orders chart data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function orders(Request $request)
    {
        $orders = OrderStats::getChartData($request);

        return response()->json(
            $this->chart->setBarChartData($orders, 'total')
        );
    }

    /**
     * Get orders chart data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ordersStatus(Request $request)
    {
        return response()->json(
            OrderStats::getStatusPieChartData($request, 'order_status_id')
        );
    }

    /**
     * Get products chart data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function products(Request $request)
    {
        $products = ProductStats::getChartData($request);

        return response()->json(
            $this->chart->setHorizontalBarChartData($products, 'total')
        );
    }

    /**
     * Get stats totals.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function totals()
    {
        return response()->json(
            Stats::total()
        );
    }
}
