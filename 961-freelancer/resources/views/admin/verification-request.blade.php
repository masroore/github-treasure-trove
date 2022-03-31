@extends('admin.layouts.master')

@section('title') Verification List @endsection

@section('content')

    @component('admin.common-components.breadcrumb')
         @slot('title') Verification Request  @endslot
         @slot('li_1') Users @endslot
         @slot('li_2') Verification List @endslot
     @endcomponent


<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table id="user-lists" class="table table-centered table-nowrap table-hover">
            <thead class="thead-light">
              <tr>
                  <th scope="col" style="width: 70px;">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Country</th>
                  <th scope="col">Verification Image</th>
                  <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $key => $user)
              <tr>
                <td>
                  {{$key+1}}
                    <!-- <div class="avatar-xs">
                        <span class="avatar-title rounded-circle">
                            {{substr($user->first_name, 0, 1)}}
                        </span>
                    </div> -->
                </td>
                <td>
                    <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">{{$user->first_name}} {{$user->last_name}}</a></h5>
                    <!-- <p class="text-muted mb-0">{{$user->tagline}}</p> -->
                </td>
                <td>{{$user->email}}</td>
                <td>{{$user->country}}</td>
                <td>
                  <div>
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#exampleModal">
                      <img src="{{asset('assets/images/user/verification/'.$user->verification_image)}}" data-toggle="modal" data-target="#exampleModal" style="width: 150px;">
                    </a>
                  </div>
                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Verification Image</h5>
                          <button type="button" class="btn-close bg-transparent border-0" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                        </div>
                        <div class="modal-body">
                          <img class="modal-content" src="{{asset('assets/images/user/verification/'.$user->verification_image)}}" />
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
                
                <td>
                  <ul class="list-inline font-size-20 contact-links mb-0">
                    <li class="list-inline-item px-2">
                      <a href="javacript:void(0);" onclick="verifyUser({{$user->id}})" data-toggle="tooltip" data-placement="top" title="Verify"><i class="bx bx-check" style="font-size: 24px; font-weight: 600;"></i></a>
                    </li>
                    <li class="list-inline-item px-2">
                      <a href="javacript:void(0)" data-toggle="tooltip" onclick="rejectVerify({{$user->id}})"  data-placement="top" title="Reject"><i class="fa fa-times"></i></a>
                    </li>
                  </ul>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
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
        <button class="btn ripple btn-primary rounded" id="confirmDelete" type="submit"> Delete </button>
        <button class="btn ripple btn-success" data-dismiss="modal" type="button">Close</button>
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
      $('#user-lists').DataTable();
  });
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  
    $('#deleteData').on('submit' , function(event){
      event.preventDefault();
      var data = $("#deleteData").serialize();
      $projectId = $("#projectId").val();
      console.log($projectId)

      $.ajax({
        url: '/admin/users/'+$projectId,
        type: 'DELETE',
        data: data,
        processData: false,

        success: (response)=>{
            
            if (response.status == 'true') {

                $.notify(response.message , 'success'  );
                window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/admin/clients-list";

            }else{
                $.notify(response.message , 'error');

            }
        },
        error: (errorResponse)=>{
            $.notify( errorResponse, 'error'  );


        }
      })

    });

  function deleteClient(id) {
    $("#deleteModel").modal('show');
    $("#projectId").val(id);
  }  

  function verifyUser(id){
    $.ajax({
      url: '/admin/verify/'+id,
      type: 'POST',
      processData: false,

      success: (response)=>{
          
          if (response.status == 'true') {

              $.notify(response.message , 'success'  );
              window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/admin/verification-list";

          }else{
              $.notify(response.message , 'error');

          }
      },
      error: (errorResponse)=>{
          $.notify( errorResponse, 'error'  );


      }
    })
  }

  function rejectVerify(id){
    $.ajax({
      url: '/admin/reject-verify/'+id,
      type: 'POST',
      processData: false,

      success: (response)=>{
          
          if (response.status == 'true') {

              $.notify(response.message , 'success'  );
              window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/admin/verification-list";

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
