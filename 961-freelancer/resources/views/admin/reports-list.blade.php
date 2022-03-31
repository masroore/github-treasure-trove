@extends('admin.layouts.master')
@section('title') Reported User List @endsection
@section('content')
@component('admin.common-components.breadcrumb')
@slot('title') Reported User List @endslot
@slot('li_1') Reported User @endslot
@slot('li_2') Reported User List @endslot
@endcomponent

<div class="row">
  <div class="col-lg-12">
    <div class="">
      <div class="table-responsive">
        <table id="project-list-table" class="table project-list-table table-nowrap table-centered table-borderless">
          <thead>
            <tr>
              <th scope="col" style="width: 100px">#</th>
              <th scope="col">Reported User</th>
              <th scope="col">Reported By</th>
              <th scope="col">Reason</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($reports as $report)
            <tr>
              <td>{{$report->id}}</td>
              <td>
                <h5 class="text-truncate font-size-14">
                  <a href="#" class="text-dark">{{$report->freelancer->getFullName()}}</a>
                </h5>
              </td>
              <td>
                <h5 class="text-truncate font-size-14">
                  <a href="#" class="text-dark">{{$report->user->getFullName()}}</a>
                </h5>
              </td>
              <td>{{$report->reason}}</td>
              <td>
                <div>
                  @if($report->status != 1)
                  <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Ignore" class="btn btn-success rounded" onclick="deleteReport({{$report->id}})"><i class="bx bx-edit"></i>Ignore</a>
                  @endif
                  @if($report->status == 0)
                  <button class="btn btn-primary rounded" data-toggle="modal" data-placement="top" title="Block" onclick="blockUser({{$report->id}})"><i class="bx bx-block"></i>Block</button>
                  @else
                  <button class="btn btn-primary rounded" data-toggle="tooltip" data-placement="top" title="Action Taken"><i class="bx bx-block"></i>Action Taken</button>
                  @endif
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
          <p>Are you sure you want to ignore report request ?</p>
        </div>
        <div class="modal-footer">
          <button class="btn ripple btn-danger" id="confirmDelete" type="submit"> Delete </button>
          <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
        </div>
         </form>
      </div>
    </div>
  </div>

  <div class="modal" id="blockModel">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content modal-content-demo">
        <div class="modal-header">
          <h6 class="modal-title">Alert</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
        </div>
        <form id="blockData" > 
          @csrf
           @method('POST')
        <input type="hidden" name="user_id" id="user_id">
        <div class="modal-body">
          <h6></h6>
          <p>Are you sure you want to block this user ?</p>
        </div>
        <div class="modal-footer">
          <button class="btn ripple btn-danger" id="confirmBlock" type="submit"> Block </button>
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
            url: '/admin/reports/'+$projectId,
            type: 'DELETE',
            data: data,
            processData: false,

            success: (response)=>{
                
                if (response.status == 'true') {

                    $.notify(response.message , 'success'  );
                    window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/admin/reports";

                }else{
                    $.notify(response.message , 'error');

                }
            },
            error: (errorResponse)=>{
                $.notify( errorResponse, 'error'  );


            }
        })

      });


      $('#blockData').on('submit' , function(event){
        event.preventDefault();
        var data = $("#blockData").serialize();
        $user_id = $("#user_id").val();
        console.log($user_id)

           $.ajax({
            url: '/admin/block-user/'+$user_id,
            type: 'POST',
            data: data,
            processData: false,

            success: (response)=>{
                
                if (response.status == 'true') {

                    $.notify(response.message , 'success'  );
                    window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/admin/reports";

                }else{
                    $.notify(response.message , 'error');

                }
            },
            error: (errorResponse)=>{
                $.notify( errorResponse, 'error'  );


            }
        })

      });

    function deleteReport(id) {
      $("#deleteModel").modal('show');
      $("#projectId").val(id);
    }
    function blockUser(id) {
      $("#blockModel").modal('show');
      $("#user_id").val(id);
    }
</script>
@endsection