<?php

namespace App\Http\Controllers;

use App\Models\PayslipType;
use Auth;
use Illuminate\Http\Request;
use Validator;

class PayslipTypeController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Manage Payslip Type')) {
            $paysliptypes = PayslipType::where('created_by', '=', Auth::user()->creatorId())->get();

            return view('paysliptype.index', compact('paysliptypes'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function create()
    {
        if (Auth::user()->can('Create Payslip Type')) {
            return view('paysliptype.create');
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Payslip Type')) {
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
            $paysliptype = new PayslipType();
            $paysliptype->name = $request->name;
            $paysliptype->created_by = Auth::user()->creatorId();
            $paysliptype->save();

            return redirect()->route('paysliptype.index')->with('success', __('PayslipType  successfully created.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function show(PayslipType $paysliptype)
    {
        return redirect()->route('paysliptype.index');
    }

    public function edit(PayslipType $paysliptype)
    {
        if (Auth::user()->can('Edit Payslip Type')) {
            if ($paysliptype->created_by == Auth::user()->creatorId()) {
                return view('paysliptype.edit', compact('paysliptype'));
            }

            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function update(Request $request, PayslipType $paysliptype)
    {
        if (Auth::user()->can('Edit Payslip Type')) {
            if ($paysliptype->created_by == Auth::user()->creatorId()) {
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

                $paysliptype->name = $request->name;
                $paysliptype->save();

                return redirect()->route('paysliptype.index')->with('success', __('PayslipType successfully updated.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function destroy(PayslipType $paysliptype)
    {
        if (Auth::user()->can('Delete Payslip Type')) {
            if ($paysliptype->created_by == Auth::user()->creatorId()) {
                $paysliptype->delete();

                return redirect()->route('paysliptype.index')->with('success', __('PayslipType successfully deleted.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
