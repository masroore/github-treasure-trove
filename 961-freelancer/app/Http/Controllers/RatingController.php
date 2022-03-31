<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRating;
use App\Models\Proposal;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRating $request)
    {
        $validatedData = $request->validated();
        $rating = new Rating();
        $rating->rating_by = auth()->user()->id;
        $rating->rating_to = $request->rating_to;
        $rating->job_id = $request->job_id;
        $rating->proposal_id = $request->proposal_id;
        $rating->general_rating = $validatedData['general_rating'];
        $rating->skills_rating = $validatedData['skills_rating'];
        $rating->work_rating = $validatedData['work_rating'];
        $rating->communication_rating = $validatedData['communication_rating'];
        $rating->feedback = $validatedData['feedback'];

        if ($rating->save()) {
            return response()->json(['status'=>'true', 'message' => 'Rating added successfully'], 200);
        }

        return response()->json(['status'=>'errorr', 'message' => 'error occured please try again'], 200);
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
        $proposal = Proposal::with('job')->wherejob_id($id)->wherestatus(5)->first();

        return View::make('frontend.rating')->with([
        'job_id' => $id,
        'proposal_id' => $proposal->id,
        'proposal_user' => $proposal->user_id,
        'job_user' => $proposal->job->user_id,
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
}
