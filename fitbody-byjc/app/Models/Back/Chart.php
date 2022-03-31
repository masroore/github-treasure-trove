<?php

namespace App\Models\Back;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Chart extends Model
{
    /**
     * @var array
     */
    public $years = [];

    /**
     * @var array
     */
    public $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

    /**
     * @var array
     */
    public $days = [
        '01',
        '02',
        '03',
        '04',
        '05',
        '06',
        '07',
        '08',
        '09',
        '10',
        '11',
        '12',
        '13',
        '14',
        '15',
        '16',
        '17',
        '18',
        '19',
        '20',
        '21',
        '22',
        '23',
        '24',
        '25',
        '26',
        '27',
        '28',
        '29',
        '30',
        '31',
    ];

    /**
     * @var array
     */
    public $hours = [
        '01',
        '02',
        '03',
        '04',
        '05',
        '06',
        '07',
        '08',
        '09',
        '10',
        '11',
        '12',
        '13',
        '14',
        '15',
        '16',
        '17',
        '18',
        '19',
        '20',
        '21',
        '22',
        '23',
        '24',
    ];

    /**
     * @var array
     */
    public $age_stats = [
        'from' => [0, 16, 26, 36, 46, 61],
        'to'   => [15, 25, 35, 45, 60, 100],
    ];

    /**
     * @var array
     */
    public $pie_colors = [
        'rgb(168, 186, 0)',
        'rgba(168, 186, 0,0.8)',
        'rgba(168, 186, 0,0.6)',
        'rgba(168, 186, 0,0.4)',
        'rgba(168, 186, 0,0.2)',
        'rgba(168, 186, 0,0.1)',
    ];

    /**
     * @var array
     */
    protected $request;

    /**
     * @var
     */
    protected $stats;

    /**
     * Chart constructor.
     *
     * @param array $request
     */
    public function __construct($request = [])
    {
        $this->request = $request;
        $this->stats = new Stats();
        $this->years = [
            now()->subYear(6)->year,
            now()->subYear(5)->year,
            now()->subYear(4)->year,
            now()->subYear(3)->year,
            now()->subYear(2)->year,
            now()->subYear(1)->year,
            now()->year,
        ];
    }

    /**
     * Set chart data query params.
     *
     * @param array $params
     *
     * @return array
     */
    public function setQueryParams($params = [])
    {
        if (empty($this->request)) {
            $this->request = $params;
        }

        $from = '';
        $to = now();
        $group = '';
        $iterator = [];

        if ('y' == $this->request['data']) {
            $from = now()->subYear(6);
            $iterator = $this->years;
            $group = 'Y';
        } elseif ('Y' == $this->request['data']) {
            $from = now()->subMonth(now()->month - 1);
            $iterator = $this->months;
            $group = 'm';
        } elseif ('M' == $this->request['data']) {
            $from = now()->startOfMonth();
            $to = now()->endOfMonth();
            $iterator = $this->days;
            $group = 'd';
        } elseif ('T' == $this->request['data']) {
            $from = Carbon::today();
            $iterator = $this->hours;
            $group = 'H';
        } else {
            $from = $this->request['data']['from'];
            $to = $this->request['data']['to'];

            if (Carbon::parse($to)->diffInMonths(Carbon::parse($from)) > 36) {
                $group = 'Y';
            } elseif (Carbon::parse($to)->diffInDays(Carbon::parse($from)) > 60) {
                $group = 'm';
            } else {
                $group = 'd';
            }
        }

        return [
            'from'     => $from,
            'to'       => $to,
            'iterator' => $iterator,
            'group'    => $group,
        ];
    }

    /**
     * Set and return chart query data.
     *
     * @param $iterator
     * @param $data
     *
     * @return array
     */
    public function returnQueryData($iterator, $data)
    {
        $response = [];

        if (empty($iterator)) {
            foreach ($data as $key => $value) {
                $response[$key] = [];

                if (isset($data[$key])) {
                    $response[$key] = $data[$key];
                }
            }
        } else {
            foreach ($iterator as $key) {
                $response[$key] = [];

                if (isset($data[$key])) {
                    $response[$key] = $data[$key];
                }
            }
        }

        return $response;
    }

    /**
     * Set Pie chart data.
     *
     * @param $data
     * @param $column
     *
     * @return array
     */
    public function setPieChartData($data, $column)
    {
        $temp = [];
        $labels = [];
        $chartdata = [];

        foreach ($data as $collection) {
            if (isset($collection->{$column})) {
                if ('birth_date' == $column) {
                    $temp[Carbon::parse($collection->{$column})->year][] = 1;
                } elseif ('gender' == $column) {
                    $temp[$collection->{$column}][] = 1;
                }
            }
        }

        if ('birth_date' == $column) {
            $birth_temp = [];

            foreach ($temp as $age => $value) {
                //Log::info(now()->year - $age);
                for ($i = 0; $i < \count($this->age_stats['from']); $i++) {
                    if ((now()->year - $age) >= $this->age_stats['from'][$i] && (now()->year - $age) <= $this->age_stats['to'][$i]) {
                        $birth_temp[$this->age_stats['from'][$i] . '/' . $this->age_stats['to'][$i]] = \count($value);
                    }
                }

                $chartdata[] = \count($value);
            }

            foreach ($birth_temp as $value => $collection) {
                $labels[] = $value;
            }
        }

        if ('gender' == $column) {
            foreach ($temp as $value => $collection) {
                $labels[] = $value;
                $chartdata[] = \count($collection);
            }
        }

        $widgets = $this->stats->getPieWidgets($data, $column);

        return [
            'labels'  => $labels,
            'data'    => $chartdata,
            'colors'  => \array_slice($this->pie_colors, 0, \count($temp) + 1),
            'widgets' => $widgets,
        ];
    }

    /**
     * Set data for Bar chart.
     *
     * @param $data
     * @param $column
     *
     * @return array
     */
    public function setBarChartData($data, $column)
    {
        $labels = [];
        $chartdata = [];

        foreach ($data as $day => $collections) {
            $sum = 0;

            foreach ($collections as $collection) {
                if (isset($collection->{$column})) {
                    $sum = $sum + (int) ($collection->{$column});
                }
            }

            $labels[] = $day;
            $chartdata[] = $sum;
        }

        return [
            'labels'  => $labels,
            'data'    => $chartdata,
            'widgets' => $this->stats->setWidgetsData($chartdata),
            'presets' => $this->stats->setPresetsData(),
        ];
    }

    /**
     * Set data for Horizontal Bar chart.
     *
     * @param $data
     * @param $column
     *
     * @return array
     */
    public function setHorizontalBarChartData($data, $column)
    {
        $temp = $this->setBarChartData($data, $column);

        for ($i = 0; $i < \count($temp['labels']); $i++) {
            $test[$temp['data'][$i]] = $temp['labels'][$i];
        }

        $response = ['labels' => [], 'data' => []];
        $count = 0;

        if (!empty($test)) {
            krsort($test);

            foreach ($test as $index => $value) {
                if ($count > 9) {
                    break;
                }

                $response['labels'][] = $value;
                $response['data'][] = $index;

                $count++;
            }
        }

        return [
            'labels'  => $response['labels'],
            'data'    => $response['data'],
            'widgets' => $this->stats->setWidgetsData($temp['data']),
            'presets' => $this->stats->setPresetsData(),
        ];
    }
}
