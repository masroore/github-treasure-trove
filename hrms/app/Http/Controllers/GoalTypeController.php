<?php

namespace App\Http\Controllers;

use App\Models\GoalType;
use Auth;
use Illuminate\Http\Request;
use Validator;

class GoalTypeController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Manage Goal Type')) {
            $goaltypes = GoalType::where('created_by', '=', Auth::user()->creatorId())->get();

            return view('goaltype.index', compact('goaltypes'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function create()
    {
        if (Auth::user()->can('Create Goal Type')) {
            return view('goaltype.create');
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Goal Type')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $goaltype = new GoalType();
            $goaltype->name = $request->name;
            $goaltype->created_by = Auth::user()->creatorId();
            $goaltype->save();

            return redirect()->route('goaltype.index')->with('success', __('GoalType  successfully created.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function show(GoalType $goalType): void
    {
    }

    public function edit($id)
    {
        if (Auth::user()->can('Edit Goal Type')) {
            $goalType = GoalType::find($id);

            return view('goaltype.edit', compact('goalType'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('Edit Goal Type')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $goalType = GoalType::find($id);
            $goalType->name = $request->name;
            $goalType->save();

            return redirect()->route('goaltype.index')->with('success', __('GoalType  successfully updated.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function destroy($id)
    {
        if (Auth::user()->can('Delete Goal Type')) {
            $goalType = GoalType::find($id);
            if ($goalType->created_by == Auth::user()->creatorId()) {
                $goalType->delete();

                return redirect()->route('goaltype.index')->with('success', __('GoalType successfully deleted.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
