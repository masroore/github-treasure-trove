<?php

namespace App\Http\Controllers\LMS;

use App\AcademicCalendar;
use App\Academicyear;
use App\Answer;
use App\Assignment;
use App\chatmessages;
use App\Coureregistration;
use App\Course;
use App\Exam;
use App\Examcheck;
use App\Examretryresponse;
use App\ExamScore;
use App\Examtrack;
use App\Http\Controllers\Controller;
use App\Jobs\Announcement\notifystudent;
use App\Jobs\LMSMail\sendmailwithfile;
use App\LecCource;
use App\model\LMS\Announcement;
use App\model\LMS\Courseoverview;
use App\model\LMS\Gradebook;
use App\model\LMS\Lessondoc;
use App\model\LMS\Lessonplan;
use App\model\LMS\Privatefile;
use App\model\LMS\StudentAttendances;
use App\model\LMS\Videoupload;
use App\Programme;
use App\QestionOption;
use App\Question;
use App\Staff;
use App\Studentexam;
use App\Studentgrouping;
use App\Studentinfo;
use App\Submission;
use App\Timetable;
use App\User;
use App\Zoomweb;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Zoom;

class LMSController extends Controller
{
    public function login()
    {
        //return Redirect()->route('lms-main');
        return view('LMS.login');
    }

    public function login_check(Request $request)
    {

        //dd($request);

        $index = $request->post('index');
        $password = $request->post('password');

        //echo $index;
        $user = User::where('indexnumber', $index)->first();

        //dd($user);

        if (!$user) {
            return Redirect()->route('lms-home')->with('error', 'Oppes! You have entered invalid credentials');
        }

        $email = $user->email;

        $credentials = ['email'=> $email, 'password' => $password];

        if (Auth::attempt($credentials)) {
            $user->is_active = '1';
            $user->save();

            return redirect()->route('lms-site-overview');
        }

        return Redirect()->route('lms-home')->with('error', 'Oppes! You have entered invalid credentials');
    }

    // Lecturer LMS Script

    public function lec_site()
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $lectcorse = LecCource::where('lecturer_id', auth()->user()->id)->get();

        $timetable = Timetable::join('timetablegroups', 'timetables.id', '=', 'timetablegroups.timetable_id')
            ->where('semester', $semester)
            ->where('academicyear', $year)
            ->where('timetablegroups.lecturer_id', auth()->user()->id)
            ->get()->unique('coursecode');

