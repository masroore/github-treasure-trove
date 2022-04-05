<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Auth;
use Illuminate\Http\Request;
use Validator;

class PaymentTypeController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Manage Payment Type')) {
            $paymenttypes = PaymentType::where('created_by', '=', Auth::user()->creatorId())->get();

            return view('paymenttype.index', compact('paymenttypes'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function create()
    {
        if (Auth::user()->can('Create Payment Type')) {
            return view('paymenttype.create');
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Payment Type')) {
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

            $paymenttype = new PaymentType();
            $paymenttype->name = $request->name;
            $paymenttype->created_by = Auth::user()->creatorId();
            $paymenttype->save();

            return redirect()->route('paymenttype.index')->with('success', __('PaymentType  successfully created.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function show(PaymentType $paymenttype)
    {
        return redirect()->route('paymenttype.index');
    }

    public function edit(PaymentType $paymenttype)
    {
        if (Auth::user()->can('Edit Payment Type')) {
            if ($paymenttype->created_by == Auth::user()->creatorId()) {
                return view('paymenttype.edit', compact('paymenttype'));
            }

            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function update(Request $request, PaymentType $paymenttype)
    {
        if (Auth::user()->can('Edit Payment Type')) {
            if ($paymenttype->created_by == Auth::user()->creatorId()) {
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
                $paymenttype->name = $request->name;
                $paymenttype->save();

                return redirect()->route('paymenttype.index')->with('success', __('PaymentType successfully updated.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function destroy(PaymentType $paymenttype)
    {
        if (Auth::user()->can('Delete Payment Type')) {
            if ($paymenttype->created_by == Auth::user()->creatorId()) {
                $paymenttype->delete();

                return redirect()->route('paymenttype.index')->with('success', __('PaymentType successfully deleted.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
