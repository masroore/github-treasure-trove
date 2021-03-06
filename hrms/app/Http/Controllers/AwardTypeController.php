<?php

namespace App\Http\Controllers;

use App\Models\AwardType;
use Auth;
use Illuminate\Http\Request;
use Validator;

class AwardTypeController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Manage Award Type')) {
            $awardtypes = AwardType::where('created_by', '=', Auth::user()->creatorId())->get();

            return view('awardtype.index', compact('awardtypes'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function create()
    {
        if (Auth::user()->can('Create Award Type')) {
            return view('awardtype.create');
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Award Type')) {
            $validator = Validator::make(
                $request->all(),
                [

                    'name' => 'required|max:20',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $awardtype = new AwardType();
            $awardtype->name = $request->name;
            $awardtype->created_by = Auth::user()->creatorId();
            $awardtype->save();

            return redirect()->route('awardtype.index')->with('success', __('AwardType  successfully created.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function show(AwardType $awardtype)
    {
        return redirect()->route('awardtype.index');
    }

    public function edit(AwardType $awardtype)
    {
        if (Auth::user()->can('Edit Award Type')) {
            if ($awardtype->created_by == Auth::user()->creatorId()) {
                return view('awardtype.edit', compact('awardtype'));
            }

            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function update(Request $request, AwardType $awardtype)
    {
        if (Auth::user()->can('Edit Award Type')) {
            if ($awardtype->created_by == Auth::user()->creatorId()) {
                $validator = Validator::make(
                    $request->all(),
                    [

                        'name' => 'required|max:20',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $awardtype->name = $request->name;
                $awardtype->save();

                return redirect()->route('awardtype.index')->with('success', __('AwardType successfully updated.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function destroy(AwardType $awardtype)
    {
        if (Auth::user()->can('Delete Award Type')) {
            if ($awardtype->created_by == Auth::user()->creatorId()) {
                $awardtype->delete();

                return redirect()->route('awardtype.index')->with('success', __('AwardType successfully deleted.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
