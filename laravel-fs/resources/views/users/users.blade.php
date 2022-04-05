<div class="content-table">
    <h3>{{ __('Users') }}</h3>

        <a class="btn btn-primary title new link_ajax"  data-dataType="html" href="{{route('users.create')}}"> {{ __('New') }} </a>
<table class="dataTable table" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th scope='col'>{{__('Avatar')}}</th>
            <th scope='col'>{{__('Full Name')}}</th>
            <th scope='col'>{{__('Profile')}}</th>
            <th scope='col'>{{__('E-mail')}}</th>
            <th scope='col'>{{__('Actions')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $key => $value)
        <tr>
            <td><img style="max-width:50px" alt="avatar" class="img-fluid img-thumbnail" src="{{asset('avatar/'.$value['avatar'])}}" /></td>
            <td>{{textUpper($value['name_user'].' '.$value['surname_user'])}}</td>
            <td>{{textUpper($value['profile']['name_profile'])}}</td>
            <td>{{textUpper($value['email'])}}</td>
			
            @if($value['locked'] == 0)
                @if($value['id'] == Auth::user()->id)  
                <td> 
                    <a class="btn btn-moderation edit link_ajax" data-dataType = "html" href="{{route('users.edit',$value['crypt_id'])}}"><i class="fa fa-pen"></i> {{ __('Edit') }} </a>                    
                </td>
                @else  
                 @if($value['suspended'] == true)
                    <td>{{ Form::button('<i class="fas fa-lock"></i>'.' '.__('Remove Suspension'), ['class' => 'btn btn-moderation delete lock', 'data-bs-toggle'=>'modal', 'data-bs-target'=>'#modalBlock','onClick'=>"readData('".$value['crypt_id']."')"]) }}</td>
                      @else                     
                    <td> 
                        <a class="btn btn-moderation edit link_ajax" data-dataType = "html" href="{{route('users.edit',$value['crypt_id'])}}"><i class="fa fa-pen"></i> {{ __('Edit') }} </a>
                      
                        {{ Form::button('<i class="fas fa-lock"></i>'.' '.__('Block - Suspend'), ['class' => 'btn btn-moderation delete lock', 'data-bs-toggle'=>'modal', 'data-bs-target'=>'#modalBlock','onClick'=>"readData('".$value['crypt_id']."')"]) }}

                        <a class="btn btn-moderation active link_ajax" data-dataType = "json" href="{{route('users.reset_password',$value['crypt_id'])}}"><i class="fas fa-history"></i> {{ __('Reset Password') }} </a>
                    </td> 
                    @endif
                @endif             
            @else
            <td> 
                <a class="btn btn-moderation active link_ajax" data-dataType = "json" href="{{route('users.unlock_user',$value['crypt_id'])}}"><i class="fas fa-lock-open"></i> {{ __('Unlock') }} </a>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<!-- Modal -->
<div class="modal fade" id="modalBlock" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close-modal" data-bs-dismiss="modal">
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="content-space">

                <div class="content-table inside">

                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{__('Block or suspend user')}}</h5>
                    </div>
                    <div id="bodyModal1" class="modal-body">
                        ...
                    </div>
         
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
});
    

    function readData(id){
        $.get("{{url('U0001.show_modal')}}/"+id,function(response){
            $("#bodyModal1").html(response);
            /*Swal.fire(
                data['title'],
                data['message'],
                data['type_message'],
            );
            if(data['status']==1){
                sendAjax(data['redirect']);
            }*/
        });
        
    }
</script>