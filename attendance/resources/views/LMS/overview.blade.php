@extends('LMS.layout')


@section('title')
OSMS | LMS | OVERVIEW
@endsection

@section('mtitle')
OSMS LMS OVERVIEW
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

@php
  $reggroup = auth()->user()->studentgrouping()->pluck('studentgroupings.coursecode')->toArray();
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>SITE OVERVIEW</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                        <li><i class="fa fa-window-maximize full-card"></i></li>
                        <li><i class="fa fa-minus minimize-card"></i></li>
                        <li><i class="fa fa-refresh reload-card"></i></li>
                        <li><i class="fa fa-trash close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block table-border-style">
                <div class="row">
                @foreach ($courses as $row)
                <div class="col-md-4">
                    <a href="#" title="{{$row->course}}">
                      <div class="card">
                        <img class="card-img-top" src="{{URL::to('images/assignment (2).jpg')}}" alt="Card image cap" width="291" height="200">
                        <div class="card-body">
                          <h5 class="card-title">{{$row->course}}</h5>
                          <p class="card-text">{{$row->lec_name}}</p>
                          <p class="card-text">
                            <small class="text-muted">{{$row->code}}
                            </small>

                      <a href="#" class="btn btn-primarys btnmenu" style="position: absolute; top: 0; right: 0; color: greenyellow;" data-title="{{$row->course}}" data-code="{{$row->code}}" data-lectname="{{$row->lec_name}}" data-lectid="{{$row->lecturer_id}}" >
                          <i class="fa fa-ellipsis-v"></i>
                      </a>


                            @if (in_array($row->code, $reggroup))

                            <small class="text-muted pull-right">
                              <a href="{{ route('lms-course-overview',['code' => $row->code]) }}" data-title="{{$row->course}}" data-code="{{$row->code}}" data-lectname="{{$row->lec_name}}" data-lectid="{{$row->lecturer_id}}"  class="enrolls btn btn-sm btn-outline-info">Enter Course</a>
                            </small>

                            @else

                            <small class="text-muted pull-right">
                              <a href="#"data-title="{{$row->course}}" data-code="{{$row->code}}" data-lectname="{{$row->lec_name}}" data-lectid="{{$row->lecturer_id}}"  class="enroll btn btn-sm btn-outline-success">Enroll</a>
                            </small>

                            @endif
                            
                        </p>
                         </div>
                       </div>
                    </a>
                </div>
                @endforeach
               </div>
            </div>
            <div class="card-footer">
                  {{$courses->links()}}              
            </div>



          </div>
      </div>

    </div>
</div>
</div>



@endsection



@section('script')

<script type="text/javascript">
    $(document).ready(function(){

       

    $(document).on("click",".enroll", function(e){
      e.preventDefault();
      var _token = $('meta[name=csrf-token]').attr('content');
      var  title = $(this).data('title');
      var  code = $(this).data('code');
      var  lectname = $(this).data('lectname');
      var  lectid = $(this).data('lectid');
      swal({
        title: "Are you sure?",
        text: "Enroll "+title+" ("+code+") Course",
        icon: "warning",
        buttons: ['Cancel', 'Yes Enroll'],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {

          $.ajax({

            beforeSend: function(){
              $.LoadingOverlay("show");
            },
            complete: function(){
              $.LoadingOverlay("hide");
            },

            url: '{{route('lms-site-overview-enroll')}}',
            type: 'POST',
            data: {_token : _token , code: code, lectid: lectid, lectname: lectname, title: title},
            success: function(data){ 

              if (data.match("success")) {
                toastr.success('Course Enrolled successfully!');
              }else if(data.match("failed")){
                toastr.error('Please make Sure Course Has Been Registered');
              }else{
                toastr.error('You have already Enrolled For this Course');
              }
              

              //window.location.reload();
            },
            error: function (data) {
              console.log('Error:', data);
            }
          });  

        }
      });

    });




        
    });
</script>


@endsection