<?php

namespace App\Traits;

use App\Booking;
use App\BookingPayment;
use App\County;
use App\State;
use App\User;
use App\Venue;
use Exception;
use Illuminate\Support\Facades\DB;
use Image;

trait CommonTrait
{
    /*
    Method Name:    uploadDocument
    Developer:      Shine Dezign
    Created Date:   2021-03-05 (yyyy-mm-dd)
    Purpose:        To upload document on s3 bucket
    Params:         []
    */
    public function uploadDocument($uploadpath, $document, $documentname): void
    {
    }
    // End Method uploadDocument

    /*
    Method Name:    getUsers
    Developer:      Shine Dezign
    Created Date:   2021-03-25 (yyyy-mm-dd)
    Purpose:        To get list of all users
    Params:         []
    */
    public function getUsers()
    {
        $users = User::role('User')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->select(DB::raw('users.id, first_name, last_name, email,mobile,address,zipcode, IF(users.status = 1, "Active","Inactive") as owner_status,DATE_FORMAT(users.created_at, "%d-%b-%Y") as createdAt'))
            ->orderBy('id', 'asc')
            ->get()->toArray();

        return $users;
    }

    // End Method getOwners
    /*
    Method Name:    getOwners
    Developer:      Shine Dezign
    Created Date:   2021-03-25 (yyyy-mm-dd)
    Purpose:        To get list of all users
    Params:         []
    */
    public function getOwners()
    {
        $owners = User::role('Owner')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->select(DB::raw('users.id, first_name, last_name, email,mobile,address,zipcode, IF(users.status = 1,   "Active","Inactive") as owner_status,DATE_FORMAT(users.created_at, "%d-%b-%Y") as createdAt'))
            ->orderBy('id', 'asc')
            ->get()->toArray();

        return $owners;
    }
    // End Method getUsers

    /*
    Method Name:    getVenues
    Developer:      Shine Dezign
    Created Date:   2021-03-25 (yyyy-mm-dd)
    Purpose:        To get list of all venues
    Params:         []
    */
    public function getVenues()
    {
        $venues = Venue::join('users', 'venues.user_id', '=', 'users.id')
            ->select(DB::raw('venues.id, CONCAT(first_name," ",last_name) as owner_name, name, location, contact, building_type, amenities_detail,other_information,total_room, booking_price,IF(venues.status = 1, "Active","Inactive") as venue_status,IF(is_featured = 1, "Yes","No") as is_featured, DATE_FORMAT(venues.created_at, "%d-%b-%Y") as createdAt'))
            ->orderBy('id', 'asc')
            ->get()->toArray();

        return $venues;
    }

    // End Method getVenues
    /*
    Method Name:    getBookings
    Developer:      Shine Dezign
    Created Date:   2021-03-25 (yyyy-mm-dd)
    Purpose:        To get list of all bookings
    Params:         []
    */
    public function getBookings()
    {
        $bookings = Booking::join('users', 'bookings.user_id', '=', 'users.id')
            ->join('venues', 'bookings.venue_id', '=', 'venues.id')
            ->select(DB::raw('bookings.id,name, CONCAT(first_name," ",last_name) as customer_name, booking_name, booking_email, DATE_FORMAT(bookings.date, "%d-%b-%Y") as booking_date,(CASE WHEN bookings.status = "0" THEN "New" WHEN bookings.status = "1" THEN "Approved" ELSE "Declined" END) AS booking_status, DATE_FORMAT(bookings.created_at, "%d-%b-%Y") as createdAt'))
            ->orderBy('id', 'asc')
            ->get()->toArray();

        return $bookings;
    }
    // End Method getBookings

    /*
    Method Name:    getCommissions
    Developer:      Shine Dezign
    Created Date:   2021-04-13 (yyyy-mm-dd)
    Purpose:        To get list of commission
    Params:         []
    */
    public function getCommissions()
    {
        $commissions = BookingPayment::join('bookings', 'booking_payments.booking_id', '=', 'bookings.id')
            ->join('venues', 'bookings.venue_id', 'venues.id')
            ->select(DB::raw('booking_payments.id,venues.name,booking_price, DATE_FORMAT(booking_payments.created_at, "%d-%b-%Y") as createdAt, DATE_FORMAT(bookings.date, "%d-%b-%Y") as booking_date,commission'))
            ->orderBy('booking_payments.id', 'asc')
            ->get()
            ->toArray();
        if ($commissions) {
            $commissionAmt = BookingPayment::sum('commission');

            $total = [
                'id' => '',
                'name' => '',
                'booking_price' => '',
                'createdAt' => '',
                'booking_date' => 'Total',
                'commission' => $commissionAmt,
            ];
            $commissions[] = $total;
        }

        return $commissions;
    }
    // End Method getCommissions

    /*
    Method Name:    getEarnings
    Developer:      Shine Dezign
    Created Date:   2021-04-13 (yyyy-mm-dd)
    Purpose:        To get list of earning
    Params:         []
    */
    public function getEarnings()
    {
        $earning = BookingPayment::join('bookings', 'booking_payments.booking_id', '=', 'bookings.id')
            ->join('venues', 'bookings.venue_id', 'venues.id')
            ->select(DB::raw('booking_payments.id,venues.name,booking_price, DATE_FORMAT(booking_payments.created_at, "%d-%b-%Y") as createdAt, DATE_FORMAT(bookings.date, "%d-%b-%Y") as booking_date,payable_amount'))
            ->orderBy('booking_payments.id', 'asc')
            ->get()
            ->toArray();
        if ($earning) {
            $earnAmt = BookingPayment::sum('payable_amount');

            $total = [
                'id' => '',
                'name' => '',
                'booking_price' => '',
                'createdAt' => '',
                'booking_date' => 'Total',
                'payable_amount' => $earnAmt,
            ];
            $earning[] = $total;
        }

        return $earning;
    }
    // End Method getEarnings

    /*
    Method Name: createThumbnail
    Developer: Shine Dezign
    Created Date: 2021-03-15 (yyyy-mm-dd)
    Purpose: To create thumbnail at fly
    Params: []
    */
    public function createThumbnail($image, $extension, $width = 250, $height = 75)
    {
        try {
            $image_resize = Image::make($image)->resize($width, $height, function ($constraint): void {
                $constraint->aspectRatio();
            })->encode($extension);

            return $image_resize;
        } catch (Exception $e) {
            return false;
        }
    }
    // End Method createThumbnail

    /*
    Method Name:    stateList
    Developer:      Shine Dezign
    Created Date:   2021-03-05 (yyyy-mm-dd)
    Purpose:        To get list of all active state
    Params:         []
    */
    public function stateList()
    {
        $states = State::where('status', 1)
            ->get(['id', 'name']);

        return $states;
    }
    // End Method stateList

    /*
    Method Name:    countyList
    Developer:      Shine Dezign
    Created Date:   2021-03-05 (yyyy-mm-dd)
    Purpose:        To get list of all active counties
    Params:         []
    */
    public function countyList()
    {
        $counties = County::where('status', 1)
            ->get(['id', 'state_id', 'name']);

        return $counties;
    }
    // End Method countyList

    /*
    Method Name:    countyByStateId
    Developer:      Shine Dezign
    Created Date:   2021-03-05 (yyyy-mm-dd)
    Purpose:        To get list of all active counties on the basic of state
    Params:         [state_id]
    */
    public function countyByStateId($state_id)
    {
        $counties = County::where('state_id', $state_id)
            ->where('status', 1)
            ->get(['id', 'state_id', 'name']);

        return $counties;
    }
    // End Method countyByStateId
}
