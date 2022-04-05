@extends('layouts.app')

@section('content')
<div class="row mb-2">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header border-0" style="padding-bottom:0px; padding-top:10px;">
        <div class="card-title font-weight-bolder">
          <div class="card-label">Log Aktivitas</div>
        </div>
      </div>
      <div class="card-body">
        <form class="form" id="form">
          {{ csrf_field() }}
            <div class="col-lg-6">
              <label class="font-weight-bold mt-5">Tanggal Awal - Akhir:</label><br>
              <input type="text" class="form-control" name="tanggal" id="tanggal" required>
            </div>
          <div class="row mt-2">
            <div class="col-lg-3">
              <button type="button" class="btn btn-lg btn-outline-primary btn-success" id="btnproses"><i class="flaticon-search"></i> Cari</button>
              
            <div id="reloaddatatable" class="btn btn-default  text-center">
              <i class="fa fa-refresh text-center"></i></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
    <div class="row justify-content-center">
    	<div class="col-md-12 col-xl-12">
            <div class="card card-custom">
                <div class="card-body text-left">
                	<div class="table-responsive">
                		<table id="datatables">
                            <thead>
                                <tr>
                                    <th>created_at</th>
                                    <th>User</th>
                                    <th>Deskripsi Aktivitas</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                		</table>
                	</div>
                </div>
            </div>
    	</div>
    </div>
    <div class="modal fade" id="modal-update" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Informasi Lengkap Data Yang Terubah
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i aria-hidden="true" class="ki ki-close"></i>
                </button>
              </div>
              <div class="modal-body" id="update-res">
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Tutup</button>
              </div>
            </div>
        </div>
      </div>

      <div class="modal fade" id="modal-new" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Informasi Lengkap Data Yang Terbuat
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i aria-hidden="true" class="ki ki-close"></i>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12" id="data">

                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Tutup</button>
              </div>
            </div>
        </div>
      </div>
@endsection
@section('script')
<script type="text/javascript"> 

$( document ).ready(function() {
   
    var datatable = $('#datatables').DataTable({
        processing: true,
        serverSide: false,
        paging:true,
         // ajax: '{{ url('log/datatables') }}',
        ajax:  {
            "url": '{{ url('log/datatables') }}',
            data: function(d){
                d.tanggal = $('#tanggal').val();
            }
        },
         columns: [
        {data: 'dates', name:'dates'},
        {data: 'user', name:'user'},
        {data: 'description', name:'description'},
        {data: 'tanggal', name:'tanggal'},
        {data: 'keterangan', name:'keterangan'},
        {data: 'aksi', name:'aksi'}
        ],
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
        ]
    }); 
    $('#reloaddatatable').click(function(){
        datatable.ajax.reload();
    })
    $("#btnproses").on('click',function(){
        if($("#tanggal").val() != ''){
            console.log($('#tanggal').val())
            datatable.ajax.reload()
        }
    })
}); 
    function modalNew(id){
        $.ajax({
        method:'POST',
        url:'{{ url("log/modal-new") }}',
        data:{
          id: id,
          '_token': $('input[name=_token]').val()
        },
        success:function(data){
          $('#data').html(data.view);
        }

      });
    }
    function modalUpdate(id){
        $.ajax({
        method:'POST',
        url:'{{ url("log/modal-update") }}',
        data:{
          id: id,
          '_token': $('input[name=_token]').val()
        },
        success:function(data){
            $('#update-res').html(data.view)
        }

      });
    }
    $('#tanggal').daterangepicker({
        locale: {
            format: "DD/MM/YYYY",
        }
    });
</script>
@endsection