@extends('admin.layouts.cmlayout')
@section('body')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">
        <!-- Total Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <a href="{{route('users.list')}}" class="anchor-link">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                                <div class="h5 mb-0 font-weight-bold text-primary"><span>{{$user_count}}</span></div>
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
                    <a href="{{route('owners.list')}}" class="anchor-link">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Owners</div>
                                <div class="h5 mb-0 font-weight-bold text-primary"><span>{{$owner_count}}</span></div>
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
                    <a href="{{route('venues.list')}}" class="anchor-link">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Venues</div>
                                <div class="h5 mb-0 font-weight-bold text-primary"><span>{{$venue_count}}</span></div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-home fa-2x text-primary"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <a href="{{route('venues.list')}}" class="anchor-link">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Featured Venue</div>
                                <div class="h5 mb-0 font-weight-bold text-primary"><span>{{$featured_venue}}</span></div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-home fa-2x text-primary"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bookings</h1>
        <a class="m-0 font-weight-bold btn-department-add  hover-white" href="{{route('booking.add')}}">Add New Booking <i class="fa fa-plus"></i></a>
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
        <div class="col-md-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div id="container">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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

    var data = {!! $bookingChart !!};
    var cat = [];

        
    if(data.length == 0){
        cat.push(0);
    }else{
        data.forEach(function(item) {
            cat.push(item[0]);
        });
    }

    Highcharts.chart('container', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Monthly Bookings'
        },

        xAxis: {
            categories: cat,
            labels: {
                formatter: function() {
                    return Highcharts.dateFormat('%b', Date.parse(this.value +' UTC'));
                }
            }
        },
        yAxis: {
            min: 0,
                title: {
                text: 'Booking count'
                },
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Bookings',
            data: data
        }]
    });
});
</script>
@stop