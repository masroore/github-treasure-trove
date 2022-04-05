@extends('layout.header')
<?php
$isHolder = Session::get('IS_HOLDER');
$ships = Session::get('shipList');
?>
@section('styles')
    <link href="{{ cAsset('css/pretty.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/dycombo.css') }}" rel="stylesheet"/>
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
    <script src="{{ cAsset('/assets/js/highcharts-3d.js') }}"></script>
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
            <div class="space-4 for-pc"></div>
            <div class="col-md-12 margin-for-mobile">
                <div class="row">
                    <div class="tabbable">
                        <ul class="nav nav-tabs ship-register for-pc" id="importTab">
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
                            <li id="li_soa">
                                <a data-toggle="tab" href="#tab_soa">
                                    SOA
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
                                        <label class="custom-label d-inline-block font-bold for-pc" style="padding: 6px;">船名:</label>
                                        <select class="custom-select d-inline-block" id="select-graph-ship" style="width:80px">
                                            <?php $index = 0 ?>
                                            @foreach($shipList as $ship)
                                                <?php $index ++ ?>
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
                                        <div class="btn-group f-right">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top:4px;width:98%!important;">
                                    <div class="row" style="text-align:center;">
                                        <strong class="for-pc" style="font-size: 20px; padding-top: 6px;">1. 利润分析</strong>
                                        <div class="space-4"></div>
                                        <div class="space-4 for-pc"></div>
                                        <div class="card for-pc-border">
                                            <div class="space-8 for-pc"></div>
                                            <strong><span id="graph-first-title"style="font-size: 16px; padding-top: 6px;"></span></strong>
                                            <div class="space-8 for-pc"></div>
                                            <div class="card graph-height-300" id="graph_first" style="border:3px double #bbb7b7">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="space-10 for-pc"></div>
                                    <div class="row" style="text-align:center;">
                                        <strong class="for-pc" style="font-size: 20px; padding-top: 6px;">2. 收支分析</strong>
                                        <div class="space-8 for-pc"></div>
                                        <div class="card for-pc-border">
                                            <div class="space-8 for-pc"></div>
                                            <strong><span id="graph-second-title"style="font-size: 16px; padding-top: 6px;"></span></strong>
                                            <div class="space-8 for-pc"></div>
                                            <div class="card" id="graph_second" style="border:3px double #bbb7b7">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="space-10 for-pc"></div>
                                    <div class="row" style="text-align:center;">
                                        <strong class="for-pc" style="font-size: 20px; padding-top: 6px;">3. 支出分析</strong>
                                        <div class="space-8 for-pc"></div>
                                        <div class="card for-pc-border">
                                            <div class="space-8 for-pc"></div>
                                            <strong><span id="graph-third-title"style="font-size: 16px; padding-top: 6px;"></span></strong>
                                            <div class="space-8 for-pc"></div>
                                            <div class="graph-height" id="graph_third" style="border:3px double #bbb7b7">
                                            </div>
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
                                        <select class="custom-select d-inline-block" id="select-table-ship" style="width:80px">
                                            <!--option value="" selected></option-->
                                            <?php $index = 0 ?>
                                            @foreach($shipList as $ship)
                                                <?php $index ++ ?>
                                                <option value="{{ $ship['IMO_No'] }}" data-name="{{$ship['shipName_En']}}">{{$ship['NickName']}}</option>
                                            @endforeach
                                        </select>
                                        <select name="select-table-year" id="select-table-year" style="font-size:13px">
                                            @for($i=date("Y");$i>=$start_year;$i--)
                                            <option value="{{$i}}" @if($i==date("Y")) selected @endif>{{$i}}年</option>
                                            @endfor
                                        </select>
                                        <strong class="f-right" style="font-size: 20px; padding-top: 6px;"><span id="table_info"></span>收支分析表</strong>
                                    </div>
                                    <div class="col-md-5" style="padding:unset!important">
                                        <div class="btn-group f-right">
                                            <a onclick="javascript:fnExcelTableReport();" class="btn btn-warning btn-sm excel-btn">
                                                <i class="icon-table"></i>{{ trans('common.label.excel') }}
                                            </a>
                                            <a onclick="javascript:popupTable();" class="btn btn-success btn-sm">
                                                <i class="icon-zoom-in"></i>全屏
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top:4px;">
                                    <div id="item-manage-dialog" class="hide"></div>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="row">
                                        <div class="table-head-fix-div" id="div-income-expense" style="height: 700px">
                                            <table id="table-income-expense-list" data-toggle="table" style="table-layout:fixed;">
                                                <thead class="">
                                                <tr>
                                                    <th class="text-center style-normal-header" rowspan="2" style="width: 2.5%;"><span>航次</span></th>
                                                    <th class="text-center style-normal-header" rowspan="2" style="width: 2.5%;"><span>租船种类</span></th>
                                                    <th class="text-center style-normal-header" rowspan="2" style="width: 6%;"><span>截止日期</span></th>
                                                    <th class="text-center style-normal-header" rowspan="2" style="width: 3%;"><span>航次用时</span></th>
                                                    <th class="text-center style-normal-header" rowspan="2" style="width: 5.5%;"><span>收入($)</span></th>
                                                    <th class="text-center style-normal-header" rowspan="2" style="width: 5.5%;"><span>支出($)</span></th>
                                                    <th class="text-center style-normal-header" rowspan="2" style="width: 5.5%;"><span>利润($)</span></th>
                                                    <th class="text-center style-normal-header right-border" rowspan="2" style="width: 7%;"><span>利润累计</span></th>
                                                    <th class="text-center style-normal-header" colspan="13"><span>支出分类 ($)</span></th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center style-red-header" style="width: 4%;"><span>油款</span></th>
                                                    <th class="text-center style-red-header" style="width: 4%;"><span>港费</span></th>
                                                    <th class="text-center style-red-header" style="width: 4%;"><span>劳务费</span></th>
                                                    <th class="text-center style-red-header" style="width: 4%;"><span>CTM</span></th>
                                                    <th class="text-center style-red-header right-border" style="width: 4%;"><span>其他</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>工资</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>伙食费</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>物料费</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>修理费</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>管理费</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>保险费</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>检验费</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>证书费</span></th>
                                                </tr>
                                                </thead>
                                                <tbody class="" id="table-income-expense-body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="keep_list" name="keep_list"></input>
                        </div>
                        <div id="tab_soa" class="tab-pane col-md-9">
                            <div class="page-header">
                                <div class="col-sm-3">
                                    <h4><b>SOA</b></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-7">
                                        <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名:</label>
                                        <select class="custom-select d-inline-block" id="select-soa-ship" style="width:80px">
                                            <?php $index = 0 ?>
                                            @foreach($shipList as $ship)
                                                <?php $index ++ ?>
                                                <option value="{{ $ship['IMO_No'] }}" data-name="{{$ship['shipName_En']}}">{{$ship['NickName']}}</option>
                                            @endforeach
                                        </select>
                                        <label class="custom-label d-inline-block font-bold" style="padding: 6px;">航次:</label>
                                        <select name="select-soa-contract" id="select-soa-contract" style="font-size:13px;width:80px;">
                                        </select>
                                        <label class="custom-label d-inline-block font-bold" style="padding: 6px;">币类:</label>
                                        <select name="select-soa-currency" id="select-soa-currency" onchange="javascript:selectCurrency()" style="padding-left:unset!important;color:#1565C0!important;">
                                            <option value="CNY" style="color:red!important;">¥</option>
                                            <option value="USD" style="color:#1565C0!important;" selected>$</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5" style="padding:unset!important">
                                        <div class="btn-group f-right">
                                            <a onclick="javascript:gotoDetailPage();" class="btn btn-primary btn-sm excel-btn">
                                                <i class="icon-bar-chart"></i> 船舶动态
                                            </a>
                                            <a onclick="javascript:fnExcelSOAReport();" class="btn btn-warning btn-sm excel-btn">
                                                <i class="icon-table"></i>{{ trans('common.label.excel') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top:4px;">
                                    <div class="space-10"></div>
                                    <div class="row" style="text-align:center;">
                                        <strong style="font-size: 20px; padding-top: 6px;"><span id="soa_title"></span>合同简要</strong>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="row">
                                        <table id="table-soa-general-info" style="width:100%;table-layout:fixed;">
                                            <thead class="">
                                                <tr>
                                                    <th class="text-center style-normal-header" style="width: 8%;"><span>种类</span></th>
                                                    <th class="text-center style-normal-header" style="width: 9%;"><span>合同日期</span></th>
                                                    <th class="text-center style-normal-header" style="width: 15%;"><span>货名</span></th>
                                                    <th class="text-center style-normal-header" style="width: 7%;"><span>货量(租期)</span></th>
                                                    <th class="text-center style-normal-header" style="width: 19%;"><span>装港</span></th>
                                                    <th class="text-center style-normal-header" style="width: 19%;"><span>卸港</span></th>
                                                    <th class="text-center style-normal-header" style="width: 15%;"><span>运费率(日租金)</span></th>
                                                    <th class="text-center style-normal-header" style="width: 8%;"><span>合同原本</span></th>
                                                </tr>
                                                </thead>
                                                <tbody class="" id="table-soa-general-body">
                                                    <tr>
                                                        <td class="text-center" id="contract_type" style="height:20px;"></td>
                                                        <td class="text-center" id="contract_date"></td>
                                                        <td class="text-center" id="contract_content"></td>
                                                        <td class="text-center" id="contract_amount"></td>
                                                        <td class="text-center" id="contract_signon_port"></td>
                                                        <td class="text-center" id="contract_signoff_port"></td>
                                                        <td class="text-center" id="contract_unit"></td>
                                                        <td class="text-center" id="contract_attachment"></td>
                                                    </tr>
                                                </tbody>
                                        </table>
                                    </div>
                                    <div class="space-10"></div>
                                    <div class="row" style="text-align:center;">
                                        <strong class="text-center" style="font-size: 20px; padding-top: 6px;"><span id="soa_info"></span>SOA</strong>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="row">
                                        <div class="head-fix-div" id="div-income-expense" style="max-height: 500px; padding-right: 1px;">
                                            <table id="table-soa-list" style="table-layout:fixed;">
                                                <thead class=""> 
                                                <tr>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>No</span></th>
                                                    <th class="text-center style-normal-header" style="width: 9%;"><span>日期</span></th>
                                                    <th class="text-center style-normal-header" style="width: 35%;"><span>摘要</span></th>
                                                    <th class="text-center style-normal-header" style="width: 12%;"><span>收支种类</span></th>
                                                    <th class="text-center style-normal-header" style="width: 12%;"><span>收入</span></th>
                                                    <th class="text-center style-normal-header" style="width: 12%;"><span>支出</span></th>
                                                    <th class="text-center style-normal-header" style="width: 5%;"><span>汇率</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>原始<br/>凭证</span></th>
                                                </tr>
                                                </thead>
                                                <tbody class="" id="table-soa-list-body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-expense-table" class="modal" aria-hidden="true" style="display: none; margin-top: 15%;">
            <div id="" class="" style="background:white;">
                <table id="modal-expense-table-body" data-toggle="table" style="max-width:unset!important;table-layout:fixed;">
                </table>
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
    
    <?php
	echo '<script>';
    echo 'var start_year = ' . $start_year . ';';
    echo 'var now_year = ' . date("Y") . ';';
    echo 'var FeeTypeData = ' . json_encode(g_enum('FeeTypeData')) . ';';
	echo '</script>';
	?>

    <script>
        var token = '{!! csrf_token() !!}';

        var year_graph;
        var year_table;
        var year_soa;

        var shipid_graph;
        var shipid_table;
        var shipid_soa;

        var listTable = null;
        var table_sums = [];
        var dest_obj;

        year_graph = $("#select-graph-year option:selected").val();
        shipid_graph = $("#select-graph-ship").val();
        var graph_title = $("#select-graph-ship option:selected").attr('data-name') + ' ' + year_graph + '年 ';
        $('#graph-first-title').html(graph_title + '利润&利润累计')
        $('#graph-second-title').html(graph_title + '收支')
        $('#graph-third-title').html(graph_title + '支出')
        initGraph();
        
        var clicked_voyno = null;
        var soa_shipid = window.localStorage.getItem("soa_shipid");
        var soa_voyNo = window.localStorage.getItem("soa_voyNo");
        if (soa_shipid != 'null' && soa_shipid != null && soa_shipid != undefined && soa_shipid != '')
        {
            window.localStorage.setItem("soa_shipid",null);
            window.localStorage.setItem("soa_voyNo",null);
            $('#select-soa-ship').val(soa_shipid);
            if (soa_voyNo != 'null' && soa_voyNo != null && soa_voyNo != undefined && soa_voyNo != '') 
            {
                clicked_voyno = soa_voyNo;
                getVoyList(soa_shipid);
                if (listSOATable == null) {
                    shipid_soa = soa_shipid;
                    voyNo_soa = soa_voyNo;
                    currency_soa = $('#select-soa-currency').val();
                }
            }
            else
            {
                getVoyList(soa_shipid);
                if (listSOATable == null) {
                    shipid_soa = soa_shipid;
                    //voyNo_soa = soa_voyNo;
                    currency_soa = $('#select-soa-currency').val();
                }
            }

            $('a[href="#tab_soa"]').trigger('click');
        }

        var color_table = ['#73b7ff','#ff655c','#50bc16','#ffc800','#9d00ff','#ff0000','#795548','#3f51b5','#00bcd4','#e91e63','#0000ff','#00ff00','#0d273a'];
        function drawFirstGraph(labels,datasets) {
            Highcharts.setOptions({
                lang: {
                    thousandsSep: ','
                }
            });
            
            Highcharts.chart('graph_first', {
                title: {
                    text: null
                },
                xAxis: {
                    categories: labels
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
                labels: {
                    items: [{
                        html: null,
                        style: {
                            left: '50px',
                            top: '18px',
                            color: ( // theme
                                Highcharts.defaultOptions.title.style &&
                                Highcharts.defaultOptions.title.style.color
                            ) || 'black'
                        }
                    }]
                },
                credits: {
                    enabled: false
                },
                tooltip: {
                    valueDecimals: 0,
                },
                series: [{
                    type: 'areaspline',
                    name: '利润累计($)',
                    data: datasets[0].data,
                    lineColor: "#735df8",
                    lineWidth: 2,
                    color: {
                        linearGradient: {
                            x1: 0,
                            x2: 0,
                            y1: 0,
                            y2: 1
                        },
                        stops: [
                            [0, 'cyan'],
                            [1, '#ff9f9f']
                        ]
                    },
                }, {
                    type: 'column',
                    name: '利润($)',
                    color: '#735df8',
                    data: datasets[1].data
                }],
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 768,
                        },
                        chartOptions: {
                            yAxis: {
                                allowDecimals: false,
                                title: {
                                    text: null
                                },
                                labels: {
                                    formatter: function() {
                                        if (this.value < 0) {
                                            return '<label style="color:red">' + '$ ' + prettyValue2(this.value/1000) + 'K</label>';
                                        }
                                        else return '$ ' + prettyValue2(this.value / 1000) + 'K';
                                    },
                                    style: {
                                        fontSize: '6px',
                                        padding: '0px'
                                    }
                                },
                                plotLines: [{
                                    value: 0,
                                    width: 2,
                                    color: '#000'
                                }],
                            },
                            xAxis: {
                                lineWidth: 1,
                                labels: {
                                    style: {
                                        fontSize: '6px'
                                    }
                                }
                            },
                        }
                    }]
                }
            });
        }

        function drawSecondGraph(labels,datasets) {
            new Chart(document.getElementById("second-chart"), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += '$ ' + prettyValue2(context.parsed.y);
                                    }
                                    return label;
                                },
                            }
                        }
                    },
                    scales: {
                        /*
                        xAxes: [{
                            ticks: {
                                autoSkip: false,
                                maxRotation: 90,
                                minRotation: 90,
                                font: function(context) {
                                    var width = context.chart.width;
                                    if (width <= 768) {
                                        return {
                                            size: 6
                                        };
                                    }
                                },
                            }
                        }],
                        */
                        x: {
                            ticks: {
                                font: function(context) {
                                    var width = context.chart.width;
                                    if (width <= 768) {
                                        return {
                                            size: 6
                                        };
                                    }
                                },
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45,
                            }
                        },
                        y: {
                            ticks: {
                                callback: function(value, index, values) {
                                    //var context = document.getElementById('second-chart').getContext('2d');
                                    //var width = context.width;
                                    return '$ ' + prettyValue2(value);
                                },
                                font: function(context) {
                                    var width = context.chart.width;
                                    if (width <= 768) {
                                        return {
                                            size: 6
                                        };
                                    }
                                },
                            }
                        },
                    }
                }
            });
        }
        
        function drawThirdGraph(datasets, costs) {
            $('#graph_third').html('');

            Highcharts.chart('graph_third', {
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45
                    }
                },
                title: {
                    text: null
                },
                subtitle: {
                    text: null
                },
                plotOptions: {
                    pie: {
                        innerSize: 100,
                        depth: 45
                    }
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Percentage',
                    /*
                    data: [
                        [name:'油款('+datasets[0]+'%)', y:datasets[0], custom:datasets[0]]
                        /*,
                        ['港费('+datasets[1]+'%)', datasets[1]],
                        ['劳务费('+datasets[2]+'%)',datasets[2]],
                        ['CTM('+datasets[3]+'%)',datasets[3]],
                        ['其他('+datasets[4]+'%)',datasets[4]],
                        ['工资('+datasets[5]+'%)',datasets[5]],
                        ['伙食费('+datasets[6]+'%)',datasets[6]],
                        ['物料费('+datasets[7]+'%)',datasets[7]],
                        ['修理费('+datasets[8]+'%)',datasets[8]],
                        ['管理费('+datasets[9]+'%)',datasets[9]],
                        ['保险费('+datasets[10]+'%)',datasets[10]],
                        ['检验费('+datasets[11]+'%)',datasets[11]],
                        ['证书费('+datasets[12]+'%)',datasets[12]]
                        */
                    //]
                    data: [
                        {
                            name: '油款('+datasets[0]+'%)',
                            y: datasets[0],
                            custom: costs[0],
                        },
                        {
                            name: '港费('+datasets[1]+'%)',
                            y: datasets[1],
                            custom: costs[1],
                        },
                        {
                            name: '劳务费('+datasets[2]+'%)',
                            y: datasets[2],
                            custom: costs[2],
                        },
                        {
                            name: 'CTM('+datasets[3]+'%)',
                            y: datasets[3],
                            custom: costs[3],
                        },
                        {
                            name: '其他('+datasets[4]+'%)',
                            y: datasets[4],
                            custom: costs[4],
                        },
                        {
                            name: '工资('+datasets[5]+'%)',
                            y: datasets[5],
                            custom: costs[5],
                        },
                        {
                            name: '伙食费('+datasets[6]+'%)',
                            y: datasets[6],
                            custom: costs[6],
                        },
                        {
                            name: '物料费('+datasets[7]+'%)',
                            y: datasets[7],
                            custom: costs[7],
                        },
                        {
                            name: '修理费('+datasets[8]+'%)',
                            y: datasets[8],
                            custom: costs[8],
                        },
                        {
                            name: '管理费('+datasets[9]+'%)',
                            y: datasets[9],
                            custom: costs[9],
                        },
                        {
                            name: '检验费('+datasets[10]+'%)',
                            y: datasets[10],
                            custom: costs[10],
                        },
                        {
                            name: '检验费('+datasets[11]+'%)',
                            y: datasets[11],
                            custom: costs[11],
                        },
                        {
                            name: '证书费('+datasets[12]+'%)',
                            y: datasets[12],
                            custom: costs[12],
                        }
                    ],
                    dataLabels: {
                        style: {
                            fontSize: 14
                        }
                    }
                }],
                tooltip: {
                    valueSuffix: "%",
                    formatter: function() {
                        return this.point.name + '<b>:$ ' + prettyValue(this.point.custom) + '</b>';
                    }
                },
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 768,
                        },
                        title: {
                            text: null
                        },
                        subtitle: {
                            text: null
                        },
                        chartOptions: {
                            plotOptions: {
                                pie: {
                                    innerSize: 30,
                                    depth: 15
                                }
                            },
                            series: [{
                                name: 'Percentage',
                                data: [
                                    {
                                        name: '油款('+datasets[0]+'%)',
                                        y: datasets[0],
                                        custom: costs[0],
                                    },
                                    {
                                        name: '港费('+datasets[1]+'%)',
                                        y: datasets[1],
                                        custom: costs[1],
                                    },
                                    {
                                        name: '劳务费('+datasets[2]+'%)',
                                        y: datasets[2],
                                        custom: costs[2],
                                    },
                                    {
                                        name: 'CTM('+datasets[3]+'%)',
                                        y: datasets[3],
                                        custom: costs[3],
                                    },
                                    {
                                        name: '其他('+datasets[4]+'%)',
                                        y: datasets[4],
                                        custom: costs[4],
                                    },
                                    {
                                        name: '工资('+datasets[5]+'%)',
                                        y: datasets[5],
                                        custom: costs[5],
                                    },
                                    {
                                        name: '伙食费('+datasets[6]+'%)',
                                        y: datasets[6],
                                        custom: costs[6],
                                    },
                                    {
                                        name: '物料费('+datasets[7]+'%)',
                                        y: datasets[7],
                                        custom: costs[7],
                                    },
                                    {
                                        name: '修理费('+datasets[8]+'%)',
                                        y: datasets[8],
                                        custom: costs[8],
                                    },
                                    {
                                        name: '管理费('+datasets[9]+'%)',
                                        y: datasets[9],
                                        custom: costs[9],
                                    },
                                    {
                                        name: '检验费('+datasets[10]+'%)',
                                        y: datasets[10],
                                        custom: costs[10],
                                    },
                                    {
                                        name: '检验费('+datasets[11]+'%)',
                                        y: datasets[11],
                                        custom: costs[11],
                                    },
                                    {
                                        name: '证书费('+datasets[12]+'%)',
                                        y: datasets[12],
                                        custom: costs[12],
                                    }
                                ],
                                dataLabels: {
                                    style: {
                                        fontSize: 8
                                    }
                                }
                            }],
                        }
                    }]
                }
            });
        }

        function washData(datasets) {
            var data = [...datasets];
            for (var i=data.length-1;i>0;i--) {
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
        
        function initGraph() {
            var datasets1 = [];
            var labels1 = [];

            var datasets2 = [];
            var labels2 = [];

            datasets1[0] = {};
            datasets1[1] = {}
            datasets1[0].data = [];
            datasets1[0].label = '利润累计';
            //73b7ff','#ff655c','#50bc16','#ffc800','#9d00ff','#ff0000','#795548','#3f51b5','#00bcd4','#e91e63','#0000ff','#00ff00','#0d273a'];

            $('#graph_first').html('');
            $('#graph_first').append('<canvas id="first-chart" height="250" class="chartjs-demo"></canvas>');

            var bar_ctx = document.getElementById('first-chart').getContext('2d');
            var cyan_red_gradient = bar_ctx.createLinearGradient(0, 100, 0, 200);
            cyan_red_gradient.addColorStop(0, 'cyan');
            cyan_red_gradient.addColorStop(1, 'red');

            datasets1[0].borderColor = '#3f51b5';
            datasets1[0].backgroundColor = cyan_red_gradient;
            datasets1[0].fill = true;
            datasets1[0].type = 'line';
            datasets1[0].order = 1;
            datasets1[1].data = [];
            datasets1[1].label = '利润($)';
            datasets1[1].borderColor = 'black';
            datasets1[1].backgroundColor = '#735ff1';
            datasets1[1].order = 0;

            $('#graph_second').html('');
            $('#graph_second').append('<canvas id="second-chart" height="250" class="chartjs-demo"></canvas>');

            bar_ctx = document.getElementById('second-chart').getContext('2d');
            purple_orange_gradient = bar_ctx.createLinearGradient(0, 0, 0, 250);
            purple_orange_gradient.addColorStop(0, 'red');
            purple_orange_gradient.addColorStop(1, 'yellow');


            datasets2[0] = {};
            datasets2[1] = {}
            datasets2[0].data = [];
            datasets2[0].label = '收入($)';
            datasets2[0].borderColor = 'black';
            datasets2[0].backgroundColor = '#305bfc';//'#026fcd';
            datasets2[1].data = [];
            datasets2[1].label = '支出($)';
            datasets2[1].borderColor = 'black';
            datasets2[1].backgroundColor = purple_orange_gradient;//#f23e00

            var datasets3 = [];
            datasets3[0] = {};
            datasets3[0].data = [];
            for (var i=0;i<13;i++) datasets3[0].data[i] = 0;
            datasets3[0].backgroundColor = ['#73b7ff','#ff655c','#50bc16','#ffc800','#9d00ff','#ff0000','#795548','#3f51b5','#00bcd4','#e91e63','#0000ff','#00ff00','#0d273a'];

            var debit_total_sum = 0;
            $.ajax({
                url: BASE_URL + 'ajax/operation/listByShip',
                type: 'post',
                data: {'year':year_graph, 'shipId':shipid_graph},
                success: function(data, status, xhr) {
                    for(var index=0;index<data.length;index++) {
                        labels1[index] = data[index]['Voy_No'];
                        labels2[index] = data[index]['Voy_No'];
                        datasets1[0].data[index] = data[index]['total_profit'];
                        datasets1[1].data[index] = data[index]['profit_sum'];
                        datasets2[0].data[index] = data[index]['credit_sum'];
                        datasets2[1].data[index] = data[index]['debit_sum'];
                        debit_total_sum += data[index]['debit_sum'];
                        for (var i=0;i<13;i++)
                        {
                            if (i == 0) offset = 2;
                            else if (i == 1) offset = 1;
                            else if (i == 2) offset = 6;
                            else if (i == 3) offset = 4;
                            else if (i == 4) offset = 15;
                            else if (i == 5) offset = 3;
                            else if (i == 6) offset = 5;
                            else if (i == 7) offset = 7;
                            else if (i == 8) offset = 8;
                            else if (i == 9) offset = 9;
                            else if (i == 10) offset = 10;
                            else if (i == 11) offset = 11;
                            else if (i == 12) offset = 12;
                            if (data[index]['debit_list'][offset] != undefined) {
                                datasets3[0].data[i] += data[index]['debit_list'][offset];
                            }
                        }
                    }

                    var datasets3_cost = [];
                    for (var i=0;i<13;i++) {
                        if (debit_total_sum != 0) {
                            //datasets3[0].data[i] = prettyValue(datasets3[0].data[i] / debit_total_sum * 100)
                            datasets3_cost[i] = datasets3[0].data[i].toFixed(0);
                            datasets3[0].data[i] = datasets3[0].data[i] / debit_total_sum * 100;
                            datasets3[0].data[i] = parseFloat(datasets3[0].data[i].toFixed(2));
                        }
                    }

                    datasets1[0].data = washData(datasets1[0].data);
                    datasets1[1].data = washData(datasets1[1].data);

                    drawFirstGraph(labels1, datasets1);
                    drawSecondGraph(labels2,datasets2);
                    drawThirdGraph(datasets3[0].data, datasets3_cost);
                }
            });
        }

        $('#select-graph-year').on('change', function() {
            selectGraphInfo();
        });

        $('#select-graph-ship').on('change', function() {
            selectGraphInfo();
        });

        function selectGraphInfo()
        {
            year_graph = $("#select-graph-year option:selected").val();
            shipid_graph = $("#select-graph-ship").val();
            var graph_title = $("#select-graph-ship option:selected").attr('data-name') + ' ' + year_graph + '年 ';
            $('#graph-first-title').html(graph_title + '利润&利润累计');
            $('#graph-second-title').html(graph_title + '收支');
            $('#graph-third-title').html(graph_title + '支出');

            initGraph();
        }

        function initTable() {
            listTable = $('#table-income-expense-list').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                bAutoWidth: false, 
                ajax: {
                    url: BASE_URL + 'ajax/operation/listByShip',
                    type: 'POST',
                    data: {'year':year_table, 'shipId':shipid_table},
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: 'Voy_No', className: "text-center"},
                    {data: 'CP_kind', className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                ],
                createdRow: function (row, data, index) {
                    if ((index%2) == 0)
                        $(row).attr('class', 'cost-item-even');
                    else
                        $(row).attr('class', 'cost-item-odd');

                    $('td', row).eq(0).attr('class', 'text-center td_voy_no');
                    $('td', row).eq(0).attr('style', 'cursor:pointer;background:linear-gradient(#fff, #d9f8fb);');
                    /*
                    if (data['max_date'] == false) {
                        $('td', row).eq(2).html('-');
                    } else {
                        $('td', row).eq(2).html(data['max_date'].Voy_Date);
                        if (data['min_date'] != false) {
                            var start_date = data['min_date'].Voy_Date + ' ' + data['min_date'].Voy_Hour + ':' + data['min_date'].Voy_Minute;
                            var end_date = data['max_date'].Voy_Date + ' ' + data['max_date'].Voy_Hour + ':' + data['max_date'].Voy_Minute;

                            var sail_time = __getTermDay(start_date, end_date, data['min_date'].GMT, data['max_date'].GMT);
                            $('td', row).eq(3).html(sail_time.toFixed(2));
                        }
                    }
                    if (data['max_date'] == false) {
                        $('td', row).eq(3).html('-');
                    }
                    */
                    if (data['voy_time'] == false) {
                        $('td', row).eq(2).html('-');
                        $('td', row).eq(3).html('-');  
                    } else {
                        $('td', row).eq(2).html(data['voy_time']['start_date'].substr(5,5) + ' ~ ' + data['voy_time']['end_date'].substr(5,5));
                        $('td', row).eq(3).html(data['voy_time']['total_time']);
                    }

                    $('td', row).eq(4).attr('class', 'style-blue-input text-right');
                    $('td', row).eq(4).attr('style', 'padding-right:5px!important;');
                    $('td', row).eq(4).html(data['credit_sum']==0?'':prettyValue(data['credit_sum']));

                    $('td', row).eq(5).attr('class', 'text-right');
                    $('td', row).eq(5).attr('style', 'padding-right:5px!important;')
                    $('td', row).eq(5).html(data['debit_sum']==0?'':prettyValue(data['debit_sum']));

                    if (data['profit_sum'] > 0) {
                        $('td', row).eq(6).attr('class', 'style-blue-input text-right');
                    } else {
                        $('td', row).eq(6).attr('class', 'style-red-input text-right');
                    }
                    $('td', row).eq(6).attr('style', 'padding-right:5px!important;')
                    $('td', row).eq(6).html(data['profit_sum']==0?'':prettyValue(data['profit_sum']));

                    if (data['total_profit'] > 0) {
                        $('td', row).eq(7).attr('class', 'style-blue-input text-right right-border');
                    } else {
                        $('td', row).eq(7).attr('class', 'style-red-input text-right right-border');
                    }
                    $('td', row).eq(7).attr('style', 'padding-right:5px!important;')
                    //$('td', row).eq(7).html(data['total_profit']==0?'':prettyValue(data['total_profit']));
                    $('td', row).eq(7).html(data['total_profit']==0?'':(data['total_profit']==0?'':prettyValue(data['total_profit'])))

                    for (var i=1;i<16;i++)
                    {
                        if (i == 2) {   // 油款
                            dest_obj = $('td', row).eq(8);
                        }
                        else if (i == 1) { // 港费
                            dest_obj = $('td', row).eq(9);
                        }
                        else if (i == 6) { // 劳务费
                            dest_obj = $('td', row).eq(10);
                        }
                        else if (i == 4) { //CTM
                            dest_obj = $('td', row).eq(11);
                        }
                        else if (i == 15) { //其他
                            dest_obj = $('td', row).eq(12);
                        }
                        else if (i == 3) { //工资
                            dest_obj = $('td', row).eq(13);
                        }
                        else if (i == 5) { //伙食费
                            dest_obj = $('td', row).eq(14);
                        }
                        else if (i == 7) { // 物料费
                            dest_obj = $('td', row).eq(15);
                        }
                        else if (i == 8) { // 修理费
                            dest_obj = $('td', row).eq(16);
                        }
                        else if (i == 9) { // 管理费
                            dest_obj = $('td', row).eq(17);
                        }
                        else if (i == 10) { // 保险费
                            dest_obj = $('td', row).eq(18);
                        }
                        else if (i == 11) { // 检验费
                            dest_obj = $('td', row).eq(19);
                        }
                        else if (i == 12) { // 证书费
                            dest_obj = $('td', row).eq(20);
                        }
                        else {
                            dest_obj = null;
                        }

                        if (i == 15) {
                            $(dest_obj).attr('class', 'text-right right-border');
                        }

                        if (data['debit_list'][i] != undefined)
                        {
                            if (i == 15) {
                                $(dest_obj).attr('class', 'text-right right-border');
                            } else {
                                $(dest_obj).attr('class', 'text-right');
                            }
                            
                            $(dest_obj).attr('style', 'padding-right:5px!important;')
                            /*
                            if ((i==1) || (i==2) || (i==4)|| (i==6) || (i==15)) {
                                $(dest_obj).attr('style', 'padding-right:5px!important;color:#9c9c9c!important')
                            } else {
                                $(dest_obj).attr('style', 'padding-right:5px!important;')
                            }
                            */

                            $(dest_obj).html(prettyValue(data['debit_list'][i]));
                        }
                        else {
                            if (dest_obj != null) $(dest_obj).html('');
                        }
                    }
                },
                drawCallback: function (response) {
                    setEvents();
                    if (response.json.data.length <= 0) return;
                    var tab = document.getElementById('table-income-expense-body');
                    var i,j;
                    for (i=0;i<18;i++) table_sums[i] = 0;
                    for(var j=0; j<tab.rows.length; j++)
                    {
                        for (var i=0;i<18;i++)
                        {
                            var value_str = tab.rows[j].childNodes[3+i].innerHTML;
                            if ((value_str != "") && (value_str != "-"))
                            {
                                if (i == 4) {
                                    table_sums[i] = parseFloat(value_str.replaceAll(",",""));
                                }
                                else {
                                    table_sums[i] += parseFloat(value_str.replaceAll(",",""));
                                }
                            }
                        }
                    }
                    
                    var report_html = "";
                    report_html = "<tr style='height:30px;'><td style='box-shadow: inset 0 -1px #000, 1px -1px #000;' class='table-footer style-normal-header sub-small-header text-center disable-td'>" + response.json.data.length + "</td>";
                    report_html += "<td style='box-shadow: inset 0 -1px #000, 1px -1px #000;' class='table-footer sub-small-header disable-td'></td><td style='box-shadow: inset 0 -1px #000, 1px -1px #000;' class='table-footer sub-small-header disable-td'></td>";
                    report_html += "<td style='box-shadow: inset 0 -1px #000, 1px -1px #000;' class='table-footer style-normal-header sub-small-header text-center'>" + (table_sums[0]==0?'':prettyValue(table_sums[0])) + "</td>";
                    report_html += "<td style='box-shadow: inset 0 -1px #000, 1px -1px #000;padding:5px!important;' class='table-footer style-normal-header sub-small-header text-right style-blue-input'>" + (table_sums[1]==0?'':prettyValue(table_sums[1])) + "</td>";
                    for(i=2;i<18;i++)
                    {
                        if (i==3 || i==4)
                            report_html += "<td style='box-shadow: inset 0 -1px #000, 1px -1px #000;padding:5px!important;' class='table-footer style-normal-header sub-small-header text-right " + (table_sums[i]>=0?'style-blue-input':'style-red-input') + "' style='padding:5px!important;'>" + (table_sums[i]==0?'':prettyValue(table_sums[i])) + "</td>";
                        else if (i>=5&&i<=9)
                            report_html += "<td style='box-shadow: inset 0 -1px #000, 1px -1px #000;padding:5px!important;' class='table-footer style-normal-header sub-small-header style-red-header text-right " + (table_sums[i]>=0?'':'style-red-input') + "' style='padding:5px!important;'>" + (table_sums[i]==0?'':prettyValue(table_sums[i])) + "</td>";
                        else
                            report_html += "<td style='box-shadow: inset 0 -1px #000, 1px -1px #000;padding:5px!important;' class='table-footer style-normal-header sub-small-header text-right " + (table_sums[i]>=0?'':'style-red-input') + "' style='padding:5px!important;'>" + (table_sums[i]==0?'':prettyValue(table_sums[i])) + "</td>";
                    }
                    report_html += "</tr>";
                    $('#table-income-expense-body').append(report_html);
                }
            });

            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }

        function changeTableShip() {
            shipid_table = $('#select-table-ship').val();
            selectTableInfo();
        }

        $('#select-table-year').on('change', function() {
            selectTableInfo();
        });

        $('#select-table-ship').on('change', function() {
            selectTableInfo();
        });

        function selectTableInfo()
        {
            year_table = $("#select-table-year option:selected").val();
            shipid_table = $("#select-table-ship").val();
            $('#table_info').html('"' + $("#select-table-ship option:selected").attr('data-name') + '" ' + year_table + '年 ');

            if (listTable == null) {
                initTable();
            }
            else
            {
                listTable.column(1).search(year_table, false, false);
                listTable.column(2).search(shipid_table, false, false).draw();
            }
        }

        function prettyValue(value)
        {
            if(value == undefined || value == null) return '';
            return parseFloat(value).toFixed(2).replaceAll(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
        }

        const DAY_UNIT = 1000 * 3600;
        const COMMON_DECIMAL = 2;

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


        // SOA
        var voyNo_soa;
        var voyType_soa;
        var currency_soa;
        var voyID_soa;
        var listSOATable = null;
        var SOA_credit_sum = 0;
        var SOA_debit_sum = 0;

        function initSOATable() {
             listSOATable = $('#table-soa-list').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/operation/listBySOA',
                    type: 'POST',
                    data: {'shipId':shipid_soa, 'voy_no':voyNo_soa, 'currency':currency_soa},
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: null, className: "text-center"},
                    {data: 'date', className: "text-center"},
                    {data: 'content', className: ""},
                    {data: null, className: "text-center"},
                    {data: 'credit', className: "text-center"},
                    {data: 'debit', className: "text-center"},
                    {data: 'rate', className: "text-center"},
                    {data: 'attachment', className: "text-center"},
                ],
                createdRow: function (row, data, index) {
                    $('td', row).eq(0).attr('style', 'height:25px;')
                    if ((index%2) == 0)
                        $(row).attr('class', 'cost-item-even');
                    else
                        $(row).attr('class', 'cost-item-odd');
                        
                    $('td', row).eq(2).attr('style', 'padding-left:2px!important;');
                    $('td', row).eq(4).attr('class', 'style-blue-input text-right');
                    $('td', row).eq(4).attr('style', 'padding-right:5px!important;');
                    $('td', row).eq(5).attr('class', 'text-right');
                    $('td', row).eq(5).attr('style', 'padding-right:5px!important;');
                        
                    $('td', row).eq(0).html('').append(index + 1);
                    $('td', row).eq(3).html('').append(FeeTypeData[data['flowid']][data['profit_type']]);
                    $('td', row).eq(4).html('').append(data['credit']=='' ? '':prettyValue(data['credit']));
                    $('td', row).eq(5).html('').append(data['debit']=='' ? '':prettyValue(data['debit']));
                    $('td', row).eq(6).html('').append(formatRate(data['rate']));

                    if (data['credit'] != '') SOA_credit_sum += parseFloat(data['credit']);
                    if (data['debit'] != '') SOA_debit_sum += parseFloat(data['debit']);

                    var link_html = '<label><a href="' + data['attachment'] + '" target="_blank" class="' + (data['attachment']==null ? 'visible-hidden':'') + '"><img src="' + "{{ cAsset('assets/images/document.png') }}" + '"' + ' width="15" height="15" style="cursor: pointer;"></a></label>';
                    $('td', row).eq(7).html('').append(link_html);
                    $('td', row).eq(2).html('').append('<input class="form-control" value="' + data['content'] + '" readonly/>');
                },
                drawCallback: function (response) {
                    var currency = (currency_soa=='USD'?'$':'¥');
                    var report_row = '<tr class="tr-report" style="height:30px;border:2px solid black;">';
                    report_row += '<td class="sub-small-header style-normal-header"></td><td class="sub-small-header style-normal-header"></td><td class="sub-small-header style-normal-header text-center">合计</td>';
                    report_row += '<td class="sub-small-header style-normal-header text-center">' + currency + '</td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header text-right ' + (SOA_credit_sum >= 0 ? 'style-blue-input':'style-red-input') + '">' + currency + ' ' + prettyValue(SOA_credit_sum) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header text-right ' + (SOA_debit_sum >= 0 ? '':'style-red-input') + '">' + currency + ' ' + prettyValue(SOA_debit_sum) + '</td>';
                    var total_sum = SOA_credit_sum - SOA_debit_sum;
                    report_row += '<td colspan="2" style="padding-right:5px!important;" class="style-normal-header text-right ' + (total_sum >= 0 ? 'style-blue-input':'style-red-input') + '">' + currency + ' ' + prettyValue(total_sum) + '</td>';
                    report_row += '</tr>';

                    $('#table-soa-list-body').append(report_row);
                    voyID_soa = response.json.voy_info.id;
                    voyType_soa = response.json.voy_info.CP_kind.substr(0,1);
                    $('#contract_type').html(response.json.voy_info.CP_kind);
                    $('#contract_date').html(response.json.voy_info.CP_Date);
                    $('#contract_content').html(response.json.Cargo);
                    $('#contract_amount').html(prettyValue(response.json.voy_info.Cgo_Qtty));
                    $('#contract_signon_port').html(response.json.LPort);
                    $('#contract_signoff_port').html(response.json.DPort);
                    $('#contract_unit').html(getFrtRate(response.json.voy_info.Freight, response.json.voy_info.total_Freight));
                    if (response.json.voy_info.is_attachment == 1) {
                        $('#contract_attachment').html('<a href="' + response.json.voy_info.attachment_url + '" target="_blank" ><img src="' + "{{ cAsset('assets/images/document.png') }}" + '" width="15" height="15"></a>');
                    }
                }
            });

            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }

        function getFrtRate(a, b) {
            return parseFloat(a) == 0 || a == undefined ? prettyValue(b) : prettyValue(a);
        }

        $(function () {
            $('ul li a[data-toggle=tab]').click(function(){
                $nowTab = $(this).attr("href");
                if ($nowTab == '#tab_graph') {
                }
                else if ($nowTab == '#tab_table') {
                    year_table = $("#select-table-year option:selected").val();
                    shipid_table = $("#select-table-ship").val();
                    $('#table_info').html('"' + $("#select-table-ship option:selected").attr('data-name') + '" ' + year_table + '年 ');
                    if (listTable == null) initTable();
                }
                else if ($nowTab == '#tab_soa') {
                    shipid_soa = $('#select-soa-ship').val();
                    currency_soa = $('#select-soa-currency').val();
                    if (listSOATable == null){
                        getVoyList(shipid_soa);
                    }
                }
            });
        });

        $('#select-soa-ship').on('change', function() {
            shipid_soa = $('#select-soa-ship').val();
            voyNo_soa = null;
            clearSOAInfo();
            getVoyList(shipid_soa);
        });

        $('#select-soa-contract').on('change', function() {
            voyNo_soa = $('#select-soa-contract').val();
            selectSOAInfo();
        });

        $('#select-soa-currency').on('change', function() {
            currency_soa = $('#select-soa-currency').val();
            selectSOAInfo();
        });

        function gotoDetailPage()
        {
            if (voyNo_soa == null) return;
            let shipId = $('#select-soa-ship').val();
            let voyId = $('#select-soa-contract').val();

            window.open(BASE_URL + 'shipManage/dynamicList?shipId=' + shipId + '&voyNo=' + voyId, '_blank');
        }

        function clearSOAInfo()
        {
            $('#contract_type').html('');
            $('#contract_date').html('');
            $('#contract_content').html('');
            $('#contract_amount').html('');
            $('#contract_signon_port').html('');
            $('#contract_signoff_port').html('');
            $('#contract_unit').html('');
            $('#contract_attachment').html('');
            $('#table-soa-list-body').html('');
        }

        function selectSOAInfo()
        {
            clearSOAInfo();
            $('#soa_title').html($("#select-soa-ship option:selected").attr('data-name') + ' ' + $("#select-soa-contract option:selected").val() + '次 ');
            $('#soa_info').html($("#select-soa-ship option:selected").attr('data-name') + ' ' + $("#select-soa-contract option:selected").val() + '次 ');

            SOA_credit_sum = 0;
            SOA_debit_sum = 0;
            if (listSOATable == null) {
                initSOATable();
            }
            else {
                if (voyNo_soa != null) {
                    listSOATable.column(1).search(shipid_soa, false, false);
                    listSOATable.column(2).search(voyNo_soa, false, false);
                    listSOATable.column(3).search(currency_soa, false, false).draw();
                }
            }
        }

        
        function setEvents() {
            $('.td_voy_no').on('click', function(e) {
                alertAudio();
                var voyNo = e.target.innerHTML;
                if (voyNo != "")
                {
                    if ($('#select-soa-ship').val() == shipid_table && listSOATable != null)
                    {
                        voyNo_soa = voyNo;
                        $('#select-soa-contract').val(voyNo_soa);
                        selectSOAInfo();
                    }
                    else
                    {
                        clicked_voyno = voyNo;
                        $('#select-soa-ship').val(shipid_table);
                        getVoyList(shipid_table);
                        if (listSOATable == null) {
                            shipid_soa = shipid_table
                            voyNo_soa = voyNo;
                            currency_soa = $('#select-soa-currency').val();
                            initSOATable();
                        }
                    }
                    
                    $('a[href="#tab_soa"]').trigger('click');
                }
            });
        }

        function getVoyList(shipId) {
            $.ajax({
                url: BASE_URL + 'ajax/report/getData',
                type: 'post',
                data: {
                    shipId: shipId
                },
                success: function(data, status, xhr) {
                    var select_html = "";
                    for (var i=0;i<data['voyList'].length;i++)
                        select_html += '<option value="' + data['voyList'][i].Voy_No + '" data-id="' + data['voyList'][i].id + '" data-id="' + data['voyList'][i].id + '">' + data['voyList'][i].Voy_No + '</option>';
                    $('#select-soa-contract').html(select_html);

                    if (clicked_voyno != null) {
                        
                        voyNo_soa = clicked_voyno;
                        $('#select-soa-contract').val(voyNo_soa);
                        clicked_voyno = null;
                        selectSOAInfo();
                    }
                    else
                    {
                        if (data['voyList'].length > 0) {
                            voyNo_soa = data['voyList'][0].Voy_No;
                            selectSOAInfo();
                        }
                    }
                }
            });
        }
        
        function alertAudio() {
            document.getElementById('warning-audio').play();
        }

        function fnExcelTableReport()
        {
            var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            var real_tab = document.getElementById('table-income-expense-list');
            var tab = real_tab.cloneNode(true);
            tab_text=tab_text+"<tr><td colspan='21' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#table_info').html() + "收支分析表</td></tr>";
            for(var j = 0; j < tab.rows.length ; j++)
            {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        if (i == 8)
                            tab.rows[j].childNodes[i].style.width = '1500px';
                        else
                            tab.rows[j].childNodes[i].style.width = '100px';
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab.rows[j].childNodes[0].style.width = '80px';
                    tab.rows[j].childNodes[1].style.width = '80px';
                }
                else if (j == 1) {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                }
                else if (j == (tab.rows.length - 1))
                {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        tab.rows[j].childNodes[i].style.height = "30px";
                        tab.rows[j].childNodes[i].style.fontWeight = "bold";
                        tab.rows[j].childNodes[i].style.backgroundColor = '#ebf1de';
                    }
                }
                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";
            
            tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
            tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
            tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

            var filename = $('#select-table-ship option:selected').text() + '_' + year_table + '_收支分析表';
            exportExcel(tab_text, filename, filename);
            
            return 0;
        }

        function fnExcelSOAReport()
        {
            if (voyNo_soa == null) return;

            var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            var real_tab = document.getElementById('table-soa-general-info');
            var tab = real_tab.cloneNode(true);
            tab_text=tab_text+"<tr><td colspan='7' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#soa_title').html() + "合同简要</td></tr>";
            for(var j = 0; j < tab.rows.length ; j++)
            {
                if (j == 0) {
                    for (var i=1; i<tab.rows[j].childElementCount*2;i+=2) {
                        tab.rows[j].childNodes[i].style.width = '100px';
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab.rows[j].childNodes[5].style.width = '200px';
                    tab.rows[j].childNodes[9].style.width = '300px';
                    tab.rows[j].childNodes[11].style.width = '300px';
                    tab.rows[j].childNodes[13].style.width = '300px';
                }
                tab.rows[j].childNodes[15].remove();
                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";
            var total_text = tab_text;
            
            tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            real_tab = document.getElementById('table-soa-list');
            if (real_tab.innerHTML.indexOf('No matching records found') < 0)
            {                
                tab = real_tab.cloneNode(true);
                tab_text=tab_text+"<tr><td colspan='8' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#soa_info').html() + "SOA</td></tr>";
                for(var j = 0 ; j < tab.rows.length ; j++)
                {
                    if (j == 0) {
                        for (var i=0; i<tab.rows[j].childElementCount;i++) {
                            tab.rows[j].childNodes[i].style.width = '100px';
                            tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                        }
                        tab.rows[j].childNodes[2].style.width = '400px';
                        tab.rows[j].childNodes[3].style.width = '60px';
                        tab.rows[j].childNodes[4].style.width = '300px';
                        tab.rows[j].childNodes[5].style.width = '300px';
                    }
                    else if (j != (tab.rows.length -1)){
                        var info = real_tab.rows[j].childNodes[2].childNodes[0].value;
                        tab.rows[j].childNodes[2].innerHTML = info;
                    }

                    if (j < (tab.rows.length-1)) tab.rows[j].childNodes[7].remove();
                    tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                }
                tab_text=tab_text+"</table>";
                total_text += tab_text;
            }

            total_text= total_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
            total_text= total_text.replaceAll(/<img[^>]*>/gi,"");
            total_text= total_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

            var filename = $('#select-soa-ship option:selected').text() + '_' + voyType_soa + voyNo_soa + '_SOA';
            exportExcel(total_text, filename, filename);
            
            return 0;
        }

        function popupTable()
        {
            $('#modal-expense-table-body').html(document.getElementById('table-income-expense-list').outerHTML);
            $('#modal-expense-table').modal('show');
        }

        function selectCurrency()
        {
            var value = $('#select-soa-currency').val();
            if (value == 'CNY') $('#select-soa-currency').attr('style','padding-left:unset!important;color:red!important');
            else { $('#select-soa-currency').attr('style','padding-left:unset!important;color:#026fcd!important'); }
        }
    </script>

@endsection
