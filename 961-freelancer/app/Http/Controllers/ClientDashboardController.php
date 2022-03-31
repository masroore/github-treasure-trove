<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ClientDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $myJobs = Job::whereuser_id($user_id)->orderBy('created_at', 'DESC')->paginate(5);

        $hiredFreelancers = Job::with('proposal', 'clientInfo')->whereuser_id($user_id)->wherejob_status(2)->orderBy('created_at', 'DESC')->paginate(5);

        // $jobCount = Job::whereuser_id($user_id)->get()
        //   ->groupBy(function($val) {
        //   return Carbon::parse($val->created_at)->format('M');
        // });

        //   $jobCount = Job::selectRaw('COUNT(*) as count, YEAR(created_at) year, MONTH(created_at) month')->whereuser_id($user_id)
        // ->groupBy('year', 'month')
        // ->get();
        // $graph = DB::table('jobs')
        // ->select(DB::raw('MONTH(created_at) as month'),
        //          DB::raw("YEAR(created_at) year"),
        //          DB::raw('ifnull(count(*),0) as totalbook'))
        // ->whereuser_id($user_id)
        // ->groupBy('year', 'month')
        // ->orderBy('created_at', 'asc')
        // ->get();

        // dd($graph);
        return View::make('frontend.client-dashboard')->with([
        'jobs' => $myJobs,
        'hiredFreelancers' => $hiredFreelancers,
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
