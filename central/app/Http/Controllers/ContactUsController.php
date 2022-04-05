<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('contactus');
    }

    public function send(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'email' => 'required|email|max:255',
        ], [
        ], [
            'title' => trans('contactus.subject_title'),
            'content' => trans('contactus.message_title'),
            'email' => trans('contactus.email_title'),
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return redirect()->back()->withInput()->withErrors($errors);
        }

        $user = Auth::user();
        if (null === $user) {
            $user_id = 0;
        } else {
            $user_id = $user->id;
        }

        try {
            $res = Contact::insert([
                'user_id' => $user_id,
                'title' => $data['title'],
                'content' => $data['content'],
                'email' => $data['email'],
                'status' => config('constants.contact_status.requested'),
            ]);

            if (!$res) {
                return redirect()->back()->withInput()->withErrors(['failed' => trans('contactus.failed_msg')]);
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(['failed' => trans('contactus.failed_msg')]);
        }

        return redirect()->route('contactus')->with('success', trans('contactus.success_msg'));
    }
}
