@extends('layouts.main')


@section('title')
OSMS | Promote Students
@endsection

@section('mtitle')
OSMS Promote Students
@endsection


@section('mtitlesub')

@endsection



@section('main_content')
@if (session()->has('message'))
<div class="alert alert-success alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <h4><i class="icon fa fa-warning"></i> Success!</h4>
  {{ session('message') }}
</div>
@endif

<div class="row">
  <div class="col-md-12">
    <div class="box box-primary table-responsive">
      <div class="box-header with-border">
        <h3 class="box-title">Promote Students</h3>
      </div>
      {{-- <table class="table table-bordered">
        <thead>
          <tr>
            <th>From</th>
            <th>To</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>

          
         <tr>
           <td>All Level 400</td>
           <td>Graduating</td>
           <td><a href="{{ route('400-to-graduating') }}" onclick="return confirm('Promote Now ?');" class="btn btn-info">Promote Now</a></td>
         </tr>

         <tr>
           <td>All Graduating Students</td>
           <td>Graduated</td>
           <td><a href="{{ route('graduating-to-graduated') }}" onclick="return confirm('Promote Now ?');" class="btn btn-info">Promote Now</a></td>
         </tr>


         <tr>
           <td>All Level 300</td>
           <td>Level 400</td>
           <td><a href="{{ route('300-to-400') }}" onclick="return confirm('Promote Now ?');" class="btn btn-info">Promote Now</a></td>
         </tr>

         <tr>
           <td>All Level 200</td>
           <td>Level 300</td>
           <td><a href="{{ route('200-to-300') }}" onclick="return confirm('Promote Now ?');" class="btn btn-info">Promote Now</a></td>
         </tr>

         <tr>
           <td>All Level 100</td>
           <td>Level 200</td>
           <td><a href="{{ route('100-to-200') }}" onclick="return confirm('Promote Now ?');" class="btn btn-info">Promote Now</a></td>
         </tr>
       </tbody>
     </table> --}}
     <div class="alert alert-info m-5">
       Click on the buttons Below to activate Student Promotion to the next level <br> or <br> Student Graduating For this Semester 
     </div>

     <a href="{{ route('100-to-200') }}" onclick="return confirm('Promote Now ?');" class="ml-5 my-5 btn btn-info">Promote Now</a>


     <a href="{{ route('200-to-300') }}" onclick="return confirm('Promote Now ?');" class="ml-5 my-5 btn btn-success">Activate Graduating Students</a>

   </div>

   <?php

   $studentinfo = App\Studentinfo::where('currentlevel','Level 400')
   ->where('type','Degree Programme')->get();

   foreach ($studentinfo as $student){
    $userid = $student->user_id;


    $creg = App\Coureregistration::where('user_id', $userid)
    ->where('indexnumber',$student->indexnumber)->get();

    $countall = count($creg);

    if ($countall > 0) {
      $i = 1;
      foreach($creg as $row){

        $array = ['D','F'];
        $grade = $row->grade;

        if (in_array($grade,$array)) {
          continue 2;
        }

        if ($i == $countall) {
            //get student gpa
          $cademicyear = App\Academicyear::where('status',1)->first();
          $academic = $cademicyear->acdemicyear;
          $semester = $cademicyear->semester;
          $gpa = App\Examresults::where('user_id',$userid)
          ->where('semester',$semester)
          ->where('year',$academic)->first();

          $grade = round($gpa->gpa,2);
          $GRAD = "x->ABSENT,Z->DISQUALIFIED,IC->INCOMPLETE,ADT->AUDITING";



          if (round($gpa->gpa,2) > 0 && round($gpa->gpa,2) <= 0.99) {
           $class = "Failed";
         }elseif (round($gpa->gpa,2) > 0.99 && round($gpa->gpa,2) <= 1.99) {
          $class = "Pass Student";
        }elseif (round($gpa->gpa,2) > 1.99 && round($gpa->gpa,2) <= 2.49) {
         $class = "Third Class Student";
       }elseif (round($gpa->gpa,2) > 2.49 && round($gpa->gpa,2) <= 2.99) {
         $class = "Second Class Lower Student";
       }elseif (round($gpa->gpa,2) > 2.99 && round($gpa->gpa,2) <= 3.59) {
        $class = "Second Class Upper Student";
      }elseif (round($gpa->gpa,2) > 3.59 && round($gpa->gpa,2) <= 4.00) {
       $class = "First Class Student";
     }








   }

   $i++;

 }
}

}




?>

</div>                 
</div>

@endsection


@section('script')

<script type="text/javascript">
  $('document').ready(function(){

    //start
    $(document).on("change",".checkit", function(e){
      e.preventDefault();
      var cid = $(this).attr("cid");
      var _token = $('meta[name=csrf-token]').attr('content');

      if ($(this).prop('checked')) {

        if (confirm("Confirm Academic Year Activation")) {
          $.ajax({
            url: '{{route('academic-year-update-status')}}',
            type: 'POST',
            data: {_token : _token , cid: cid, status: 1},
            dataType: 'json',
            success: function(data){
              if (data.msg) {
                alert(data.msg);
              }else{
                $("#error").text(data.error).show();
              }

            },
            error: function (data) {
              console.log('Error:', data);
              $("#msg").text(data.message).show();
            }
          });

        }


      }else{

        if (confirm("Confirm Academic Year Deactivation !")) {
          $.ajax({
            url: '{{route('academic-year-update-status')}}',
            type: 'POST',
            data: {_token : _token , cid: cid, status: 0},
            dataType: 'json',
            success: function(data){
              if (data.msg) {
                alert(data.msg);
              }else{
                $("#error").text(data.error).show();
              }

            },
            error: function (data) {
              console.log('Error:', data);
              $("#msg").text(data.message).show();
            }
          });

        }

      }


    });
    //end

  });

</script>


@endsection
