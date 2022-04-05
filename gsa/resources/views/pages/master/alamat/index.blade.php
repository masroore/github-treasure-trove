@extends('layouts.app')
@section('content')
<div class="card card-custom">
  <div class="card-header flex-wrap border-0 pt-6 pb-0">
    <div class="card-title">
      <h3 class="card-label">Master Alamat
      <span class="d-block text-muted pt-2 font-size-sm">Data Alamat yang tersedia</span></h3>
    </div>
    <div class="card-toolbar">
      <a href="{{url('master/alamat/edit/0') }}" class="btn btn-primary font-weight-bolder">
      <i class="la la-plus"></i>Tambah Data Alamat</a>
    </div>
  </div>
  <div class="card-body">
      <div class="table-responsive">
        <table id="datatables" class="table table-striped table-hover table-bordered">
          <thead>
            <tr>  
              <th>Alamat milik customer</th>
              <th>Label</th>
              <th>nama Penerima</th>    
              <th>Alamat</th> 
              <th>Kodepos</th> 
              <th>Kota</th>    
              <th>Kecamatan</th>    
              <th>notelp</th>    
              <th width='5%'>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
  </div>
</div>
@endsection
@section('script')
<script type='text/javascript'>
      
    var dt = $('#datatables').DataTable({
	     processing : true,
	     serverSide : false,
	     paging     : true,
	     ajax       :'{{ url('master/alamat/datatables') }}',
	     columns    : [ 
          {data: 'namacustomer',      name:'namacustomer'}, 
          {data: 'labelalamat',       name:'label'}, 
          {data: 'nama_penerima',     name:'nama_penerima'}, 
          {data: 'alamat',            name:'alamat'}, 
          {data: 'kodepos',           name:'kodepos'}, 
          {data: 'namakota',          name:'namakota'},  
          {data: 'kecamatan',         name:'kecamatan'},  
          {data: 'no_hp',             name:'no_hp'},  
          {data: 'aksi',              name:'aksi'},
      ],
     
	   "order": [[ 0, "desc" ]],
    });

    var detailRows = [];
  
    // On each draw, loop over the `detailRows` array and show any child rows
    dt.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );

   function deleteCustomer( id,nama)
    {
         Swal.fire({   
          title               : "Anda Yakin?",   
          text                : "Data alamat akan dihapus dari sistem",   
          icon                : "warning",   
          showCancelButton    : true,   
          confirmButtonColor  : "#e6b034",   
          confirmButtonText   : "Ya,   hapus alamat"                   
        }).then((result) => {
        if (result.value) {
          $.ajax({
            method  :'POST',
            url     :'{{ url('master/alamat/delete') }}',
            data    :{
              id:id,
              status:status,
              '_token': $('input[name=_token]').val()
            },
            success:function(data){
                Swal.fire({title:"Rubah status berhasil!", text:"alamat "+nama+" berhasil dihapus ", icon:"success"}
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
        toastr.success("alamat Baru Berhasil ditambahkan!");
    </script>
@endif
@if(Session::get('message') == "updated")
    <script type="text/javascript">
        toastr.success("Data alamat Berhasil diubah!");
    </script>
@endif
@endsection
