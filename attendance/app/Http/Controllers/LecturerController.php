<?php

namespace App\Http\Controllers;

use App\Academicyear;
use App\Assignment;
use App\Coureregistration;
use App\Course;
use App\Examresults;
use App\Faculty;
use App\LecCource;
use App\Lecturer;
use App\Programme;
use App\Staff;
use App\Studentinfo;
use App\Submission;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    public function register_lecturer()
    {
        $faculty = Faculty::all();
        $courses = Course::all();

        //dd($courses);
        return view('Lecturer.add_lecturer', ['faculty' => $faculty, 'courses' => $courses]);
    }

    public function register_lecturer_save(Request $request)
    {
        $courses = $request->input('courses');

        //dd($courses[0]);
        //$total = count($courses);

        $this->validate($request, [
            'fullname' => 'required',
            'gender' => 'required',
            'dateofbirth' => 'required',
            'faculty' => 'required',
            'religion' => 'required',
            'mobile' => 'required|min:10',
            'qualification' => 'required',
            'email' => 'required|email',
            'image' => 'required',
            'address' => 'required',
        ]);

        $maxcode = DB::table('users')->where('indexnumber', 'like', '%LEC%')->max('indexnumber');
        if ($maxcode) {
            $max = substr($maxcode, 3);
            $number = $max + 1;
            $code = 'LEC' . $number;
        } else {
            $code = 'LEC1019330';
        }

        //dd($code);

        if ($request->has('image')) {

            //dd($img);

            $user = User::create([
                'name' => $request->input('fullname'),
                'email' => $request->input('email'),
                'indexnumber' => $code,
                'pro_pic' => $request->file('image')->store('profileimage', 'public'),
                'password' => Hash::make($request->input('email')),
            ]);
        }

        $user->assignRole('Lecturer');

        //create user

        $data = [
            'user_id' => $user->id,
            'fullname' => $request->input('fullname'),
            'dateofbirth' => $request->input('dateofbirth'),
            'address' => $request->input('address'),
            'faculty' => $request->input('faculty'),
            'gender' => $request->input('gender'),
            'religion' => $request->input('religion'),
            'qualification' => $request->input('qualification'),
            'number' => $request->input('mobile'),
        ];

        $Lecturer = new Lecturer($data);
        $Lecturer->save();

        $lecid = $Lecturer->user_id;

        $total = \count($courses);

        for ($i = 0; $i < $total; ++$i) {
            $acode = $courses[$i];
            $course = Course::where('code', $acode)->first();
            $titlec = $course->title;

            $lecdata = [
                'lecturer_id' => $lecid,
                'lec_name' => $request->input('fullname'),
                'course' => $titlec,
                'code' => $acode,
            ];

            $leccourse = new LecCource($lecdata);
            $leccourse->save();
        }

        //dd($total);

        return Redirect()->back()->with('message', 'Lecturer Added Successfully');
    }

    public function all_lecturer()
    {
        $users = DB::table('users')->where('indexnumber', 'like', '%LEC%')->get();
        $lecurer = Lecturer::all();

        //dd($lecure);

        return view('Lecturer.all_lecturers', ['user' => $users, 'lecturer' => $lecurer]);
    }

    public function edit_lecturer($id)
    {
        $faculty = Faculty::all();
        $lecurer = Lecturer::where('user_id', $id)->first();
        $user = User::where('id', $id)->first();

        $lecourses = LecCource::where('lecturer_id', $id)->get();
        $courses = Course::all();
        //dd($lecourses);
        return view('Lecturer.edit_lecture', ['lectid' => $id, 'courses' => $courses, 'leccources' => $lecourses, 'faculty' => $faculty, 'lecturer' => $lecurer, 'user' => $user]);
    }

    public function register_lecturer_update(Request $request)
    {
        $id = $request->input('hiddenid');
        $user = User::where('id', $id)->first();

        $lect = Lecturer::where('user_id', $id)->first();

        if ($request->has('image')) {
            $storage = Storage::disk('public')->delete($user->pro_pic);
            if ($storage) {
                //$suportdoc->delete();
            }

            $user->pro_pic = $request->file('image')->store('profileimage', 'public');
            $user->save();
        }

        $user->name = $request->input('fullname');
        $user->email = $request->input('email');
        $user->save();

        $lect->fullname = $request->input('fullname');
        $lect->dateofbirth = $request->input('dateofbirth');
        $lect->address = $request->input('address');
        $lect->faculty = $request->input('faculty');
        $lect->gender = $request->input('gender');
        $lect->religion = $request->input('religion');
        $lect->qualification = $request->input('qualification');
        $lect->number = $request->input('mobile');
        $lect->save();

        return Redirect()->route('lecturer-all')->with('message', 'Lecturer Info Updated Successfully');
    }

    public function lecturer_enter_results()
    {
        return view('Lecturer.student_results_enter');
    }

    public function lecturer_get_fullname(Request $request)
    {
        $stdid = $request->post('indexnumber');
        $course = $request->post('cousercode');

        $couser = Coureregistration::where('indexnumber', $stdid)
            ->where('cource_code', $course)->first();

        if (!empty($couser)) {
            $userid = $couser->user_id;
            $user = User::where('id', $userid)->first();

            //check resit
            if ('0' == $couser->resit) {

          //no resit
                $data = [
                    'fullname' => $user->name,
                    'IA' => $couser->IA_mark,
                    'exam' => $couser->exams_mark,
                    'msg' => true,
                ];
            } else {
                $data = [
                    'fullname' => $user->name,
                    'IA' => '0',
                    'exam' => '0',
                    'msg' => true,
                ];
            }

            return response()->json($data, 200);
        }

        return response()->json(['error' => 'Index Number or Course Code Dont Exist'], 200);
    }

    public function lecturer_save_results(Request $request)
    {
        $this->validate($request, [
            'indexnumber' => 'required',
            'iamarks' => 'required|integer',
            'exmasmarks' => 'required|integer',
            'courcecode' => 'required',

        ]);

        $stdid = $request->input('indexnumber');
        $ia = $request->input('iamarks');
        $exam = $request->input('exmasmarks');
        $couree = $request->input('courcecode');
        $lecdid = auth()->user()->id;

        $check = Coureregistration::where('indexnumber', $stdid)
            ->where('cource_code', $couree)->first();

        $couser = Coureregistration::where('indexnumber', $stdid)
            ->where('cource_code', $couree)->first();

        $couser->IA_mark = $ia;
        $couser->exams_mark = $exam;
        $couser->total_marks = $ia + $exam;
        $total = $ia + $exam;

        if ($total > 0 && $total <= 44) {
            $grade = 'F';
            $gradepoint = 0;
        } elseif ($total > 44 && $total <= 49) {
            $grade = 'D';
            $gradepoint = 0.5;
        } elseif ($total > 49 && $total <= 54) {
            $grade = 'C-';
            $gradepoint = 1.0;
        } elseif ($total > 54 && $total <= 59) {
            $grade = 'C';
            $gradepoint = 1.50;
        } elseif ($total > 59 && $total <= 64) {
            $grade = 'C+';
            $gradepoint = 2.0;
        } elseif ($total > 64 && $total <= 69) {
            $grade = 'B-';
            $gradepoint = 2.50;
        } elseif ($total > 69 && $total <= 74) {
            $grade = 'B';
            $gradepoint = 3.0;
        } elseif ($total > 74 && $total <= 79) {
            $grade = 'B+';
            $gradepoint = 3.5;
        } elseif ($total > 79 && $total <= 100) {
            $grade = 'A';
            $gradepoint = 4.0;
        }

        if ('0' == $ia) {
            $grade = 'IC';
        }

        $couser->grade = $grade;
        $couser->grade_point = $gradepoint;
        $totgradepoint = $gradepoint * $couser->credithours;
        $couser->total_gp = $totgradepoint;
        $couser->status = 1;
        $couser->lecturer_id = auth()->user()->id;
        $couser->save();

        //check if resit has been activated
        $resit = $check->resit;

        if ('0' == $resit) {
            // normal score...

            //total credit hours
            $credithours = DB::table('coureregistrations')->where('semester', $couser->semester)
                ->where('user_id', $couser->user_id)
                ->where('academic_year', $couser->academic_year)->sum('credithours');

            $exms = Examresults::where('user_id', $couser->user_id)
                ->get();

            //get count
            if ($exms->count() > 1) {
                //meaning it has multiple records
                $fetchrecord = Examresults::where('user_id', $couser->user_id)
                    ->where('semester', $couser->semester)
                    ->where('year', $couser->academic_year)->first();

                if ($fetchrecord) {
                    //has a record
                    //total credit hours

                    $credithours = DB::table('examresults')->where('user_id', $couser->user_id)->sum('credithours');

                    $total = DB::table('examresults')->where('user_id', $couser->user_id)->sum('totalgp');

                    $totalgp = $total + $totgradepoint;
                    //$credithr = $credithours +
                    $gpa = $totalgp / $credithours;

                    //new totalgp

                    $nwtotal = $fetchrecord->totalgp + $totgradepoint;
                    //update record
                    $fetchrecord->totalgp = $nwtotal;
                    $fetchrecord->gpa = $gpa;
                    $fetchrecord->save();
                } else {

          //has no record for this semester
                    $credithr = DB::table('examresults')->where('user_id', $couser->user_id)->sum('credithours');

                    $total = DB::table('examresults')->where('user_id', $couser->user_id)->sum('totalgp');

                    $totalgp = $total + $totgradepoint;

                    $gpa = $totalgp / $credithr;

                    //$credithours = $credithours + $credithours;

                    $data = [
                        'user_id' => $couser->user_id,
                        'semester' => $couser->semester,
                        'year' => $couser->academic_year,
                        'totalgp' => $totgradepoint,
                        'credithours' => $credithours,
                        'gpa' => $gpa,
                    ];

                    $examresults = new Examresults($data);
                    $examresults->save();
                }
            } else {

        //it has only one Record

                //fetch that one record
                $fetchrecord = Examresults::where('user_id', $couser->user_id)
                    ->where('semester', $couser->semester)
                    ->where('year', $couser->academic_year)->first();

                if ($fetchrecord) {
                    $totlgp = $fetchrecord->totalgp + $totgradepoint;
                    //$totalcedit = $fetchrecord->credithours + $couser->credithours;
                    $gpa = $totlgp / $credithours;

                    $fetchrecord->totalgp = $totlgp;
                    //$fetchrecord->credithours = $totalcedit;
                    $fetchrecord->gpa = $gpa;
                    $fetchrecord->save();
                } else {
                    $gpa = $totgradepoint / $credithours;

                    $data = [
                        'user_id' => $couser->user_id,
                        'semester' => $couser->semester,
                        'year' => $couser->academic_year,
                        'totalgp' => $totgradepoint,
                        'credithours' => $credithours,
                        'gpa' => $gpa,
                    ];

                    $examresults = new Examresults($data);
                    $examresults->save();
                }
            }
        } else {

        // this is for resit
            //
            // update resit
            $check->resit = 1;
            $check->save();

            //GET LEVEL
            $level = $check->level;
            $semester = $check->semester;
            $userid = $check->user_id;
            $Ayear = $check->academic_year;

            //level 100 first
            $leval1f = Coureregistration::where('indexnumber', $stdid)
                ->where('level', 'Level 100')
                ->where('semester', 'First Semester')->first();

            if ($leval1f) {
                $totalgpl1f = DB::table('coureregistrations')
                    ->where('level', 'Level 100')->where('semester', 'First Semester')
                    ->sum('total_gp');

                $credithrl1f = DB::table('coureregistrations')
                    ->where('level', 'Level 100')->where('semester', 'First Semester')
                    ->sum('credithours');

                $gpal1f = $totalgpl1f / $credithrl1f;

                //get exams
                $examsl1f = Examresults::where('user_id', $couser->user_id)
                    ->where('semester', 'First Semester')
                    ->where('year', $leval1f->academic_year)->first();

                $examsl1f->totalgp = $totalgpl1f;
                $examsl1f->gpa = $gpal1f;
                $examsl1f->save();
            }

            //level 100 second

            $leval1s = Coureregistration::where('indexnumber', $stdid)
                ->where('level', 'Level 100')
                ->where('semester', 'Second Semester')->first();

            if ($leval1s) {
                $totalgpl1s = DB::table('coureregistrations')
                    ->where('level', 'Level 100')->where('semester', 'Second Semester')
                    ->sum('total_gp');

                $credithrl1s = DB::table('coureregistrations')
                    ->where('level', 'Level 100')->where('semester', 'Second Semester')
                    ->sum('credithours');

                $totalgb1 = $totalgpl1f + $totalgpl1s;

                $totcredit = $credithrl1f + $credithrl1s;

                $gpal1s = $totalgb1 / $totcredit;

                //get exams
                $examsl1s = Examresults::where('user_id', $couser->user_id)
                    ->where('semester', 'Second Semester')
                    ->where('year', $leval1s->academic_year)->first();

                $examsl1s->totalgp = $totalgpl1s;
                $examsl1f->gpa = $gpal1s;
                $examsl1s->save();
            }

            //level 200 firat

            $leval2f = Coureregistration::where('indexnumber', $stdid)
                ->where('level', 'Level 200')
                ->where('semester', 'First Semester')->first();

            if ($leval2f) {
                $totalgpl2f = DB::table('coureregistrations')
                    ->where('level', 'Level 200')->where('semester', 'First Semester')
                    ->sum('total_gp');

                $credithrl2f = DB::table('coureregistrations')
                    ->where('level', 'Level 200')->where('semester', 'First Semester')
                    ->sum('credithours');

                $totalgbl2f = $totalgb1 + $totalgpl2f;
                $totcredidl2f = $totcredit + $credithrl2f;
                $gpal2f = $totalgbl2f / $totcredidl2f;

                //get exams
                $examsl2f = Examresults::where('user_id', $couser->user_id)
                    ->where('semester', 'First Semester')
                    ->where('year', $leval2f->academic_year)->first();

                $examsl2f->totalgp = $totalgpl2f;
                $examsl1f->gpa = $gpal2f;
                $examsl2f->save();
            }

            //level 200 second

            $leval2s = Coureregistration::where('indexnumber', $stdid)
                ->where('level', 'Level 200')
                ->where('semester', 'Second Semester')->first();

            if ($leval2s) {
                $totalgpl2s = DB::table('coureregistrations')
                    ->where('level', 'Level 200')->where('semester', 'Second Semester')
                    ->sum('total_gp');

                $credithrl2s = DB::table('coureregistrations')
                    ->where('level', 'Level 200')->where('semester', 'Second Semester')
                    ->sum('credithours');

                $totalgbl2s = $totalgbl2f + $totalgpl2s;

                $totcredidl2s = $totcredidl2f + $credithrl2s;

                $gpal2s = $totalgbl2s / $totcredidl2s;

                //get exams
                $examsl2s = Examresults::where('user_id', $couser->user_id)
                    ->where('semester', 'Second Semester')
                    ->where('year', $leval2s->academic_year)->first();

                $examsl2s->totalgp = $totalgpl2s;
                $examsl2s->gpa = $gpal2s;
                $examsl2s->save();
            }

            //level 300 first

            $leval3f = Coureregistration::where('indexnumber', $stdid)
                ->where('level', 'Level 300')
                ->where('semester', 'First Semester')->first();

            if ($leval3f) {
                $totalgpl3f = DB::table('coureregistrations')
                    ->where('level', 'Level 300')->where('semester', 'First Semester')
                    ->sum('total_gp');

                $credithrl3f = DB::table('coureregistrations')
                    ->where('level', 'Level 300')->where('semester', 'First Semester')
                    ->sum('credithours');

                $totalgbl3f = $totalgbl2s + $totalgpl3f;

                $totcredidl3f = $totcredidl2s + $credithrl3f;

                $gpal3f = $totalgbl3f / $totcredidl3f;

                //get exams
                $examsl3f = Examresults::where('user_id', $couser->user_id)
                    ->where('semester', 'First Semester')
                    ->where('year', $leval3f->academic_year)->first();

                $examsl3f->totalgp = $totalgpl3f;
                $examsl3f->gpa = $gpal3f;
                $examsl3f->save();
            }

            //level 300 second

            $leval3s = Coureregistration::where('indexnumber', $stdid)
                ->where('level', 'Level 300')
                ->where('semester', 'Second Semester')->first();

            if ($leval3s) {
                $totalgpl3s = DB::table('coureregistrations')
                    ->where('level', 'Level 300')->where('semester', 'Second Semester')
                    ->sum('total_gp');

                $credithrl3s = DB::table('coureregistrations')
                    ->where('level', 'Level 300')->where('semester', 'Second Semester')
                    ->sum('credithours');

                $totalgbl3s = $totalgbl3f + $totalgpl3s;

                $totcredidl3s = $totcredidl3f + $credithrl3s;

                $gpal3s = $totalgbl3s / $totcredidl3s;

                //get exams
                $examsl3s = Examresults::where('user_id', $couser->user_id)
                    ->where('semester', 'Second Semester')
                    ->where('year', $leval3s->academic_year)->first();

                $examsl3s->totalgp = $totalgpl3s;
                $examsl3s->gpa = $gpal3s;
                $examsl3s->save();
            }

            //level 400 first

            $leval4f = Coureregistration::where('indexnumber', $stdid)
                ->where('level', 'Level 400')
                ->where('semester', 'First Semester')->first();

            if ($leval4f) {
                $totalgpl4f = DB::table('coureregistrations')
                    ->where('level', 'Level 400')->where('semester', 'First Semester')
                    ->sum('total_gp');

                $credithrl4f = DB::table('coureregistrations')
                    ->where('level', 'Level 400')->where('semester', 'First Semester')
                    ->sum('credithours');

                $totalgbl4f = $totalgbl3s + $totalgpl4f;

                $totcredidl4f = $totcredidl3s + $credithrl4f;

                $gpal4f = $totalgbl4f / $totcredidl4f;

                //get exams
                $examsl4f = Examresults::where('user_id', $couser->user_id)
                    ->where('semester', 'First Semester')
                    ->where('year', $leval4f->academic_year)->first();

                $examsl4f->totalgp = $totalgpl4f;
                $examsl4f->gpa = $gpal4f;
                $examsl4f->save();
            }

            //level 400 second

            $leval4s = Coureregistration::where('indexnumber', $stdid)
                ->where('level', 'Level 400')
                ->where('semester', 'Second Semester')->first();

            if ($leval4s) {
                $totalgpl4s = DB::table('coureregistrations')
                    ->where('level', 'Level 400')->where('semester', 'Second Semester')
                    ->sum('total_gp');

                $credithrl4s = DB::table('coureregistrations')
                    ->where('level', 'Level 400')->where('semester', 'Second Semester')
                    ->sum('credithours');

                $totalgbl4s = $totalgbl4f + $totalgpl4s;

                $totcredidl4s = $totcredidl4f + $credithrl4s;

                $gpal4s = $totalgbl4s / $totcredidl4s;

                //get exams
                $examsl4s = Examresults::where('user_id', $couser->user_id)
                    ->where('semester', 'Second Semester')
                    ->where('year', $leval4s->academic_year)->first();

                $examsl4s->totalgp = $totalgpl4s;
                $examsl4s->gpa = $gpal4s;
                $examsl4s->save();
            }
        }

        return Redirect()->back()->with('message', 'Result Added Successfully!');
    }

    public function lecturer_enter_results_reenter()
    {
        return view('Lecturer.student_results_reenter');
    }

    public function lecturer_resave_results(Request $request)
    {
        $this->validate($request, [
            'indexnumber' => 'required',
            'iamarks' => 'required|integer',
            'exmasmarks' => 'required|integer',
            'courcecode' => 'required',

        ]);

        $stdid = $request->input('indexnumber');
        $ia = $request->input('iamarks');
        $exam = $request->input('exmasmarks');
        $couree = $request->input('courcecode');
        $lecdid = auth()->user()->id;

        $check = Coureregistration::where('indexnumber', $stdid)
            ->where('cource_code', $couree)->where('status', 1)->first();

        if (empty($check)) {
            return Redirect()->back()->with('error', 'Result For ' . $stdid . ' Has No Existing Record To Update, Proceed To Enter Results. Thank You');
        }

        $couser = Coureregistration::where('indexnumber', $stdid)
            ->where('cource_code', $couree)->first();

        $couser->IA_mark = $ia;
        $couser->exams_mark = $exam;
        $couser->total_marks = $ia + $exam;
        $total = $ia + $exam;

        if ($total > 0 && $total <= 44) {
            $grade = 'F';
            $gradepoint = 0;
        } elseif ($total > 44 && $total <= 49) {
            $grade = 'D';
            $gradepoint = 0.5;
        } elseif ($total > 49 && $total <= 54) {
            $grade = 'C-';
            $gradepoint = 1.0;
        } elseif ($total > 54 && $total <= 59) {
            $grade = 'C';
            $gradepoint = 1.50;
        } elseif ($total > 59 && $total <= 64) {
            $grade = 'C+';
            $gradepoint = 2.0;
        } elseif ($total > 64 && $total <= 69) {
            $grade = 'B-';
            $gradepoint = 2.50;
        } elseif ($total > 69 && $total <= 74) {
            $grade = 'B';
            $gradepoint = 3.0;
        } elseif ($total > 74 && $total <= 79) {
            $grade = 'B+';
            $gradepoint = 3.5;
        } elseif ($total > 79 && $total <= 100) {
            $grade = 'A';
            $gradepoint = 4.0;
        }

        $couser->grade = $grade;
        $couser->grade_point = $gradepoint;
        $totgradepoint = $gradepoint * $couser->credithours;
        $couser->total_gp = $totgradepoint;
        $couser->lecturer_id = auth()->user()->id;
        $couser->save();

        return Redirect()->back()->with('message', 'Result Updated Successfully!');
    }

    public function lecturer_post_assignment()
    {
        $prog = Programme::all();
        $assingment = Assignment::where('lecturer_id', auth()->user()->id)->get();

        return view('Lecturer.post_assignment', ['prog' => $prog, 'assingment' => $assingment]);
    }

    public function lecturer_assignment_save(Request $request)
    {

  //dd($request);
        $lectid = auth()->user()->id;
        $lecname = auth()->user()->name;

        $this->validate($request, [
            'coursecode' => 'required|max:7',
            'assignmenttitle' => 'required|min:8|max:50',
            'assignmentdesc' => 'required',
            'deadline' => 'required',
            'assingmentdoc' => 'required|mimes:pdf,docx,txt',
        ]);

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $data = [
            'lecturer_id' => $lectid,
            'lname' => $lecname,
            'course_code' => $request->input('coursecode'),
            'programme' => $request->input('programme'),
            'assignment_title' => $request->input('assignmenttitle'),
            'assignment_description' => $request->input('assignmentdesc'),
            'subenddate' => $request->input('deadline'),
            'academicyear' => $year,
            'semester' => $semester,
            'lecdoc' => $request->file('assingmentdoc')->store('Assignments', 'public'),
        ];

        //dd($data);

        $assignment = new Assignment($data);
        $assignment->save();

        return Redirect()->back()->with('message', 'Assignment Posted Successfully!');
    }

    public function lecturer_assignment_view()
    {
        $assingment = Assignment::where('lecturer_id', auth()->user()->id)->orderBy('id', 'Desc')->get();

        return view('Lecturer.view_assignments', ['assingment' => $assingment]);
    }

    public function lecturer_assignment_edit($id)
    {
        $assingment = Assignment::where('id', $id)->first();
        $prog = Programme::all();

        return view('Lecturer.edit_assignment', ['assingment' => $assingment, 'prog' => $prog]);
    }

    public function lecturer_assignment_update(Request $request)
    {
        $id = $request->input('hiddenid');
        $assingment = Assignment::where('id', $id)->first();

        $this->validate($request, [
            'coursecode' => 'required|max:7',
            'assignmenttitle' => 'required|min:8|max:50',
            'assignmentdesc' => 'required',
            'deadline' => 'required',
        ]);

        $assingment->course_code = $request->input('coursecode');
        $assingment->assignment_title = $request->input('assignmenttitle');
        $assingment->assignment_description = $request->input('assignmentdesc');
        $assingment->subenddate = $request->input('deadline');

        if ($request->has('assingmentdoc')) {
            $storage = Storage::disk('public')->delete($assingment->lecdoc);
            $assingment->lecdoc = $request->file('assingmentdoc')->store('Assignments', 'public');
            //$assingment->save();
        }

        $assingment->save();

        // return Redirect()->route('lecturer-student-assignment-view')->with('message','Assignment Updated Successfully!');

        return Redirect()->route('lms-lec-online-assignments', ['code' => $request->input('coursecode')])->with('message', 'Assignment Updated Successfully!');
    }

    public function lecturer_assignment_delete($id)
    {
        $assingment = Assignment::where('id', $id)->first();
        $storage = Storage::disk('public')->delete($assingment->lecdoc);
        $assingment->delete();

        return Redirect()->back()->with('message', 'Assignment Removed Successfully!');
    }

    public function lecturer_assignment_submiited($id)
    {
        $assingment = Submission::where('assignment_id', $id)->get();
        $user = Studentinfo::all();

        //dd($assingment);
        return view('Lecturer.submitted_assignment', ['assingment' => $assingment, 'user' => $user]);
    }

    public function lecturer_assign_course(Request $request): void
    {
        $lecid = $request->post('lecid');
        $code = $request->post('cid');

        $course = Course::where('code', $code)->first();
        $titlec = $course->title;

        $lecurer = Staff::where('user_id', $lecid)->first();

        $chele = LecCource::where('code', $code)->where('lecturer_id', $lecid)->first();

        if ($chele) {
            echo '
   failed
   ';
        } else {
            $lecdata = [
                'lecturer_id' => $lecid,
                'lec_name' => $lecurer->fullname,
                'course' => $titlec,
                'code' => $code,
            ];

            $leccourse = new LecCource($lecdata);
            $leccourse->save();

            echo 'success';
        }
    }

    public function lecturer_remove_assign_course(Request $request): void
    {
        $id = $request->post('cid');

        $leccourse = LecCource::where('id', $id);
        $leccourse->delete();

        echo 'Course Removed Successfully, Reload Page to take Effect';
    }
}
