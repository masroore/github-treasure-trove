<?php

namespace App\Http\Controllers;

use App\Academicyear;
use App\Jobs\Communication\Quicksms;
use App\Jobs\Communication\Sendmailadmittedstudentsjob;
use App\Jobs\Communication\Sendmailindividualjob;
use App\Jobs\Communication\Sendmaillecturersjob;
use App\Jobs\Communication\SendmailSessionjob;
use App\Jobs\Communication\Sendmailstudentsjob;
use App\Jobs\Communication\Sendsmsadmittedstudentsjob;
use App\Jobs\Communication\Sendsmsindividualjob;
use App\Jobs\Communication\Sendsmslecturersjob;
use App\Jobs\Communication\SendsmsSessionjob;
use App\Jobs\Communication\Sendsmsstudentsjob;
use App\Lecturer;
use App\Notifications\Communicate\Sendmail;
use App\Personalinfo;
use App\Programme;
use App\Studentinfo;
use Illuminate\Http\Request;
use Response;

class CommunicateController extends Controller
{
    public function send_mail()
    {
        $program = Programme::all();

        return view('Communicate.send_mail', ['program' => $program]);
    }

    public function send_mail_now(Request $request)
    {
        $compose = $request->post('compose');
        $html = $request->post('html');
        $sendto = $request->post('sendto');
        $file = $request->input('pdffile');

        if ($request->has('pdffile')) {
            $uploadfile = $request->file('pdffile')->store('MailFile', 'public');

            $fullpath = asset('storage') . '/' . $uploadfile;
        } else {
            $fullpath = 'false';
        }

        $eperemail = $request->post('eperemail');

        if ('2' == $sendto) {
            $level = $request->post('level');
            $session = $request->post('session');
            $program = $request->post('program');

            $students = Studentinfo::where('currentlevel', $level)
                ->where('session', $session)
                ->where('programme', $program)
                ->get();

            $this->dispatch(new SendmailSessionjob($students, $compose, $html, $fullpath));

            //$this->dispatch(new Sendmail($students,$compose,$html));

            return Response::json([
                'success' => true,
                'message' => 'Mail Submitted Successfully!',

            ], 200);
        }

        if ('5' == $sendto) {
            $eperemail = $request->post('eperemail');
            $this->dispatch(new Sendmailindividualjob($eperemail, $compose, $html, $fullpath));

            return Response::json([
                'success' => true,
                'message' => 'Mail Submitted Successfully!',

            ], 200);
        }

        if ('0' == $sendto) {
            // send Mail to all students
            $students = Studentinfo::where('currentlevel', '!=', 'Graduated')
                ->where('currentlevel', '!=', 'Graduating')->get();

            $this->dispatch(new Sendmailstudentsjob($students, $compose, $html, $fullpath));

            return Response::json([
                'success' => true,
                'message' => 'Mail Submitted Successfully!',

            ], 200);
        }

        if ('1' == $sendto) {
            // send Mail to all Admiited Students
            $academic = Academicyear::where('status', 1)->first();
            $approve = Personalinfo::where('academicyear', $academic->year)
                ->where('approve', '1')->get();

            $this->dispatch(new Sendmailadmittedstudentsjob($approve, $compose, $html, $fullpath));

            return Response::json([
                'success' => true,
                'message' => 'Mail Submitted Successfully!',

            ], 200);
        }

        if ('3' == $sendto) {
            // send Mail to all Lecturers
            $lecturer = Lecturer::all();

            $this->dispatch(new Sendmaillecturersjob($lecturer, $compose, $html, $fullpath));

            return Response::json([
                'success' => true,
                'message' => 'Mail Submitted Successfully!',

            ], 200);
        }

        if ($request->has('quicksendto')) {
            if ('false' == $fullpath) {
                $this->dispatch(new Quicksms(
                    $request->post('quicksendto'),
                    $compose,
                    $html,
                    $fullpath,
                    auth()->user()->email
                ));
            } else {
                $this->dispatch(new Quicksms(
                    $request->post('quicksendto'),
                    $compose,
                    $html,
                    $fullpath,
                    auth()->user()->email
                ));
            }

            return Response::json([
                'success' => true,
                'message' => 'Mail Submitted Successfully!',

            ], 200);
        }
    }

    public function send_sms()
    {
        $program = Programme::all();

        return view('Communicate.send_sms', ['program' => $program]);
    }

    public function send_sms_now(Request $request)
    {
        $html = $request->post('html');
        $sendto = $request->post('sendto');
        $file = $request->input('pdffile');

        if ($request->has('pdffile')) {
            $uploadfile = $request->file('pdffile')->store('MailFile', 'public');

            $fullpath = asset('storage') . '/' . $uploadfile;
        } else {
            $fullpath = 'false';
        }

        $eperemail = $request->post('eperemail');

        if ('2' == $sendto) {
            $level = $request->post('level');
            $session = $request->post('session');
            $program = $request->post('program');

            $students = Studentinfo::where('currentlevel', $level)
                ->where('session', $session)
                ->where('programme', $program)
                ->get();

            $this->dispatch(new SendsmsSessionjob($students, $html, $fullpath));

            //$this->dispatch(new Sendmail($students,$compose,$html));

            return Response::json([
                'success' => true,
                'message' => 'Sms Sent Successfully!',

            ], 200);
        }

        if ('5' == $sendto) {
            $eperemail = $request->post('phonenumber');

            $this->dispatch(new Sendsmsindividualjob($eperemail, $html, $fullpath));

            return Response::json([
                'success' => true,
                'message' => 'Sms Sent Successfully!',

            ], 200);
        }

        if ('0' == $sendto) {
            // send Mail to all students
            $students = Studentinfo::where('currentlevel', '!=', 'Graduated')
                ->where('currentlevel', '!=', 'Graduating')->get();

            $this->dispatch(new Sendsmsstudentsjob($students, $html, $fullpath));

            return Response::json([
                'success' => true,
                'message' => 'Sms Sent Successfully!',

            ], 200);
        }

        if ('1' == $sendto) {
            // send Mail to all Admiited Students
            $academic = Academicyear::where('status', 1)->first();
            $approve = Personalinfo::where('academicyear', $academic->year)
                ->where('approve', '1')->get();

            $this->dispatch(new Sendsmsadmittedstudentsjob($approve, $html, $fullpath));

            return Response::json([
                'success' => true,
                'message' => 'Sms Sent Successfully!',

            ], 200);
        }

        if ('3' == $sendto) {
            // send Mail to all Lecturers
            $lecturer = Lecturer::all();

            $this->dispatch(new Sendsmslecturersjob($lecturer, $html, $fullpath));

            return Response::json([
                'success' => true,
                'message' => 'Sms Sent Successfully!',

            ], 200);
        }
    }
}
