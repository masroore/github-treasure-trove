@extends('layouts.main')


@section('title')
Graduating List
@endsection

@section('mtitle')
Graduating List
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <!-- left column -->
  <div class="col-md-12">

    <a href="{{ route('graduating_list') }}" class="btn btn-success">&larr;</a>

    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Graduating List</h3>
      </div>
      <div class="box-body">

        @if ($type == 'Degree Programme')


        <table class="table table-bordered">
         <thead>
           <tr class="text-center">
             <td colspan="3"> <h1 style="font-size: 25px;">
               GRADUATING LIST <br>
               ACADEMIC YEAR - {{$academicyear}} <br>
               PROGRAMME - <?php echo strtoupper($prog);?> <br>
               SESSION - <?php echo strtoupper($session);?> </h1>
             </td>
           </tr>
         </thead>
         <tbody>

          <tr bgcolor="#ccc">
           <td colspan="3">First Class</td>
         </tr>
         @foreach ($graduation as $row)
         @if (trim($row->graduatingclas) == 'First Class')
         <tr>
          <td></td>
          <td colspan="2">{{$row->fullname}}</td>
        </tr>
        @endif
        @endforeach

        <tr bgcolor="#ccc">
         <td colspan="3">Second Class Upper</td>
       </tr>
       @foreach ($graduation as $row)
       @if (trim($row->graduatingclas) == 'Second Class Upper')
       <tr>
        <td></td>
        <td colspan="2">{{$row->fullname}}</td>
      </tr>
      @endif
      @endforeach


      <tr bgcolor="#ccc">
       <td colspan="3">Second Class Lower</td>
     </tr>
     @foreach ($graduation as $row)
     @if (trim($row->graduatingclas) == 'Second Class Lower')
     <tr>
      <td></td>
      <td colspan="2">{{$row->fullname}}</td>
    </tr>
    @endif
    @endforeach


    <tr bgcolor="#ccc">
     <td colspan="3">Third Class</td>
   </tr>
   @foreach ($graduation as $row)
   @if (trim($row->graduatingclas) == 'Third Class')
   <tr>
    <td></td>
    <td colspan="2">{{$row->fullname}}</td>
  </tr>
  @endif
  @endforeach


  <tr bgcolor="#ccc">
   <td colspan="3">Pass</td>
 </tr>
 @foreach ($graduation as $row)
 @if (trim($row->graduatingclas) == 'Pass')
 <tr>
  <td></td>
  <td colspan="2">{{$row->fullname}}</td>
</tr>
@endif
@endforeach



</tbody>
</table>'


{{-- the above code is degree --}}
@else


<table class="table table-bordered">
 <thead>
   <tr class="text-center">
     <td colspan="3"> <h1 style="font-size: 25px;">
       GRADUATING LIST <br>
       ACADEMIC YEAR - {{$academicyear}} <br>
       PROGRAMME - <?php echo strtoupper($prog);?> <br>
       SESSION - <?php echo strtoupper($session);?> </h1>
     </td>
   </tr>
 </thead>
 <tbody>

  <tr bgcolor="#ccc">
   <td colspan="3">Distinction</td>
 </tr>
 @foreach ($graduation as $row)
 @if (trim($row->graduatingclas) == 'Distinction')
 <tr>
  <td></td>
  <td colspan="2">{{$row->fullname}}</td>
</tr>
@endif
@endforeach

<tr bgcolor="#ccc">
 <td colspan="3">Credit</td>
</tr>
@foreach ($graduation as $row)
@if (trim($row->graduatingclas) == 'Credit')
<tr>
  <td></td>
  <td colspan="2">{{$row->fullname}}</td>
</tr>
@endif
@endforeach


<tr bgcolor="#ccc">
 <td colspan="3">Pass</td>
</tr>
@foreach ($graduation as $row)
@if (trim($row->graduatingclas) == 'Pass')
<tr>
  <td></td>
  <td colspan="2">{{$row->fullname}}</td>
</tr>
@endif
@endforeach


<tr bgcolor="#ccc">
 <td colspan="3">Failed</td>
</tr>
@foreach ($graduation as $row)
@if (trim($row->graduatingclas) == 'Failed')
<tr>
  <td></td>
  <td colspan="2">{{$row->fullname}}</td>
</tr>
@endif
@endforeach



</tbody>
</table>'


@endif


</div>
</div>
</div>
</div>
@endsection

@section('script')

<script type="text/javascript">
  $('document').ready(function(){


  });

</script>


@endsection