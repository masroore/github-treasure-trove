@extends('LMS.course_layout')


@section('title')
OSMS | LMS | Public Chat
@endsection

@section('mtitle')
Public Chat
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5>Title</h5>
      </div>
      <div class="card-block">

      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-md-3">
    <div class="card">
      <div class="card-header">
        <h5>Online Users</h5>
      </div>
      <div class="card-block">
        <div class="user-wrapper" style="height: 100px;">
          <ul class="users">
            @hasanyrole('Student')

            <?php

            $index = $lectureid;
            
            $user = App\Staff::where('user_id',$index)->first();

            $online = App\User::where('id',$user->user_id)->first();
            ?>

            <li class="user" id="{{ $user->user_id }}">
              {{--will show unread count notification--}}
              <span class="pendings"></span>
              @if ($online->is_active == '1')
              <span class="useractive"></span>
              @else
              
              @endif
              <div class="media">
                <div class="media-left">
                  <img src="{{ asset('storage') }}/{{$user->getimage($user->user_id)}}" alt="" class="media-object" style="display: block; height: 50px; width: 50px;">
                </div>

                <?php
                  $count = App\Chatcount::where('from', $user->user_id)
                  ->where('to',auth()->user()->id)->first();
                ?>

                <div class="media-body">
                  <p class="name"><b>{{ $user->fullname }}</b> 
                    @if ($count)
                      <?php
                        $ccnt = $count->count;
                      ?>
                      @if ($ccnt > 0)
                        <span id="remove_{{$user->user_id}}" class="pull-right badge badge-danger">{{$count->count}}</span>
                      @endif
                      
                    @endif
                 </p>
                  <p class="email">{{ $user->role }}</p>
                  <p class="email">{{ $user->faculty }}</p>
                </div>
              </div>
            </li>

            @endhasanyrole

          </ul>
        </div>

      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="card">
      <div class="card-header">
        {{-- <h5>Total <span data-toggle="tooltip" title="3 New Messages" class="badge bg-light-blue"><?php echo count($messages); ?></span> </h5> --}}
      </div>
      <div class="card-block">

        <!-- /.box-header -->
        <div class="box-body">
          <!-- Conversations are loaded here -->
          <div class="direct-chat-messages" style="height: 600px;" id="chatcntainer">  
            <!-- Message. Default to the left -->
            <div class="alert alert-info">Select Chat To Continue</div>

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <form action="{{ route('private_chat_save') }}"  method="POST" enctype="multipart/form-data" id="sendchat">
          @csrf
          <input type="hidden" name="user_id" id="user_id" />
          <input type="hidden" name="my_id" id="my_id" value="{{auth()->user()->id}}" />
          <input type="file" name="file" id="file" / style="display: none;">
          <div class="input-group">
            <input type="text" name="message" id="message" placeholder="Type Message ..." class="form-control" required>
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary btn-flat">Send</button>
            </span>

            &nbsp;
            <span class="input-group-btn">
              <a href="#" class="btn btn-default fileget"><i class="fa fa-ils"> </i> </a>
            </span>
          </div>
        </form>
      </div>
      <!-- /.box-footer-->
    </div>
    <!--/.direct-chat -->


  </div>
</div>
</div>
</div>



@endsection



@section('script')

<script type="text/javascript">
  $(document).ready(function() {

    var socket = io("http://127.0.0.1:3000");

           //Enable pusher logging - don't include this in production

           scrollToBottomFunc();

           $(document).on("submit","#sendchat",function(e){
            e.preventDefault();
            var textmesage = $("#message").val();
            var user = $("#user_id").val();
            var urid = '{{auth()->user()->id}}';

            $.ajax({
              beforeSend: function(){
                $.LoadingOverlay("show");
              },
              complete: function(){
                $.LoadingOverlay("hide");
              },
              url: '{{ route('private_chat_save') }}',
              type: 'POST',
              contentType: false,
              processData: false,
              cache: false,
              dataType: 'json',
              data: new FormData(this),
              success: function(data){

                if(data.success){

                  socket.emit("sendchatToServer",data);
                  $("#message").val("");

                }else{

                  swal("File Supports Extensions are doc, png, jpeg, txt, docx, pdf!", {
                    icon: "error",
                  });
                  $("#message").val("");

                }
                // $("#thisishere").html(data);
                // return;
                

              },
              error: function (data) {
                console.log('Error:', data);
                $("#msg").text(data.message).show();
              }
              
            }); 

          });  

           socket.on("serverchatToClient", function(message){

            if(message.from == $("#my_id").val() && message.to == $("#user_id").val() || message.from == $("#user_id").val() && message.to == $("#my_id").val()){

              if(message.from == $("#my_id").val()){
                $("#chatcntainer").append(message.right);
                scrollToBottomFunc();
              }else{
                $("#chatcntainer").append(message.left);
                scrollToBottomFunc();
              }

            }

          });


              // make a function to scroll down auto
              function scrollToBottomFunc() {
                $('#chatcntainer').animate({
                  scrollTop: $('#chatcntainer').get(0).scrollHeight
                }, 50);
              }


              $(document).on("click",".fileget", function(e){
                e.preventDefault();
                $("#file").click();

              });



              $(document).on("click",".user",function(e){
                e.preventDefault();
                $(".user").removeClass('addhover');
                $(this).addClass('addhover');
                var id = $(this).attr('id');
                $("#user_id").val(id);
                $("#remove_"+id).remove();
                var _token = $('meta[name=csrf-token]').attr('content'); 

                $.ajax({

                  beforeSend: function(){
                    $.LoadingOverlay("show");
                  },
                  complete: function(){
                    $.LoadingOverlay("hide");
                  },

                  url: '{{route('private_chat_get_messages')}}',
                  type: 'POST',
                  data: {_token : _token , id: id},
                  success: function(data){ 

                    $("#chatcntainer").html(data);

                  },
                  error: function (data) {
                    console.log('Error:', data);
                  }
                }); 


              });



            });
          </script>

          @endsection