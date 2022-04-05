@extends('layouts.app')
@section('content')
<div class="card card-custom">
  <div class="card-header flex-wrap border-0 pt-6 pb-0">
    <div class="card-title">
      <h3 class="card-label">Master manifest
      <span class="d-block text-muted pt-2 font-size-sm">Data manifest yang tersedia</span></h3>
    </div>
    <div class="card-toolbar">
      <div onclick="dt.ajax.reload();" class="btn btn-default  text-center">
      <i class="fa fa-refresh text-center"></i></div>
      &nbsp;
      @if ((int)Auth::user()->level ==1)          
        <a href="{{url('master/manifest/grouping') }}" class="btn btn-primary font-weight-bolder">
        <i class="la la-plus"></i>Tambah Data manifest</a>
      @endif
    </div>
  </div>
  <div class="card-body">
      <div class="table-responsive">
        <table id="datatables" class="table table-striped table-hover table-bordered">
          <thead>
            <tr> 
              <th>Kode</th>
              <th>Asal</th>
              <th>Tujuan</th>
              <th>AgenTujuan</th>
              <th>Tanggal</th>
              <th>Dibuat Oleh</th>
              <th>Koli</th>
              <th>Kg</th>
              <th>Doc</th>
              <th>Supir</th>
              <th width='5%'>Status</th> 
              <th width='5%'>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xs">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Rubah Status Manifest</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row" > 
        <form class="col-12 bg-light" style="padding-bottom:10px;" id="formmanifest_" >
          {{ csrf_field() }}
          <div class="form-group">
            <table class="table table-striped table-hover table-bordered">
              <tr>
                <td>Kode : </td>
                <td>Tanggal :</td> 
                <td>Kota asal :</td> 
                <td>Kota Tujuan :</td> 
              </tr>
              
              <tr>
                <td id='kodemanifest_'></td>
                <td id='tanggalmanifest_'></td> 
                <td id='Kotaasal'></td> 
                <td id='kotatujuan'></td> 
              </tr>
            </table>
            
            <input type="text" name="idmanifest" id="idmanifest" class="d-none"  > 
            <input type="text" name="kodemanifest" id="kodemanifest" class="d-none"  > 
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect2">Status</label>
            <select class="form-control" id="status" name="status">
              <option class='options_' id='checked'    value='checked'   >checked</option>
              <option class='options_' id='delivering' value='delivering'>delivering (load ke truck)</option>
              <option class='options_' id='arrived'    value='arrived'   >arrived</option>
            </select>
          </div>
          <div class="form-group" > 
            <button type="button" class="pull-left btn btn-secondary" data-dismiss="modal">Close</button> 
            <button type="submit" id='simpanbutton' class="btn btn-primary pull-right mr-2">SIMPAN</button>
          </div>
        </form>
      </div> 
    </div>
  </div>
</div>

