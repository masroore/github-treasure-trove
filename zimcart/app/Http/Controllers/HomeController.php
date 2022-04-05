<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Order;
use App\Product;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();
        $orders = Order::count();
        $products = Product::count();
        $messages = Contact::count();

        return view('home', compact('products', 'users', 'messages', 'orders'));
    }
}
