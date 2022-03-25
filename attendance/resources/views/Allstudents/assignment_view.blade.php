@extends('layouts.main')


@section('title')
OSMS | Student Portal Assignments
@endsection

@section('mtitle')
Student Portal
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

   @if(Session::has('message'))
   <div class="callout {{Session::get('type')}}">
    <h4>{{Session::get('title')}}</h4>
    <p> {{Session::get('message')}}</p>
  </div>
  @endif

  <div class="card-desk bg-danger border-info" >
   @foreach($assingment as $row)
   <a href="{{route('students-assignment-view',['id'=>$row->id])}}" title="{{$row->assignment_title}}">
     <div class="col-md-4 mb-5" style="background-color: #fff;padding: 10px;">
     <div class="card bg-dark shadow">
      {{-- <div class="card-body">
        <h6 class="card-subtitle text-muted"></h6>
      </div> --}}
      <img style="height: 200px; width: 100%; display: block;" src="{{URL::to('images/assignment (1).jpg')}}" alt="Card image">
    </div>
    <div class="card border-1">
      <div class="card-body">
        <h4 class="card-title">{{$row->assignment_title}}</h4>
        <p class="card-text">{{Str::limit($row->assignment_description,63,'...')}}</p>
        <a href="#" class="card-link"><button type="button" class="btn btn-outline-primary">{{$row->course_code}}</button></a>
        <a href="#" class="card-link"><button type="button" class="btn btn-outline-secondary">{{$row->lname}}</button></a>
        <a href="#" class="card-link"><button type="button" class="btn btn-outline-secondary">{{\Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</button></a>

      </div>
    </div>
</div>
  </a>
  @endforeach
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




   $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
     console.log(message);
   };

 });
</script>


@endsection
