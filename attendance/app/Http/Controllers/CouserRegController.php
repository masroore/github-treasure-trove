<?php

namespace App\Http\Controllers;

use App\Academicyear;
use App\Coureregistration;
use App\Defer;
use App\Dismssal;
use App\Examresults;
use App\Paymentdeadline;
use App\Programmecourse;
use App\Rasticate;
use App\Regacademicyear;
use App\Resultsrelease;
use App\Studentfee;
use App\Studentinfo;
use App\User;
use Illuminate\Http\Request;

class CouserRegController extends Controller
{
    public function register_course_user(Request $request)
    {
        $user = auth()->user();
        $studentinfo = Studentinfo::where('user_id', $user->id)->first();

        $cademicyear = Academicyear::where('status', 1)->first();
        $academicyear = $cademicyear->acdemicyear;
        $academicsem = $cademicyear->semester;

        $creg = Coureregistration::where('user_id', $user->id)
            ->where('semester', $academicsem)
            ->where('academic_year', $academicyear)->get();
        //$courses =
        //dd($cademicyear);

        //dd($creg);
        return view('CourseRegistration.reg_course_student', ['course'=> $creg, 'academicyear' => $academicyear, 'semester'=>$academicsem, 'studentinfo'=>$studentinfo]);
    }

    public function register_course_user_now($prog, $code, $currentlevel, $semester, $academicyear)
    {
        $indexnumber = auth()->user()->indexnumber;
        //check dimissal || Rasticate | Defer
        $dsmiss = Dismssal::where('studendid', $indexnumber)
            ->where('status', '1')->first();
        if ($dsmiss) {
            return Redirect()->back()->with('error', 'Cant Perform This action now, please visit Academic for more info.');
        }

        $rasticate = Rasticate::where('studentid', $indexnumber)
            ->where('status', '1')->first();
        if ($rasticate) {
            return Redirect()->back()->with('error', 'Cant Perform This action now, please visit Academic for more info.');
        }

        $ras = Defer::where('studentid', $indexnumber)
            ->where('status', '1')->first();
        if ($ras) {
            return Redirect()->back()->with('error', 'Cant Perform This action now, please visit Academic for more info.');
        }

        //check if fee deadline has been met
        $getdeadline = Paymentdeadline::latest()->first();
        $date = $getdeadline->deadline;
        $diffs = now()->diffInDays(\Carbon\Carbon::parse($date), false);
        if ($diffs < 0) {
            return Redirect()->back()->with('error', 'Course Registration Date Elpased. Visit accounts to register course');
        }

        //check if student has paid fess
        $fees = Studentfee::where('indexnumber', auth()->user()->indexnumber)->get();

        //dd($fees);

        if (\count($fees) > 0) {
        } else {
            return Redirect()->back()->with('error', 'Course Registration Under Contruction, Check in Later, or make sure all financial obligations has been met!');
        }

        //dd("exit");

        //check semster
        //get current academic year
        $cademicyear = Academicyear::where('status', 1)->first();
        $academic = $cademicyear->acdemicyear;
        $semester = $cademicyear->semester;

        if ('First Semester' == $semester) {
            //for first semester

            foreach ($fees as $row) {
                $sfee = trim($row->fee);

                if ('Undergraduate Degree Evening Fee' == $sfee || 'Undergraduate Degree Morning Fee' == $sfee || 'Undergraduate Degree Weekend Fee' == $sfee || 'Undergraduate Diploma Evening Fee' == $sfee || 'Undergraduate Diploma Morning Fee' == $sfee || 'Undergraduate Diploma Weekend Fee' == $sfee) {
                    $amount = $row->feeamount;
                    $paid = (int) $row->paid;
                    $left = (int) $row->owed;

                    $half = (int) ($amount / 2);

                    //check if semester is the same

                    //dd($row->semester);

                    if ($row->semester != $academicyear) {
                        // code...
                        return Redirect()->route('pay_mandatory_fees');
                    }

                    //dd('equal');

                    if ($paid < $half) {
                        return Redirect()->back()->with('error', 'Please Make sure, all financial obligations are met to proceed!');
                    }
                }
            }
        } else {
            //for second semester
            $feessum = Studentfee::where('indexnumber', auth()->user()->indexnumber)->sum('owed');

            if (1 > $feessum) {
            } else {
                return Redirect()->back()->with('error', 'Please Make sure, all financial obligations are met to proceed!');
            }
        }

        //echo $prog.$currentlevel.$semester.$academicyear;

        //get couses from Programmes and their course
        $Progcouse = Programmecourse::where('progcode', trim($code))
            ->where('level', $currentlevel)->where('semester', trim($semester))->get();

        //curent user
        $userid = auth()->user()->id;
        $indexnumber = auth()->user()->indexnumber;
        $countcourse = $Progcouse->count();
        $stuinfo = Studentinfo::where('user_id', $userid)->first();

        foreach ($Progcouse as $courses) {
            $code = $courses->coursecode;
            $codetittle = $courses->coursetitle;
            $credithours = $courses->credithours;

            $data = [
   'user_id'=> $userid,
   'indexnumber' => $indexnumber,
   'cource_code'=> $code,
   'level'=>$currentlevel,
   'cource_title'=> $codetittle,
   'credithours'=> $credithours,
   'semester'=> $semester,
   'session' => $stuinfo->session,
   'academic_year'=> $academicyear,
 ];

            $cousereg = new Coureregistration($data);
            $cousereg->save();
        }

        //add semester record into the database

        $regdata = [
  'user_id'=> $userid,
  'semester'=> $semester,
  'academicyear'=> $academicyear,
];

        $userreg = new Regacademicyear($regdata);
        $userreg->save();

        return Redirect()->back()->with('message', 'Couses Registered Successfully');
    }

    public function print_course_user($prog, $currentlevel, $semester, $academicyear)
    {
        $cousereg = Coureregistration::where('semester', $semester)
            ->where('academic_year', $academicyear)
            ->where('user_id', auth()->user()->id)
            ->orWhere('resit', '1')->get();

        $studentinfo = Studentinfo::where('user_id', auth()->user()->id)->first();
        //dd($cousereg);
        return view('CourseRegistration.prin_courses_reg', ['courses'=>$cousereg, 'academicyear' => $academicyear, 'semester'=>$semester, 'studentinfo'=>$studentinfo]);
    }

    public function results_display()
    {
        $user = auth()->user();
        $studentinfo = Studentinfo::where('user_id', $user->id)->first();

        // $cademicyear = Academicyear::where('status', 1)->first();
        // $academicyear = $cademicyear->acdemicyear;
        // $academicsem =  $cademicyear->semester;

        //dd($regs);

        $regsem = Regacademicyear::where('user_id', $user->id)->get();

        $creg = Coureregistration::where('user_id', $user->id)->get();

        $exresults = Examresults::where('user_id', $user->id)->get();

        //dd($exresults);

        //check if student results has been released
        $checkresult = Resultsrelease::first();

        return view('CourseRegistration.results_display', ['course'=> $creg, 'studentinfo'=>$studentinfo, 'regsem'=>$regsem, 'examsresults'=> $exresults, 'check' => $checkresult]);
    }
}
