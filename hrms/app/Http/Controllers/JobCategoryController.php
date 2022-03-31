<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('Manage Job Category')) {
            $categories = JobCategory::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('jobCategory.index', compact('categories'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function create()
    {
        return view('jobCategory.create');
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Job Category')) {
            $validator = \Validator::make(
                $request->all(),
                [
                                   'title' => 'required',
                               ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $jobCategory = new JobCategory();
            $jobCategory->title = $request->title;
            $jobCategory->created_by = \Auth::user()->creatorId();
            $jobCategory->save();

            return redirect()->back()->with('success', __('Job category  successfully created.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function show(JobCategory $jobCategory)
    {

    }

    public function edit(JobCategory $jobCategory)
    {
        return view('jobCategory.edit', compact('jobCategory'));
    }

    public function update(Request $request, JobCategory $jobCategory)
    {
        if (\Auth::user()->can('Edit Job Category')) {
            $validator = \Validator::make(
                $request->all(),
                [
                                   'title' => 'required',
                               ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $jobCategory->title = $request->title;
            $jobCategory->save();

            return redirect()->back()->with('success', __('Job category  successfully updated.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function destroy(JobCategory $jobCategory)
    {
        if (\Auth::user()->can('Delete Job Category')) {
            if ($jobCategory->created_by == \Auth::user()->creatorId()) {
                $jobCategory->delete();

                return redirect()->back()->with('success', __('Job category successfully deleted.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}