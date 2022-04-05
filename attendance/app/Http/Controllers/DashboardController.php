<?php

namespace App\Http\Controllers;

use App\Academicyear;
use App\Course;
use App\Hall;
use App\LecCource;
use App\Payroll;
use App\Personalinfo;
use App\Programme;
use App\Staff;
use App\Staffleave;
use App\Studentinfo;
use App\User;
use FPDF as pdfs;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $fpdf;

    public function index()
    {

        // $this->fpdf = new pdfs();
        // $this->fpdf->SetFont('Times');
        //       $this->fpdf->AddPage("P");
        //       $this->fpdf->Text(10, 10, "Hello FPDF");

        // //do stuff
        // return response($this->fpdf->Output())
        //           ->header('Content-Type', 'application/pdf');

        $user = User::findorfail(auth()->user()->id);

        if ($user->hasRole('is_admin|is_superAdmin')) {
            $totalstaff = Staff::all()->count();

            $disablestaff = User::with('staff')
                ->where('indexnumber', 'not like', '%GES%')
                ->where('force_logout', '1')->get()->count();

            $totalstudents = Studentinfo::all()->count();

            $totallevel100students = Studentinfo::where('currentlevel', 'Level 100')->get()->count();

            $totallevel200students = Studentinfo::where('currentlevel', 'Level 200')->get()->count();

            $totallevel300students = Studentinfo::where('currentlevel', 'Level 300')->get()->count();

            $totallevel400students = Studentinfo::where('currentlevel', 'Level 400')->get()->count();

            $totalgraduatedstudents = Studentinfo::where('currentlevel', 'graduated')->get()->count();

            $academic = Academicyear::where('status', 1)->first();

            $totalonlineApplications = Personalinfo::where('year', $academic->acdemicyear)->get()->count();

            $totalonlinesubmitted = Personalinfo::where('year', $academic->acdemicyear)
                ->where('status', '1')->get()->count();

            $totalonlineapproved = Personalinfo::where('year', $academic->acdemicyear)
                ->where('status', '1')
                ->where('approve', '1')->get()->count();

            $totalprog = Programme::all()->count();

            $totaldegreeprog = Programme::where('type', 'Degree Programme')->get()->count();

            $totaldiplomaprog = Programme::where('type', 'Diploma Programme')->get()->count();

            $totalcourse = Course::all()->count();

            $totaldegreecourse = Course::where('program', 'Degree')->get()->count();

            $totaldiplomacourse = Course::where('program', 'Diploma')->get()->count();

            $onlineusers = User::where('is_active', '1')->get()->count();

            //$hall = Hall::all()->count();

            $curl = curl_init();

            curl_setopt_array($curl, [
                \CURLOPT_URL => 'https://apps.mnotify.net/smsapi/balance?key=H5gTSQ85AuKA6OqpMu242y66U',
                \CURLOPT_RETURNTRANSFER => true,
                \CURLOPT_ENCODING => '',
                \CURLOPT_MAXREDIRS => 10,
                \CURLOPT_TIMEOUT => 0,
                \CURLOPT_FOLLOWLOCATION => true,
                \CURLOPT_HTTP_VERSION => \CURL_HTTP_VERSION_1_1,
                \CURLOPT_CUSTOMREQUEST => 'GET',
            ]);

            $sms = curl_exec($curl);

            curl_close($curl);

            $online = User::where('is_active', '1')
                ->orderBy('id')->take(10)->get();

            $totaltoday = DB::table('transactions')
                ->whereDate('created_at', \Carbon\Carbon::today())
                ->get();

            $totalmonth = DB::table('transactions')
                ->whereMonth('created_at', date('m'))
                ->get();

            $totalyear = DB::table('transactions')
                ->whereYear('created_at', date('Y'))
                ->get();

            // $paylastmonth = Payroll::whereMonth('created_at', date('m')- 1)
            // ->get();

            // $paytoday = Payroll::whereMonth('created_at', \Carbon\Carbon::today())
            // ->get();

            // $paythismonth = Payroll::whereMonth('created_at', date('m'))
            // ->get();

            // $paythisyear = Payroll::whereYear('created_at', date('Y'))
            // ->get();

            $leave = Staffleave::all()->count();

            $leaveapp = Staffleave::where('status', 'Approved')->get()->count();

            $leavereg = Staffleave::where('status', 'Rejected')->get()->count();

            $leavethismonth = Staffleave::whereDate('created_at', \Carbon\Carbon::today())->get()->count();

            //dd($paylastmonth);

            return view('layouts.dashboard', [
                'taotalstaff' => $totalstaff,
                'totalstudents' => $totalstudents,
                'totallevel100students' => $totallevel100students,
                'totallevel200students' => $totallevel200students,
                'totallevel300students' => $totallevel300students,
                'totallevel400students' => $totallevel400students,
                'totalgraduatedstudents' => $totalgraduatedstudents,
                'totalonlineApplications' => $totalonlineApplications,
                'totalonlinesubmitted' => $totalonlinesubmitted,
                'totalonlineapproved' => $totalonlineapproved,
                'academcyear' => $academic->acdemicyear,
                'totalprog' => $totalprog,
                'totaldegreeprog' => $totaldegreeprog,
                'totaldiplomaprog' => $totaldiplomaprog,
                'totalcourse' => $totalcourse,
                'totaldegreecourse' => $totaldegreecourse,
                'totaldiplomacourse' => $totaldiplomacourse,
                'onlineusers' => $onlineusers,
                'sms' => $sms,
                'online' => $online,
                'leave' => $leave,
                'leaveapp' => $leaveapp,
                'leavereg' => $leavereg,
                'leavethismonth' => $leavethismonth,
                'disablestaff' => $disablestaff,
                '' => '',
                '' => '',
                '' => '',
                '' => '',
                '' => '',
                '' => '',

            ]);
        }
        if ($user->hasRole('Lecturer')) {
            $totalstaff = Staff::all()->count();

            $disablestaff = User::with('staff')
                ->where('indexnumber', 'not like', '%GES%')
                ->where('force_logout', '1')->get()->count();

            $totalstudents = Studentinfo::all()->count();

            $totallevel100students = Studentinfo::where('currentlevel', 'Level 100')->get()->count();

            $totallevel200students = Studentinfo::where('currentlevel', 'Level 200')->get()->count();

            $totallevel300students = Studentinfo::where('currentlevel', 'Level 300')->get()->count();

            $totallevel400students = Studentinfo::where('currentlevel', 'Level 400')->get()->count();

            $totalgraduatedstudents = Studentinfo::where('currentlevel', 'graduated')->get()->count();

            $academic = Academicyear::where('status', 1)->first();

            $totalonlineApplications = Personalinfo::where('year', $academic->acdemicyear)->get()->count();

            $totalonlinesubmitted = Personalinfo::where('year', $academic->acdemicyear)
                ->where('status', '1')->get()->count();

            $totalonlineapproved = Personalinfo::where('year', $academic->acdemicyear)
                ->where('status', '1')
                ->where('approve', '1')->get()->count();

            $totalprog = Programme::all()->count();

            $totaldegreeprog = Programme::where('type', 'Degree Programme')->get()->count();

            $totaldiplomaprog = Programme::where('type', 'Diploma Programme')->get()->count();

            $totalcourse = LecCource::where('lecturer_id', auth()->user()->id)->get()->count();

            $totaldegreecourse = Course::where('program', 'Degree')->get()->count();

            $totaldiplomacourse = Course::where('program', 'Diploma')->get()->count();

            $onlineusers = User::where('is_active', '1')->get()->count();

            //$hall = Hall::all()->count();

            $curl = curl_init();

            curl_setopt_array($curl, [
                \CURLOPT_URL => 'https://apps.mnotify.net/smsapi/balance?key=H5gTSQ85AuKA6OqpMu242y66U',
                \CURLOPT_RETURNTRANSFER => true,
                \CURLOPT_ENCODING => '',
                \CURLOPT_MAXREDIRS => 10,
                \CURLOPT_TIMEOUT => 0,
                \CURLOPT_FOLLOWLOCATION => true,
                \CURLOPT_HTTP_VERSION => \CURL_HTTP_VERSION_1_1,
                \CURLOPT_CUSTOMREQUEST => 'GET',
            ]);

            $sms = curl_exec($curl);

            curl_close($curl);

            $online = User::where('is_active', '1')
                ->orderBy('id')->take(10)->get();

            $totaltoday = DB::table('transactions')
                ->whereDate('created_at', \Carbon\Carbon::today())
                ->get();

            $totalmonth = DB::table('transactions')
                ->whereMonth('created_at', date('m'))
                ->get();

            $totalyear = DB::table('transactions')
                ->whereYear('created_at', date('Y'))
                ->get();

            // $paylastmonth = Payroll::whereMonth('created_at', date('m')- 1)
            // ->where('user_id', auth()->user()->id)
            // ->get();

            // $paytoday = Payroll::
            // where('user_id', auth()->user()->id)->whereMonth('created_at', \Carbon\Carbon::today())
            // ->get();

            // $paythismonth = Payroll::
            // where('user_id', auth()->user()->id)->whereMonth('created_at', date('m'))
            // ->get();

            // $paythisyear = Payroll::
            // where('user_id', auth()->user()->id)->whereYear('created_at', date('Y'))
            // ->get();

            $leave = Staffleave::where('user_id', auth()->user()->id)->get()->count();

            //dd($leave);

            $leaveapp = Staffleave::where('user_id', auth()->user()->id)->where('status', 'Approved')->get()->count();

            $leavereg = Staffleave::where('user_id', auth()->user()->id)->where('status', 'Rejected')->get()->count();

            $leavethismonth = Staffleave::where('user_id', auth()->user()->id)->whereDate('created_at', \Carbon\Carbon::today())->get()->count();

            //dd($paylastmonth);

            return view('layouts.lecdashboard', [
                'taotalstaff' => $totalstaff,
                'totalstudents' => $totalstudents,
                'totallevel100students' => $totallevel100students,
                'totallevel200students' => $totallevel200students,
                'totallevel300students' => $totallevel300students,
                'totallevel400students' => $totallevel400students,
                'totalgraduatedstudents' => $totalgraduatedstudents,
                'totalonlineApplications' => $totalonlineApplications,
                'totalonlinesubmitted' => $totalonlinesubmitted,
                'totalonlineapproved' => $totalonlineapproved,
                'academcyear' => $academic->acdemicyear,
                'totalprog' => $totalprog,
                'totaldegreeprog' => $totaldegreeprog,
                'totaldiplomaprog' => $totaldiplomaprog,
                'totalcourse' => $totalcourse,
                'totaldegreecourse' => $totaldegreecourse,
                'totaldiplomacourse' => $totaldiplomacourse,
                'onlineusers' => $onlineusers,
                'sms' => $sms,
                'online' => $online,
                'leave' => $leave,
                'leaveapp' => $leaveapp,
                'leavereg' => $leavereg,
                'leavethismonth' => $leavethismonth,
                'disablestaff' => $disablestaff,
                '' => '',
                '' => '',
                '' => '',
                '' => '',
                '' => '',
                '' => '',

            ]);
        }
        if ($user->hasRole('Front_desk_help')) {
            $totalstaff = Staff::all()->count();

            $disablestaff = User::with('staff')
                ->where('indexnumber', 'not like', '%GES%')
                ->where('force_logout', '1')->get()->count();

            $totalstudents = Studentinfo::all()->count();

            $totallevel100students = Studentinfo::where('currentlevel', 'Level 100')->get()->count();

            $totallevel200students = Studentinfo::where('currentlevel', 'Level 200')->get()->count();

            $totallevel300students = Studentinfo::where('currentlevel', 'Level 300')->get()->count();

            $totallevel400students = Studentinfo::where('currentlevel', 'Level 400')->get()->count();

            $totalgraduatedstudents = Studentinfo::where('currentlevel', 'graduated')->get()->count();

            $academic = Academicyear::where('status', 1)->first();

            $totalonlineApplications = Personalinfo::where('year', $academic->acdemicyear)->get()->count();

            $totalonlinesubmitted = Personalinfo::where('year', $academic->acdemicyear)
                ->where('status', '1')->get()->count();

            $totalonlineapproved = Personalinfo::where('year', $academic->acdemicyear)
                ->where('status', '1')
                ->where('approve', '1')->get()->count();

            $totalprog = Programme::all()->count();

            $totaldegreeprog = Programme::where('type', 'Degree Programme')->get()->count();

            $totaldiplomaprog = Programme::where('type', 'Diploma Programme')->get()->count();

            $totalcourse = Course::all()->count();

            $totaldegreecourse = Course::where('program', 'Degree')->get()->count();

            $totaldiplomacourse = Course::where('program', 'Diploma')->get()->count();

            $onlineusers = User::where('is_active', '1')->get()->count();

            //$hall = Hall::all()->count();

            $curl = curl_init();

            curl_setopt_array($curl, [
                \CURLOPT_URL => 'https://apps.mnotify.net/smsapi/balance?key=H5gTSQ85AuKA6OqpMu242y66U',
                \CURLOPT_RETURNTRANSFER => true,
                \CURLOPT_ENCODING => '',
                \CURLOPT_MAXREDIRS => 10,
                \CURLOPT_TIMEOUT => 0,
                \CURLOPT_FOLLOWLOCATION => true,
                \CURLOPT_HTTP_VERSION => \CURL_HTTP_VERSION_1_1,
                \CURLOPT_CUSTOMREQUEST => 'GET',
            ]);

            $sms = curl_exec($curl);

            curl_close($curl);

            $online = User::where('is_active', '1')
                ->orderBy('id')->take(10)->get();

            $totaltoday = DB::table('transactions')
                ->whereDate('created_at', \Carbon\Carbon::today())
                ->get();

            $totalmonth = DB::table('transactions')
                ->whereMonth('created_at', date('m'))
                ->get();

            $totalyear = DB::table('transactions')
                ->whereYear('created_at', date('Y'))
                ->get();

            // $paylastmonth = Payroll::where('user_id',auth()->user()->id)->whereMonth('created_at', date('m')- 1)
            // ->get();

            // $paytoday = Payroll::whereMonth('created_at', \Carbon\Carbon::today())
            // ->get();

            // $paythismonth = Payroll::where('user_id',auth()->user()->id)->whereMonth('created_at', date('m'))
            // ->get();

            // $paythisyear = Payroll::where('user_id',auth()->user()->id)->whereYear('created_at', date('Y'))
            // ->get();

            $leave = Staffleave::where('user_id', auth()->user()->id)->get()->count();

            //dd($leave);

            $leaveapp = Staffleave::where('user_id', auth()->user()->id)->where('status', 'Approved')->get()->count();

            $leavereg = Staffleave::where('user_id', auth()->user()->id)->where('status', 'Rejected')->get()->count();

            $leavethismonth = Staffleave::where('user_id', auth()->user()->id)->whereDate('created_at', \Carbon\Carbon::today())->get()->count();

            //dd($paylastmonth);

            return view('layouts.frontdesk_dashboard', [
                'taotalstaff' => $totalstaff,
                'totalstudents' => $totalstudents,
                'totallevel100students' => $totallevel100students,
                'totallevel200students' => $totallevel200students,
                'totallevel300students' => $totallevel300students,
                'totallevel400students' => $totallevel400students,
                'totalgraduatedstudents' => $totalgraduatedstudents,
                'totalonlineApplications' => $totalonlineApplications,
                'totalonlinesubmitted' => $totalonlinesubmitted,
                'totalonlineapproved' => $totalonlineapproved,
                'academcyear' => $academic->acdemicyear,
                'totalprog' => $totalprog,
                'totaldegreeprog' => $totaldegreeprog,
                'totaldiplomaprog' => $totaldiplomaprog,
                'totalcourse' => $totalcourse,
                'totaldegreecourse' => $totaldegreecourse,
                'totaldiplomacourse' => $totaldiplomacourse,
                'onlineusers' => $onlineusers,
                'sms' => $sms,
                'online' => $online,

                'leave' => $leave,
                'leaveapp' => $leaveapp,
                'leavereg' => $leavereg,
                'leavethismonth' => $leavethismonth,
                'disablestaff' => $disablestaff,
                '' => '',
                '' => '',
                '' => '',
                '' => '',
                '' => '',
                '' => '',

            ]);
        }
        if ($user->hasRole('Admission committee')) {
            $totalstaff = Staff::all()->count();

            $disablestaff = User::with('staff')
                ->where('indexnumber', 'not like', '%GES%')
                ->where('force_logout', '1')->get()->count();

            $totalstudents = Studentinfo::all()->count();

            $totallevel100students = Studentinfo::where('currentlevel', 'Level 100')->get()->count();

            $totallevel200students = Studentinfo::where('currentlevel', 'Level 200')->get()->count();

            $totallevel300students = Studentinfo::where('currentlevel', 'Level 300')->get()->count();

            $totallevel400students = Studentinfo::where('currentlevel', 'Level 400')->get()->count();

            $totalgraduatedstudents = Studentinfo::where('currentlevel', 'graduated')->get()->count();

            $academic = Academicyear::where('status', 1)->first();

            $totalonlineApplications = Personalinfo::where('year', $academic->acdemicyear)->get()->count();

            $totalonlinesubmitted = Personalinfo::where('year', $academic->acdemicyear)
                ->where('status', '1')->get()->count();

            $totalonlineapproved = Personalinfo::where('year', $academic->acdemicyear)
                ->where('status', '1')
                ->where('approve', '1')->get()->count();

            $totalprog = Programme::all()->count();

            $totaldegreeprog = Programme::where('type', 'Degree Programme')->get()->count();

            $totaldiplomaprog = Programme::where('type', 'Diploma Programme')->get()->count();

            $totalcourse = Course::all()->count();

            $totaldegreecourse = Course::where('program', 'Degree')->get()->count();

            $totaldiplomacourse = Course::where('program', 'Diploma')->get()->count();

            $onlineusers = User::where('is_active', '1')->get()->count();

            //$hall = Hall::all()->count();

            $curl = curl_init();

            curl_setopt_array($curl, [
                \CURLOPT_URL => 'https://apps.mnotify.net/smsapi/balance?key=H5gTSQ85AuKA6OqpMu242y66U',
                \CURLOPT_RETURNTRANSFER => true,
                \CURLOPT_ENCODING => '',
                \CURLOPT_MAXREDIRS => 10,
                \CURLOPT_TIMEOUT => 0,
                \CURLOPT_FOLLOWLOCATION => true,
                \CURLOPT_HTTP_VERSION => \CURL_HTTP_VERSION_1_1,
                \CURLOPT_CUSTOMREQUEST => 'GET',
            ]);

            $sms = curl_exec($curl);

            curl_close($curl);

            $online = User::where('is_active', '1')
                ->orderBy('id')->take(10)->get();

            $totaltoday = DB::table('transactions')
                ->whereDate('created_at', \Carbon\Carbon::today())
                ->get();

            $totalmonth = DB::table('transactions')
                ->whereMonth('created_at', date('m'))
                ->get();

            $totalyear = DB::table('transactions')
                ->whereYear('created_at', date('Y'))
                ->get();

            // $paylastmonth = Payroll::where('user_id',auth()->user()->id)->whereMonth('created_at', date('m')- 1)
            // ->get();

            // $paytoday = Payroll::whereMonth('created_at', \Carbon\Carbon::today())
            // ->get();

            // $paythismonth = Payroll::where('user_id',auth()->user()->id)->whereMonth('created_at', date('m'))
            // ->get();

            // $paythisyear = Payroll::where('user_id',auth()->user()->id)->whereYear('created_at', date('Y'))
            // ->get();

            $leave = Staffleave::where('user_id', auth()->user()->id)->get()->count();

            //dd($leave);

            $leaveapp = Staffleave::where('user_id', auth()->user()->id)->where('status', 'Approved')->get()->count();

            $leavereg = Staffleave::where('user_id', auth()->user()->id)->where('status', 'Rejected')->get()->count();

            $leavethismonth = Staffleave::where('user_id', auth()->user()->id)->whereDate('created_at', \Carbon\Carbon::today())->get()->count();

            //dd($paylastmonth);

            return view('layouts.admissiondashboard', [
                'taotalstaff' => $totalstaff,
                'totalstudents' => $totalstudents,
                'totallevel100students' => $totallevel100students,
                'totallevel200students' => $totallevel200students,
                'totallevel300students' => $totallevel300students,
                'totallevel400students' => $totallevel400students,
                'totalgraduatedstudents' => $totalgraduatedstudents,
                'totalonlineApplications' => $totalonlineApplications,
                'totalonlinesubmitted' => $totalonlinesubmitted,
                'totalonlineapproved' => $totalonlineapproved,
                'academcyear' => $academic->acdemicyear,
                'totalprog' => $totalprog,
                'totaldegreeprog' => $totaldegreeprog,
                'totaldiplomaprog' => $totaldiplomaprog,
                'totalcourse' => $totalcourse,
                'totaldegreecourse' => $totaldegreecourse,
                'totaldiplomacourse' => $totaldiplomacourse,
                'onlineusers' => $onlineusers,
                'sms' => $sms,
                'online' => $online,

                'leave' => $leave,
                'leaveapp' => $leaveapp,
                'leavereg' => $leavereg,
                'leavethismonth' => $leavethismonth,
                'disablestaff' => $disablestaff,
                '' => '',
                '' => '',
                '' => '',
                '' => '',
                '' => '',
                '' => '',

            ]);
        }
        if ($user->hasRole('Academic Committee')) {
            $totalstaff = Staff::all()->count();

            $disablestaff = User::with('staff')
                ->where('indexnumber', 'not like', '%GES%')
                ->where('force_logout', '1')->get()->count();

            $totalstudents = Studentinfo::all()->count();

            $totallevel100students = Studentinfo::where('currentlevel', 'Level 100')->get()->count();

            $totallevel200students = Studentinfo::where('currentlevel', 'Level 200')->get()->count();

            $totallevel300students = Studentinfo::where('currentlevel', 'Level 300')->get()->count();

            $totallevel400students = Studentinfo::where('currentlevel', 'Level 400')->get()->count();

            $totalgraduatedstudents = Studentinfo::where('currentlevel', 'graduated')->get()->count();

            $academic = Academicyear::where('status', 1)->first();

            $totalonlineApplications = Personalinfo::where('year', $academic->acdemicyear)->get()->count();

            $totalonlinesubmitted = Personalinfo::where('year', $academic->acdemicyear)
                ->where('status', '1')->get()->count();

            $totalonlineapproved = Personalinfo::where('year', $academic->acdemicyear)
                ->where('status', '1')
                ->where('approve', '1')->get()->count();

            $totalprog = Programme::all()->count();

            $totaldegreeprog = Programme::where('type', 'Degree Programme')->get()->count();

            $totaldiplomaprog = Programme::where('type', 'Diploma Programme')->get()->count();

            $totalcourse = Course::all()->count();

            $totaldegreecourse = Course::where('program', 'Degree')->get()->count();

            $totaldiplomacourse = Course::where('program', 'Diploma')->get()->count();

            $onlineusers = User::where('is_active', '1')->get()->count();

            //$hall = Hall::all()->count();

            $curl = curl_init();

            curl_setopt_array($curl, [
                \CURLOPT_URL => 'https://apps.mnotify.net/smsapi/balance?key=H5gTSQ85AuKA6OqpMu242y66U',
                \CURLOPT_RETURNTRANSFER => true,
                \CURLOPT_ENCODING => '',
                \CURLOPT_MAXREDIRS => 10,
                \CURLOPT_TIMEOUT => 0,
                \CURLOPT_FOLLOWLOCATION => true,
                \CURLOPT_HTTP_VERSION => \CURL_HTTP_VERSION_1_1,
                \CURLOPT_CUSTOMREQUEST => 'GET',
            ]);

            $sms = curl_exec($curl);

            curl_close($curl);

            $online = User::where('is_active', '1')
                ->orderBy('id')->take(10)->get();

            $totaltoday = DB::table('transactions')
                ->whereDate('created_at', \Carbon\Carbon::today())
                ->get();

            $totalmonth = DB::table('transactions')
                ->whereMonth('created_at', date('m'))
                ->get();

            $totalyear = DB::table('transactions')
                ->whereYear('created_at', date('Y'))
                ->get();

            // $paylastmonth = Payroll::where('user_id',auth()->user()->id)->whereMonth('created_at', date('m')- 1)
            // ->get();

            // $paytoday = Payroll::whereMonth('created_at', \Carbon\Carbon::today())
            // ->get();

            // $paythismonth = Payroll::where('user_id',auth()->user()->id)->whereMonth('created_at', date('m'))
            // ->get();

            // $paythisyear = Payroll::where('user_id',auth()->user()->id)->whereYear('created_at', date('Y'))
            // ->get();

            $leave = Staffleave::where('user_id', auth()->user()->id)->get()->count();

            //dd($leave);

            $leaveapp = Staffleave::where('user_id', auth()->user()->id)->where('status', 'Approved')->get()->count();

            $leavereg = Staffleave::where('user_id', auth()->user()->id)->where('status', 'Rejected')->get()->count();

            $leavethismonth = Staffleave::where('user_id', auth()->user()->id)->whereDate('created_at', \Carbon\Carbon::today())->get()->count();

            //dd($paylastmonth);

            return view('layouts.admissiondashboard', [
                'taotalstaff' => $totalstaff,
                'totalstudents' => $totalstudents,
                'totallevel100students' => $totallevel100students,
                'totallevel200students' => $totallevel200students,
                'totallevel300students' => $totallevel300students,
                'totallevel400students' => $totallevel400students,
                'totalgraduatedstudents' => $totalgraduatedstudents,
                'totalonlineApplications' => $totalonlineApplications,
                'totalonlinesubmitted' => $totalonlinesubmitted,
                'totalonlineapproved' => $totalonlineapproved,
                'academcyear' => $academic->acdemicyear,
                'totalprog' => $totalprog,
                'totaldegreeprog' => $totaldegreeprog,
                'totaldiplomaprog' => $totaldiplomaprog,
                'totalcourse' => $totalcourse,
                'totaldegreecourse' => $totaldegreecourse,
                'totaldiplomacourse' => $totaldiplomacourse,
                'onlineusers' => $onlineusers,
                'sms' => $sms,
                'online' => $online,

                'leave' => $leave,
                'leaveapp' => $leaveapp,
                'leavereg' => $leavereg,
                'leavethismonth' => $leavethismonth,
                'disablestaff' => $disablestaff,
                '' => '',
                '' => '',
                '' => '',
                '' => '',
                '' => '',
                '' => '',

            ]);
        }
        if ($user->hasRole('Accounts')) {
            $totalstaff = Staff::all()->count();

            $disablestaff = User::with('staff')
                ->where('indexnumber', 'not like', '%GES%')
                ->where('force_logout', '1')->get()->count();

            $totalstudents = Studentinfo::all()->count();

            $totallevel100students = Studentinfo::where('currentlevel', 'Level 100')->get()->count();

            $totallevel200students = Studentinfo::where('currentlevel', 'Level 200')->get()->count();

            $totallevel300students = Studentinfo::where('currentlevel', 'Level 300')->get()->count();

            $totallevel400students = Studentinfo::where('currentlevel', 'Level 400')->get()->count();

            $totalgraduatedstudents = Studentinfo::where('currentlevel', 'graduated')->get()->count();

            $academic = Academicyear::where('status', 1)->first();

            $totalonlineApplications = Personalinfo::where('year', $academic->acdemicyear)->get()->count();

            $totalonlinesubmitted = Personalinfo::where('year', $academic->acdemicyear)
                ->where('status', '1')->get()->count();

            $totalonlineapproved = Personalinfo::where('year', $academic->acdemicyear)
                ->where('status', '1')
                ->where('approve', '1')->get()->count();

            $totalprog = Programme::all()->count();

            $totaldegreeprog = Programme::where('type', 'Degree Programme')->get()->count();

            $totaldiplomaprog = Programme::where('type', 'Diploma Programme')->get()->count();

            $totalcourse = LecCource::where('lecturer_id', auth()->user()->id)->get()->count();

            $totaldegreecourse = Course::where('program', 'Degree')->get()->count();

            $totaldiplomacourse = Course::where('program', 'Diploma')->get()->count();

            $onlineusers = User::where('is_active', '1')->get()->count();

            //$hall = Hall::all()->count();

            $curl = curl_init();

            curl_setopt_array($curl, [
                \CURLOPT_URL => 'https://apps.mnotify.net/smsapi/balance?key=H5gTSQ85AuKA6OqpMu242y66U',
                \CURLOPT_RETURNTRANSFER => true,
                \CURLOPT_ENCODING => '',
                \CURLOPT_MAXREDIRS => 10,
                \CURLOPT_TIMEOUT => 0,
                \CURLOPT_FOLLOWLOCATION => true,
                \CURLOPT_HTTP_VERSION => \CURL_HTTP_VERSION_1_1,
                \CURLOPT_CUSTOMREQUEST => 'GET',
            ]);

            $sms = curl_exec($curl);

            curl_close($curl);

            $online = User::where('is_active', '1')
                ->orderBy('id')->take(10)->get();

            $totaltoday = DB::table('transactions')
                ->whereDate('created_at', \Carbon\Carbon::today())
                ->get();

            $totalmonth = DB::table('transactions')
                ->whereMonth('created_at', date('m'))
                ->get();

            $totalyear = DB::table('transactions')
                ->whereYear('created_at', date('Y'))
                ->get();

            // $paylastmonth = Payroll::whereMonth('created_at', date('m')- 1)
            // ->get();

            // $paytoday = Payroll::whereMonth('created_at', \Carbon\Carbon::today())
            // ->get();

            // $paythismonth = Payroll::whereMonth('created_at', date('m'))
            // ->get();

            // $paythisyear = Payroll::whereYear('created_at', date('Y'))
            // ->get();

            $leave = Staffleave::where('user_id', auth()->user()->id)->get()->count();

            //dd($leave);

            $leaveapp = Staffleave::where('user_id', auth()->user()->id)->where('status', 'Approved')->get()->count();

            $leavereg = Staffleave::where('user_id', auth()->user()->id)->where('status', 'Rejected')->get()->count();

            $leavethismonth = Staffleave::where('user_id', auth()->user()->id)->whereDate('created_at', \Carbon\Carbon::today())->get()->count();

            //dd($paylastmonth);

            return view('layouts.accdashboard', [
                'taotalstaff' => $totalstaff,
                'totalstudents' => $totalstudents,
                'totallevel100students' => $totallevel100students,
                'totallevel200students' => $totallevel200students,
                'totallevel300students' => $totallevel300students,
                'totallevel400students' => $totallevel400students,
                'totalgraduatedstudents' => $totalgraduatedstudents,
                'totalonlineApplications' => $totalonlineApplications,
                'totalonlinesubmitted' => $totalonlinesubmitted,
                'totalonlineapproved' => $totalonlineapproved,
                'academcyear' => $academic->acdemicyear,
                'totalprog' => $totalprog,
                'totaldegreeprog' => $totaldegreeprog,
                'totaldiplomaprog' => $totaldiplomaprog,
                'totalcourse' => $totalcourse,
                'totaldegreecourse' => $totaldegreecourse,
                'totaldiplomacourse' => $totaldiplomacourse,
                'onlineusers' => $onlineusers,
                'sms' => $sms,
                'online' => $online,

                'leave' => $leave,
                'leaveapp' => $leaveapp,
                'leavereg' => $leavereg,
                'leavethismonth' => $leavethismonth,
                'disablestaff' => $disablestaff,
                '' => '',
                '' => '',
                '' => '',
                '' => '',
                '' => '',
                '' => '',

            ]);
        }
        if ($user->hasRole('Human Resource')) {
            $totalstaff = Staff::all()->count();

            $disablestaff = User::with('staff')
                ->where('indexnumber', 'not like', '%GES%')
                ->where('force_logout', '1')->get()->count();

            $totalstudents = Studentinfo::all()->count();

            $totallevel100students = Studentinfo::where('currentlevel', 'Level 100')->get()->count();

            $totallevel200students = Studentinfo::where('currentlevel', 'Level 200')->get()->count();

            $totallevel300students = Studentinfo::where('currentlevel', 'Level 300')->get()->count();

            $totallevel400students = Studentinfo::where('currentlevel', 'Level 400')->get()->count();

            $totalgraduatedstudents = Studentinfo::where('currentlevel', 'graduated')->get()->count();

            $academic = Academicyear::where('status', 1)->first();

            $totalonlineApplications = Personalinfo::where('year', $academic->acdemicyear)->get()->count();

            $totalonlinesubmitted = Personalinfo::where('year', $academic->acdemicyear)
                ->where('status', '1')->get()->count();

            $totalonlineapproved = Personalinfo::where('year', $academic->acdemicyear)
                ->where('status', '1')
                ->where('approve', '1')->get()->count();

            $totalprog = Programme::all()->count();

            $totaldegreeprog = Programme::where('type', 'Degree Programme')->get()->count();

            $totaldiplomaprog = Programme::where('type', 'Diploma Programme')->get()->count();

            $totalcourse = LecCource::where('lecturer_id', auth()->user()->id)->get()->count();

            $totaldegreecourse = Course::where('program', 'Degree')->get()->count();

            $totaldiplomacourse = Course::where('program', 'Diploma')->get()->count();

            $onlineusers = User::where('is_active', '1')->get()->count();

            //$hall = Hall::all()->count();

            $curl = curl_init();

            curl_setopt_array($curl, [
                \CURLOPT_URL => 'https://apps.mnotify.net/smsapi/balance?key=H5gTSQ85AuKA6OqpMu242y66U',
                \CURLOPT_RETURNTRANSFER => true,
                \CURLOPT_ENCODING => '',
                \CURLOPT_MAXREDIRS => 10,
                \CURLOPT_TIMEOUT => 0,
                \CURLOPT_FOLLOWLOCATION => true,
                \CURLOPT_HTTP_VERSION => \CURL_HTTP_VERSION_1_1,
                \CURLOPT_CUSTOMREQUEST => 'GET',
            ]);

            $sms = curl_exec($curl);

            curl_close($curl);

            $online = User::where('is_active', '1')
                ->orderBy('id')->take(10)->get();

            $totaltoday = DB::table('transactions')
                ->whereDate('created_at', \Carbon\Carbon::today())
                ->get();

            $totalmonth = DB::table('transactions')
                ->whereMonth('created_at', date('m'))
                ->get();

            $totalyear = DB::table('transactions')
                ->whereYear('created_at', date('Y'))
                ->get();

            // $paylastmonth = Payroll::whereMonth('created_at', date('m')- 1)
            // ->get();

            // $paytoday = Payroll::whereMonth('created_at', \Carbon\Carbon::today())
            // ->get();

            // $paythismonth = Payroll::whereMonth('created_at', date('m'))
            // ->get();

            // $paythisyear = Payroll::whereYear('created_at', date('Y'))
            // ->get();

            $leave = Staffleave::where('user_id', auth()->user()->id)->get()->count();

            //dd($leave);

            $leaveapp = Staffleave::where('user_id', auth()->user()->id)->where('status', 'Approved')->get()->count();

            $leavereg = Staffleave::where('user_id', auth()->user()->id)->where('status', 'Rejected')->get()->count();

            $leavethismonth = Staffleave::where('user_id', auth()->user()->id)->whereDate('created_at', \Carbon\Carbon::today())->get()->count();

            //dd($paylastmonth);

            return view('layouts.accdashboard', [
                'taotalstaff' => $totalstaff,
                'totalstudents' => $totalstudents,
                'totallevel100students' => $totallevel100students,
                'totallevel200students' => $totallevel200students,
                'totallevel300students' => $totallevel300students,
                'totallevel400students' => $totallevel400students,
                'totalgraduatedstudents' => $totalgraduatedstudents,
                'totalonlineApplications' => $totalonlineApplications,
                'totalonlinesubmitted' => $totalonlinesubmitted,
                'totalonlineapproved' => $totalonlineapproved,
                'academcyear' => $academic->acdemicyear,
                'totalprog' => $totalprog,
                'totaldegreeprog' => $totaldegreeprog,
                'totaldiplomaprog' => $totaldiplomaprog,
                'totalcourse' => $totalcourse,
                'totaldegreecourse' => $totaldegreecourse,
                'totaldiplomacourse' => $totaldiplomacourse,
                'onlineusers' => $onlineusers,
                'sms' => $sms,
                'online' => $online,

                'leave' => $leave,
                'leaveapp' => $leaveapp,
                'leavereg' => $leavereg,
                'leavethismonth' => $leavethismonth,
                'disablestaff' => $disablestaff,
                '' => '',
                '' => '',
                '' => '',
                '' => '',
                '' => '',
                '' => '',

            ]);
        }
        if ($user->hasRole('Student')) {
            return Redirect()->route('students-profile-info-view');
        }

        return view('layouts.dashboard');
    }
}
