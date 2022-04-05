<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BookingExport;
use App\Exports\CommissionExport;
use App\Exports\EarningExport;
use App\Exports\OwnerExport;
use App\Exports\UserExport;
use App\Exports\VenueExport;
use App\Http\Controllers\Controller;
use App\User;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    // export user detail
    public function exportUser()
    {
        return Excel::download(new UserExport(), 'users-' . date('d-m-Y') . '.csv');
    }

    //ecport owner detail
    public function exportOwner()
    {
        return Excel::download(new OwnerExport(), 'owners-' . date('d-m-Y') . '.csv');
    }

    public function exportVenue()
    {
        return Excel::download(new VenueExport(), 'venues-' . date('d-m-Y') . '.csv');
    }

    public function exportBooking()
    {
        return Excel::download(new BookingExport(), 'bookings-' . date('d-m-Y') . '.csv');
    }

    public function exportCommission()
    {
        return Excel::download(new CommissionExport(), 'commission-' . date('d-m-Y') . '.csv');
    }

    public function exportEarning()
    {
        return Excel::download(new EarningExport(), 'earning-' . date('d-m-Y') . '.csv');
    }
}
