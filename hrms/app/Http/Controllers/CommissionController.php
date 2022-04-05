<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Employee;
use Auth;
use Illuminate\Http\Request;
use Validator;

class CommissionController extends Controller
{
    public function commissionCreate($id)
    {
        $employee = Employee::find($id);

        return view('commission.create', compact('employee'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Commission')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'employee_id' => 'required',
                    'title' => 'required',
                    'amount' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $commission = new Commission();
            $commission->employee_id = $request->employee_id;
            $commission->title = $request->title;
            $commission->amount = $request->amount;
            $commission->created_by = Auth::user()->creatorId();
            $commission->save();

            return redirect()->back()->with('success', __('Commission  successfully created.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function show(Commission $commission)
    {
        return redirect()->route('commision.index');
    }

    public function edit($commission)
    {
        $commission = Commission::find($commission);
        if (Auth::user()->can('Edit Commission')) {
            if ($commission->created_by == Auth::user()->creatorId()) {
                return view('commission.edit', compact('commission'));
            }

            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function update(Request $request, Commission $commission)
    {
        if (Auth::user()->can('Edit Commission')) {
            if ($commission->created_by == Auth::user()->creatorId()) {
                $validator = Validator::make(
                    $request->all(),
                    [

                        'title' => 'required',
                        'amount' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $commission->title = $request->title;
                $commission->amount = $request->amount;
                $commission->save();

                return redirect()->back()->with('success', __('Commission successfully updated.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function destroy(Commission $commission)
    {
        if (Auth::user()->can('Delete Commission')) {
            if ($commission->created_by == Auth::user()->creatorId()) {
                $commission->delete();

                return redirect()->back()->with('success', __('Commission successfully deleted.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
