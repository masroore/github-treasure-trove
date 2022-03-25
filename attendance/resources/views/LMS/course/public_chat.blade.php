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
                <div class="user-wrapper">
                    <ul class="users">
                      @foreach($grp as $grp)
                      <?php
                      $index = $grp->indexnumber;

                      $user = App\User::where('indexnumber',$index)->first();
                      ?>

                      @if ($user)

                      <li class="user" id="{{ $user->id }}">
                        {{--will show unread count notification--}}
                        <span class="useractive"></span>
                        <div class="media">
                          <div class="media-left">
                            <img src="{{ asset('storage') }}/{{$user->pro_pic}}" alt="" class="media-object" style="display: block; height: 50px; width: 50px;">
                        </div>

                        <div class="media-body">
                            <p class="name">{{ $user->name }}</p>
                            <p class="email">{{ $user->indexnumber }}</p>
                        </div>
                    </div>
                </li>

                @endif

                @endforeach
            </ul>
        </div>

    </div>
</div>
</div>
<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            <h5>Total <span data-toggle="tooltip" title="3 New Messages" class="badge bg-light-blue"><?php echo count($messages); ?></span> </h5>
        </div>
        <div class="card-block">

          <!-- /.box-header -->
          <div class="box-body">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages" style="height: 540px;" id="chatcntainer">  
              <!-- Message. Default to the left -->



              @foreach ($messages as $row => $value)

              <?php $today = date('d-M-Y'); ?>

              <div style="margin: auto; width:200px; padding: 5px;">
                <h4 class="text-center" style="background-color: #aaa;padding:5px;border-radius: 50px;width: 200px;font-size: 20px;"> 
                  @if ($today == $row)
                  Today
                  @else
                  {{$row}}
                  @endif 
              </h4>
          </div>

          <div class="clearfix"></div>


          @foreach ($messages[$row] as $msg)
          {{-- expr --}}

          <?php 
          $user = App\User::where('id',$msg['from'])->first();
          ?>

          <?php
          if($msg['filetype'] == 'image'){

            if ($msg['from'] == auth()->user()->id) {
              ?>
              <div class="attachment" style="padding: 10px;margin-left: 400px;">
                <div class="pull-right" style="margin-bottom: 30px;">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left">{{$user->name}}</span>
                    <span class="direct-chat-timestamp pull-right">{{\Carbon\Carbon::parse($msg['created_at'])->diffForHumans()}}</span>
                </div>
                <div style="height: 100px; width: 100px;">
                    <p>Attachement</p>
                    <img src="{{ asset('storage') }}/{{$msg['file']}}" alt="Attachment" width="100" height="100">
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="direct-chat-msg">

              <div class="direct-chat-text" style="background-color: #3c8dbc; color: white;">
                {{$msg['message']}}
            </div>
        </div>
    </div>
    <?php
}else{
  ?>
  <div class="attachment" style="padding: 10px;">
    <div class="pull-righs" style="margin-bottom: 30px;">
      <div class="direct-chat-info clearfix">
        <span class="direct-chat-name pull-left">{{$user->name}}</span>
        <span class="direct-chat-timestamp pull-left">{{\Carbon\Carbon::parse($msg['created_at'])->diffForHumans()}}</span>
    </div>
    <div style="height: 100px; width: 100px;">
        <p>Attachement</p>
        <img src="{{ asset('storage') }}/{{$msg['file']}}" alt="Attachment" width="100" height="100">
    </div>
</div>
<div class="clearfix"></div>

<div class="direct-chat-msg">
  <div class="direct-chat-text" 
  >
  {{$msg['message']}}
</div>
</div>
</div>
<?php
}
}else if($msg['filetype'] == 'doc'){
  if ($msg['from']  == auth()->user()->id) {
    ?>
    <div class="attachment" style="margin-top: 50px;margin-left: 400px;">
      <div class="pull-right">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-left">{{$user->name}}</span>
          <span class="direct-chat-timestamp pull-left">{{\Carbon\Carbon::parse($msg['created_at'])->diffForHumans()}}</span>
      </div>
      <div>
          <p>Attachement</p>
          <img src="{{ URL::to('images/doc.jpg') }}" alt="Attachment" width="100" height="100">
          <a href="{{ asset('storage') }}/{{$msg['file']}}" target="_blank" class="fa fa-download btn btn-primary"></a>
      </div>
  </div>
  <div class="clearfix"></div>

  <div class="direct-chat-msg" >

    <div class="direct-chat-text" style="background-color: #3c8dbc; color: white;">
      {{$msg['message']}}
  </div>
</div>
</div>


<?php
}else{
    ?>
    <div class="attachment" style="padding: 10px;">
      <div class="pull-righs">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-left">{{$user->name}}</span>
          <span class="direct-chat-timestamp pull-right">{{\Carbon\Carbon::parse($msg['created_at'])->diffForHumans()}}</span>
      </div>
      <div>
          <p>Attachement</p>
          <img src="{{ URL::to('images/doc.jpg') }}" alt="Attachment" width="100" height="100">
          <a href="{{ asset('storage') }}/{{$msg['file']}}" target="_blank" class="fa fa-download btn btn-primary"></a>
      </div>
      <div class="clearfix"></div>

      <div class="direct-chat-msg ">
          <div class="direct-chat-text" 
          style="background-color: #d2d6de;color:black;">
          {{$msg['message']}}
      </div>
  </div>
</div>
</div>
<?php
}
}else{
    if ($msg['from'] == auth()->user()->id) {
      ?>
      <div class="direct-chat-msg right">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-right">{{$user->name}}</span>
          <span class="direct-chat-timestamp pull-left">{{\Carbon\Carbon::parse($msg['created_at'])->diffForHumans()}}</span>
      </div>
      <!-- /.direct-chat-info -->
      <img class="direct-chat-img" src="{{ asset('storage') }}/{{Auth::user()->pro_pic}}" alt="Message User Image"><!-- /.direct-chat-img -->
      <div class="direct-chat-text">
          {{$msg['message']}}
      </div>
      <!-- /.direct-chat-text -->
  </div>
  <!-- /.direct-chat-msg -->
  <?php
}else{
  ?>
  <div class="direct-chat-msg">
    <div class="direct-chat-info clearfix">
      <span class="direct-chat-name pull-left">{{$user->name}}</span>
      <span class="direct-chat-timestamp pull-right">{{\Carbon\Carbon::parse($msg['created_at'])->diffForHumans()}}</span>
  </div>
  <!-- /.direct-chat-info -->
  <img class="direct-chat-img" src="{{ asset('storage') }}/{{$user->pro_pic}}" alt="Message User Image">
  <div class="direct-chat-text">
      {{$msg['message']}}
  </div>
  <!-- /.direct-chat-text -->
</div>
<!-- /.direct-chat-msg -->
<?php
}
}

