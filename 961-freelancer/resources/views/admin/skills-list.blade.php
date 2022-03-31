@extends('admin.layouts.master')
@section('title') Skills List @endsection
@section('content')
@component('admin.common-components.breadcrumb')
@slot('title') Skills List @endslot
@slot('li_1') Skills @endslot
@slot('li_2') Skills List @endslot
@endcomponent

<div class="row">
  <div class="col-lg-12">
    <div class="">
      <div class="table-responsive">
        <table id="project-list-table" class="table project-list-table table-nowrap table-centered table-borderless">
          <thead>
            <tr>
              <th scope="col" style="width: 100px">#</th>
              <th scope="col">Skills</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($skills as $skill)
            <tr>
              <td>{{$skill->id}}</td>
              <td>
                <h5 class="text-truncate font-size-14">
                  <a href="#" class="text-dark">{{$skill->skill_name}}</a>
                </h5>
              </td>
              <td>
                <div>
                  <a href="{{url('admin/skills/'.$skill->id.'/edit')}}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-success rounded"><i class="bx bx-edit"></i></a>
                  <button class="btn btn-primary rounded" data-toggle="modal" onclick="deleteBatch({{$skill->id}})" data-placement="top" title="Delete"><i class="bx bx-trash-alt"></i></button>
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
    
      // ******************** ******************************* confirm delete ajax **********************


      $('#deleteData').on('submit' , function(event){
        event.preventDefault();
        var data = $("#deleteData").serialize();
        $projectId = $("#projectId").val();
        console.log($projectId)

           $.ajax({
            url: '/admin/skills/'+$projectId,
            type: 'DELETE',
            data: data,
            processData: false,

            success: (response)=>{
                
                if (response.status == 'true') {

                    $.notify(response.message , 'success'  );
                    window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/admin/skills";

                }else{
                    $.notify(response.message , 'error');

                }
            },
            error: (errorResponse)=>{
                $.notify( errorResponse, 'error'  );


            }
        })

      });

    function deleteBatch(id) {
      $("#deleteModel").modal('show');
      $("#projectId").val(id);
    }
</script>
@endsection