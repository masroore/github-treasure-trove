@extends('layout.header')
<?php
$isHolder = Session::get('IS_HOLDER');
$shipList = Session::get('shipList');
?>

@section('styles')
    <link href="{{ cAsset('css/pretty.css') }}" rel="stylesheet">
    <link href="{{ cAsset('css/dycombo.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="page-header">
                <div class="col-sm-3">
                    <h4><b>Ship Register</b></h4>
                </div>
                <div class="col-sm-6"></div>
                <div class="col-sm-3">
                    @if(!$isHolder)
                        <div class="btn-group f-right">
                            <a href="/shipManage/registerShipData?type=new" class="btn btn-sm btn-primary btn-add" style="width: 80px">
                                <i class="icon-plus"></i>{{ trans('common.label.add') }}
                            </a>
                            <button type="submit" id="btnRegister" class="btn btn-sm btn-success" style="width: 80px">
                                <i class="icon-save"></i>{{ trans('common.label.save') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-12" style="margin-top:2px;">
                <div id="item-manage-dialog" class="hide"></div>
                <div class="row">
                    <div class="head-fix-div" id="ship-table" style="height: 128px;">
                        <table class="registered-list" style="table-layout:fixed">
                            <thead id="list-header">
                            <tr>
                                <th class="text-center style-header" style="width: 2%;"><span>No</span></th>
                                <th class="text-center style-header" style=""><span>ShipName</span></th>
                                <th class="text-center style-header" style="width: 6%;"><span>IMO NO</span></th>
                                <th class="text-center style-header" style="width: 8%;"><span>Flag</span></th>
                                <th class="text-center style-header" style="width: 8%;"><span>Port of Registry</span></th>
                                <th class="text-center style-header" style="width: 6%;"><span>Class</span></th>
                                <th class="text-center style-header" style="width: 4%;"><span>GT</span></th>
                                <th class="text-center style-header" style="width: 4%;"><span>NT</span></th>
                                <th class="text-center style-header" style="width: 4%;"><span>DWT</span></th>
                                <th class="text-center style-header" style="width: 18%;"><span>ShipType</span></th>
                                <th class="text-center style-header" style="width: 4%;"><span>LOA</span></th>
                                <th class="text-center style-header" style="width: 4%;"><span>BM</span></th>
                                <th class="text-center style-header" style="width: 4%;"><span>DM</span></th>
                                <th class="text-center style-header" style="width: 5%;"><span>Draught</span></th>
                                @if(Auth::user()->isAdmin == STAFF_LEVEL_MANAGER)
                                    <th style="width: 2%;"></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
							<?php $index = 1; ?>
                            @if(isset($list) && count($list) > 0)
                                @foreach ($list as $item)
                                    @if(!$isHolder || ($isHolder == true && in_array($item['id'], $shipList)))
                                        <tr class="ship-item {{ $item['id'] == $shipInfo['id'] ? 'selected' : '' }}" data-index="{{ $item['id'] }}">
                                            <td class="text-center no-padding">{{ $index }}</td>
                                            <td class="text-center no-padding">{{ $item['shipName_En'] }}</td>
                                            <td class="text-center no-padding">{{ $item['IMO_No'] }}</td>
                                            <td class="text-center no-padding">{{ $item['Flag'] }}</td>
                                            <td class="text-center no-padding">{{ $item['PortOfRegistry'] }}</td>
                                            <td class="text-center no-padding">{{ $item['Class'] }}</td>
                                            <td class="text-center no-padding">{{ $item['GrossTon'] }}</td>
                                            <td class="text-center no-padding">{{ $item['NetTon'] }}</td>
                                            <td class="text-center no-padding">{{ $item['Deadweight'] }}</td>
                                            <td class="text-center no-padding">{{ $item['ShipType'] }}</td>
                                            <td class="text-center no-padding">{{ $item['LOA'] }}</td>
                                            <td class="text-center no-padding">{{ $item['BM'] }}</td>
                                            <td class="text-center no-padding">{{ $item['DM'] }}</td>
                                            <td class="text-center no-padding">{{ $item['Draught'] }}</td>
                                            @if(Auth::user()->isAdmin == STAFF_LEVEL_MANAGER)
                                                <td class="text-center no-padding">
                                                    <div class="action-buttons">
                                                        @if(!$isHolder)
                                                            <a class="red" href="javascript:deleteItem('{{ $item['id'] }}', '{{ $item['shipName_Cn'] }}')">
                                                                <i class="icon-trash"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endif
									<?php $index ++; ?>
                                @endforeach
                            @else
                                <div>
                                    {{ trans('common.message.no_data') }}
                                </div>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row" style="bottom: -3px; position: relative;">
                    <div class="tabbable">
                        <ul class="nav nav-tabs ship-register" id="myTab">
                            <li class="active">
                                <a data-toggle="tab" href="#general">
                                    {{ trans('shipManage.tabMenu.General') }}
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#hull">
                                    {{ trans('shipManage.tabMenu.Hull/Cargo') }}
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#machiery">
                                    {{ trans('shipManage.tabMenu.Machinery') }}
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#remarks">
                                    {{ trans('shipManage.tabMenu.Remarks') }}
                                </a>
                            </li>
                            <li>
                                <div class="alert alert-block alert-success center visuallyhidden">
                                    <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                                    <strong id="msg-content"> Please register a new ship.</strong>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <form role="form" method="POST" action="{{url('shipManage/saveShipData')}}" enctype="multipart/form-data" id="general-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="shipId"
                               value="@if(isset($shipInfo['id'])){{$shipInfo['id']}}@else'0'@endif">
                        <div class="tab-content">
                            <div id="general" class="tab-pane active">
                                @include('shipManage.tab_general', with(['shipList'=>$shipList, 'shipType'=>$shipType, 'shipInfo'=>$shipInfo]))
                            </div>
                            <div id="hull" class="tab-pane">
                                @include('shipManage.tab_hull', with(['shipList'=>$shipList, 'shipType'=>$shipType, 'shipInfo'=>$shipInfo, 'freeBoard'=>$freeBoard]))
                            </div>
                            <div id="machiery" class="tab-pane">
                                @include('shipManage.tab_machinery', with(['shipList'=>$shipList, 'shipType'=>$shipType, 'shipInfo'=>$shipInfo]))
                            </div>
                            <div id="remarks" class="tab-pane">
                                @include('shipManage.tab_remarks', with(['shipInfo'=>$shipInfo]))
                            </div>
                            <div class="space-4"></div>
                        </div>
                    </form>
                </div>
                <div class="vspace-xs-12"></div>
            </div>
            <a href="#modify-dialog" role="button" class="hidden" data-toggle="modal" id="dialog-show-btn"></a>
            <div id="modify-dialog" class="modal fade modal-draggable" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content" id="item-modify-dialog">
                    </div>
                </div>
            </div>
            <div id="modal-shiptype-list" class="modal modal-draggable" aria-hidden="true" style="display: none; margin-top: 15%;">
                <div class="dynamic-modal-dialog">
                    <div class="dynamic-modal-content" style="border: 0;">
                        <div class="dynamic-modal-header" data-target="#modal-step-contents">
                            <div class="table-header">
                                <button type="button"  style="margin-top: 8px; margin-right: 12px;" class="close" data-dismiss="modal" aria-hidden="true">
                                    <span class="white">&times;</span>
                                </button>
                                <h4 style="padding-top:10px;font-style:italic;">Ship Type</h4>
                            </div>
                        </div>
                        <div id="modal-shiptype-content" class="dynamic-modal-body step-content">
                            <div class="row" style="">
                                <div class="head-fix-div col-md-12" style="height:300px;">
                                    <table class="table-bordered rank-table">
                                        <thead>
                                        <tr class="rank-tr" style="background-color: #d9f8fb;height:18px;">
                                            <th class="text-center sub-header style-bold-italic" style="background-color: #d9f8fb;width:10%">OrderNo</th>
                                            <th class="text-center sub-header style-bold-italic" style="background-color: #d9f8fb;">Name of ShipType</th>
                                            <th class="text-center sub-header style-bold-italic" style="background-color: #d9f8fb;width:10%"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="shiptype-table">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="btn-group f-right mt-20 d-flex">
                                        <button type="button" class="btn btn-success small-btn ml-0" onclick="javascript:dynamicShipTypeSubmit('shiptype')">
                                            <img src="{{ cAsset('assets/images/send_report.png') }}" class="report-label-img">OK
                                        </button>
                                        <div class="between-1"></div>
                                        <a class="btn btn-danger small-btn close-modal" data-dismiss="modal"><i class="icon-remove"></i>Cancel</a>
                                    </div>
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

    <script src="{{ asset('/assets/js/x-editable/bootstrap-editable-photo.min.js') }}"></script>
    <script src="{{ asset('/assets/js/x-editable/ace-editable.min.js') }}"></script>
    <script src="{{ asset('/assets/js/ajaxfileupload.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.colorbox-min.js') }}"></script>
    <script src="{{ asset('/assets/js/dycombo.js') }}"></script>

    <script type="text/javascript">

        var token = '{!! csrf_token() !!}';
        var shipId = '{!! $shipInfo['id'] !!}';
        var submitted = false;

        var state = '@if(isset($status)){{$status}}@endif';
        $(function () {
            //editables on first profile page
            $.fn.editable.defaults.mode = 'inline';
            $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue icon-2x icon-spinner icon-spin'></i></div>";
            $.fn.editableform.buttons = '<button type="submit" class="btn btn-primary editable-submit"><i class="icon-ok icon-white"></i></button>';
            if(state == 'error') {
                $.gritter.add({
                    title: '错误',
                    text: 'IMO_No不可以重复了!',
                    class_name: 'gritter-error'
                });
            }
        });

        $('#btnRegister').on('click', function() {
            $('form').validate();
            $('form').submit();
        });

        $('.registered-list').on('click', 'tr', function(evt) {
            let cell = $(evt.target).closest('td');
            if(!$(this).hasClass('ship-item')) return false;
            if(cell.index() < 14) {
                if($(this).hasClass('selected'))
                    return;

                let ship_id = $(this).attr('data-index');
                location.href = BASE_URL + 'shipManage/registerShipData?shipId=' + ship_id;
            }
        });

        function alertAudio() {
            document.getElementById('warning-audio').play();
        }

        function deleteItem(shipId, shipName) {
            alertAudio();
            bootbox.confirm("All related records are about to be damaged.<br>Are you sure you want to delete?", function (result) {
                if (result) {
                    $.post('deleteShipData', {'_token':token, 'dataId':shipId}, function (result) {
                        var code = parseInt(result);
                        if (code > 0) {
                            location.reload();
                        } else {

                        }
                    });
                }
            });
        }

        $(function() {
            if(shipId.length < 1) {
                $('.alert').toggleClass('visuallyhidden');
                setTimeout(function() {
                    $('.alert').toggleClass('visuallyhidden');
                }, 2000);
                $('[name=shipName_En]').focus();
            }
            else
            {
                var row = $(".ship-item.selected");
                var headrow = $('#list-header');
                $('#ship-table').scrollTop(row.position().top - headrow.innerHeight());
            }
        })

        $(function () {
            $('ul li a[data-toggle=tab]').click(function(){
                $nowTab = $(this).attr("href");
                window.localStorage.setItem("shipRegTab",$nowTab);
            });

            if (shipId != -1) {
                $initTab = window.localStorage.getItem("shipRegTab");
                if ($initTab != null) {
                    $('ul li a[data-toggle=tab]').each(function(){
                        $href = $(this).attr("href");
                        $(this).parent("li").prop("class","");
                        $($href).prop("class", "tab-pane");
                        if($initTab == $href) {
                            $($initTab).prop("class", "tab-pane active");
                            $(this).parent("li").prop("class","active");
                        }
                    });
                }
            }
        });

        $('body').on('keydown', 'input, select', function(e) {
            if (e.key === "Enter") {
                var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
                focusable = form.find('input,a,select,button,textarea').filter(':visible');
                next = focusable.eq(focusable.index(this)+1);
                if (next.length) {
                    next.focus();
                    next.select();
                } else {
                    form.submit();
                }
                return false;
            }
        });

        $('body').on('click', function(e) {
            var current = null;
            if ($(event.target).attr('class') == 'form-control dynamic-select-span' || $(event.target).attr('class') == 'dynamic-select__trigger') {
                current = $(event.target).closest('.dynamic-select-wrapper');
            }
            for (const selector of document.querySelectorAll(".dynamic-select-wrapper")) {
                if (current == null || selector != current[0])
                    selector.firstElementChild.classList.remove('open');
            }
        });

        $('#general').find('input').not('.auto-complete').attr('autocomplete', 'off');

        
        $("form").submit(function() {
            submitted = true;
        });

        var $form = $('form');
        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = 'It looks like you have been editing something. '
                                    + 'If you leave before saving, your changes will be lost.';
            if ($form.serialize() !== origForm && !submitted) {
                console.log($form.serialize());
                console.log(origForm);
                (e || window.event).returnValue = confirmationMessage;
            }
            return confirmationMessage;
        });
        /*
        var $form = $('form'),
        origForm = $form.serialize();
        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = 'It looks like you have been editing something. '
                                    + 'If you leave before saving, your changes will be lost.';
            console.log($form.serialize());
            console.log($form.serialize() !== origForm);

            console.log("Really");
            alert("Really?");
            if ($form.serialize() !== origForm) {
                (e || window.event).returnValue = confirmationMessage;
            }
            return confirmationMessage;
        });
        */
    </script>
@stop