<?php

namespace App\Http\Controllers\Admin;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController
{
    public function index()
    {
        $settings1 = [
            'chart_title' => 'Check-in',
            'chart_type' => 'line',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\TimeTracking',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'filter_days' => '7',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-12',
            'entries_number' => '5',
            'translation_key' => 'timeTracking',
        ];

        $chart1 = new LaravelChart($settings1);

        $settings2 = [
            'chart_title' => 'Recent Check-in',
            'chart_type' => 'latest_entries',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\TimeTracking',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'filter_days' => '7',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-6',
            'entries_number' => '5',
            'fields' => [
                'checkin_time' => '',
                'checkout_time' => '',
                'user' => 'name',
            ],
            'translation_key' => 'timeTracking',
        ];

        $settings2['data'] = [];

        if (class_exists($settings2['model'])) {
            $settings2['data'] = $settings2['model']::latest()
                ->take($settings2['entries_number'])
                ->get();
        }

        if (!\array_key_exists('fields', $settings2)) {
            $settings2['fields'] = [];
        }

        $settings3 = [
            'chart_title' => 'Total Hours',
            'chart_type' => 'pie',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\TimeTracking',
            'group_by_field' => 'total_hours',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'cost',
            'filter_field' => 'created_at',
            'filter_days' => '7',
            'column_class' => 'col-md-6',
            'entries_number' => '5',
            'translation_key' => 'timeTracking',
        ];

        $chart3 = new LaravelChart($settings3);

        return view('home', compact('chart1', 'settings2', 'chart3'));
    }
}
