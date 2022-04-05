@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header border-0" style="padding-bottom:0px; padding-top:10px;">
          <div class="card-title font-weight-bolder">
            <div class="card-label">Report Manifest</div>
          </div>
        </div>
        <div class="card-body">
          <form class="form" id="form">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-lg-3">
                <label class="mt-5 font-weight-bold">Kota Asal:</label><br>
                <select class="form-control select2" name="id_kota_asal" id="id_kota_asal">
                  <option value="-">--Tampil Semua--</option>
                  @foreach($kota as $k)
                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-lg-6">
                <label class="mt-5 font-weight-bold">Tanggal Awal - Akhir:</label><br>
                <input type="text" id="txtPeriod" class="form-control" name="tanggal" id="tanggal" required>
              </div>
              <div class="col-lg-3">
                <label class="mt-5 font-weight-bold">Status Manifest</label><br>
                <select class="form-control select2" name="status" id="status">
                  <option value="-">--Tampil Semua--</option>
                  <option value="checked">checked</option>
                  <option value="delivering">delivering</option>
                  <option value="arrived">arrived</option>
                </select>
              </div>
              <div class="col-lg-3">
                <label class="mt-5 font-weight-bold">Kota Tujuan</label><br>
                <select class="form-control select2" name="id_kota_tujuan" id="id_kota_tujuan">
                  <option value="-">--Tampil Semua--</option>
                  @foreach($kota as $a)
                    <option value="{{ $a->id }}">{{ $a->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-lg-3">
                <label class="mt-5 font-weight-bold">Kode Manifest </label><br>
                <input type="text" name="kode_manifest" id="kode_manifest" class="form-control">
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-3">
                <button type="button" class="btn btn-lg btn-outline-primary btn-success" id="btnproses"><i class="flaticon-search"></i> Cari</button>
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
                url : "{{ url('report/manifest-grid') }}",
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
            height:570,
            paging: {
                pageSize: 1000,
            },
            pager: {
                visible: true,
                showNavigationButtons: true,
                showInfo: true,
                showPageSizeSelector: true,
                allowedPageSizes: [100, 250, 500, 1000]
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
                fileName: "Laporan Manifest",
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
                    caption: "Lihat Detail",
                    dataField: "id",
                    dataType: "string",
                    width:200,
                    cellTemplate: function (container, options) {
                    console.log(options);
                        $(container).html(`<a href="https://globalserviceasia.com/public/printout/manifest/`+options.data.id+`" target="_blank">`+options.data.kode+`</a>`)
                    },
                },
                {
                    caption: "Kode Manifest",
                    dataField: "kode",
                    dataType: "string",
                    width:160,
                },
                {
                    caption: "Status",
                    dataField: "status",
                    dataType: "string",
                    width:160,
                },
                {
                    caption: "Kota Asal",
                    dataField: "kota_asal",
                    dataType: "string",
                    width:180,
                },
                {
                    caption: "Kota Tujuan",
                    dataField: "kota_tujuan",
                    dataType: "string",
                    width:180,
                },
                {
                    caption: "Tanggal Manifest",
                    dataField: "created_at",
                    dataType: "datetime",
                    format:"shortDateShortTime",
                    width:170,
                },
                {
                    caption: "Dibuat Oleh",
                    dataField: "dibuat_oleh_user",
                    dataType: "string",
                    width:120,
                },
                {
                    caption: "Supir",
                    dataField: "supir",
                    dataType: "string",
                    width:120,
                },
                {
                    caption: "Keterangan",
                    dataField: "keterangan",
                    dataType: "string",
                    width:170,
                },
                {
                    caption: "Koli",
                    dataField: "jumlah_koli",
                    dataType: "number",
                    width:70,
                },
                {
                    caption: "Doc",
                    dataField: "jumlah_doc",
                    dataType: "number",
                    width:70,
                },
                {
                    caption: "Kg",
                    dataField: "jumlah_kg",
                    dataType: "number",
                    width:70,
                },
                {
                    caption: "Tanggal Diterima",
                    dataField: "tanggal_diterima",
                    dataType: "datetime",
                    format:"shortDateShortTime",
                    width:170,
                },
                {
                    caption: "Discan Oleh (diterima)",
                    dataField: "discan_diterima_oleh_nama",
                    dataType: "string",
                    width:200,
                },
                
            ],
        }).dxDataGrid("instance");
    return dataGrid;
  }
</script>
@endsection