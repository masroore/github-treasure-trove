@extends('layouts.app')
@section('content')
<div class="card card-custom">
  <div class="card-header flex-wrap border-0 pt-6 pb-0">
    <div class="card-title row col-md-10 col-12">
      <h3 class="card-label col-12" style="margin:0px; padding:0px;margin-bottom:5px;">Data AWB
        <span class="d-block text-muted pt-2 font-size-sm">Data AWB yang tampil adalah data 2 bulan terakhir, untuk lebih lengkap dapat melihat data di report AWB</span>
        @if (((int) Carbon\Carbon::now()->addHours(7)->format('H') >= 16  && (int)Auth::user()->level == 2)  )    
          <span class="d-block text-muted pt-2 font-size-sm" style="color:red !important;background-color:rgb(255, 255, 137);padding:5px;">Batas maksimal order jam 16.00</span>
        @endif
      </h3>

      <select id='status_complete' class="form-control col-6 col-md-3 select2" onChange="onChangeFilter()">
        <option value='-'>Sembunyikan complete</option>
        <option value="complete">Tampilkan complete</option> 
      </select> 

      <input id="tanggal_filter" type="text" class="form-control col-6 col-md-2  datepicker" value="-" onChange="onChangeFilter()">
      
      <select id='customer' class="select2  col-6 col-md-3  " onChange="onChangeFilter()">
        <option value='-'>Tampilkan Semua Pengirim</option>
        @foreach($master_customer as $c)
          <option value="{{ $c->id }}">{{ $c->nama }}</option>
        @endforeach
      </select> 
      
      <select name="kota" id='kota' class="select2 form-control col-6 col-md-3" onChange="onChangeFilter()">
        <option value='-'>Semua Tujuan</option>
        @foreach($kota as $k)
          <option value="{{ $k->id }}">{{ $k->nama }}</option>
        @endforeach
      </select> 
    </div>
    <div class="card-toolbar">  
        
      <div onclick="datatable.ajax.reload();" class="btn btn-default  text-center">
      <i class="fa fa-refresh text-center"></i></div>
      &nbsp;
      @if (((int) Carbon\Carbon::now()->addHours(7)->format('H') < 16  && (int)Auth::user()->level == 2) || (int)Auth::user()->level == 1)    
        <a href="{{ url('awb/edit/0/0') }}" class="btn btn-primary font-weight-bolder">
        <i class="la la-plus"></i>Buat AWB Baru </a>
        &nbsp;
      @endif
      
    </div>
    
  </div>
  <div class="card-body">
      <div class="table-responsive">
        <table id="datatables" class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
              <th></th>
              <th>No AWB</th>
              <th>Pengirim</th>
              <th>Kota Asal</th>
              <th>Kota Tujuan</th>
              <th width="15%">Alamat Tujuan</th>
              <th width="10%">Tanggal</th>
              <th width="7%">Agen Tujuan</th>
              <th width="7%">Qty Detail</th>
              <th>Status</th>
              <th>Qty</th>
              @if ((int)Auth::user()->level == 1)                  
                <th>Ubah status</th>
              @endif
              <th>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg bd-example-modal-lg_" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xs">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Rubah Status Manifest</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row" > 
        <div class="col-12 bg-light" style="padding-bottom:10px;" id="formawb"  > 
          <div class="form-group">
            <table class="table table-striped table-hover table-bordered">
              <tr>
                <td>Kode : </td>
                <td>Tanggal :</td> 
                <td>Kota asal :</td> 
                <td>Kota Tujuan :</td> 
              </tr>
              
              <tr>
                <td id='kodeawb_'></td>
                <td id='tanggalawb_'></td> 
                <td id='Kotaasal_'></td> 
                <td id='kotatujuan_'></td> 
              </tr>
            </table>
            
            <input type="text" name="idawb_" id="idawb_" class="d-none"  > 
            <input type="text" name="kodeawb_" id="kodeawb_" class="d-none"  > 
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect2">Status</label>
            <select class="form-control" id="status" name="status">
              <option class='options_'                              value=''>                     pilih status</option> 
              <option class='options_' id='loaded'                  value='loaded'>               loaded</option> 
              <option class='options_' id='at-agen'                 value='at-agen'>              at-agen</option> 
              <option class='options_' id='delivery-by-courier'     value='delivery-by-courier'>  delivery-by-courier</option> 
              <option class='options_' id='complete'                value='complete'>             complete</option>  
            </select>
          </div>
          <div class="form-group" > 
            <button type="button" class="pull-left btn btn-secondary" data-dismiss="modal">Close</button> 
            <button type="submit" id='simpanbutton' class="btn btn-primary pull-right mr-2">SIMPAN</button>
          </div>
        </div>
      </div> 
    </div>
  </div>
