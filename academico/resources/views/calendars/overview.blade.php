@extends('backpack::blank')

@section('after_styles')
<link href='/fullcalendar/core/main.css' rel='stylesheet' />
<link href='/fullcalendar/timeline/main.css' rel='stylesheet' />
<link href='/fullcalendar/resource-timeline/main.css' rel='stylesheet' />

<script src='/fullcalendar/core/main.js'></script>
<script src='/fullcalendar/timeline/main.js'></script>
<script src='/fullcalendar/resource-common/main.js'></script>
<script src='/fullcalendar/resource-timeline/main.js'></script>
<script src='/fullcalendar/interaction/main.js'></script>

@endsection

@section('header')
    <section class="container-fluid">
	  <h2>
        @lang('resource Calendars')
      </h2>
    </section>
@endsection


@section('content')
    <div class="row" id="app">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('after_scripts')

<script>

document.addEventListener('DOMContentLoaded', () => { // page is now ready...
    var calendarEl = document.getElementById('calendar'); // grab element reference

    var calendar = new FullCalendar.Calendar(calendarEl, {
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        plugins: [ 'resourceTimeline', 'interaction' ],
        defaultView: 'resourceTimelineWeek',
        resources: @json($resources),
        height: "auto",
        slotLabelInterval: {hours:4},
        nowIndicator: true,
        hiddenDays: [ 0 ], // TODO make this customizable
        firstDay: 1,
        slotLabelFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: 'short',
            hour12: false,
        },
        slotWidth: 20,
        eventRender: function (info) {
            tippy(info.el, {
                content: info.event.title,
            });
        },
        resourceAreaWidth: 150,
        eventSources: [
            {
                events: @json($events)
            },
            {
                events: @json($unassigned_events)
            },
            {
                events: @json($leaves ?? null),
                color: 'red',
                textColor: 'white',
            },
        ],

        editable:true,

        eventDrop: info =>
            axios.patch(window.location.href, {
                course_id: info.event.groupId,
                resource_id: info.newResource.id,
            })

                .then(response =>
                    new Noty({
                        title: "Operation successful",
                        text: "The course has been updated.",
                        type: "success"
                    }).show())

                .catch(error =>
                    new Noty({
                        title: "Error",
                        text: "The course was not updated.",
                        type: "error"
                    }).show())
    });

    calendar.render();
});

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js" integrity="sha256-XmdRbTre/3RulhYk/cOBUMpYlaAp2Rpo/s556u0OIKk=" crossorigin="anonymous"></script>

<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
@endsection
