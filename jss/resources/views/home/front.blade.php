@extends('layout.header')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ cAsset('assets/css/slick.css') }}"/>
    <link href="{{ cAsset('assets/css/slides.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cAsset('assets/js/chartjs/c3.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cAsset('assets/css/home.css') }}" rel="stylesheet"/>

    <link href="{{ cAsset('css/pretty.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/dycombo.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/multiselect.css') }}" rel="stylesheet"/>
    <script src="{{ cAsset('assets/js/multiselect.min.js') }}"></script>


    <link href="{{ cAsset('assets/js/chartjs/chartist.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ cAsset('assets/js/chartjs/flot.css') }}">
    
    
    <script src="{{ cAsset('assets/js/chartjs/chartist.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/chartjs.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/d3.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/c3.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/flot.js') }}"></script>
    <script src="{{ cAsset('/assets/js/highcharts.js') }}"></script>

    <script type="text/javascript" src="{{ cAsset('assets/js/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ cAsset('assets/css/koala.min.1.5.js') }}"></script>

    <style>
        embed:scroll-bar{display:none}

        #currency-list tr td {
            padding: 0 4px!important;
        }
        .c3 path {
            stroke-width: 3px;
        }

        #chartist-h-bars .ct-series-a line {
            stroke: #81afe4;
            /*stroke-width: 5px;
            stroke-dasharray: 10px 20px;*/
        }

        #chartist-h-bars .ct-series-b line {
            stroke: #f58787;
        }

        #chartist-h-bars .ct-series-c line {
            stroke: #b5ce71;
        }

        #chartist-h-bars-02 .ct-series-b line {
            stroke: #f58787;
        }

        #chartist-h-bars-02 .ct-series-c line {
            stroke: #b5ce71;
        }

        #chartist-h-bars-02 .ct-series-a line {
            stroke: #81afe4;
        }

        .ship-item:hover {
            background-color: #ffe3e082;
        }

        .c3-legend-item text {
            font-size:14px;
        }

        .member-item-odd {
            background-color: #f5f5f5;
        }

        .member-item-even:hover {
            background-color: #ffe3e082;
        }

        .member-item-odd:hover {
            background-color: #ffe3e082;
        }

        table{
            border-style:dotted;
        }

        table td{
            border-style:dotted;
        }

        .td-notice-yellow {
            border: 2px solid white;
            border-top: unset!important;border-bottom: unset!important;
            color:yellow;
            font-weight:bold;
            font-size: 12px;
        }

        .td-notice-white {
            border: 2px solid white;
            border-top: unset!important;border-bottom: unset!important;
            color:white;
            font-weight:bold;
            font-size: 12px;
        }

        @-webkit-keyframes blinker {
        from {opacity: 1.0;}
        to {opacity: 0.0;}
        }
        .blink{
            text-decoration: blink;
            -webkit-animation-name: blinker;
            -webkit-animation-duration: 0.6s;
            -webkit-animation-iteration-count:infinite;
            -webkit-animation-timing-function:ease-in-out;
            -webkit-animation-direction: alternate;
        }
    </style>
    <div class="main-content">
        <div class="page-content">
            <div class="row" style="padding-top: 12px;">
                <div class="col-lg-2">
                    <div class="row for-pc">
                        <div class="card mb-4">
                            <a href="/decision/receivedReport" style="color: white; outline: unset;" target="_blank">
                            <div class="card-header decide-title" style="cursor:pointer">
                                <div class="card-title front-span">
                                    <span class="bigger-120">等待批准</span>
                                </div>
                            </div>
                            </a>
                            <div class="card-body decide-border" style="padding: 0 0px!important;max-height:121px!important;overflow-y: auto;">
                                <table id="" style="table-layout:fixed;border:0px solid black;">
                                    <tbody class="" id="list-body" style="">
                                    @if (isset($reportList) && count($reportList) > 0)
                                    <?php $index = 1;?>
                                    @foreach ($reportList as $report)
                                        @if ($report['ishide'] != 1)
                                        <?php $nickName=""?>
                                        @foreach($shipList as $ship)
                                            @if ($ship->IMO_No == $report['shipNo'])
                                            <?php $nickName = $ship['NickName'];?>
                                            @endif
                                        @endforeach
                                        <tr @if($index%2==0) class="member-item-odd" @else class="member-item-even" @endif title="{{$report['report_id']}}">
                                            <td class="center" style="height:20px!important;"><span class="{{$report['flowid']=='Credit'?'text-profit':''}}">{{g_enum('ReportTypeData')[$report['flowid']]}}</span></td>
                                            <td class="center">{{$report['obj_type'] == OBJECT_TYPE_SHIP?$nickName:$report['obj_name']}}</td>
                                            <td class="center">{{$report['voyNo']}}</td>
                                            <td class="center" style="width:25%;overflow: hidden;white-space: nowrap;"><span class="{{$report['flowid']=='Credit'?'text-profit':''}}">{{isset(g_enum('FeeTypeData')[$report['flowid']][$report['profit_type']])?g_enum('FeeTypeData')[$report['flowid']][$report['profit_type']]:""}}</span></td>
                                            <td class="center" style="background-color:#fdb971!important;overflow: hidden;white-space: nowrap;"><span class="blink">等待</span></td>
                                            <?php $index++;?>
                                        </tr>
                                        @endif
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="8">{{ trans('common.message.no_data') }}</td>
                                    </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row for-pc">
                        <div class="card mb-4">
                            <!--a href="" style="color: white; outline: unset;" target=""-->
                            <div class="card-header no-attachment-decide-title">
                                <div class="card-title front-span">
                                    <span class="bigger-120">等待凭证</span>
                                </div>
                            </div>
                            </a>
                            <div class="card-body no-attachment-decide-border" style="padding: 0 0px!important;max-height:141px!important;overflow-y: auto;">
                                <table id="" style="table-layout:fixed;border:0px solid black;">
                                    <tbody class="" id="list-body" style="">
                                    @if (isset($noattachments) && count($noattachments) > 0)
                                    <?php $index = 1;?>
                                    @foreach ($noattachments as $report)
                                        @if ($report['ishide'] != 1)
                                        <?php $nickName=""?>
                                        @foreach($shipList as $ship)
                                            @if ($ship->IMO_No == $report['shipNo'])
                                            <?php $nickName = $ship['NickName'];?>
                                            @endif
                                        @endforeach
                                        <tr @if($index%2==0) class="member-item-odd" @else class="member-item-even" @endif title="{{$report['report_id']}}">
                                            <td class="center" style="height:20px!important;"><span class="{{$report['flowid']=='Credit'?'text-profit':''}}">{{g_enum('ReportTypeData')[$report['flowid']]}}</span></td>
                                            <td class="center">{{$report['obj_type'] == OBJECT_TYPE_SHIP?$nickName:$report['obj_name']}}</td>
                                            <td class="center">{{$report['voyNo']}}</td>
                                            <td class="center" style="width:25%;overflow: hidden;white-space: nowrap;"><span class="{{$report['flowid']=='Credit'?'text-profit':''}}">{{isset(g_enum('FeeTypeData')[$report['flowid']][$report['profit_type']])?g_enum('FeeTypeData')[$report['flowid']][$report['profit_type']]:""}}</span></td>
                                            <td class="center"><img src="{{ cAsset('assets/images/paper-clip.png') }}" width="15" height="15" style="margin: 0px 0px"></td>
                                            <?php $index++;?>
                                        </tr>
                                        @endif
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="8">{{ trans('common.message.no_data') }}</td>
                                    </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row for-pc">
                        <div class="card mb-4">
                            <!--a href="" style="color: white; outline: unset;" target=""-->
                            <div class="card-header expired-cert-title">
                                <div class="card-title front-span">
                                    <span class="bigger-120">船舶证书到期{{ '(' . $settings->cert_expire_date . ')天'}}</span>
                                </div>
                            </div>
                            </a>
                            <div class="card-body expired-cert-border" style="padding: 0 0px!important;max-height:121px!important;overflow-y: auto;">
                                <table id="" style="border:0px solid black;">
                                    <thead style="position:sticky;top:0;box-shadow: inset 0 -1px #000, 1px -1px #000;">
                                        <td class="center decide-sub-title" style="width: 36px;">船名</td>
                                        <td class="center decide-sub-title" style="overflow: hidden;white-space: nowrap;">证书</td>
                                        <td class="center decide-sub-title" style="width: 61px;">有效期</td>
                                        <td class="center decide-sub-title" style="width: 61px;">周检日期</td>
                                    </thead>
                                    <tbody class="" id="cert-body" style="">
                                        @foreach($expireCert as $key => $item)
                                            <tr>
                                                <td>{{ $item->shipName }}</td>
                                                <td class="center">{{ $item->certName }}</td>
                                                <td class="center">{{ date('y-m-d', strtotime($item->expire_date)) }}</td>
                                                <td class="center">{{ isset($item->due_endorse) ? date('y-m-d', strtotime($item->due_endorse)):"" }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row for-pc">
                        <div class="card mb-4">
                            <!--a href="" style="color: white; outline: unset;" target=""-->
                            <div class="card-header no-attachment-decide-title">
                                <div class="card-title front-span">
                                    <span class="bigger-120">海员证书到期{{ '(' . $settings->cert_expire_date . ')天'}}</span>
                                </div>
                            </div>
                            </a>
                            <div class="card-body no-attachment-decide-border" style="padding: 0 0px!important;max-height:121px!important;overflow-y: auto;">
                                <table id="" style="border:0px solid black;table-layout:fixed;">
                                    <thead style="position:sticky;top:0;box-shadow: inset 0 -1px #000, 1px -1px #000;">
                                        <td class="center decide-sub-title" style="width:36px;">船名</td>
                                        <td class="center decide-sub-title" style="width:45px;">职务</td>
                                        <td class="center decide-sub-title" style="">证书</td>
                                        <td class="center decide-sub-title" style="width:61px;">有效期</td>
                                    </thead>
                                    <tbody class="" id="cert-body" style="">
                                        @foreach($expireMemberCert as $key => $item)
                                            <tr title="{{ $item['title'] }}">
                                                <td class="center">{{ $item['shipName'] }}</td>
                                                <td class="center" style="overflow: hidden;white-space: nowrap;">{{ $item['rank'] }}</td>
                                                <td class="center" style="overflow: hidden;white-space: nowrap;">{{ $item['title'] }}</td>
                                                <td class="center">{{ date('y-m-d', strtotime($item['_expire'])) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row for-pc">
                        <div class="card mb-4">
                            <!--a href="/shipManage/equipment" style="color: white; outline: unset;" target="_blank"-->
                            <div class="card-header decide-title">
                                <div class="card-title front-span">
                                    <span class="bigger-120">必需备件</span>
                                </div>
                            </div>
                            </a>
                            <div class="card-body decide-border" style="padding: 0 0px!important;max-height:121px!important;overflow-y: auto;">
                                <table id="" style="border:0px solid black;">
                                    <thead style="position:sticky;top:0;box-shadow: inset 0 -1px #000, 1px -1px #000;">
                                        <td class="center decide-sub-title">船名</td>
                                        <td class="center decide-sub-title" style="width: 30px;">部门</td>
                                        <td class="center decide-sub-title">缺件</td>
                                    </thead>
                                    <tbody class="" id="equipment-body" style="">
                                        @foreach($equipment as $key => $item)
                                            <tr>
                                                <td style="width: 35px;">{{ $item->shipName }}</td>
                                                <td class="center">{{ $item->place }}</td>
                                                <td>{{ $item->remark }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="for-pc row">
                        <div class="card mb-4">
                            <div class="card-body p-0" style="box-shadow: 0px 0px 8px 4px #d2d2d2;">
                                <div class="advertise" style="height:30px;">
                                    <div style="padding-left: 16px;">
                                        <h5 style="font-weight: bold;">动态 </h5>
                                    </div>
                                    <div class="sign_list slider text-center" style="width:100%;padding-left:10px;padding-right: 16px; margin-left: auto;">
                                        @if(isset($voyList) && count($voyList) > 0)
                                            @foreach ($voyList as $info)
                                                @if ($info['ishide'] != 1)
                                                <?php $nickName=""?>
                                                @foreach($shipList as $ship)
                                                    @if ($ship->IMO_No == $info['Ship_ID'])
                                                    <?php $nickName = $ship['NickName'];?>
                                                    @endif
                                                @endforeach
                                                <div style="height: auto; outline: unset;">
                                                    <h5>
                                                        <a href="/shipManage/dynamicList" style="color: white; outline: unset;" target="_blank" >
                                                        <table style="width:100%;border:unset!important;table-layout:fixed;" class="not-striped">
                                                            <tbody><tr>
                                                                <td class="td-notice-yellow" style="width:4%">{{$nickName}}</td>
                                                                <td class="td-notice-white" style="width:9%">{{$info['Voy_Date']}}</td>
                                                                <td class="td-notice-white" style="width:6%">{{str_pad($info['Voy_Hour'],2,"0",STR_PAD_LEFT).str_pad($info['Voy_Minute'],2,"0",STR_PAD_LEFT)}}</td>
                                                                <td class="td-notice-yellow" style="width:15%">{{g_enum('DynamicStatus')[$info['Voy_Status']][0]}}</td>
                                                                <td class="td-notice-white" style="width:15%">{{$info['Ship_Position']}}</td>
                                                                <td class="td-notice-white" style="width:8%">{{$info['Cargo_Qtty']}}</td>
                                                                <td class="td-notice-yellow" style="width:8%">{{$info['ROB_FO']}}</td>
                                                                <td class="td-notice-yellow" style="width:8%">{{$info['ROB_DO']}}</td>
                                                                <td class="td-notice-white" style="width:8%">{{$info['BUNK_FO']}}</td>
                                                                <td class="td-notice-white" style="width:8%">{{$info['BUNK_DO']}}</td>
                                                                <td class="td-notice-white" style="border-right:unset!important;">{{$info['Remark']}}</td>
                                                            </tr></tbody>
                                                        </table>
                                                        </a>
                                                    </h5>
                                                </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <span>{{ trans('home.message.no_data') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="for-sp row">
                        <div class="card mb-4">
                            <div class="card-body p-0" style="box-shadow: 0px 0px 8px 4px #d2d2d2;">
                                <!-- For SP -->
                                <div class="advertise" style="height:30px;">
                                    <div style="padding-left: 16px;">
                                        <h5 style="font-weight: bold;">动态 </h5>
                                    </div>
                                    <div class="sign_list slider text-center" style="width:100%;padding-left:10px;padding-right: 16px; margin-left: auto;">
                                        @if(isset($voyList) && count($voyList) > 0)
                                            @foreach ($voyList as $info)
                                                @if ($info['ishide'] != 1)
                                                <?php $nickName=""?>
                                                @foreach($shipList as $ship)
                                                    @if ($ship->IMO_No == $info['Ship_ID'])
                                                    <?php $nickName = $ship['NickName'];?>
                                                    @endif
                                                @endforeach
                                                <div style="height: auto; outline: unset;">
                                                    <h5>
                                                        <a href="/shipManage/dynamicList" style="color: white; outline: unset;" target="_blank" >
                                                        <table style="width:100%;border:unset!important;table-layout:fixed;" class="not-striped">
                                                            <tbody><tr>
                                                                <td class="td-notice-yellow" style="width:4%">{{$nickName}}</td>
                                                                <td class="td-notice-white" style="width:9%">{{ date('m-d', strtotime($info['Voy_Date']))}}</td>
                                                                <td class="td-notice-yellow" style="width:15%">{{g_enum('DynamicStatus')[$info['Voy_Status']][0]}} / </td>
                                                                <td class="td-notice-white" style="width:15%">{{$info['Ship_Position']}}</td>
                                                            </tr></tbody>
                                                        </table>
                                                        </a>
                                                    </h5>
                                                </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <span>{{ trans('home.message.no_data') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row for-sp">
                        <div class="card mb-4">
                            <a href="/decision/receivedReport" style="color: white; outline: unset;" target="_blank">
                            <div class="card-header decide-title" style="cursor:pointer">
                                <div class="card-title front-span">
                                    <span class="bigger-120">等待批准</span>
                                </div>
                            </div>
                            </a>
                            <div class="card-body decide-border" style="padding: 0 0px!important;max-height:121px!important;overflow-y: auto;">
                                <table id="" style="table-layout:fixed;border:0px solid black;">
                                    <tbody class="" id="list-body" style="">
                                    @if (isset($reportList) && count($reportList) > 0)
                                    <?php $index = 1;?>
                                    @foreach ($reportList as $report)
                                        @if ($report['ishide'] != 1)
                                        <?php $nickName=""?>
                                        @foreach($shipList as $ship)
                                            @if ($ship->IMO_No == $report['shipNo'])
                                            <?php $nickName = $ship['NickName'];?>
                                            @endif
                                        @endforeach
                                        <tr @if($index%2==0) class="member-item-odd" @else class="member-item-even" @endif title="{{$report['report_id']}}">
                                            <td class="center" style="height:20px!important;"><span class="{{$report['flowid']=='Credit'?'text-profit':''}}">{{g_enum('ReportTypeData')[$report['flowid']]}}</span></td>
                                            <td class="center">{{$report['obj_type'] == OBJECT_TYPE_SHIP?$nickName:$report['obj_name']}}</td>
                                            <td class="center">{{$report['voyNo']}}</td>
                                            <td class="center" style="width:25%"><span class="{{$report['flowid']=='Credit'?'text-profit':''}}">{{isset(g_enum('FeeTypeData')[$report['flowid']][$report['profit_type']])?g_enum('FeeTypeData')[$report['flowid']][$report['profit_type']]:""}}</span></td>
                                            <td class="center" style="background-color:#fdb971!important"><span class="blink">等待</span></td>
                                            <?php $index++;?>
                                        </tr>
                                        @endif
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="8">{{ trans('common.message.no_data') }}</td>
                                    </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row default-style main-panel">
                        <div class="card">
                            <div class="card-body margin-for-mobile">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top:4px;width:100%!important;">
                                        <div class="row" style="text-align:center;">
                                            <strong class="text-center graph-title-for-pc" style="padding-top: 6px;"><span id="graph_first_title"></span>利润累计比较</strong>
                                            <div class="card graph-height" id="graph_first" style="border:3px double #bbb7b7;">
                                            </div>
                                        </div>
                                        <div class="space-4"></div>
                                        <div class="space-10"></div>
                                        <div class="row" style="text-align:center;">
                                            <strong class="text-center graph-title-for-pc" style="padding-top: 6px;"><span id="graph_second_title"></span>收支累计比较</strong>
                                            <div class="card graph-height" id="graph_second" style="border:3px double #bbb7b7;">
                                            </div>
                                        </div>
                                        <div class="for-pc">
                                            <div class="space-4"></div>
                                            <div class="space-10"></div>
                                            <div class="row" style="text-align:center;">
                                                <strong class="text-center" style="font-size: 20px; padding-top: 6px;"><span id="graph_third_title"></span>经济天数占率比较</strong>
                                                <div class="card" id="graph_third" style="border:3px double #bbb7b7">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="for-pc">
                                            <div class="space-4"></div>
                                            <div class="space-10"></div>
                                            <div class="row" style="text-align:center;">
                                                <strong class="text-center" style="font-size: 20px; padding-top: 6px;"><span id="graph_fourth_title"></span>支出比较</strong>
                                                <div class="card" id="graph_fourth" style="border:3px double #bbb7b7">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="for-pc">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 for-pc">
                    <div class="row">
                        <div class="card mb-4">
                            <div class="card-header common-decide-title">
                                <div class="card-title front-span">
                                    <span class="bigger-120">审核次数 ({{$settings['report_year']}})</span>
                                </div>
                            </div>
                            <div class="card-body common-decide-border" style="padding: 0 0px!important;max-height:101px!important;overflow-y: auto;">
                                <table id="" style="table-layout:fixed;border:0px solid black;">
                                    <tbody class="" id="list-body" style="">
                                    @if (isset($reportSummary) && count($reportSummary) > 0)
                                    <?php $index = 1;?>
                                    @foreach ($reportSummary as $report)
                                        @if ($report['depart_id'] != null)
                                        <tr @if($index%2==0) class="member-item-odd" @else class="member-item-even" @endif>
                                            <td class="center">{{$report['title']}}</td>
                                            <td class="center">{{$report['count']}}</td>
                                            <td class="center">{{number_format($report['percent'],1,".",",")}} %</td>
                                            <?php $index++;?>
                                        </tr>
                                        @endif
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="8">{{ trans('common.message.no_data') }}</td>
                                    </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card mb-4">
                            <div class="card-header common-decide-title">
                                <div class="card-title front-span">
                                    <span class="bigger-120">船舶日报 ({{$settings['dyn_year']}})</span>
                                </div>
                            </div>
                            <div class="card-body common-decide-border" style="padding: 0 0px!important;max-height:101px!important;overflow-y: auto;">
                                <table id="" style="border:0px solid black;">
                                    <thead style="position:sticky;top:0;box-shadow: inset 0 -1px #000, 1px -1px #000;">
                                        <td class="center decide-sub-title">船名</td>
                                        <td class="center decide-sub-title">报告次</td>
                                        <td class="center decide-sub-title">占率</td>
                                    </thead>
                                    <tbody class="" id="dyn-body" style="">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card mb-4">
                            <div class="card-header common-decide-title">
                                <div class="card-title front-span">
                                    <span class="bigger-120">TOP 10 PORTS ({{$settings['port_year']}})</span>
                                </div>
                            </div>
                            </a>
                            <div class="card-body common-decide-border" style="padding: 0 0px!important;max-height:121px!important;overflow-y: auto;">
                                <table id="" style="border:0px solid black;">
                                    <thead style="position:sticky;top:0;box-shadow: inset 0 -1px #000, 1px -1px #000;">
                                        <td class="center decide-sub-title" style="width: 50px;">排名</td>
                                        <td class="center decide-sub-title">港名</td>
                                        <td class="center decide-sub-title">次数</td>
                                    </thead>
                                    <tbody class="" id="cert-body" style="">
                                        <?php $index = 1;?>
                                        @foreach($topPorts as $key => $item)
                                            <tr>
                                                <td>{{ $index }}</td>
                                                <td><span>{{ $item['name'] }}</span></td>
                                                <td class="center"><span>{{ $item['count'] }}</span></td>
                                            </tr>
                                            <?php $index++;?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card mb-4">
                            <div class="card-header common-decide-title">
                                <div class="card-title front-span">
                                    <span class="bigger-120">有关网站</span>
                                </div>
                            </div>
                            <div class="card-body common-decide-border" style="padding: 0 0px!important;">
                                <table id="" style="table-layout:fixed;border:0px solid black;">
                                    <tbody class="" id="sites-body" style="">
                                        @if (isset($sites) && count($sites) > 0)
                                        @foreach ($sites as $site)
                                            @if ($site['link'] != null && $site['image'] != null)
                                            <tr>
                                                <td class="center"><a href="{{$site['link']}}" target="_blank"><img height="42px;" src="{{ cAsset($site['image']) }}"></a></td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ cAsset('assets/js/moment.js') }}"></script>
    <script src="{{ cAsset('assets/js/vue.js') }}"></script>
    <script src="{{ cAsset('assets/js/bignumber.js') }}"></script>
    <?php
	echo '<script>';
    echo 'var settings = ' . $settings . ';';
    echo 'var ships = [];';
    echo 'var shipids_all = [];';
    foreach($shipList as $ship) {
        echo 'ships["' . $ship['IMO_No'] . '"]="' . $ship['NickName'] . '";';
        echo 'shipids_all.push("'.$ship['IMO_No'].'");';
    }
	echo '</script>';
	?>
    <script>
        var certList = new Array();
        var cIndex = 0;
        @foreach($security as $type)
            var cert = new Object();
            cert.value = '{{$type["title"]}}';
            certList[cIndex] = cert;
            cIndex++;
        @endforeach

        var index = 0;
        var shipnames_graph = "";
        var color_table = ['#73b7ff','#ff655c','#50bc16','#ffc800','#9d00ff','#ff0000','#795548','#3f51b5','#00bcd4','#e91e63','#0000ff','#00ff00','#0d273a','#cddc39','#0f184e'];
        var shipids_graph = JSON.parse(settings.graph_ship);
        for (var i=0;i<shipids_graph.length;i++) {
            var name = '<span style="color:' + color_table[i] + '">' + ships[shipids_graph[i]] + '</span>';
            shipnames_graph = shipnames_graph + (i==0?"":"+") + name;
        }
        var year_graph = settings.graph_year;
        var year_dyn = settings.dyn_year;

        $('#graph_first_title').html(shipnames_graph + " " + year_graph + "年");
        $('#graph_second_title').html(shipnames_graph + " " + year_graph + "年");
        $('#graph_third_title').html(shipnames_graph + " " + year_graph + "年");
        $('#graph_fourth_title').html(shipnames_graph + " " + year_graph + "年");
        $('#graph_fifth_title').html(shipnames_graph + " " + year_graph + "年");

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
        
        initGraphTable();
        function initGraphTable() 
        {
            $.ajax({
                url: BASE_URL + 'ajax/operation/listByAll',
                type: 'post', 
                data: {'year':year_graph, 'shipId':shipids_all},
                success: function(result) {
                    // Table 1
                    var prev_sum = 0;
                    var month_sum = [];
                    var axis_x_names = [];
                    for(var i=0;i<12;i++) month_sum[i] = 0;
                    var index = 0;
                    var datasets = [];
                    var ismobile = $($('.graph-height')[0]).css('height') == '200px';
                    for (index=0;index<shipids_graph.length;index++) {
                        var ship_name = ships[shipids_graph[index]];
                        var ship_no = shipids_graph[index];
                        datasets[index] = {};
                        datasets[index].data = washData(result[ship_no]['sum_months']);
                        datasets[index].name = ship_name;
                        datasets[index].color = color_table[index];
                        
                        if (ismobile) {
                            datasets[index].lineWidth = 1;
                            datasets[index].marker = {radius: 2};
                        }

                        for(var i=0;i<12;i++) {
                            value = result[ship_no]['sum_months'][i];
                            month_sum[i] += value;
                        }
                    }
                    datasets[index] = {};
                    month_sum = washData(month_sum);
                    datasets[index].data = month_sum;
                    datasets[index].name = '合计';
                    datasets[index].color = '#4a7ebb';  //4a7ebb
                    datasets[index].dashStyle = 'Dash';//LongDash
                    datasets[index].lineWidth = 4;
                    if (ismobile) {
                        datasets[index].lineWidth = 2;
                        datasets[index].marker = {radius: 3};
                     }

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
                    for (index=0;index<shipids_graph.length;index++) {
                        var ship_name = ships[shipids_graph[index]];
                        var ship_no = shipids_graph[index];
                        var value = result[ship_no]['credit_sum'];

                        /*
                        datasets[index] = {};
                        datasets[index].label = ship_name;
                        datasets[index].data = [result[ship_no]['credit_sum'], result[ship_no]['debit_sum']*(-1)];
                        datasets[index].borderColor = color_table[index];
                        datasets[index].backgroundColor = addAlpha(color_table[index],0.8);
                        */
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
                        datasets4[index].borderColor = addAlpha(color_table[index],0.8);
                        datasets4[index].backgroundColor = color_table[index];
                        var indexes = [2,1,6,4,15,3,5,7,8,9,10,11,12];
                        for(var i=0;i<indexes.length;i++) {
                            datasets4[index].data[i] = result[ship_no]['debits'][indexes[i]];
                        }
                    }
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
                    var show_index = 0;
                    var datasets = [];
                    var labels = [];
                    datasets[0] = {};
                    for (index=0;index<shipids_graph.length;index++) {
                        var ship_name = ships[shipids_graph[index]];
                        var ship_no = shipids_graph[index];

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

                        datasets[index] = {};
                        datasets[index].label = ship_name;
                        var percent = _format((footerData['loading_time'] + footerData['disch_time'] + footerData['total_sail_time'])/footerData['sail_time']*100,1);
                        datasets[index].data = [];
                        datasets[index].data[0] = percent;
                        datasets[index].borderColor = addAlpha(color_table[index],0.8);
                        datasets[index].backgroundColor = color_table[index];

                        datasets[index].barThickness = 40;
                        datasets[index].maxBarThickness = 40;
                    }
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

                    for (index=0;index<shipids_graph.length;index++) {
                        var ship_name = ships[shipids_graph[index]];
                        var ship_no = shipids_graph[index];
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
                    }
                    drawFifthGraph(datasets);
                }
            })

            $.ajax({
                url: BASE_URL + 'ajax/voy/totals',
                type: 'post', 
                data: {
                    'year':year_dyn,
                    'shipIds':shipids_all,
                },
                success: function(result) {
                    var index = 0;
                    var show_index = 0;
                    var datasets = [];
                    var labels = [];
                    datasets[0] = {};
                    for (index=0;index<shipids_all.length;index++) {
                        var ship_name = ships[shipids_all[index]];
                        var ship_no = shipids_all[index];

                        let data = result[ship_no];

                        let voy_rate = 0;
                        var voy_count = 0
                        if (data == 0 || data['total_count'] == 0) {
                            voy_rate = 0;
                            voy_count = 0;
                        }
                        else {
                            voy_count = data['total_count'];
                            voy_rate = data['total_count'] / data['total_time'] * 100;
                        }
                        var row_html = "<tr class='" + ((index%2==0)?"member-item-odd":"member-item-even") + "'>" + "<td class='center'>" + ship_name + "</td><td class='center'>" + voy_count + "</td><td class='center'>" + voy_rate.toFixed(1) + " %</td><tr>";
                        
                        $('#dyn-body').append(row_html);
                    }
                }
            });
        }

        function drawFirstGraph(datasets) {
            $('#graph_first').html('');

            Highcharts.setOptions({
                lang: {
                    thousandsSep: ','
                }
            });

            const options = {
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
                    }]
                },
                xAxis: {
                    categories: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                    lineWidth: 2,
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
                series: datasets,
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 768,
                        },
                        chartOptions: {
                            title: {
                                text: '.',
                                style: {
                                    color: 'transparent'
                                }
                            },
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            },
                            xAxis: {
                                categories: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                                lineWidth: 1,
                                labels: {
                                    style: {
                                        fontSize: '6px'
                                    }
                                }
                            },
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
                                        else return '$ ' + prettyValue2(this.value/1000) + 'K';
                                    },
                                    x: 5,
                                    y: -3,
                                    style: {
                                        fontSize: '6px',
                                        padding: '0px'
                                    }
                                },
                                plotLines: [{
                                    value: 0,
                                    width: 2,
                                    color: '#000'
                                }]
                            },
                        }
                    }]
                }
            };
            Highcharts.chart('graph_first', options);
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
                series: datasets,
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 768,
                        },
                        chartOptions: {
                            chart: {
                                type: 'bar',
                                events: {
                                    load: function() {
                                        var yAxis = this.yAxis[0];
                                        this.xAxis[0].update({
                                            offset: -yAxis.toPixels(0, true)
                                        });
                                    }
                                },
                                marginLeft: 0,
                                marginRight: 0
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
                                        fontSize: 12,
                                        color: 'black'
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
                                            return '<label style="color:red">' + '$ ' + prettyValue2(this.value/1000) + 'K</label>';
                                        }
                                        else return '$ ' + prettyValue2(this.value/1000) + 'K';
                                    },
                                    style: {
                                        fontSize: 6
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
                        }
                    }]
                }
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
    </script>

    <script>

        var certObj = new Vue({
            el: '#cert-body',
            data: {
                list: [],
            }
        })

        $(".sign_list").slick({
            dots: false,
            vertical: true,
            centerMode: false,
            autoplay: true,
            prevArrow: false,
            nextArrow: false,
            autoplaySpeed: 2000,
            swipe: false,
            slidesToShow: 1,
            slidesToScroll: 1
        });

    </script>
    <script type="text/javascript">
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

        function addAlpha(color, opacity) {
            const _opacity = Math.round(Math.min(Math.max(opacity || 1, 0), 1) * 255);
            return color + _opacity.toString(16).toUpperCase();
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
            return parseFloat(diffDay.div(24));
        }

        function number_format (number, decimals, dec_point = '.', thousands_sep = ',') {
            // Strip all characters but numerical ones.
            number = (number + '').replaceAll(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replaceAll(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
        
        function _format(value, decimal = 2) {
            return isNaN(value) || value == 0 || value == null || value == undefined ? '' : number_format(value, decimal);
        }

        function __parseFloat(value) {
            if(value == undefined || value == null || isNaN(value) || value == '' || value == 'Infinity') 
                return 0;

            return parseFloat(value);
        }

        function prettyValue2(value)
        {
            if(value == undefined || value == null) return '';
            return parseFloat(value).toFixed(0).replaceAll(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
        }

    </script>
@endsection
