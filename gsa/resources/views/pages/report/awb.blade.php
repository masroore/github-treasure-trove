@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header border-0" style="padding-bottom:0px; padding-top:10px;">
          <div class="card-title font-weight-bolder">
            <div class="card-label">Report AWB</div>
          </div>
        </div>
        <div class="card-body">
          <form class="form" id="form">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-lg-3">
                <label class="font-weight-bold mt-5">Customer:</label><br>
                <select class="form-control select2" name="id_customer" id="id_customer">
                  @if((int) Auth::user()->level == 1 ||(int) Auth::user()->level == 3)
                  <option value="-">--Tampil Semua--</option>
                  @foreach($customer as $c)
                    <option value="{{ $c->id }}">{{ $c->nama }}</option>
                  @endforeach
                  @elseif((int) Auth::user()->level == 2)
                    <option value="{{ $customer->id }}">{{ $customer->nama }} </option>
                  @endif
                </select>
              </div>
              <div class="col-lg-6">
                <label class="font-weight-bold mt-5">Tanggal Awal - Akhir:</label><br>
                <input type="text" id="txtPeriod" class="form-control" name="tanggal" id="tanggal" required>
              </div>
              <div class="col-lg-3">
                <label class="font-weight-bold mt-5">Status Tracking</label><br>
                <select class="form-control select2" name="status_tracking" id="status_tracking">
                  <option value="-">--Tampil Semua--</option>
                  <option value="booked">booked</option>
                  <option value="at-manifest">at-manifest</option>
                  <option value="loaded">loaded</option>
                  <option value="at-agen">at-agen</option>
                  <option value="delivery-by-courier">delivery-by-courier</option>
                  <option value="complete">complete</option>
                  <option value="cancel">cancel</option>
                </select>
              </div>

              <div class="col-lg-3
                
                @if((int) Auth::user()->level == 3 || (int) Auth::user()->level == 2)
                d-none
                @endif
                ">
                  <label class="font-weight-bold mt-5">Agen Asal</label><br>
                  <select class="form-control select2" name="id_agen_asal" id="id_agen_asal">
                    <option value="-">--Tampil Semua--</option>
                    @foreach($agen as $a)
                      <option value="{{ $a->id }}">{{ $a->nama }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-lg-3
                
                @if((int) Auth::user()->level == 3 || (int) Auth::user()->level == 2)
                d-none
                @endif
                ">
                  <label class="font-weight-bold mt-5">Agen Tujuan</label><br>
                  <select class="form-control select2" name="id_agen_penerima" id="id_agen_penerima">
                    <option value="-">--Tampil Semua--</option>
                    @foreach($agen as $a)
                      <option value="{{ $a->id }}">{{ $a->nama }}</option>
                    @endforeach
                  </select>
                </div>
                
              <div class="col-lg-3">
                <label class="font-weight-bold mt-5">Kode Awb </label><br>
                <input type="text" name="noawb" id="noawb" class="form-control">
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
                url : "{{ url('report/awb-grid') }}",
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
                fileName: "Laporan AWB",
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
                  width:110,
                  cellTemplate: function (container, options) {
                    console.log(options);
                        $(container).html(`<a href="https://globalserviceasia.com/public/t/`+options.data.noawb+`/t/1" target="_blank">`+options.data.noawb+`</a>`)
                    },
                },
                {
                    caption: "Noawb",
                    dataField: "noawb",
                    dataType: "string",
                    width:110,
                },
                {
                    caption: "Faktur",
                    dataField: "faktur_string",
                    dataType: "string", 
                    width:90,
                },
                {
                    caption: "Pengirim",
                    dataField: "pengirim",
                    dataType: "string",
                    width:200,
                },
                {
                    caption: "Tanggal",
                    dataField: "created_at",
                    dataType: "date",
                    format:"shortDateShortTime",
                    width:170,
                },
                {
                    caption: "Kota Asal",
                    dataField: "kota_asal",
                    dataType: "string",
                },
                {
                    caption: "Kota Transit",
                    dataField: "kota_transit",
                    dataType: "string", 
                },
                {
                    caption: "Kota Tujuan",
                    dataField: "kota_tujuan",
                    dataType: "string", 
                },
                
                {
                    caption: "Agen Asal",
                    dataField: "agen_asal",
                    dataType: "string", 
                },
                {
                    caption: "Agen Tujuan",
                    dataField: "agen_tujuan",
                    dataType: "string", 
                },
                {
                    caption: "Nama Penerima",
                    dataField: "nama_penerima",
                    dataType: "string", 
                },
                {
                    caption: "Label Alamat",
                    dataField: "labelalamat",
                    dataType: "string", 
                },
                {
                    caption: "Kodepos Penerima",
                    dataField: "kodepos_penerima",
                    dataType: "string", 
                },
                {
                    caption: "Alamat Penerima",
                    dataField: "alamat_tujuan",
                    dataType: "string",
                    width:170,
                },
                {
                    caption: "Kecamatan",
                    dataField: "kecamatan_tujuan",
                    dataType: "string", 
                },
                {
                    caption: "No Hp Penerima",
                    dataField: "notelp_penerima",
                    dataType: "string", 
                },
                {
                    caption: "Tanggal Diterima",
                    dataField: "tanggal_diterima",
                    dataType: "datetime",
                    format:"shortDateShortTime",
                    width:170,
                },
                {
                    caption: "Diterima Oleh",
                    dataField: "diterima_oleh",
                    dataType: "string",
                    width:170,
                },
                {
                    caption: "Status",
                    dataField: "status_tracking",
                    dataType: "string",
                    width:170,
                },
                // {
                //     caption: "OA/tidak",
                //     dataField: "oa_string",  
                //     dataType: "string",
                //     width:100,
                // },
                {
                    caption: "QTY",
                    dataField: "qty",
                    dataType: "number",
                    width:90,
                },
                {
                    caption: "koli kecil",
                    dataField: "qty_kecil",
                    dataType: "number",
                    width:90,
                },
                {
                    caption: "koli sedang",
                    dataField: "qty_sedang",
                    dataType: "number",
                    width:90,
                },
                {
                    caption: "koli besar",
                    dataField: "qty_besar",
                    dataType: "number",
                    width:90,
                },
                {
                    caption: "koli bb",
                    dataField: "qty_besarbanget",
                    dataType: "number",
                    width:90,
                },
                {
                    caption: "koli kg",
                    dataField: "qty_kg",
                    dataType: "number",
                    width:90,
                },
                {
                    caption: "koli doc",
                    dataField: "qty_doc",
                    dataType: "number",
                    width:90,
                },
                @if((int) Auth::user()->level == 1 )
                {
                    caption: "OA desc",
                    dataField: "oa_desc",
                    dataType: "string",
                    width:180,
                },
                {
                    caption: "Total OA",
                    dataField: "idr_oa",
                    dataType: "number",
                    format:"#,##0", 
                    width:180,
                },
                {
                    caption: "Total Harga",
                    dataField: "total_harga",
                    dataType: "number",
                    format:"#,##0",
                    width:150,
                },
                {
                    caption: "Harga Charge",
                    dataField: "harga_charge",
                    dataType: "number",
                    format:"#,##0",
                    width:150,
                },
                {
                    caption: "Harga GSA",
                    dataField: "harga_gsa",
                    dataType: "number",
                    format:"#,##0",
                    width:150,
                },
                @endif
                {
                    caption: "Kode Manifest",
                    dataField: "kode_manifest",
                    dataType: "string",
                    width:160,
                },

                @if((int) Auth::user()->level == 1 )
                  {
                      caption: "Kode Invoice",
                      dataField: "kode_invoice",
                      dataType: "string",
                      width:160,
                  },
                @endif
                @if((int) Auth::user()->level == 1 ||(int) Auth::user()->level == 2)
                {
                    caption: "Status Pembayaran",
                    dataField: "status_pembayaran", 
                    dataType: "string",
                    width:150, 
                },
                @endif
                
            ],
        }).dxDataGrid("instance");
    return dataGrid;
  }
</script>
@endsection