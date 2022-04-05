<?php

namespace App\Http\Controllers\Frontend;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Traits\AutoResponderTrait;
use App\User;
use App\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class BookingController extends Controller
{
    use AutoResponderTrait;

    /*
    Method Name:    add_form
    Developer:      Shine Dezign
    Created Date:   2021-03-22 (yyyy-mm-dd)
    Purpose:        Form to add booking details
    Params:         []
    */
    public function add_form()
    {
        $venues = Venue::where('is_deleted', 0)->where('status', 1)->get();
        $users = User::Role('User')->where('is_deleted', 0)->get();

        return view('admin.bookings.add', compact('venues', 'users'));
    }
    // End Method add_form

    /*
    Method Name:    add_record
    Developer:      Shine Dezign
    Created Date:   2021-05-03 (yyyy-mm-dd)
    Purpose:        To add booking
    Params:         [venue_id, booking_name,booking_email, user_id]
    */
    public function booking(Request $request)
    {
        $request->validate([
            'venue_id' => 'required',
            'user_id' => 'required',
            'booking_name' => 'required|string',
            'booking_email' => 'required|email',
            'date' => 'required|date|after:' . date('Y-m-d H:i:s'),
        ], [
            'date.after' => 'Date must be a future date',
        ]);

        try {
            $venue = Venue::where('id', $request->venue_id)->first();

            $data = [
                'venue_id' => $request->venue_id,
                'user_id' => $request->user_id,
                'booking_name' => $request->booking_name,
                'booking_email' => $request->booking_email,
                'date' => $request->date,
                'status' => 1,
            ];

            $record = Booking::create($data);
            if ($record) {
                return redirect()->back()->with('status', 'success')->with('message', 'Submit successfully');
            }

            return redirect()
                ->back()->with('status', 'error')
                ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }

    /*
    Method Name:    getList
    Developer:      Shine Dezign
    Created Date:   2021-03-09 (yyyy-mm-dd)
    Purpose:        To get list of all bookings
    Params:
    */
    public function getList(Request $request)
    {
        $start = $end = '';

        if ($request->has('search_keyword') && $request->search_keyword != '') {
            $keyword = $request->search_keyword;
        } else {
            $keyword = '';
        }

        if ($request->has('daterange_filter') && $request->daterange_filter != '') {
            $daterange = $request->daterange_filter;
            $daterang = explode(' / ', $daterange);
            $start = $daterang[0];
            $end = $daterang[1];
        } else {
            $daterange = '';
        }

        $data = Booking::when($request->search_keyword, function ($q) use ($request): void {
            $q->where(function ($quer) use ($request): void {
                $quer->where('booking_name', 'like', '%' . $request->search_keyword . '%')
                    ->orWhere('booking_email', 'like', '%' . $request->search_keyword . '%')
                    ->orWhere('status', 'like', '%' . $request->search_keyword . '%')
                    ->orWhere('id', $request->search_keyword)
                    ->orWhereHas('venue', function ($query) use ($request): void {
                        $query->where('name', 'like', '%' . $request->search_keyword . '%');
                    });
            });
        })->when($daterange != '', function ($query) use ($start, $end): void {
            $query->whereBetween('date', [$start, $end]);
        })->where('user_id', Auth::user()->id)->sortable('id')->paginate(Config::get('constants.PAGINATION_NUMBER'));

        return view('user.bookings.list', compact('data', 'daterange', 'keyword'));
    }

    /*
    Method Name:    view_detail
    Developer:      Shine Dezign
    Created Date:   2021-04-07 (yyyy-mm-dd)
    Purpose:        To get detail of Booking
    Params:         [id]
    */
    public function view_detail($id, Request $request)
    {
        $bookingDetail = Booking::find($id);

        if (!$bookingDetail) {
            return redirect()->route('bookings.mybookings');
        }

        return view('user.bookings.view_detail', compact('bookingDetail'));
    }
    // End method view Detail

    /*
    Method Name:    booking_cancel
    Developer:      Shine Dezign
    Created Date:   2021-04-07 (yyyy-mm-dd)
    Purpose:        To get detail of Booking
    Params:         [id]
    */
    public function booking_cancel(Request $request)
    {
        try {
            $bookingDetail = Booking::findOrFail($request->id);

            $bookingDetail->status = 3;
            $bookingDetail->push();

            if ($bookingDetail->status !== '3') {
                $this->send_notification('CANCEL_BOOKING', $bookingDetail->venue->user->email, $bookingDetail->venue->user->first_name, date('d F Y', strtotime($bookingDetail->date)), $bookingDetail->user->first_name);
            }

            return redirect()->back()->with('status', 'success')->with('message', 'Booking cancelled has been successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('status', 'error')->with('message', $ex->getMessage());
        }
    }

    /**
     * Method Name:     send_notification
     * Developer:      Shine Dezign
     * Created Date:   2021-04-13 (yyyy-mm-dd)
     * Purpose:        To send mail to admin , when booking cacel by admin
     * Params:         [id].
     */
    public function send_notification($btemplate, $email, $name, $date, $byName): void
    {
        $template = $this->get_template_by_name($btemplate);
        $string_to_replace = [
            '{{$name}}',
            '{{$date}}',
            '{{$byName}}',
        ];
        $string_replace_with = [
            $name,
            $date,
            $byName,
        ];
        $newval = str_replace($string_to_replace, $string_replace_with, $template->template);

        $logId = $this->email_log_create($email, $template->id, $btemplate);
        $result = $this->send_mail($email, $template->subject, $newval);
        if ($result) {
            $this->email_log_update($logId);

            return;
        }

    }
}
