@extends('admin.layouts.master')
@section('title') Create New Skill @endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin-assets/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<!-- dropzone css -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin-assets/assets/libs/dropzone/min/dropzone.min.css')}}">
@endsection
@section('content')

@component('admin.common-components.breadcrumb')
@slot('title') Create New @endslot
@slot('li_1') Skill @endslot
@slot('li_2') Create New @endslot
@endcomponent
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">Create New Skill</h4>
        <form id="create-skill-form">
          @csrf
          <div class="form-group row mb-4">
            <label for="projectname" class="col-form-label col-lg-2">Skill Name</label>
            <div class="col-lg-10">
              <input id="categoryname" name="skill_name" type="text" class="form-control" placeholder="Enter Skill Name...">
            </div>
          </div>
        </form>
        <div class="row justify-content-end">
          <div class="col-lg-10">
            <button type="submit" form="create-skill-form" class="btn btn-primary">Add Skill</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end row -->
@endsection
@section('script')
<!-- bootstrap datepicker -->
<script src="{{ URL::asset('admin-assets/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<!-- dropzone plugin -->
<script src="{{ URL::asset('admin-assets/assets/libs/dropzone/min/dropzone.min.js')}}"></script>
@endsection
@section('script-bottom')
<script>
    function catImg(input) {

      if (input.files && input.files[0]) {
          var reader = new FileReader();
          console.log(reader);
          reader.onload = function (e) {
              $('#icon_show')
                  .attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
      }
      
    }

  $('#create-skill-form').on('submit', function(event){
      event.preventDefault();
    $.ajax({
        url: "{{route('admin.skills.store')}}",
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,

        success: (response)=>{
            if (response.status == 'true') {
                $.notify(response.message , 'success'  );
                  window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/admin/skills/";
                
                
            }else{
                $.notify(response.message , 'error');

            }
        },
        error: (errorResponse)=>{
            $.notify( errorResponse, 'error'  );


        }
    })
  })
</script>
@endsection