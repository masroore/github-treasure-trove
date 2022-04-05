<?php

namespace App\Http\Controllers\Admin;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController
{
    public function index()
    {
        $settings1 = [
            'chart_title' => 'Secure Access (KK)',
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Sanitation',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'secure',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'd-m-Y H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
            'translation_key' => 'sanitation',
        ];

        $settings1['total_number'] = 0;
        if (class_exists($settings1['model'])) {
            $settings1['total_number'] = $settings1['model']::when(isset($settings1['filter_field']), function ($query) use ($settings1) {
                if (isset($settings1['filter_days'])) {
                    return $query->where(
                        $settings1['filter_field'],
                        '>=',
                        now()->subDays($settings1['filter_days'])->format('Y-m-d')
                    );
                }
                if (isset($settings1['filter_period'])) {
                    switch ($settings1['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));

                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';

                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';

                            break;
                    }
                    if (isset($start)) {
                        return $query->where($settings1['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings1['aggregate_function'] ?? 'count'}($settings1['aggregate_field'] ?? '*');
        }

        $settings2 = [
            'chart_title' => 'Basic Access (KK)',
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Sanitation',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'basic',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'd-m-Y H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
            'translation_key' => 'sanitation',
        ];

        $settings2['total_number'] = 0;
        if (class_exists($settings2['model'])) {
            $settings2['total_number'] = $settings2['model']::when(isset($settings2['filter_field']), function ($query) use ($settings2) {
                if (isset($settings2['filter_days'])) {
                    return $query->where(
                        $settings2['filter_field'],
                        '>=',
                        now()->subDays($settings2['filter_days'])->format('Y-m-d')
                    );
                }
                if (isset($settings2['filter_period'])) {
                    switch ($settings2['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));

                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';

                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';

                            break;
                    }
                    if (isset($start)) {
                        return $query->where($settings2['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings2['aggregate_function'] ?? 'count'}($settings2['aggregate_field'] ?? '*');
        }

        $settings3 = [
            'chart_title' => 'Poor Access (KK)',
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Sanitation',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'poor',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'd-m-Y H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
            'translation_key' => 'sanitation',
        ];

        $settings3['total_number'] = 0;
        if (class_exists($settings3['model'])) {
            $settings3['total_number'] = $settings3['model']::when(isset($settings3['filter_field']), function ($query) use ($settings3) {
                if (isset($settings3['filter_days'])) {
                    return $query->where(
                        $settings3['filter_field'],
                        '>=',
                        now()->subDays($settings3['filter_days'])->format('Y-m-d')
                    );
                }
                if (isset($settings3['filter_period'])) {
                    switch ($settings3['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));

                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';

                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';

                            break;
                    }
                    if (isset($start)) {
                        return $query->where($settings3['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings3['aggregate_function'] ?? 'count'}($settings3['aggregate_field'] ?? '*');
        }

        $settings4 = [
            'chart_title' => 'Poor Access Sanitation',
            'chart_type' => 'pie',
            'report_type' => 'group_by_relationship',
            'model' => 'App\Models\Sanitation',
            'group_by_field' => 'name',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'poor',
            'filter_field' => 'created_at',
            'column_class' => 'col-md-6',
            'entries_number' => '5',
            'relationship_name' => 'kecamatan',
            'translation_key' => 'sanitation',
        ];

        $chart4 = new LaravelChart($settings4);

        $settings5 = [
            'chart_title' => 'Amount Sanitation Infrastructure',
            'chart_type' => 'bar',
            'report_type' => 'group_by_relationship',
            'model' => 'App\Models\Build',
            'group_by_field' => 'type',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'column_class' => 'col-md-12',
            'entries_number' => '5',
            'relationship_name' => 'categories',
            'translation_key' => 'build',
        ];

        $chart5 = new LaravelChart($settings5);

        $settings6 = [
            'chart_title' => 'KOTAKU by Kecamatan',
            'chart_type' => 'line',
            'report_type' => 'group_by_relationship',
            'model' => 'App\Models\Nsup',
            'group_by_field' => 'name',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'column_class' => 'col-md-12',
            'entries_number' => '5',
            'relationship_name' => 'kecamatans',
            'translation_key' => 'nsup',
        ];

        $chart6 = new LaravelChart($settings6);

        $settings7 = [
            'chart_title' => 'Entry Data',
            'chart_type' => 'latest_entries',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Build',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'd-m-Y H:i:s',
            'column_class' => 'col-md-12',
            'entries_number' => '10',
            'fields' => [
                'address' => '',
                'kelurahans' => 'name',
                'categories' => 'type',
            ],
            'translation_key' => 'build',
        ];

        $settings7['data'] = [];
        if (class_exists($settings7['model'])) {
            $settings7['data'] = $settings7['model']::latest()
                ->take($settings7['entries_number'])
                ->get();
        }

        if (!array_key_exists('fields', $settings7)) {
            $settings7['fields'] = [];
        }

        return view('home', compact('settings1', 'settings2', 'settings3', 'chart4', 'chart5', 'chart6', 'settings7'));
    }
}
