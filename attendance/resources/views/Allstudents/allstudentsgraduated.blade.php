@extends('layouts.main')


@section('title')
  OSMS | All ONLINE Admissions
@endsection

@section('mtitle')
  Confirm Student Admission
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

  <div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Confirm Admission</h3>
      </div>
      <div class="box-body">
          <div class="box-body">
              <table id="admission" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Pic</th>
                  <th>Fullname</th>
                  <th>Gender</th>
                  <th>Entry Level</th>
                  <th>Current Level</th>
                  <th>Academic Year</th>
                  <th>Programme</th>
                  <th>Index Number</th>
                  <th>Status</th>
                  <th>Details</th>
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


@endsection




@section('script')

<script type="text/javascript">
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


	$('document').ready(function(){
		$(document).on('change','.progamme',function(e){
			e.preventDefault();
			var prog = $(this).val();
			var cid = $(this).attr("cid");
			var _token = $('meta[name=csrf-token]').attr('content');
			_this = $(this);
			$.ajax({
					url: '{{route('admissions-update-programme')}}',
					type: 'POST',
					data: {_token : _token , prog: prog, cid: cid},
					 dataType: 'json',
					success: function(data){
						$("#msg").text(data.msg).show();
					},
			          error: function (data) {
			            console.log('Error:', data);
			            $("#msg").text('Sorry, Something error :(').show();
			          }
				});
		});

		$(document).on('click','.confirm',function(e){
			e.preventDefault();
			var cid = $(this).attr("cid");
			var _token = $('meta[name=csrf-token]').attr('content');
			_this = $(this);

            if (confirm("Confirm Student Admission")){
               $.ajax({
                    url: '{{route('admissions-all-confirm-now')}}',
                    type: 'POST',
                    data: {_token : _token , cid: cid},
                     dataType: 'json',
                    success: function(data){
                        if (data.msg) {
                            alert(data.msg);
                window.location.href="/LatestAdmission/student-admission-confirm-appointment-letter/"+cid;
                        }else{
                            $("#error").text(data.error).show();
                        }
                        
                    },
                      error: function (data) {
                        console.log('Error:', data);
                        $("#msg").text(data.message).show();
                      }
                });
            }

		});


		


	$('#admission').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('add-students-data') }}',
        dom: 'lBfrtip',
        buttons: [
            'copy',
            'csv',
            'excel',
            'pdf',
            'print'
        ],
        columns: [
            {data: 'id'},
            {data: 'profileimg', render: function(data){
            	return '<img src="{{asset('storage')}}/'+data+'" class="img-circle"width="50" height="50">';
            },
            orderable: false
        },
            {data: 'fullname'},
            {data: 'gender'},
            {data: 'entrylevel'},
            {data: 'currentlevel'},
            {data: 'academic_year'},
            {data: 'programme'},
            {data: 'indexnumber'},
           {data: 'approve', render: function(data,type,row,meta){
            	$html = "";
                $html += '<span class="badge badge-primary">Active</span>';
                return $html;
            }, 
             orderable: false
        },
            {data: 'action', name: 'action'},
        ]




    });





	$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
    	console.log(message);
};

	});
</script>


@endsection
