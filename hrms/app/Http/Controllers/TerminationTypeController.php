<?php

namespace App\Http\Controllers;

use App\Models\TerminationType;
use Illuminate\Http\Request;

class TerminationTypeController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('Manage Termination Type')) {
            $terminationtypes = TerminationType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('terminationtype.index', compact('terminationtypes'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function create()
    {
        if (\Auth::user()->can('Create Termination Type')) {
            return view('terminationtype.create');
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Termination Type')) {
            $validator = \Validator::make(
                $request->all(),
                [
                                   'name' => 'required',
                               ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $terminationtype = new TerminationType();
            $terminationtype->name = $request->name;
            $terminationtype->created_by = \Auth::user()->creatorId();
            $terminationtype->save();

            return redirect()->route('terminationtype.index')->with('success', __('TerminationType  successfully created.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function show(TerminationType $terminationtype)
    {
        return redirect()->route('terminationtype.index');
    }

    public function edit(TerminationType $terminationtype)
    {
        if (\Auth::user()->can('Edit Termination Type')) {
            if ($terminationtype->created_by == \Auth::user()->creatorId()) {
                return view('terminationtype.edit', compact('terminationtype'));
            }

            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function update(Request $request, TerminationType $terminationtype)
    {
        if (\Auth::user()->can('Edit Termination Type')) {
            if ($terminationtype->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                                       'name' => 'required|max:20',

                                   ]
                );

                $terminationtype->name = $request->name;
                $terminationtype->save();

                return redirect()->route('terminationtype.index')->with('success', __('TerminationType successfully updated.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function destroy(TerminationType $terminationtype)
    {
        if (\Auth::user()->can('Delete Termination Type')) {
            if ($terminationtype->created_by == \Auth::user()->creatorId()) {
                $terminationtype->delete();

                return redirect()->route('terminationtype.index')->with('success', __('TerminationType successfully deleted.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