@endsection
@section('script')
<script type="text/javascript"> 

 
$(document) .ajaxStart(function () {
    $('#loading').removeClass('d-none')
    console.log('start')
})          .ajaxStop(function () {
    $('#loading').addClass('d-none')
    console.log('stop')
}); 
    $(document).on("click",".openstatus",function() {
      $('#Kotaasal'           ).html($(this).attr('kodekotaasal'))
      $('#kotatujuan'         ).html($(this).attr('kodekotatujuan'))
      $('#tanggalmanifest_'   ).html($(this).attr('tanggalmanifest'))
      $('#kodemanifest_'      ).html($(this).attr('kodemanifest'))

      $('#idmanifest'         ).val($(this).attr('idmanifest')) 
      $('#kodemanifest'       ).val($(this).attr('kodemanifest')) 
      $("#status").val($(this).attr('status'));

      $('.options_').removeClass('d-none')
      if($(this).attr('status') == 'delivering'){
        $('#checked').addClass('d-none')
      }
      else if($(this).attr('status') == 'arrived'){
        $('#checked'   ).addClass('d-none')
        $('#delivering').addClass('d-none')
      }
    })
    $(document).on("click","#simpanbutton",function() {
        var btnsave = $(this);
        $(this).prop('disabled', true);
        
        Swal.fire({   
            title               : "Anda Yakin?",   
            text                : "Merubah status menjadi ("+$('#status').val()+") status yang sudah dirubah, tidak bisa dikembalikan lagi",   
            icon                : "warning",   
            showCancelButton    : true,   
            confirmButtonColor  : "#e6b034",   
            confirmButtonText   : "Ya, Rubah status ke - " +$('#status').val()                  
            }).then((result) => {
            console.log(result)
            if (result.value) {
                scan_update_status($('#kodemanifest').val()); 
            } else{
                $(btnsave).prop('disabled', false); 
            }
        });
    })
    function scan_update_status(kode_manifest){
        $.ajax({
            method  :'POST',
            url     :'{{ url('awb/updatemanifestqr') }}',
            data    :{
                kode                : kode_manifest,
                status_nonencrypt   : $('#status').val(),
                '_token'            : "{{ csrf_token() }}" 
            },
            success:function(data){
                $('#simpanbutton').prop('disabled', false);
                $('#kode_manifest').val('')
                dt.ajax.reload();
                $('.bd-example-modal-lg').modal('toggle');
                if(data.statuserror)    {toastr.error( data.statuserror)}
                if(data.statuswarning)  { 
                    toastr.warning( data.statuswarning) 
                }
                if(data.statussuccess)  {
                    toastr.success( data.statussuccess) 
                }                   
            }
        }) 
    } 
    var dt = $('#datatables').DataTable({
	     processing : true,
	     serverSide : false,
	     paging     : true,
       pageLength : 100,
	     ajax       :'{{ url('master/manifest/datatables') }}',
	     columns    : [
         
      
          {data: 'kode',              name:'kode'}, 
          {data: 'kodekotaasal',      name:'Asal'}, 
          {data: 'kodekotatujuan',    name:'Tujuan'}, 
          {data: 'kodeagen',          name:'AgenTujuan'}, 
          {data: 'tanggal_manifest',  name:'Tujuan'}, 
          {data: 'namauser',          name:'Dicek Oleh'}, 
          {data: 'jumlah_koli',       name:'Koli'}, 
          {data: 'jumlah_kg',         name:'Kg'}, 
          {data: 'jumlah_doc',        name:'Doc'}, 
          {data: 'supir',             name:'supir'}, 
          {data: 'status_info',       name:'Status'},
          {data: 'aksi',              name:'aksi'},
      ],
	   "order": [[ 0, "desc" ]],
    });

    var detailRows = [];
   
    function deleteCustomer(status,id,nama)
    {
         Swal.fire({   
                      title               : "Anda Yakin?",   
                      text                : "Data user akan di-"+status+"-kan dari sistem",   
                      icon                : "warning",   
                      showCancelButton    : true,   
                      confirmButtonColor  : "#e6b034",   
                      confirmButtonText   : "Ya,   "+status+"-kan user" 
                       
                  }).then((result) => {
            if (result.value) {
              $.ajax({
                method  :'POST',
                url     :'{{ url('master/users/delete') }}',
                data    :{
                  id:id,
                  status:status,
                  '_token': $('input[name=_token]').val()
                },
                success:function(data){
                    Swal.fire({title:"Rubah status berhasil!", text:"user "+nama+" berhasil di-"+status+"-kan ", icon:"success"}
                    ).then((result) => {
                        location.reload()
                    })
                }
              }) 
            } 
         });
    }

  </script>
  
@if(Session::get('message') == "created")
    <script type="text/javascript">
        toastr.success("Manifest Baru Berhasil ditambahkan!");
    </script>
@endif
@if(Session::get('message') == "updated")
    <script type="text/javascript">
        toastr.success("Data Manifest Berhasil diubah!");
    </script>
@endif
@endsection
