@extends('layout.header')

@section('content')
    <div class="main-content">
        <style>
            .table thead>tr>th {
                padding: 6px 3px;
            }
        </style>
        <div class="page-content">
            <div class="page-header">
                <div class="col-md-3">
                    <h4>
                        <b>{{trans("orgManage.title.MemberInfo")}}</b>
                    </h4>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-11">
                        <div class="col-md-3">
                            <label style="float:left;padding-top:7px">{{trans("orgManage.captions.department")}}:</label>
                            <div class="col-md-9" style="padding-left:10px">
                                <select class="form-control chosen-select select_unit">
                                    <option value="">{{trans("orgManage.captions.total")}}</option>
                                    @foreach($unitList as $unit)
                                        <option value="{{$unit['id']}}" @if(isset($unitId) && ($unitId == $unit['id'])) selected @endif>{{$unit['title']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label style="float:left;padding-top:7px">{{trans("orgManage.captions.officePosition")}}:</label>
                            <div class="col-md-9" style="padding-left:10px">
                                <select class="form-control chosen-select select_pos">
                                    <option value="">{{trans("orgManage.captions.total")}}</option>
                                    @foreach($posList as $pos)
                                        <option value="{{$pos['id']}}" @if(isset($posId) && ($posId == $pos['id'])) selected @endif>{{$pos['title']}}</option>
                                    @endforeach
                                    <option value="{{ STAFF_LEVEL_SHAREHOLDER }}">船东</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 input-group">
                            <label>{{trans("orgManage.captions.name")}}:</label>
                            <input class="form-control realname" style="width:65%;margin-left: 10px" value="@if(isset($realname)){{$realname}}@endif">
                        </div>
                        <button class="btn btn-primary btn-sm search-btn" style="float:left; width: 80px"><i class="icon-search"></i>{{trans("orgManage.captions.search")}}</button>
                    </div>
                </div>
                <div class="row">
                    <div class="space-4"></div>
                    <div class="table-responsive" id="user_list_table">
                        <table class="table table-striped table-bordered table-hover" id="user-table">
                            <thead>
                            <tr class="black br-hblue">
                                <th class="center">No</th>
                                <th class="center">{{trans("orgManage.captions.department")}}</th>
                                <th style="text-align: left" class="center">{{trans("orgManage.captions.officePosition")}}</th>
                                <th class="center">{{trans("orgManage.captions.name")}}</th>
                                <th width="50px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (isset($list) && count($list) > 0)
								<?php $index = ($list->currentPage() - 1) * 15 + 1; ?>
                                @foreach ($list as $userInfo)

                                    <tr>
                                        <td class="center">{{$index++}}</td>
                                        <td class="center">{{is_null($userInfo['unitTitle'])?'':$userInfo['unitTitle']}}</td>
                                        <td class="center">{{is_null($userInfo['posTitle']) ? '&nbsp;':$userInfo['posTitle']}}</td>
                                        <td class="center">{{$userInfo['realname']}}</td>
                                        <td class="action-buttons center">
                                            <a class="blue" href="{{ 'privilege' }}?uid={{$userInfo->id}}">
                                                <i class="icon-edit bigger-130"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">{{ trans('common.message.no_data') }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        {!! $list->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.main-content -->

    <script>

        function filterByUnitName() {
            var keyword = $("#search_unit").val();
            $("#user-table_filter").find('input[type="text"]').val(keyword).trigger("keyup.DT");
        }

        $(function () {
            $('.search-btn').on('click', function () {
                var unit = $('.select_unit').val();
                var pos = $('.select_pos').val();
                var realname = $('.realname').val();
                var status = $('.select_status').val();

                var param = '';
                if(unit.length > 0)
                    param = '?unit=' + unit;
                if(pos.length > 0)
                    param = (param == '' ? '?' : param + '&') + 'pos=' + pos;

                if(realname.length > 0)
                    param = (param == '' ? '?' : param + '&') + 'realname=' + realname;

                location.href = 'userPrivilege' + param;
            });

            $('.init-btn').on('click', function() {

                location.href = 'userInfoListView';
            });

        })

    </script>
@stop
