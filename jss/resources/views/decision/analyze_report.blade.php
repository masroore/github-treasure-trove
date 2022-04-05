@extends('layout.header')

@section('styles')
    <link href="{{ cAsset('css/pretty.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('/assets/css/datatables.min.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/dycombo.css') }}" rel="stylesheet"/>
    <style>
        [v-cloak] { display: none; }
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
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content" id="search-div" v-cloak>
            <div class="page-header">
                <div class="col-md-6">
                    <h4><b>审批分析</b></h4>
                </div>
            </div>
            <div class="space-6"></div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <select class="custom-select d-inline-block" id="select-year" style="width: auto;" @change="onChangeYear" v-model="activeYear">
                            @foreach($years as $year)
                                <option value="{{ $year }}">{{ $year }}年</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="btn-group f-right">
                            @if(!Auth::user()->isAdmin)
                                <a class="btn btn-sm btn-success no-radius show-modal">
                                    <img src="{{ cAsset('assets/images/submit.png') }}" class="report-label-img">起草
                                </a>
                            @endif
                            <a class="btn btn-sm btn-warning refresh-btn-over for-pc" type="button" @click="fnExcelReport">
                                <i class="icon icon-table"></i>{{ trans('common.label.excel') }}
                            </a>
                            <a href="#modal-wizard" class="only-modal-show d-none" role="button" data-toggle="modal"></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="space-2"></div>
                    <div class="row" style="text-align:center;">
                        <strong style="font-size: 20px; padding-top: 6px;"><span id="table_count_info"></span>审批文件申请次数</strong>
                    </div>
                    <div class="table-head-fix-div" id="">
                        <table id="table-report-count" data-toggle="table" style="table-layout:fixed;">
                            <thead class="">
                            <tr>
                                <th class="text-center style-normal-header" style="width: 4%;height:30px;"><span>No</span></th>
                                <th class="text-center style-normal-header" style="width: 6%;"><span>姓名</span></th>
                                <th class="text-center style-normal-header" style="width: 8%;"><span>@{{ activeYear }}年</span></th>
                                <th class="text-center style-normal-header" style=""><span>1月</span></th>
                                <th class="text-center style-normal-header" style=""><span>2月</span></th>
                                <th class="text-center style-normal-header" style=""><span>3月</span></th>
                                <th class="text-center style-normal-header" style=""><span>4月</span></th>
                                <th class="text-center style-normal-header" style=""><span>5月</span></th>
                                <th class="text-center style-normal-header" style=""><span>6月</span></th>
                                <th class="text-center style-normal-header" style=""><span>7月</span></th>
                                <th class="text-center style-normal-header" style=""><span>8月</span></th>
                                <th class="text-center style-normal-header" style=""><span>9月</span></th>
                                <th class="text-center style-normal-header" style=""><span>10月</span></th>
                                <th class="text-center style-normal-header" style=""><span>11月</span></th>
                                <th class="text-center style-normal-header" style=""><span>12月</span></th>
                            </tr>
                            </thead>
                            <tbody class="" id="table-report-count-body">
                                <template v-for="(currentItem, index) in report_by_author" v-cloak>
                                    <tr class="dynamic-item">
                                        <td class="text-center" style="height:25px;">@{{ index + 1 }}</td>
                                        <td class="text-center">@{{ currentItem.name }}</td>
                                        <td class="text-center style-blue-input">@{{ currentItem.total }}</td>
                                        <td class="text-center" v-for="item in currentItem.report">@{{ number_format(item, 0) }}</td>
                                    </tr>
                                </template>
                                <tr class="style-normal-header fixed-footer" style="border-bottom: 1px solid black;">
                                    <td class="text-center" style="height:25px;" colspan="2">合计</td>
                                    <td v-for="(item,index) in footer_author" :class="'text-center ' + (index==0?'style-blue-input':'')">@{{ number_format(item, 0) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="space-12"></div>
                    <div class="space-12"></div>
					<div class="row" style="text-align:center;">
                        <strong style="font-size: 20px; padding-top: 6px;"><span id="table_file_info"></span>附加凭证文件数</strong>
                    </div>
                    <div class="table-head-fix-div" id="">
                        <table id="table-file-count" data-toggle="table" style="table-layout:fixed;">
                            <thead class="">
                            <tr>
                                <th class="text-center style-normal-header" style="width: 4%;height:30px;"><span>No</span></th>
                                <th class="text-center style-normal-header" style="width: 6%;"><span>姓名</span></th>
                                <th class="text-center style-normal-header" style="width: 8%;"><span>@{{ activeYear }}年</span></th>
                                <th class="text-center style-normal-header" style=""><span>1月</span></th>
                                <th class="text-center style-normal-header" style=""><span>2月</span></th>
                                <th class="text-center style-normal-header" style=""><span>3月</span></th>
                                <th class="text-center style-normal-header" style=""><span>4月</span></th>
                                <th class="text-center style-normal-header" style=""><span>5月</span></th>
                                <th class="text-center style-normal-header" style=""><span>6月</span></th>
                                <th class="text-center style-normal-header" style=""><span>7月</span></th>
                                <th class="text-center style-normal-header" style=""><span>8月</span></th>
                                <th class="text-center style-normal-header" style=""><span>9月</span></th>
                                <th class="text-center style-normal-header" style=""><span>10月</span></th>
                                <th class="text-center style-normal-header" style=""><span>11月</span></th>
                                <th class="text-center style-normal-header" style=""><span>12月</span></th>
                            </tr>
                            </thead>
                            <tbody class="" id="table-file-count-body">
                                <template v-for="(currentItem, index) in report_by_attach" v-cloak>
                                    <tr class="dynamic-item">
                                        <td class="text-center" style="height:25px;">@{{ index + 1 }}</td>
                                        <td class="text-center">@{{ currentItem.name }}</td>
                                        <td class="text-center style-blue-input">@{{ currentItem.total }}</td>
                                        <td class="text-center" v-for="item in currentItem.report">@{{ number_format(item, 0) }}</td>
                                    </tr>
                                </template>
                                <tr class="style-normal-header fixed-footer" style="border-bottom: 1px solid black;">
                                    <td class="text-center" style="height:25px;" colspan="2">合计</td>
                                    <td :class="'text-center ' + (index==0?'style-blue-input':'')" v-for="(item,index) in footer_attach" >@{{ number_format(item, 0) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
				</div>
            </div>
        </div>
    </div>

    <script src="{{ cAsset('assets/js/datatables.min.js') }}"></script>
    <script src="{{ cAsset('assets/js/vue.js') }}"></script>
	<?php
	echo '<script>';
    echo 'var CurrencyLabel = ' . json_encode(g_enum('CurrencyLabel')) . ';';
	echo '</script>';
	?>
    <script>
        var searchObj = null;
        var ACTIVE_YEAR = '{!! $years[0] !!}';
        $(function() {
            initialize();
        });

        function initialize() {
            searchObj = new Vue({
                el: '#search-div',
                data: {
                    activeYear : ACTIVE_YEAR,
                    report_by_author : [],
                    report_by_attach : [],
                    footer_author : [],
                    footer_attach : [],
                },
                methods: {
                    init: function() {
                        this.getAnalyzeData();
                    },
                    onChangeYear: function(e) {
                        this.activeYear = e.target.value;
                        this.getAnalyzeData();
                    },
                    getAnalyzeData() {
                        $('#table_count_info').html(this.activeYear + '年');
                        $('#table_file_info').html(this.activeYear + '年');
                        $.ajax({
                            url: BASE_URL + 'ajax/report/analyze',
                            type: 'post',
                            data: {
                                year: this.activeYear
                            },
                            success: function(result, status, xhr) {
                                searchObj.report_by_author = [];
                                searchObj.report_by_author = Object.assign([], [], result['report_by_author']);

                                searchObj.report_by_attach = [];
                                searchObj.report_by_attach = Object.assign([], [], result['report_by_attach']);

                                footer_author = new Array(13).fill(0);
                                for (var index=0;index<result['report_by_author'].length;index++)
                                {
                                    for (var i=1;i<13;i++) {
                                        footer_author[i] += result['report_by_author'][index]['report'][i];
                                    }
                                    footer_author[0] += result['report_by_author'][index]['total'];
                                }
                                searchObj.footer_author = [];
                                searchObj.footer_author = Object.assign([], [], footer_author);

                                footer_attach = new Array(13).fill(0);
                                for (var index=0;index<result['report_by_attach'].length;index++)
                                {
                                    for (var i=1;i<13;i++) {
                                        footer_attach[i] += result['report_by_attach'][index]['report'][i];
                                    }
                                    footer_attach[0] += result['report_by_attach'][index]['total'];
                                }
                                searchObj.footer_attach = [];
                                searchObj.footer_attach = Object.assign([], [], footer_attach);
                            }
                        });
                    },
                    number_format: function(value, decimal = 1) {
                        return isNaN(value) || value == 0 || value == null || value == undefined ? '' : number_format(value, decimal);
                    },
                    fnExcelReport() {
                        var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
                        var real_tab = document.getElementById('table-report-count');
                        var tab = real_tab.cloneNode(true);
                        tab_text=tab_text+"<tr><td colspan='15' style='width:1000px!important;font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + searchObj.activeYear + "年审批文件申请次数</td></tr>";
                        for(var j = 0; j < tab.rows.length; j++) 
                        {
                            if(j==0) {
                                for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                                    tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                                    tab.rows[j].childNodes[i].style.width = '100px';
                                }
                                tab.rows[j].childNodes[0].style.width = '40px';
                            } 
                            else if (j == (tab.rows.length-1)) {
                                for (var i=2; i<15;i++) {
                                    tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                                }
                                tab.rows[j].childNodes[0].style.backgroundColor = '#d9f8fb';
                            }
                            tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                        }
                        tab_text=tab_text+"</table>";

                        var tab_text2="<table border='1px' style='text-align:center;vertical-align:middle;'>";
                        var real_tab = document.getElementById('table-file-count');
                        tab = real_tab.cloneNode(true);
                        tab_text2=tab_text2+"<tr><td colspan='15' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + searchObj.activeYear + "年附加凭证文件数</td></tr>";
                        for(var j = 0; j < tab.rows.length; j++) 
                        {
                            if(j==0) {
                                for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                                    tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                                    tab.rows[j].childNodes[i].style.width = '100px';
                                }
                                tab.rows[j].childNodes[0].style.width = '40px';
                            } 
                            else if (j == (tab.rows.length-1)) {
                                for (var i=2; i<15;i++) {
                                    tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                                }
                                tab.rows[j].childNodes[0].style.backgroundColor = '#d9f8fb';
                            }
                            tab_text2=tab_text2+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                        }
                        tab_text2=tab_text2+"</table>";
                        tab_text = tab_text + tab_text2;
                        tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
                        tab_text= tab_text.replaceAll(/<img[^>]*>/gi,""); // remove if u want images in your table
                        tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, ""); // remove input params
                        var filename = '审批分析_' + searchObj.activeYear;
                        exportExcel(tab_text, filename, filename);
                        return 0;
                    }
                }
            });
            searchObj.init();
        }

    </script>

@stop
