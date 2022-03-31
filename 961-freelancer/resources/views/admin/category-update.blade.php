@extends('admin.layouts.master')
@section('title') Create New Category @endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin-assets/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<!-- dropzone css -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin-assets/assets/libs/dropzone/min/dropzone.min.css')}}">
@endsection
@section('content')

@component('admin.common-components.breadcrumb')
@slot('title') Create New @endslot
@slot('li_1') Category @endslot
@slot('li_2') Create New @endslot
@endcomponent
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">Edit Category</h4>
        <form enctype="multipart/form-data" id="create-category-form">
          @csrf
          <div class="form-group row mb-4">
            <label for="projectname" class="col-form-label col-lg-2">Category Name</label>
            <div class="col-lg-10">
              <input id="categoryname" name="category_name" value="{{$getSingleData->category_name}}" type="text" class="form-control" placeholder="Enter Category Name...">
            </div>
          </div>
          <div class="form-group row mb-4">
            <label for="projectname" class="col-form-label col-lg-2">Category Slug</label>
            <div class="col-lg-10">
              <input id="categoryname" name="slug" value="{{$getSingleData->slug}}" type="text" class="form-control" placeholder="Enter Category Slug...">
            </div>
          </div>
          <div class="form-group row mb-4">
            <label for="projectdesc" class="col-form-label col-lg-2">Category Description</label>
            <div class="col-lg-10">
              <textarea class="form-control" name="cat_desc" id="cat_desc" rows="3" placeholder="Enter Category Description...">{{$getSingleData->cat_desc}}</textarea>
            </div>
          </div>
        </form>
        <div class="row mb-4">
          <label class="col-form-label col-lg-2">Category Icon</label>
          <div class="col-lg-10">
            <!-- <div class="dropzone"> -->
              <div class="fallback form-control mb-3">
                <input name="cat_icon" value="{{$getSingleData->cat_icon}}" onchange="catImg(this)" form="create-category-form" type="file" accept="image/png, image/gif, image/jpeg" />
              </div>
              
              <!-- <div class="dz-message needsclick">
                <div class="mb-3">
                  <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                </div>
                
                <h4>Drop file here or click to upload.</h4>
              </div> -->
            <!-- </div> -->
            <img src="{{asset('assets/images/categories/'.$getSingleData->cat_icon)}}" id="icon_show">
          </div>
        </div>
        <div class="row justify-content-end">
          <div class="col-lg-10">
            <button type="submit" form="create-category-form" class="btn btn-primary">Edit Category</button>
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
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $('#create-category-form').on('submit', function(event){
      event.preventDefault();
      let createFormData = $(this).serialize();
    $.ajax({
        url: "{{url('admin/categories/'.$getSingleData->id)}}",
        type: 'PATCH',
        data: createFormData,
        // contentType: false,
        processData: false,

        success: (response)=>{
            if (response.status == 'true') {
                $.notify(response.message , 'success'  );
                  window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/admin/categories/";
                
                
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