@extends('layouts.main')


@section('title')
OSMS | Academic Calendar
@endsection

@section('mtitle')
OSMS Academic Calendar
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <div class="col-md-3">
    <div class="box box-primary">
      <div class="box-body">
        <div class="card-header">
          <h5>Edit Events</h5>
        </div>
        <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
          <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
          <ul class="fc-color-picker" id="color-chooser">
            <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
          </ul>
        </div>
        <!-- /btn-group -->

        <input type="hidden" id="hiddenid" name="hiddenid" value="{{$data->id}}">
        <div class="form-group">
          <input id="new-event" type="text" value="{{$data->title}}" class="form-control" placeholder="Event Title">
        </div>
        <label>Start Date</label>
        <div class="form-group">
          <input id="new-date" type="date" value="{{$data->startdate}}" class="form-control" >
        </div>
        <label>End Date</label>
        <div class="form-group">
          <input id="end-date" type="date" value="{{$data->enddate}}" class="form-control" placeholder="End">

        </div>
        <div class="input-group-btn">
          <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Save</button>
        </div>

      </div>
    </div>
  </div>

</div>         

@endsection


@section('style')

<!-- fullCalendar -->
<link rel="stylesheet" href="{{ URL::to('bower_components/fullcalendar/dist/fullcalendar.min.css')}}">
<link rel="stylesheet" href="{{ URL::to('bower_components/fullcalendar/dist/fullcalendar.print.min.css')}}" media="print">

@endsection


@section('script')

<!-- fullCalendar -->
<script src="{{ URL::to('bower_components/moment/moment.js')}}"></script>
<script src="{{ URL::to('bower_components/fullcalendar/dist/fullcalendar.min.js')}}"></script>
<!-- Page specific script -->
<script>
  $(function () {


    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var title = $('#new-event').val()
      var start = $('#new-date').val()
      var end = $('#end-date').val()
      var hiddenid = $("#hiddenid").val()

      if (title.length == 0) {
        return
      }

      if (start.length == 0) {
        return
      }

      if (end.length == 0) {
        return
      }

      if(hiddenid.length == 0){
        return
      }

      console.log(title + start + end)
      var _token = $('meta[name=csrf-token]').attr('content')

      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show")
        },
        complete: function(){
          $.LoadingOverlay("hide")
        },

        url: '{{route('create-event-save')}}',
        type: 'POST',
        data: {_token: _token, title: title, start: start, end: end, hiddenid: hiddenid, currColor: currColor},
        success: function(data){
          $("#displaymessage").html(data)

          if(data.match("successfully")){

           swal("Success! Event Added Successfully!", {
             icon: "success",
           })

         //getEvents()
       }else{

        swal("Success! Event Updated Successfully!", {
         icon: "success",
       })
      }

      window.location.href= '{{ route('create-event-all') }}'
    },
    error: function (data) {
      console.log('Error:', data)
    }
  })

    })
  })
</script>

@endsection
