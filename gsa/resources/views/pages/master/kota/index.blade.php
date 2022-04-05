@extends('layouts.app')
@section('content')
<div class="card card-custom">
  <div class="card-header flex-wrap border-0 pt-6 pb-0">
    <div class="card-title">
      <h3 class="card-label">Master kota
      <span class="d-block text-muted pt-2 font-size-sm">Data kota yang tersedia</span></h3>
    </div>
    <div class="card-toolbar">
      <a href="{{url('master/kota/edit/0') }}" class="btn btn-primary font-weight-bolder">
      <i class="la la-plus"></i>Tambah Data kota</a>
    </div>
  </div>
  <div class="card-body">
      <div class="table-responsive">
        <table id="datatables" class="table table-striped table-hover table-bordered">
          <thead>
            <tr> 
              <th>Kode</th> 
              <th>Nama</th>
              <th>Keterangan</th> 
              <th>last_update</th> 
              <th width='10%'>kecamatan</th> 
              <th width='5%'>Status</th> 
              <th width='5%'>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="judulmodalkota"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row" >
        <div class="col-8" style="height:400px; overflow:auto;">
          <table class="table table-striped "  id="example" >
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Out Area</th>
                <th scope="col" width='10%'>Edit</th>
                <th scope="col" width='10%'>Delete</th>
              </tr>
            </thead>
            <tbody id='detailkecmatan'>
              
            </tbody>
          </table>
        </div>
        <form class="col-4 bg-light" id="formBooking" method="post" action="{{url('master/kecamatan/save')}}">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nama Kecamatan:</label>
            <input type="text" name='nama' class="form-control" id="nama" required>
            <input type="hidden" name="idkota" id="idkota"  >
            <input type="hidden" name="idkec" id="idkec"  >
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Out Area:</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="oa" id="inlineRadio2" value="0" checked>
              <label class="form-check-label" for="inlineRadio2">Tidak</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="oa" id="inlineRadio1" value="1">
              <label class="form-check-label" for="inlineRadio1">Ya</label>
            </div>
          </div>
          <div class="form-group">
            <div onclick="resetkec()" class="btn btn-danger mr-2">CANCEL</div>
            <button type="submit" id='simpanbutton' class="btn btn-primary mr-2">SIMPAN</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
      </div>
    </div>
  </div>
</div>


