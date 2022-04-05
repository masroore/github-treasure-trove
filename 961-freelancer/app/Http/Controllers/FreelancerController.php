<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Countries;
use App\Models\Language;
use App\Models\ReportUser;
use App\Models\SaveItem;
use App\Models\User;
use App\Models\UserLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class FreelancerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $freelancers = User::with('userSkills', 'saveInfo', 'freelancerRating')->withCount('freelancerRating')->whereaccount_type('Freelancer')->paginate(10);
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
        $username = $id;
        $freelancer = User::with('userInfo', 'education', 'userSkills', 'userProjects', 'certificates', 'freelancerRating')->withCount('freelancerRating')->whereusername($username)->first();
        // dd($freelancer);
        $rating_avg = 0.0;
        $total = 0;
        foreach ($freelancer->freelancerRating as $rating) {
            $total = $total + $rating->general_rating;
            $rating_avg = $total / $freelancer->freelancer_rating_count;
        }

        return View::make('frontend.user')->with([
            'freelancer' => $freelancer,
            'rating_avg' => $rating_avg,
        ]);
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

    // Saved Items
    public function savedItems(Request $request)
    {
        $user_id = auth()->user()->id;
        $getSavedFreelancer = SaveItem::with('userData')->whereuser_id($user_id)->where('save_type', 'Freelancer')->where('status', 1)->get();
        $countFreelancer = $getSavedFreelancer->count();

        $getSavedjob = SaveItem::with('jobData')->whereuser_id($user_id)->where('save_type', 'Job')->where('status', 1)->get();
        $jobCount = $getSavedjob->count();

        return View::make('frontend.saved-items')->with([
            'saveFreelancers' => $getSavedFreelancer,
            'freelancerCount' => $countFreelancer,
            'saveJobs' => $getSavedjob,
            'jobCount' => $jobCount,
        ]);
    }

    public function saveFreelancer(Request $request)
    {
        $user_id = auth()->user()->id;
        $freelancer_id = $request->input('freelancer_id');

        $save = new SaveItem();

        $data = SaveItem::where('freelancer_id', $freelancer_id)->where('user_id', $user_id)->where('save_type', 'Freelancer')->first();
        if ($data) {
            if (1 == $data->status) {
                $update = SaveItem::where('freelancer_id', $freelancer_id)->where('user_id', $user_id)->update(['status' => 0]);

                return 2;
            }
            $update = SaveItem::where('freelancer_id', $freelancer_id)->where('user_id', $user_id)->update(['status' => 1]);

            return 1;
        }
        $save->user_id = $user_id;
        $save->freelancer_id = $request->input('freelancer_id');
        $save->save_type = $request->input('save_type');
        $save->status = 1;
        $save->save();

        return 1;
    }

    public function saveJob(Request $request)
    {
        $user_id = auth()->user()->id;
        $job_id = $request->input('job_id');

        $save = new SaveItem();

        $data = SaveItem::where('job_id', $job_id)->where('user_id', $user_id)->where('save_type', 'Job')->first();
        if ($data) {
            if (1 == $data->status) {
                $update = SaveItem::where('job_id', $job_id)->where('user_id', $user_id)->update(['status' => 0]);

                return 2;
            }
            $update = SaveItem::where('job_id', $job_id)->where('user_id', $user_id)->update(['status' => 1]);

            return 1;
        }
        $save->user_id = $user_id;
        $save->job_id = $request->input('job_id');
        $save->save_type = $request->input('save_type');
        $save->status = 1;
        $save->save();

        return 1;
    }

    // Filter Freelancers
    public function getFreelancers(Request $request)
    {
        // dd($request->all());
        $hourly_rate = $request->input('hourly_rate');
        $tagline = $request->input('tagline');
        $location = $request->input('user_location');
        $clear = $request->input('clear');
        // dd($tagline);

        if ('' != $tagline) {
            if ('all' == $tagline) {
                $freelancers = User::with('userSkills', 'saveInfo', 'freelancerRating')->withCount('freelancerRating')->whereaccount_type('Freelancer')->paginate(10);
            } else {
                $freelancers = User::with('userSkills', 'saveInfo', 'freelancerRating')->withCount('freelancerRating')->whereaccount_type('Freelancer')->where('tagline', 'like', '%' . $tagline . '%')->paginate(10);
            }
        }
        if ('' != $location) {
            $freelancers = User::with('userSkills', 'saveInfo', 'freelancerRating')->withCount('freelancerRating')->whereaccount_type('Freelancer')->where('country', 'like', '%' . $location . '%')->paginate(10);
        } else {
            $freelancers = User::with('userSkills', 'saveInfo', 'freelancerRating')->withCount('freelancerRating')->whereaccount_type('Freelancer')->paginate(10);
        }
        // else{
        //   $freelancers = User::with('userSkills','saveInfo','freelancerRating')->withCount('freelancerRating')->whereaccount_type('Freelancer')->paginate(10);
        // }
        if ('' != $hourly_rate) {
            if (9 == $hourly_rate) {
                $min_rate = 0;
                $max_rate = 9;
            } elseif (91 == $hourly_rate) {
                $min_rate = 91;
                $max_rate = 500;
            } else {
                $hour_price = explode('-', $hourly_rate);
                $min_rate = $hour_price[0];
                $max_rate = $hour_price[1];
            }

            // dd($max_rate);
            $freelancers = User::with('userSkills', 'saveInfo', 'freelancerRating')->withCount('freelancerRating')->whereaccount_type('Freelancer')->whereBetween('hourly_rate', [(int) $min_rate, (int) $max_rate])->paginate(10);
        }

        if ($clear) {
            $freelancers = User::with('userSkills', 'saveInfo', 'freelancerRating')->withCount('freelancerRating')->whereaccount_type('Freelancer')->paginate(10);
        }

        return View::make('frontend.ajax.get-freelancers')->with([
            'freelancers' => $freelancers,
        ]);
    }

    // Language Search
    public function languageSearch(Request $request)
    {
        $keyword = $request->lang_keyword;
        $get_languge = Language::where('language_name', 'like', '%' . $keyword . '%')->get();

        return View::make('frontend.ajax.language-filter')->with([
            'languages' => $get_languge,
        ]);
    }

    // Filter Freelancer Using Language
    public function getFreelancersLang(Request $request)
    {
        $language_id = $request->user_lang;
        if ('' != $language_id) {
            $freelancers = UserLanguage::with('freelancer', 'freelancerRating')->withCount('freelancerRating')->where('language_id', $language_id)->paginate(10);

            return View::make('frontend.ajax.get-freelancers-language')->with([
                'freelancers' => $freelancers,
            ]);
        }
        $freelancers = User::with('userSkills', 'saveInfo', 'freelancerRating')->withCount('freelancerRating')->whereaccount_type('Freelancer')->paginate(10);

        return View::make('frontend.ajax.get-freelancers')->with([
            'freelancers' => $freelancers,
        ]);

        // dd($freelancers->freelancer);
    }

    // Freelancer Dashboard
    public function freelancerDashboard(Request $request)
    {
        return View::make('frontend.freelancer-dashboard');
    }

    public function clientDashboard(Request $request)
    {
        return View::make('frontend.client-dashboard');
    }

    // Client Single Page
    public function client(Request $request, $username)
    {
        $client = User::with('userInfo', 'certificates', 'freelancerRating')->withCount('freelancerRating')->whereusername($username)->first();
        // dd($freelancer);
        $rating_avg = 0.0;
        $total = 0;
        foreach ($client->freelancerRating as $rating) {
            $total = $total + $rating->general_rating;
            $rating_avg = $total / $client->freelancer_rating_count;
        }

        return View::make('frontend.client')->with([
            'client' => $client,
            'rating_avg' => $rating_avg,
        ]);
    }

    // Report User
    public function reportUser(Request $request)
    {
        // dd($request->all());
        $report = ReportUser::create($request->all());
        if ($report) {
            return response()->json(['status' => 'true', 'message' => 'Freelancer reported successfully'], 200);
        }

        return response()->json(['status' => 'true', 'message' => 'Freelancer reported successfully'], 200);
    }
}
