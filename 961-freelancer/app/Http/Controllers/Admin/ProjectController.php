<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProject;
use App\Http\Requests\UpdateProject;
use App\Models\Category;
use App\Models\Countries;
use App\Models\Job;
use App\Models\Skills;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Job::with('clientInfo')->orderBy('created_at', 'DESC')->get();

        return View::make('admin.projects-list')->with([
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        $skills = Skills::get();
        $countries = Countries::get();

        return \View::make('admin.projects-create')->with([
            'categories' => $categories,
            'skills' => $skills,
            'countries' => $countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProject $request)
    {
        $validatedData = $request->validated();

        $job = new Job();
        $job->job_id = time() . Str::random(9);
        $job->user_id = auth()->user()->id;
        $job->job_title = $validatedData['job_title'];
        $job->service_level = $validatedData['service_level'];
        $job->job_type = $validatedData['job_type'];
        $job->hourly_min_price = $request->input('hourly_min_price');
        $job->hourly_max_price = $request->input('hourly_max_price');
        $job->fixed_price = $request->input('fixed_price');
        $job->job_location = $request->input('job_location');
        $job->job_duration = $validatedData['job_duration'];
        $job->job_description = $validatedData['job_description'];
        $job_skills = $validatedData['job_skills'];
        $skills = [];
        foreach ($job_skills as $key => $skill) {
            $skills[] = $skill;
        }
        $job->job_skills = implode(',', $skills);
        // $job_cat = $validatedData['job_cat'];
        // $categories = array();
        // foreach ($job_cat as $key => $cat) {
        //   $categories[] = $cat;
        // }
        $job->job_cat = $validatedData['job_cat'];
        $images = [];
        if ($files = $request->file('job_attachement')) {
            foreach ($files as $file) {
                $imagename = 'job-' . mt_rand(000000, 999999) . '.' . $file->getClientOriginalExtension();
                $extension = $file->getClientOriginalExtension();
                // $imagename= $filename;
                $destinationpath = public_path('assets/images/jobs/');
                $file->move($destinationpath, $imagename);

                $images[] = $imagename;
            }
        }
        $job->job_attachement = implode(',', $images);

        if ($job->save()) {
            return response()->json(['status' => 'true', 'message' => 'Project created successfully'], 200);
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
        $categories = Category::get();
        $skills = Skills::get();
        $countries = Countries::get();
        $getSingleData = Job::find($id);

        return \View::make('admin.projects-update')->with([
            'categories' => $categories,
            'skills' => $skills,
            'countries' => $countries,
            'getSingleData' => $getSingleData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProject $request, $id)
    {
        $validatedData = $request->validated();

        $job = Job::find($id);
        // dd($job);
        $job->job_id = $job->job_id;
        $job->user_id = $job->user_id;
        $job->job_title = $validatedData['job_title'];
        $job->service_level = $validatedData['service_level'];
        $job->job_type = $validatedData['job_type'];
        $job->hourly_min_price = $request->input('hourly_min_price');
        $job->hourly_max_price = $request->input('hourly_max_price');
        $job->fixed_price = $request->input('fixed_price');
        $job->job_location = $request->input('job_location');
        $job->job_duration = $validatedData['job_duration'];
        $job->job_description = $validatedData['job_description'];
        $job_skills = $validatedData['job_skills'];
        $skills = [];
        foreach ($job_skills as $key => $skill) {
            $skills[] = $skill;
        }
        $job->job_skills = implode(',', $skills);
        // $job_cat = $validatedData['job_cat'];
        // $categories = array();
        // foreach ($job_cat as $key => $cat) {
        //   $categories[] = $cat;
        // }
        $job->job_cat = $validatedData['job_cat'];
        $images = [];
        if ('' != $request->file('job_attachement')) {
            if ($files = $request->file('job_attachement')) {
                foreach ($files as $file) {
                    $imagename = 'job-' . mt_rand(000000, 999999) . '.' . $file->getClientOriginalExtension();
                    $extension = $file->getClientOriginalExtension();
                    // $imagename= $filename;
                    $destinationpath = public_path('assets/images/jobs/');
                    $file->move($destinationpath, $imagename);

                    $images[] = $imagename;
                }
            }
        } else {
            foreach (explode(',', $job->job_attachement) as $files) {
                $images[] = $files;
            }
        }
        $job->job_attachement = implode(',', $images);

        if ($job->save()) {
            return response()->json(['status' => 'true', 'message' => 'Project updated successfully'], 200);
        }

        return response()->json(['status' => 'errorr', 'message' => 'error occured please try again'], 200);
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
        $deleteData = Job::find($id);
        if ($deleteData->delete()) {
            return response()->json(['status' => 'true', 'message' => 'Project deleted successfully'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'error occured please try again'], 200);
    }
}
