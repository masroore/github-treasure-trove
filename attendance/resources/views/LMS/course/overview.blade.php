@extends('LMS.course_layout')


@section('title')
OSMS | LMS | OVERVIEW
@endsection

@section('mtitle')
OSMS LMS
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
    <div class="col-md-6">

        <div class="card">
            <div class="card-block">
                
                <h2 class="text-center">{{$course->cource_code}}</h2>

                <br>

                <h2 class="text-center">{{$course->cource_title}}</h2>

                <br>

                <h3 class="text-center">For Undergraduate 

                Level <?php
                        $codes = substr($code,4,1);

                        if ($codes == '1') {
                            echo "100";
                        }

                        if ($codes == '2') {
                            echo "200";
                        }

                        if ($codes == '3') {
                            echo "300";
                        }

                        if ($codes == '4') {
                            echo "400";
                        }
                        
                    ?>
                        
                    </h3>
                <br>
                <br>

                <p class="text-center">{{$course->academic_year}} Academic Year</p>
                <br><br>
                <p class="text-center">{{$lecturer->lecname}}, {{$staff->faculty}}, </p>

                <p class="text-center">Ogus School Management System</p>

            </div>
        </div>

        <div class="card">
                <div class="card-header">
                    <h5>Course Grading</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="fa fa fa-wrench open-card-option"></i></li>
                            <li><i class="fa fa-window-maximize full-card"></i></li>
                            <li><i class="fa fa-minus minimize-card"></i></li>
                            <li><i class="fa fa-refresh reload-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block table-border-style">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Attendance</th>
                                    <th>Quiz Score</th>
                                    <th>Examination Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grade as $row)
                                <tr>
                                  <td></td>
                                  <td>{{$row->attendance}}</td>
                                  <td>{{$row->quiz}}</td>
                                  <td>{{$row->exams}}</td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        {{-- <div class="card">
            <div class="card-block">
                
                <h2 class="text-center">Brief Overview</h2>
                {!! $data->overview !!}

                <h2 class="text-center">Course Objectives</h2>

                {!!$data->objectives!!}
            </div>
        </div> --}}


    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Announcement</h5>
            </div>
            <div class="card-block">
               
                


                <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th>title</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                  @forelse ($announcement as $row)
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$row->title}}</td>
                      <td>{{$row->message}}</td>
                </tr>

                @empty

                <div class="alert alert-danger">
                    <h4>oowp!</h4>
                    <p>There are currently no announcements at this location.</p>
                </div>

                @endforelse
            </tbody>
        </table>


            </div>
        </div>


        <div class="card">
            <div id="calendar"></div>
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
          url: '{{route('lms-calendar-getevents', ['code' => $code])}}',
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