?>
@endforeach
@endforeach


<!--- Attachement -->






<!--- End Attachement -->







<!--/.direct-chat-messages-->
</div>
<!-- /.box-body -->
<div class="box-footer">
    <form action="{{ route('public_chat_save') }}"  method="POST" enctype="multipart/form-data" id="sendchat">
      @csrf
      <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}"/>
      <input type="hidden" name="code" id="code" value="{{$code}}">
      <input type="hidden" name="lectid" id="lectid" value="{{$lectid}}">
      <input type="hidden" name="lecname" id="lecname" value="{{$lecname}}">
      <input type="file" name="file" id="file" style="display: none;">
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

              $.ajax({
                beforeSend: function(){
                  $.LoadingOverlay("show");
                },
                complete: function(){
                  $.LoadingOverlay("hide");
                },
                url: '{{ route('public_chat_save') }}',
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

                  // if(message.type == 'public'){

                  //   if(message.user_id == $("#user_id").val()){
                  //     $("#chatcntainer").append(message.right);
                  //     scrollToBottomFunc();
                  //   }else{
                  //     $("#chatcntainer").append(message.left);
                  //     scrollToBottomFunc();
                  //   }
                  
                  // }
                  
                  if(message.code == '{{$code}}' && message.lectid == $("#lectid").val()){

                    if(message.user_id == $("#user_id").val()){
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



           });
         </script>

         @endsection