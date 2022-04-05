<?php

namespace App\Models\Back;

use App\Models\Back\Orders\OrderStats;
use App\Models\Back\Product\ProductStats;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{
    /**
     * Set data for chart footer widgets.
     *
     * @param $data
     *
     * @return array
     */
    public function setWidgetsData($data)
    {
        $total_sum = 0;
        $avg = 0;
        $min = $data[0] ?? 0;
        $max = $data[0] ?? 0;

        if (isset($data[0])) {
            foreach ($data as $amount) {
                if (0 != $amount && $min > $amount) {
                    $min = $amount;
                }

                if ($max < $amount) {
                    $max = $amount;
                }

                $total_sum = $total_sum + $amount;
            }

            $avg = $total_sum / \count($data);
        }

        return [
            'total' => [
                'label' => __('layout.charts.total'),
                'data' => number_format($total_sum, 2, ',', '.'),
            ],
            'avg' => [
                'label' => __('layout.charts.avg'),
                'data' => number_format($avg, 2, ',', '.'),
            ],
            'min' => [
                'label' => __('layout.charts.min'),
                'data' => number_format($min, 2, ',', '.'),
            ],
            'max' => [
                'label' => __('layout.charts.max'),
                'data' => number_format($max, 2, ',', '.'),
            ],
        ];
    }

    /**
     * Return chart dropdown menu presets links.
     *
     * @return array
     */
    public function setPresetsData()
    {
        return [
            0 => [
                'label' => __('layout.charts.yearly'),
                'data' => 'y',
            ],
            1 => [
                'label' => __('layout.charts.current_year'),
                'data' => 'Y',
            ],
            2 => [
                'label' => __('layout.charts.current_month'),
                'data' => 'M',
            ],
            3 => [
                'label' => __('layout.charts.today'),
                'data' => 'T',
            ],
        ];
    }

    /**
     * Return Pie info data.
     *
     * @param $data
     * @param $column
     *
     * @return array
     */
    public function getPieWidgets($data, $column)
    {
        $widgets = [];

        if ('gender' == $column) {
            $widgets = [
                'title' => __('user.chart_gender_title'),
                'subtitle' => __('user.chart_gender_subtitle'),
                'count' => \count($data),
            ];
        } elseif ('birth_date' == $column) {
            $widgets = [
                'title' => __('user.chart_age_title'),
                'subtitle' => __('user.chart_age_subtitle'),
                'count' => \count($data),
            ];
        }

        return $widgets;
    }

    /**
     * Return stotistics totals.
     *
     * @return array
     */
    public static function total()
    {
        return [
            'products' => ProductStats::count(),
            //'actions'  => ProductStats::actionsCount(),
            'orders' => OrderStats::count(),
            'users' => [
                'qty' => User::where('status', 1)->count(),
                'href' => route('users'),
                'label' => 'Korisnici',
                'icon' => 'si si-user',
            ],
        ];
    }
}
