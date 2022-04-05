@extends('layout.header')
<?php
$isHolder = Session::get('IS_HOLDER');
$ships = Session::get('shipList');
?>
@section('styles')
    <link href="{{ cAsset('css/pretty.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/dycombo.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/multiselect.css') }}" rel="stylesheet"/>
    <script src="{{ cAsset('assets/js/multiselect.min.js') }}"></script>
@endsection

@section('scripts')
    <link href="{{ cAsset('assets/js/chartjs/chartist.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cAsset('assets/js/chartjs/c3.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ cAsset('assets/js/chartjs/flot.css') }}">
    
    
    <script src="{{ cAsset('assets/js/chartjs/chartist.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/chartjs.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/d3.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/c3.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/flot.js') }}"></script>
    <script src="{{ cAsset('/assets/js/highcharts.js') }}"></script>
@endsection
@section('content')
    
    <div class="main-content">
        <style>
            .cost-item-odd {
                background-color: #f5f5f5;
            }

            .cost-item-even:hover {
                background-color: #ffe3e082;
            }

            .cost-item-odd:hover {
                background-color: #ffe3e082;
            }
        </style>
        <div class="page-content">
            <div class="space-4"></div>
            <div class="col-md-12">
                <div class="row">
                    <div class="tabbable">
                        <ul class="nav nav-tabs ship-register" id="importTab">
                            <li class="active">
                                <a data-toggle="tab" href="#tab_graph">
                                    GRAPH
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab_table">
                                    TABLE
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="tab_graph" class="tab-pane active">
                            <div class="page-header">
                                <div class="col-sm-3">
                                    <h4><b>GRAPH</b></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-7">
                                        <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名:</label>
                                        <select class="custom-select d-inline-block" id="select-graph-ship" style="width:80px" multiple>
                                            @foreach($shipList as $ship)
                                                <option value="{{ $ship['IMO_No'] }}" data-name="{{$ship['shipName_En']}}">{{$ship['NickName']}}</option>
                                            @endforeach
                                        </select>
                                        <select name="select-graph-year" id="select-graph-year" style="font-size:13px">
                                            @for($i=date("Y");$i>=$start_year;$i--)
                                            <option value="{{$i}}" @if($i==date("Y")) selected @endif>{{$i}}年</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-5" style="padding:unset!important">
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top:4px;">
                                    <div class="row" style="text-align:center;">
                                        <strong class="text-center" style="font-size: 20px; padding-top: 6px;"><span id="graph_first_title"></span>利润累计比较</strong>
                                        <div class="card" id="graph_first" width="500px;" style="border:3px double #bbb7b7">
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="space-10"></div>
                                    <div class="row" style="text-align:center;">
                                        <strong class="text-center" style="font-size: 20px; padding-top: 6px;"><span id="graph_second_title"></span>收支累计比较</strong>
                                        <div class="card" id="graph_second" style="border:3px double #bbb7b7">
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="space-10"></div>
                                    <div class="row" style="text-align:center;">
                                        <strong class="text-center" style="font-size: 20px; padding-top: 6px;"><span id="graph_third_title"></span>经济天数占率比较</strong>
                                        <div class="card" id="graph_third" style="border:3px double #bbb7b7">
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="space-10"></div>
                                    <div class="row" style="text-align:center;">
                                        <strong class="text-center" style="font-size: 20px; padding-top: 6px;"><span id="graph_fourth_title"></span>支出比较</strong>
                                        <div class="card" id="graph_fourth" style="border:3px double #bbb7b7">
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="space-10"></div>
                                    <div class="row" style="text-align:center;">
                                        <strong class="text-center" style="font-size: 20px; padding-top: 6px;"><span id="graph_fifth_title"></span>CTM支出比较</strong>
                                        <div class="card" id="graph_fifth" style="border:3px double #bbb7b7">
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="space-10"></div>
                                </div>
                            </div>
                        </div>
                        <div id="tab_table" class="tab-pane">
                            <div class="page-header">
                                <div class="col-sm-3">
                                    <h4><b>收支分析表</b></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-7">
                                        <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名:</label>
                                        <select class="custom-select d-inline-block" id="select-table-ship" style="width:80px" multiple>
                                            @foreach($shipList as $ship)
                                                <option value="{{ $ship['IMO_No'] }}" data-name="{{$ship['shipName_En']}}">{{$ship['NickName']}}</option>
                                            @endforeach
                                        </select>
                                        <select name="select-table-year" id="select-table-year" style="font-size:13px">
                                            @for($i=date("Y");$i>=$start_year;$i--)
                                            <option value="{{$i}}" @if($i==date("Y")) selected @endif>{{$i}}年</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-5" style="padding:unset!important">
                                        <div class="btn-group f-right">
                                            <a onclick="javascript:fnExcelTableReport();" class="btn btn-warning btn-sm excel-btn">
                                                <i class="icon-table"></i>{{ trans('common.label.excel') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin:4px;">
                                <div class="row" style="text-align:center;">
                                    <strong class="text-center" style="font-size: 20px; padding-top: 6px;"><span id="table_first_title"></span>利润</strong>
                                    <div class="space-4"></div>
                                    <table id="table-total-profit" style="table-layout:fixed;">
                                        <thead class="">
                                        <tr>
                                            <th class="text-center style-normal-header" width="4%"><span>船名</span></th>
                                            <th class="text-center style-normal-header right-border" id="total-year"><span></span></th>
                                            <th class="text-center style-normal-header"><span>1月</span></th>
                                            <th class="text-center style-normal-header"><span>2月</span></th>
                                            <th class="text-center style-normal-header"><span>3月</span></th>
                                            <th class="text-center style-normal-header"><span>4月</span></th>
                                            <th class="text-center style-normal-header"><span>5月</span></th>
                                            <th class="text-center style-normal-header"><span>6月</span></th>
                                            <th class="text-center style-normal-header"><span>7月</span></th>
                                            <th class="text-center style-normal-header"><span>8月</span></th>
                                            <th class="text-center style-normal-header"><span>9月</span></th>
                                            <th class="text-center style-normal-header"><span>10月</span></th>
                                            <th class="text-center style-normal-header"><span>11月</span></th>
                                            <th class="text-center style-normal-header"><span>12月</span></th>
                                        </tr>
                                        </thead>
                                        <tbody class="" id="table-total-profit-body">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="space-4"></div>
                                <div class="space-8"></div>
                                <div class="row" style="text-align:center;">
                                    <strong class="text-center" style="font-size: 20px; padding-top: 6px;"><span id="table_second_title"></span>收支</strong>
                                    <div class="space-4"></div>
                                    <table id="table-income-expense" style="table-layout:fixed;">
                                        <thead class="">
                                        <tr>
                                            <th class="text-center style-normal-header" width="4%"><span>船名</span></th>
                                            <th class="text-center style-normal-header"><span>收入</span></th>
                                            <th class="text-center style-normal-header right-border"><span>支出</span></th>
                                            <th class="text-center style-normal-header style-red-header"><span>油款</span></th>
                                            <th class="text-center style-normal-header style-red-header"><span>港费</span></th>
                                            <th class="text-center style-normal-header style-red-header"><span>劳务费</span></th>
                                            <th class="text-center style-normal-header style-red-header"><span>CTM</span></th>
                                            <th class="text-center style-normal-header style-red-header right-border"><span>其他</span></th>
                                            <th class="text-center style-normal-header"><span>工资</span></th>
                                            <th class="text-center style-normal-header"><span>伙食费</span></th>
                                            <th class="text-center style-normal-header"><span>物料费</span></th>
                                            <th class="text-center style-normal-header"><span>修理费</span></th>
                                            <th class="text-center style-normal-header"><span>管理费</span></th>
                                            <th class="text-center style-normal-header"><span>保险费</span></th>
                                            <th class="text-center style-normal-header"><span>检验费</span></th>
                                            <th class="text-center style-normal-header"><span>证书费</span></th>
                                        </tr>
                                        </thead>
                                        <tbody class="" id="table-income-expense-body">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="space-4"></div>
                                <div class="space-8"></div>
                                <div class="row" style="text-align:center;">
                                    <strong class="text-center" style="font-size: 20px; padding-top: 6px;"><span id="table_third_title"></span>经济天数占率</strong>
                                    <div class="space-4"></div>
                                    <table id="table-economic-days" style="table-layout:fixed;">
                                        <thead class="">
                                        <tr>
                                            <th class="text-center style-normal-header" rowspan="2" width="4%"><span>船名</span></th>
                                            <th class="text-center style-normal-header" rowspan="2" width="5%"><span>航次数</span></th>
                                            <th class="text-center style-normal-header" rowspan="2" width="10%"><span>期间</span></th>
                                            <th class="text-center style-normal-header"><span>航次</span></th>
                                            <th class="text-center style-normal-header"><span>距离</span></th>
                                            <th class="text-center style-normal-header right-border"><span>平均</span></th>
                                            <th class="text-center style-normal-header right-border" colspan="5"><span>经济天数</span></th>
                                            <th class="text-center style-normal-header" colspan="5"><span>非经济天数</span></th>
                                        </tr>
                                        <tr>
                                            <th class="text-center style-normal-header"><span>用时</span></th>
                                            <th class="text-center style-normal-header"><span>[NM]</span></th>
                                            <th class="text-center style-normal-header right-border"><span>速度</span></th>
                                            <th class="text-center style-normal-header"><span>合计</span></th>
                                            <th class="text-center style-normal-header"><span>占率</span></th>
                                            <th class="text-center style-normal-header"><span>航行</span></th>
                                            <th class="text-center style-normal-header"><span>装货</span></th>
                                            <th class="text-center style-normal-header right-border"><span>卸货</span></th>
                                            <th class="text-center style-normal-header"><span>合计</span></th>
                                            <th class="text-center style-normal-header"><span>待泊</span></th>
                                            <th class="text-center style-normal-header"><span>天气</span></th>
                                            <th class="text-center style-normal-header"><span>修理</span></th>
                                            <th class="text-center style-normal-header"><span>供应</span></th>
                                        </tr>
                                        </thead>
                                        <tbody class="" id="table-economic-days-body">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="space-4"></div>
                                <div class="space-8"></div>
                                <div class="row" style="text-align:center;">
                                    <strong class="text-center" style="font-size: 20px; padding-top: 6px;"><span id="table_fourth_title"></span>CTM支出</strong>
                                    <div class="space-4"></div>
                                    <table id="table-ctm-deposit" style="table-layout:fixed;">
                                        <thead class="">
                                        <tr>
                                            <th class="text-center style-normal-header" width="4%"><span>船名</span></th>
                                            <th class="text-center style-normal-header right-border"><span>支出</span></th>
                                            <th class="text-center style-normal-header style-red-header"><span>劳务费</span></th>
                                            <th class="text-center style-normal-header style-red-header"><span>娱乐费</span></th>
                                            <th class="text-center style-normal-header style-red-header"><span>招待费</span></th>
                                            <th class="text-center style-normal-header style-red-header"><span>奖励</span></th>
                                            <th class="text-center style-normal-header style-red-header"><span>小费</span></th>
                                            <th class="text-center style-normal-header style-red-header"><span>通信费</span></th>
                                            <th class="text-center style-normal-header style-red-header right-border"><span>其他</span></th>
                                            <th class="text-center style-normal-header"><span>伙食费</span></th>
                                            <th class="text-center style-normal-header"><span>物料费</span></th>
                                            <th class="text-center style-normal-header"><span>修理费</span></th>
                                            <th class="text-center style-normal-header"><span>证书费</span></th>
                                        </tr>
                                        </thead>
                                        <tbody class="" id="table-ctm-deposit-body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <audio controls="controls" class="d-none" id="warning-audio">
            <source src="{{ cAsset('assets/sound/delete.wav') }}">
            <embed src="{{ cAsset('assets/sound/delete.wav') }}" type="audio/wav">
        </audio>
    </div>
    

    <script src="{{ cAsset('assets/js/moment.js') }}"></script>
    <script src="{{ asset('/assets/js/x-editable/bootstrap-editable.min.js') }}"></script>
    <script src="{{ asset('/assets/js/x-editable/ace-editable.min.js') }}"></script>
    <script src="{{ cAsset('assets/js/jsquery.dataTables.js') }}"></script>
    <script src="{{ asset('/assets/js/dataTables.rowsGroup.js') }}"></script>
    <script src="{{ cAsset('assets/js/bignumber.js') }}"></script>

    <script>
        document.multiselect('#select-graph-ship')
            .setCheckBoxClick("checkboxAll", function(target, args) {
            })
            .setCheckBoxClick("1", function(target, args) {
            });

        document.multiselect('#select-table-ship')
            .setCheckBoxClick("checkboxAll", function(target, args) {
            })
            .setCheckBoxClick("1", function(target, args) {
            });
        $('.multiselect-wrapper').on('click', function() {
            $('.multiselect-wrapper hr').hide()
        })

        var DYNAMIC_SUB_SALING = '{!! DYNAMIC_SUB_SALING !!}';
        var DYNAMIC_SUB_LOADING = '{!! DYNAMIC_SUB_LOADING !!}';
        var DYNAMIC_SUB_DISCH = '{!! DYNAMIC_SUB_DISCH !!}';
        var DYNAMIC_SUB_WAITING = '{!! DYNAMIC_SUB_WAITING !!}';
        var DYNAMIC_SUB_WEATHER = '{!! DYNAMIC_SUB_WEATHER !!}';
        var DYNAMIC_SUB_REPAIR = '{!! DYNAMIC_SUB_REPAIR !!}';
        var DYNAMIC_SUB_SUPPLY = '{!! DYNAMIC_SUB_SUPPLY !!}';
        var DYNAMIC_SUB_ELSE = '{!! DYNAMIC_SUB_ELSE !!}';

        
        var DYNAMIC_SAILING = '{!! DYNAMIC_SAILING !!}';
        var DYNAMIC_CMPLT_DISCH = '{!! DYNAMIC_CMPLT_DISCH !!}';
        const DAY_UNIT = 1000 * 3600;
        const COMMON_DECIMAL = 2;

    </script>
    <?php
	echo '<script>';
    echo 'var start_year = ' . $start_year . ';';
    echo 'var now_year = ' . date("Y") . ';';
    echo 'var FeeTypeData = ' . json_encode(g_enum('FeeTypeData')) . ';';
	echo '</script>';
	?>
    <script>
    var token = '{!! csrf_token() !!}';
    var shipids_table;
    var shipnames_table;
    var year_table;
    var shipids_graph;
    var shipnames_graph;
    var year_graph;
    $(function() {
        $("body").on('click', function(e){
            if (JSON.stringify(shipids_table) != JSON.stringify($('#select-table-ship').val())) {
                shipids_table = $('#select-table-ship').val();
                if (shipids_table != null) {
                    selectTableInfo();
                }
            }
            if (JSON.stringify(shipids_graph) != JSON.stringify($('#select-graph-ship').val())) {
                shipids_graph = $('#select-graph-ship').val();
                console.log("shipids_graph",",",shipids_graph);
                if (shipids_graph != null) {
                    selectGraphInfo();
                }
            }
        });
    });

    $('#select-table-year').on('change', function() {
        selectTableInfo();
    });

    $('#select-graph-year').on('change', function() {
        selectGraphInfo();
    });

    function selectTableInfo()
    {
        shipnames_table = $("#select-table-ship option:selected").map(function () {
            return $(this).text();
        }).get().join('+');
        year_table = $("#select-table-year option:selected").val();
        $('#total-year').html(year_table + "年");
        $('#table_first_title').text(shipnames_table + " " + year_table + "年");
        $('#table_second_title').text(shipnames_table + " " + year_table + "年");
        $('#table_third_title').text(shipnames_table + " " + year_table + "年");
        $('#table_fourth_title').text(shipnames_table + " " + year_table + "年");

        initTable();
    }

    function selectGraphInfo()
    {
        var index = 0;
        shipnames_graph = $("#select-graph-ship option:selected").map(function () {
            var name = '<span style="color:' + color_table[index] + '">' + $(this).text() + '</span>';
            index ++;
            return name;
        }).get().join('+');
        year_graph = $("#select-graph-year option:selected").val();

        $('#graph_first_title').html(shipnames_graph + " " + year_graph + "年");
        $('#graph_second_title').html(shipnames_graph + " " + year_graph + "年");
        $('#graph_third_title').html(shipnames_graph + " " + year_graph + "年");
        $('#graph_fourth_title').html(shipnames_graph + " " + year_graph + "年");
        $('#graph_fifth_title').html(shipnames_graph + " " + year_graph + "年");

        initGraphTable();
    }

    function prettyValue(value)
    {
        if(value == undefined || value == null) return '';
        return parseFloat(value).toFixed(2).replaceAll(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
    }

    function prettyValue2(value)
    {
        if(value == undefined || value == null) return '';
        return parseFloat(value).toFixed(0).replaceAll(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
    }

    function addAlpha(color, opacity) {
        const _opacity = Math.round(Math.min(Math.max(opacity || 1, 0), 1) * 255);
        return color + _opacity.toString(16).toUpperCase();
    }

    var color_table = ['#73b7ff','#ff655c','#50bc16','#ffc800','#9d00ff','#ff0000','#795548','#3f51b5','#00bcd4','#e91e63','#0000ff','#00ff00','#0d273a','#cddc39','#0f184e'];
    function drawFirstGraph(datasets) {
        $('#graph_first').html('');

        Highcharts.setOptions({
            lang: {
                thousandsSep: ','
            }
        });

        Highcharts.chart('graph_first', {
            title: {
                text: null
            },
            subtitle: {
                text: null
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: null
                },
                labels: {
                    formatter: function() {
                        if (this.value < 0) {
                            return '<label style="color:red">' + '$ ' + prettyValue2(this.value) + '</label>';
                        }
                        else return '$ ' + prettyValue2(this.value);
                    }
                },
                plotLines: [{
                    value: 0,
                    width: 2,
                    color: '#000'
                }],
            },
            xAxis: {
                categories: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                lineWidth: 2
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            credits: {
                enabled: false
            },
            tooltip: {
                valueDecimals: 0,
                formatter: function() {
                    return '<span style="color:' + this.color + '">\u25CF</span> ' + this.series.name + ': <b>' + ('$ ' + prettyValue2(this.y)) + '</b><br/>';
                }
            },
            plotOptions: {
            },
            series: datasets
        });
    }
    
    function drawSecondGraph(datasets) {
        $('#graph_second').html('');

        Highcharts.chart('graph_second', {
            chart: {
                type: 'bar',
                events: {
                    load: function() {
                        var yAxis = this.yAxis[0];
                        this.xAxis[0].update({
                            offset: -yAxis.toPixels(0, true)
                        });
                    }
                }
            },
            title: {
                text: null
            },
            subtitle: {
                text: null
            },
            xAxis: {
                categories: ['收入', '支出'],
                title: {
                    text: null
                },
                labels: {
                    style: {
                        fontSize: 20,
                        color: 'black',
                        fontWeight: 'bold'
                    }
                },
            },
            yAxis: {
                title: {
                    text: null,
                },
                labels: {
                    formatter: function() {
                        if (this.value < 0) {
                            return '<label style="color:red">' + '$ ' + prettyValue2(this.value) + '</label>';
                        }
                        else return '$ ' + prettyValue2(this.value);
                    }
                },
                plotLines: [{
                    color: 'black',
                    width: 2,
                    value: 0,
                    label: {
                        text: null,
                        align: 'right',
                        x: -10
                    }
                }]
            },
            tooltip: {
                valueDecimals: 0,
                valuePrefix: "$ ",
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: datasets
        });
    }
        
    function drawThirdGraph(labels,datasets) {
        $('#graph_third').html('');
        $('#graph_third').append('<canvas id="third-chart" height="250" class="chartjs-demo"></canvas>');
        new Chart(document.getElementById("third-chart"), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += prettyValue2(context.parsed.y) + '%';
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value, index, values) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
    }
    
    function drawFourthGraph(datasets) {
        $('#graph_fourth').html('');
        $('#graph_fourth').append('<canvas id="fourth-chart" height="500" class="chartjs-demo"></canvas>');
        new Chart(document.getElementById("fourth-chart"), {
            type: 'bar',
            data: {
                labels: ['油款','港费','劳务费','CTM','其他','工资','伙食费','物料费','修理费','管理费','保险费','检验费','证书费'],
                datasets: datasets
            },
            options: {
                indexAxis: 'y',
                elements: {
                    bar: {
                        borderWidth: 1,
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.x !== null) {
                                    label += '$ ' + prettyValue2(context.parsed.x);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            callback: function(value, index, values) {
                                return '$ ' + prettyValue2(value);
                            }
                        }
                    }
                }
            }
        });
    }
    function drawFifthGraph(datasets) {
        $('#graph_fifth').html('');
        $('#graph_fifth').append('<canvas id="fifth-chart" height="500" class="chartjs-demo"></canvas>');
        new Chart(document.getElementById("fifth-chart"), {
            type: 'bar',
            data: {
                labels: ['劳务费','娱乐费','招待费','奖励','小费','通信费','其他','伙食费','物料费','修理费','证书费'],
                datasets: datasets
            },
            options: {
                indexAxis: 'y',
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.x !== null) {
                                    label += '$ ' + prettyValue2(context.parsed.x);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            callback: function(value, index, values) {
                                return '$ ' + prettyValue2(value);
                            }
                        }
                    }
                }
            }
        });
    }

    function washData(datasets) {
        var data = [...datasets];
        for (var i=11;i>0;i--) {
            if (data[i] == data[i-1]) {
                data[i] = null;
            } else {
                break;
            }
        }
        for (var i=0;i<12;i++) {
            if (data[i] == 0) data[i] = null;
        }
        return data;
    }
    function initGraphTable() {
        $.ajax({
            url: BASE_URL + 'ajax/operation/listByAll',
            type: 'post', 
            data: {'year':year_graph, 'shipId':shipids_graph},
            success: function(result) {
                // Table 1
                var prev_sum = 0;
                var month_sum = [];
                var axis_x_names = [];
                for(var i=0;i<12;i++) month_sum[i] = 0;
                var index = 0;
                var datasets = [];
                $("#select-graph-ship option:selected").map(function () {
                    var ship_name = $(this).text();
                    var ship_no = $(this).val();
                    datasets[index] = {};
                    datasets[index].data = washData(result[ship_no]['sum_months']);
                    datasets[index].name = ship_name;
                    datasets[index].color = color_table[index];
                    for(var i=0;i<12;i++) {
                        value = result[ship_no]['sum_months'][i];
                        month_sum[i] += value;
                    }
                    index++;
                });
                datasets[index] = {};
                month_sum = washData(month_sum);
                datasets[index].data = month_sum;
                datasets[index].name = '合计';
                datasets[index].color = '#4a7ebb';  //4a7ebb
                datasets[index].dashStyle = 'Dash';//LongDash
                datasets[index].lineWidth = 4;
                datasets[index].smoothed = true;
                datasets[index].type = 'spline';
                drawFirstGraph(datasets);

                // Table 2
                var credit_sum = 0;
                var debit_sum = 0;
                var profit_sum = [];
                for(var i=0;i<16;i++) profit_sum[i] = 0;
                var index = 0;
                datasets = [];
                var datasets4 = [];
                $("#select-graph-ship option:selected").map(function () {
                    var ship_name = $(this).text();
                    var ship_no = $(this).val();
                    var value = result[ship_no]['credit_sum'];
                    datasets[index] = {};
                    datasets[index].name = ship_name;
                    result[ship_no]['credit_sum'] = parseInt(result[ship_no]['credit_sum']);
                    result[ship_no]['debit_sum'] = parseInt(result[ship_no]['debit_sum']);

                    datasets[index].data = [result[ship_no]['credit_sum'], result[ship_no]['debit_sum']*(-1)];
                    datasets[index].borderColor = color_table[index];
                    datasets[index].color = addAlpha(color_table[index],0.8);

                    datasets4[index] = {};
                    datasets4[index].label = ship_name;
                    datasets4[index].data = [];
                    datasets4[index].borderColor = addAlpha(color_table[index],0.8);//color_table[index];
                    datasets4[index].backgroundColor = color_table[index];//addAlpha(color_table[index],0.8);
                    var indexes = [2,1,6,4,15,3,5,7,8,9,10,11,12];
                    for(var i=0;i<indexes.length;i++) {
                        datasets4[index].data[i] = result[ship_no]['debits'][indexes[i]];
                    }
                    index++;
                });
                value = credit_sum;
                value = debit_sum;
                for(var i=0;i<13;i++) {
                    var value = profit_sum[i];
                }
                drawSecondGraph(datasets);
                drawFourthGraph(datasets4);
            }
        });

        $.ajax({
            url: BASE_URL + 'ajax/business/dynamic/multiSearch',
            type: 'post', 
            data: {
                'year':year_graph,
                'shipId':shipids_graph,
            },
            success: function(result) {
                var index = 0;
                var datasets = [];
                var labels = [];
                datasets[0] = {};
                $("#select-graph-ship option:selected").map(function () {
                    var ship_name = $(this).text();
                    var ship_no = $(this).val();

                    let data = result[ship_no]['currentData'];
                    let voyData = result[ship_no]['voyData'];
                    let cpData = result[ship_no]['cpData'];

                    let list = [];
                    let realData = [];
                    let footerData = [];
                    footerData['voy_count'] = 0;
                    footerData['total_count'] = 0;
                    footerData['average_speed'] = 0;
                    footerData['voy_start'] = '';
                    footerData['voy_end'] = '';
                    footerData['economic_rate'] = '-';
                    footerData['sail_time'] = 0;
                    footerData['total_distance'] = 0;
                    footerData['total_sail_time'] = 0;
                    footerData['total_loading_time'] = 0;
                    footerData['loading_time'] = 0;
                    footerData['disch_time'] = 0;
                    footerData['total_waiting_time'] = 0;
                    footerData['total_weather_time'] = 0;
                    footerData['total_repair_time'] = 0;
                    footerData['total_supply_time'] = 0;
                    footerData['total_else_time'] = 0;

                    if(voyData.length > 0) {
                        voyData.forEach(function(value, key) {
                            let tmpData = data[value];
                            let total_sail_time = 0;
                            let total_loading_time = 0;
                            let loading_time = 0;
                            let disch_time = 0;
                            let total_waiting_time = 0;
                            let total_weather_time = 0;
                            let total_repair_time = 0;
                            let total_supply_time = 0;
                            let total_else_time = 0;
                            let total_distance = 0;

                            realData = [];
                            realData['voy_no'] = value;
                            realData['voy_count'] = tmpData.length - 1;
                            realData['voy_start'] = tmpData[0]['Voy_Date'] + ' ' + tmpData[0]['Voy_Hour'] + ':' + tmpData[0]['Voy_Minute'];
                            realData['voy_end'] = tmpData[tmpData.length - 1]['Voy_Date'] + ' ' + tmpData[tmpData.length - 1]['Voy_Hour'] + ':' + tmpData[tmpData.length - 1]['Voy_Minute'];
                            realData['lport'] = cpData[value]['LPort'] == false ? '-' : cpData[value]['LPort'];
                            realData['dport'] = cpData[value]['DPort'] == false ? '-' : cpData[value]['DPort'];
                            //realData['sail_time'] = __getTermDay(realData['voy_start'], realData['voy_end'], tmpData[0]['GMT'], tmpData[tmpData.length - 1]['GMT']);
                            
                            tmpData.forEach(function(data_value, data_key) {
                                total_distance += data_key > 0 ? __parseFloat(data_value["Sail_Distance"]) : 0;
                                if(data_key > 0) {
                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_SALING) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                        total_sail_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                    }

                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_LOADING) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                        loading_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                    }

                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_DISCH) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                        disch_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                    }

                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_WAITING) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                        total_waiting_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                    }

                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_WEATHER) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                        total_weather_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                    }

                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_REPAIR) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'];
                                        total_repair_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                    }

                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_SUPPLY) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'];
                                        total_supply_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                    }

                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_ELSE) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'];
                                        total_else_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                        if(value == '2017') console.log(total_else_time)
                                    }
                                }
                            });

                            realData.total_sail_time = total_sail_time;
                            realData.total_distance = total_distance;
                            realData.average_speed = BigNumber(realData.total_distance).div(total_sail_time).div(24);
                            realData.loading_time = loading_time.toFixed(COMMON_DECIMAL);
                            realData.disch_time = disch_time.toFixed(COMMON_DECIMAL);
                            realData.total_loading_time = BigNumber(__parseFloat(loading_time.toFixed(2))).plus(__parseFloat(disch_time.toFixed(2))).plus(__parseFloat(total_sail_time.toFixed(2)));
                            //realData.economic_rate = BigNumber(realData.total_loading_time).div(__parseFloat(realData.sail_time.toFixed(2))).multipliedBy(100).toFixed(1);
                            
                            realData.total_waiting_time = total_waiting_time.toFixed(COMMON_DECIMAL);
                            realData.total_weather_time = total_weather_time.toFixed(COMMON_DECIMAL);
                            realData.total_repair_time = total_repair_time.toFixed(COMMON_DECIMAL);
                            realData.total_supply_time = total_supply_time.toFixed(COMMON_DECIMAL);
                            realData.total_else_time = total_else_time.toFixed(COMMON_DECIMAL);
                            realData.non_economic_date = BigNumber(__parseFloat(realData.total_waiting_time)).plus(__parseFloat(realData.total_weather_time)).plus(__parseFloat(realData.total_repair_time)).plus(__parseFloat(realData.total_supply_time)).plus(__parseFloat(realData.total_else_time))
                            realData['sail_time'] = __parseFloat(realData.non_economic_date) + __parseFloat(realData.total_loading_time);
                            realData.economic_rate = BigNumber(realData.total_loading_time).div(__parseFloat(realData.sail_time.toFixed(2))).multipliedBy(100).toFixed(1);

                            // Calc Footer data
                            footerData['sail_time'] += __parseFloat(realData.sail_time.toFixed(2));
                            footerData['total_count'] += __parseFloat(realData['voy_count']);
                            footerData['total_distance'] += __parseFloat(realData['total_distance']);
                            footerData['total_sail_time'] += __parseFloat(total_sail_time.toFixed(2));
                            footerData['total_loading_time'] += __parseFloat(realData['total_loading_time'].toFixed(2));
                            footerData['loading_time'] += __parseFloat(realData['loading_time']);
                            footerData['disch_time'] += __parseFloat(realData['disch_time']);
                            footerData['total_waiting_time'] += __parseFloat(realData['total_waiting_time']);
                            footerData['total_weather_time'] += __parseFloat(realData['total_weather_time']);
                            footerData['total_repair_time'] += __parseFloat(realData['total_repair_time']);
                            footerData['total_supply_time'] += __parseFloat(realData['total_supply_time']);
                            footerData['total_else_time'] += __parseFloat(realData['total_else_time']);

                            list.push(realData);
                        });

                        if (list.length > 0) {
                            footerData['voy_count'] = voyData.length;
                            footerData['voy_start'] = list[0].voy_start;
                            footerData['voy_end'] = list[list.length - 1].voy_end;
                            if (footerData['voy_start'].length > 9) {
                                footerData['voy_start'] = footerData['voy_start'].substring(0,10);
                            }
                            if (footerData['voy_end'].length > 9) {
                                footerData['voy_end'] = footerData['voy_end'].substring(0,10);
                            }
                            footerData['average_speed'] = __parseFloat(BigNumber(footerData['total_distance']).div(footerData['total_sail_time']).div(24));
                            footerData['economic_rate'] = BigNumber(footerData['loading_time']).plus(footerData['disch_time']).plus(footerData['total_sail_time']).div(footerData['sail_time']).multipliedBy(100).toFixed(1);
                        } else {
                            footerData['voy_start'] = "-";
                            footerData['voy_end'] = "-";
                        }
                    }
                    
                    
                    datasets[index] = {};
                    datasets[index].label = ship_name;
                    var percent = _format((footerData['loading_time'] + footerData['disch_time'] + footerData['total_sail_time'])/footerData['sail_time']*100,1);
                    datasets[index].data = [];
                    datasets[index].data[0] = percent;
                    datasets[index].borderColor = addAlpha(color_table[index],0.8);
                    datasets[index].backgroundColor = color_table[index];

                    //datasets[index].barPercentage = 1;
                    datasets[index].barThickness = 40;
                    datasets[index].maxBarThickness = 40;
                    //datasets[index].minBarLength = 1;
                    //datasets[index].barPercentage = 1;
                    
                    index++;
                });
                labels = [''];
                drawThirdGraph(labels,datasets);
            }
        });

        $.ajax({
            url: BASE_URL + 'ajax/shipmanage/ctm/debits',
            type: 'post',
            data: {
                year:year_graph,
                shipId:shipids_graph,
            },
            success: function(data) {
                var debits_sum = [];
                for(var i=0;i<12;i++) debits_sum[i] = 0;
                var index = 0;
                var datasets = [];
                $("#select-graph-ship option:selected").map(function () {
                    var ship_name = $(this).text();
                    var ship_no = $(this).val();
                    datasets[index] = {};
                    datasets[index].label = ship_name;
                    datasets[index].data = [];
                    datasets[index].borderColor = addAlpha(color_table[index],0.8);
                    datasets[index].backgroundColor = color_table[index];
                    for(var i=1;i<12;i++) {
                        var offset;
                        if (i == 0) offset = 1;
                        else if (i == 1) offset = 3;
                        else if (i == 2) offset = 4;
                        else if (i == 3) offset = 6;
                        else if (i == 4) offset = 7;
                        else if (i == 5) offset = 8;
                        else if (i == 6) offset = 11;
                        else if (i == 7) offset = 12;
                        else if (i == 8) offset = 2;
                        else if (i == 9) offset = 5;
                        else if (i == 10) offset = 9;
                        else if (i == 11) offset = 10;
                        datasets[index].data[i-1] = data[ship_no]['total'][offset];
                    }
                    index++;
                });
                drawFifthGraph(datasets);
            }
        })
    }
    
    function initTable() {
        $.ajax({
            url: BASE_URL + 'ajax/operation/listByAll',
            type: 'post', 
            data: {'year':year_table, 'shipId':shipids_table},
            success: function(result) {
                // Table 1
                $('#table-total-profit-body').html('');
                var prev_sum = 0;
                var month_sum = [];
                for(var i=0;i<12;i++) month_sum[i] = 0;
                var index = 0;
                $("#select-table-ship option:selected").map(function () {
                    var ship_name = $(this).text();
                    var ship_no = $(this).val();
                    var row_html = "<tr class='" + ((index%2==0)?'cost-item-even':'cost-item-odd') + "'>";
                    row_html += "<td>" + ship_name + "</td>";
                    
                    //var value = result[ship_no]['prevProfit'];
                    //row_html += '<td style="padding-right:5px!important;height:20px!important;" class="right-border text-right ' + (value >= 0 ? 'style-blue-input':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                    var value = result[ship_no]['sum_months'][11];
                    prev_sum += value;
                    row_html += '<td style="padding-right:5px!important;height:20px!important;" class="right-border text-right ' + (value >= 0 ? 'style-blue-input':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';

                    var prev_month = 0;
                    for(var i=0;i<12;i++) {
                        value = result[ship_no]['months'][i];
                        
                        
                        month_sum[i] += value;
                        if (value == prev_month)
                            row_html += '<td style="padding-right:5px!important;height:20px!important;" class="text-right ' + (value >= 0 ? '':'style-red-input') + '">' + '' + '</td>';
                        else
                            row_html += '<td style="padding-right:5px!important;height:20px!important;" class="text-right ' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                        prev_month = result[ship_no]['months'][i];
                    }
                    row_html += "</tr>"
                    $('#table-total-profit-body').append(row_html);
                    index++;
                });
                row_html = "<tr><td class='sub-small-header style-blue-input' style='height:20px!important'>合计</td>";
                value = prev_sum;
                row_html += '<td style="padding-right:5px!important;height:20px!important;" class="right-border sub-small-header style-normal-header text-right ' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                prev_month = 0;
                for(var i=0;i<12;i++) {
                    var value = month_sum[i];
                    if (value == prev_month)
                        row_html += '<td style="padding-right:5px!important;height:20px!important;" class="sub-small-header style-normal-header text-right ' + '">' + '' + '</td>';
                    else
                        row_html += '<td style="padding-right:5px!important;height:20px!important;" class="sub-small-header style-normal-header text-right ' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                }
                row_html += "</tr>";
                $('#table-total-profit-body').append(row_html);

                // Table 2
                $('#table-income-expense-body').html('');
                var credit_sum = 0;
                var debit_sum = 0;
                var profit_sum = [];
                for(var i=0;i<16;i++) profit_sum[i] = 0;
                var index = 0;
                $("#select-table-ship option:selected").map(function () {
                    var ship_name = $(this).text();
                    var ship_no = $(this).val();
                    var row_html = "<tr class='" + ((index%2==0)?'cost-item-even':'cost-item-odd') + "'>";
                    row_html += "<td>" + ship_name + "</td>";
                    var value = result[ship_no]['credit_sum'];
                    row_html += '<td style="padding-right:5px!important;height:20px!important;" class="text-right ' + (value >= 0 ? 'style-blue-input':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                    credit_sum += value;
                    value = result[ship_no]['debit_sum'];
                    row_html += '<td style="padding-right:5px!important;height:20px!important;" class="right-border text-right ' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                    debit_sum += value;
                    var indexes = [2,1,6,4,15,3,5,7,8,9,10,11,12];
                    for(var i=0;i<indexes.length;i++) {
                        value = result[ship_no]['debits'][indexes[i]];
                        profit_sum[i] += value;
                        if (i == 4) {
                            row_html += '<td style="padding-right:5px!important;height:20px!important;" class="right-border text-right ' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                        }
                        else {
                            row_html += '<td style="padding-right:5px!important;height:20px!important;" class="text-right ' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                        }
                    }
                    row_html += "</tr>"
                    $('#table-income-expense-body').append(row_html);
                    index++;
                });
                row_html = "<tr><td class='sub-small-header style-blue-input' style='height:20px!important'>合计</td>";
                value = credit_sum;
                row_html += '<td style="padding-right:5px!important;height:20px!important;" class="sub-small-header style-normal-header text-right ' + (value >= 0 ? 'style-blue-input':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                value = debit_sum;
                row_html += '<td style="padding-right:5px!important;height:20px!important;" class="right-border sub-small-header style-normal-header text-right ' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                for(var i=0;i<13;i++) {
                    var value = profit_sum[i];
                    if (i == 4) {
                        row_html += '<td style="padding-right:5px!important;height:20px!important;" class="right-border style-red-header style-normal-header text-right ' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                    } else {
                        if (i < 4) row_html += '<td style="padding-right:5px!important;height:20px!important;" class="style-red-header style-normal-header text-right ' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                        else row_html += '<td style="padding-right:5px!important;height:20px!important;" class="sub-small-header style-normal-header text-right ' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                    }
                }
                row_html += "</tr>";
                $('#table-income-expense-body').append(row_html);
            }
        });

        $.ajax({
            url: BASE_URL + 'ajax/business/dynamic/multiSearch',
            type: 'post', 
            data: {
                'year':year_table,
                'shipId':shipids_table,
            },
            success: function(result) {
                $('#table-economic-days-body').html('');
                var index = 0;
                $("#select-table-ship option:selected").map(function () {
                    var ship_name = $(this).text();
                    var ship_no = $(this).val();

                    let data = result[ship_no]['currentData'];
                    let voyData = result[ship_no]['voyData'];
                    let cpData = result[ship_no]['cpData'];

                    let list = [];
                    let realData = [];
                    let footerData = [];
                    footerData['voy_count'] = 0;
                    footerData['total_count'] = 0;
                    footerData['average_speed'] = 0;
                    footerData['voy_start'] = '';
                    footerData['voy_end'] = '';
                    footerData['economic_rate'] = '-';
                    footerData['sail_time'] = 0;
                    footerData['total_distance'] = 0;
                    footerData['total_sail_time'] = 0;
                    footerData['total_loading_time'] = 0;
                    footerData['loading_time'] = 0;
                    footerData['disch_time'] = 0;
                    footerData['total_waiting_time'] = 0;
                    footerData['total_weather_time'] = 0;
                    footerData['total_repair_time'] = 0;
                    footerData['total_supply_time'] = 0;
                    footerData['total_else_time'] = 0;

                    if(voyData.length > 0) {
                        voyData.forEach(function(value, key) {
                            let tmpData = data[value];
                            let total_sail_time = 0;
                            let total_loading_time = 0;
                            let loading_time = 0;
                            let disch_time = 0;
                            let total_waiting_time = 0;
                            let total_weather_time = 0;
                            let total_repair_time = 0;
                            let total_supply_time = 0;
                            let total_else_time = 0;
                            let total_distance = 0;

                            realData = [];
                            realData['voy_no'] = value;
                            realData['voy_count'] = tmpData.length - 1;
                            realData['voy_start'] = tmpData[0]['Voy_Date'] + ' ' + tmpData[0]['Voy_Hour'] + ':' + tmpData[0]['Voy_Minute'];
                            realData['voy_end'] = tmpData[tmpData.length - 1]['Voy_Date'] + ' ' + tmpData[tmpData.length - 1]['Voy_Hour'] + ':' + tmpData[tmpData.length - 1]['Voy_Minute'];
                            realData['lport'] = cpData[value]['LPort'] == false ? '-' : cpData[value]['LPort'];
                            realData['dport'] = cpData[value]['DPort'] == false ? '-' : cpData[value]['DPort'];
                            //realData['sail_time'] = __getTermDay(realData['voy_start'], realData['voy_end'], tmpData[0]['GMT'], tmpData[tmpData.length - 1]['GMT']);
                            
                            tmpData.forEach(function(data_value, data_key) {
                                total_distance += data_key > 0 ? __parseFloat(data_value["Sail_Distance"]) : 0;
                                if(data_key > 0) {
                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_SALING) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                        total_sail_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                    }

                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_LOADING) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                        loading_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                    }

                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_DISCH) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                        disch_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                    }

                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_WAITING) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                        total_waiting_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                    }

                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_WEATHER) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                        total_weather_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                    }

                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_REPAIR) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'];
                                        total_repair_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                    }

                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_SUPPLY) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'];
                                        total_supply_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                    }

                                    if(data_value['Voy_Type'] == DYNAMIC_SUB_ELSE) {
                                        let preKey = data_key - 1;
                                        let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                        let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'];
                                        total_else_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                        //if(value == '2017') console.log(total_else_time)
                                    }
                                }
                            });

                            realData.total_sail_time = total_sail_time;
                            realData.total_distance = total_distance;
                            realData.average_speed = BigNumber(realData.total_distance).div(total_sail_time).div(24);
                            realData.loading_time = loading_time.toFixed(COMMON_DECIMAL);
                            realData.disch_time = disch_time.toFixed(COMMON_DECIMAL);
                            realData.total_loading_time = BigNumber(__parseFloat(loading_time.toFixed(2))).plus(__parseFloat(disch_time.toFixed(2))).plus(__parseFloat(total_sail_time.toFixed(2)));
                            //realData.economic_rate = BigNumber(realData.total_loading_time).div(__parseFloat(realData.sail_time.toFixed(2))).multipliedBy(100).toFixed(1);
                            
                            realData.total_waiting_time = total_waiting_time.toFixed(COMMON_DECIMAL);
                            realData.total_weather_time = total_weather_time.toFixed(COMMON_DECIMAL);
                            realData.total_repair_time = total_repair_time.toFixed(COMMON_DECIMAL);
                            realData.total_supply_time = total_supply_time.toFixed(COMMON_DECIMAL);
                            realData.total_else_time = total_else_time.toFixed(COMMON_DECIMAL);
                            realData.non_economic_date = BigNumber(__parseFloat(realData.total_waiting_time)).plus(__parseFloat(realData.total_weather_time)).plus(__parseFloat(realData.total_repair_time)).plus(__parseFloat(realData.total_supply_time)).plus(__parseFloat(realData.total_else_time))
                            realData['sail_time'] = __parseFloat(realData.non_economic_date) + __parseFloat(realData.total_loading_time);
                            realData.economic_rate = BigNumber(realData.total_loading_time).div(__parseFloat(realData.sail_time.toFixed(2))).multipliedBy(100).toFixed(1);

                            // Calc Footer data
                            footerData['sail_time'] += __parseFloat(realData.sail_time.toFixed(2));
                            footerData['total_count'] += __parseFloat(realData['voy_count']);
                            footerData['total_distance'] += __parseFloat(realData['total_distance']);
                            footerData['total_sail_time'] += __parseFloat(total_sail_time.toFixed(2));
                            footerData['total_loading_time'] += __parseFloat(realData['total_loading_time'].toFixed(2));
                            footerData['loading_time'] += __parseFloat(realData['loading_time']);
                            footerData['disch_time'] += __parseFloat(realData['disch_time']);
                            footerData['total_waiting_time'] += __parseFloat(realData['total_waiting_time']);
                            footerData['total_weather_time'] += __parseFloat(realData['total_weather_time']);
                            footerData['total_repair_time'] += __parseFloat(realData['total_repair_time']);
                            footerData['total_supply_time'] += __parseFloat(realData['total_supply_time']);
                            footerData['total_else_time'] += __parseFloat(realData['total_else_time']);

                            list.push(realData);
                        });

                        if (list.length > 0) {
                            footerData['voy_count'] = voyData.length;
                            footerData['voy_start'] = list[0].voy_start;
                            footerData['voy_end'] = list[list.length - 1].voy_end;
                            if (footerData['voy_start'].length > 9) {
                                footerData['voy_start'] = footerData['voy_start'].substring(0,10);
                            }
                            if (footerData['voy_end'].length > 9) {
                                footerData['voy_end'] = footerData['voy_end'].substring(0,10);
                            }
                            footerData['average_speed'] = __parseFloat(BigNumber(footerData['total_distance']).div(footerData['total_sail_time']).div(24));
                            footerData['economic_rate'] = BigNumber(footerData['loading_time']).plus(footerData['disch_time']).plus(footerData['total_sail_time']).div(footerData['sail_time']).multipliedBy(100).toFixed(1);
                        } else {
                            footerData['voy_start'] = "-";
                            footerData['voy_end'] = "-";
                        }
                    }
                    
                    var row_html = "<tr class='" + ((index%2==0)?'cost-item-even':'cost-item-odd') + "'>";
                    row_html += "<td>" + ship_name + "</td>";
                    row_html += "<td>" + footerData['voy_count'] + "</td>";
                    //row_html += "<td>" + footerData['voy_start'] + "~" + "<br>" + footerData['voy_end'] + "</td>";
                    row_html += "<td>" + footerData['voy_start'] + "~" + footerData['voy_end'] + "</td>";
                    row_html += "<td>" + _format(footerData['sail_time']) + "</td>";
                    row_html += "<td>" + _format(footerData['total_distance']) + "</td>";
                    row_html += "<td class='right-border'>" + _format(footerData['average_speed'].toFixed(1)) + "</td>";
                    row_html += "<td>" + _format(footerData['total_sail_time']+footerData['loading_time']+footerData['disch_time']) + "</td>";
                    var percent = _format((footerData['loading_time'] + footerData['disch_time'] + footerData['total_sail_time'])/footerData['sail_time']*100,1);
                    // /BigNumber(loading_time).plus(disch_time).plus(realData.total_sail_time).div(realData.sail_time).multipliedBy(100).toFixed(1);
                    row_html += "<td>" + percent + "%</td>";
                    row_html += "<td>" + _format(footerData['total_sail_time']) + "</td>";
                    row_html += "<td>" + _format(footerData['loading_time']) + "</td>";
                    row_html += "<td class='right-border'>" + _format(footerData['disch_time']) + "</td>";
                    row_html += "<td>" + _format(footerData['total_waiting_time']+footerData['total_weather_time']+footerData['total_repair_time']+footerData['total_supply_time']) + "</td>";
                    row_html += "<td>" + _format(footerData['total_waiting_time']) + "</td>";
                    row_html += "<td>" + _format(footerData['total_weather_time']) + "</td>";
                    row_html += "<td>" + _format(footerData['total_repair_time']) + "</td>";
                    row_html += "<td>" + _format(footerData['total_supply_time']) + "</td>";

                    row_html += "</tr>"
                    $('#table-economic-days-body').append(row_html);
                    index++;
                });
            }
        });

        $.ajax({
            url: BASE_URL + 'ajax/shipmanage/ctm/debits',
            type: 'post',
            data: {
                year:year_table,
                shipId:shipids_table,
            },
            success: function(data) {
                $('#table-ctm-deposit-body').html('');
                var debits_sum = [];
                for(var i=0;i<12;i++) debits_sum[i] = 0;
                var index = 0;
                $("#select-table-ship option:selected").map(function () {
                    var ship_name = $(this).text();
                    var ship_no = $(this).val();
                    var row_html = "<tr class='" + ((index%2==0)?'cost-item-even':'cost-item-odd') + "'>";
                    row_html += "<td>" + ship_name + "</td>";
                    for(var i=0;i<12;i++) {
                        var offset;
                        if (i == 0) offset = 1;
                        else if (i == 1) offset = 3;
                        else if (i == 2) offset = 4;
                        else if (i == 3) offset = 6;
                        else if (i == 4) offset = 7;
                        else if (i == 5) offset = 8;
                        else if (i == 6) offset = 11;
                        else if (i == 7) offset = 12;
                        else if (i == 8) offset = 2;
                        else if (i == 9) offset = 5;
                        else if (i == 10) offset = 9;
                        else if (i == 11) offset = 10;
                        value = data[ship_no]['total'][offset];
                        debits_sum[i] += value;
                        if (i == 0 || i == 7)
                            row_html += '<td style="padding-right:5px!important;height:20px!important;" class="text-right right-border' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                        else
                            row_html += '<td style="padding-right:5px!important;height:20px!important;" class="text-right ' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                    }
                    row_html += "</tr>"
                    $('#table-ctm-deposit-body').append(row_html);
                    index++;
                });
                row_html = "<tr><td class='sub-small-header style-blue-input' style='height:20px!important'>合计</td>";
                for(var i=0;i<12;i++) {
                    var value = debits_sum[i];
                    if (i == 7) {
                        row_html += '<td style="padding-right:5px!important;height:20px!important;" class="right-border style-red-header style-normal-header text-right ' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                    } else {
                        if (i > 0 && i < 7) row_html += '<td style="padding-right:5px!important;height:20px!important;" class="style-red-header style-normal-header text-right ' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                        else {
                            if (i == 0)
                                row_html += '<td style="padding-right:5px!important;height:20px!important;" class="sub-small-header style-normal-header text-right right-border' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                            else
                                row_html += '<td style="padding-right:5px!important;height:20px!important;" class="sub-small-header style-normal-header text-right ' + (value >= 0 ? '':'style-red-input') + '">' + (value==0?'':'$'+prettyValue2(value)) + '</td>';
                        }
                    }
                }
                row_html += "</tr>";
                $('#table-ctm-deposit-body').append(row_html);
            }
        })
    }

    function _format(value, decimal = 2) {
        return isNaN(value) || value == 0 || value == null || value == undefined ? '' : number_format(value, decimal);
    }

    function __getTermDay(start_date, end_date, start_gmt = 8, end_gmt = 8) {
        let currentDate = moment(end_date).valueOf();
        let currentGMT = DAY_UNIT * end_gmt;
        let prevDate = moment(start_date).valueOf();
        let prevGMT = DAY_UNIT * start_gmt;
        let diffDay = 0;
        currentDate = BigNumber(currentDate).minus(currentGMT).div(DAY_UNIT);
        prevDate = BigNumber(prevDate).minus(prevGMT).div(DAY_UNIT);
        diffDay = currentDate.minus(prevDate);
        return parseFloat(diffDay.div(24).toFixed(4));
    }

    function fnExcelTableReport()
    {
        if (shipids_table == null || shipids_table == undefined) return;

        var tab_text = "";
        for (var index=0;index<4;index++) {
            tab_text +="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            
            var real_tab;
            if (index == 0) {
                real_tab = document.getElementById('table-total-profit');
            } else if (index == 1) {
                real_tab = document.getElementById('table-income-expense');
            } else if (index == 2) {
                real_tab = document.getElementById('table-economic-days');
            } else if (index == 3) {
                real_tab = document.getElementById('table-ctm-deposit');
            }

            var tab = real_tab.cloneNode(true);
            if (index == 0) {
                tab_text=tab_text+"<tr><td colspan='14' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#table_first_title').html() + " " + year_table + "年"+ "利润</td></tr>";
            } else if(index == 1) {
                tab_text=tab_text+"<tr><td colspan='16' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#table_first_title').html() + " " + year_table + "年"+ "收支</td></tr>";
            } else if(index == 2) {
                tab_text=tab_text+"<tr><td colspan='16' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#table_first_title').html() + " " + year_table + "年"+ "经济天数占率</td></tr>";
            } else if(index == 3) {
                tab_text=tab_text+"<tr><td colspan='13' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#table_first_title').html() + " " + year_table + "年"+ "CTM支出</td></tr>";
            }
            
            for(var j = 0; j < tab.rows.length ; j++)
            {
                if (j == 0) {
                    for (var i=1; i<tab.rows[j].childElementCount*2;i+=2) {
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab.rows[j].childNodes[1].style.width = '80px';
                }
                if (j == 1) {
                    if (index == 2) {
                        for (var i=1; i<tab.rows[j].childElementCount*2;i+=2) {
                            tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                        }
                    }
                }
                else if (j == (tab.rows.length - 1))
                {
                    if (index != 2) {
                        for (var i=0; i<tab.rows[j].childElementCount;i++) {
                            tab.rows[j].childNodes[i].style.fontWeight = "bold";
                            tab.rows[j].childNodes[i].style.backgroundColor = '#ebf1de';
                        }
                    }
                }
                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";
        }
        tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
        tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
        tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

        var filename = '收支(综合)_' + $('#table_first_title').html() + '_' + year_table;
        exportExcel(tab_text, filename, filename);
        
        return 0;
    }

    </script>
@endsection
