<?php

namespace Vanguard\Http\Controllers\Web;

use Carbon\Carbon;

use Vanguard\Http\Controllers\Controller;
use Vanguard\WorkOrder;

class IcalController extends Controller
{
    /**
     * Gets the events data from the database
     * and populates the iCal object.
     */
    public function getEventsICalObject($cid): void
    {
        $events = WorkOrder::with('estimate', 'estimate.customer')->where('companyId', $cid)->where('status', 1)->get();

        //dd($events);
        define('ICAL_FORMAT', 'Ymd\THis\Z');

        $icalObject = "BEGIN:VCALENDAR
       VERSION:2.0
       METHOD:PUBLISH
       PRODID:-//XtremeReflection//Details//EN\n";

        // loop over events
        foreach ($events as $event) {
            $endTime = Carbon::parse($event->estimate->arrivalTime)->addHours(6)->format('H:i:s');
            $start = $event->estimate->dateofService . ' ' . $event->estimate->arrivalTime;
            $end = $event->estimate->dateofService . ' ' . $endTime;
            $start = Carbon::parse($start)->addHours(4);
            $end = Carbon::parse($end)->addHours(4);
            $eventLink = 'https://xtremereflection.app/estimate/' . $event->estimate->id . '/show';
            if ($event->estimate->serviceAddress) {
                $location = $event->estimate->serviceAddress;
            } else {
                $location = '';
            }

            if ($event->estimate->detailType == 1) {
                $detailType = 'Shop Detail';
            } elseif ($event->estimate->detailType == 2) {
                $detailType = 'Mobile Detail';
            } else {
                $detailType = 'Detail';
            }
            $summary = $event->estimate->customer->firstName . ' ' . $event->estimate->customer->lastName;

            $icalObject .=
                'BEGIN:VEVENT
           DTSTART:' . date(ICAL_FORMAT, strtotime($start)) . '
           DTEND:' . date(ICAL_FORMAT, strtotime($end)) . '
           DTSTAMP:' . date(ICAL_FORMAT, strtotime($event->created_at)) . "
           URL:$eventLink
           SUMMARY:$summary
           UID:$event->id
           LAST-MODIFIED:" . date(ICAL_FORMAT, strtotime($event->updated_at)) . "
           LOCATION:$location
           BEGIN:VALARM
            TRIGGER:-PT1D
            ACTION:DISPLAY
            DESCRIPTION:Auto Detail Scheduled
            END:VALARM
           END:VEVENT\n";
        }

        // close calendar
        $icalObject .= 'END:VCALENDAR';

        // Set the headers
        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');

        $icalObject = str_replace(' ', '', $icalObject);

        echo $icalObject;
    }
}
