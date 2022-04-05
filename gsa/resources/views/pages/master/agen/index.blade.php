@extends('layouts.app')
@section('content')
<div class="card card-custom">
  <div class="card-header flex-wrap border-0 pt-6 pb-0">
    <div class="card-title">
      <h3 class="card-label">Master Agen
      <span class="d-block text-muted pt-2 font-size-sm">Data agen yang tersedia</span></h3>
    </div>
    <div class="card-toolbar">
      <a href="javascript:void(0)" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#modal-create">
      <i class="la la-plus"></i>Tambah Data Agen</a>
    </div>
  </div>
  <div class="card-body">
      <div class="table-responsive">
        <table id="datatables" class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
              <th width='5%'>Kode</th>
              <th>Nama Agen</th>
              <th width='20%'>Alamat</th>
              <th width='10%'>Nomor Telpon</th>
              <th width='10%'>Presentase</th>
              <th>harga khusus</th>
              <th>Coverage Kota Agen</th>
              <th>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
  </div>
</div>

@include('pages.master.agen.modal_create')
@include('pages.master.agen.modal_edit')

@endsection
@section('script')
<script>
   $('#datatables').DataTable({
	    processing: true,
	    serverSide: false,
	    paging:true,
	    ajax: '{{ url('master/agen/datatables') }}',
	    columns: [
	    {data: 'kode', name:'kode'},
	    {data: 'nama_agen', name:'nama_agen'},
	    {data: 'alamat_agen', name:'alamat_agen'},
	    {data: 'no_telp', name:'no_telp'},
	    {data: 'presentase', name:'presentase'},
	    {data: 'hargakhusus', name:'hargakhusus'},
	    {data: 'coverage', name:'coverage'},
	    {data: 'aksi', name:'aksi'},
	],
	 "order": [[ 1, "asc" ]],
   });

   function deleteAgen(id,nama)
    {
         Swal.fire({   
                      title: "Anda Yakin?",   
                      text: "Data Agen akan terhapus dari sistem",   
                      icon: "warning",   
                      showCancelButton: true,   
                      confirmButtonColor: "#e6b034",   
                      confirmButtonText: "Ya, Hapus Agen" 
                       
                  }).then((result) => {
            if (result.value) {
                $.ajax({
                            method:'POST',
                            url:'{{ url("master/agen/delete") }}',
                            data:{
                              id:id,
                              '_token': $('input[name=_token]').val()
                            },
                            success:function(data){
                                Swal.fire({title:"Terhapus!", text:"Agen "+data.agen.nama+" berhasil terhapus dari sistem", icon:"success"}
                                ).then((result) => {
                                    location.reload()
                                })
                            }
                          }) 
            } 
         });
    }

    function editAgen(id){
      $.ajax({
                            method:'POST',
                            url:'{{ url("master/agen/edit") }}',
                            data:{
                              id:id,
                              '_token': $('input[name=_token]').val()
                            },
                            success:function(data){
                              console.log(data);
                              $('#idagen').val(data.agen.id)
                              $('#nama').val(data.agen.nama)
                              $('#idkota1').val(data.agen.idkota1)
                              $("#idkota1").val(data.agen.idkota1).trigger('change')
                              $('#idkota2').val(data.agen.idkota2)
                              $("#idkota2").val(data.agen.idkota2).trigger('change')
                              $('#idkota3').val(data.agen.idkota3)
                              $("#idkota3").val(data.agen.idkota3).trigger('change')
                              $('#idkota4').val(data.agen.idkota4)
                              $("#idkota4").val(data.agen.idkota4).trigger('change')
                              $('#idkota5').val(data.agen.idkota5)
                              $("#idkota5").val(data.agen.idkota5).trigger('change')
                              $('#idkota6').val(data.agen.idkota6)
                              $("#idkota6").val(data.agen.idkota6).trigger('change')
                              $('#idkota7').val(data.agen.idkota7)
                              $("#idkota7").val(data.agen.idkota7).trigger('change')
                              $('#idkota8').val(data.agen.idkota8)
                              $("#idkota8").val(data.agen.idkota8).trigger('change')
                              $('#idkota9').val(data.agen.idkota9)
                              $("#idkota9").val(data.agen.idkota9).trigger('change')
                              $('#idkota10').val(data.agen.idkota10)
                              $("#idkota10").val(data.agen.idkota10).trigger('change')
                              $('#kode').val(data.agen.kode)
                              $('#alamat').val(data.agen.alamat)
                              $('#no_telp').val(data.agen.no_telp)
                              $('#presentase').val(data.agen.presentase)
                              $('#has_harga_khusus').val(data.agen.has_harga_khusus)
                              $('#harga_doc').val(data.agen.harga_doc)
                              $('#harga_kg').val(data.agen.harga_kg)
                              $('#harga_kg_selanjutnya').val(data.agen.harga_kg_selanjutnya)
                              $('#harga_koli_b').val(data.agen.harga_koli_b)
                              $('#harga_koli_bb').val(data.agen.harga_koli_bb)
                              $('#harga_koli_k').val(data.agen.harga_koli_k)
                              $('#harga_koli_s').val(data.agen.harga_koli_s)
                            }
                          }) 
    }
  </script>
@if(Session::get('message') == "created")
    <script type="text/javascript">
        toastr.success("Agen Baru Berhasil ditambahkan!");
    </script>
@endif
@if(Session::get('message') == "updated")
    <script type="text/javascript">
        toastr.success("Data Agen Berhasil diubah!");
    </script>
@endif
@endsection