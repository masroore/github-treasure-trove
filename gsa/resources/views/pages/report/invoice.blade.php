@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header border-0" style="padding-bottom:0px; padding-top:10px;">
          <div class="card-title font-weight-bolder">
            <div class="card-label">Report Invoice</div>
          </div>
        </div>
        <div class="card-body">
          <form class="form" id="form">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-lg-3">
                <label>Customer:</label>
                <select class="form-control select2" name="id_customer" id="id_customer">
                  @if((int) Auth::user()->level == 1)
                  <option value="-">--Tampil Semua--</option>
                  @foreach($customer as $k)
                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                  @endforeach
                  @else
                    <option value="{{ $customer->id }}">{{ $customer->nama }} </option>
                  @endif
                </select>
              </div>
              <div class="col-lg-6">
                <label>Tanggal Awal - Akhir:</label>
                <input type="text" id="txtPeriod" class="form-control" name="tanggal" id="tanggal" required>
              </div>
              <div class="col-lg-3">
                <label>Status Pembayaran</label>
                <select class="form-control select2" name="status" id="status">
                  <option value="-">--Tampil Semua--</option>
                  <option value="paid">paid</option>
                  <option value="unpaid">unpaid</option>
                </select>
              </div>
              <div class="col-lg-3">
                <label>Metode Pembayaran</label>
                <select class="form-control select2" name="metodepembayaran" id="metodepembayaran">
                  <option value="-">--Tampil Semua--</option>
                  <option value="transfer">transfer</option>
                  <option value="tunai">tunai</option>
                </select>
              </div>
              <div class="col-lg-3">
                <label>Kode Invoice </label>
                <input type="text" name="kode_invoice" id="kode_invoice" class="form-control">
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-3">
                <button type="button" class="btn btn-lg btn-outline-primary" id="btnproses"><i class="flaticon-search"></i> Cari</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div  class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div id="awb"></div>
          <div class="loadpanel"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
  
  $(document).on({
      ajaxStart: function() { loadPanel.show(); },
      ajaxStop: function() { loadPanel.hide(); }    
  });
  $(document).ready(function() {
        //Initialize Select2 Elements

        $('#txtPeriod').daterangepicker({
            locale: {
                format: "DD/MM/YYYY",
            }
        });

        $("#txtPeriod").val('')
        show_grid(null)
    });

    $("#btnproses").on('click',function(){
        if($("#txtPeriod").val() != ''){
            $.ajax({
                type : "POST",
                url : "{{ url('report/invoice-grid') }}",
                dataType : "json",
                data :  $("#form").serialize(),
                success : function(response) {
                    console.log(response)
                    show_grid(response.data)
                },
                error : function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown)
                }
            });
        }
    })
  function show_grid(data){
    var dataGrid = $("#awb").dxDataGrid({
            dataSource: data,
            height:470,
            paging: {
                pageSize: 10,
            },
            pager: {
                visible: true,
                showNavigationButtons: true,
                showInfo: true,
                showPageSizeSelector: true,
                allowedPageSizes: [10, 25, 50, 100]
            },
            filterRow: {
                visible: true,
                applyFilter: "auto"
            },
            headerFilter: {
                visible: true
            },
            hoverStateEnabled: true,
            groupPanel: {
                visible: true
            },
            grouping: {
                autoExpandAll: false
            },
            scrolling: {
                // mode: "virtual",
                rowRenderingMode: 'virtual'
            },
            columnAutoWidth: true,
            export: {
                enabled: false,
                fileName: "Laporan Invoice",
                allowExportSelectedData: true
            },
            onToolbarPreparing: function (e) {
                e.toolbarOptions.items.push({
                    widget: 'dxButton',
                    showText: 'always',
                    options: {
                        icon: 'export',
                        // text: 'Export to Excel',
                        onClick: function () {
                            e.component.exportToExcel(false);
                        }
                    },
                    location: 'after'
                });
            },
            allowColumnReordering: true,
            allowColumnResizing: true,
            showBorders: true,
            wordWrapEnabled:true,
            columns: [
                // {
                //     caption: "No",
                //     dataType: "number",
                //     alignment: 'center',
                //     width: 70,
                //     cellTemplate: function(container, row) {
                //         $(container).html(row.rowIndex + 1);
                //     }
                // },
                {
                    caption: "Lihat detail",
                    dataField: "id",
                    dataType: "string",
                    width:200,
                    cellTemplate: function (container, options) {
                    console.log(options);
                        $(container).html(`<a href="https://globalserviceasia.com/public/printout/invoice/`+options.data.id+`" target="_blank">`+options.data.kode+`</a>`)
                    },
                },
                {
                    caption: "Kode Invoice",
                    dataField: "kode",
                    dataType: "string",
                    width:200,
                },
                {
                    caption: "Customer",
                    dataField: "customer",
                    dataType: "string",
                    width:200,
                },
                {
                    caption: "Tanggal Invoice",
                    dataField: "tanggal_invoice",
                    dataType: "datetime",
                    format:"shortDateShortTime",
                    width:170,
                },
                {
                    caption: "Dikerjakan Oleh",
                    dataField: "mengetahui_oleh_user",
                    dataType: "string",
                    width:175,
                },
                {
                    caption: "Status Pembayaran",
                    dataField: "status",
                    dataType: "string",
                    width:175,
                    
                },
                {
                    caption: "Keterangan",
                    dataField: "keterangan",
                    dataType: "string",
                    width:170,
                },
                {
                    caption: "Koli",
                    dataField: "total_koli",
                    dataType: "number",
                    width:170,
                },
                {
                    caption: "Doc",
                    dataField: "total_doc",
                    dataType: "number",
                    width:170,
                },
                {
                    caption: "Kg",
                    dataField: "total_kg",
                    dataType: "number",
                    width:170,
                },
                {
                    caption: "Total OA",
                    dataField: "total_oa",
                    dataType: "number",
                    width:170,
                },
                {
                    caption: "Total Harga",
                    dataField: "total_harga",
                    dataType: "number",
                    format:"#,##0",
                    width:170,
                },
                {
                    caption: "Metode Pembayaran",
                    dataField: "metodepembayaran",
                    dataType: "string",
                    width:170,
                },
                
            ],
        }).dxDataGrid("instance");
    return dataGrid;
  }
</script>
@endsection