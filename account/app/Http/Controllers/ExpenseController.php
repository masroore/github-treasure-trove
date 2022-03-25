<?php

namespace App\Http\Controllers;

use App\Expense;
use App\ExpensesCategory;
use App\User;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('manage expense') || 'client' == \Auth::user()->type) {
            if ('client' == \Auth::user()->type) {
                $expenses = Expense::select('expenses.*', 'projects.name')->join('projects', 'projects.id', '=', 'expenses.project')->where('projects.client', '=', \Auth::user()->id)->where('expenses.created_by', '=', \Auth::user()->creatorId())->get();
            } else {
                $expenses = Expense::where('created_by', '=', \Auth::user()->creatorId())->get();
            }

            return view('expenses.index')->with('expenses', $expenses);
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function create()
    {
        if (\Auth::user()->can('create expense')) {
            $category = ExpensesCategory::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $projects = \Auth::user()->projects->pluck('name', 'id');
            $users = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '!=', 'client')->get()->pluck('name', 'id');

            return view('expenses.create', compact('category', 'projects', 'users'));
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create expense')) {
            $rules = [
                'category_id' => 'required',
                'amount' => 'required',
                'date' => 'required',
                'project_id' => 'required',
            ];
            if ($request->attachment) {
                $rules['attachment'] = 'required|max:2048';
            }

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('expenses.index')->with('error', $messages->first());
            }

            $expense = new Expense();
            $expense->category_id = $request->category_id;
            $expense->description = $request->description;
            $expense->amount = $request->amount;
            $expense->date = $request->date;
            $expense->project = $request->project_id;
            $expense->user_id = $request->user_id;
            $expense->created_by = \Auth::user()->creatorId();
            $expense->save();

            if ($request->attachment) {
                $imageName = 'expense_' . $expense->id . '_' . $request->attachment->getClientOriginalName();
                $request->attachment->storeAs('public/attachment', $imageName);
                $expense->attachment = $imageName;
                $expense->save();
            }

            return redirect()->route('expenses.index')->with('success', __('Expense successfully created.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit(Expense $expense)
    {
        if (\Auth::user()->can('edit expense')) {
            if ($expense->created_by == \Auth::user()->creatorId()) {
                $category = ExpensesCategory::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $projects = \Auth::user()->projects->pluck('name', 'id');
                $users = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '!=', 'client')->get()->pluck('name', 'id');

                return view('expenses.edit', compact('expense', 'category', 'projects', 'users'));
            }

            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function update(Request $request, Expense $expense)
    {
        if (\Auth::user()->can('edit expense')) {
            if ($expense->created_by == \Auth::user()->creatorId()) {
                $rules = [
                    'category_id' => 'required',
                    'amount' => 'required',
                    'date' => 'required',
                    'project_id' => 'required',
                ];
                if ($request->attachment) {
                    $rules['attachment'] = 'required|max:2048';
                }

                $validator = \Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('expenses.index')->with('error', $messages->first());
                }
                $expense->category_id = $request->category_id;
                $expense->description = $request->description;
                $expense->amount = $request->amount;
                $expense->date = $request->date;
                $expense->project = $request->project_id;
                $expense->user_id = $request->user_id;
                $expense->save();

                if ($request->attachment) {
                    if ($expense->attachment) {
                        \File::delete(storage_path('uploads/attachment/' . $expense->attachment));
                    }
                    $imageName = 'expense_' . $expense->id . '_' . $request->attachment->getClientOriginalName();
                    $request->attachment->storeAs('attachment', $imageName);
                    $expense->attachment = $imageName;
                    $expense->save();
                }

                return redirect()->route('expenses.index')->with('success', __('Expense successfully updated.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function destroy(Expense $expense)
    {
        if (\Auth::user()->can('delete expense')) {
            if ($expense->created_by == \Auth::user()->creatorId()) {
                $expense->delete();

                return redirect()->route('expenses.index')->with('success', __('Expense successfully deleted.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
