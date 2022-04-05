@extends('user.layouts.cmlayout')
@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    <div class="row">
        <!-- Total Booking Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <a href="{{route('bookings.mybookings')}}" class="anchor-link">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Bookings</div>
                                <div class="h5 mb-0 font-weight-bold text-primary"><span>{{$userDetail->booking->count()}}</span></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-circle fa-2x text-primary"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- New Bookings -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <a href="{{route('bookings.mybookings')}}" class="anchor-link">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">New Bookings</div>
                                <div class="h5 mb-0 font-weight-bold text-primary"><span>{{$userDetail->booking->count()}}</span></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-circle fa-2x text-primary"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- Confirmed Bookings -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <a href="{{route('bookings.mybookings')}}" class="anchor-link">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Confirmed Bookings</div>
                                <div class="h5 mb-0 font-weight-bold text-primary"><span>{{$userDetail->booking->count()}}</span></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-circle fa-2x text-primary"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <a href="{{route('bookings.mybookings')}}" class="anchor-link">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Canceled Bookings</div>
                                <div class="h5 mb-0 font-weight-bold text-primary"><span>{{$userDetail->booking->count()}}</span></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-circle fa-2x text-primary"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bookings</h1>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
             <div class="card shadow mb-4">
                <div class="card-body">
                    <div id="calendar">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script type="text/javascript" src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript" src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript"  src="https://code.highcharts.com/modules/export-data.js"></script>
<script type="text/javascript"  src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
jQuery(document).ready(function(){

// console.log({!! date('F, Y', strtotime("2021-03-18")) !!})
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: moment().format("YYYY-MM-DD"),
        defaultView: 'month',
        editable: false,
        events: {!! $bookingEvent !!},
        eventColor: '#75296e',
        eventTextColor : "#ffffff"
    });
});
</script>
 @stop

