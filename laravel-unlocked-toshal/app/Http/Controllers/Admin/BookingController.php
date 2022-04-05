<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\BookingPayment;
use App\Commission;
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

    public function __construct()
    {
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
                    })
                    ->orWhereHas('user', function ($qu) use ($request): void {
                        $qu->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", '%' . $request->search_keyword . '%');
                    });
            });
        })->when($daterange != '', function ($query) use ($start, $end): void {
            $query->whereBetween('date', [$start, $end]);
        })->sortable('id')->paginate(Config::get('constants.PAGINATION_NUMBER'));

        return view('admin.bookings.list', compact('data', 'daterange', 'keyword'));
    }
    // End Method getList

    /*
    Method Name:    confirm_request
    Developer:      Shine Dezign
    Created Date:   2021-03-09 (yyyy-mm-dd)
    Purpose:        To Approved/decline any booking
    Params:         [id]
    */
    public function confirm_request(Request $request)
    {
        try {
            $getData = $request->all();

            $booking = Booking::find($getData['id']);
            $booking->status = $getData['status'];
            $booking->save();

            if ($getData['status'] == 1) {
                $status = 'APPROVED_DONE';
                $template = 'APPROVE_BOOKING';
            } else {
                $status = 'DECLINED_DONE';
                $template = 'DECLINE_BOOKING';
            }
            $this->send_notification($template, $booking->user->email, $booking->user->first_name, date('d F Y', strtotime($booking->date)));

            return redirect()->back()->with('status', 'success')->with('message', 'Booking ' . Config::get('constants.SUCCESS.' . $status));
        } catch (Exception $ex) {
            return redirect()->back()->with('status', 'error')->with('message', $ex->getMessage());
        }
    }

    // End Method confirm_request

    // End Method confirm_request

    /*
    Method Name:    edit_form
    Developer:      Shine Dezign
    Created Date:   2021-03-10 (yyyy-mm-dd)
    Purpose:        Form to update booking details
    Params:         [id]
    */
    public function edit_form($id)
    {
        $venues = Venue::get();

        $bookingDetail = Booking::find($id);
        if (!$bookingDetail) {
            return redirect()->route('bookings.list');
        }

        return view('admin.bookings.edit', compact('bookingDetail', 'venues'));
    }
    // End Method edit_form

    /*
    Method Name:    update_record
    Developer:      Shine Dezign
    Created Date:   2021-03-10 (yyyy-mm-dd)
    Purpose:        To update booking details
    Params:         [edit_record_id, first_name, last_name, email, status]
    */
    public function update_record(Request $request)
    {
        $postData = $request->all();
        $id = $postData['edit_record_id'];
        $request->validate([
            'venue_id' => 'required',
            'booking_name' => 'required|string',
            'booking_email' => 'required|email',
            'date' => 'required|date|after:' . date('Y-m-d H:i:s'),
            'status' => 'required',
        ], [
            'date.after' => 'Date must be a future date',
        ]);

        try {
            $bookings = Booking::findOrFail($id);
            $bookings->venue_id = $postData['venue_id'];
            $bookings->booking_name = $postData['booking_name'];
            $bookings->date = date('Y-m-d', strtotime($postData['date']));
            $bookings->booking_email = $postData['booking_email'];
            $bookings->status = $postData['status'];

            $bookings->push();

            return redirect()->route('bookings.list')->with('status', 'success')->with('message', 'Booking details ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }
    // End Method update_record

    /*
    Method Name:    del_record
    Developer:      Shine Dezign
    Created Date:   2021-03-10 (yyyy-mm-dd)
    Purpose:        To delete any booking by id
    Params:         [id]
    */
    public function del_record($id)
    {
        $bookingDetail = Booking::find($id);
        if (!$bookingDetail) {
            return redirect()->route('bookings.list');
        }

        try {
            $booking = Booking::find($id);
            $booking->is_deleted = 1;
            $booking->save();

            return redirect()->back()->with('status', 'success')->with('message', 'Booking ' . Config::get('constants.SUCCESS.DELETE_DONE'));
        } catch (Exception $ex) {
            return redirect()->back()->with('status', 'error')->with('message', $ex->getMessage());
        }
    }
    // End Method del_record

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
    Created Date:   2021-03-22 (yyyy-mm-dd)
    Purpose:        To add booking
    Params:         [venue_id, booking_name,booking_email, user_id]
    */
    public function add_record(Request $request)
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

            //Add commission
            $commPercentage = 0;
            $venue = Venue::where('id', $request->venue_id)->first();
            $commission = Commission::first();
            if ($venue && $commission) {
                $commPercentage = ($venue->booking_price * $commission->commission_percentage) / 100;
            }

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
                //update commssion
                if ($commPercentage > 0) {
                    $payments = [
                        'booking_id' => $record->id,
                        'user_id' => Auth::user()->id,
                        'price' => $venue->booking_price,
                        'commission' => $commPercentage,
                        'payable_amount' => ($venue->booking_price - $commPercentage),
                    ];
                    BookingPayment::create($payments);
                }

                $user = User::find($request->user_id);
                $this->send_notification('COMPLETE_BOOKING', $user->email, $user->first_name, date('d F Y', strtotime($request->date)));

                $routes = ($request->action == 'saveadd') ? 'booking.add' : 'bookings.list';

                return redirect()->route($routes)->with('status', 'success')->with('message', 'Booking ' . Config::get('constants.SUCCESS.CREATE_DONE'));
            }

            return redirect()
                ->back()->with('status', 'error')
                ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }
    // End Method add_record

    /*
    Method Name:    view_detail
    Developer:      Shine Dezign
    Created Date:   2021-03-23 (yyyy-mm-dd)
    Purpose:        To get detail of Booking
    Params:         [id]
    */
    public function view_detail($id, Request $request)
    {
        $bookingDetail = Booking::find($id);

        if (!$bookingDetail) {
            return redirect()->route('bookings.list');
        }

        return view('admin.bookings.view_detail', compact('bookingDetail'));
    }

    // End Method view_detail

    /*
    Method Name:    send_notification
    Developer:      Shine Dezign
    Created Date:   2021-03-25 (yyyy-mm-dd)
    Purpose:        To Send email on APProve/Decline Booking request
    Params:         []
     */
    public function send_notification($btemplate, $email, $name, $date): void
    {
        $template = $this->get_template_by_name($btemplate);
        $string_to_replace = [
            '{{$name}}',
            '{{$date}}',
            '{{$link}}',
        ];
        $string_replace_with = [
            $name,
            $date,
            url('/'),

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
