<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $currency_list = $this->getCryptocurrencyList();
        $last_news_list = $this->getLastNews();
        $last_notification_list = $this->getLastNotifications();

        $data['currency_list'] = $currency_list;
        $data['last_news_list'] = $last_news_list;
        $data['last_notifications_list'] = $last_notification_list;

        return view('home', $data);
    }
}
