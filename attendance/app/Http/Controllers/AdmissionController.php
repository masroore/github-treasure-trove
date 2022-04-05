<?php

namespace App\Http\Controllers;

use App\Academicyear;
use App\Admissionapproveinfo;
use App\Applicationinfo;
use App\Guardianinfo;
use App\Mail\Sendosncode as Osnmail;
use App\Notifications\AdmissionSubmitMail;
use App\Notifications\NewstudentMail;
use App\Notifications\SendOsncode;
use App\Osncode;
use App\Personalinfo;
use App\Programme;
use App\Result;
use App\School;
use App\Studentinfo;
use App\Supportingdoc;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use DB;
use FPDF as pdfs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use URL;

class AdmissionController extends Controller
{
    private $fpdf;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.osncode');
    }

    public function purchase_osn(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'pnumber' => 'required',
            'prog' => 'required',
        ]);

        $amount = 0;

        if ('Degree Programme' == $request->input('prog')) {
            $amount = 200;
        } else {
            $amount = 180;
        }

        $data = [
            'firstname' => $request->input('fname'),
            'lastname' => $request->input('lname'),
            'othernames' => $request->input('oname'),
            'email' => $request->input('email'),
            'phone' => $request->input('pnumber'),
            'programme' => $request->input('prog'),
            'amount' => $amount,
            'year' => $request->input('pyear'),
        ];

        $osn = new Osncode($data);
        $osn->save();

        $lastid = $osn->id;

        $session = $request->session()->put('lastid', $lastid);

        //dd($session);

        if ($osn) {
            return Redirect()->back()->with('message', 'Info Saved Successfully');
        }
    }

    public function osn_payment(Request $request)
    {
        $session = $request->session()->get('lastid');
        //  dd($request);

        // exit();
        $osn = Osncode::find($session);
        // dd($osn);
        // exit();

        return view('web.osnpayment', ['osn' => $osn]);
    }

    public function osn_code_gen(Request $request)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($permitted_chars), 0, 18);

        $session = $request->session()->get('lastid');
        $osn = Osncode::find($session);
        $osn->code = $code;
        $osn->save();

        $fullname = $osn->lastname . ' ' . $osn->othernames . ' ' . $osn->firstname;
        $osncode = $osn->code;
        $email = $osn->email;
        $phone = $osn->phone;
        $prog = $osn->programme;

        // send email after code sent. to the intended user

        // Mail Send here via notification

        Notification::route('mail', $email)
            ->notify(new SendOsncode($fullname, $osncode, $email, $phone, $prog));

        // Send mail now
        // Mail::to($email)
        // ->cc('ogusesitsolutions@gmail.com')
        // ->send(new Osnmail($osncode));

        // return new Osnmail($osncode);

        return redirect()->route('online-admission-login')->with('message', 'Please check your mail box for online serial number to proceed for the registration process.');
    }

    public function online_admission(Request $request)
    {
        return View('web.admission_login');
    }

    public function admission_loign(Request $request)
    {
        $this->validate($request, [
            'osncode' => 'required',
        ]);

        $code = $request->input('osncode');
        $osncode = Osncode::whereRaw('BINARY `code` = ?', [$code])->first();

        //dd($osncode);

        if ($osncode) {
            $request->session()->put('id', $osncode->id);
            $request->session()->put('code', $code);
            $request->session()->put('name', $osncode->lastname);

            return Redirect()->route('admission-personal-info');
        }

        return Redirect()->back()->with('message', 'OSN CODE DONT Exist!.');
    }

    public function admission_personal_info(Request $request)
    {
        if (empty($request->session()->get('id'))) {
            session()->forget('id');
            session()->forget('code');
            session()->forget('name');

            return Redirect()->route('online-admission-login');
        }

        $id = $request->session()->get('id');
        $progra = Personalinfo::where('osncode_id', $id)->first();
        // dd($progra);
        // exit();
        return view('web.admission_personal_info', ['info' => $progra]);
    }

    public function save_per_info(Request $request)
    {
        //get current academic year
        $academic = Academicyear::where('status', 1)->first();

        $progra = Personalinfo::where('id', '=', $request->session()->get('id'))->count();
        if ($progra > 0) {
            $personalinfo = Personalinfo::where('osncode_id', '=', $request->session()->get('id'))->first();
            $personalinfo->title = $request->input('title');
            $personalinfo->surname = $request->input('Sname');
            $personalinfo->middlename = $request->input('mname');
            $personalinfo->firstnames = $request->input('fname');
            $personalinfo->gender = $request->input('gender');
            $personalinfo->dateofbirth = $request->input('dateofb');
            $personalinfo->religion = $request->input('relig');
            $personalinfo->denomination = $request->input('denomina');
            $personalinfo->placeofbirth = $request->input('plofbir');
            $personalinfo->nationality = $request->input('national');
            $personalinfo->hometown = $request->input('hometwn');
            $personalinfo->region = $request->input('region');
            $personalinfo->disability = $request->input('disble');
            $personalinfo->postcode = $request->input('pcode');
            $personalinfo->address = $request->input('residnadd');
            $personalinfo->email = $request->input('Email');
            $personalinfo->phone = $request->input('Phone');
            $personalinfo->maritalstutus = $request->input('mstatus');
            $personalinfo->save();
        } else {

            //insert data
            $data = [
                'title' => $request->input('title'),
                'surname' => $request->input('Sname'),
                'middlename' => $request->input('mname'),
                'firstnames' => $request->input('fname'),
                'gender' => $request->input('gender'),
                'dateofbirth' => $request->input('dateofb'),
                'religion' => $request->input('relig'),
                'denomination' => $request->input('denomina'),
                'placeofbirth' => $request->input('plofbir'),
                'nationality' => $request->input('national'),
                'hometown' => $request->input('hometwn'),
                'region' => $request->input('region'),
                'disability' => $request->input('disble'),
                'postcode' => $request->input('pcode'),
                'address' => $request->input('residnadd'),
                'email' => $request->input('Email'),
                'phone' => $request->input('Phone'),
                'year' => $academic->acdemicyear,
                'maritalstutus' => $request->input('mstatus'),
            ];

            $osdcode = Osncode::find($request->session()->get('id'));
            $personalinfo = new Personalinfo($data);
            $osdcode->personinfos()->save($personalinfo);
        }

        return Redirect()->route('admission-personal-results');
    }

    public function admission_personal_results(Request $request)
    {
        if (empty($request->session()->get('id'))) {
            session()->forget('id');
            session()->forget('code');
            session()->forget('name');

            return Redirect()->route('online-admission-login');
        }

        $id = $request->session()->get('id');
        $result1 = Result::where('osncode_id', $id)
            ->where('resulttype', 'result1')->first();

        $result2 = Result::where('osncode_id', $id)
            ->where('resulttype', 'result2')->first();

        $result3 = Result::where('osncode_id', $id)
            ->where('resulttype', 'result3')->first();

        // dd($result1);
        // exit();
        return view('web.admission_results', [
            'result1' => $result1,
            'result2' => $result2,
            'result3' => $result3,
        ]);
    }

    public function save_results(Request $request)
    {
        $grade1 = 0;
        $grade2 = 0;
        $grade3 = 0;
        $grade4 = 0;
        $grade5 = 0;
        $grade6 = 0;

        if ('' == $request->input('subject1')) {
        } else {
            if ('A' == $request->input('grade1')) {
                $grade1 = 1;
            } elseif ('B' == $request->input('grade1')) {
                $grade1 = 2;
            } elseif ('B1' == $request->input('grade1')) {
                $grade1 = 2;
            } elseif ('B2' == $request->input('grade1')) {
                $grade1 = 2;
            } elseif ('B3' == $request->input('grade1')) {
                $grade1 = 3;
            } elseif ('C' == $request->input('grade1')) {
                $grade1 = 3;
            } elseif ('C4' == $request->input('grade1')) {
                $grade1 = 4;
            } elseif ('C5' == $request->input('grade1')) {
                $grade1 = 5;
            } elseif ('C6' == $request->input('grade1')) {
                $grade1 = 6;
            } elseif ('D' == $request->input('grade1')) {
                $grade1 = 7;
            }
        }

        if ('' == $request->input('subject2')) {
        } else {
            if ('A' == $request->input('grade2')) {
                $grade2 = 1;
            } elseif ('B' == $request->input('grade2')) {
                $grade2 = 2;
            } elseif ('B1' == $request->input('grade2')) {
                $grade2 = 2;
            } elseif ('B2' == $request->input('grade2')) {
                $grade2 = 2;
            } elseif ('B3' == $request->input('grade2')) {
                $grade2 = 3;
            } elseif ('C' == $request->input('grade2')) {
                $grade2 = 3;
            } elseif ('C4' == $request->input('grade2')) {
                $grade2 = 4;
            } elseif ('C5' == $request->input('grade2')) {
                $grade2 = 5;
            } elseif ('C6' == $request->input('grade2')) {
                $grade2 = 6;
            } elseif ('D' == $request->input('grade2')) {
                $grade2 = 7;
            }
        }

        if ('' == $request->input('subject3')) {
        } else {
            if ('A' == $request->input('grade3')) {
                $grade3 = 1;
            } elseif ('B' == $request->input('grade3')) {
                $grade3 = 2;
            } elseif ('B1' == $request->input('grade3')) {
                $grade3 = 2;
            } elseif ('B2' == $request->input('grade3')) {
                $grade3 = 2;
            } elseif ('B3' == $request->input('grade3')) {
                $grade3 = 3;
            } elseif ('C' == $request->input('grade3')) {
                $grade3 = 3;
            } elseif ('C4' == $request->input('grade3')) {
                $grade3 = 4;
            } elseif ('C5' == $request->input('grade3')) {
                $grade3 = 5;
            } elseif ('C6' == $request->input('grade3')) {
                $grade3 = 6;
            } elseif ('D' == $request->input('grade3')) {
                $grade3 = 7;
            }
        }

        if ('' == $request->input('subject4')) {
        } else {
            if ('A' == $request->input('grade4')) {
                $grade4 = 1;
            } elseif ('B' == $request->input('grade4')) {
                $grade4 = 2;
            } elseif ('B1' == $request->input('grade4')) {
                $grade4 = 2;
            } elseif ('B2' == $request->input('grade4')) {
                $grade4 = 2;
            } elseif ('B3' == $request->input('grade4')) {
                $grade4 = 3;
            } elseif ('C' == $request->input('grade4')) {
                $grade4 = 3;
            } elseif ('C4' == $request->input('grade4')) {
                $grade4 = 4;
            } elseif ('C5' == $request->input('grade4')) {
                $grade4 = 5;
            } elseif ('C6' == $request->input('grade4')) {
                $grade4 = 6;
            } elseif ('D' == $request->input('grade4')) {
                $grade4 = 7;
            }
        }

        if ('' == $request->input('subject5')) {
        } else {
            if ('A' == $request->input('grade5')) {
                $grade5 = 1;
            } elseif ('B' == $request->input('grade5')) {
                $grade5 = 2;
            } elseif ('B1' == $request->input('grade5')) {
                $grade5 = 2;
            } elseif ('B2' == $request->input('grade5')) {
                $grade5 = 2;
            } elseif ('B3' == $request->input('grade5')) {
                $grade5 = 3;
            } elseif ('C' == $request->input('grade5')) {
                $grade5 = 3;
            } elseif ('C4' == $request->input('grade5')) {
                $grade5 = 4;
            } elseif ('C5' == $request->input('grade5')) {
                $grade5 = 5;
            } elseif ('C6' == $request->input('grade5')) {
                $grade5 = 6;
            } elseif ('D' == $request->input('grade5')) {
                $grade5 = 7;
            }
        }

        if ('' == $request->input('subject6')) {
        } else {
            if ('A' == $request->input('grade6')) {
                $grade6 = 1;
            } elseif ('B' == $request->input('grade6')) {
                $grade6 = 2;
            } elseif ('B1' == $request->input('grade6')) {
                $grade6 = 2;
            } elseif ('B2' == $request->input('grade6')) {
                $grade6 = 2;
            } elseif ('B3' == $request->input('grade6')) {
                $grade6 = 3;
            } elseif ('C' == $request->input('grade6')) {
                $grade6 = 3;
            } elseif ('C4' == $request->input('grade6')) {
                $grade6 = 4;
            } elseif ('C5' == $request->input('grade6')) {
                $grade6 = 5;
            } elseif ('C6' == $request->input('grade6')) {
                $grade6 = 6;
            } elseif ('D' == $request->input('grade6')) {
                $grade6 = 7;
            }
        }

        $resul1 = Result::where('resulttype', '=', 'result1')
            ->where('osncode_id', $request->session()->get('id'))->count();

        if ($resul1 > 0) {
            //update

            $results = Result::where('resulttype', 'result1')
                ->where('osncode_id', $request->session()->get('id'))->first();

            $results->resulttype = $request->input('result');
            $results->examtype = $request->input('extype');
            $results->examyear = $request->input('exyr');
            $results->indexnumber = $request->input('indexnember');
            $results->subject1 = $request->input('subject1');
            $results->grade1 = $request->input('grade1');
            $results->grad1 = $grade1;
            $results->subject2 = $request->input('subject2');
            $results->grade2 = $request->input('grade2');
            $results->grad2 = $grade2;
            $results->subject3 = $request->input('subject3');
            $results->grade3 = $request->input('grade3');
            $results->grad3 = $grade3;
            $results->subject4 = $request->input('subject4');
            $results->grade4 = $request->input('grade4');
            $results->grad4 = $grade4;
            $results->subject5 = $request->input('subject5');
            $results->grade5 = $request->input('grade5');
            $results->grad5 = $grade5;
            $results->subject6 = $request->input('subject6');
            $results->grade6 = $request->input('grade6');
            $results->grad6 = $grade6;
            $results->save();
        } else {
            //insert

            $data = [
                'resulttype' => $request->input('result'),
                'examtype' => $request->input('extype'),
                'examyear' => $request->input('exyr'),
                'indexnumber' => $request->input('indexnember'),
                'subject1' => $request->input('subject1'),
                'grade1' => $request->input('grade1'),
                'grad1' => $grade1,
                'subject2' => $request->input('subject2'),
                'grade2' => $request->input('grade2'),
                'grad2' => $grade2,
                'subject3' => $request->input('subject3'),
                'grade3' => $request->input('grade3'),
                'grad3' => $grade3,
                'subject4' => $request->input('subject4'),
                'grade4' => $request->input('grade4'),
                'grad4' => $grade4,
                'subject5' => $request->input('subject5'),
                'grade5' => $request->input('grade5'),
                'grad5' => $grade5,
                'subject6' => $request->input('subject6'),
                'grade6' => $request->input('grade6'),
                'grad6' => $grade6,
            ];

            //dd($data);

            $osdcode = Osncode::find($request->session()->get('id'));
            $result = new Result($data);
            $osdcode->saveresults()->save($result);
        }

        //toast('Result 1 Recorded Successfully!','success');

        return Redirect()->route('admission-personal-results')->with('message', 'Result 1 Recorded Successfully');
    }

    public function save_results2(Request $request)
    {
        if (empty($request->session()->get('id'))) {
            session()->forget('id');
            session()->forget('code');
            session()->forget('name');

            return Redirect()->route('online-admission-login');
        }

        $grade1 = 0;
        $grade2 = 0;
        $grade3 = 0;
        $grade4 = 0;
        $grade5 = 0;
        $grade6 = 0;

        if ('' == $request->input('subject1')) {
        } else {
            if ('A' == $request->input('grade1')) {
                $grade1 = 1;
            } elseif ('B' == $request->input('grade1')) {
                $grade1 = 2;
            } elseif ('B1' == $request->input('grade1')) {
                $grade1 = 2;
            } elseif ('B2' == $request->input('grade1')) {
                $grade1 = 2;
            } elseif ('B3' == $request->input('grade1')) {
                $grade1 = 3;
            } elseif ('C' == $request->input('grade1')) {
                $grade1 = 3;
            } elseif ('C4' == $request->input('grade1')) {
                $grade1 = 4;
            } elseif ('C5' == $request->input('grade1')) {
                $grade1 = 5;
            } elseif ('C6' == $request->input('grade1')) {
                $grade1 = 6;
            } elseif ('D' == $request->input('grade1')) {
                $grade1 = 7;
            }
        }

        if ('' == $request->input('subject2')) {
        } else {
            if ('A' == $request->input('grade2')) {
                $grade2 = 1;
            } elseif ('B' == $request->input('grade2')) {
                $grade2 = 2;
            } elseif ('B1' == $request->input('grade2')) {
                $grade2 = 2;
            } elseif ('B2' == $request->input('grade2')) {
                $grade2 = 2;
            } elseif ('B3' == $request->input('grade2')) {
                $grade2 = 3;
            } elseif ('C' == $request->input('grade2')) {
                $grade2 = 3;
            } elseif ('C4' == $request->input('grade2')) {
                $grade2 = 4;
            } elseif ('C5' == $request->input('grade2')) {
                $grade2 = 5;
            } elseif ('C6' == $request->input('grade2')) {
                $grade2 = 6;
            } elseif ('D' == $request->input('grade2')) {
                $grade2 = 7;
            }
        }

        if ('' == $request->input('subject3')) {
        } else {
            if ('A' == $request->input('grade3')) {
                $grade3 = 1;
            } elseif ('B' == $request->input('grade3')) {
                $grade3 = 2;
            } elseif ('B1' == $request->input('grade3')) {
                $grade3 = 2;
            } elseif ('B2' == $request->input('grade3')) {
                $grade3 = 2;
            } elseif ('B3' == $request->input('grade3')) {
                $grade3 = 3;
            } elseif ('C' == $request->input('grade3')) {
                $grade3 = 3;
            } elseif ('C4' == $request->input('grade3')) {
                $grade3 = 4;
            } elseif ('C5' == $request->input('grade3')) {
                $grade3 = 5;
            } elseif ('C6' == $request->input('grade3')) {
                $grade3 = 6;
            } elseif ('D' == $request->input('grade3')) {
                $grade3 = 7;
            }
        }

        if ('' == $request->input('subject4')) {
        } else {
            if ('A' == $request->input('grade4')) {
                $grade4 = 1;
            } elseif ('B' == $request->input('grade4')) {
                $grade4 = 2;
            } elseif ('B1' == $request->input('grade4')) {
                $grade4 = 2;
            } elseif ('B2' == $request->input('grade4')) {
                $grade4 = 2;
            } elseif ('B3' == $request->input('grade4')) {
                $grade4 = 3;
            } elseif ('C' == $request->input('grade4')) {
                $grade4 = 3;
            } elseif ('C4' == $request->input('grade4')) {
                $grade4 = 4;
            } elseif ('C5' == $request->input('grade4')) {
                $grade4 = 5;
            } elseif ('C6' == $request->input('grade4')) {
                $grade4 = 6;
            } elseif ('D' == $request->input('grade4')) {
                $grade4 = 7;
            }
        }

        if ('' == $request->input('subject5')) {
        } else {
            if ('A' == $request->input('grade5')) {
                $grade5 = 1;
            } elseif ('B' == $request->input('grade5')) {
                $grade5 = 2;
            } elseif ('B1' == $request->input('grade5')) {
                $grade5 = 2;
            } elseif ('B2' == $request->input('grade5')) {
                $grade5 = 2;
            } elseif ('B3' == $request->input('grade5')) {
                $grade5 = 3;
            } elseif ('C' == $request->input('grade5')) {
                $grade5 = 3;
            } elseif ('C4' == $request->input('grade5')) {
                $grade5 = 4;
            } elseif ('C5' == $request->input('grade5')) {
                $grade5 = 5;
            } elseif ('C6' == $request->input('grade5')) {
                $grade5 = 6;
            } elseif ('D' == $request->input('grade5')) {
                $grade5 = 7;
            }
        }

        if ('' == $request->input('subject6')) {
        } else {
            if ('A' == $request->input('grade6')) {
                $grade6 = 1;
            } elseif ('B' == $request->input('grade6')) {
                $grade6 = 2;
            } elseif ('B1' == $request->input('grade6')) {
                $grade6 = 2;
            } elseif ('B2' == $request->input('grade6')) {
                $grade6 = 2;
            } elseif ('B3' == $request->input('grade6')) {
                $grade6 = 3;
            } elseif ('C' == $request->input('grade6')) {
                $grade6 = 3;
            } elseif ('C4' == $request->input('grade6')) {
                $grade6 = 4;
            } elseif ('C5' == $request->input('grade6')) {
                $grade6 = 5;
            } elseif ('C6' == $request->input('grade6')) {
                $grade6 = 6;
            } elseif ('D' == $request->input('grade6')) {
                $grade6 = 7;
            }
        }

        $resul1 = Result::where('resulttype', 'result2')
            ->where('osncode_id', $request->session()->get('id'))->count();

        if ($resul1 > 0) {
            //update

            $results = Result::where('resulttype', 'result2')
                ->where('osncode_id', $request->session()->get('id'))->first();

            $results->resulttype = $request->input('result');
            $results->examtype = $request->input('extype');
            $results->examyear = $request->input('exyr');
            $results->indexnumber = $request->input('indexnember');
            $results->subject1 = $request->input('subject1');
            $results->grade1 = $request->input('grade1');
            $results->grad1 = $grade1;
            $results->subject2 = $request->input('subject2');
            $results->grade2 = $request->input('grade2');
            $results->grad2 = $grade2;
            $results->subject3 = $request->input('subject3');
            $results->grade3 = $request->input('grade3');
            $results->grad3 = $grade3;
            $results->subject4 = $request->input('subject4');
            $results->grade4 = $request->input('grade4');
            $results->grad4 = $grade4;
            $results->subject5 = $request->input('subject5');
            $results->grade5 = $request->input('grade5');
            $results->grad5 = $grade5;
            $results->subject6 = $request->input('subject6');
            $results->grade6 = $request->input('grade5');
            $results->grad6 = $grade6;
            $results->save();

        //dd($results);
        } else {
            //insert

            $data = [
                'resulttype' => $request->input('result'),
                'examtype' => $request->input('extype'),
                'examyear' => $request->input('exyr'),
                'indexnumber' => $request->input('indexnember'),
                'subject1' => $request->input('subject1'),
                'grade1' => $request->input('grade1'),
                'grad1' => $grade1,
                'subject2' => $request->input('subject2'),
                'grade2' => $request->input('grade2'),
                'grad2' => $grade2,
                'subject3' => $request->input('subject3'),
                'grade3' => $request->input('grade3'),
                'grad3' => $grade3,
                'subject4' => $request->input('subject4'),
                'grade4' => $request->input('grade4'),
                'grad4' => $grade4,
                'subject5' => $request->input('subject5'),
                'grade5' => $request->input('grade5'),
                'grad5' => $grade5,
                'subject6' => $request->input('subject6'),
                'grade6' => $request->input('grade6'),
                'grad6' => $grade6,
            ];

            $osdcode = Osncode::find($request->session()->get('id'));
            $result = new Result($data);
            $osdcode->saveresults()->save($result);
        }

        toastr()->success('Result 2 Recorded Successfully!');

        return Redirect()->route('admission-personal-results');
    }

    public function save_results3(Request $request)
    {
        if (empty($request->session()->get('id'))) {
            session()->forget('id');
            session()->forget('code');
            session()->forget('name');

            return Redirect()->route('online-admission-login');
        }

        $grade1 = 0;
        $grade2 = 0;
        $grade3 = 0;
        $grade4 = 0;
        $grade5 = 0;
        $grade6 = 0;

        if ('' == $request->input('subject1')) {
        } else {
            if ('A' == $request->input('grade1')) {
                $grade1 = 1;
            } elseif ('B' == $request->input('grade1')) {
                $grade1 = 2;
            } elseif ('B1' == $request->input('grade1')) {
                $grade1 = 2;
            } elseif ('B2' == $request->input('grade1')) {
                $grade1 = 2;
            } elseif ('B3' == $request->input('grade1')) {
                $grade1 = 3;
            } elseif ('C' == $request->input('grade1')) {
                $grade1 = 3;
            } elseif ('C4' == $request->input('grade1')) {
                $grade1 = 4;
            } elseif ('C5' == $request->input('grade1')) {
                $grade1 = 5;
            } elseif ('C6' == $request->input('grade1')) {
                $grade1 = 6;
            } elseif ('D' == $request->input('grade1')) {
                $grade1 = 7;
            }
        }

        if ('' == $request->input('subject2')) {
        } else {
            if ('A' == $request->input('grade2')) {
                $grade2 = 1;
            } elseif ('B' == $request->input('grade2')) {
                $grade2 = 2;
            } elseif ('B1' == $request->input('grade2')) {
                $grade2 = 2;
            } elseif ('B2' == $request->input('grade2')) {
                $grade2 = 2;
            } elseif ('B3' == $request->input('grade2')) {
                $grade2 = 3;
            } elseif ('C' == $request->input('grade2')) {
                $grade2 = 3;
            } elseif ('C4' == $request->input('grade2')) {
                $grade2 = 4;
            } elseif ('C5' == $request->input('grade2')) {
                $grade2 = 5;
            } elseif ('C6' == $request->input('grade2')) {
                $grade2 = 6;
            } elseif ('D' == $request->input('grade2')) {
                $grade2 = 7;
            }
        }

        if ('' == $request->input('subject3')) {
        } else {
            if ('A' == $request->input('grade3')) {
                $grade3 = 1;
            } elseif ('B' == $request->input('grade3')) {
                $grade3 = 2;
            } elseif ('B1' == $request->input('grade3')) {
                $grade3 = 2;
            } elseif ('B2' == $request->input('grade3')) {
                $grade3 = 2;
            } elseif ('B3' == $request->input('grade3')) {
                $grade3 = 3;
            } elseif ('C' == $request->input('grade3')) {
                $grade3 = 3;
            } elseif ('C4' == $request->input('grade3')) {
                $grade3 = 4;
            } elseif ('C5' == $request->input('grade3')) {
                $grade3 = 5;
            } elseif ('C6' == $request->input('grade3')) {
                $grade3 = 6;
            } elseif ('D' == $request->input('grade3')) {
                $grade3 = 7;
            }
        }

        if ('' == $request->input('subject4')) {
        } else {
            if ('A' == $request->input('grade4')) {
                $grade4 = 1;
            } elseif ('B' == $request->input('grade4')) {
                $grade4 = 2;
            } elseif ('B1' == $request->input('grade4')) {
                $grade4 = 2;
            } elseif ('B2' == $request->input('grade4')) {
                $grade4 = 2;
            } elseif ('B3' == $request->input('grade4')) {
                $grade4 = 3;
            } elseif ('C' == $request->input('grade4')) {
                $grade4 = 3;
            } elseif ('C4' == $request->input('grade4')) {
                $grade4 = 4;
            } elseif ('C5' == $request->input('grade4')) {
                $grade4 = 5;
            } elseif ('C6' == $request->input('grade4')) {
                $grade4 = 6;
            } elseif ('D' == $request->input('grade4')) {
                $grade4 = 7;
            }
        }

        if ('' == $request->input('subject5')) {
        } else {
            if ('A' == $request->input('grade5')) {
                $grade5 = 1;
            } elseif ('B' == $request->input('grade5')) {
                $grade5 = 2;
            } elseif ('B1' == $request->input('grade5')) {
                $grade5 = 2;
            } elseif ('B2' == $request->input('grade5')) {
                $grade5 = 2;
            } elseif ('B3' == $request->input('grade5')) {
                $grade5 = 3;
            } elseif ('C' == $request->input('grade5')) {
                $grade5 = 3;
            } elseif ('C4' == $request->input('grade5')) {
                $grade5 = 4;
            } elseif ('C5' == $request->input('grade5')) {
                $grade5 = 5;
            } elseif ('C6' == $request->input('grade5')) {
                $grade5 = 6;
            } elseif ('D' == $request->input('grade5')) {
                $grade5 = 7;
            }
        }

        if ('' == $request->input('subject6')) {
        } else {
            if ('A' == $request->input('grade6')) {
                $grade6 = 1;
            } elseif ('B' == $request->input('grade6')) {
                $grade6 = 2;
            } elseif ('B1' == $request->input('grade6')) {
                $grade6 = 2;
            } elseif ('B2' == $request->input('grade6')) {
                $grade6 = 2;
            } elseif ('B3' == $request->input('grade6')) {
                $grade6 = 3;
            } elseif ('C' == $request->input('grade6')) {
                $grade6 = 3;
            } elseif ('C4' == $request->input('grade6')) {
                $grade6 = 4;
            } elseif ('C5' == $request->input('grade6')) {
                $grade6 = 5;
            } elseif ('C6' == $request->input('grade6')) {
                $grade6 = 6;
            } elseif ('D' == $request->input('grade6')) {
                $grade6 = 7;
            }
        }

        $resul1 = Result::where('resulttype', 'result3')
            ->where('osncode_id', $request->session()->get('id'))->count();

        if ($resul1 > 0) {
            //update

            $results = Result::where('resulttype', 'result3')
                ->where('osncode_id', $request->session()->get('id'))->first();

            $results->resulttype = $request->input('result');
            $results->examtype = $request->input('extype');
            $results->examyear = $request->input('exyr');
            $results->indexnumber = $request->input('indexnember');
            $results->subject1 = $request->input('subject1');
            $results->grade1 = $request->input('grade1');
            $results->grad1 = $grade1;
            $results->subject2 = $request->input('subject2');
            $results->grade2 = $request->input('grade2');
            $results->grad2 = $grade2;
            $results->subject3 = $request->input('subject3');
            $results->grade3 = $request->input('grade3');
            $results->grad3 = $grade3;
            $results->subject4 = $request->input('subject4');
            $results->grade4 = $request->input('grade4');
            $results->grad4 = $grade4;
            $results->subject5 = $request->input('subject5');
            $results->grade5 = $request->input('grade5');
            $results->grad5 = $grade5;
            $results->subject6 = $request->input('subject6');
            $results->grade6 = $request->input('grade6');
            $results->grad6 = $grade6;
            $results->save();
        } else {
            //insert

            $data = [
                'resulttype' => $request->input('result'),
                'examtype' => $request->input('extype'),
                'examyear' => $request->input('exyr'),
                'indexnumber' => $request->input('indexnember'),
                'subject1' => $request->input('subject1'),
                'grade1' => $request->input('grade1'),
                'grad1' => $grade1,
                'subject2' => $request->input('subject2'),
                'grade2' => $request->input('grade2'),
                'grad2' => $grade2,
                'subject3' => $request->input('subject3'),
                'grade3' => $request->input('grade3'),
                'grad3' => $grade3,
                'subject4' => $request->input('subject4'),
                'grade4' => $request->input('grade4'),
                'grad4' => $grade4,
                'subject5' => $request->input('subject5'),
                'grade5' => $request->input('grade5'),
                'grad5' => $grade5,
                'subject6' => $request->input('subject6'),
                'grade6' => $request->input('grade6'),
                'grad6' => $grade6,
            ];

            // print_r($data);

            // exit();

            $osdcode = Osncode::find($request->session()->get('id'));
            $result = new Result($data);
            $osdcode->saveresults()->save($result);
        }
        // DB::enableQuerylog();
        // dd(DB::getQuerylog());

        // exit();

        toastr()->success('Result 3 Recorded Successfully!');

        return Redirect()->route('admission-personal-results');
    }

    public function admission_personal_school(Request $request)
    {
        if (empty($request->session()->get('id'))) {
            session()->forget('id');
            session()->forget('code');
            session()->forget('name');

            return Redirect()->route('online-admission-login');
        }

        $id = $request->session()->get('id');
        $school = School::where('osncode_id', $id)->first();
        // dd($school);
        // exit();

        return view('web.admission_school', ['school' => $school]);
    }

    public function admission_personal_school_save(Request $request)
    {
        if (empty($request->session()->get('id'))) {
            session()->forget('id');
            session()->forget('code');
            session()->forget('name');

            return Redirect()->route('online-admission-login');
        }

        $school = School::where('osncode_id', $request->session()->get('id'))->count();

        if ($school > 0) {
            //update
            $schoolattneded = School::where('osncode_id', $request->session()->get('id'))->first();
            $schoolattneded->name = $request->input('iname1');
            $schoolattneded->schstart = $request->input('stdate1');
            $schoolattneded->schend = $request->input('eddate1');
            $schoolattneded->name2 = $request->input('iname2');
            $schoolattneded->schstart2 = $request->input('stdate2');
            $schoolattneded->schend2 = $request->input('eddate2');
            $schoolattneded->save();
        } else {
            //insert
            $data = [
                'name' => $request->input('iname1'),
                'schstart' => $request->input('stdate1'),
                'schend' => $request->input('eddate1'),
                'name2' => $request->input('iname2'),
                'schstart2' => $request->input('stdate2'),
                'schend2' => $request->input('eddate2'),
            ];

            $osdcode = Osncode::find($request->session()->get('id'));
            $schoolattneded = new School($data);
            $osdcode->schools()->save($schoolattneded);
        }

        return Redirect()->route('admission-app-info');
    }

    public function admission_app_info(Request $request)
    {
        if (empty($request->session()->get('id'))) {
            session()->forget('id');
            session()->forget('code');
            session()->forget('name');

            return Redirect()->route('online-admission-login');
        }

        $id = $request->session()->get('id');
        $appinfo = Applicationinfo::where('osncode_id', $id)->first();
        $prog = Programme::all();

        return view('web.admisssion_appliactioninfo', [
            'prog' => $prog,
            'appinfo' => $appinfo,
        ]);
    }

    public function admission_app_info_save(Request $request)
    {
        if (empty($request->session()->get('id'))) {
            session()->forget('id');
            session()->forget('code');
            session()->forget('name');

            return Redirect()->route('online-admission-login');
        }

        $admision = Applicationinfo::where('osncode_id', $request->session()->get('id'))->count();

        $fc = explode('-', $request->input('fcchoice'));
        $sc = explode('-', $request->input('sndchoice'));
        $tc = explode('-', $request->input('thrdchoice'));

        $first = trim($fc[0]);
        $firstc = trim($fc[1]);

        $sec = trim($sc[0]);
        $secc = trim($sc[1]);

        $trd = trim($tc[0]);
        $trdc = trim($tc[1]);

        if ($admision > 0) {
            // update
            $appinfo = Applicationinfo::where('osncode_id', $request->session()->get('id'))->first();
            $appinfo->session = $request->input('session');
            $appinfo->entrylevel = $request->input('entry');

            $appinfo->firstchoice = $first;
            $appinfo->fcode = $firstc;

            $appinfo->secondchoice = $sec;
            $appinfo->scode = $secc;

            $appinfo->thirdchoice = $trd;
            $appinfo->tcode = $trdc;

            $appinfo->indexnumber = $request->input('index1');

            //dd($appinfo);

            $appinfo->save();
        } else {
            // insert
            function generateindexid($limit)
            {
                $code = 'GES';

                for ($i = 0; $i < $limit; ++$i) {
                    $code .= mt_rand(0, 9);
                }

                return $code;
            }

            // $indexnumber = generateindexid(9);

            // dd($indexnumber);
            // exit();

            $data = [
                'session' => $request->input('session'),
                'entrylevel' => $request->input('entry'),
                'firstchoice' => $first,
                'fcode' => $first,
                'secondchoice' => $sec,
                'scode' => $secc,
                'thirdchoice' => $trd,
                'tcode' => $trdc,
                'indexnumber' => generateindexid(5),
            ];

            $osdcode = Osncode::find($request->session()->get('id'));
            $appinfo = new Applicationinfo($data);
            $osdcode->appinfomations()->save($appinfo);
        }

        return Redirect()->route('admission-guidian-info');
    }
    //admission-app-info

    public function admission_guidian_info(Request $request)
    {
        $id = $request->session()->get('id');
        $gurinfo = Guardianinfo::where('osncode_id', $id)->first();

        return view('web.admission_gurdian', ['gurinfo' => $gurinfo]);
    }

    public function admission_guid_save(Request $request)
    {
        if (empty($request->session()->get('id'))) {
            session()->forget('id');
            session()->forget('code');
            session()->forget('name');

            return Redirect()->route('online-admission-login');
        }

        $guidian = Guardianinfo::where('osncode_id', $request->session()->get('id'))->count();

        if ($guidian > 0) {
            // update
            $gurinfo = Guardianinfo::where('osncode_id', $request->session()->get('id'))->first();
            $gurinfo->gurdianname = $request->input('gurname');
            $gurinfo->relationshp = $request->input('gurrela');
            $gurinfo->occupation = $request->input('guroccu');
            $gurinfo->mobile = $request->input('gurmob');
            $gurinfo->employed = $request->input('emplued');
            $gurinfo->save();
        } else {
            //insert
            $data = [
                'gurdianname' => $request->input('gurname'),
                'relationshp' => $request->input('gurrela'),
                'occupation' => $request->input('guroccu'),
                'mobile' => $request->input('gurmob'),
                'employed' => $request->input('emplued'),
            ];

            $osdcode = Osncode::find($request->session()->get('id'));
            $gurinfo = new Guardianinfo($data);
            $osdcode->gurdianinfos()->save($gurinfo);
        }

        return Redirect()->route('admission-sup-doc');
    }

    public function admission_sup_doc(Request $request)
    {
        if (empty($request->session()->get('id'))) {
            session()->forget('id');
            session()->forget('code');
            session()->forget('name');

            return Redirect()->route('online-admission-login');
        }

        $suportdoc = Supportingdoc::where('osncode_id', $request->session()->get('id'))->get();

        // dd($suportdoc);
        // exit();
        return view('web.admission_sup_doc', ['supportdoc' => $suportdoc]);
    }

    public function admission_sup_doc_save(Request $request)
    {
        $fillname = pathinfo($request->file('fileToUpload')->getClientOriginalName(), \PATHINFO_FILENAME);

        //insert
        $data = [
            'doctype' => $request->input('doctype'),
            'filename' => $fillname,
        ];

        if (empty($request->session()->get('id'))) {
            session()->forget('id');
            session()->forget('code');
            session()->forget('name');

            return Redirect()->route('online-admission-login');
        }

        $osdcode = Osncode::find($request->session()->get('id'));
        $suportdoc = new Supportingdoc($data);

        $osdcode->supportdocs()->save($suportdoc);

        if ($request->has('fileToUpload')) {
            // code...
            // $suportdoc->name = $request->file('fileToUpload')->store('supportdoc','public');
            // $suportdoc->save();

            //or
            $data = [
                'name' => $request->file('fileToUpload')->store('supportdoc', 'public'),
            ];
            $suportdoc->update($data);
        }

        return Redirect()->back();
        // route('admission-sup-doc');
    }

    public function admission_sup_doc_delete($id)
    {
        $suportdoc = Supportingdoc::find($id)->first();

        $name = $suportdoc->name;

        // dd($name);
        // exit();

        //delete Document First
        $storage = Storage::disk('public')->delete($name);
        // $storage = Storage::delete($name);
        //delete form database;
        if ($storage) {
            $suportdoc->delete();
        }

        return Redirect()->back();
    }

    public function admission_profile_image(Request $request)
    {
        $id = $request->session()->get('id');
        if (empty($id)) {
            session()->forget('id');
            session()->forget('code');
            session()->forget('name');

            return Redirect()->route('online-admission-login');
        }

        $person = Personalinfo::where('osncode_id', $id)->first();

        if ($person) {
            return view('web.admission_upload_pic', ['profile' => $person]);
        }

        return Redirect()->back();
    }

    public function admission_submit_img(Request $request)
    {
        $id = $request->session()->get('id');

        if (empty($id)) {
            session()->forget('id');
            session()->forget('code');
            session()->forget('name');

            return Redirect()->route('online-admission-login');
        }

        $person = Personalinfo::where('osncode_id', $id)->first();

        if ($person->profileimg) {
            //delete previous image then update
            $img = $person->profileimg;
            $storage = Storage::disk('public')->delete($img);
            //now update image
            $person->profileimg = $request->file('fileToUpload')
                ->store('profile_img', 'public');
            $person->save();
        } else {
            //update only
            $person->profileimg = $request->file('fileToUpload')
                ->store('profile_img', 'public');
            $person->save();
        }

        return Redirect()->back();
    }

    public function submit_appliaction($id)
    {
        // echo $id;
        $progra = Personalinfo::where('id', $id)->first();
        //dd($progra);
        $progra->status = 1;
        $progra->save();

        //SEND MAIL TO NOTIFY USER OF ADMISSION COMPLESSION

        $email = $progra->email;
        $fullname = $progra->surname . ' ' . $progra->firstnames . ' ' . $progra->middlename;

        //END MAIL HERE
        Notification::route('mail', $email)
            ->notify(new AdmissionSubmitMail($fullname));

        return Redirect()->route('admission-completed');
    }

    public function user_logout()
    {
        session()->forget('id');
        session()->forget('code');
        session()->forget('name');

        return Redirect()->route('online-admission-login');
    }

    public function adm_complete(Request $request)
    {
        $id = $request->session()->get('id');

        if (empty($id)) {
            session()->forget('id');
            session()->forget('code');
            session()->forget('name');

            return Redirect()->route('online-admission-login');
        }

        $person = Personalinfo::where('osncode_id', $id)->first();
        $appinfo = Applicationinfo::where('osncode_id', $id)->first();

        $admissfile = Admissionapproveinfo::latest()->first();

        $fullpath = asset('storage') . '/' . $admissfile->file;

        return view('web.admission_completed', [
            'personal' => $person,
            'appinfo' => $appinfo,
            'file' => $fullpath, ]);
    }

    public function adm_complete_print(Request $request)
    {

    //do stuff
        // return response($this->fpdf->Output('D','Admission-Form.pdf'))
        //         ->header('Content-Type', 'application/pdf');

        $id = $request->session()->get('id');
        $person = Personalinfo::where('osncode_id', $id)->first();

        $appinfo = Applicationinfo::where('osncode_id', $id)->first();

        $result1 = Result::where('resulttype', 'result1')
            ->where('osncode_id', $id)->first();

        $result2 = Result::where('resulttype', 'result2')
            ->where('osncode_id', $id)->first();

        $result3 = Result::where('resulttype', 'result3')
            ->where('osncode_id', $id)->first();

        // $pdf = App::make('dompdf.wrapper');

        // $pdf->loadView('web.admission_print',[
        //   'personal' => $person,
        //   'appinfo' => $appinfo,
        //   'result1' => $result1,
        //   'result2' => $result2,
        //   'result3' => $result3
        // ]);

        // return $pdf->stream('Admission-Summary.pdf');

        $image = URL::to('images/logo.png');
        $pro = asset('storage') . '/' . $person->profileimg;

        $back = URL::to('images/logo-back.png');

        //$signature = URL::to('images/sign2.jpg');

        $this->fpdf = new pdfs();
        $this->fpdf->AliasNbPages();

        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->AddPage('P');
        // $this->fpdf->SetTitle("Students With Their Enrollment Numbers");

        $this->fpdf->centreImage($back);

        //$this->fpdf->imageUniformToFill($image,10,10,0,0,"C");

        $this->fpdf->Cell(190, 5, 'Ogua School Management System', 0, 1, 'C');
        $this->fpdf->Cell(190, 10, 'Application Summary', 0, 1, 'C');
        $this->fpdf->Image($image, 10, 6, 30);
        $this->fpdf->Image($pro, 160, 6, 30);

        $this->fpdf->line(20, 45, 210 - 20, 45);

        $this->fpdf->Ln(22);

        $this->fpdf->Cell(190, 5, "Summary of Applicant's Informaton", 0, 1, 'C');
        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(10);

        $this->fpdf->MultiCell(190, 3, 'I hereby declare that the information provided by me online regarding the summary of my bio-data and my entry qualification(s) as reproduced below are authentic and reflects my true records.', 0, 'J', 0, 4);

        // $this->fpdf->MultiCell(190, 3,'I hereby declare that the information provided by me online regarding the summary of my bio-data and my entry qualification(s) as reproduced below are authentic and reflects my true records.',0,'J',0,4);

        $this->fpdf->Cell(96, 10, 'Personnal Information', 1, 0, 'C');
        $this->fpdf->Cell(92, 10, 'Application Information', 1, 1, 'C');

        $this->fpdf->SetFont('Arial', '', 6);
        $this->fpdf->Cell(48, 5, 'Fullame', 1, 0, 'L');
        $this->fpdf->Cell(48, 5, $person->surname . ' ' . $person->firstnames . ' ' . $person->middlename, 1, 0, 'L');
        $this->fpdf->Cell(46, 5, 'Entry Level', 1, 0, 'L');
        $this->fpdf->Cell(46, 5, $appinfo->entrylevel, 1, 1, 'L');

        $this->fpdf->Cell(48, 5, 'Date of birth', 1, 0, 'L');
        $this->fpdf->Cell(48, 5, $person->dateofbirth, 1, 0, 'L');
        $this->fpdf->Cell(46, 5, 'Session', 1, 0, 'L');
        $this->fpdf->Cell(46, 5, $appinfo->session, 1, 1, 'L');

        $this->fpdf->Cell(48, 5, 'Email', 1, 0, 'L');
        $this->fpdf->Cell(48, 5, $person->email, 1, 0, 'L');
        $this->fpdf->Cell(46, 5, '', 1, 0, 'L');
        $this->fpdf->Cell(46, 5, '', 1, 1, 'L');

        $this->fpdf->Cell(48, 5, 'Phone', 1, 0, 'L');
        $this->fpdf->Cell(48, 5, $person->phone, 1, 0, 'L');
        $this->fpdf->Cell(46, 5, '', 1, 0, 'L');
        $this->fpdf->Cell(46, 5, '', 1, 1, 'L');

        $this->fpdf->Cell(48, 5, 'Marital Status', 1, 0, 'L');
        $this->fpdf->Cell(48, 5, $person->maritalstutus, 1, 0, 'L');
        $this->fpdf->Cell(46, 5, '', 1, 0, 'L');
        $this->fpdf->Cell(46, 5, '', 1, 1, 'L');

        $this->fpdf->Cell(48, 5, 'First Choice', 1, 0, 'L');
        $this->fpdf->Cell(140, 5, $appinfo->firstchoice, 1, 1, 'L');

        $this->fpdf->Cell(48, 5, 'Second Choice', 1, 0, 'L');
        $this->fpdf->Cell(140, 5, $appinfo->secondchoice, 1, 1, 'L');

        $this->fpdf->Cell(48, 5, 'Third Choice', 1, 0, 'L');
        $this->fpdf->Cell(140, 5, $appinfo->thirdchoice, 1, 1, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell(188, 5, 'Examination Results', 1, 1, 'C');

        $this->fpdf->Cell(48, 5, 'Subject', 1, 0, 'C');
        $this->fpdf->Cell(48, 5, 'Grade', 1, 0, 'C');
        $this->fpdf->Cell(46, 5, 'Index Number', 1, 0, 'C');
        $this->fpdf->Cell(46, 5, 'Year of Sitting', 1, 1, 'C');

        $this->fpdf->SetFont('Arial', '', 8);

        if ($result1->subject1) {
            $this->fpdf->Cell(48, 5, $result1->subject1, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result1->grade1, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result1->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result1->examyear, 1, 1, 'C');
        }

        if ($result1->subject2) {
            $this->fpdf->Cell(48, 5, $result1->subject2, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result1->grade2, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result1->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result1->examyear, 1, 1, 'C');
        }

        if ($result1->subject3) {
            $this->fpdf->Cell(48, 5, $result1->subject3, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result1->grade3, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result1->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result1->examyear, 1, 1, 'C');
        }

        if ($result1->subject4) {
            $this->fpdf->Cell(48, 5, $result1->subject4, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result1->grade4, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result1->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result1->examyear, 1, 1, 'C');
        }

        if ($result1->subject5) {
            $this->fpdf->Cell(48, 5, $result1->subject5, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result1->grade5, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result1->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result1->examyear, 1, 1, 'C');
        }

        if ($result1->subject6) {
            $this->fpdf->Cell(48, 5, $result1->subject6, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result1->grade6, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result1->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result1->examyear, 1, 1, 'C');
        }

        if (!empty($result2->subject1)) {
            $this->fpdf->Cell(48, 5, $result2->subject1, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result2->grade1, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result2->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result2->examyear, 1, 1, 'C');
        }

        if (!empty($result2->subject2)) {
            $this->fpdf->Cell(48, 5, $result2->subject2, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result2->grade2, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result2->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result2->examyear, 1, 1, 'C');
        }

        if (!empty($result2->subject3)) {
            $this->fpdf->Cell(48, 5, $result2->subject3, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result2->grade3, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result2->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result2->examyear, 1, 1, 'C');
        }

        if (!empty($result2->subject4)) {
            $this->fpdf->Cell(48, 5, $result2->subject4, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result2->grade4, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result2->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result2->examyear, 1, 1, 'C');
        }

        if (!empty($result2->subject5)) {
            $this->fpdf->Cell(48, 5, $result2->subject5, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result2->grade5, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result2->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result2->examyear, 1, 1, 'C');
        }

        if (!empty($result2->subject6)) {
            $this->fpdf->Cell(48, 5, $result2->subject6, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result2->grade6, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result2->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result2->examyear, 1, 1, 'C');
        }

        if (!empty($result3->subject1)) {
            $this->fpdf->Cell(48, 5, $result3->subject1, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result3->grade1, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result3->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result3->examyear, 1, 1, 'C');
        }

        if (!empty($result3->subject2)) {
            $this->fpdf->Cell(48, 5, $result3->subject2, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result3->grade2, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result3->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result3->examyear, 1, 1, 'C');
        }

        if (!empty($result3->subject3)) {
            $this->fpdf->Cell(48, 5, $result3->subject3, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result3->grade3, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result3->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result3->examyear, 1, 1, 'C');
        }

        if (!empty($result3->subject4)) {
            $this->fpdf->Cell(48, 5, $result3->subject4, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result3->grade4, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result3->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result3->examyear, 1, 1, 'C');
        }

        if (!empty($result3->subject5)) {
            $this->fpdf->Cell(48, 5, $result3->subject5, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result3->grade5, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result3->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result3->examyear, 1, 1, 'C');
        }

        if (!empty($result3->subject6)) {
            $this->fpdf->Cell(48, 5, $result3->subject6, 1, 0, 'C');
            $this->fpdf->Cell(48, 5, $result3->grade6, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result3->indexnumber, 1, 0, 'C');
            $this->fpdf->Cell(46, 5, $result3->examyear, 1, 1, 'C');
        }

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(27, 5, 'Applicant Signature: ', 0, 0, 'L');
        $this->fpdf->Cell(100, 5, '-----------------------------------', 0, 0, 'L');
        $this->fpdf->Cell(16, 5, 'Date: ', 0, 0, 'R');
        $this->fpdf->Cell(60, 5, '-------------------------------------------------------', 0, 1, 'L');

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(190, 5, 'Witness', 0, 1, 'L');
        $this->fpdf->SetFont('Arial', '', 8);
        $this->fpdf->Cell(190, 5, 'To be completed by witness:', 0, 1, 'L');

        //$this->fpdf->Ln(5);

        $this->fpdf->MultiCell(190, 3, 'I certify that the photograph endorsed by me is the true likeness of the application', 0, 'J', 0, 4);

        //$this->fpdf->setY(70);

        $this->fpdf->MultiCell(190, 3, 'MR/Ms/Mrs:.....................................................................................................................................................................................who is personally known by me. I have inspected the certificate(s) submitted by the applicate and to the best of my knowledge, they are genuine and the grades provided above are exact replication of the grades indicated on the certificate(s)', 0, 'J', 0, 4);

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(25, 5, 'Name:', 0, 0, 'L');
        $this->fpdf->Cell(190, 5, '..................................................................................', 0, 1, 'L');

        $this->fpdf->Cell(25, 5, 'Signature/Stamp:', 0, 0, 'L');
        $this->fpdf->Cell(190, 5, '..................................................................................', 0, 1, 'L');

        $this->fpdf->Cell(25, 5, 'Position:', 0, 0, 'L');
        $this->fpdf->Cell(190, 5, '..................................................................................', 0, 1, 'L');

        $this->fpdf->Cell(25, 5, 'Address:', 0, 0, 'L');
        $this->fpdf->Cell(190, 5, '..................................................................................', 0, 1, 'L');

        $this->fpdf->Cell(25, 5, 'Date:', 0, 0, 'L');
        $this->fpdf->Cell(190, 5, '..................................................................................', 0, 1, 'L');

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', '', 8);
        $this->fpdf->MultiCell(190, 3, "The endorsed copy of this declaration must be submiited together with copies of the applicant's birth certificate, result slip/certificate and in the case of HND/University Diploma holders, transcript of academic records in a manila envelope to the address below by EMS", 0, 'J', 0, 4);

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(190, 5, 'The Director of Academic Affairs', 0, 1, 'C');
        $this->fpdf->Cell(190, 5, 'Ogua School Management System', 0, 1, 'C');
        $this->fpdf->Cell(190, 5, 'P.O.BOX TS 367', 0, 1, 'C');
        $this->fpdf->Cell(190, 5, 'Accra', 0, 1, 'C');

        $this->fpdf->Ln(5);
        $this->fpdf->Cell(190, 5, 'Closing date for submission is ' . date('d-m-y'), 0, 1, 'L');

        return response($this->fpdf->Output('D', 'application-summary.pdf'))
            ->header('Content-Type', 'application/pdf');

        return view('web.admission_print', [
            'personal' => $person,
            'appinfo' => $appinfo,
            'result1' => $result1,
            'result2' => $result2,
            'result3' => $result3,
        ]);
    }

    public function newStudent()
    {
        $prog = Programme::all();

        return view('admissionsubmitted.new_student_reg', ['prog' => $prog]);
    }

    public function newStudent_register(Request $request)
    {
        $academic = Academicyear::where('status', 1)->first();

        //dd($request);
        $this->validate($request, [
            'fullname' => 'required',
            'gender' => 'required',
            'dateofbirth' => 'required',
            'denomination' => 'required',
            'religion' => 'required',
            'mobile' => 'required',
            'placeofbirth' => 'required',
            'nationality' => 'required',
            'hometown' => 'required',
            'disability' => 'required',
            'postcode' => 'required',
            'email' => 'required|email',
            'maritalstatus' => 'required',
            'address' => 'required',
            'entrylevel' => 'required',
            'session' => 'required',
            'programme' => 'required',
            'guidianfullname' => 'required',
            'relationship' => 'required',
            'guidianoccupation' => 'required',
            'mobnumber' => 'required',
            'image' => 'required|image',
            'employed' => 'required',
        ]);

        function generateindexid($limit)
        {
            $code = 'GES';

            for ($i = 0; $i < $limit; ++$i) {
                $code .= mt_rand(0, 9);
            }

            return $code;
        }

        $indexnumber = generateindexid(5);

        $regemail = $indexnumber . '@osms.edu.com';

        //create user
        $user = User::create([
            'name' => $request->input('fullname'),
            'email' => $regemail,
            'indexnumber' => $indexnumber,
            'regemail' => $request->input('email'),
            'pro_pic' => $request->file('image')->store('profileimage', 'public'),
            'password' => Hash::make($request->input('email')),
        ]);

        $user->assignRole('Student');

        $prog = explode('-', $request->input('programme'));

        $name = $prog[0];
        $code = $prog[1];
        $duras = $prog[2];
        $type = $prog[3];

        if ('Degree Programme' == $type) {
            $duration = 4 + date('Y');
        } else {
            $duration = 3 + date('Y');
        }
        //transfer details to another table

        $data = [
            'title' => $request->input('title'),
            'fullname' => $request->input('fullname'),
            'gender' => $request->input('gender'),
            'dateofbirth' => $request->input('dateofbirth'),
            'religion' => $request->input('religion'),
            'denomination' => $request->input('denomination'),
            'placeofbirth' => $request->input('placeofbirth'),
            'nationality' => $request->input('nationality'),
            'hometown' => $request->input('hometown'),
            'region' => '',
            'disability' => $request->input('disability'),
            'postcode' => $request->input('postcode'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'phone' => $request->input('mobile'),
            'maritalstutus' => $request->input('maritalstatus'),
            'entrylevel' => $request->input('entrylevel'),
            'currentlevel' => $request->input('entrylevel'),
            'session' => $request->input('session'),
            'programme' => $name,
            'type' => $type,
            'indexnumber' => $indexnumber,
            'gurdianname' => $request->input('guidianfullname'),
            'relationship' => $request->input('relationship'),
            'occupation' => $request->input('guidianoccupation'),
            'mobile' => $request->input('mobnumber'),
            'employed' => $request->input('employed'),
            'status' => 1,
            'academic_year' => $academic->acdemicyear,
            'admitted' => 'AUG,' . date('Y'),
            'completion' => 'AUG' . $duration,
            'progcode' => $code,
            'duration' => $duras,
        ];

        $studentinfos = new Studentinfo($data);
        $user->studentinfos()->save($studentinfos);

        $email = $request->input('email');
        $fullanem = $request->input('fullname');

        //SEND MAIL TO NEW STUDENT HERE
        Notification::route('mail', $email)
            ->notify(new NewstudentMail($fullanem, $regemail));
        //END MAIL HERE

        $textmsg = "Dear {$fullanem},Congratulations upon your admission. Have a nice stay with us, Your login credential to access the schools portal are: Email: {$regemail},password is the email address you provided during registration";

        return Redirect()->back()->with('message', 'Student Registered Successfully!');
    }
}