        return view('LMS.lecturer.site', ['leccources' => $lectcorse, 'thissem' => $timetable]);
    }

    public function lec_overview($code)
    {
        $view = Courseoverview::where('user_id', auth()->user()->id)
            ->where('course_code', $code)->first();

        if ($view) {
            $vailable = '1';
        } else {
            $vailable = '0';
        }

        return view('LMS.lecturer.overview', ['available' => $vailable, 'overview' => $view]);
    }

    public function lec_overview_save(Request $request)
    {
        $this->validate($request, [
      'overview' => 'required',
      'courseobj' => 'required',
    ]);

        $available = $request->input('available');

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $data = [
      'overview' => $request->input('overview'),
      'objectives' => $request->input('courseobj'),
      'academicyear' => $year,
      'semester' => $semester,
      'user_id' => auth()->user()->id,
      'course_code' => $request->input('coursecode'),
      'fullname' => auth()->user()->name,
    ];

        if ('1' == $available) {
            $view = Courseoverview::where('user_id', auth()->user()->id)
                ->where('course_code', $request->input('coursecode'))->first();

            $update = Courseoverview::findorfail($view->id)->update($data);

            toastr()->success('Course Overview Updated Successfully!');
        } else {
            $new = new Courseoverview($data);
            $new->save();

            toastr()->success('Course Overview Recorded Successfully!');
        }

        return Redirect()->back();
    }

    public function lec_syllabus()
    {
        return view('LMS.lecturer.syllabus');
    }

    public function lec_callendar(Request $request, $code)
    {
        return view('LMS.lecturer.calendar', ['code' => $code]);
    }

    public function lec_callendar_edit($code, $id)
    {
        $data = AcademicCalendar::where('id', $id)->first();

        return view('LMS.lecturer.edit_event', ['data' => $data, 'code' => $code]);
    }

    public function lec_callendar_get($code)
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $new = AcademicCalendar::where('coursecode', $code)
            ->where('academicyear', $year)
            ->where('semester', $semester)
            ->where('lectid', auth()->user()->id)
            ->get()
            ->toArray();

        echo json_encode($new);
    }

    public function lec_callendar_save(Request $request)
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
  'coursecode' => $request->post('code'),
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

    public function lec_callendar_get_all($code)
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $data = AcademicCalendar::where('coursecode', $code)
            ->where('academicyear', $year)
            ->where('semester', $semester)
            ->where('lectid', auth()->user()->id)
            ->get();

        return view('LMS.lecturer.all_events', ['data' => $data, 'code' => $code]);
    }

    public function lec_announcements($code)
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $data = Announcement::where('user_id', auth()->user()->id)
            ->where('course_code', $code)
            ->where('semester', $semester)
            ->where('academicyear', $year)
            ->latest()->get();

        return view('LMS.lecturer.announcement', ['data' => $data]);
    }

    public function lec_announcements_save(Request $request)
    {
        $this->validate($request, [
    'title' => 'required',
    'message' => 'required',
  ]);

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $data = [
    'title' => $request->input('title'),
    'message' => $request->input('message'),
    'academicyear' => $year,
    'semester' => $semester,
    'user_id' => auth()->user()->id,
    'course_code' => $request->input('coursecode'),
    'fullname' => auth()->user()->name,
  ];

        if ($request->has('hiddenid')) {
            $id = $request->post('hiddenid');
            $new = Announcement::findorfail($id)->update($data);
        } else {
            $new = new Announcement($data);
            $new->save();
        }

        $notify = $request->post('notify');
        $cousers = $request->input('coursecode');

        foreach ($notify as $row => $value) {
            $check = $value;

            if ('yes' == $check) {
                //send email to students

                $students = Studentgrouping::where('year', $year)
          ->where('semester', $semester)
          ->where('coursecode', $cousers)
          ->where('lecid', auth()->user()->id)
          ->get();

                $this->dispatch(new notifystudent($students, $request->input('title'), $request->input('message'), auth()->user()->email, auth()->user()->name));
            }
        }

        if ($request->has('hiddenid')) {
            toastr()->success('Announcement Updated Successfully!');

            return Redirect()->route('lms-lec-announcements', ['code' => $cousers]);
        }
        toastr()->success('Announcement Recorded Successfully!');

        return Redirect()->back();
    }

    public function lec_edit_announcement($code, $id)
    {
        $info = Announcement::findorfail($id);

        return view('LMS.lecturer.announcement_edit', ['info' => $info]);
    }

    public function lec_del_announcement($id)
    {
        Announcement::findorfail($id)->delete();
        toastr()->success('Info Delected Successfully!');

        return Redirect()->back();
    }

    public function lec_test_quiz($code)
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $exams = Exam::where('lecturer_id', auth()->user()->id)
            ->where('coursecode', $code)
            ->where('semester', $semester)
            ->where('academicyear', $year)
            ->latest()->get();

        return view('LMS.lecturer.quiz', ['exams' => $exams]);
    }

    public function lec_del_test_quiz($id)
    {
        $exams = Exam::findorfail($id);
        $id = $exams->id;

        $check = Examcheck::where('exam_id', $id)->first();
        if ($check) {
            $check->delete();
        }

        $retry = Examretryresponse::where('exam_id', $id)->first();

        if ($retry) {
            $retry->delete();
        }

        $score = ExamScore::where('exam_id', $id)->get();
        foreach ($score as $key => $value) {
            $sid = $key->id;
            ExamScore::where('id', $sid)->delete();
        }

        $track = Examtrack::where('exam_id', $id)->first();
        if ($track) {
            $track->delete();
        }

        $qop = Question::where('exam_id', $id)->get();
        foreach ($qop as $row) {
            $opid = $row->id;
            Question::where('id', $opid)->delete();

            $quop = QestionOption::where('question_id', $opid)->get();
            foreach ($quop as $row) {
                $opqid = $row->id;
                QestionOption::where('id', $opqid)->delete();
            }
        }

        $exams->delete();

        toastr()->success('Info Delected Successfully!');

        return Redirect()->back();
    }

    public function lec_addquestion_test_quiz($code, $id)
    {
        $exam = Exam::where('id', $id)->first();
        $examsid = $exam->id;
        $totalquestions = $exam->totalquestion;

        return view('LMS.lecturer.add_questions', ['examsid'=>$examsid, 'totalquestions'=>$totalquestions]);
    }

    public function lec_edit_test_quiz($code, $id)
    {
        $programm = Programme::all();
        $exam = Exam::where('id', $id)->first();

        return view('LMS.lecturer.edit_exams', ['exams'=>$exam, 'prog'=>$programm]);
    }

    public function lec_quisquestion_test_quiz($code, $id)
    {
        $exam = Exam::where('id', $id)->first();
        $examid = $exam->id;
        $examtot = $exam->totalquestion;

        $ques = Question::where('exam_id', $examid)
            ->with('qestionOptions')
            ->get()->shuffle();

        $anser = Answer::join('qestion_options', 'answers.answer', 'qestion_options.id')
            ->where('exam_id', $examid)
            ->get();

        return view('LMS.lecturer.lec_exam_view', ['answer'=>$anser, 'questions'=>$ques, 'examsid'=>$examid, 'examtot'=>$examtot]);
    }

    public function more_questions($code, $quanty, $examid)
    {
        return view('LMS.lecturer.add_more_question', ['examsid'=>$examid, 'totalquestions'=>$quanty]);
    }

    public function lect_question_edit($code, $id)
    {
        $exam = Exam::where('id', $id)->first();
        $examsid = $exam->id;
        $totalquestions = $exam->totalquestion;

        $ques = Question::where('exam_id', $examsid)
            ->with('qestionOptions')
            ->get();

        $anser = Answer::join('qestion_options', 'answers.answer', 'qestion_options.id')
            ->where('exam_id', $examsid)
            ->get();

        return view('LMS.lecturer.edit_question', ['answer'=>$anser, 'examsid'=>$examsid, 'totalquestions'=>$totalquestions, 'questions'=>$ques]);
    }

    public function view_exams_score($code, $id)
    {
        $exscore = ExamScore::where('exam_id', $id)->orderBy('score', 'Desc')->get();

        $user = DB::table('users')->where('indexnumber', 'like', '%GES%')->get();

        return view('LMS.lecturer.view_exam_score', ['score'=>$exscore, 'user'=>$user]);
    }

    public function lec_gradebook($code)
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $grade = Gradebook::where('user_id', auth()->user()->id)
            ->where('course_code', $code)
            ->where('semester', $semester)
            ->where('academicyear', $year)
            ->latest()->first();

        return view('LMS.lecturer.gradebook', ['code' => $code, 'grade' => $grade]);
    }

    public function lec_gradebook_save(Request $request)
    {
        $this->validate($request, [
    'attendancescore' => 'required',
    'quiz' => 'required',
    'exams' => 'required',
  ]);

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $data = [
    'attendance' => $request->input('attendancescore'),
    'quiz' => $request->input('quiz'),
    'exams' => $request->input('exams'),
    'academicyear' => $year,
    'semester' => $semester,
    'user_id' => auth()->user()->id,
    'course_code' => $request->input('coursecode'),
    'fullname' => auth()->user()->name,
  ];

        if ($request->has('hiddenid')) {
            $new = Gradebook::findorfail($request->post('hiddenid'))->update($data);
            toastr()->success('Grading Updated Successfully!');

            return Redirect()->back();
        }
        $new = new Gradebook($data);
        $new->save();
        toastr()->success('Grading Saved Successfully!');

        return Redirect()->back();
    }

    public function lec_meetings($code)
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $zoom = Zoomweb::where('lec_id', auth()->user()->id)
            ->where('cousers', $code)
            ->where('semester', $semester)
            ->where('academicyear', $year)
            ->latest()->get();

        // dd($zoom);

        return view('LMS.lecturer.meeeting', ['zoom' => $zoom, 'code' => $code]);
    }

    public function lec_meetings_save(Request $request)
    {
        $this->validate($request, [
    'title' => 'required',
    'start-time' => 'required',
    'duration' => 'required',
  ]);

        $data = [
    'topic' => $request->input('title'),
    'start_time' => new Carbon($request->input('start-time')),
    'duration' => $request->input('duration'),
  ];

        $meeting = Zoom::user()->find('ogua.ahmed18@gmail.com')
            ->meetings()->create($data);

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        if ($meeting) {
            $meeting->settings()->make([
    'host_video' => true,
    'participant_video' => true,
    'join_before_host' => false,
    'approval_type' => 2,
    'registration_type' => 2,
    'enforce_login' => false,
    'waiting_room' => false,
  ]);

            //$meeting->save();

            $details = [
    'zoomid' => $meeting->id,
    'user_id' => $meeting->user_id,
    'uuid' => $meeting->uuid,
    'lec_id' => auth()->user()->id,
    'lec_name' => auth()->user()->name,
    'title' => $request->input('title'),
    'starttime' => $request->input('start-time'),
    'duration' => $request->input('duration'),
    'cousers' => $request->input('cousers'),
    'join_url' => $meeting->join_url,
    'start_url' => $meeting->start_url,
    'academicyear' => $year,
    'semester' => $semester,
  ];

            $zoom = new Zoomweb($details);
            $zoom->save();

            toastr()->success('Zoom Meeting Created Successfully!');

            return Redirect()->back();
        }
        toastr()->error('Unable to create Zoom Meeting');

        return Redirect()->back();
    }

    public function lec_email($code)
    {
        $lec = Staff::where('user_id', auth()->user()->id)->first();

        return view('LMS.lecturer.email', ['lecturer' => $lec, 'code' => $code]);
    }

    public function lec_email_save(Request $request)
    {
        $this->validate($request, [
    'subject' => 'required',
    'compose' => 'required',
    'sendto' => 'required',
  ]);

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $subject = $request->post('subject');
        $compose = $request->post('compose');
        $sendto = $request->post('sendto');
        $code = $request->post('coursecode');

        $from = auth()->user()->name;
        $fremail = auth()->user()->email;

        $studntgroup = Studentgrouping::where('lecid', auth()->user()->id)
            ->where('coursecode', $code)
            ->where('semester', $semester)
            ->where('year', $year)
            ->latest()->get();

        if ($request->has('pdffile')) {
            $file = $request->file('pdffile')->store('Coursefile', 'public');

            $fullpath = asset('storage') . '/' . $file;

            $this->dispatch(new sendmailwithfile($from, $fremail, $subject, $compose, $studntgroup, $fullpath));
        } else {
            $this->dispatch(new sendmail($from, $fremail, $subject, $compose, $studntgroup));
        }

        toastr()->success('Mail Sent Successfully!');

        return Redirect()->back();
    }

    public function lec_attendance()
    {
        $course = Course::all();
        $prog = Programme::all();

        return view('LMS.lecturer.attendance', ['data' => $course, 'prog'=>$prog]);
    }

    public function getstudentsattenca(Request $request)
    {
        $level = $request->post('level');
        $programme = $request->post('programme');
        $code = $request->post('code');
        $session = $request->post('session');
        $date = $request->post('date');

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $students = Studentinfo::where('session', $session)
            ->where('progcode', $programme)
            ->where('currentlevel', $level)->get();

        $attendance = StudentAttendances::select(['indexnumber', 'date'])
            ->where('coursecode', $code)
            ->where('session', $session)
            ->where('lectid', auth()->user()->id)
            ->where('academicyear', $year)
            ->where('semester', $semester)->get()
            ->groupBy('indexnumber')
            ->map(function ($items) {
        return $items->pluck('indexnumber', 'date');
    });

        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));

        $daysInMonth = now()->setYear($year)
            ->setMonth($month)
            ->daysInMonth;

        $paginationLinks = static::getAttendancePaginationLinks($year, $month);

        //dd($paginationLinks);

        //dd($daysInMonth);

        return view('LMS.lecturer.showattendance', compact('daysInMonth', 'attendance', 'students', 'year', 'month', 'paginationLinks'));
    }

    public function attendancereportgenerate($level, $code, $programme, $session, $date)
    {

  //dd($level);

        $academicyear = Academicyear::where('status', '1')->first();
        $ayear = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $students = Studentinfo::where('session', $session)
            ->where('progcode', $programme)
            ->where('currentlevel', $level)->get();

        $attendance = StudentAttendances::select(['indexnumber', 'date'])
            ->where('coursecode', $code)
            ->where('session', $session)
            ->where('lectid', auth()->user()->id)
            ->where('academicyear', $ayear)
            ->where('semester', $semester)->get()
            ->groupBy('indexnumber')
            ->map(function ($items) {
        return $items->pluck('indexnumber', 'date');
    });

        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));

        $daysInMonth = now()->setYear($year)
            ->setMonth($month)
            ->daysInMonth;

        $paginationLinks = static::getAttendancePaginationLinks($year, $month);

        //dd($paginationLinks);

        //dd($daysInMonth);

        return view('LMS.lecturer.redirectattendancegen', compact(
            'daysInMonth',
            'attendance',
            'students',
            'year',
            'month',
            'paginationLinks',
            'level',
            'code',
            'programme',
            'session',
            'date',
            'semester'
        ));
    }

    public function getAttendancePaginationLinks(int $year, int $month)
    {
        $currentDate = now()->setYear($year)->setMonth($month)->toImmutable();
        $currentDateYear = $currentDate->year;
        $currentDateMonth = $currentDate->format('m');
        $previousDate = $currentDate->subMonth();
        $previousDateYear = $previousDate->year;
        $previousDateMonth = $previousDate->format('m');
        $nextDate = $currentDate->addMonth();
        $nextDateYear = $nextDate->year;
        $nextDateMonth = $nextDate->format('m');

        $dates = [
            [
                'year'     => $previousDateYear,
                'month'    => $previousDateMonth,
                'fullName' => $this->getYearAndFullMonthName($previousDateYear, $previousDateMonth),
                'date'        => $previousDate,
            ],
            [
                'year'     => $currentDateYear,
                'month'    => $currentDateMonth,
                'fullName' => $this->getYearAndFullMonthName($currentDateYear, $currentDateMonth),
                'date'        => $currentDate,
            ],
        ];

        if ($year < now()->year | ($year == now()->year && $month < now()->month)) {
            $dates[] = [
                'year'     => $nextDateYear,
                'month'    => $nextDateMonth,
                'fullName' => $this->getYearAndFullMonthName($nextDateYear, $nextDateMonth),
                'date'        => $nextDate,
            ];
        }

        return $dates;
    }

    /**
     * @return bool
     */
    public function isProvidedMonthGreaterThanCurrentMonth(int $year, int $month)
    {
        if ($year > now()->year) {
            return true;
        }

        if ($year == now()->year && $month > now()->month) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getYearAndFullMonthName(int $year, int $month)
    {
        return now()->setYear($year)->setMonth($month)->format('F Y');
    }

    public function attendancereportget($level, $code, $programme, $session, $date)
    {

  //dd($level);

        $academicyear = Academicyear::where('status', '1')->first();
        $ayear = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $students = Studentinfo::where('session', $session)
            ->where('progcode', $programme)
            ->where('currentlevel', $level)->get();

        $attendance = StudentAttendances::select(['indexnumber', 'date'])
            ->where('coursecode', $code)
            ->where('session', $session)
            ->where('lectid', auth()->user()->id)
            ->where('academicyear', $ayear)
            ->where('semester', $semester)->get()
            ->groupBy('indexnumber')
            ->map(function ($items) {
        return $items->pluck('indexnumber', 'date');
    });

        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));

        $daysInMonth = now()->setYear($year)
            ->setMonth($month)
            ->daysInMonth;

        $paginationLinks = static::getAttendancePaginationLinks($year, $month);

        //dd($paginationLinks);

        //dd($daysInMonth);

        return view('LMS.lecturer.redirectattendance', compact(
            'daysInMonth',
            'attendance',
            'students',
            'year',
            'month',
            'paginationLinks',
            'level',
            'code',
            'programme',
            'session',
            'date',
            'semester',
            'ayear'
        ));
    }

    public function getstudentsattenca_save(Request $request)
    {
        $count = \count($request->post('loop'));
        $mumber = $request->post('loop');
        $code = $request->post('code');
        $academicyear = $request->post('year');
        $semester = $request->post('semester');
        $session = $request->post('session');

        //dd($request);

        // dd($count);

        foreach ($mumber as $key => $value) {
            $loop = $mumber[$key];
            $user = $request->post('user' . $loop);

            $date = $request->post('date' . $loop);

            $countdate = \count($date);

            $curindex = $user;

            // echo $key.'=>'.$value;

            for ($i = 0; $i < $countdate; $i++) {
                $datenow = $date[$i];
                $day = substr($datenow, 8);
                $month = substr($datenow, 5, 2);
                $year = substr($datenow, 0, 4);

                $data = [
            'indexnumber' => $curindex,
            'attendance' => 'P',
            'note' => '',
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'date' => $datenow,
            'academicyear' => $academicyear,
            'semester' => $semester,
            'lectid' => auth()->user()->id,
            'coursecode' => $code,
            'lecname' => auth()->user()->name,
            'session' => $session,
        ];

                //dd($data);

                $attendance = StudentAttendances::where('coursecode', $code)
                    ->where('session', $session)
                    ->where('lectid', auth()->user()->id)
                    ->where('academicyear', $academicyear)
                    ->where('semester', $semester)
                    ->where('indexnumber', $user)
                    ->where('date', $datenow)->first();

                if ($attendance) {
                    $attendance->delete();
                }

                StudentAttendances::insert($data);
            }
        }

        return Redirect()->back()->with('message', 'Attendance Recorded Successfully!');
    }

    public function spedentsattencae(Request $request)
    {
        $count = \count($request->post('loop'));
        $mumber = $request->post('loop');
        $code = $request->post('code');
        $academicyear = $request->post('year');
        $semester = $request->post('semester');
        $session = $request->post('session');

        dd($request);

        // dd($count);

        for ($i = 0; $i < $count; $i++) {
            $loop = $mumber[$i];
            $user = $request->post('user' . $loop);

            $date = $request->post('date' . $loop);

            $countdate = \count($date);

            $curindex = $user;

            for ($i = 0; $i < $countdate; $i++) {
                $datenow = $date[$i];
                $day = substr($datenow, 8);
                $month = substr($datenow, 5, 2);
                $year = substr($datenow, 0, 4);

                $data = [
            'indexnumber' => $curindex,
            'attendance' => 'P',
            'note' => '',
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'date' => $datenow,
            'academicyear' => $academicyear,
            'semester' => $semester,
            'lectid' => auth()->user()->id,
            'coursecode' => $code,
            'lecname' => auth()->user()->name,
            'session' => $session,
        ];

                $attendance = StudentAttendances::where('coursecode', $code)
                    ->where('session', $session)
                    ->where('lectid', auth()->user()->id)
                    ->where('academicyear', $academicyear)
                    ->where('semester', $semester)
                    ->where('indexnumber', $user)
                    ->where('date', $datenow)->first();

                if ($attendance) {
                    $attendance->delete();
                }

                StudentAttendances::insert($data);
            }
        }

        return Redirect()->back()->with('message', 'Attendance Recorded Successfully!');
    }

    public function lec_attendance_fetch_student(Request $request)
    {
        $level = $request->post('level');
        $programme = $request->post('programme');
        $code = $request->post('code');
        $session = $request->post('session');
        $date = $request->post('date');

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $student = Studentinfo::where('session', $session)
            ->where('progcode', $programme)
            ->where('currentlevel', $level)->get();

        //dd($student);

        $attendance = StudentAttendances::where('coursecode', $code)
            ->where('session', $session)
            ->where('lectid', auth()->user()->id)
            ->where('academicyear', $year)
            ->where('semester', $semester)
            ->where('date', $date)->get();

        //dd($year);

        $count = \count($attendance);
        $html = '';
        $html .= '
    <form method="post" action="" id="submitattendance">

    <table id="example1" class="table table-bordered">
    <thead>
    <tr>
    <th></th>
    <th>Student ID</th>
    <th>Student name</th>
    <th>Attendance</th>
    <th>Note</th>
    <th></th>
    </tr>
    </thead>
    <tbody>';

        if (\count($student) > 0) {
            $loop = 1;
            foreach ($student as $row) {
                $html .= '
      <tr>
      <td></td>
      <td>' . $row->indexnumber . '</td>
      <td>' . $row->fullname . '</td>
      <td>';
                if ($count > 0) {
                    foreach ($attendance as $value) {
                        if ($value->indexnumber == $row->indexnumber) {
                            if ('' == $value->attendance) {
                                $html .= '
                    <input type="hidden" name="code" value="' . $code . '" />

                    <input type="hidden" name="year" value="' . $year . '" />

                    <input type="hidden" name="semester" value="' . $semester . '" />

                    <input type="hidden" name="session" value="' . $session . '" />

                    <input type="hidden" name="loop[]" value="' . $loop . '" />

                    <input type="hidden" name="date" value="' . $date . '" id="date"/>

                    <input type="hidden" name="user' . $loop . '" value="' . $row->indexnumber . '" id="date"/>

                    <label>
                    <input type="radio"  name="attend' . $loop . '" value="P" >
                    Present
                    </label>


                    <label>
                    <input type="radio"  name="attend' . $loop . '" value="A" >
                    Absent
                    </label>


                    <label>
                    <input type="radio" name="attend' . $loop . '" value="H" >
                    Holiday
                    </label>
                    ';
                            } else {
                                $html .= '

                    <input type="hidden" name="code" value="' . $code . '" />

                    <input type="hidden" name="year" value="' . $year . '" />

                    <input type="hidden" name="semester" value="' . $semester . '" />

                    <input type="hidden" name="session" value="' . $session . '" />

                    <input type="hidden" name="loop[]" value="' . $loop . '" />

                    <input type="hidden" name="date" value="' . $date . '" id="date"/>

                    <input type="hidden" name="user' . $loop . '" value="' . $row->indexnumber . '" id="date"/>



                    <label>
                    <input type="radio"  ';
                                if ('P' == $value->attendance) {
                                    $html .= 'checked';
                                }

                                $html .= ' name="attend' . $loop . '" value="P" >
                    Present
                    </label>


                    <label>
                    <input type="radio"  ';
                                if ('A' == $value->attendance) {
                                    $html .= 'checked';
                                }

                                $html .= ' name="attend' . $loop . '" value="A" >
                    Absent
                    </label>


                    <label>
                    <input type="radio" ';
                                if ('H' == $value->attendance) {
                                    $html .= 'checked';
                                }

                                $html .= ' name="attend' . $loop . '" value="H" >
                    Holiday
                    </label>
                    ';
                            }
                        }
                    }
                } else {
                    $html .= '

        <input type="hidden" name="code" value="' . $code . '" />

        <input type="hidden" name="year" value="' . $year . '" />

        <input type="hidden" name="semester" value="' . $semester . '" />

        <input type="hidden" name="session" value="' . $session . '" />

        <input type="hidden" name="loop[]" value="' . $loop . '" />

        <input type="hidden" name="date" value="' . $date . '" id="date"/>

        <input type="hidden" name="user' . $loop . '" value="' . $row->indexnumber . '" id="date"/>

        <label>
        <input type="radio"  name="attend' . $loop . '" value="P" >
        Present
        </label>


        <label>
        <input type="radio"  name="attend' . $loop . '" value="A" >
        Absent
        </label>


        <label>
        <input type="radio" name="attend' . $loop . '" value="H" >
        Holiday
        </label>

        ';
                }

                $html .= '</td>
    <td>';

                if ($count > 0) {
                    foreach ($attendance as $value) {
                        if ($value->indexnumber == $row->indexnumber) {
                            $html .= '
            <input type="text" name="note' . $loop . '" value="' . $value->note . '" class="form-control" />
            ';
                        }
                    }
                } else {
                    $html .= '
    <input type="text" name="note' . $loop . '" value="" class="form-control" />
    ';
                }

                $html .= '</td>

</tr>
';
                $loop++;
            }
        } else {
            $html .= '
    <tr>
    <td colspan="6">
    <div class="alert alert-danger">No Record Found </div>
    </td>
    </tr>
    ';
        }

        $html .= '
<tr>
<td  colspan="6"><input type="submit" class="btn btn-success pull-right" value="Save" /> </td>
</tr>
</tbody>
</table>
</form>';

        return $html;
    }

    public function attendancereport()
    {
        $course = Course::all();
        $prog = Programme::all();

        return view('LMS.lecturer.reportattendance', ['data' => $course, 'prog'=>$prog]);
    }

    public function attendancereport_fetch(Request $request)
    {
        $level = $request->post('level');
        $programme = $request->post('programme');
        $code = $request->post('code');
        $session = $request->post('session');
        $sdate = $request->post('sdate');
        $edate = $request->post('edate');

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $student = Studentinfo::where('session', $session)
            ->where('progcode', $programme)
            ->where('currentlevel', $level)->get();

        //dd($student);

        $attendance = StudentAttendances::where('coursecode', $code)
            ->where('session', $session)
            ->where('lectid', auth()->user()->id)
            ->where('academicyear', $year)
            ->where('semester', $semester)
            ->whereBetween('data', [$sdate, $edate])
            ->where('date', $date)->get();

        //dd($year);

        $count = \count($attendance);
        $html = '';
        $html .= '
    <form method="post" action="" id="submitattendance">

    <table id="example1" class="table table-bordered">
    <thead>
    <tr>
    <th></th>
    <th>Student ID</th>
    <th>Student name</th>
    <th>Attendance</th>
    <th>Note</th>
    <th></th>
    </tr>
    </thead>
    <tbody>';

        if (\count($student) > 0) {
            $loop = 1;
            foreach ($student as $row) {
                $html .= '
      <tr>
      <td></td>
      <td>' . $row->indexnumber . '</td>
      <td>' . $row->fullname . '</td>
      <td>';
                if ($count > 0) {
                    foreach ($attendance as $value) {
                        if ($value->indexnumber == $row->indexnumber) {
                            if ('' == $value->attendance) {
                                $html .= '
                    <input type="hidden" name="code" value="' . $code . '" />

                    <input type="hidden" name="year" value="' . $year . '" />

                    <input type="hidden" name="semester" value="' . $semester . '" />

                    <input type="hidden" name="session" value="' . $session . '" />

                    <input type="hidden" name="loop[]" value="' . $loop . '" />

                    <input type="hidden" name="date" value="' . $date . '" id="date"/>

                    <input type="hidden" name="user' . $loop . '" value="' . $row->indexnumber . '" id="date"/>

                    <label>
                    <input type="radio"  name="attend' . $loop . '" value="P" >
                    Present
                    </label>


                    <label>
                    <input type="radio"  name="attend' . $loop . '" value="A" >
                    Absent
                    </label>


                    <label>
                    <input type="radio" name="attend' . $loop . '" value="H" >
                    Holiday
                    </label>
                    ';
                            } else {
                                $html .= '

                    <input type="hidden" name="code" value="' . $code . '" />

                    <input type="hidden" name="year" value="' . $year . '" />

                    <input type="hidden" name="semester" value="' . $semester . '" />

                    <input type="hidden" name="session" value="' . $session . '" />

                    <input type="hidden" name="loop[]" value="' . $loop . '" />

                    <input type="hidden" name="date" value="' . $date . '" id="date"/>

                    <input type="hidden" name="user' . $loop . '" value="' . $row->indexnumber . '" id="date"/>



                    <label>
                    <input type="radio"  ';
                                if ('P' == $value->attendance) {
                                    $html .= 'checked';
                                }

                                $html .= ' name="attend' . $loop . '" value="P" >
                    Present
                    </label>


                    <label>
                    <input type="radio"  ';
                                if ('A' == $value->attendance) {
                                    $html .= 'checked';
                                }

                                $html .= ' name="attend' . $loop . '" value="A" >
                    Absent
                    </label>


                    <label>
                    <input type="radio" ';
                                if ('H' == $value->attendance) {
                                    $html .= 'checked';
                                }

                                $html .= ' name="attend' . $loop . '" value="H" >
                    Holiday
                    </label>
                    ';
                            }
                        }
                    }
                } else {
                    $html .= '

        <input type="hidden" name="code" value="' . $code . '" />

        <input type="hidden" name="year" value="' . $year . '" />

        <input type="hidden" name="semester" value="' . $semester . '" />

        <input type="hidden" name="session" value="' . $session . '" />

        <input type="hidden" name="loop[]" value="' . $loop . '" />

        <input type="hidden" name="date" value="' . $date . '" id="date"/>

        <input type="hidden" name="user' . $loop . '" value="' . $row->indexnumber . '" id="date"/>

        <label>
        <input type="radio"  name="attend' . $loop . '" value="P" >
        Present
        </label>


        <label>
        <input type="radio"  name="attend' . $loop . '" value="A" >
        Absent
        </label>


        <label>
        <input type="radio" name="attend' . $loop . '" value="H" >
        Holiday
        </label>

        ';
                }

                $html .= '</td>
    <td>';

                if ($count > 0) {
                    foreach ($attendance as $value) {
                        if ($value->indexnumber == $row->indexnumber) {
                            $html .= '
            <input type="text" name="note' . $loop . '" value="' . $value->note . '" class="form-control" />
            ';
                        }
                    }
                } else {
                    $html .= '
    <input type="text" name="note' . $loop . '" value="" class="form-control" />
    ';
                }

                $html .= '</td>

</tr>
';
                $loop++;
            }
        } else {
            $html .= '
    <tr>
    <td colspan="6">
    <div class="alert alert-danger">No Record Found </div>
    </td>
    </tr>
    ';
        }

        $html .= '
<tr>
<td  colspan="6"><input type="submit" class="btn btn-success pull-right" value="Save" /> </td>
</tr>
</tbody>
</table>
</form>';

        return $html;
    }

    public function lec_attendance_fetch_student_save(Request $request)
    {
        $count = \count($request->post('loop'));
        $mumber = $request->post('loop');
        $code = $request->post('code');
        $academicyear = $request->post('year');
        $semester = $request->post('semester');
        $session = $request->post('session');

        $date = $request->post('date');

        for ($i = 0; $i < $count; $i++) {
            $loop = $mumber[$i];
            $indexnumber = $request->post('user' . $loop);
            $attend = $request->post('attend' . $loop);
            $note = $request->post('note' . $loop);
            $day = substr($date, 8);
            $month = substr($date, 5, 2);
            $year = substr($date, 0, 4);

            $data = [
            'indexnumber' => $indexnumber,
            'attendance' => $attend,
            'note' => $note,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'date' => $date,
            'academicyear' => $academicyear,
            'semester' => $semester,
            'lectid' => auth()->user()->id,
            'coursecode' => $code,
            'lecname' => auth()->user()->name,
            'session' => $session,
        ];

            //make query
            $attendance = StudentAttendances::where('coursecode', $code)
                ->where('session', $session)
                ->where('lectid', auth()->user()->id)
                ->where('academicyear', $year)
                ->where('semester', $semester)
                ->where('indexnumber', $indexnumber)
                ->where('date', $date)->first();

            if ($attendance) {
                //record dey so update

                $attendance->attendance = $attend;
                $attendance->note = $note;
                $attendance->save();
            } else {
                //new record so update
                //
                $newrecord = new StudentAttendances($data);
                $newrecord->save();
            }
        }

        return 'success';
    }

    public function lec_lesson_plan($code)
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $lessplan = Lessonplan::where('user_id', auth()->user()->id)
            ->where('course_code', $code)
            ->where('semester', $semester)
            ->where('academicyear', $year)
            ->latest()->get();

        //dd($lessplan);

        return view('LMS.lecturer.lesson_plan', ['code' => $code, 'data' => $lessplan]);
    }

    public function lec_lesson_plan_edit($code, $id)
    {
        $lessplan = Lessonplan::where('id', $id)
            ->first();

        return view('LMS.lecturer.lesson_plan_edit', ['code' => $code, 'data' => $lessplan]);
    }

    public function lec_lesson_plan_delete($id)
    {
        Lessonplan::where('id', $id)
            ->delete();

        return Redirect()->back();
    }

    public function lec_lesson_plan_save(Request $request)
    {
        $this->validate($request, [
    'week' => 'required',
    'topic' => 'required',
    'aimlesson' => 'required',
    'objec' => 'required',
    'keyskills' => 'required',
    'coursemat' => 'required',
    'lessques' => 'required',
    'lessnote' => 'required',
  ]);

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $data = [
    'week' => $request->input('week'),
    'topic' => $request->input('topic'),
    'aims' => $request->input('aimlesson'),
    'obj' => $request->input('objec'),
    'skills' => $request->input('keyskills'),
    'materials' => $request->input('coursemat'),
    'questions' => $request->input('lessques'),
    'feedback' => $request->input('lessnote'),
    'academicyear' => $year,
    'semester' => $semester,
    'user_id' => auth()->user()->id,
    'course_code' => $request->input('coursecode'),
    'fullname' => auth()->user()->name,
  ];

        if ($request->has('hiddenid')) {
            $new = Lessonplan::findorfail($request->post('hiddenid'))->update($data);

            return Redirect()->route('lms-lec-lesson-plan', ['code' => $request->input('coursecode')])->with('message', 'Lesson Plan Updated Successfully!');
        }
        $new = new Lessonplan($data);
        $new->save();

        return Redirect()->back()->with('message', 'Lesson Plan Saved Successfully!');
    }

    public function lec_lesson_docs($code)
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $lessdoc = Lessondoc::where('user_id', auth()->user()->id)
            ->where('course_code', $code)
            ->where('semester', $semester)
            ->where('academicyear', $year)
            ->latest()->get();

        return view('LMS.lecturer.lesson_doc', ['code' => $code, 'data' => $lessdoc]);
    }

    public function lec_lesson_docs_save(Request $request)
    {
        $this->validate($request, [
    'week' => 'required',
    'title' => 'required',
    'doc' => 'required|mimes:pdf,docx,txt',
  ]);

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $data = [
    'week' => $request->input('week'),
    'title' => $request->input('title'),
    'doc' => $request->file('doc')->store('Coursefile', 'public'),
    'academicyear' => $year,
    'semester' => $semester,
    'user_id' => auth()->user()->id,
    'course_code' => $request->input('coursecode'),
    'fullname' => auth()->user()->name,
  ];

        $new = new Lessondoc($data);
        $new->save();

        return Redirect()->back()->with('message', 'Document Uploaded Successfully!');
    }

    public function lec_lesson_docs_delete(Request $request, $id)
    {
        $new = Lessondoc::findorfail($id);
        $doc = $new->doc;

        $storage = Storage::disk('public')->delete($doc);
        // $storage = Storage::delete($name);
        //delete form database;
        if ($storage) {
            $new->delete();
        }

        return Redirect()->back();
    }

    public function lec_online_videos($code)
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $video = Videoupload::where('user_id', auth()->user()->id)
            ->where('course_code', $code)
            ->where('semester', $semester)
            ->where('academicyear', $year)
            ->latest()->get();

        return view('LMS.lecturer.online_video', ['code' => $code, 'data' => $video]);
    }

    public function lec_online_videos_edit($code, $id)
    {
        $video = Videoupload::where('id', $id)->first();

        //dd($video);

        return view('LMS.lecturer.online_video_edit', ['code' => $code, 'data' => $video]);
    }

    public function lec_online_video_save(Request $request)
    {
        $this->validate($request, [
    'week' => 'required',
    'title' => 'required',
    'desc' => 'required',
    'url' => 'required',
  ]);

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $url = $request->input('url');

        $youtudeid = explode('/', $url);

        $vid = end($youtudeid);

        $data = [
    'week' => $request->input('week'),
    'title' => $request->input('title'),
    'desc' => $request->input('desc'),
    'url' => $request->input('url'),
    'youtubeid' => $vid,
    'academicyear' => $year,
    'semester' => $semester,
    'user_id' => auth()->user()->id,
    'course_code' => $request->input('coursecode'),
    'fullname' => auth()->user()->name,
  ];

        //dd($data);

        if ($request->has('hiddenid')) {
            $id = $request->post('hiddenid');
            $new = Videoupload::findorfail($id)->update($data);

            return Redirect()->route('lms-lec-online-videos', ['code'=> $request->input('coursecode')])->with('message', 'Video Info Updated Successfully!');
        }
        $new = new Videoupload($data);
        $new->save();

        return Redirect()->back()->with('message', 'Video Info Saved Successfully!');
    }

    public function lec_online_video_delete($id)
    {
        Videoupload::findorfail($id)->delete();

        return Redirect()->back();
    }

    public function lec_online_assignments($code)
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $assignmnent = Assignment::where('lecturer_id', auth()->user()->id)
            ->where('course_code', $code)
            ->where('semester', $semester)
            ->where('academicyear', $year)
            ->latest()->get();

        return view('LMS.lecturer.post_assignment', ['code' => $code, 'data' => $assignmnent]);
    }

    public function lec_online_assignment_edit($code, $id)
    {
        $assingment = Assignment::where('id', $id)->first();

        return view('LMS.lecturer.edit_assignment', ['assingment'=> $assingment, 'code'=>$code]);
    }

    public function lec_online_assignment_submitted($code, $id)
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $assingment = Submission::where('assignment_id', $id)->get();

        $user = Studentgrouping::where('year', $year)
       ->where('semester', $semester)
       ->where('coursecode', $code)
       ->where('lecid', auth()->user()->id)
       ->get();

        //dd($assingment);
        return view('LMS.lecturer.submitted_assignment', ['assingment'=> $assingment, 'user'=> $user]);
    }

    public function lec_public_chat($code)
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $grp = Studentgrouping::where('year', $year)
      ->where('semester', $semester)
      ->where('coursecode', $code)
      ->where('lecid', auth()->user()->id)
      ->get();

        $user = User::join(
            'studentgroupings',
            'studentgroupings.indexnumber',
            '=',
            'users.indexnumber'
        )
            ->where('year', $year)
            ->where('semester', $semester)
            ->where('coursecode', $code)
            ->where('lecid', auth()->user()->id)->get();

        $message = chatmessages::all()->
   where('year', $year)
       ->where('semester', $semester)
       ->where('code', $code)
       ->where('lectid', auth()->user()->id)->groupBy(function ($item) { return $item->created_at->format('d-M-Y'); })->toArray();

        return view('LMS.lecturer.all_chat', ['users' => $user, 'messages' => $message, 'code' => $code, 'grp' => $grp, 'lectid' => auth()->user()->id, 'lecname' => auth()->user()->name]);
    }

    public function lec_private_chat($code)
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $user = Studentgrouping::where('year', $year)
      ->where('semester', $semester)
      ->where('coursecode', $code)
      ->where('lecid', auth()->user()->id)
      ->get();

        $message = chatmessages::all()->groupBy(function ($item) { return $item->created_at->format('d-M-Y'); })->toArray();

        return view('LMS.lecturer.private', ['users' => $user, 'messages' => $message, 'code' => $code]);
    }

    public function main()
    {
        return view('LMS.main');
    }

    public function site_overview()
    {

  //dd(auth()->user()->studentgrouping()->pluck('studentgroupings.coursecode')->toArray());

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $courses = LecCource::paginate(9)->fragment('Courses');

        //dd(auth()->user()->studentinfos->session);

        return view('LMS.overview', ['courses' => $courses]);
    }

    public function site_overview_enroll(Request $request)
    {
        $code = $request->post('code');
        $lectid = $request->post('lectid');
        $lectname = $request->post('lectname');

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semester = $academicyear->semester;

        $coursereg = Coureregistration::where('cource_code', $code)
            ->where('indexnumber', auth()->user()->indexnumber)->first();

        if (!$coursereg) {
            return 'failed';
        }

        $data = [
    'indexnumber' => auth()->user()->indexnumber,
    'studentname' => auth()->user()->name,
    'year' => $year,
    'semester' => $semester,
    'lecname' => $lectname,
    'lecid' => $lectid,
    'capacity' => '1',
    'group' => '',
    'session' => auth()->user()->studentinfos->session,
    'coursecode' => $code,
    'level' => auth()->user()->studentinfos->currentlevel,
    'progcode' => auth()->user()->studentinfos->progcode,
  ];

        $check = Studentgrouping::where('indexnumber', auth()->user()->indexnumber)
            ->where('coursecode', $code)
            ->where('lecid', $lectid)
            ->first();

        if ($check) {
            echo 'error';
        } else {
            $new = new Studentgrouping($data);
            $new->save();
            echo 'success';
        }
    }

    public function profile()
    {
        $student = Studentinfo::where('user_id', auth()->user()->id)->first();

        return view('LMS.profile', ['personal' => $student]);
    }

    public function course_overview(Request $request)
    {
        $code = $request->get('code');

        $coursereg = Coureregistration::where('cource_code', $code)
            ->where('indexnumber', auth()->user()->indexnumber)->first();

        $user = Studentgrouping::where('coursecode', $code)
            ->where('indexnumber', auth()->user()->indexnumber)
            ->first();

        //dd($user);

        if (!$user) {
            return Redirect()->route('lms-empty', ['code' => $code]);
        }

        $staff = Staff::where('user_id', $user->lecid)->first();

        $data = Courseoverview::where('user_id', $user->lecid)
            ->where('course_code', $code)->first();

        $announcement = Announcement::where('user_id', $user->lecid)
            ->where('course_code', $code)
            ->get();

        $grade = Gradebook::where('user_id', $user->lecid)
            ->where('course_code', $code)->get();
        //dd($view);

        return view('LMS.course.overview', ['data' => $data, 'course' => $coursereg, 'code' => $code, 'lecturer' => $user, 'staff' => $staff, 'announcement' => $announcement, 'grade' => $grade]);
    }

    public function lesson_plan(Request $request)
    {
        $code = $request->get('code');

        $user = Studentgrouping::where('coursecode', $code)
            ->where('indexnumber', auth()->user()->indexnumber)
            ->first();

        if (!$user) {
            return Redirect()->route('lms-empty', ['code' => $code]);
        }
        $lect = $user->lecid;

        $data = Lessonplan::where('user_id', $lect)
            ->where('course_code', $code)->get();

        //dd($lect);

        return view('LMS.course.lesson_plan', ['data' => $data, 'code' => $code]);
    }

    public function course_materials(Request $request)
    {
        $code = $request->get('code');
        $user = Studentgrouping::where('coursecode', $code)
            ->where('indexnumber', auth()->user()->indexnumber)
            ->first();

        if (!$user) {
            return Redirect()->route('lms-empty', ['code' => $code]);
        }
        $lect = $user->lecid;

        $data = Lessondoc::where('user_id', $lect)
            ->where('course_code', $code)->get();

        return view('LMS.course.course_materials', ['data' => $data, 'code' => $code]);
    }

    public function course_video(Request $request)
    {
        $code = $request->get('code');
        $user = Studentgrouping::where('coursecode', $code)
            ->where('indexnumber', auth()->user()->indexnumber)
            ->first();

        if (!$user) {
            return Redirect()->route('lms-empty', ['code' => $code]);
        }
        $lect = $user->lecid;

        $data = Videoupload::where('user_id', $lect)
            ->where('course_code', $code)->get();
        //dd($data);
        if (\count($data) < 1) {
            return Redirect()->route('lms-nodata', ['code' => $code]);
        }

        $first = Videoupload::where('user_id', $lect)
            ->where('course_code', $code)->first();

        return view('LMS.course.course_video', ['data' => $data, 'first' => $first, 'code' => $code]);
    }

    public function Announcement(Request $request)
    {
        $code = $request->get('code');
        $user = Studentgrouping::where('coursecode', $code)
            ->where('indexnumber', auth()->user()->indexnumber)
            ->first();
        if (!$user) {
            return Redirect()->route('lms-empty', ['code' => $code]);
        }
        $lect = $user->lecid;

        $data = Announcement::where('user_id', $lect)
            ->where('course_code', $code)->get();

        return view('LMS.course.announcement', ['data' => $data, 'code' => $code]);
    }

    public function announcement_view()
    {
        $data = Studentgrouping::where('indexnumber', auth()->user()->indexnumber)
            ->get();

        //dd($data);

        // Announcement::where('user_id',$user->lecid)->get();

        return view('LMS.main.announcement', ['data' => $data]);
    }

    public function tests_quiz(Request $request)
    {
        $code = $request->get('code');
        $user = Studentgrouping::where('coursecode', $code)
            ->where('indexnumber', auth()->user()->indexnumber)
            ->first();
        if (!$user) {
            return Redirect()->route('lms-empty', ['code' => $code]);
        }
        $lect = $user->lecid;

        $data = Exam::where('lecturer_id', $lect)
            ->where('coursecode', $code)->get();

        return view('LMS.course.quiz', ['data' => $data, 'code' => $code]);
    }

    public function tests_quiz_start(Request $request, $id)
    {
        $code = $request->get('code');

        $exam = Exam::where('id', $id)->first();
        $examid = $exam->id;
        $examtot = $exam->questiontoshow;
        $examStatus = $exam->retry;
        $mins = $exam->minutes;
        $etitle = $exam->title;

        //change it and apply changes Later
        // No

        if ('No' == $examStatus) {
            //Add User Details To Exams Tracking
            //first check if this user exist
            $examtrack = Examtrack::where('user_id', auth()->user()->id)
                ->where('exam_id', $examid)->first();
            if ($examtrack) {
                return Redirect()->back()->with('Message', 'Your Session has Expired!');
            }
            //add to exams tracking
            $data = ['user_id'=> auth()->user()->id, 'exam_id'=>$examid];
            $track = new Examtrack($data);
            $track->save();
        }

        $ques = Question::where('exam_id', $examid)
            ->with('qestionOptions')
            ->get()->shuffle()->take($examtot);

        //now insert the given question then fetch it back to the user
        $studex = Studentexam::where('user_id', auth()->user()->id)
            ->where('exam_id', $examid)->get();

        if (!empty($studex)) {
            foreach ($studex as $studenteams) {
                $studenteams->delete();
            }
        }

        foreach ($ques as $row) {
            $data = [
    'question_id' => $row['id'],
    'exam_id' => $row['exam_id'],
    'user_id' => auth()->user()->id,
  ];

            $stueaxm = new Studentexam($data);
            $stueaxm->save();
        }

        // return Redirect()->route('student_exams_start',
        //   ['studentname'=> auth()->user()->name,
        //   'examid'=> $examid,
        //   'examtotal'=> $examtot,
        //   'mins'=> $mins]);

        return Redirect()->route(
            'lms-student-exams-start',
            ['studentname'=> auth()->user()->name,
  'examid'=> $examid,
  'examtotal'=> $examtot,
  'mins'=> $mins,
  'code' => $code,
  'title' => $etitle,
]
        );
    }

    public function student_exams_start(Request $request, $studentname, $examid, $examtotal, $mins)
    {
        $code = $request->get('code');
        $title = $request->get('title');
        //fetch exams from database
        $ques = Studentexam::where('user_id', auth()->user()->id)
            ->where('exam_id', $examid)->get();

        return view('LMS.course.quiz_start', ['mins'=>$mins, 'questions'=>$ques, 'examsid'=>$examid, 'examtot'=>$examtotal, 'code' => $code, 'title' => $title]);
    }

    public function retry_exam_results(Request $request, $id)
    {
        $code = $request->get('code');
        $wrespon = Examretryresponse::where('user_id', auth()->user()->id)
            ->where('exam_id', $id)->get();

        //dd($wrespon);
        return view('LMS.course.results_view', ['examsresults'=>$wrespon, 'code' => $code]);
    }

    public function assignment(Request $request)
    {
        $code = $request->get('code');
        $user = Studentgrouping::where('coursecode', $code)
            ->where('indexnumber', auth()->user()->indexnumber)
            ->first();

        if (!$user) {
            return Redirect()->route('lms-empty', ['code' => $code]);
        }
        $lect = $user->lecid;

        $data = Assignment::where('lecturer_id', $lect)
            ->where('course_code', $code)->latest()->get();

        return view('LMS.course.assignment', ['data' => $data, 'code' => $code]);
    }

    public function assignment_view(Request $request, $id)
    {
        $code = $request->get('code');
        $assingment = Assignment::where('id', $id)->first();

        $sub = Submission::where('assignment_id', $id)->where('studentid', auth()->user()->indexnumber)->count();

        //dd($sub);

        $diffs = now()->diffInDays(\Carbon\Carbon::parse($assingment->subenddate), false);
        //dd($diffs);

        return view('LMS.course.assignment_view', ['assignmentid'=> $id, 'row'=> $assingment, 'elapse'=> $diffs, 'subs'=> $sub, 'code' => $code]);
    }

    public function zoom_meeting(Request $request)
    {
        $code = $request->get('code');
        $user = Studentgrouping::where('coursecode', $code)
            ->where('indexnumber', auth()->user()->indexnumber)
            ->first();

        if (!$user) {
            return Redirect()->route('lms-empty', ['code' => $code]);
        }
        $lect = $user->lecid;

        $data = Zoomweb::where('lec_id', $lect)
            ->where('cousers', $code)->latest()->get();

        return view('LMS.course.zoom_meeting', ['data' => $data, 'code' => $code]);
    }

    public function chat_room_public(Request $request)
    {
        $code = $request->get('code');

        $lectd = Studentgrouping::where('coursecode', $code)
            ->where('indexnumber', auth()->user()->indexnumber)
            ->first();

        if (!$lectd) {
            return Redirect()->route('lms-empty', ['code' => $code]);
        }
        $lect = $lectd->lecid;
        $lecname = $lectd->lecname;

        $grp = User::join(
            'studentgroupings',
            'studentgroupings.indexnumber',
            '=',
            'users.indexnumber'
        )
            ->where('coursecode', $code)
            ->where('lecid', $lect)->get();

        $user = User::join(
            'studentgroupings',
            'studentgroupings.indexnumber',
            '=',
            'users.indexnumber'
        )
            ->where('coursecode', $code)
            ->where('lecid', $lect)->get();

        $message = chatmessages::all()
            ->where('code', $code)
            ->where('lectid', $lect)->groupBy(function ($item) { return $item->created_at->format('d-M-Y'); })->toArray();

        return view('LMS.course.public_chat', ['users' => $user, 'messages' => $message, 'grp' => $grp, 'code' => $code, 'lectid' => $lect, 'lecname' =>  $lecname]);
    }

    public function chat_room_private(Request $request)
    {
        $code = $request->get('code');

        $lectd = Studentgrouping::where('coursecode', $code)
            ->where('indexnumber', auth()->user()->indexnumber)
            ->first();

        if (!$lectd) {
            return Redirect()->route('lms-empty', ['code' => $code]);
        }
        $lect = $lectd->lecid;
        $lecname = $lectd->lecname;

        $user = User::join(
            'studentgroupings',
            'studentgroupings.indexnumber',
            '=',
            'users.indexnumber'
        )
            ->where('coursecode', $code)
            ->where('lecid', $lect)->get();

        $message = chatmessages::all()->
where('type', 'public')->groupBy(function ($item) { return $item->created_at->format('d-M-Y'); })->toArray();

        return view('LMS.course.private_chat', ['users' => $user, 'messages' => $message, 'lectureid' => $lect, 'code' => $code]);
    }

    public function private_file()
    {
        $data = Privatefile::where('user_id', auth()->user()->id)->latest()->get();

        return view('LMS.main.private_file', ['data' => $data]);
    }

    public function private_file_save(Request $request)
    {
        $this->validate($request, [
    'title' => 'required',
    'file' => 'required|mimes:pdf,docx,txt',
  ]);

        $data = [
    'user_id' => auth()->user()->id,
    'title' => $request->input('title'),
    'file' => $request->file('file')->store('PrivateFiles', 'public'),
  ];

        $new = new Privatefile($data);
        $new->save();

        return Redirect()->back()->with('message', 'File Uploaded Successfully!');
    }

    public function private_file_delete($id)
    {
        $data = Privatefile::where('id', $id)->first();

        $doc = $data->file;

        $storage = Storage::disk('public')->delete($doc);

        if ($storage) {
            $data->delete();
        }

        return Redirect()->back();
    }

    public function calendar()
    {
        return view('LMS.main.calendar');
    }

    public function calendar_save(Request $request)
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
    'coursecode' => '',
    'lecname' => auth()->user()->name,
  ];

        $new = new AcademicCalendar($data);
        $new->save();

        echo 'successfully';
        exit();
    }

    public function calendar_get(Request $request)
    {
        $new = AcademicCalendar::all()->toArray();

        echo json_encode($new);
    }

    public function empty(Request $request)
    {
        $code = $request->get('code');

        return view('LMS.main.empty', ['code' => $code]);
    }

    public function nodata(Request $request)
    {
        $code = $request->get('code');

        return view('LMS.nodata', ['code' => $code]);
    }

    public function calendar_student()
    {
        return view('LMS.course.calendar');
    }

    public function calendar_getevents(Request $request)
    {
        $code = $request->get('code');

        $lect = Studentgrouping::where('coursecode', $code)
            ->where('indexnumber', auth()->user()->indexnumber)
            ->first();

        if (!$lect) {
        } else {
            $new = AcademicCalendar::where('coursecode', $code)
                ->where('lectid', $lect->lecid)
                ->get()
                ->toArray();

            echo json_encode($new);
        }
    }

    public function my_courses()
    {

 // $message = Coureregistration::all()->where('indexnumber',auth()->user()->indexnumber)
        // ->groupBy(function($item){ return $item->academic_year; })->toArray();

        $data = Coureregistration::all()->where('indexnumber', auth()->user()->indexnumber)
            ->groupBy(['academic_year', 'semester'])->toArray();

        //dd($data);
        return view('LMS.main.course', ['data' => $data]);
    }

    public function my_courses_save(Request $request)
    {
        //dd($request);
        $id = $request->post('cid');
        $val = $request->post('val');

        $course = Coureregistration::where('id', $id)->first();

        if ('' == $val) {
            $course->fvrt = '0';
            $course->save();
        } else {
            $course->fvrt = '1';
            $course->save();
        }

        //dd($course);
    }

    public function attendance(Request $request)
    {
        $code = $request->get('code');
        // $attendance = StudentAttendances::where('indexnumber',auth()->user()->indexnumber)
        // ->where('coursecode',$code)
        // ->where('year',date('Y'))->get();

        $attendance = StudentAttendances::where('indexnumber', auth()->user()->indexnumber)
            ->where('coursecode', $code)
            ->where('year', date('Y'))->get();

        $totalpresent = StudentAttendances::where('indexnumber', auth()->user()->indexnumber)
            ->where('coursecode', $code)
            ->where('year', date('Y'))
            ->where('attendance', 'P')->count();

        //dd($totalpresent);

        $totallate = StudentAttendances::where('indexnumber', auth()->user()->indexnumber)
            ->where('coursecode', $code)
            ->where('year', date('Y'))
            ->where('attendance', 'L')->count();

        $totalabsent = StudentAttendances::where('indexnumber', auth()->user()->indexnumber)
            ->where('coursecode', $code)
            ->where('year', date('Y'))
            ->where('attendance', 'A')->count();

        $totalholiday = StudentAttendances::where('indexnumber', auth()->user()->indexnumber)
            ->where('coursecode', $code)
            ->where('year', date('Y'))
            ->where('attendance', 'H')->count();

        $totalhalfday = StudentAttendances::where('indexnumber', auth()->user()->indexnumber)
            ->where('coursecode', $code)
            ->where('year', date('Y'))
            ->where('attendance', 'F')->count();

        //dd($attendance);

        return view('LMS.course.attendance', ['code' => $code, 'attendance' => $attendance, 'totalpresent' => $totalpresent, 'totallate' => $totallate, 'totalabsent' => $totalabsent, 'totalholiday' => $totalholiday, 'totalhalfday' => $totalhalfday, 'studentid' => auth()->user()->indexnumber]);
    }

    public function attendance_year_fetch(Request $request)
    {
        $id = $request->post('studentid');
        $code = $request->post('code');
        $year = $request->post('value');

        $attendance = StudentAttendances::where('indexnumber', $id)
            ->where('coursecode', $code)
            ->where('year', $year)->get();

        $totalpresent = StudentAttendances::where('indexnumber', $id)
            ->where('coursecode', $code)
            ->where('year', $year)
            ->where('attendance', 'P')->count();

        $totallate = StudentAttendances::where('indexnumber', $id)
            ->where('coursecode', $code)
            ->where('year', $year)
            ->where('attendance', 'L')->count();

        $totalabsent = StudentAttendances::where('indexnumber', $id)
            ->where('coursecode', $code)
            ->where('year', $year)
            ->where('attendance', 'A')->count();

        $totalholiday = StudentAttendances::where('indexnumber', $id)
            ->where('coursecode', $code)
            ->where('year', $year)
            ->where('attendance', 'H')->count();

        $totalhalfday = StudentAttendances::where('indexnumber', $id)
            ->where('coursecode', $code)
            ->where('year', $year)
            ->where('attendance', 'F')->count();

        return view('LMS.course.attendance_view', ['attendance' => $attendance, 'totalpresent' => $totalpresent, 'totallate' => $totallate, 'totalabsent' => $totalabsent, 'totalholiday' => $totalholiday, 'totalhalfday' => $totalhalfday, 'year' => $year]);
    }
}