</div>

@include('modalpenerima')

@include('pages.awb.ajax.modal_koli')
@include('pages.awb.ajax.modal_view')
@endsection
@section('script')
<script>
    
  $(document).on("click",".openstatus",function() {
      $('#Kotaasal_'          ).html($(this).attr('kodekotaasal'))
      $('#kotatujuan_'        ).html($(this).attr('kodekotatujuan'))
      $('#tanggalawb_'        ).html($(this).attr('tanggalawb'))
      $('#kodeawb_'           ).html($(this).attr('kodeawb'))

      $('#idawb_'        ).val($(this).attr('idawb')) 
      $('#kodeawb_'      ).val($(this).attr('kodeawb')) 

      // CEK, jika status adalah at manifest, booked, cancel, maka di set 0 (pilih status)
      $("#status"        ).val(
          (
            ($(this).attr('status') !='at-manifest' && $(this).attr('status') !='booked' && $(this).attr('status') !='cancel') 
            ? $(this).attr('status') 
            : ''
          )
        );

      // $('.options_').removeClass('d-none')
      // if($(this).attr('status') == 'delivering'){
      //   $('#checked').addClass('d-none')
      // }
      // else if($(this).attr('status') == 'arrived'){
      //   $('#checked'   ).addClass('d-none')
      //   $('#delivering').addClass('d-none')
      // }
    })
    // $('#status_complete').change(function(){
    //   console.log($('#status_complete').val())
    //   datatable.ajax.reload();
    // })
    function onChangeFilter(){
      
      datatable.ajax.reload();
    }
  var datatable = $('#datatables').DataTable({
	    processing    : true,
	    serverSide    : false,
	    paging        : true,      
        pageLength    : 100,
	    // ajax          : '{{ url('awb/datatables') }}',
      ajax:  {
            "url": '{{ url('awb/datatables') }}',
            data: function(d){
                d.status_complete = $('#status_complete').val();
                d.tanggal         = $('#tanggal_filter').val();
                d.customer        = $('#customer').val();
                d.kota            = $('#kota').val();
            }
        },
      "columnDefs": [{
                "targets": '_all',
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).css('paddingLeft', '2px')
                    $(td).css('paddingRight', '2px')
                }
            }],
	    columns: [
	    {data: 'id',                name:'id'},
	    {data: 'noawb',             name:'noawb'},
	    {data: 'nama_pengirim_link',name:'nama_pengirim_link'},
	    {data: 'kota_asal',         name:'kota_asal'},
	    {data: 'kota_tujuan',       name:'kota_tujuan'},
	    {data: 'alamat_tujuan',     name:'alamat_tujuan'},
	    {data: 'tanggal_awb',       name:'tanggal_awb'},
	    {data: 'agen_stat',         name:'agen_stat'},
	    {data: 'qty_stat',          name:'qty_stat'},
	    {data: 'status_tracking',   name:'status_tracking'},
	    {data: 'qty',               name:'qty'},
      
      @if ((int)Auth::user()->level == 1)                  
        {data: 'gantistatus', name:'gantistatus'},
      @endif
	    {data: 'aksi', name:'aksi'},
	],
	 "order": [[ 0, "desc" ]],
   "createdRow": function( row, data, dataIndex){
                if( data.qty < 0){
                    $(row).addClass('redsoftbg');
                }
            }
   });
   datatable.column(0).visible(false); 

   
   $('#simpanbutton').click(function(){
    if($(`#status`).val() == ''){
      toastr.warning("Pilih Status terlebih dahulu !") 
    }else{

      Swal.fire({   
          title               : "Anda Yakin?",   
          text                : "Merubah status AWB -> "+$('#kodeawb_').val()+", menjadi ("+$('#status').val()+") status yang sudah dirubah, tidak bisa dikembalikan lagi",   
          icon                : "warning",   
          showCancelButton    : true,   
          confirmButtonColor  : "#e6b034",   
          confirmButtonText   : "Ya, Rubah status ke - " +$('#status').val()                  
        }).then((result) => {
          console.log(result)
        if (result.value) { 
          scan_update_status($('#kodeawb_').val(),'all'); 
        } else{
          $(btnsave).prop('disabled', false);

        }
      });
    }
  })
   function scan_update_status(kode_awb_or_manifest, qty){
        $.ajax({
            method  :'POST',
            url     :'{{ url('awb/updateawb') }}',
            data    :{
                kode                : kode_awb_or_manifest,
                qty                 : qty,
                status_nonencrypt   : $(`#status`).val(),
                '_token'            : "{{ csrf_token() }}" 
            },
            success:function(data){
              datatable.ajax.reload();
                $('.bd-example-modal-lg').modal('toggle');
                $('#kode_awb').val('')
                if(data.statuserror)    {toastr.error( data.statuserror)}
                if(data.statuswarning)  { 
                    toastr.warning( data.statuswarning) 
                }
                if(data.statussuccess)  {
                    toastr.success( data.statussuccess) 
                } 
                if(data.openmodal == 'open'){
                    $('#modalpenerima').modal('show');
                    $('#kodeawb_penerima'   ).val(kode_awb_or_manifest)
                    $('#diterima_oleh'      ).val(data.awb.diterima_oleh)
                }       
            }
        }) 
    }  
    function updatepenerima(){
      if($('#diterima_oleh').val() == ''){
            alert('Penerima tidak boleh kosong!')
      }else{
        $.ajax({
            method  :'POST',
            url     :'{{ url('awb/updatediterima') }}',
            data    :{
                kode                 : $('#kodeawb_penerima').val(),
                diterima_oleh        : $('#diterima_oleh').val(),
                keterangan_kendala   : $('#keterangan_kendala').val(),
                '_token'             : "{{ csrf_token() }}" 
            },
            success:function(data){ 
                datatable.ajax.reload();
                if(data.statussuccess)  {
                    toastr.success( data.statussuccess) 
                    $('#modalpenerima').modal('hide');
                    $('#diterima_oleh'      ).val('')
                    
                    setTimeout(function(){ 
                      if($('#reload_penerima').val('reload')){
                          location.reload();
                      }
                    }, 800);
                    
                }    
            }
        }) 
      }
    }
   function deleteAwb(id,noawb)
    {
         Swal.fire({   
                      title: "Anda Yakin?",   
                      text: "Data AWB Nomor "+noawb+" akan terhapus",   
                      icon: "warning",   
                      showCancelButton: true,   
                      confirmButtonColor: "#e6b034",   
                      confirmButtonText: "Ya, Hapus AWB" 
                       
                  }).then((result) => {
            if (result.value) {
                $.ajax({
                            method:'POST',
                            url:'{{ url("awb/delete") }}',
                            data:{
                              id:id,
                              '_token': $('input[name=_token]').val()
                            },
                            success:function(data){
                              if(data.status=='success'){
                                Swal.fire({title:"Terhapus!", text:"Awb "+data.awb.noawb+" berhasil terhapus dari sistem", icon:"success"}
                                ).then((result) => {
                                    location.reload()
                                })
                              }else{
                                Swal.fire({title:"GAGAL!", text: data.message, icon:"error"}
                                ).then((result) => {
                                    location.reload()
                                })
                              }
                            }
                          }) 
            } 
         });
    }
