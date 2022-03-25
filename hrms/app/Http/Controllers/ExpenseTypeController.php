<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('Manage Expense Type')) {
            $expensetypes = ExpenseType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('expensetype.index', compact('expensetypes'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function create()
    {
        if (\Auth::user()->can('Create Expense Type')) {
            return view('expensetype.create');
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Expense Type')) {
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

            $expensetype = new ExpenseType();
            $expensetype->name = $request->name;
            $expensetype->created_by = \Auth::user()->creatorId();
            $expensetype->save();

            return redirect()->route('expensetype.index')->with('success', __('ExpenseType  successfully created.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function show(ExpenseType $expensetype)
    {
        return redirect()->route('expensetype.index');
    }

    public function edit(ExpenseType $expensetype)
    {
        if (\Auth::user()->can('Edit Expense Type')) {
            if ($expensetype->created_by == \Auth::user()->creatorId()) {
                return view('expensetype.edit', compact('expensetype'));
            }

            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function update(Request $request, ExpenseType $expensetype)
    {
        if (\Auth::user()->can('Edit Expense Type')) {
            if ($expensetype->created_by == \Auth::user()->creatorId()) {
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

                $expensetype->name = $request->name;
                $expensetype->save();

                return redirect()->route('expensetype.index')->with('success', __('ExpenseType successfully updated.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function destroy(ExpenseType $expensetype)
    {
        if (\Auth::user()->can('Delete Expense Type')) {
            if ($expensetype->created_by == \Auth::user()->creatorId()) {
                $expensetype->delete();

                return redirect()->route('expensetype.index')->with('success', __('ExpenseType successfully deleted.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
