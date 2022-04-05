<?php

namespace App\Http\Controllers;

use App\Genral;
use App\Mail\SendFeedback;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mail;

class SendFeedBackController extends Controller
{
    public function send(Request $request)
    {
        $feedback = [
            'name' => $request->name,
            'email' => $request->email,
            'msg' => $request->msg,
            'rate' => $request->rate,
        ];

        $defaultemail = Genral::findorfail(1)->email;

        try {
            Mail::to($defaultemail)->send(new SendFeedback($feedback));
        } catch (Exception $e) {
            Log::error('Mail sent fail for feedback reason :', $e->getMessage());
        }

        notify()->success(__('Sent ! Thankyou for valuable feedback !'));

        return back();
    }
}
