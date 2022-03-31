<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class FreelancerDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $freelancerJobs = Proposal::with('job')->whereuser_id($user_id)->wherestatus(2)->orderBy('created_at', 'DESC')->paginate(5);

        $completedJobs = Proposal::with('job', 'freelancerRating')->whereuser_id($user_id)->wherestatus(5)->orderBy('created_at', 'DESC')->paginate(5);

        $monthlySale = Proposal::with('job', 'freelancerRating')->whereuser_id($user_id)->wherestatus(5)->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->updated_at)->format('M');
            });

        // dd(count($monthlySale['Dec']));
        return View::make('frontend.freelancer-dashboard')->with([
        'freelancerOngoingJobs' => $freelancerJobs,
        'completedJobs' => $completedJobs,
        'monthlySale' => $monthlySale,
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
}
