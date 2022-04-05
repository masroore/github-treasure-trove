<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Message;

class HomeController extends Controller
{
    public function index()
    {
        $customers = $this->getInactiveUser();
        $Icount = count($customers);
        $Ydrivers = Customer::where('is_allow', '=', 'Y')->where('role', '=', 'D')->get();
        $YdCount = count($Ydrivers);
        $messages = Message::all();
        $Mcount = count($messages);
        $passengers = Customer::where('role', '=', 'P')->get();
        $Pcount = count($passengers);

        return view('dashboard.index', compact('customers', 'Icount', 'YdCount', 'Mcount', 'Pcount'));
    }
}
