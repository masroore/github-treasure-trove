<?php

namespace App\Http\Controllers\Back;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Imports\ProjectImport;
use App\Models\Back\Dashboard;
use App\Models\Back\Users\Message;
use Bouncer;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Bouncer::assign('admin')->to(auth()->user());
        $dash = new Dashboard();

        $stats = $dash->stats();
        $news = $dash->news(config('settings.category.news'));
        $clicks = $dash->mostClicks();

        return view('back.dashboard', compact('stats', 'news', 'clicks'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tempCustomerDashboard()
    {
        return view('front.account.temp');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
        //Excel::import(new ProjectImport(), 'media/projekti.xlsx');

        return redirect()->back()->with(['success' => 'Testirano!!! :)']);
    }

    public function testTwo()
    {
        return redirect()->back()->with(['success' => 'Testirano i drugi put!!! :)']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function testThree()
    {
        $message = Message::find(4);

        event(new MessageSent($message));

        return redirect()->back()->with(['success' => 'Testirano!!! Poruka poslana']);
    }
}
