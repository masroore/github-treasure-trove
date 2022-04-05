<?php

namespace App\Traits;

use Auth;
use Calendar;
use DateTime;

trait HospitalScheduleTrait
{
    use MomProfileTrait;

    public function getSchedule($hospital, $setPacientName)
    {
        $event_list = [];
        foreach ($hospital->hospitalSchedule as $key => $event) {
            $event_list[] = Calendar::event(
                $setPacientName ? $event->pacient->name : 'Ocupado',
                false,
                new DateTime($event->start_date),
                new DateTime($event->end_date)
            );
        }

        //Set business hour array from availability
        $businessHours = [];
        foreach ($hospital->hospitalAvailability as $availability) {
            $businessHours[] = [
                'dow' => [$this->getCalendarDow($availability->day)],
                'start' => $availability->time_start,
                'end' => $availability->time_end,
            ];
        }

        //Variables to manage select hour on calendar (logged in,guest)
        $isLoggedIn = Auth::guest() ? 0 : 1;

        $calendar = Calendar::addEvents($event_list)
            ->setOptions([ //set fullcalendar options
                'firstDay' => 1,
                'lang' => 'es',
                'selectable' => true,
                'allDay' => false,
                'allDaySlot' => false,
                'defaultView' => 'agendaWeek',
                'slotLabelFormat' => 'hh:mm a',
                'allDay' => false,
                'selectLongPressDelay' => 5,
                'minTime' => $hospital->hospitalAvailability->min('time_start'),
                'maxTime' => $hospital->hospitalAvailability->max('time_end'),
                'slotDuration' => $hospital->appointment_duration,
                'businessHours' => $businessHours,
                'eventColor' => '#9A7AA0',
                'eventTextColor' => '#ffffff',
                'timeFormat' => 'hh:mm a',
                'displayEventTime' => 'true',
                'aspectRatio' => 'auto',
                'themeSystem' => 'bootstrap4',
                'header' => [
                    'left' => 'prev,next',
                    'right' => 'agendaWeek,agendaDay',
                    'center' => 'title',

                ],
                'selectConstraint' => 'businessHours',

            ])
            ->setCallbacks([
                'select' => 'function(start, end, jsEvent, view) {


                    var isLoggedIn=' . $isLoggedIn . ';

                    if(isLoggedIn == 1){

                            var appointmentDate= moment(start).format("LL h:m a");

                            $("input[name=\'start_date\']").val(moment(start).format("YYYY-MM-DD HH:mm:ss"));
                            $("input[name=\'end_date\']").val(moment(end).format("YYYY-MM-DD HH:mm:ss"));

                            $("#modalAcceptAppointment .modal-body p").text("¿Está segura de agendar cita el "+ appointmentDate + " ?");
                            $("#modalAcceptAppointment").modal("show");


                    }else{
                        window.location = "' . route('web.getRegisterMom') . '";
                    }


                }',
                'eventClick' => 'function(calEvent, jsEvent, view) {



                }',
            ]);

        return $calendar;
    }

    private function getCalendarDow($day)
    {
        switch ($day) {
            case 'mon':
                return 1;
            case 'tue':
                return 2;
            case 'wed':
                return 3;
            case 'thu':
                return 4;
            case 'fri':
                return 5;
            case 'sat':
                return 6;
            case 'sun':
                return 7;

        }
    }
}
