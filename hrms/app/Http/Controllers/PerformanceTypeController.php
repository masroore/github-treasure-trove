<?php

namespace App\Http\Controllers;

use App\Models\Performance_Type;
use Auth;
use Illuminate\Http\Request;
use Validator;

class PerformanceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $performance_types = Performance_Type::where('created_by', '=', Auth::user()->id)->get();

        return view('performance_type.index', compact('performance_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('performance_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        $performance_type = new Performance_Type();
        $performance_type->name = $request->name;
        $performance_type->created_by = Auth::user()->id;
        $performance_type->save();

        return redirect()->back()->with('success', 'Performance Type created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Performance_Type $performance_Type)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $performance_type = Performance_Type::find($id);

        return view('performance_type.edit', compact('performance_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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

        $performance_type = Performance_Type::findOrFail($id);
        $performance_type->name = $request->name;
        $performance_type->save();

        return redirect()->back()->with('success', 'Performance Type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Performance_Type $performance_Type)
    {
    }
}
