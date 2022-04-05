<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassroomStoreRequest;
use App\Http\Requests\ClassroomUpdateRequest;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $classrooms = Classroom::all();

        return view('classroom.index', compact('classrooms'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('classroom.create')->with('location', $request->location);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(ClassroomStoreRequest $request)
    {
        $classroom = Classroom::create($request->validated());

        $request->session()->flash('classroom.id', $classroom->id);

        return redirect()->route('classroom.index');
    }

    /**
     * @param \App\Classroom $classroom
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Classroom $classroom)
    {
        return view('classroom.show', compact('classroom'))->with('photos', $classroom->getMedia('classrooms'));
    }

    /**
     * @param \App\Classroom $classroom
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Classroom $classroom)
    {
        return view('classroom.edit', compact('classroom'));
    }

    /**
     * @param \App\Classroom $classroom
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ClassroomUpdateRequest $request, Classroom $classroom)
    {
        $classroom->update($request->validated());

        $request->session()->flash('classroom.id', $classroom->id);

        return redirect()->route('classroom.index');
    }

    /**
     * @param \App\Classroom $classroom
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Classroom $classroom)
    {
        $classroom->delete();

        return redirect()->route('classroom.index');
    }
}
