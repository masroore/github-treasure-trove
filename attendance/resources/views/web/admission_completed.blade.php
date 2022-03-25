@extends('web.layouts.web_layout')


@section('title', 'Oguses IT Solutions | Purchase OSN Code')

@section('addcss')
<link rel="stylesheet" href="{{URL::to('css/bootstrap.min.css')}}">
@endsection

@section('content')
<!-- banner -->
<div class="banner-agile-2">
  @include('web.layouts.admsion_nav')
</div>

@include('web.layouts.breadcrumb')
<!-- //banner -->

<!-- admission form -->
<div class="form-w3l py-5">
  <div class="container py-xl-5 py-lg-3">

   <!--- Admision Control Condition Here ---->

   @if($personal->approve)
   <h3 class="title text-capitalize font-weight-light text-dark text-center mb-5">
    <span class="font-weight-bold">Congratulations</span>
  </h3>
  @else

  <h3 class="title text-capitalize font-weight-light text-dark text-center mb-5">Admission
    <span class="font-weight-bold">form Completed</span>
  </h3>
  @endif

  <div class="register-form pt-md-4">
    <div class="col-md-10 col-md-offset-2 well">
      @if($personal->approve)
      <legend>Student Information</legend>
      @else
      <legend>Application Summary</legend>
      @endif

      <div class="row">
       <div class="col-md-4">
        <img src="{{asset('storage')}}/{{$personal->profileimg}}" height="200" width="200" id="imgs" class="img-thumbnail">
      </div>
      <div class="col-md-8">

        <div class="box-body">
         <table class="table table-bordered table-striped">
           <thead>
             <tr>
               @if($personal->approve)
               <th colspan="2">Student Information</th>
               @else
               <th colspan="2">Personnal Information</th>
               @endif

             </tr>
           </thead>
           <tbody>
            <tr>
             <td>Fullname</td>
             <td>{{$personal->surname}} {{$personal->firstnames}} {{$personal->middlename}}</td>
           </tr>
           <tr>
             <td>Date of birth</td>
             <td>{{$personal->dateofbirth}}</td>
           </tr>
           <tr>
             <td>Religion</td>
             <td>{{$personal->religion}}</td>
           </tr>
           <tr>
             <td>Place of birth</td>
             <td>{{$personal->placeofbirth}}</td>
           </tr>
           <td>Denomination</td>
           <td>{{$personal->denomination}}</td>
         </tr>
         <td>Nationality</td>
         <td>{{$personal->nationality}}</td>
       </tr>
       <td>Hometown</td>
       <td>{{$personal->hometown}}</td>
     </tr>
     <td>Region</td>
     <td>{{$personal->region}}</td>
   </tr>
   <td>Disabled</td>
   <td>{{$personal->disability}}</td>
 </tr>
 <td>Postal Address</td>
 <td>{{$personal->address}}</td>
</tr>
<td>Email</td>
<td>{{$personal->email}}</td>
</tr>
<td>Phone</td>
<td>{{$personal->phone}}</td>
</tr>
<td>Marital Status</td>
<td>{{$personal->maritalstutus}}</td>
</tr>
<tr>


  @if($personal->approve)
  <td colspan="2"><b> Admission Information </b></td>
  @else
  <td colspan="2"><b> Application Information </b></td>
  @endif
</tr>
<tr>
 <td>Entry Level</td>
 <td>{{$appinfo->entrylevel}}</td>
</tr>
<tr>
 <td>Session</td>
 <td>{{$appinfo->session}}</td>
</tr>

@if($personal->approve)

<tr>
  <td>Programme Type</td>
  <td>{{$appinfo->type}}</td>
</tr>

<tr>
  <td>Programme Offered</td>
  <td>{{$appinfo->programme}}</td>
</tr>

@else
<tr>
 <td>First Choice</td>
 <td>{{$appinfo->firstchoice}}</td>
</tr>
<tr>
 <td>Second Choice</td>
 <td>{{$appinfo->secondchoice}}</td>
</tr>
<tr>
 <td>Third Choice</td>
 <td>{{$appinfo->thirdchoice}}</td>
</tr>
@endif
<tr>
 <td>Index Number</td>
 <td>{{$appinfo->indexnumber}}</td>
</tr>
</tbody>
</table>
</div>


</div>
</div>

@if($personal->approve)
<a href="{{$file}}" target="_blank" class="btn btn-success pull-right" id="" style="">Print Admission Hand book</a>
@else
<a href="{{route('admission-completed-print')}}" target="_blank" class="btn btn-success pull-right" id="" style="">Print</a>

@endif
</div>	
</div>

<!--- Admision Control Condition Here ---->
</div>
</div>
   <!-- admission form -->


   @endsection