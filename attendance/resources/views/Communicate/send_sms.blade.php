@extends('layouts.main')


@section('title')
  OSMS | Send SMS
@endsection

@section('mtitle')
  Send SMS
@endsection


@section('mtitlesub')
  
@endsection



@section('main_content')


<div class="clearfix" style="background-color: #fff;padding: 20px;">
<div class="row">
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Compose New Message</h3>
      </div>
      <div class="box-body">
        <form method="post" action="{{ route('send_sms_now') }}" enctype="multipart/form-data" id="smssubmit">
            @csrf
          <div class="form-group compose-textarea">
            <textarea name="html" id="compose-textarea" class="form-control" placeholder="TYPE MESSAGE HERE" rows="4" cols="5"></textarea>
    </div>
    <div class="form-group">
      <div class="btn btn-default btn-file">
        <i class="fas fa-paperclip"></i> Attachment
        <input type="file" name="pdffile" id="attachment">
    </div>
    <p class="help-block">Max. 32MB</p>
</div>



</div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Send To</h3>
      </div>
      <div class="box-body">
         <div class="form-group sendto"> 
             <select class="form-control" name="sendto" id="sendto">
                 <option></option>
                 <option value="0">All Students</option>
                 <option value="1">All Admitted Students</option>
                 <option value="2">Session</option>
                 <option value="3">All Lecturers</option>
                 {{-- <option value="4">All Staff</option> --}}
                 <option value="5">Individual</option>
             </select>
         </div>

         <div class="form-group peremail" style="display: none;"> 
             <select class="form-control" id="level" name="level">
                 <option>Level</option>
                 <option value="0">Level 100</option>
                 <option value="1">Level 200</option>
                 <option value="2">Level 300</option>
                 <option value="3">Level 400</option>
             </select>
         </div>


         <div class="form-group peremail" style="display: none;"> 
             <select class="form-control" id="session" name="session">
                 <option>Session</option>
                 <option value="0">Morning Session</option>
                 <option value="1">Evening Session</option>
                 <option value="2">Weekend Session</option>
             </select>
         </div>

         <div class="form-group peremail" style="display: none;">
             <select class="form-control" id="program" name="program">
                 <option>Programme</option>
                 @foreach($program as $progs)
                    <option value="{{$progs->name}}">{{$progs->name}}</option>
                 @endforeach
             </select>
         </div>

         <div class="form-group @error('phonenumber') has-error @enderror" id="peremail" style="display: none;">
             <input type="text" name="phonenumber" value="{{old('phonenumber')}}" id="eperemail" class="form-control" placeholder="Enter Phone Number">
         </div>

      </div>
    </div>
  </div>                 
</div>
<button type="submit" id="sendmail" class="btn btn-primary pull-right"><i class="far fa-envelope"></i> Send</button>

</form>

</div>


@endsection





@section('script')

    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on("change","#sendto", function(e){
                e.preventDefault();
                var sendto = $(this).val();
                
                if(sendto == '2'){
                    $(".peremail").show('slow/400/fast', function() {
                        
                    });

                     $("#peremail").hide('slow/400/fast', function() {
                        
                    });
                }

                if(sendto == '5'){
                    $("#peremail").show('slow/400/fast', function() {
                        
                    });

                    $(".peremail").hide('slow/400/fast', function() {
                        
                    });
                }


                if(sendto == '0' || sendto == '1' || sendto == '3' || sendto == '4' ){
                    $("#peremail").hide('slow/400/fast', function() {
                        
                    });

                    $(".peremail").hide('slow/400/fast', function() {
                        
                    });
                }




            });



            $(document).on("submit","#smssubmit", function(e){
                e.preventDefault();
                var html = $("#compose-textarea").val();
                var sendto = $("#sendto").val();
                var _token = $('meta[name=csrf-token]').attr('content');
                var level = $("#level").val();
                var session = $("#session").val();
                var program = $("#program").val();
                var eperemail = $("#eperemail").val();



                if(html == ""){
                    swal("Sms Text Cant Be Empty", {
                            icon: "warning",
                    });
                    $(".compose-textarea").addClass('has-error');
                    return;
                }else{
                	$(".compose-textarea").addClass('has-success');
                }


                if(sendto == ""){
                    swal("Sms Sendto Cant Be Empty", {
                            icon: "warning",
                    });
                    $(".sendto").addClass('has-error');
                    return;
                }else{
                    $(".sendto").removeClass('has-error').addClass('has-success');
                }


                $.ajax({
                    beforeSend: function(){
                      $.LoadingOverlay("show");
                    },
                    complete: function(){
                      $.LoadingOverlay("hide");
                    },
                    url: '{{route('send_sms_now')}}',
                    type: 'POST',
                    data: $("form").serialize(),
                    success: function(data){ 

                       swal("Sms Sent Successfully!", {
                            icon: "success",
                       });
                    },
                      error: function (data) {
                        console.log('Error:', data);
                      }
                });    



            });












        });
    </script>

@endsection
