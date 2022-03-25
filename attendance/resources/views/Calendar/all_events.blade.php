@extends('layouts.main')


@section('title')
OSMS | All Events
@endsection

@section('mtitle')
OSMS All Events
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">All Events</h3>
      </div>
      <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th></th>
              <th>Title</th>
              <th>Startdate</th>
              <th>Enddate</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $row)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$row->title}}</td>
              <td>{{ date('jS M Y', strtotime($row->startdate))}}</td>
              <td>{{ date('jS M Y', strtotime($row->enddate))}}</td>
              <td>
                <a href="{{route('create-event-edit', ['id'=>$row->id])}}" class="btn btn-info" ><i class='fa fa-pencil-square-o'></i></a>

                <a href="{{route('create-event-delete', ['id'=>$row->id])}}" onclick=" return confirm('Are You Sure ?') " class="btn btn-danger" ><i class='fa fa-trash'></i></a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Calendar</h3>
      </div>
      <div class="box-body">
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

                console.log(data[i].title)

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
                events.allDay = true
                events.editable = true
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
    },
    
})

    
    
    
})
</script>

@endsection