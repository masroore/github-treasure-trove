@extends('admin.layouts.master')

@section('title') Update Project @endsection

@section('css') 
<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin-assets/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<!-- dropzone css -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin-assets/assets/libs/dropzone/min/dropzone.min.css')}}">
<link rel="stylesheet" media="screen" href="{{ URL::asset('assets/css/chosen.css') }}">
<style>
  .chosen-container-multi .chosen-choices{
    height: calc(1.5em + .94rem + 2px);
    border-radius: .25rem;
  }
  .chosen-container-multi .chosen-choices li.search-choice{
    line-height: 20px;
  }
  /* Chosen Style */
  
  .select2-container .select2-selection--single{
    height: 36px;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
  }
</style>
@endsection

@section('content')

@component('admin.common-components.breadcrumb')
@slot('title') Update @endslot
@slot('li_1') Projects @endslot
@slot('li_2') Update @endslot
@endcomponent 

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">Update Project</h4>
        <form id="updateProjectForm">
          @csrf
          <input type="hidden" name="id" value="{{$getSingleData->id}}">
          <div class="form-group row mb-4">
            <label for="projectname" class="col-form-label col-lg-2">Project Name</label>
            <div class="col-lg-10">
              <input id="projectname" name="job_title" type="text" class="form-control" placeholder="Enter Project Name..." value="{{$getSingleData->job_title}}">
            </div>
          </div>
          <div class="form-group row mb-4">
            <label for="category" class="col-form-label col-lg-2">Project Categories:</label>
            <div class="col-lg-10">
              <select name="job_cat" class="form-control select2">
                @foreach($categories as $category)
                <option value="{{$category->category_name}}" {{ $getSingleData->job_cat === $category->category_name ? "selected" : "" }}>{{$category->category_name}}</option>
                @endforeach
              </select>
            </div>          
          </div>
          <div class="form-group row mb-4">
            <label for="level" class="col-form-label col-lg-2">Service Level:</label>
            <div class="col-lg-10">
              <select name="service_level" class="form-control">
                <option value="Expert" {{ $getSingleData->service_level === 'Expert' ? "selected" : "" }}>Expert</option>
                <option value="Intermediate" {{ $getSingleData->service_level === 'Intermediate' ? "selected" : "" }}>Intermediate</option>
                <option value="Beginner" {{ $getSingleData->service_level === 'Beginner' ? "selected" : "" }}>Beginner</option>
              </select>
            </div>          
          </div>
          <div class="form-group row mb-4">
            <label for="type" class="col-form-label col-lg-2">Project Type:</label>
            <div class="col-lg-10">
              <select name="job_type" class="form-control" onchange="jobType(this)">
                <option value="fixed" {{ $getSingleData->job_type === 'fixed' ? "selected" : "" }}>Fixed</option>
                <option value="hourly" {{ $getSingleData->job_type === 'hourly' ? "selected" : "" }}>Hourly</option>
              </select>
            </div>
          </div>
          
          <div id="hourly_price" class="form-group row mb-4 {{ $getSingleData->job_type === 'hourly' ? "" : "d-none" }}">
              <label for="hour" class="col-lg-2 col-form-label">Hourly Price:</label>
            <div class="col-lg-5">
              <input type="text" name="hourly_min_price" value="{{$getSingleData->hourly_min_price}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Hourly Min Price $10">
            </div>
            <div class="col-lg-5">
              <!-- <label for="selectoption">Hourly Price:</label> -->
              <input type="text" name="hourly_max_price" value="{{$getSingleData->hourly_max_price}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Hourly Max Price $40">
            </div>
          </div>
          
          <div class="form-group row mb-4 {{ $getSingleData->job_type === 'fixed' ? "" : "d-none" }}" id="fixed_price">
            <label for="fixed" class="col-form-label col-lg-2">Fixed Price:</label>
            <div class="col-lg-10">
              <input type="text" name="fixed_price" value="{{$getSingleData->fixed_price}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Fixed Price $500">
            </div>
          </div>
          <div class="form-group row mb-4">
            <label for="length" class="col-form-label col-lg-2">Project Length:</label>
            <div class="col-lg-10">
              <select name="job_duration" class="form-control">
                <option value="Less than 1 month" {{ $getSingleData->job_duration === 'Less than 1 month' ? "selected" : "" }}>Less than 1 month</option>
                <option value="1 to 3 months" {{ $getSingleData->job_duration === '1 to 3 months' ? "selected" : "" }}>1 to 3 months</option>
                <option value="3 to 6 months" {{ $getSingleData->job_duration === '3 to 6 months' ? "selected" : "" }}>3 to 6 months</option>
                <option value="More than 6 months" {{ $getSingleData->job_duration === 'More than 6 months' ? "selected" : "" }}>More than 6 months</option>
              </select>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label for="projectdesc" class="col-form-label col-lg-2">Project Description</label>
            <div class="col-lg-10">
              <textarea class="form-control" name="job_description" rows="3" placeholder="Enter Project Description...">{{$getSingleData->job_description}}</textarea>
            </div>
          </div>

          <div class="form-group row mb-4">
            <label for="skills" class="col-form-label col-lg-2">Project Skills</label>
            <div class="col-lg-10">
              <select class="chosen-select form-control Skills" name="job_skills[]" multiple>
                
                @foreach($skills as $skill)
                
                <option value="{{$skill->skill_name}}" @foreach(explode(',',$getSingleData->job_skills) as $jobskil) {{ $jobskil === $skill->skill_name ? "selected" : "" }} @endforeach>{{$skill->skill_name}}</option>
                
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label for="skills" class="col-form-label col-lg-2">Location</label>
            <div class="col-lg-10">
              <select class="form-control select2" name="job_location">
                @foreach($countries as $country)
                <option value="{{$country->name}}" {{ $getSingleData->job_location === $country->name ? "selected" : "" }}>{{$country->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </form>
        <div class="row mb-4">
          <label class="col-form-label col-lg-2">Attached Files</label>
          <div class="col-lg-10">
            <input name="job_attachement[]" form="updateProjectForm" type="file" multiple />
            
          </div>
        </div>
        <div class="row justify-content-end">
          <div class="col-lg-10">
            <button type="submit" form="updateProjectForm" class="btn btn-primary">Create Project</button>
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
<script src="{{ URL::asset('admin-assets/assets/js/jqueryvalidate/jquery.validate.min.js')}}"></script>
<script src="{{ URL::asset('admin-assets/assets/js/jqueryvalidate/additional-methods.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/chosen.jquery.js') }}"></script>
<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $('.select2').select2();

  var config = {
    '.chosen-select'           : {},
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
    '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      jQuery(selector).chosen(config[selector]);
  }
  function jobType(select){
    if(select.value == 'hourly'){
      $('#hourly_price').removeClass('d-none');
      $('#fixed_price').addClass('d-none');
    }else{
      $('#fixed_price').removeClass('d-none');
      $('#hourly_price').addClass('d-none');
    }
  }

  // var input = document.querySelector("#phone");

  $("#updateProjectForm").validate({


      errorPlacement:function (error , element) {
        error.insertAfter(element.parents(".form-group .col-lg-10"))
      },
          rules: {
              job_title: {
                  required: true,
                  // lettersonly: true
              },
              service_level: {
                  required: true,
                  // lettersonly: true
              },
              job_type: {
                  required: true,
                  // email: true
              },
              job_duration: {
                  required: true,
                  // number: true
              },
              job_skills: {
                  required: true,
                  
              },
              job_cat: {
                  required: true,
                  
              },
              job_description: {
                  required: true,
                  
              },


          },
          messages: {
              job_title: {
                  required: "Please enter project title",

              } ,
              service_level: {
                  required: "Please select service level",

              } ,
              job_type: {
                  required: "Please select job type",

              } ,
              job_duration: {
                  required: "Please select job duration",
                  // number: "Please enter valid integer",
              } ,
              job_skills: {
                  required: "Please select job skills",

              } ,
              job_cat: {
                  required: "Please select job category",

              } ,
              job_description: {
                  required: "Please enter job description",

              } ,

          },

          submitHandler: function(form) {
             form_Create(form);
          }

    });


  function form_Create(formData) {
   let createFormData = $('#updateProjectForm').serialize();
// var createFormData = new FormData (formData);
    console.log(createFormData);
    $.ajax({
        url: "{{url('admin/projects/'.$getSingleData->id)}}",
        type: 'PATCH',
        data: createFormData,
        // contentType: false,
        processData: false,

        success: (response)=>{
            if (response.status == 'true') {
                $.notify(response.message , 'success'  );
                  window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/admin/projects/";
                
                
            }else{
                $.notify(response.message , 'error');

            }
        },
        error: (errorResponse)=>{
            $.notify( errorResponse, 'error'  );


        }
    })

}
</script>
@endsection