@extends('layouts.app')
@section('content')
<div class="card card-custom">
  <div class="card-header flex-wrap border-0 pt-6 pb-0">
    <div class="card-title">
      <h3 class="card-label">Master users
      <span class="d-block text-muted pt-2 font-size-sm">Data users yang tersedia</span></h3>
    </div>
    <div class="card-toolbar">
      <a href="{{url('master/users/edit/0') }}" class="btn btn-primary font-weight-bolder">
      <i class="la la-plus"></i>Tambah Data users</a>
    </div>
  </div>
  <div class="card-body">
      <div class="table-responsive">
        <table id="datatables" class="table table-striped table-hover table-bordered">
          <thead>
            <tr> 
              <th>Nama</th>
              <th>Username</th>
              <th>Jenis</th>
              <th>Alamat</th>
              <th>No Telp</th>
              <th>Email</th>
              <th width='15%'>Hak akses halaman</th> 
              <th width='5%'>Status</th> 
              <th width='5%'>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
  </div>
</div>


@endsection
@section('script')
<script>
 
    var dt = $('#datatables').DataTable({
	     processing : true,
	     serverSide : false,
	     paging     :true,
	     ajax       :'{{ url('master/users/datatables') }}',
	     columns    : [
         
      
          {data: 'nama',          name:'nama'},
          {data: 'username',      name:'username'},
          {data: 'jenis',         name:'jenis'},
          {data: 'alamat',        name:'alamat'},
          {data: 'notelp',        name:'notelp'},
          {data: 'email',         name:'email'},
          {data: 'akseshalaman',  name:'akseshalaman'},
          {data: 'aktifnonaktif', name:'Status'},
          {data: 'aksi',          name:'aksi'},
      ],
	   "order": [],
    });

    var detailRows = [];
  
    // On each draw, loop over the `detailRows` array and show any child rows
    dt.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );
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
        toastr.success("User Baru Berhasil ditambahkan!");
    </script>
@endif
@if(Session::get('message') == "updated")
    <script type="text/javascript">
        toastr.success("Data User Berhasil diubah!");
    </script>
@endif
@endsection
