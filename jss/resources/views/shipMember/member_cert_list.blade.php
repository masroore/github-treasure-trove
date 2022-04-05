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
                    <h4><b>{{trans("shipMember.title.Member Cert")}}</b>
                    </h4>
                </div>
            </div>
            <div class="row col-md-12" style="margin-bottom: 4px;">
                <div class="col-md-6">
                    <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名:</label>
                    <select class="custom-select d-inline-block" id="select-ship" style="max-width: 100px;">
                        @foreach($shipList as $ship)
                            <option value="{{ $ship['IMO_No'] }}" data-name="{{$ship['shipName_En']}}">{{ $ship['NickName'] == '' ? $ship['shipName_En'] : $ship['NickName'] }}</option>
                        @endforeach
                    </select>
                    <strong class="f-right" style="font-size: 16px; padding-top: 6px;align-content: flex-end;display: flex;"><span id="ship_name" class="list-header"></span> CREW CERTIFICATES LIST</strong>
                </div>
                <div class="col-md-6">
                    <div class="f-right">
                        <label class="font-bold">提前:</label>
                        <!--input type="number" min="0" step="1" class="text-center" style="width: 60px;" name="expire_date" id="expire-date" value="0"-->
                        <select id="expire-date" style="width: 60px;">
                            <option value="0" selected>All</option>
                            <option value="60">60</option>
                            <option value="90">90</option>
                            <option value="120">120</option>
                        </select>
                        <label>天</label>
                        <!--button class="btn btn-report-search btn-sm search-btn" onclick="" id="btn-search"><i class="icon-search"></i>搜索</button-->
                        <!--a class="btn btn-sm btn-danger refresh-btn-over" type="button" onclick="javascript:refresh()">
                            <img src="{{ cAsset('assets/images/refresh.png') }}" class="report-label-img">恢复
                        </a-->
                        <button class="btn btn-warning btn-sm excel-btn" onclick=""><i class="icon-table"></i>{{ trans('common.label.excel') }}</button>
                    </div>
                </div>
            </div>
            <div class="row col-lg-12" style="margin-top:8px;">
                <div id="item-manage-dialog" class="hide"></div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="">
                    <table id="table-shipmember-list" class="not-striped">
                        <thead>
                        <tr class="black br-hblue" style="height:45px;">
                            <th class="text-center style-header" style="width: 3%;"><span>No</span></th>
                            <th class="text-center style-header" style="width: 8%;"><span>Name</span></th>
                            <th class="text-center style-header" style="width: 7%;"><span>Rank</span></th>
                            <th class="text-center style-header" style="width: 2%;"><span>DOC No</span></th>
                            <th class="text-center style-header" style="width: 15%;"><span>Type of certificates</span></th>
                            <th class="text-center style-header" style="width: 7%;"><span>Certificates No.</span></th>
                            <th class="text-center style-header" style="width: 6%;"><span>Issued Date</span></th>
                            <th class="text-center style-header" style="width: 6%;"><span>Expire Date</span></th>
                            <th class="text-center style-header" style="width: 6%;"><span>Issued by</span></th>
                        </tr>
                        </thead>
                        <tbody class="" id="list-body">
                        </tbody>
                    </table>
                </div>
                <div id="test">
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('/assets/js/x-editable/bootstrap-editable.min.js') }}"></script>
    <script src="{{ asset('/assets/js/x-editable/ace-editable.min.js') }}"></script>
    <script src="{{ cAsset('assets/js/jsquery.dataTables.js') }}"></script>
    <script src="{{ asset('/assets/js/dataTables.rowsGroup.js') }}"></script>
    <?php
	echo '<script>';
	echo 'var CurrencyLabel = ' . json_encode(g_enum('CurrencyLabel')) . ';';
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

        var token = '{!! csrf_token() !!}';
        var shipName = '';
        $(function () {
            $.fn.editable.defaults.mode = 'inline';
            $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue icon-2x icon-spinner icon-spin'></i></div>";
            $.fn.editableform.buttons = '';

            shipName = $('#select-ship option:selected').attr('data-name');
            $('#ship_name').html('"' + shipName + '"');
            doSearch();
        });
            
        function setDatePicker() {
            $('.date-picker').datepicker({autoclose: true}).next().on(ace.click_event, function () {
                $(this).prev().focus();
            });
        }

        var listTable = null;
        function initTable() {
            listTable = $('#table-shipmember-list').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/shipMember/cert/list',
                    type: 'POST',
                    data: {'type' : 'crew'},
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                order: [[2, 'asc']],
                columns: [
                    {data: 'no', className: "text-center"},
                    {data: 'name', className: "text-center"},
                    {data: 'rank', className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: '_no', className: "text-center"},
                    {data: '_issue', className: "text-center"},
                    {data: '_expire', className: "text-center"},
                    {data: '_by', className: "text-center"},
                ],
                rowsGroup: [0, 1, 2],
                createdRow: function (row, data, index) {
                    var pageInfo = listTable.page.info();

                    if ((data['no']%2) == 0)
                        $(row).attr('class', 'cost-item-even member-item');
                    else
                        $(row).attr('class', 'cost-item-odd member-item');
                        
                    var cert_index = data['index'];
                    $('td', row).eq(3).html('').append(data['count']);
                    $('td', row).eq(4).attr('class', 'text-center style-bold-italic');
                    if (cert_index == 0) {
                        $('td', row).eq(4).html('').append('Seamanbook');
                    }
                    else if (cert_index == 1) {
                        $('td', row).eq(4).html('').append('Passport');
                    }
                    else if (cert_index == 2 || cert_index == 3) {
                        if (data['_type'] != '' ) {
                            $('td', row).eq(4).html('').append(data['_type']);
                        }
                        else
                        {
                            if (cert_index == 2) $('td', row).eq(4).html('').append('COC: Certificate of Competency');
                            else if (cert_index == 3) $('td', row).eq(4).html('').append('COE: Certificate of Endorsement');
                        }
                    }
                    else if (cert_index == 4) {
                        $('td', row).eq(4).html('').append('GOC: GMDSS general operator');
                    }
                    else if (cert_index == 5) {
                        $('td', row).eq(4).html('').append('GOC Endorsement');
                    }
                    else if (cert_index < 15)
                    {
                        $('td', row).eq(4).html('').append(certList[cert_index-6].value);
                    }
                    else {
                        $('td', row).eq(4).html('').append(data['_name']);
                    }
                },
            });

            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }

        function doSearch() {
            if (shipName == "") return;
            if (listTable == null) initTable();
            $('#ship_name').html('"' + shipName + '"');
            listTable.column(2).search($("#select-ship" ).val(), false, false);
            listTable.column(3).search($("#expire-date").val(), false, false).draw();
        }

        $('#select-ship').on('change', function() {
            shipName = $(this).find(':selected').attr('data-name');
            $('#ship_name').html('"' + shipName + '"');
            doSearch();
        });

        $('#expire-date').on('change', function() {
            doSearch();
        });

        $('.excel-btn').on('click', function() {
           $('td[style*="display: none;"]').remove();
           fnExcelReport();
		});

        function fnExcelReport()
        {
            var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            var real_tab = document.getElementById('table-shipmember-list');
            var tab = real_tab.cloneNode(true);
            tab_text=tab_text+"<tr><td colspan='9' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + '"' + shipName + '"' + "CREW CERTIFICATES LIST</td></tr>";
            for(var j = 0 ; j < tab.rows.length ; j++) 
            {
                if (j == 0) {
                    console.log(tab.rows[j]);
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        if (i == 0) {
                        }
                        else if (i == 1) {
                            tab.rows[j].childNodes[i].style.width = '240px';
                        }
                        else if (i == 2) {
                        }
                        else if (i == 3) {
                        }
                        else if (i == 4) {
                            tab.rows[j].childNodes[i].style.width = '340px';
                        }
                        else if (i == 5) {
                            tab.rows[j].childNodes[i].style.width = '240px';
                        }
                        else if (i == 8) {
                            tab.rows[j].childNodes[i].style.width = '240px';
                        }
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                }
                else
                    tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }

            tab_text=tab_text+"</table>";
            //tab_text='<table border="2px" style="text-align:center;vertical-align:middle;"><tr><th class="text-center sorting_disabled" style="width: 78px;text-align:center;vertical-align:center;" rowspan="1" colspan="1"><span>No</span></th></tr><tr style="width: 78px;text-align:center;vertical-align:middle;"><td class="text-center sorting_disabled" rowspan="2" style="">你好</td></tr></table>';
            tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
            tab_text= tab_text.replaceAll(/<img[^>]*>/gi,""); // remove if u want images in your table
            tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

            //document.getElementById('test').innerHTML = tab_text;
            var filename = 'CREW CERTIFICATES LIST(' + shipName + ')';
            exportExcel(tab_text, filename, 'CREW CERTIFICATES LIST');
            return 0;
        }

        /*
        function refresh() {
            $('#expire-date').val('0');
            doSearch();
        }

        $('#btn-search').on('click', function() {
            doSearch();
        });
        */
        
    </script>

@endsection