@if($hide_qty == "true")
  datatable.column(6).visible(false);  
  datatable.column(8).visible(false);
@endif
    function updateManifest(id,noawb)
    {
         Swal.fire({   
                      title: "Anda Yakin?",   
                      text: "Data AWB Nomor "+noawb+" akan diupdate menjadi Manifested",   
                      icon: "warning",   
                      showCancelButton: true,   
                      confirmButtonColor: "#e6b034",   
                      confirmButtonText: "Ya, Manifested AWB" 
                       
                  }).then((result) => {
            if (result.value) {
                $.ajax({
                            method:'POST',
                            url:'{{ url("awb/manifest") }}',
                            data:{
                              id:id,
                              '_token': $('input[name=_token]').val()
                            },
                            success:function(data){
                                Swal.fire({title:"Updated!", text:"Awb Nomor "+data.awb.noawb+" sudah berada di manifest", icon:"success"}
                                ).then((result) => {
                                    location.reload()
                                })
                            }
                          }) 
            } 
         });
    }

    function modalKoli(id){
      $.ajax({
              method:'POST',
              url:'{{ url("awb/koli") }}',
              data:{
                id:id,
                '_token': $('input[name=_token]').val()
              },
              success:function(data){
                console.log(data.awb.is_agen)
                if(data.awb.is_agen == 1){
                  $('#table-not-agen').hide();
                  $('#table-agen').show();
                }
                else{
                  $('#table-not-agen').show();
                  $('#table-agen').hide();
                }
                $('#kecil').html(data.awb.qty_kecil)
                $('#sedang').html(data.awb.qty_sedang)
                $('#besar').html(data.awb.qty_besar)
                $('#besarbanget').html(data.awb.qty_besarbanget)
                $('#doc').html(data.awb.qty_doc)
                $('#kg').html(data.awb.qty_kg)
                $('#qty').html(data.awb.qty)
                $('.total_harga').html(data.awb.total_harga)
                $('.harga_charge').html(data.awb.harga_charge).number(true)
                $('.total_oa').html(data.awb.idr_oa).number(true)
                $('.harga_gsa').html(data.awb.harga_gsa).number(true)
                $('#noawb_koli').html(data.awb.noawb).number(true)
                $('.total_harga').number(true)
                $('.total_oa').number(true)
                $('.harga_gsa').number(true)
                if(data.awb.qty < 0){
                  $('.minus_harga').html('-')
                }
                else{
                  $('.minus_harga').html('')
                }
              } 
            })
    }
    function detail(id){
      $.ajax({
              method:'POST',
              url:'{{ url("awb/show") }}',
              data:{
                id:id,
                '_token': $('input[name=_token]').val()
              },
              success:function(data){
                console.log(data)
                $('#res_show_awb').html(data.view)
              } 
            })
    }
</script>

@if(Session::get('message') == "created")
    <script type="text/javascript">
        toastr.success("AWB Baru Berhasil ditambahkan!");
    </script>
@endif
@if(Session::get('message') == "updated")
    <script type="text/javascript">
        toastr.success("Data AWB Berhasil diubah!");
    </script>
@endif
@if(Session::get('failed_customer') !== null)
    <script type="text/javascript">
        toastr.error("Data AWB Gagal diubah! Customer {{ Session::get('failed_customer') }} Belum ada di data agen");
    </script>
@endif
@if(Session::get('outoftime') !== null)
    <script type="text/javascript">
        toastr.error("Data AWB Gagal dibuat! <BR>Sudah melebihi jam input hari ini");
    </script>
@endif
@endsection