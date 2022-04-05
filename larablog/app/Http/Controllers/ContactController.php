<?php

namespace App\Http\Controllers;

use App\Mail\ContactMe;
use Illuminate\Support\Facades\Mail;
use function request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function getMessage()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required | email',
            'message' => 'required',
        ]);

        $received_email = request('email');
        $name = request('name');
        $message = request('message');

        Mail::to($received_email)->send(new ContactMe($name, $message)); // queue a mail message

        return response()->json(['success' => 'Your message is successfully sent']); // return notification on ajax success
    }
}
