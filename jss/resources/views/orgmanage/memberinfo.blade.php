@extends('layout.header')

@section('styles')
    <link href="{{ cAsset('css/pretty.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/dycombo.css') }}" rel="stylesheet">
    
    <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/-->
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="page-header">
                <div class="col-sm-3">
                    <h4><b>{{trans("orgManage.title.MemberInfo")}}</b></h4>
                </div>
            </div>
            <div class="col-md-12" style="margin-top:4px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-7">
                            <strong class="f-right" style="font-size: 20px; padding-top: 6px;">吉速船舶有限公司</strong>
                        </div>
                        <div class="col-md-5" style="padding:unset!important">
                            <div class="btn-group f-right">
                                <a href="{{ url('org/memberadd') }}" class="btn btn-sm btn-primary btn-add" style="width: 80px">
                                    <i class="icon-plus"></i>{{ trans('common.label.add') }}
                                </a>
                                <a onclick="javascript:fnExcelReport();" class="btn btn-warning btn-sm excel-btn">
                                    <i class="icon-table"></i>{{ trans('common.label.excel') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top:4px;">
                    <div id="item-manage-dialog" class="hide"></div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="head-fix-div common-list" id="crew-table" style="">
                            <table id="table-shipmember-list" style="table-layout:fixed;">
                                <thead class="">
                                    <th class="text-center style-normal-header" style="width: 3%; height: 30px;"><span>No</span></th>
                                    <th class="text-center style-normal-header" style="width: 10%;"><span>姓名</span></th>
                                    <th class="text-center style-normal-header" style="width: 10%;"><span>ID</span></th>
                                    <th class="text-center style-normal-header" style="width: 10%;"><span>职位</span></th>
                                    <th class="text-center style-normal-header" style="width: 15%;"><span>手机号码</span></th>
                                    <th class="text-center style-normal-header" style="width: 9%;"><span>到职日期</span></th>
                                    <th class="text-center style-normal-header" style="width: 9%;"><span>退职日期</span></th>
                                    <th class="text-center style-normal-header" style="width: 30%;"><span>备注</span></th>
                                    <th class="text-center" style=""></th>
                                </thead>
                                <tbody class="" id="list-body">
                                @if (isset($list) && count($list) > 0)
                                <?php $index = 1;?>
                                @foreach ($list as $userInfo)
                                    <tr>
                                        <td class="center">{{$index++}}</td>
                                        <td class="center">{{$userInfo['realname']}}</td>
                                        <td class="center">{{$userInfo['account']}}</td>
                                        <td class="center"><span class="badge badge-{{ g_enum('StaffLevelData')[$userInfo['pos']][1] }}">{{ g_enum('StaffLevelData')[$userInfo['pos']][0] }}</span></td>
                                        <td class="center">{{$userInfo['phone']}}</td>
                                        <td class="center">{{$userInfo['entryDate']}}</td>
                                        <td class="center">{{$userInfo['releaseDate']}}</td>
                                        <td class="center">{{$userInfo['remark']}}</td>
                                        <td class="action-buttons center">
                                            <a class="blue" href="{{ 'memberadd' }}?uid={{$userInfo->id}}">
                                                <i class="icon-edit bigger-110"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="9">{{ trans('common.message.no_data') }}</td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.main-content -->

    <script>
        function fnExcelReport() {
            var tab_text = "";
            tab_text +="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            var real_tab = document.getElementById('table-shipmember-list');
            var tab = real_tab.cloneNode(true);
            tab_text=tab_text+"<tr><td colspan='8' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>吉速船舶有限公司</td></tr>";

            for(var j = 0; j < tab.rows.length ; j++)
            {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                        tab.rows[j].childNodes[i].style.width = '100px';
                    }
                }
                tab.rows[j].childNodes[16].remove();
                tab.rows[j].childNodes[16].remove();
                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";
            tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
            tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
            tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

            var filename = '职员信息';
            exportExcel(tab_text, filename, filename);
            
            return 0;
        }
    </script>
@stop
