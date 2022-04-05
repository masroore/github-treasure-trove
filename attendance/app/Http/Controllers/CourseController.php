<?php

namespace App\Http\Controllers;

use App\Course;
use App\LecCource;
use App\Programme;
use App\Programmecourse;
use App\Staff;
use App\User;
use DB;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function pro_degree()
    {
        $program = Programme::all();
        $course = Course::where('program', 'Degree')
            ->where('level', 'Level 100')->get();
        //dd($code);
        return view('course_management.new_level_1course', [
            'program' => $program,
            'course' => $course, ]);
    }

    public function pro_degree_update1($id)
    {
        $course = Course::where('id', $id)->first();

        return view('course_management.edit_level_1course', ['course' => $course]);
    }

    public function pro_degree_update1_save(Request $Request)
    {
        $this->validate($Request, [
            'name' => 'required|min:8|max:255',
            'chrs' => 'required|integer',
            'code' => 'required',
            'type' => 'required',
        ]);

        $id = $Request->post('hiddenid');
        $course = Course::where('id', $id)->first();
        $course->title = $Request->post('name');
        $course->code = $Request->post('code');
        $course->type = $Request->post('type');
        $course->credithours = $Request->post('chrs');
        $course->save();

        toastr()->success('Course Update Successfully!');

        return Redirect()->route('add-course-degreel1');
    }

    //level 200

    public function pro_degree_200()
    {
        $program = Programme::all();
        $course = Course::where('program', 'Degree')
            ->where('level', 'Level 200')->get();
        //dd($code);
        return view('course_management.new_level_2course', [
            'program' => $program,
            'course' => $course, ]);
    }

    public function pro_degree_update2($id)
    {
        $course = Course::where('id', $id)->first();

        return view('course_management.edit_level_2course', ['course' => $course]);
    }

    public function pro_degree_update2_save(Request $Request)
    {
        $this->validate($Request, [
            'name' => 'required|min:8|max:255',
            'chrs' => 'required|integer',
            'code' => 'required',
            'type' => 'required',
        ]);

        $id = $Request->post('hiddenid');
        $course = Course::where('id', $id)->first();
        $course->title = $Request->post('name');
        $course->code = $Request->post('code');
        $course->type = $Request->post('type');
        $course->credithours = $Request->post('chrs');
        $course->save();
        toastr()->success('Course Update Successfully!');

        return Redirect()->route('add-course-degreel2');
    }

    //300

    public function pro_degree_300()
    {
        $program = Programme::all();
        $course = Course::where('program', 'Degree')
            ->where('level', 'Level 300')->get();
        //dd($code);
        return view('course_management.new_level_3course', [
            'program' => $program,
            'course' => $course, ]);
    }

    public function pro_degree_update3($id)
    {
        $course = Course::where('id', $id)->first();

        return view('course_management.edit_level_3course', ['course' => $course]);
    }

    public function pro_degree_update3_save(Request $Request)
    {
        $this->validate($Request, [
            'name' => 'required|min:8|max:255',
            'chrs' => 'required|integer',
            'code' => 'required',
            'type' => 'required',
        ]);

        $id = $Request->post('hiddenid');
        $course = Course::where('id', $id)->first();
        $course->title = $Request->post('name');
        $course->code = $Request->post('code');
        $course->type = $Request->post('type');
        $course->credithours = $Request->post('chrs');
        $course->save();
        toastr()->success('Course Update Successfully!');

        return Redirect()->route('add-course-degreel3');
    }

    //400

    public function pro_degree_400()
    {
        $program = Programme::all();
        $course = Course::where('program', 'Degree')
            ->where('level', 'Level 400')->get();
        //dd($code);
        return view('course_management.new_level_4course', [
            'program' => $program,
            'course' => $course, ]);
    }

    public function pro_degree_update4($id)
    {
        $course = Course::where('id', $id)->first();

        return view('course_management.edit_level_4course', ['course' => $course]);
    }

    public function pro_degree_update4_save(Request $Request)
    {
        $this->validate($Request, [
            'name' => 'required|min:8|max:255',
            'chrs' => 'required|integer',
            'code' => 'required',
            'type' => 'required',
        ]);

        $id = $Request->post('hiddenid');
        $course = Course::where('id', $id)->first();
        $course->title = $Request->post('name');
        $course->code = $Request->post('code');
        $course->type = $Request->post('type');
        $course->credithours = $Request->post('chrs');
        $course->save();
        toastr()->success('Course Update Successfully!');

        return Redirect()->route('add-course-degreel4');
    }

    //Diploma programme
    public function pro_diploma()
    {
        $program = Programme::all();
        $course = Course::where('program', 'Diploma')
            ->where('level', 'Level 100')->get();
        //dd($code);
        return view('course_management.new_level_1dcourse', [
            'program' => $program,
            'course' => $course, ]);
    }

    public function pro_diploma_update1($id)
    {
        $course = Course::where('id', $id)->first();

        return view('course_management.edit_level_1dcourse', ['course' => $course]);
    }

    public function pro_diploma_update1_save(Request $Request)
    {
        $this->validate($Request, [
            'name' => 'required|min:8|max:255',
            'chrs' => 'required|integer',
            'code' => 'required',
            'type' => 'required',
        ]);

        $id = $Request->post('hiddenid');
        $course = Course::where('id', $id)->first();
        $course->title = $Request->post('name');
        $course->code = $Request->post('code');
        $course->type = $Request->post('type');
        $course->credithours = $Request->post('chrs');
        $course->save();
        toastr()->success('Course Update Successfully!');

        return Redirect()->route('add-course-diploma1');
    }

    // Diploma level 200

    public function pro_diploma2()
    {
        $program = Programme::all();
        $course = Course::where('program', 'Diploma')
            ->where('level', 'Level 200')->get();
        //dd($code);
        return view('course_management.new_level_2dcourse', [
            'program' => $program,
            'course' => $course, ]);
    }

    public function pro_diploma_update2($id)
    {
        $course = Course::where('id', $id)->first();

        return view('course_management.edit_level_2dcourse', ['course' => $course]);
    }

    public function pro_diploma_update2_save(Request $Request)
    {
        $this->validate($Request, [
            'name' => 'required|min:8|max:255',
            'chrs' => 'required|integer',
            'code' => 'required',
            'type' => 'required',
        ]);

        $id = $Request->post('hiddenid');
        $course = Course::where('id', $id)->first();
        $course->title = $Request->post('name');
        $course->code = $Request->post('code');
        $course->type = $Request->post('type');
        $course->credithours = $Request->post('chrs');
        $course->save();
        toastr()->success('Course Update Successfully!');

        return Redirect()->route('add-course-diploma2');
    }

    //programme course Assignment

    public function firstsemster_bprm($code)
    {

        //get programme from code
        $prog = Programme::where('code', $code)->first();

        $course = Course::where('level', 'Level 100')
            ->where('program', 'Degree')->get();

        $procourse = Programmecourse::where('progcode', $code)
            ->where('semester', 'First Semester')
            ->where('level', 'Level 100')->get();

        return view('course_management.first_semester_bprm', [
            'course' => $course,
            'procode' => $prog,
            'procourse' => $procourse, ]);
    }

    public function firstsemster_bprm_save(Request $Request, $code)
    {
        $prog = $Request->input('programme');
        $progcode = $code;
        $semester = $Request->input('semester');
        $courses = $Request->input('course');

        $count = \count($courses);

        for ($i = 0; $i < $count; ++$i) {
            $id = $courses[$i];

            //fetch cousre from database first
            $course = Course::where('id', $id)->first();

            $cousertitle = $course->title;
            $cousecode = $course->code;
            $courech = $course->credithours;

            // echo $cousertitle." | ".$cousecode." | ".$courech."<br>";

            //insert values Into Database
            $data = ['programme' => $prog,
                'progcode' => $progcode,
                'semester' => $semester,
                'coursetitle' => $cousertitle,
                'coursecode' => $cousecode,
                'credithours' => $courech,
                'level' => 'Level 100',
            ];

            $progcourse = new Programmecourse($data);
            $progcourse->save();
        }

        toastr()->success('First Semester Course(s) Added Successfully!');

        return Redirect()->back();
    }

    public function firstsemster_bprm_delete($id)
    {
        $progcourse = Programmecourse::where('id', $id)->first();
        $progcourse->delete();
        toastr()->success('Course Deleted Successfully!');

        return Redirect()->back();
    }

    //BPMP SECOND SEMESTER HERE
    public function secondsemster_bprm($code)
    {
        $prog = Programme::where('code', $code)->first();

        $course = Course::where('level', 'Level 100')
            ->where('program', 'Degree')->get();

        $procourse = Programmecourse::where('progcode', $code)
            ->where('semester', 'Second Semester')
            ->where('level', 'Level 100')->get();

        return view('course_management.second_semester_bprm', [
            'course' => $course,
            'procode' => $prog,
            'procourse' => $procourse, ]);
    }

    public function secondsemster_bprm_save(Request $Request, $code)
    {
        $prog = $Request->input('programme');
        $progcode = $code;
        $semester = $Request->input('semester');
        $courses = $Request->input('course');

        $count = \count($courses);

        for ($i = 0; $i < $count; ++$i) {
            $id = $courses[$i];

            //fetch cousre from database first
            $course = Course::where('id', $id)->first();

            $cousertitle = $course->title;
            $cousecode = $course->code;
            $courech = $course->credithours;

            // echo $cousertitle." | ".$cousecode." | ".$courech."<br>";

            //insert values Into Database
            $data = ['programme' => $prog,
                'progcode' => $progcode,
                'semester' => $semester,
                'coursetitle' => $cousertitle,
                'coursecode' => $cousecode,
                'credithours' => $courech,
                'level' => 'Level 100',
            ];

            $progcourse = new Programmecourse($data);
            $progcourse->save();
        }

        toastr()->success('Second Semester Course(s) Added Successfully!');

        return Redirect()->back();
    }

    public function secondsemster_bprm_delete($id)
    {
        $progcourse = Programmecourse::where('id', $id)->first();
        $progcourse->delete();
        toastr()->success('Course Deleted Successfully!');

        return Redirect()->back();
    }

    //SECOND END HERE

    //First Semester for level 200

    public function firstsemster_bprml2($code)
    {
        $prog = Programme::where('code', $code)->first();

        $course = Course::where('level', 'Level 200')
            ->where('program', 'Degree')->get();

        $procourse = Programmecourse::where('progcode', $code)
            ->where('semester', 'First Semester')
            ->where('level', 'Level 200')->get();

        return view('course_management.first_semester_bprml2', [
            'course' => $course,
            'procode' => $prog,
            'procourse' => $procourse, ]);
    }

    public function firstsemster_bprm_savel2(Request $Request, $code)
    {
        $prog = $Request->input('programme');
        $progcode = $code;
        $semester = $Request->input('semester');
        $courses = $Request->input('course');

        $count = \count($courses);

        for ($i = 0; $i < $count; ++$i) {
            $id = $courses[$i];

            //fetch cousre from database first
            $course = Course::where('id', $id)->first();

            $cousertitle = $course->title;
            $cousecode = $course->code;
            $courech = $course->credithours;

            // echo $cousertitle." | ".$cousecode." | ".$courech."<br>";

            //insert values Into Database
            $data = ['programme' => $prog,
                'progcode' => $progcode,
                'semester' => $semester,
                'coursetitle' => $cousertitle,
                'coursecode' => $cousecode,
                'credithours' => $courech,
                'level' => 'Level 200',
            ];

            $progcourse = new Programmecourse($data);
            $progcourse->save();
        }

        toastr()->success('First Semester Course(s) Added Successfully!');

        return Redirect()->back();
    }

    public function firstsemster_bprm_deletel2($id)
    {
        $progcourse = Programmecourse::where('id', $id)->first();
        $progcourse->delete();
        toastr()->success('Course Deleted Successfully!');

        return Redirect()->back();
    }

    //Second Semester for level 200

    public function secondsemster_bprml2($code)
    {
        $prog = Programme::where('code', $code)->first();

        $course = Course::where('level', 'Level 200')
            ->where('program', 'Degree')->get();

        $procourse = Programmecourse::where('progcode', $code)
            ->where('semester', 'Second Semester')
            ->where('level', 'Level 200')->get();

        return view('course_management.second_semester_bprml2', [
            'course' => $course,
            'procode' => $prog,
            'procourse' => $procourse, ]);
    }

    public function secondsemster_bprm_savel2(Request $Request, $code)
    {
        $prog = $Request->input('programme');
        $progcode = $code;
        $semester = $Request->input('semester');
        $courses = $Request->input('course');

        $count = \count($courses);

        for ($i = 0; $i < $count; ++$i) {
            $id = $courses[$i];

            //fetch cousre from database first
            $course = Course::where('id', $id)->first();

            $cousertitle = $course->title;
            $cousecode = $course->code;
            $courech = $course->credithours;

            // echo $cousertitle." | ".$cousecode." | ".$courech."<br>";

            //insert values Into Database
            $data = ['programme' => $prog,
                'progcode' => $progcode,
                'semester' => $semester,
                'coursetitle' => $cousertitle,
                'coursecode' => $cousecode,
                'credithours' => $courech,
                'level' => 'Level 200',
            ];

            $progcourse = new Programmecourse($data);
            $progcourse->save();
        }

        toastr()->success('Second Semester Course(s) Added Successfully!');

        return Redirect()->back();
    }

    public function secondsemster_bprm_deletel2($id)
    {
        $progcourse = Programmecourse::where('id', $id)->first();
        $progcourse->delete();
        toastr()->success('Course Deleted Successfully!');

        return Redirect()->back();
    }

    //First Semester for level 300

    public function firstsemster_bprml3($code)
    {
        $prog = Programme::where('code', $code)->first();

        $course = Course::where('level', 'Level 300')
            ->where('program', 'Degree')->get();

        $procourse = Programmecourse::where('progcode', $code)
            ->where('semester', 'First Semester')
            ->where('level', 'Level 300')->get();

        return view('course_management.first_semester_bprml3', [
            'course' => $course,
            'procode' => $prog,
            'procourse' => $procourse, ]);
    }

    public function firstsemster_bprm_savel3(Request $Request, $code)
    {
        $prog = $Request->input('programme');
        $progcode = $code;
        $semester = $Request->input('semester');
        $courses = $Request->input('course');

        $count = \count($courses);

        for ($i = 0; $i < $count; ++$i) {
            $id = $courses[$i];

            //fetch cousre from database first
            $course = Course::where('id', $id)->first();

            $cousertitle = $course->title;
            $cousecode = $course->code;
            $courech = $course->credithours;

            // echo $cousertitle." | ".$cousecode." | ".$courech."<br>";

            //insert values Into Database
            $data = ['programme' => $prog,
                'progcode' => $progcode,
                'semester' => $semester,
                'coursetitle' => $cousertitle,
                'coursecode' => $cousecode,
                'credithours' => $courech,
                'level' => 'Level 300',
            ];

            $progcourse = new Programmecourse($data);
            $progcourse->save();
        }

        toastr()->success('First Semester Course(s) Added Successfully!');

        return Redirect()->back();
    }

    public function firstsemster_bprm_deletel3($id)
    {
        $progcourse = Programmecourse::where('id', $id)->first();
        $progcourse->delete();
        toastr()->success('Course Deleted Successfully!');

        return Redirect()->back();
    }

    //Second Semester for level 300

    public function secondsemster_bprml3($code)
    {
        $prog = Programme::where('code', $code)->first();

        $course = Course::where('level', 'Level 300')
            ->where('program', 'Degree')->get();

        $procourse = Programmecourse::where('progcode', $code)
            ->where('semester', 'Second Semester')
            ->where('level', 'Level 300')->get();

        return view('course_management.second_semester_bprml3', [
            'course' => $course,
            'procode' => $prog,
            'procourse' => $procourse, ]);
    }

    public function secondsemster_bprm_savel3(Request $Request, $code)
    {
        $prog = $Request->input('programme');
        $progcode = $code;
        $semester = $Request->input('semester');
        $courses = $Request->input('course');

        $count = \count($courses);

        for ($i = 0; $i < $count; ++$i) {
            $id = $courses[$i];

            //fetch cousre from database first
            $course = Course::where('id', $id)->first();

            $cousertitle = $course->title;
            $cousecode = $course->code;
            $courech = $course->credithours;

            // echo $cousertitle." | ".$cousecode." | ".$courech."<br>";

            //insert values Into Database
            $data = ['programme' => $prog,
                'progcode' => $progcode,
                'semester' => $semester,
                'coursetitle' => $cousertitle,
                'coursecode' => $cousecode,
                'credithours' => $courech,
                'level' => 'Level 300',
            ];

            $progcourse = new Programmecourse($data);
            $progcourse->save();
        }

        toastr()->success('Second Semester Course(s) Added Successfully!');

        return Redirect()->back();
    }

    public function secondsemster_bprm_deletel3($id)
    {
        $progcourse = Programmecourse::where('id', $id)->first();
        $progcourse->delete();
        toastr()->success('Course Deleted Successfully!');

        return Redirect()->back();
    }

    //First Semester for level 400

    public function firstsemster_bprml4($code)
    {
        $prog = Programme::where('code', $code)->first();

        $course = Course::where('level', 'Level 400')
            ->where('program', 'Degree')->get();

        $procourse = Programmecourse::where('progcode', $code)
            ->where('semester', 'First Semester')
            ->where('level', 'Level 400')->get();

        return view('course_management.first_semester_bprml4', [
            'course' => $course,
            'procode' => $prog,
            'procourse' => $procourse, ]);
    }

    public function firstsemster_bprm_savel4(Request $Request, $code)
    {
        $prog = $Request->input('programme');
        $progcode = $code;
        $semester = $Request->input('semester');
        $courses = $Request->input('course');

        $count = \count($courses);

        for ($i = 0; $i < $count; ++$i) {
            $id = $courses[$i];

            //fetch cousre from database first
            $course = Course::where('id', $id)->first();

            $cousertitle = $course->title;
            $cousecode = $course->code;
            $courech = $course->credithours;

            // echo $cousertitle." | ".$cousecode." | ".$courech."<br>";

            //insert values Into Database
            $data = ['programme' => $prog,
                'progcode' => $progcode,
                'semester' => $semester,
                'coursetitle' => $cousertitle,
                'coursecode' => $cousecode,
                'credithours' => $courech,
                'level' => 'Level 400',
            ];

            $progcourse = new Programmecourse($data);
            $progcourse->save();
        }

        toastr()->success('First Semester Course(s) Added Successfully!');

        return Redirect()->back();
    }

    public function firstsemster_bprm_deletel4($id)
    {
        $progcourse = Programmecourse::where('id', $id)->first();
        $progcourse->delete();

        toastr()->success('Course Deleted Successfully!');

        return Redirect()->back();
    }

    //Second Semester for level 400

    public function secondsemster_bprml4($code)
    {
        $prog = Programme::where('code', $code)->first();

        $course = Course::where('level', 'Level 400')
            ->where('program', 'Degree')->get();

        $procourse = Programmecourse::where('progcode', $code)
            ->where('semester', 'Second Semester')
            ->where('level', 'Level 400')->get();

        return view('course_management.second_semester_bprml4', [
            'course' => $course,
            'procode' => $prog,
            'procourse' => $procourse, ]);
    }

    public function secondsemster_bprm_savel4(Request $Request, $code)
    {
        $prog = $Request->input('programme');
        $progcode = $code;
        $semester = $Request->input('semester');
        $courses = $Request->input('course');

        $count = \count($courses);

        for ($i = 0; $i < $count; ++$i) {
            $id = $courses[$i];

            //fetch cousre from database first
            $course = Course::where('id', $id)->first();

            $cousertitle = $course->title;
            $cousecode = $course->code;
            $courech = $course->credithours;

            // echo $cousertitle." | ".$cousecode." | ".$courech."<br>";

            //insert values Into Database
            $data = ['programme' => $prog,
                'progcode' => $progcode,
                'semester' => $semester,
                'coursetitle' => $cousertitle,
                'coursecode' => $cousecode,
                'credithours' => $courech,
                'level' => 'Level 400',
            ];

            $progcourse = new Programmecourse($data);
            $progcourse->save();
        }

        toastr()->success('Second Semester Course(s) Added Successfully!');

        return Redirect()->back();
    }

    public function secondsemster_bprm_deletel4($id)
    {
        $progcourse = Programmecourse::where('id', $id)->first();
        $progcourse->delete();
        toastr()->success('Course Deleted Successfully!');

        return Redirect()->back();
    }

    //all degree courses controller

    public function alldegreecourse()
    {
        $course = Course::where('program', 'Degree')->get();

        return view('course_management.all_degree_courses', ['degree' => $course]);
    }

    public function alldiplomacourse()
    {
        $course = Course::where('program', 'Diploma')->get();

        return view('course_management.all_diploma_courses', ['degree' => $course]);
    }

    public function delcourse($id)
    {
        $course = Course::where('id', $id)->first();
        $course->delete();
        toastr()->success('Course Deleted Successfully!');

        return Redirect()->back();
    }

    public function lecturer_list()
    {
        $staff = Staff::latest()->get();
        $users = DB::table('users')->where('indexnumber', 'not like', '%GES%')->get();

        return view('course_management.all-staff', ['staff' => $staff, 'user' => $users]);
    }

    public function assign_course_lecturer($id)
    {
        $staff = User::with('staff')->where('id', $id)->first();
        $lectcorse = LecCource::where('lecturer_id', $id)->get();
        $courses = Course::all();

        return view(
            'course_management.assign-course-staff',
            ['lectid' => $id, 'staff' => $staff, 'leccources' => $lectcorse, 'courses' => $courses]
        );
    }
}
