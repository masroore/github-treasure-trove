@extends('LMS.course_layout')


@section('title')
OSMS | LMS | Start Quiz
@endsection

@section('mtitle')
Start Quiz
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <!-- left column -->
  <div class="col-md-7 offset-2">
    <!-- general form elements -->
    <div class="card">
        <div class="card-header">
            <h5>{{$title}}</h5>
        </div>
        <div class="card-block">

            <form method="post" action="{{route('submit-exams')}}" id="formsubmit">
              @csrf

              <input type="hidden" name="ccode" value="{{$code}}">

              <input type="hidden" name="examsid" id="examsid" value="{{$examsid}}">

              <input type="hidden" name="examtotal" value="{{$examtot}}">

              <input type="hidden" name="jquey" id="jquey">

              <?php
              $loops = 1; 
              ?>

              @foreach($questions as $stuquestion)
              @php
              $qestion = \App\Question::where('id',$stuquestion->question_id)->first();
              @endphp

              <b>Question &nbsp;  {{$loops}} &nbsp;::<br />
                {{$qestion->question}}</b>
                <input type="hidden" name="que{{$loops}}" value="{{$qestion->id}}">
                
                <div class="form-group">
                    @php
                    $qestionoption = \App\QestionOption::where('question_id',$stuquestion->question_id)->get();
                    @endphp

                    @foreach($qestionoption as $options)
                    <div class="radio">
                      <label>
                        <input type="radio" name="ans{{$loops}}" value="{{$options->id}}" >
                        {{$options->option}}
                    </label>
                </div>

                @endforeach

            </div>

            <div class="form-group">
               <label class="control-label" for="inputError"></label>
           </div>

           <hr style="border: 1px solid #ccc;">
           <?php
           $loops++;
           ?>
           @endforeach

           <input type="submit" name="submitform" value="Submit" id="submitform" class="btn btn-success">

       </form> 

   </div>

   

</div>
</div>

</div> 

<div style="position: relative;">
   <div class="time">
       <h3 class="text-center"><span id="time">{{$mins}}</span></h3>
   </div> 
</div>


@endsection


@section('style')
<style type="text/css">
    .sticky {
        position: fixed;
        top: 0;
        box-shadow: 5px 10px #888888;
    }
    .time{
        border-radius: 50px;
        bottom: 30px;
        right: 20px;
        width: 200px;
        color:white;
        background: #3b98ff;
        padding: 12px 20px;
        text-transform: capitalize;
        font-weight: bold;
        font-size: 16px;
        position: fixed;
        -webkit-transition: all 0.5s ease;
        transition: all 0.5s ease;
        -webkit-animation: pulse 2s infinite;
        animation: pulse 2s infinite;
    }


    @-webkit-keyframes pulse {
        0% {
            -webkit-box-shadow: 0 0 0 0 rgba(59, 152, 255, 0.3);
            box-shadow: 0 0 0 0 rgba(59, 152, 255, 0.3)
        }
        70% {
            -webkit-box-shadow: 0 0 0 20px rgba(4, 169, 245, 0);
            box-shadow: 0 0 0 20px rgba(4, 169, 245, 0)
        }
        100% {
            -webkit-box-shadow: 0 0 0 0 rgba(4, 169, 245, 0);
            box-shadow: 0 0 0 0 rgba(4, 169, 245, 0)
        }
    }

    @keyframes pulse {
        0% {
            -webkit-box-shadow: 0 0 0 0 rgba(59, 152, 255, 0.3);
            box-shadow: 0 0 0 0 rgba(59, 152, 255, 0.3)
        }
        70% {
            -webkit-box-shadow: 0 0 0 20px rgba(4, 169, 245, 0);
            box-shadow: 0 0 0 20px rgba(4, 169, 245, 0)
        }
        100% {
            -webkit-box-shadow: 0 0 0 0 rgba(4, 169, 245, 0);
            box-shadow: 0 0 0 0 rgba(4, 169, 245, 0)
        }
    }

</style>
@endsection


@section('script')

<script type="text/javascript">
  $('document').ready(function(){

    $("#jquey").val('');

    function checkExamsStatus(){

    }

   function startTimer(duration, display) {

    var timer = duration;

    var myVar = setInterval(function () {

        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        localStorage.setItem("counter", minutes + ":" + seconds);

       // console.log(localStorage.getItem("counter"));

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            //timer = duration;
             clearInterval(myVar);
             submitform();
        }

    }, 1000);
}

window.onload = function () {
  
    var fiveMinutes = 60 * {{$mins}},
    display = document.querySelector('#time');

    if(localStorage.getItem("counter")){
      
      var counter = localStorage.getItem("counter");
      var splitcounter = counter.split(":");
      var minute = parseInt(splitcounter[0]);
      var second = parseInt(splitcounter[1]);
      var total = (minute*60)+second;

      startTimer(total, display);
      
    }else{
      
      startTimer(fiveMinutes, display);

    }


    
};


function submitform(){

  console.log('working..');

  $("#jquey").val('jquey');
  document.getElementById("submitform").click();

}


$(document).on("submit","#formsubmit",function(e){
    e.preventDefault();  
    var examsid = $("#examsid").val();
    var yes = '{{ route('lms-quiz-retry-score',['id' => $examsid, 'code' => $code]) }}';
    var no = '{{ route('lms-tests-quiz', ['code' => $code]) }}';     
    $.ajax({
      beforeSend: function(){
        $.LoadingOverlay("show");
      },
      complete: function(){
        $.LoadingOverlay("hide");
      },
      url: '{{route('submit-exams')}}',
      type: 'POST',
      contentType: false,
      processData: false,
      cache: false,
      data: new FormData(this),
      success: function(data){                        
        
        localStorage.removeItem("counter");
        
        if(data.match("Yes")){
          
          swal("Success! Procced To Try Examination Results!", {
              icon: "success",
          });

          window.location.href=yes;
        }else{

          swal("Success! Examination Finished Successfully!", {
              icon: "success",
          });

           window.location.href=no;
        }
        
      },
      error: function (data) {
        console.log('Error:', data.message);
        $("#msg").text(data.message).show();
      }
    });   

  });

//check back button
// window.onbeforeunload = function() { return "Your work will be lost."; };

});

</script>




{{-- <script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("timer");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script> --}}

@endsection