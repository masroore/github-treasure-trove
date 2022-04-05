<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\Programme;
use Illuminate\Http\Request;

class ProgrammeController extends Controller
{
    public function index()
    {
        $program = Programme::all();
        // dd($program);
        return view('programmes.new_programme', ['program' => $program]);
    }

    public function editprogramme($id)
    {
        $program = Programme::where('id', $id)->first();

        return view('programmes.edit_programme', ['program' => $program]);
    }

    public function update(Request $Request)
    {
        $id = $Request->post('hiddenid');
        $name = $Request->post('name');
        $type = $Request->post('typeofp');
        $code = $Request->post('code');
        $duration = $Request->post('duration');
        $depart = $Request->post('department');

        $this->validate($Request, [
            'name' => 'required|min:12|max:255',
            'typeofp' => 'required',
            'code' => 'required|min:3|max:4',
            'duration' => 'required|integer',
            'department' => 'required|min:12|max:255',
        ]);

        $program = Programme::where('id', $id)->first();
        $program->name = $name;
        $program->type = $type;
        $program->code = $code;
        $program->duration = $duration;
        $program->department = $depart;
        $program->save();

        return Redirect()->route('add-programme')->with('message', 'Programme Updated Successfully!');
    }

    public function faculty()
    {
        $faculty = Faculty::all();
        // dd($program);
        return view('programmes.faculty', ['faculty' => $faculty]);
    }

    public function faculty_save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:10|max:255',
        ]);

        $data = [
            'name' => $request->input('name'),
        ];

        $faculty = new Faculty($data);
        $faculty->save();

        return Redirect()->back()->with('message', 'Faculty Added Successfully!');
    }

    public function faculty_delete($id)
    {
        $faculty = Faculty::where('id', $id)->first();
        $faculty->delete();

        return Redirect()->back()->with('message', 'Faculty Deleted Successfully!');
    }
}
