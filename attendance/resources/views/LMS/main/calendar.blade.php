@extends('LMS.layout')


@section('title')
OSMS | LMS | Calendar
@endsection

@section('mtitle')
Calendar
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
    {{-- <div class="col-md-3">
        <div class="card">

        <div class="card-block">
            <div class="card-header">
                <h5>Create Events</h5>
            </div>
            <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                
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
          <div class="input-group">
            <input id="new-event" type="text" class="form-control" placeholder="Event Title">
        </div>
        <label>Start Date</label>
        <div class="input-group">
            <input id="new-date" type="date" class="form-control" >
        </div>
        <label>End Date</label>
        <div class="input-group">
            <input id="end-date" type="date" class="form-control" placeholder="End">
            
        </div>
        <div class="input-group-btn">
          <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add</button>
      </div>

  </div>
</div>
</div> --}}
<div class="col-md-12">
    <div class="card">
        <div id="calendar"></div>
    </div>

    <div id="displaymessage"></div>
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

    /* initialize the external events
    -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
      }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        //console.log(eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
      })

    })
  }

  init_events($('#external-events div.external-event'))

    /* initialize the calendar
    -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    
    getEvents();
    function getEvents(){
        $.ajax({
          url: '{{route('fetch-events')}}',
          type: 'get',
          dataType: 'json',
          success: function(data){

            var events = [];

            for (var i = 0; i < data.length; i++){
               // console.log(data[i].title)

                var eventdom = {
                  title          : data[i].title,
                  start          : moment(data[i].startdate),
                  end            : moment(data[i].enddate),
                  allDay         : false,
                  backgroundColor: data[i].background, //Info (aqua)
                  borderColor    : data[i].background //Info (aqua)
                }

                events.title = data[i].title
                events.start = moment(data[i].startdate)
                events.end = moment(data[i].enddate)
                events.allDay = false
                events.backgroundColor = data[i].background
                events.borderColor = data[i].background


                $('#calendar').fullCalendar('renderEvent', events, true)

                //$(this).data('eventdom', eventdom)

                // $('#calendar').fullCalendar('renderEvent', {
                //   title: data[i].title,
                //   start: moment(data[i].startdate),
                //   end: moment(data[i].enddate),
                //   backgroundColor: data[i].background,
                //   borderColor: data[i].background,
                //   allDay: false
                // })

                console.log(events)
            }
            
        },
        error: function (data) {
          console.log('Error:', data)
      }
  })

    }


    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
    },
    buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
    }
})

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

      if (title.length == 0) {
        return
    }

    if (start.length == 0) {
        return
    }

    if (end.length == 0) {
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

      url: '{{route('lms-calendar-save')}}',
      type: 'POST',
      data: {_token: _token, title: title, start: start, end: end, currColor: currColor},
      success: function(data){
        $("#displaymessage").html(data)

        if(data.match("successfully")){

         swal("Success! Event Added Successfully!", {
             icon: "success",
         })

         $('#new-event').val("")
         $('#new-date').val("")
         $('#end-date').val("")

         getEvents()
     }
 },
 error: function (data) {
  console.log('Error:', data)
}
})

})
})
</script>

@endsection