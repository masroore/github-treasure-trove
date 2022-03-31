<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skills;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = Skills::get();

        return \View::make('admin.skills-list')->with([
          'skills' => $skills,
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \View::make('admin.skill-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $skill = new Skills();
        $skill->skill_name = $request->input('skill_name');

        if ($skill->save()) {
            return response()->json(['status'=>'true', 'message' => 'Skill added successfully'], 200);
        }

        return response()->json(['status'=>'errorr', 'message' => 'error occured please try again'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $getSingleData = Skills::find($id);

        return \View::make('admin.skill-update', compact('getSingleData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $findData = Skills::find($id);
        $findData->skill_name = $request->input('skill_name');

        if ($findData->save()) {
            return response()->json(['status'=>'true', 'message' => 'Skill updated successfully'], 200);
        }

        return response()->json(['status'=>'errorr', 'message' => 'error occured please try again'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteData = Skills::find($id);
        if ($deleteData->delete()) {
            return response()->json(['status'=>'true', 'message' => 'Skill deleted successfully'], 200);
        }

        return response()->json(['status'=>'error', 'message' => 'error occured please try again'], 200);
    }
}
