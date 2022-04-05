@extends('layout.header')
<?php
$isHolder = Session::get('IS_HOLDER');
?>

@section('styles')
<link href="{{ cAsset('css/pretty.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/dycombo.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/multiselect.css') }}" rel="stylesheet"/>
    <script src="{{ cAsset('assets/js/multiselect.min.js') }}"></script>
    <link href="{{ cAsset('/assets/css/datatables.min.css') }}" rel="stylesheet"/>
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
@endsection
@section('content')
    <div class="main-content">
        <style>
            .settings-item {
                height:30px;
            }

            .add-td-label {
                font-size:12px!important;
                font-weight:bold!important;
                background-color:#d9f8fb !important;
                text-align: left!important;
                padding-left:5px!important;
            }

            .add-td-text {
                background-color: #FFFFFF;
                font-weight: normal;
                vertical-align: middle;
            }

            .add-td-input {
                font-size:14px!important;
                margin-left:10px;
            }

            .add-td-select {
                font-size:14px!important;
                margin-left:5px;
                margin-right:10px;
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
        </style>
        <div class="page-header">
            <div class="col-sm-3">
                <h4><b>看板管理</b></h4>
            </div>
        </div>
        <div class="page-content">
            <div class="row" style="margin-bottom: 4px;">
                <div class="col-md-12">
                    <div class="col-md-6" style="padding:unset!important">
                    </div>
                    <div class="col-md-6" style="padding:unset!important">
                        <div class="btn-group f-right">
                            <a id="btnSave" class="btn btn-sm btn-success" style="width: 80px">
                                <i class="icon-save"></i>{{ trans('common.label.save') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <form id="validation-form" action="updateSettings" role="form" method="POST" enctype="multipart/form-data">
            <div class="row" style="border-top: 1px solid gray">
                <div class="col-md-12 common-list" style="margin-top:4px;">
                <div id="item-manage-dialog" class="hide"></div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                
                    <div class="" style="">
                        <div class="col-md-6" style="padding-left: 0px!important;">
                            <div class="table-responsive">
                                <table style="table-layout:fixed;">
                                    <tbody class="" id="list-body">
                                        <tr>
                                            <td class="add-td-label" style="width:20%!important;height:20px;">GRAPH:</td>
                                            <td class="add-td-text" style="width:15%!important;">
                                                <select name="select-graph-year" id="select-graph-year" class="form-control" style="width:100%;border:unset!important;">
                                                    @for($i=date("Y");$i>=$start_year;$i--)
                                                    <option value="{{$i}}" @if($i==$settings['graph_year']) selected @endif>{{$i}}年</option>
                                                    @endfor
                                                </select>
                                            </td>
                                            <td class="add-td-text">
                                                <select name="select-graph-ship[]" id="select-graph-ship" style="z-index:10000!important;" class="custom-select d-inline-block form-control" multiple>
                                                    @foreach($shipList as $ship)
                                                        <option value="{{ $ship['IMO_No'] }}" data-name="{{$ship['shipName_En']}}">{{$ship['NickName']}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="add-td-label" style="width:20%!important;">证书到期(提前):</td>
                                            <td class="add-td-text" colspan="2">
                                                <select class="form-control" name="cert-expire_date" id="cert-expire_date">
                                                    <option value="0" @if($settings['cert_expire_date']=='0') selected @endif>All</option>
                                                    <option value="60" @if($settings['cert_expire_date']=='60') selected @endif>60天</option>
                                                    <option value="90" @if($settings['cert_expire_date']=='90') selected @endif>90天</option>
                                                    <option value="120" @if($settings['cert_expire_date']=='120') selected @endif>120天</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding-left: 0px!important; padding-right: 0px!important;">
                            <div class="table-responsive">
                                <table style="table-layout:fixed;">
                                    <tbody class="" id="list-body">
                                        <tr>
                                            <td class="add-td-label" style="width:15%!important;">批准次数:</td>
                                            <td class="add-td-text">
                                                <select name="select-report-year" id="select-report-year" class="form-control" style="font-size:13px">
                                                    @for($i=date("Y");$i>=$start_year;$i--)
                                                    <option value="{{$i}}" @if($i==$settings['report_year']) selected @endif>{{$i}}年</option>
                                                    @endfor
                                                </select>
                                            </td>
                                            <td class="add-td-label" style="width:15%!important;">TOP PORTS:</td>
                                            <td class="add-td-text">
                                                <select name="select-port-year" id="select-port-year" class="form-control" style="font-size:13px">
                                                    @for($i=date("Y");$i>=$start_year;$i--)
                                                    <option value="{{$i}}" @if($i==$settings['port_year']) selected @endif>{{$i}}年</option>
                                                    @endfor
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="add-td-label">船舶日报:</td>
                                            <td class="add-td-text">
                                                <select name="select-dyn-year" id="select-dyn-year" class="form-control" style="font-size:13px">
                                                    @for($i=date("Y");$i>=$start_year;$i--)
                                                    <option value="{{$i}}" @if($i==$settings['dyn_year']) selected @endif>{{$i}}年</option>
                                                    @endfor
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <table style="table-layout:fixed;">
                        </table>
                        <div class="table-head-fix-div" style="max-height: 157px;margin-top:20px;">
                        <table id="table-dynamic-list" style="table-layout:fixed;">
                            <thead class="">
                                <th class="text-center style-normal-header" style="width: 5%;height:35px;"><span>船名</span></th>
                                <th class="text-center style-normal-header" style="width: 6%;"><span>DATE</span></th>
                                <th class="text-center style-normal-header" style="width: 4%;"><span>TIME</span></th>
                                <th class="text-center style-normal-header" style="width: 12%;"><span>STATUS</span></th>
                                <th class="text-center style-normal-header" style="width: 9%;"><span>POSITION</span></th>
                                <th class="text-center style-normal-header" style="width: 7%;"><span>CGO QTY</span></th>
                                <th class="text-center style-normal-header" style="width: 7%;"><span>ROB(FO)</span></th>
                                <th class="text-center style-normal-header" style="width: 7%;"><span>ROB(DO)</span></th>
                                <th class="text-center style-normal-header" style="width: 7%;"><span>BNKR(FO)</span></th>
                                <th class="text-center style-normal-header" style="width: 7%;"><span>BNKR(DO)</span></th>
                                <th class="text-center style-normal-header" style=""><span>REMARK</span></th>
                                <th class="text-center style-normal-header" style="width: 7%;"><span>无显示</span></th>
                            </thead>
                            <tbody class="" id="list-body">
                            @if (isset($voyList) && count($voyList) > 0)
                            <?php $index = 1;?>
                            
                            @foreach ($voyList as $info)
                                <?php $nickName=""?>
                                @foreach($shipList as $ship)
                                    @if ($ship->IMO_No == $info['Ship_ID'])
                                    <?php $nickName = $ship['NickName'];?>
                                    @endif
                                @endforeach
                                <tr @if($index%2==0) class="member-item-odd" @else class="member-item-even" @endif>
                                    <td class="center" style="height:20px;">{{$nickName}}</td>
                                    <td class="center">{{$info['Voy_Date']}}</td>
                                    <td class="center">{{str_pad($info['Voy_Hour'],2,"0",STR_PAD_LEFT).str_pad($info['Voy_Minute'],2,"0",STR_PAD_LEFT)}}</td>
                                    <td class="center">{{g_enum('DynamicStatus')[$info['Voy_Status']][0]}}</td>
                                    <td class="center">{{$info['Ship_Position']}}</td>
                                    <td class="center">{{$info['Cargo_Qtty']}}</td>
                                    <td class="center">{{$info['ROB_FO']}}</td>
                                    <td class="center">{{$info['ROB_DO']}}</td>
                                    <td class="center">{{$info['BUNK_FO']}}</td>
                                    <td class="center">{{$info['BUNK_DO']}}</td>
                                    <td class="center">{{$info['Remark']}}</td>
                                    <td class="center dyn-visible" data-id="{{$info['id']}}" style="cursor:pointer;">{{$info['ishide']?"✓":""}}</td>
                                    <?php $index++;?>
                                </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8">{{ trans('common.message.no_data') }}</td>
                            </tr>
                            
                            @endif
                            
                            </tbody>
                        </table>
                        </div>
                        <table id="table-sites-list" style="table-layout:fixed;margin-top:20px;">
                            <thead class="">
                                <th class="text-center style-normal-header" style="width: 5%;height:35px;"><span>Order No</span></th>
                                <th class="text-center style-normal-header" style="width: 60%;"><span>网站地址</span></th>
                                <th class="text-center style-normal-header" style="width: 30%;"><span>有关网站</span></th>
                                <th class="text-center style-normal-header" style="width: 5%;"></th>
                            </thead>
                            <tbody class="" id="table-sites-list-body">
                            @for($index=0;$index<10;$index++)
                                <tr @if($index%2==0) class="member-item-odd" @else class="member-item-even" @endif>
                                @if (isset($sites[$index]))
                                    <td class="center" style="height:20px;"><input name="site_orders[]" @if($index%2==0) class="text-center form-control member-item-odd" @else class="text-center form-control member-item-even" @endif value="{{$sites[$index]['orderNo']}}"></input></td>
                                    <td class="center"><input name="site_links[]" @if($index%2==0) class="form-control member-item-odd" @else class="form-control member-item-even" @endif value="{{$sites[$index]['link']}}" autocomplete="off"></input></td>
                                    @if (($sites[$index]['image'] != null) && ($sites[$index]['image'] != ''))
                                    <td class="center">
                                        <div class="report-attachment">
                                            <a href="{{$sites[$index]['image']}}" target="_blank">
                                                <img src="{{ cAsset('assets/images/document.png') }}" width="15" height="15">
                                            </a>
                                            <img src="{{ cAsset('assets/images/cancel.png') }}" onclick="deleteAttach(this)" width="10" height="10">
                                            <label for={{$index}} ><img src="{{ cAsset('assets/images/paper-clip.png') }}"  width="15" height="15" style="margin: 2px 4px" class="d-none"></label>
                                            <input type="file" name="attachment[]" id="{{$index}}" data-index="{{$index}}" accept="image/png, image/gif, image/jpeg" class="d-none" enctype="multipart/form-data">
                                            <input type="hidden" name="is_update[]" class="d-none" value="0">
                                            <input type="hidden" name="image[]" class="d-none" value="{{$sites[$index]['image']}}">
                                            <input type="hidden" name="image_path[]" class="d-none" value="{{$sites[$index]['image_path']}}">
                                        </div>
                                    </td>
                                    @else
                                    <td class="center">
                                        <label for={{$index}} ><img src="{{ cAsset('assets/images/paper-clip.png') }}"  width="15" height="15" style="margin: 2px 4px"></label>
                                        <input type="file" name="attachment[]" id="{{$index}}" data-index="{{$index}}" accept="image/png, image/gif, image/jpeg" class="d-none" enctype="multipart/form-data">
                                        <input type="hidden" name="is_update[]" class="d-none" value="0">
                                        <input type="hidden" name="image[]" class="d-none" value="">
                                        <input type="hidden" name="image_path[]" class="d-none" value="">
                                    </td>
                                    @endif
                                @else
                                    <td class="center" style="height:20px;"><input name="site_orders[]" @if($index%2==0) class="text-center form-control member-item-odd" @else class="text-center form-control member-item-even" @endif value=""></input></td>
                                    <td class="center"><input name="site_links[]" @if($index%2==0) class="form-control member-item-odd" @else class="form-control member-item-even" @endif value="" autocomplete="off"></input></td>
                                    <td class="center">
                                        <label for={{$index}} ><img src="{{ cAsset('assets/images/paper-clip.png') }}"  width="15" height="15" style="margin: 2px 4px"></label>
                                        <input type="file" name="attachment[]" id="{{$index}}" data-index="{{$index}}" accept="image/png, image/gif, image/jpeg" class="d-none" enctype="multipart/form-data">
                                        <input type="hidden" name="is_update[]" class="d-none" value="0">
                                        <input type="hidden" name="image[]" class="d-none" value="">
                                        <input type="hidden" name="image_path[]" class="d-none" value="">
                                    </td>
                                @endif
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a class="red" onclick="deleteItem(this)">
                                                <i class="icon-trash" style="color: red!important;"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                        <div class="head-fix-div" style="max-height: 200px; margin-top:20px;padding: 0 1px;table table-bordered">
                            <table id="table-report-list" style="margin-bottom: 20px;">
                            </table>
                        </div>
                        <div class="space-12"></div>
                    </div>
                </div>
            
            </div>
            </form>
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
    echo 'var ship_ids = ' . $settings['graph_ship'] . ';';
	echo 'var ReportTypeLabelData = ' . json_encode(g_enum('ReportTypeLabelData')) . ';';
	echo 'var ReportTypeData = ' . json_encode(g_enum('ReportTypeData')) . ';';
	echo 'var ReportStatusData = ' . json_encode(g_enum('ReportStatusData')) . ';';
    echo 'var CurrencyLabel = ' . json_encode(g_enum('CurrencyLabel')) . ';';
    echo 'var FeeTypeData = ' . json_encode(g_enum('FeeTypeData')) . ';';
    echo 'var ships = [];';
    foreach($shipList as $ship) {
        echo 'ships["' . $ship['IMO_No'] . '"]="' . $ship['NickName'] . '";';
    }

	echo '</script>';
	?>
    <script>
        var token = '{!! csrf_token() !!}';
        var shipName = '';
        var OBJECT_TYPE_SHIP = '{!! OBJECT_TYPE_SHIP !!}';

        document.multiselect('#select-graph-ship')
        .setCheckBoxClick("checkboxAll", function(target, args) {
        })
        .setCheckBoxClick("1", function(target, args) {
        });
        $('.multiselect-input').attr('style','border:unset!important;width:100%!important;height:10px!important;margin-top:3px;width:auto!important;');
        $('.multiselect-count').attr('style','margin-top:-4px!important;');
        $('.multiselect-input-div').attr('style','border:unset!important;height:10px!important;width:auto!important;');
        $('.multiselect-dropdown-arrow').attr('style','margin-top:1px');
        $('.multiselect-list').attr('style','margin-top:7px;z-index:1000;')
        $('.multiselect-wrapper').on('click', function() {
            $('.multiselect-wrapper hr').hide()
        })

        $("#btnSave").on('click', function() {
            $('#validation-form').submit();
        });

        for (var i=0;i<ship_ids.length; i++) {
            document.multiselect('#select-graph-ship').select(ship_ids[i]);
        }
        $('#select-graph-ship').trigger("chosen:updated");


        $("input[type=file]").on('change',function(e) {
            var parentElement = e.target.parentElement;
            var dest = ($($(parentElement).children(":first"))).children(":first");
            var isUpdate = $(parentElement).children().eq(2);
            $(dest).attr('src', "{{ cAsset('assets/images/document.png') }}");
            $(isUpdate).val('1');
        });

        $(".dyn-visible").on('click',function(e) {
            var ishide = 0;
            var td_html = "";
            if (e.target.innerHTML == "") {
                ishide = 1;
                td_html = "✓";
            }
            e.target.innerHTML = td_html;

            //td_html = "input type='hidden' name="
            var parentElement = e.target.parentElement;
            var name = $($(parentElement).children(":last")).attr('name');
            if (name == 'dyn_value[]') {
                $(parentElement).children(":last").remove();
                $(parentElement).children(":last").remove();
            }
            td_html = "<input type='hidden' name='dyn_id[]' value='" + ($(parentElement).children("td:last")).attr('data-id') + "'/>";
            td_html += "<input type='hidden' name='dyn_value[]' value='" + ishide + "'/>";
            $(parentElement).append(td_html);
        });

        function alertAudio() {
            document.getElementById('warning-audio').play();
        }

        function deleteAttach(e) {
            var parentElement = e.parentElement;
            $($(parentElement).children(":first")).remove();
            $($(parentElement).children(":first")).remove();
            $($(parentElement).children(":first")).attr('class','d-block');
            ($($(parentElement).children(":first"))).children(":first").attr('class','d-block');
            var isUpdate = $(parentElement).children().eq(2);
            $(isUpdate).val('1');
        }

        function deleteItem(e) {
            alertAudio();
            bootbox.confirm("Are you sure you want to delete?", function (result) {
                if (result) {
                    //var id = $(e).closest("tr").attr('data-ref');
                    $(e).closest("tr").remove();
                    resortSites();
                }
            });
        }

        function resortSites() {
            for (var i=0;i<$('#table-sites-list-body').children().length;i++) {
                $($($('#table-sites-list-body').children()[i]).children()[0].firstChild).val(i+1);
            }
        }

        function onFileChange(e) {
            alert(e);
        }

        
        $(function() {
            initTable();
        });

        function initTable()
        {
            listTable = $('#table-report-list').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/decide/noattachments',
                    type: 'POST',
                },
                "ordering": false,
                "pageLength": 100,
                columnDefs: [{
                    targets: [0],
                    orderable: false,
                    searchable: false
                }],
                columns: [
                    {data: 'report_id', className: "text-center"},
                    {data: 'report_date', className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: 'voyNo', className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center report-visible"},
                ],
                createdRow: function (row, data, index) {
                    if (data['flowid'] == "Credit") {
                        $('td', row).eq(2).attr('class', 'text-center text-profit');
                    }
                    $('td', row).eq(2).html(ReportTypeData[data['flowid']]);
                    if(data['obj_type'] == OBJECT_TYPE_SHIP) {
                        $('td', row).eq(3).html(ships[data['shipNo']]);
                    } else {
                        $('td', row).eq(3).html(__parseStr(data['obj_name']));
                    }

                    var profit_type = FeeTypeData[data['flowid']][data['profit_type']];
                    if (profit_type == null || profit_type == 'null' || profit_type == undefined) profit_type = "";
                    //$('td', row).eq(5).html(profit_type);
                    if(data['flowid'] != 'Contract' &&  data['flowid'] != 'Other') {
                        $('td', row).eq(5).html('').append(
                            '<span class="' + (data['flowid'] == "Credit" ? "text-profit" : "") + '">' + __parseStr(profit_type) + '</span>'
                        );  
                    } else {
                        $('td', row).eq(5).html('').append(
                            ''
                        );  
                    }


                    $('td', row).eq(6).html('<img src="' + "{{ cAsset('assets/images/paper-clip.png') }}" + '"' + ' width="15" height="15">');
                    $('td', row).eq(7).html(data['ishide']?"✓":"");
                    $('td', row).eq(7).css('cursor','pointer');
                    //$('td', row).eq(7).prop('class','report-visible');
                },
                initComplete: function (response) {
                    $($($('#table-report-list thead').children()[0]).children()[2]).prop("colspan","5").prop("height","30px");
                    $($($('#table-report-list thead').children()[0]).children()[3]).remove();
                    $($($('#table-report-list thead').children()[0]).children()[3]).remove();
                    $($($('#table-report-list thead').children()[0]).children()[3]).remove();
                    $($($('#table-report-list thead').children()[0]).children()[3]).remove();
                    $($($('#table-report-list thead').children()[0]).children()[0]).html('审批编号')
                    $($($('#table-report-list thead').children()[0]).children()[0]).css('font-style','unset');
                    $($($('#table-report-list thead').children()[0]).children()[0]).css('width', '9%');
                    $($($('#table-report-list thead').children()[0]).children()[1]).html('申请日期')
                    $($($('#table-report-list thead').children()[0]).children()[1]).css('font-style','unset');
                    $($($('#table-report-list thead').children()[0]).children()[1]).css('width', '10%');
                    $($($('#table-report-list thead').children()[0]).children()[2]).html('无凭证文件')
                    $($($('#table-report-list thead').children()[0]).children()[2]).css('font-style','unset');
                    $($($('#table-report-list thead').children()[0]).children()[2]).css('width', '75%');
                    $($($('#table-report-list thead').children()[0]).children()[3]).html('无显示')
                    $($($('#table-report-list thead').children()[0]).children()[3]).css('font-style','unset');
                    $($($('#table-report-list thead').children()[0]).children()[3]).css('width', '5%');
                    //$('#table-report-list_wrapper').css('overflow-x', 'hidden');

                },
                drawCallback: function (response) {
                    $(".report-visible").unbind().on('click',function(e) {
                        var ishide = 0;
                        var td_html = "";
                        if (e.target.innerHTML == "") {
                            ishide = 1;
                            td_html = "✓";
                        }
                        e.target.innerHTML = td_html;

                        //td_html = "input type='hidden' name="
                        var parentElement = e.target.parentElement;
                        var name = $($(parentElement).children(":last")).attr('name');
                        if (name == 'visible_value[]') {
                            $(parentElement).children(":last").remove();
                            $(parentElement).children(":last").remove();
                        }
                        td_html = "<input type='hidden' name='visible_id[]' value='" + ($(parentElement).children(":first")).html() + "'/>";
                        td_html += "<input type='hidden' name='visible_value[]' value='" + ishide + "'/>";
                        $(parentElement).append(td_html);
                    });
                }
            });

            // $('.paginate_button').hide();
            $('.dataTables_length').hide();
            // $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }
    </script>

@endsection
