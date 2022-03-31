@extends('admin.layouts.master')
@section('title') Projects List @endsection
@section('content')
@component('admin.common-components.breadcrumb')
@slot('title') Projects List @endslot
@slot('li_1') Projects @endslot
@slot('li_2') Projects List @endslot
@endcomponent

<div class="row">
  <div class="col-lg-12">
    <div class="">
      <div class="table-responsive">
        <table id="project-list-table" class="table project-list-table table-nowrap table-centered table-borderless">
          <thead>
            <tr>
              <th scope="col" style="width: 100px">#</th>
              <th scope="col">Projects</th>
              <th scope="col">Project Length</th>
              <th scope="col">Type</th>
              <th scope="col">Budget</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($projects as $project)
            <tr>
              <td>
                @if($project->clientInfo->profile_image != '')
                <img src="{{asset('assets/images/user/profile/'.$project->clientInfo->profile_image)}}" alt="" class="avatar-sm">
                @else
                <img src="{{asset('assets/images/user-login.png')}}" alt="" class="avatar-sm">
                @endif
              </td>
              <td>
                <h5 class="text-truncate font-size-14"><a href="#" class="text-dark">{{$project->job_title}}</a></h5>
                <p class="text-muted mb-0">It will be as simple as Occidental</p>
              </td>
              <td>{{$project->job_duration}}</td>
              <td class="text-capitalize">{{$project->job_type}}</td>
              <td> 
                @if($project->job_type == 'fixed')
                  ${{$project->fixed_price}} /Fixed
                @else
                  ${{$project->hourly_min_price}} - ${{$project->hourly_max_price}} /hr
                @endif
              </td>
              <td>
                @if($project->job_status == 2)
                <span class="badge badge-primary">In Progress</span>
                @elseif($project->job_status == 3)
                <span class="badge badge-danger">Cancelled</span>
                @elseif($project->job_status == 4)
                <span class="badge badge-success">Completed</span>
                @else
                <span class="badge badge-success">Active</span>
                @endif
              </td>
              <td>
                <div>
                  <a href="{{url('admin/projects/'.$project->id.'/edit')}}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-success rounded"><i class="bx bx-edit"></i></a>
                  <button class="btn btn-primary rounded" data-toggle="modal" onclick="deleteProject({{$project->id}})" data-placement="top" title="Delete"><i class="bx bx-trash-alt"></i></button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Modal effects -->
<div class="modal" id="deleteModel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modal-content-demo">
      <div class="modal-header">
        <h6 class="modal-title">Alert</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
      </div>
      <form id="deleteData" > 
        @csrf
         @method('DELETE')
      <input type="hidden" name="projectId" id="projectId">
      <div class="modal-body">
        <h6></h6>
        <p>Are you sure you want to delete the record ?</p>
      </div>
      <div class="modal-footer">
        <button class="btn ripple btn-danger" id="confirmDelete" type="submit"> Delete </button>
        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
      </div>
       </form>
    </div>
  </div>
</div>
<!-- End Modal effects-->
@endsection
@section('script-bottom')
<script>
    $(document).ready(function() {
        $('#project-list-table').DataTable();
    } );
    $('#deleteData').on('submit' , function(event){
      event.preventDefault();
      var data = $("#deleteData").serialize();
      $projectId = $("#projectId").val();
      console.log($projectId)

         $.ajax({
          url: '/admin/projects/'+$projectId,
          type: 'DELETE',
          data: data,
          processData: false,

          success: (response)=>{
              
              if (response.status == 'true') {

                  $.notify(response.message , 'success'  );
                  window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/admin/projects";

              }else{
                  $.notify(response.message , 'error');

              }
          },
          error: (errorResponse)=>{
              $.notify( errorResponse, 'error'  );


          }
      })

    });

    function deleteProject(id) {
      $("#deleteModel").modal('show');
      $("#projectId").val(id);
    }
</script>
@endsection