@endsection
@section('script')
<script type='text/javascript'>
    function openkec(id,nama){
      console.log(nama)
      $('#judulmodalkota').html('Daftar kecamatan di kota '+nama)
      $('#idkota').val(id)
      getlist()
    }
    $("#simpanbutton").on('click',function(){  
        var btnsave = $(this);
        $(this).prop('disabled', true);
        $.ajax({
            type      : "POST",
            url       : "{{url('master/kecamatan/save')}}",
            dataType  : "json",
            data      : $('#formBooking').serialize(),
            success : function(response) {
                console.log(response)
                if(response && response.success && response.success=='success'){
                  toastr.success("Kecamatan berhasil ditambahkan!");
                  resetkec()
                  getlist()
                }
                $(btnsave).prop('disabled', false);
            },
            error : function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown)
            }
        });
    })
    function getlist(){
                   $("#example").dataTable().fnDestroy()
      var id_kota_list = $('#idkota').val()
      $('#detailkecmatan').html('')
      $.ajax({
            type      : "GET",
            url       : '{{ url('master/kecamatan/datatables') }}',
            dataType  : "json",
            data : {
                id : id_kota_list || "",
            },
            success : function(response) {
                console.log(response)
                if(response && response.data){
                  for(var i = 0; i < response.data.length ; i++){
                    var oa='<i class="fa fa-remove text-danger" aria-hidden="true"></i>';
                    if(response.data[i].oa==1){
                      oa='<i class="fa fa-check text-success" aria-hidden="true"></i>';
                    }
                    $('#detailkecmatan').append(`
                    <tr>
                      <th scope="row">`+(i+1)+`</th>
                      <td>`+response.data[i].nama+`</td>
                      <td>`+oa+`</td>
                      <td><button onclick="setedit(`+response.data[i].id+`,'`+response.data[i].nama+`',`+response.data[i].oa+`)" type="button" class="text-center btn btn-sm btn-warning"><i class="flaticon-edit-1"></i></button></td>
                      <td><button onclick="deletekecamatan(`+response.data[i].id+`,'`+response.data[i].nama+`')" type="button" class="text-center btn btn-sm btn-danger"><i class="flaticon-delete"></i></button></td>
                    </tr>
                    `);
                  }
                  resetkec()
                  $('#example').DataTable();
                }
            },
            error : function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown)
            }
        });
    }
    function setedit(id,nama,oa){
      $('#idkec').val(id)
      $('#nama').val(nama) 
      $("input[name=oa][value=" + oa + "]").prop('checked', true);
    }
    function resetkec(){
      $('#nama').val('')
      $('#idkec').val(0)
      $("input[name=oa][value=" + 0 + "]").prop('checked', true);
    }
    var dt = $('#datatables').DataTable({
	     processing : true,
	     serverSide : false,
	     paging     : true,
	     ajax       :'{{ url('master/kota/datatables') }}',
	     columns    : [
         
      
          {data: 'kode',              name:'kode'}, 
          {data: 'nama',              name:'nama'}, 
          {data: 'keterangan',        name:'Keterangan'}, 
          {data: 'updated_at',        name:'last update'}, 
          {data: 'tambahkecamatan',   name:'Kecamatan'},
          {data: 'aktifnonaktif',     name:'Status'},
          {data: 'aksi',              name:'aksi'},
      ],
      columnDefs:[{targets:3, render:function(data){
        return moment(data).format('Do MMMM YYYY');
      }}],
	   "order": [[ 3, "desc" ]],
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
          text                : "Data Kota akan di-"+status+"-kan dari sistem",   
          icon                : "warning",   
          showCancelButton    : true,   
          confirmButtonColor  : "#e6b034",   
          confirmButtonText   : "Ya,   "+status+"-kan Kota"                   
        }).then((result) => {
        if (result.value) {
          $.ajax({
            method  :'POST',
            url     :'{{ url('master/kota/delete') }}',
            data    :{
              id:id,
              status:status,
              '_token': $('input[name=_token]').val()
            },
            success:function(data){
                Swal.fire({title:"Rubah status berhasil!", text:"Kota "+nama+" berhasil di-"+status+"-kan ", icon:"success"}
                ).then((result) => {
                    location.reload()
                })
            }
          }) 
        } 
      });
    }
    function deletekecamatan( id,nama)
    {
         Swal.fire({   
          title               : "Anda Yakin?",   
          text                : "Data kecamatan akan dihapus dari sistem",   
          icon                : "warning",   
          showCancelButton    : true,   
          confirmButtonColor  : "#e6b034",   
          confirmButtonText   : "Ya, Hapus kecamatan"                   
        }).then((result) => {
        if (result.value) {
          $.ajax({
            method  :'POST',
            url     :'{{ url('master/kecamatan/delete') }}',
            data    :{
              id:id, 
              '_token': $('input[name=_token]').val()
            },
            success:function(data){
                Swal.fire({title:"Hapus kecamatan berhasil!", text:"Kota "+nama+" berhasil diHapus ", icon:"success"}
                ).then((result) => {
                  getlist()
                })
            }
          }) 
        } 
      });
    }

  </script>
  
@if(Session::get('message') == "created")
    <script type="text/javascript">
        toastr.success("Kota Baru Berhasil ditambahkan!");
    </script>
@endif
@if(Session::get('message') == "updated")
    <script type="text/javascript">
        toastr.success("Data kota Berhasil diubah!");
    </script>
@endif
@endsection
