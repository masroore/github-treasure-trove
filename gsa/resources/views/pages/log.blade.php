@extends('layouts.app')

@section('content')

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
              <div class="modal-body">
                
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
	 $(function() {
        $('#datatables').DataTable({
            processing: true,
            serverSide: false,
            paging:true,
            ajax: '{{ url('log/datatables') }}',
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
    });
    function modalNew(id){
        $.ajax({
        method:'POST',
        url:'{{ url("log/modal/new") }}',
        data:{
          id: id,
          '_token': $('input[name=_token]').val()
        },
        success:function(data){
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
            
        }

      });
    }
</script>
@endsection