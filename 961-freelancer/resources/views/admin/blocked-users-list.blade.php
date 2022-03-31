@extends('admin.layouts.master')

@section('title') Freelancers List @endsection

@section('content')

    @component('admin.common-components.breadcrumb')
         @slot('title') Freelancers List  @endslot
         @slot('li_1') Users @endslot
         @slot('li_2') Freelancers List @endslot
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
                  <th scope="col">Account Type</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($blockedusers as $key => $freelancer)
              <tr>
                <td>
                  {{$key+1}}
                    <!-- <div class="avatar-xs">
                        <span class="avatar-title rounded-circle">
                            {{substr($freelancer->first_name, 0, 1)}}
                        </span>
                    </div> -->
                </td>
                <td>
                    <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">{{$freelancer->first_name}} {{$freelancer->last_name}}</a></h5>
                    <p class="text-muted mb-0">{{$freelancer->tagline}}</p>
                </td>
                <td>{{$freelancer->email}}</td>
                <td>{{$freelancer->country}}</td>
                <td>{{$freelancer->account_type}}</td>
                <td>
                  @if($freelancer->status == 'block')
                    Block
                  @endif
                </td>
                <td>
                  <ul class="list-inline font-size-20 contact-links mb-0">
                    <li class="list-inline-item px-2">
                      <a href="javascript:void(0);" class="btn btn-success text-white" data-toggle="tooltip" data-placement="top" title="Unblock" onclick="unblockUser({{$freelancer->id}})"><i class="bx bx-edit"></i>Unblock</a>
                    </li>
                    <!-- <li class="list-inline-item px-2">
                      <a href="" class="btn btn-primary text-white rounded" data-toggle="modal" onclick="deleteFreelancer({{$freelancer->id}})" data-placement="top" title="Delete"><i class="bx bx-block"></i>Unblock</a>
                    </li> -->
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
    } );
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      function unblockUser(id){
        // alert(id);
       
           $.ajax({
            url: '/admin/unblock-users/'+id,
            type: 'POST',
            processData: false,

            success: (response)=>{
                
                if (response.status == 'true') {

                    $.notify(response.message , 'success'  );
                    window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/admin/freelancers-list";

                }else{
                    $.notify(response.message , 'error');

                }
            },
            error: (errorResponse)=>{
                $.notify( errorResponse, 'error'  );


            }
        })

      }

    function deleteFreelancer(id) {
      $("#deleteModel").modal('show');
      $("#projectId").val(id);
    }
</script>
@endsection
