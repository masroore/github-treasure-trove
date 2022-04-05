<?php

namespace App\Http\Controllers;

use App\Plan;
use Auth;
use File;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('manage plan')) {
            $plans = Plan::get();

            return view('plan.index', compact('plans'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function create()
    {
        if (Auth::user()->can('create plan')) {
            $arrDuration = Plan::$arrDuration;

            return view('plan.create', compact('arrDuration'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create plan')) {
            if (('on' == env('ENABLE_STRIPE') && !empty(env('STRIPE_KEY')) && !empty(env('STRIPE_SECRET'))) || ('on' == env('ENABLE_PAYPAL') && !empty(env('PAYPAL_CLIENT_ID')) || !empty(env('PAYPAL_SECRET_KEY')))) {
                $validation = [];
                $validation['name'] = 'required|unique:plans';
                $validation['price'] = 'required|numeric|min:0';
                $validation['duration'] = 'required';
                $validation['max_users'] = 'required|numeric';
                $validation['max_customers'] = 'required|numeric';
                $validation['max_venders'] = 'required|numeric';
                if ($request->image) {
                    $validation['image'] = 'required|max:20480';
                }
                $request->validate($validation);
                $post = $request->all();

                if ($request->hasFile('image')) {
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, \PATHINFO_FILENAME);
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileNameToStore = 'plan_' . time() . '.' . $extension;

                    $dir = storage_path('uploads/plan/');
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $path = $request->file('image')->storeAs('uploads/plan/', $fileNameToStore);
                    $post['image'] = $fileNameToStore;
                }

                if (Plan::create($post)) {
                    return redirect()->back()->with('success', __('Plan Successfully created.'));
                }

                return redirect()->back()->with('error', __('Something is wrong.'));
            }

            return redirect()->back()->with('error', __('Please set stripe or paypal api key & secret key for add new plan.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit($plan_id)
    {
        if (Auth::user()->can('edit plan')) {
            $arrDuration = Plan::$arrDuration;
            $plan = Plan::find($plan_id);

            return view('plan.edit', compact('plan', 'arrDuration'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function update(Request $request, $plan_id)
    {
        if (Auth::user()->can('edit plan')) {
            if (('on' == env('ENABLE_STRIPE') && !empty(env('STRIPE_KEY')) && !empty(env('STRIPE_SECRET'))) || ('on' == env('ENABLE_PAYPAL') && !empty(env('PAYPAL_CLIENT_ID')) || !empty(env('PAYPAL_SECRET_KEY'))) || $request->price <= 0) {
                $plan = Plan::find($plan_id);
                if (!empty($plan)) {
                    $validation = [];
                    $validation['name'] = 'required|unique:plans,name,' . $plan_id;
                    $validation['duration'] = 'required';
                    $validation['max_users'] = 'required|numeric';
                    $validation['max_customers'] = 'required|numeric';
                    $validation['max_venders'] = 'required|numeric';

                    $request->validate($validation);

                    $post = $request->all();

                    if ($request->hasFile('image')) {
                        $filenameWithExt = $request->file('image')->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, \PATHINFO_FILENAME);
                        $extension = $request->file('image')->getClientOriginalExtension();
                        $fileNameToStore = 'plan_' . time() . '.' . $extension;

                        $dir = storage_path('uploads/plan/');
                        if (!file_exists($dir)) {
                            mkdir($dir, 0777, true);
                        }
                        $image_path = $dir . '/' . $plan->image;  // Value is not URL but directory file path
                        if (File::exists($image_path)) {
                            chmod($image_path, 0755);
                            File::delete($image_path);
                        }
                        $path = $request->file('image')->storeAs('uploads/plan/', $fileNameToStore);

                        $post['image'] = $fileNameToStore;
                    }

                    if ($plan->update($post)) {
                        return redirect()->back()->with('success', __('Plan successfully updated.'));
                    }

                    return redirect()->back()->with('error', __('Something is wrong.'));
                }

                return redirect()->back()->with('error', __('Plan not found.'));
            }

            return redirect()->back()->with('error', __('Please set stripe api key & secret key for add new plan.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function userPlan(Request $request)
    {
        $objUser = Auth::user();
        $planID = \Illuminate\Support\Facades\Crypt::decrypt($request->code);
        $plan = Plan::find($planID);
        if ($plan) {
            if ($plan->price <= 0) {
                $objUser->assignPlan($plan->id);

                return redirect()->route('plans.index')->with('success', __('Plan successfully activated.'));
            }

            return redirect()->back()->with('error', __('Something is wrong.'));
        }

        return redirect()->back()->with('error', __('Plan not found.'));
    }
}
