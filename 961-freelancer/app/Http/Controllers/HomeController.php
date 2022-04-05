<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Countries;
use App\Models\Job;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Mail;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::limit(8)->get();

        return View::make('frontend.index')->with([
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact = new Contact();
        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        $contact->subject = $request->input('subject');
        $contact->comments = $request->input('comments');

        if ($contact->save()) {
            $contact->id;
            $new_user = Contact::find($contact->id);
            $toemail = 'peek.zeeshan@gmail.com';
            Mail::send(
                'mail.contact-email',
                ['user' => $new_user],
                function ($message) use ($toemail): void {
                    $message->subject('961Freelancer - Contact Us');
                    $message->from('support@961freelancer.com', '961Freelancer');
                    $message->to($toemail);
                }
            );

            return response()->json(['status' => 'true', 'message' => 'Your message sent successfully'], 200);
        }

        return response()->json(['status' => 'errorr', 'message' => 'error occured please try again'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    // Categories

    public function allCategories(Request $request)
    {
        $categories = Category::get();

        return View::make('frontend.categories')->with([
            'categories' => $categories,
        ]);
    }

    // Contact Us
    public function contactUs(Request $request)
    {
        return View::make('frontend.contact-us');
    }

    // About Us
    public function aboutUs(Request $request)
    {
        return View::make('frontend.about');
    }

    // How it Works
    public function howWorks(Request $request)
    {
        return View::make('frontend.how-it-works');
    }

    // How it Works
    public function helpSupport(Request $request)
    {
        return View::make('frontend.help-support');
    }

    // Main Search
    public function search(Request $request)
    {
        if ('freelancer' == $request->searchtype) {
            if ('' != $request->keyword) {
                $freelancers = User::with('userSkills', 'saveInfo', 'freelancerRating')->withCount('freelancerRating')->whereaccount_type('Freelancer')->where('first_name', 'like', '%' . $request->keyword . '%')->orWhere('last_name', 'like', '%' . $request->keyword . '%')->orWhere('tagline', 'like', '%' . $request->keyword . '%')->orWhere('username', 'like', '%' . $request->keyword . '%')->orWhere('description', 'like', '%' . $request->keyword . '%')->orWhere('country', 'like', '%' . $request->keyword . '%')->paginate(10);
            } else {
                $freelancers = User::with('userSkills', 'saveInfo', 'freelancerRating')->withCount('freelancerRating')->whereaccount_type('Freelancer')->paginate(10);
            }
            $categories = Category::all();
            $countries = Countries::all();
            $languages = Language::all();

            return View::make('frontend.freelancers')->with([
                'freelancers' => $freelancers,
                'categories' => $categories,
                'countries' => $countries,
                'languages' => $languages,
            ]);
        }
        if ('' != $request->keyword) {
            $jobs = Job::with('saveJobs')->where('job_status', 1)->where('job_title', 'like', '%' . $request->keyword . '%')->orWhere('job_description', 'like', '%' . $request->keyword . '%')->orWhere('job_skills', 'like', '%' . $request->keyword . '%')->orWhere('job_cat', 'like', '%' . $request->keyword . '%')->orWhere('service_level', 'like', '%' . $request->keyword . '%')->orWhere('job_location', 'like', '%' . $request->keyword . '%')->orWhere('job_duration', 'like', '%' . $request->keyword . '%')->orWhere('job_type', 'like', '%' . $request->keyword . '%')->orderBy('created_at', 'DESC')->paginate(10);
        } else {
            $jobs = Job::with('saveJobs')->where('job_status', 1)->orderBy('created_at', 'DESC')->paginate(10);
        }

        $categories = Category::get();
        $countries = Countries::get();

        return View::make('frontend.job-listings')->with([
            'jobs' => $jobs,
            'categories' => $categories,
            'countries' => $countries,
        ]);
    }
}
