<?php

namespace App\Http\Controllers;

use App\AcademicCalendar;
use App\Academicyear;
use Illuminate\Http\Request;

class AcademicCalandarController extends Controller
{
    public function create_event()
    {
        return view('Calendar.create_event');
    }

    public function create_event_save(Request $request)
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $data = [
            'title' => $request->post('title'),
            'startdate' => $request->post('start'),
            'enddate' => $request->post('end'),
            'border' => $request->post('currColor'),
            'background' => $request->post('currColor'),
            'academicyear' => $year,
            'semester' => $semester,
            'lectid' => auth()->user()->id,
            'coursecode' => 'admin',
            'lecname' => auth()->user()->name,
        ];

        if ($request->has('hiddenid')) {
            AcademicCalendar::where('id', $request->post('hiddenid'))->update($data);
            echo 'Updated';
        } else {
            $new = new AcademicCalendar($data);
            $new->save();
            echo 'successfully';
        }

        exit();
    }

    public function create_event_edit($id)
    {
        $data = AcademicCalendar::where('id', $id)->first();

        return view('Calendar.edit_event', ['data' => $data]);
    }

    public function fetch_events()
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $new = AcademicCalendar::where('coursecode', 'admin')
            ->where('academicyear', $year)
            ->where('semester', $semester)
            ->get()
            ->toArray();

        echo json_encode($new);
    }

    public function create_event_all()
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $data = AcademicCalendar::where('coursecode', 'admin')
            ->where('academicyear', $year)
            ->where('semester', $semester)
            ->get();

        return view('Calendar.all_events', ['data' => $data]);
    }

    public function create_event_delete($id)
    {
        $data = AcademicCalendar::where('id', $id)->first();
        $data->delete();

        return Redirect()->back()->with('message', 'Event Delected Successfully!');
    }
}
