@extends('layouts.main');


@section('title')
Ogua School Management System | Dashboard
@endsection

@section('mtitle')
Dashboard
@endsection


@section('mtitlesub')
Control panel
@endsection



@section('main_content')
<!-- Small boxes (Stat box) -->
<div class="row">

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>{{$taotalstaff}}</h3>

        <p>Total Staff</p>
      </div>
      <div class="icon">
        <i class="ion ion-android-person"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>


  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3>{{$totalstudents}}<sup style="font-size: 20px"></sup></h3>

        <p>Total Students</p>
      </div>
      <div class="icon">
        <i class="ion ion-android-person"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{$totallevel100students}}</h3>

        <p>Total Level 100</p>
      </div>
      <div class="icon">
        <i class="ion ion-android-person"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3>{{$totallevel200students}}</h3>

        <p>Total Level 200</p>
      </div>
      <div class="icon">
        <i class="ion ion-android-person"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>{{$totallevel300students}}</h3>

        <p>Total Level 300</p>
      </div>
      <div class="icon">
        <i class="ion ion-android-person"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3>{{$totallevel400students}}</h3>

        <p>Total Level 400</p>
      </div>
      <div class="icon">
        <i class="ion ion-android-person"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{$totalgraduatedstudents}}</h3>

        <p>Total Graduated</p>
      </div>
      <div class="icon">
        <i class="ion ion-android-person"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>


  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{$academcyear}}</h3>

        <p>Current Academic Year</p>
      </div>
      <div class="icon">
        <i class="ion ion-android-calendar"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{$totalprog}}</h3>

        <p>Total Programmes</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-book"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>


  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{$totaldegreeprog}}</h3>

        <p>Total Degree Programmes</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-book"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>


  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{$totaldiplomaprog}}</h3>

        <p>Total Diploma Programmes</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-book"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>



  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{$totalcourse}}</h3>

        <p>Total Courses</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-book-outline"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>


  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{$totaldegreecourse}}</h3>

        <p>Total Degree Courses</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-book-outline"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>


  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{$totaldiplomacourse}}</h3>

        <p>Total Diploma Courses</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-book-outline"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  




</div>

<!-- /.row -->


<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <section class="col-lg-6 connectedSortable">

    <!-- quick email widget -->
    <div class="box box-info">
      <div class="box-header">
        <i class="fa fa-envelope"></i>
        <h3 class="box-title">Quick Email</h3>
      </div>
      <div class="box-body">
        <form method="post" action="{{ route('send_mail_now') }}" enctype="multipart/form-data" id="mailsubmit">

          @csrf
          <div class="form-group">
            <input type="email" class="form-control" name="quicksendto" id="quicksendto" placeholder="Email to:" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="compose" id="compose" placeholder="Subject" required>
          </div>
          <div>
            <textarea class="textarea" name="html" id="html" placeholder="Message"
            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
          </div> 
          <div class="form-group" style="margin-top: 10px;">
              <div class="btn btn-default btn-file">
                <i class="fas fa-paperclip"></i> Attachment
                <input type="file" name="pdffile" id="attachment">
            </div>
            <p class="help-block">Max. 32MB</p>
        </div>
        
      </div>
      <div class="box-footer clearfix">
        <input type="submit" name="submit" class="pull-right btn btn-default" id="sendEmail" value="Send">
        </div>
        </form>
      </div>


      <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Users Online</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-danger">{{$onlineusers}} Users Online</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix" style="margin-bottom: 15px;">
                    @foreach ($online as $row)
                    <li style="width: 120px;height: 120px;">
                      <img src="{{asset('storage')}}/{{$row->pro_pic}}" alt="User Image" style="display: block; height: 100px; width: 100px;">
                      <a class="users-list-name" href="#">{{$row->name}}</a>
                    </li>
                    @endforeach
                  </ul>
                  <!-- /.users-list -->
                </div>
              </div>

    </section>
    <!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    <section class="col-lg-6 connectedSortable">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Academic Calendar</h3>
        </div>
        <div class="box-body">
          <div id="calendar"></div>
        </div>
    </div>
    </section>
    <!-- right col -->
  </div>
  <!-- /.row (main row) -->

  
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

    $(document).on("submit","#mailsubmit", function(e){
      e.preventDefault();

      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },
        url: '{{route('send_mail_now')}}',
        type: 'POST',
        data: $("form").serialize(),
        success: function(data){ 

         swal("Mail Sent Successfully!", {
          icon: "success",
        });

         $("#quicksendto").val('');
         $("#compose").val('');
         $("#html").val('');

       },
       error: function (data) {
        console.log('Error:', data);
      }
    });    



    });
    

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
                events.allDay = true
                events.editable = true
                events.backgroundColor = data[i].background
                events.borderColor = data[i].background

                $('#calendar').fullCalendar('renderEvent', events, true)

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
    });

    
  });
</script>

@endsection
