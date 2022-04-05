@extends('layout.header')
<?php
$isHolder = Session::get('IS_HOLDER');
?>

@section('styles')
    <link href="{{ cAsset('css/pretty.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="main-content">
        <style>
            .backup-member-item {
                height:30px;
            }

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
            <div class="page-header">
                <div class="col-sm-3">
                    <h4><b>数据备份</b></h4>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-6">
                    <strong class="f-right" style="font-size: 16px; padding-top: 6px;"><span id="ship_name"></span>备份历史</strong>
                </div>
                <div class="col-md-6" style="padding:unset!important">
                    <div class="btn-group f-right">
                        <a class="btn btn-warning btn-sm excel-btn" onclick="javascript:shell_backup_command();"><i class="icon-table"></i>备份</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="margin-top:4px;">
                <div id="item-manage-dialog" class="hide"></div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="row">
                    <div class="head-fix-div common-list" style="">
                        <table id="table-system-backup" style="table-layout:fixed;">
                            <thead class="">
                                <th class="text-center style-header" style="width: 5%;"><span>No</span></th>
                                <th class="text-center style-header" style="width: 25%;"><span>文件名称</span></th>
                                <th class="text-center style-header" style="width: 25%;"><span>备份日期</span></th>
                                <th class="text-center style-header" style="width: 15%;"><span>用户名</span></th>
                                <th class="text-center style-header" style="width: 10%;"><span>文件位置</span></th>
                                <th class="text-center style-header" style="width: 10%;"><span>还原</span></th>
                                <th class="text-center style-header" style="width: 10%;"><span>删除</span></th>
                            </thead>
                            <tbody class="" id="list-body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <audio controls="controls" class="d-none" id="warning-audio">
            <source src="{{ cAsset('assets/sound/delete.wav') }}">
            <embed src="{{ cAsset('assets/sound/delete.wav') }}" type="audio/wav">
        </audio>
    </div>

    <script src="{{ asset('/assets/js/x-editable/bootstrap-editable.min.js') }}"></script>
    <script src="{{ asset('/assets/js/x-editable/ace-editable.min.js') }}"></script>
    <script src="{{ asset('/assets/js/loadingoverlay.min.js') }}"></script>
    <script src="{{ cAsset('assets/js/jsquery.dataTables.js') }}"></script>
    <script src="{{ asset('/assets/js/dataTables.rowsGroup.js') }}"></script>
    <script>
        var token = '{!! csrf_token() !!}';
        var shipName = '';

        var listTable = null;
        function initTable() {
            listTable = $('#table-system-backup').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/system/backup/list',
                    type: 'POST',
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: null, className: "text-center"},
                    {data: 'filename', className: "text-center"},
                    {data: 'datetime', className: "text-center"},
                    {data: 'realname', className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                ],
                createdRow: function (row, data, index) {
                    if ((index%2) == 0)
                        $(row).attr('class', 'backup-member-item cost-item-even');
                    else
                        $(row).attr('class', 'backup-member-item cost-item-odd');

                    $(row).attr('data-ref', data['id']);
                        
                    var pageInfo = listTable.page.info();
                    $('td', row).eq(0).html(index+1);
                    $('td', row).eq(4).html('').append('<div class="action-buttons"><a class="blue" href="javascript:open_backup_folder(' + "'" + data['filepath'].replaceAll(/\\/g,"/") + "','" + data['filename'] + "'" + ')"' + ' title="File Path"><i class="icon-book"></i></a></div>');
                    $('td', row).eq(5).html('').append('<div class="action-buttons"><a class="red" href="javascript:restore(' + "'" + data['filepath'].replaceAll(/\\/g,"/") + "','" + data['filename'] + "'" + ')"' + ' title="Restore"><i class="icon-plus"></i></a></div>');
                    $('td', row).eq(6).html('').append('<div class="action-buttons"><a class="red" onclick="javascript:deleteItem(this)"><i class="icon-trash"></i></a></div>');
                },
            });

            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }
        initTable();
        function shell_backup_command()
        {
            $('.main-content').LoadingOverlay('show', {
                text : "处理中..."
            });
            $.ajax({
                url: BASE_URL + 'ajax/system/backup/backup',
                type: 'POST',
                success: function(result) {
                    if (result.success == 0)
                    {
                        $.gritter.add({
                            title: '错误',
                            text: '备份失败了!',
                            class_name: 'gritter-success'
                        });
                        $('.main-content').LoadingOverlay('hide');
                        return;
                    }
                    listTable.ajax.reload();
                    $.gritter.add({
                        title: '成功',
                        text: '备份成功!',
                        class_name: 'gritter-success'
                    });
                    $('.main-content').LoadingOverlay('hide');
                },
                error: function(error) {
                    $.gritter.add({
                        title: '错误',
                        text: '备份途中发生了错误!',
                        class_name: 'gritter-success'
                    });
                    $('.main-content').LoadingOverlay('hide');
                }
            });
        }

        function open_backup_folder(path, name)
        {
            alert(path+name);
        }

        function restore(path, name)
        {
            alertAudio();
            bootbox.confirm("All related records are about to be damaged.<br>Are you sure you want to restore?", function (result) {
                if (result) {
                    $('.main-content').LoadingOverlay('show', {
                        text : "处理中..."
                    });
                    $.ajax({
                        url: BASE_URL + 'ajax/system/backup/restore',
                        type: 'POST',
                        data: {'path':path+name},
                        success: function(result) {
                            if (result.success == 0)
                            {
                                $.gritter.add({
                                    title: '错误',
                                    text: '还原失败了!',
                                    class_name: 'gritter-success'
                                });
                                
                                $('.main-content').LoadingOverlay('hide');
                                return;
                            }
                            listTable.ajax.reload();
                            $.gritter.add({
                                    title: '成功',
                                    text: '还原成功!',
                                    class_name: 'gritter-success'
                                });
                            $('.main-content').LoadingOverlay('hide');
                        },
                        error: function(error) {
                            $.gritter.add({
                                title: '错误',
                                text: '还原途中发生了错误!',
                                class_name: 'gritter-success'
                            });
                            $('.main-content').LoadingOverlay('hide');
                        }
                    });
                }
            });
        }

        function deleteItem(e) {
            alertAudio();
            bootbox.confirm("Are you sure you want to delete?", function (result) {
                if (result) {
                    var id = $(e).closest("tr").attr('data-ref');
                    $.ajax({
                        url: BASE_URL + 'ajax/system/backup/delete',
                        type: 'POST',
                        data: {'id':id},
                        success: function(result) {
                            //location.reload();
                            $(e).closest("tr").remove();
                        },
                        error: function(error) {
                        }
                    });
                }
            });
        }

        function alertAudio() {
            document.getElementById('warning-audio').play();
        }

    </script>

@endsection
