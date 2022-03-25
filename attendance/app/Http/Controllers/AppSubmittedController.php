<?php

namespace App\Http\Controllers;

use App\Academicyear;
use App\Admissionapproveinfo;
use App\Applicationinfo;
use App\Guardianinfo;
use App\Notifications\Admissionapprove;
use App\Notifications\Disapproveddmission;
use App\Notifications\NewstudentMail;
use App\Notifications\NewstudentrevertMail;
use App\Personalinfo;
use App\Programme;
use App\Result;
use App\Studentinfo;
use App\Supportingdoc;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use FPDF as pdfs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AppSubmittedController extends Controller
{
    public function index()
    {
        $academicyear = Academicyear::where('status', 1)->first();

        $peronalinfo = Personalinfo::with('applicationinfo')
            ->withCount(['results as grade' => function ($query) {
            $query->select(\DB::raw('sum(grad1 + grad2 + grad3 + grad4 + grad5 + grad6)'));
        }])
            ->where('status', '1')
            ->where('year', $academicyear->acdemicyear)
            ->orderBy('grade', 'asc')->get();

        //dd($peronalinfo);
        return view('admissionsubmitted.online_admission', ['peronalinfo' => $peronalinfo, 'academicyear'=> $academicyear]);
    }

    public function admission_all()
    {
        $academicyear = Academicyear::where('status', 1)->first();

        $peronalinfo = Personalinfo::with('applicationinfo')
            ->withCount(['results as grade' => function ($query) {
            $query->select(\DB::raw('sum(grad1 + grad2 + grad3 + grad4 + grad5 + grad6)'));
        }])
            ->where('status', '1')
            ->where('year', $academicyear->acdemicyear)
            ->orderBy('grade', 'asc');

        return Datatables::of($peronalinfo)
            ->addColumn('action', function ($user) {
            if (1 == $user->approve) {
                return '<a href="/LatestAdmission/admission-all-view/' . $user->osncode_id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>';
            }

            return '<a href="/LatestAdmission/admission-all-view/' . $user->osncode_id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>';
        })
            ->addColumn('status', function ($user) {
            if (1 == $user->approve) {
                return 'Approved <span class="badge badge-light">Approved</span>';
            }

            return 'Processing...';
        })
            ->addColumn('grade', function ($user) {
            return Result::where('osncode_id', $user->osncode_id)
                ->select(\DB::raw('sum(grad1 + grad2 + grad3 + grad4 + grad5 +grad6) as total'))->get();
        })
            ->editColumn('firstnames', function ($model) {
            return $model->surname . ' ' . $model->firstnames . ' ' . $model->middlename;
        })
            ->make(true);
    }

    public function admission_view($id)
    {
        $person = Personalinfo::where('osncode_id', $id)->first();
        $appinfo = Applicationinfo::where('osncode_id', $id)->first();

        $result1 = Result::where('resulttype', 'result1')
            ->where('osncode_id', $id)->first();

        $result2 = Result::where('resulttype', 'result2')
            ->where('osncode_id', $id)->first();

        $result3 = Result::where('resulttype', 'result3')
            ->where('osncode_id', $id)->first();

        $gurdian = Guardianinfo::where('osncode_id', $id)->first();

        $support = Supportingdoc::where('osncode_id', $id)->get();

        return view('admissionsubmitted.admission_details_view', [
            'personal' => $person,
            'appinfo' => $appinfo,
            'result1' => $result1,
            'result2' => $result2,
            'result3' => $result3,
            'gurdian'=>$gurdian,
            'supportdoc' => $support,
        ]);
    }

    public function admission_update_program(Request $Request)
    {
        if ($Request->ajax()) {
            $id = $Request->post('cid');
            $prog = $Request->post('prog');

            //update programme duration,so get the programme
            $progs = Programme::where('name', $prog)->first();

            $appinfo = Applicationinfo::where('osncode_id', $id)->first();
            $appinfo->programme = $prog;
            $appinfo->duration = $progs->duration;
            $appinfo->type = $progs->type;
            $appinfo->save();

            $msg = 'Programme Updated Successfully!';

            return response()->json(['msg'=> $msg], 200);
        }
    }

    public function admission_modal_show(Request $Request)
    {
        $id = $Request->get('cid');
        $appinfo = Applicationinfo::with('personalinfo')->where('osncode_id', $id)->first();

        return view('admissionsubmitted.admission-modal', ['appinfo' => $appinfo, 'id' => $id]);
    }

    public function admission_approve_admission(Request $Request)
    {
        if ($Request->ajax()) {
            $id = $Request->post('cid');
            $adstus = $Request->post('status');

            //check if post value is 1 0r 0
            if (1 == $adstus) {
                $ssession = $Request->post('session');

                $improg = explode('-', $Request->post('prog'));

                $sprog = $improg[0];
                $sprogcode = $improg[1];

                $prog = Programme::where('code', trim($sprogcode))->first();

                $academic = Academicyear::where('status', 1)->first();
                $appinfo = Applicationinfo::where('osncode_id', $id)->first();

                //get programme code

                $appinfo->session = $ssession;
                $appinfo->programme = $sprog;
                $appinfo->duration = $prog->duration;
                $appinfo->type = $prog->type;
                $appinfo->save();
                //value is 1
                if (null != $appinfo->programme) {
                    if (1 == $adstus) {
                        //approve
                        //check if approved
                        $status = Personalinfo::where('approve', 1)
                            ->where('osncode_id', $id)->first();
                        if ($status) {
                            //admission approved
                            $msg = 'Admission Has Already been Approved!';

                            return response()->json(['msg'=> $msg], 200);
                        }
                        //approve it now
                        $approve = Personalinfo::where('osncode_id', $id)->first();
                        $approve->approve = 1;
                        $approve->save();

                        $gurdian = Guardianinfo::where('osncode_id', $id)->first();

                        $title = $approve->title;
                        $fullname = $approve->surname . ' ' . $approve->middlename . ' ' . $approve->firstnames;
                        $gender = $approve->gender;
                        $dateofbirth = $approve->dateofbirth;
                        $religion = $approve->religion;
                        $denomination = $approve->denomination;
                        $placeofbirth = $approve->placeofbirth;
                        $nationality = $approve->nationality;
                        $hometown = $approve->hometown;
                        $region = $approve->region;
                        $disability = $approve->disability;
                        $postcode = $approve->postcode;
                        $address = $approve->address;
                        $email = $approve->email;
                        $phone = $approve->phone;
                        $maritalstutus = $approve->maritalstutus;
                        $entrylevel = $appinfo->entrylevel;
                        $session = $appinfo->session;
                        $programme = $prog->name;
                        $currentlevel = $entrylevel;
                        $indexnumber = $appinfo->indexnumber;
                        $gurdianname = $gurdian->gurdianname;
                        $relationshp = $gurdian->relationshp;
                        $occupation = $gurdian->occupation;
                        $mobile = $gurdian->mobile;
                        $employed = $gurdian->employed;
                        $status = 0;
                        $type = $appinfo->type;

                        $admitted = 'AUG,' . date('Y');
                        $duration = $appinfo->duration;
                        $endyear = date('Y') + $duration;

                        $regemail = strtolower($indexnumber) . '@osms.edu.com';
                        //create user
                        $user = User::create([
                                'name' => $fullname,
                                'email' => $regemail,
                                'indexnumber'=> $indexnumber,
                                'regemail' => $email,
                                'pro_pic'=> $approve->profileimg,
                                'password' => Hash::make($email),
                            ]);

                        $data = [
                                'title' => $title,
                                'fullname'=>$fullname,
                                'gender'=>$gender,
                                'dateofbirth'=>$dateofbirth,
                                'religion'=>$religion,
                                'denomination'=>$denomination,
                                'placeofbirth'=>$placeofbirth,
                                'nationality'=>$nationality,
                                'hometown'=>$hometown,
                                'region'=>$region,
                                'disability'=>$disability,
                                'postcode'=>$postcode,
                                'address'=>$address,
                                'email'=>$email,
                                'phone'=>$phone,
                                'maritalstutus'=>$maritalstutus,
                                'entrylevel'=>$entrylevel,
                                'session'=>$session,
                                'programme'=>$programme,
                                'progcode' => $prog->code,
                                'type'=> $prog->type,
                                'currentlevel'=>$currentlevel,
                                'indexnumber'=>$indexnumber,
                                'gurdianname'=>$gurdianname,
                                'relationship'=>$relationshp,
                                'occupation'=>$occupation,
                                'mobile' =>$mobile,
                                'employed'=>$employed,
                                'status'=> 0,
                                'academic_year' => $academic->acdemicyear,
                                'admitted' => $admitted,
                                'completion'=> 'AUG,' . $endyear,
                                'duration' => $duration,
                            ];

                        $studentinfos = new Studentinfo($data);
                        $user->studentinfos()->save($studentinfos);

                        $admissfile = Admissionapproveinfo::latest()->first();

                        $fullpath = asset('storage') . '/' . $admissfile->file;

                        //send Email or text message to notify user of Admission Approved
                        $user->notify(new Admissionapprove($fullname, $currentlevel, $programme, $session, $fullpath));

                        //send notification to use of admission approved
                        $msg = 'Admission Approved! Successfully';

                        return response()->json(['msg'=> $msg], 200);
                    }
                    //disapprove
                    //check if there is a data here

                    //disapprove admission
                    $approve = Personalinfo::where('osncode_id', $id)->first();
                    $approve->approve = 0;
                    $approve->save();

                    //delete user for database
                    $appinfo = Applicationinfo::where('osncode_id', $id)->first();
                    $user = User::where('indexnumber', $appinfo->indexnumber)->first();
                    $user->delete();

                    //delete student information as well
                    $studentinfos = Studentinfo::where('indexnumber', $appinfo->indexnumber)->first();
                    $studentinfos->delete();

                    $fullname = $approve->surname . ' ' . $approve->middlename . ' ' . $approve->firstnames;

                    $email = $approve->email;

                    //notify user of revoked admission
                    Notification::route('mail', $email)
                        ->notify(new Disapproveddmission($fullname));

                    //notify user of disapproved success
                    $msg = 'Admission Revoked Successfully!';

                    return response()->json(['msg'=> $msg], 200);
                }
                $msg = 'Please Approve Programme Before Approving Admission Requests!';

                return response()->json(['error'=> $msg], 200);
            }
            //value is 0
            //check if there is a data here

            //disapprove admission
            $approve = Personalinfo::where('osncode_id', $id)->first();
            $approve->approve = 0;
            $approve->save();

            //delete user for database
            $appinfo = Applicationinfo::where('osncode_id', $id)->first();

            $user = User::where('indexnumber', $appinfo->indexnumber)->delete();

            //delete student information as well
            $studentinfos = Studentinfo::where('indexnumber', $appinfo->indexnumber)->delete();

            $fullname = $approve->surname . ' ' . $approve->middlename . ' ' . $approve->firstnames;

            $email = $approve->email;
            //notify user of revoked admission
            Notification::route('mail', $email)
                ->notify(new Disapproveddmission($fullname));

            //notify user of disapproved success
            $msg = 'Admission Revoked Successfully!';

            return response()->json(['msg'=> $msg], 200);
        }
    }

    public function admission_all_level100()
    {
        $academicyear = Academicyear::where('status', 1)->first();

        $peronalinfo = Personalinfo::with('applicationinfo')
            ->withCount(['results as grade' => function ($query) {
            $query->select(\DB::raw('sum(grad1 + grad2 + grad3 + grad4 + grad5 + grad6)'));
        }])
            ->where('status', '1')
            ->where('year', $academicyear->acdemicyear)
            ->whereHas('applicationinfo', function ($query) {
            $query->where('entrylevel', 'Level 100');
        })
            ->orderBy('grade', 'asc')->get();

        return view('admissionsubmitted.online_admission_level_1', ['peronalinfo' => $peronalinfo, 'academicyear'=> $academicyear]);
    }

    public function admission_all_level1()
    {
        $academicyear = Academicyear::where('status', 1)->first();
        $peronalinfo = Personalinfo::join('applicationinfos', 'personalinfos.osncode_id', '=', 'applicationinfos.osncode_id')
            ->select(['personalinfos.id', 'personalinfos.osncode_id', 'personalinfos.firstnames', 'personalinfos.surname', 'personalinfos.middlename', 'personalinfos.gender', 'personalinfos.email', 'personalinfos.phone', 'personalinfos.profileimg', 'personalinfos.approve', 'applicationinfos.entrylevel', 'applicationinfos.session', 'applicationinfos.firstchoice', 'personalinfos.year', 'applicationinfos.secondchoice', 'applicationinfos.thirdchoice', 'applicationinfos.programme'])
            ->where('status', '1')
            ->where('year', $academicyear->acdemicyear)
            ->where('applicationinfos.entrylevel', 'Level 100');

        return Datatables::of($peronalinfo)
            ->addColumn('action', function ($user) {
            if (1 == $user->approve) {
                return '<a href="/LatestAdmission/admission-all-view/' . $user->osncode_id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a> | <span class="badge badge-light">Approved</span';
            }

            return '<a href="/LatestAdmission/admission-all-view/' . $user->osncode_id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>';
        })
            ->editColumn('firstnames', function ($model) {
            return $model->surname . ' ' . $model->firstnames . ' ' . $model->middlename;
        })
            ->make(true);
    }

    public function admission_all_level100_app()
    {
        $academicyear = Academicyear::where('status', 1)->first();

        $peronalinfo = Personalinfo::with('applicationinfo')
            ->withCount(['results as grade' => function ($query) {
            $query->select(\DB::raw('sum(grad1 + grad2 + grad3 + grad4 + grad5 + grad6)'));
        }])
            ->where('status', '1')
            ->where('approve', '1')
            ->where('year', $academicyear->acdemicyear)
            ->whereHas('applicationinfo', function ($query) {
            $query->where('entrylevel', 'Level 100');
        })
            ->orderBy('grade', 'asc')->get();

        return view('admissionsubmitted.online_admission_level1_app', ['peronalinfo' => $peronalinfo, 'academicyear'=> $academicyear]);
    }

    public function admission_all_level1_app()
    {
        $academicyear = Academicyear::where('status', 1)->first();
        $peronalinfo = Personalinfo::join('applicationinfos', 'personalinfos.osncode_id', '=', 'applicationinfos.osncode_id')
            ->select(['personalinfos.id', 'personalinfos.osncode_id', 'personalinfos.firstnames', 'personalinfos.surname', 'personalinfos.middlename', 'personalinfos.gender', 'personalinfos.email', 'personalinfos.phone', 'personalinfos.profileimg', 'applicationinfos.entrylevel', 'applicationinfos.session', 'applicationinfos.firstchoice', 'personalinfos.year', 'applicationinfos.secondchoice', 'applicationinfos.thirdchoice', 'applicationinfos.programme'])
            ->where('status', '1')
            ->where('approve', '1')
            ->where('year', $academicyear->acdemicyear)
            ->where('applicationinfos.entrylevel', 'Level 100');

        return Datatables::of($peronalinfo)
            ->addColumn('action', function ($user) {
            return '<a href="/LatestAdmission/admission-all-view/' . $user->osncode_id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>';
        })
            ->editColumn('firstnames', function ($model) {
            return $model->surname . ' ' . $model->firstnames . ' ' . $model->middlename;
        })
            ->make(true);
    }

    //level 200

    public function admission_all_level200()
    {
        $academicyear = Academicyear::where('status', 1)->first();

        $peronalinfo = Personalinfo::with('applicationinfo')
            ->withCount(['results as grade' => function ($query) {
            $query->select(\DB::raw('sum(grad1 + grad2 + grad3 + grad4 + grad5 + grad6)'));
        }])
            ->where('status', '1')
            ->where('year', $academicyear->acdemicyear)
            ->whereHas('applicationinfo', function ($query) {
            $query->where('entrylevel', 'Level 200');
        })
            ->orderBy('grade', 'asc')->get();

        return view('admissionsubmitted.online_admission_level_2', ['peronalinfo' => $peronalinfo, 'academicyear'=> $academicyear]);
    }

    public function admission_all_level2()
    {
        $academicyear = Academicyear::where('status', 1)->first();
        $peronalinfo = Personalinfo::join('applicationinfos', 'personalinfos.osncode_id', '=', 'applicationinfos.osncode_id')
            ->select(['personalinfos.id', 'personalinfos.osncode_id', 'personalinfos.firstnames', 'personalinfos.surname', 'personalinfos.middlename', 'personalinfos.gender', 'personalinfos.email', 'personalinfos.phone', 'personalinfos.profileimg', 'personalinfos.approve', 'applicationinfos.entrylevel', 'applicationinfos.session', 'applicationinfos.firstchoice', 'personalinfos.year', 'applicationinfos.secondchoice', 'applicationinfos.thirdchoice', 'applicationinfos.programme'])
            ->where('status', '1')
            ->where('year', $academicyear->acdemicyear)
            ->where('applicationinfos.entrylevel', 'Level 200');

        return Datatables::of($peronalinfo)
            ->addColumn('action', function ($user) {
            if (1 == $user->approve) {
                return '<a href="/LatestAdmission/admission-all-view/' . $user->osncode_id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a> | <span class="badge badge-light">Approved</span';
            }

            return '<a href="/LatestAdmission/admission-all-view/' . $user->osncode_id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>';
        })
            ->editColumn('firstnames', function ($model) {
            return $model->surname . ' ' . $model->firstnames . ' ' . $model->middlename;
        })
            ->make(true);
    }

    public function admission_all_level200_app()
    {
        $academicyear = Academicyear::where('status', 1)->first();

        $peronalinfo = Personalinfo::with('applicationinfo')
            ->withCount(['results as grade' => function ($query) {
            $query->select(\DB::raw('sum(grad1 + grad2 + grad3 + grad4 + grad5 + grad6)'));
        }])
            ->where('status', '1')
            ->where('approve', '1')
            ->where('year', $academicyear->acdemicyear)
            ->whereHas('applicationinfo', function ($query) {
            $query->where('entrylevel', 'Level 200');
        })
            ->orderBy('grade', 'asc')->get();

        return view('admissionsubmitted.online_admission_level2_app', ['peronalinfo' => $peronalinfo, 'academicyear'=> $academicyear]);
    }

    public function admission_all_level2_app()
    {
        $academicyear = Academicyear::where('status', 1)->first();
        $peronalinfo = Personalinfo::join('applicationinfos', 'personalinfos.osncode_id', '=', 'applicationinfos.osncode_id')
            ->select(['personalinfos.id', 'personalinfos.osncode_id', 'personalinfos.firstnames', 'personalinfos.surname', 'personalinfos.middlename', 'personalinfos.gender', 'personalinfos.email', 'personalinfos.phone', 'personalinfos.profileimg', 'applicationinfos.entrylevel', 'applicationinfos.session', 'applicationinfos.firstchoice', 'personalinfos.year', 'applicationinfos.secondchoice', 'applicationinfos.thirdchoice', 'applicationinfos.programme'])
            ->where('status', '1')
            ->where('approve', '1')
            ->where('year', $academicyear->acdemicyear)
            ->where('applicationinfos.entrylevel', 'Level 200');

        return Datatables::of($peronalinfo)
            ->addColumn('action', function ($user) {
            return '<a href="/LatestAdmission/admission-all-view/' . $user->osncode_id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>';
        })
            ->editColumn('firstnames', function ($model) {
            return $model->surname . ' ' . $model->firstnames . ' ' . $model->middlename;
        })
            ->make(true);
    }

    //level 300

    //level 200

    public function admission_all_level300()
    {
        $academicyear = Academicyear::where('status', 1)->first();

        $peronalinfo = Personalinfo::with('applicationinfo')
            ->withCount(['results as grade' => function ($query) {
            $query->select(\DB::raw('sum(grad1 + grad2 + grad3 + grad4 + grad5 + grad6)'));
        }])
            ->where('status', '1')
            ->where('year', $academicyear->acdemicyear)
            ->whereHas('applicationinfo', function ($query) {
            $query->where('entrylevel', 'Level 200');
        })
            ->orderBy('grade', 'asc')->get();

        return view('admissionsubmitted.online_admission_level_3', ['peronalinfo' => $peronalinfo, 'academicyear'=> $academicyear]);
    }

    public function admission_all_level3()
    {
        $academicyear = Academicyear::where('status', 1)->first();
        $peronalinfo = Personalinfo::join('applicationinfos', 'personalinfos.osncode_id', '=', 'applicationinfos.osncode_id')
            ->select(['personalinfos.id', 'personalinfos.osncode_id', 'personalinfos.firstnames', 'personalinfos.surname', 'personalinfos.middlename', 'personalinfos.gender', 'personalinfos.email', 'personalinfos.phone', 'personalinfos.profileimg', 'personalinfos.approve', 'applicationinfos.entrylevel', 'applicationinfos.session', 'applicationinfos.firstchoice', 'personalinfos.year', 'applicationinfos.secondchoice', 'applicationinfos.thirdchoice', 'applicationinfos.programme'])
            ->where('status', '1')
            ->where('year', $academicyear->acdemicyear)
            ->where('applicationinfos.entrylevel', 'Level 300');

        return Datatables::of($peronalinfo)
            ->addColumn('action', function ($user) {
            if (1 == $user->approve) {
                return '<a href="/LatestAdmission/admission-all-view/' . $user->osncode_id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a> | <span class="badge badge-light">Approved</span';
            }

            return '<a href="/LatestAdmission/admission-all-view/' . $user->osncode_id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>';
        })
            ->editColumn('firstnames', function ($model) {
            return $model->surname . ' ' . $model->firstnames . ' ' . $model->middlename;
        })
            ->make(true);
    }

    public function admission_all_level300_app()
    {
        $academicyear = Academicyear::where('status', 1)->first();

        $peronalinfo = Personalinfo::with('applicationinfo')
            ->withCount(['results as grade' => function ($query) {
            $query->select(\DB::raw('sum(grad1 + grad2 + grad3 + grad4 + grad5 + grad6)'));
        }])
            ->where('status', '1')
            ->where('approve', '1')
            ->where('year', $academicyear->acdemicyear)
            ->whereHas('applicationinfo', function ($query) {
            $query->where('entrylevel', 'Level 300');
        })
            ->orderBy('grade', 'asc')->get();

        return view('admissionsubmitted.online_admission_level3_app', ['peronalinfo' => $peronalinfo, 'academicyear'=> $academicyear]);
    }

    public function admission_all_level3_app()
    {
        $academicyear = Academicyear::where('status', 1)->first();
        $peronalinfo = Personalinfo::join('applicationinfos', 'personalinfos.osncode_id', '=', 'applicationinfos.osncode_id')
            ->select(['personalinfos.id', 'personalinfos.osncode_id', 'personalinfos.firstnames', 'personalinfos.surname', 'personalinfos.middlename', 'personalinfos.gender', 'personalinfos.email', 'personalinfos.phone', 'personalinfos.profileimg', 'applicationinfos.entrylevel', 'applicationinfos.session', 'applicationinfos.firstchoice', 'personalinfos.year', 'applicationinfos.secondchoice', 'applicationinfos.thirdchoice', 'applicationinfos.programme'])
            ->where('status', '1')
            ->where('approve', '1')
            ->where('year', $academicyear->acdemicyear)
            ->where('applicationinfos.entrylevel', 'Level 300');

        return Datatables::of($peronalinfo)
            ->addColumn('action', function ($user) {
            return '<a href="/LatestAdmission/admission-all-view/' . $user->osncode_id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>';
        })
            ->editColumn('firstnames', function ($model) {
            return $model->surname . ' ' . $model->firstnames . ' ' . $model->middlename;
        })
            ->make(true);
    }

    //confirm student Admsission
    public function admission_confirm_message()
    {
        $data = Admissionapproveinfo::latest()->get();

        return view('admissionsubmitted.message', ['data' => $data]);
    }

    public function admission_confirm_doc(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:pdf,docx,txt',
        ]);

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;

        $data = [
            'academicyear' => $year,
            'file' => $request->file('file')->store('AdmissionFile', 'public'),
        ];

        $new = new Admissionapproveinfo($data);
        $new->save();

        return Redirect()->back()->with('message', 'File Uploaded Successfully!');
    }

    public function admission_confirm_delete($id)
    {
        $new = Admissionapproveinfo::findorfail($id);
        $doc = $new->file;

        $storage = Storage::disk('public')->delete($doc);

        if ($storage) {
            $new->delete();
        }

        return Redirect()->back();
    }

    public function admission_confirm()
    {
        return view('admissionsubmitted.admission_confirm');
    }

    public function admission_confirm_students()
    {
        $academicyear = Academicyear::where('status', 1)->first();
        $peronalinfo = Personalinfo::join('applicationinfos', 'personalinfos.osncode_id', '=', 'applicationinfos.osncode_id')
            ->select(['personalinfos.id', 'personalinfos.osncode_id', 'personalinfos.firstnames', 'personalinfos.surname', 'personalinfos.middlename', 'personalinfos.gender', 'personalinfos.email', 'personalinfos.approve', 'personalinfos.phone', 'personalinfos.approved', 'personalinfos.profileimg', 'applicationinfos.entrylevel', 'applicationinfos.session', 'applicationinfos.indexnumber', 'applicationinfos.firstchoice', 'personalinfos.year', 'applicationinfos.secondchoice', 'applicationinfos.thirdchoice', 'applicationinfos.programme'])
            ->where('status', '1')
            ->where('year', $academicyear->acdemicyear)
            ->where('approve', '1');

        return Datatables::of($peronalinfo)
            ->addColumn('action', function ($user) {
            return '<a href="/LatestAdmission/admission-all-view/' . $user->osncode_id . '" class="btn btn-xs btn-primary" target="_blank"><i class="fa fa-eye"></i> View</a>';
        })
            ->editColumn('firstnames', function ($model) {
            return $model->surname . ' ' . $model->firstnames . ' ' . $model->middlename;
        })
            ->make(true);
    }

    public function admission_confirm_students_now(Request $Request)
    {
        $indexnumber = $Request->post('cid');
        $studentinfos = Studentinfo::where('indexnumber', $indexnumber)->first();
        if ($studentinfos) {
            $studentinfos->status = 1;
            //$studentinfos->admitted = 'Sat-Jun-2020 09:02:36';
            $studentinfos->save();

            $perso = Personalinfo::where('email', $studentinfos->email)->first();
            $perso->approved = 1;
            $perso->save();

            //add student role
            $user = User::where('indexnumber', $indexnumber)->first();
            $user->assignRole('Student');

            $regemail = $user->regemail;
            $email = $user->email;
            $fullname = $user->name;

            Notification::route('mail', $email)
                ->notify(new NewstudentMail($fullname, $regemail));

            $textmsg = "Dear {$fullname},Congratulations upon your admission. Have a nice stay with us, Your login credential to access the schools portal are: Email: {$regemail},password is the email address you provided during registration";

            //send login Test Message as well

            $msg = 'Student Admission Confirmed Successfully!';

            return response()->json(['msg'=> $msg], 200);
        }

        $msg = 'Something Went Wrong, Contact System Administrator';

        return response()->json(['error'=> $msg], 200);
    }

    public function admission_revert_students_now(Request $Request)
    {
        $indexnumber = $Request->post('cid');
        $studentinfos = Studentinfo::where('indexnumber', $indexnumber)->first();
        if ($studentinfos) {
            $studentinfos->status = 0;
            //$studentinfos->admitted = 'Sat-Jun-2020 09:02:36';
            $studentinfos->save();

            $perso = Personalinfo::where('email', $studentinfos->email)->first();
            $perso->approved = 0;
            $perso->save();

            //add student role
            $user = User::where('indexnumber', $indexnumber)->first();
            $user->removeRole('Student');

            $regemail = $user->regemail;
            $email = $user->email;
            $fullname = $user->name;

            Notification::route('mail', $email)
                ->notify(new NewstudentrevertMail($fullname, $regemail));

            $textmsg = "Dear {$fullname},Please your admission has been revocked due to certain reasons unknown to management, You will get an email to notify you if your admission is reconsidered by management. For more info, please visit the admission office for more info";

            //send login Test Message as well

            $msg = 'Student Admission Reverted Successfully!';

            return response()->json(['msg'=> $msg], 200);
        }

        $msg = 'Something Went Wrong, Contact System Administrator';

        return response()->json(['error'=> $msg], 200);
    }

    public function admission_confirm_letter($num)
    {
        // $studentinfos = Studentinfo::where('indexnumber', $num)->first();
        $user = User::with('studentinfos')
            ->where('indexnumber', $num)->first();

        $prog = Programme::where('code', $user->studentinfos->progcode)->first();

        $academicyear = Academicyear::where('status', 1)->first();

        $image = URL::to('images/logo.png');
        $pro = asset('storage') . '/' . $user->pro_pic;
        $back = URL::to('images/logo-back.png');

        $signature = URL::to('images/sign2.jpg');

        $this->fpdf = new pdfs();
        $this->fpdf->AliasNbPages();
        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->AddPage('P');
        $this->fpdf->centreImage($back);

        $this->fpdf->Cell(190, 5, 'Ogua School Management System', 0, 1, 'C');
        $this->fpdf->Cell(190, 10, 'Application Summary', 0, 1, 'C');
        $this->fpdf->Image($image, 10, 6, 30);
        $this->fpdf->Image($pro, 160, 6, 30);

        $this->fpdf->line(20, 45, 210 - 20, 45);

        $this->fpdf->Ln(22);

        $this->fpdf->SetFont('Arial', '', 8);
        $this->fpdf->Cell(190, 5, $user->studentinfos->fullname, 0, 1, 'L');
        $this->fpdf->Cell(190, 5, $user->studentinfos->address, 0, 1, 'L');
        $this->fpdf->Cell(190, 5, $user->studentinfos->region, 0, 1, 'L');
        $this->fpdf->Ln(5);

        $print = explode(' ', $user->studentinfos->fullname);
        $name = $print[0];
        $this->fpdf->Cell(190, 5, 'Dear ' . $user->studentinfos->title . ' ' . $name . ',', 0, 1, 'L');
        $this->fpdf->Ln(3);
        $this->fpdf->Cell(50, 5, 'Offer Of Admission', 'B', 1, 'L');
        $this->fpdf->Ln(3);
        $this->fpdf->MultiCell(190, 3, 'We are pleased to offer you admission to the Univeristy of Ogua School Management System. to Purpue a ' . $prog->duration . ' Years ' . $user->studentinfos->programme . 'programme starting from the ' . $academicyear->acdemicyear . ' academic year as Follows:', 0, 'J', 0, 4);

        $this->fpdf->Ln(5);

        $this->fpdf->MultiCell(190, 3, 'You are admitted to ' . $user->studentinfos->entrylevel . ' of the ' . $user->studentinfos->session, 0, 'J', 0, 4);

        $this->fpdf->Ln(5);

        $this->fpdf->MultiCell(190, 3, 'Your Index Number is ' . $user->studentinfos->indexnumber, 0, 'J', 0, 4);

        $this->fpdf->Ln(5);

        $this->fpdf->MultiCell(190, 3, 'You will be affppated to ( Hall Name )', 0, 'J', 0, 4);
        $this->fpdf->Ln(5);

        $this->fpdf->MultiCell(190, 3, 'The ' . $academicyear->acdemicyear . ' academic year commerce on Monday 11th, August, ' . date('Y'), 0, 'J', 0, 4);
        $this->fpdf->Ln(5);

        $this->fpdf->MultiCell(190, 3, 'You are expected to report for the semester course registeration and participate fully in an orientation programme for all fresh students. Originals of certificate used to gain admission will be inspected before registration is completed', 0, 'J', 0, 4);
        $this->fpdf->Ln(5);

        $this->fpdf->MultiCell(190, 3, 'The official dates for registration, orientation and commercement of lecturers are clearly stated on the programme of Acticities for fresh students attached to this letter.', 0, 'J', 0, 4);
        $this->fpdf->Ln(5);

        $this->fpdf->MultiCell(190, 3, 'The offer is based on available information that you have satisfied the entry requirements for the above programme of study. You will be summarily dismissed in the event that the information provided is found to be false at any time in the course of your study. it is important to also note that all students are considered to be on probation for the entire duration of their programme and may be dismissed or withdrawn from the University for misconduct or unsatisfactory academic work.', 0, 'J', 0, 4);
        $this->fpdf->Ln(5);

        $this->fpdf->MultiCell(190, 3, 'Please confirm your acceptance of our offer by paying the appropriate non-refundable initial payment of the total bill for the academic year as per the fee schedule for fresh students. the dead Line for payment is friday, ' . date('m-d-Y'), 0, 'J', 0, 4);
        $this->fpdf->Ln(5);

        $this->fpdf->MultiCell(190, 3, 'In accepting this offer, you are required to fully comply with all the directives given in the Guidpnes for fresh students (Regulations, Programme of Activities and fee Schedule for Fresh Students) attached to this letter. Failure to comply shall lead to the revocation or forfeiture of your admission.', 0, 'J', 0, 4);
        $this->fpdf->Ln(5);

        $this->fpdf->MultiCell(190, 3, 'You are thus, welcome to the OSMS. Please accept my congratulations upon your admission.', 0, 'J', 0, 4);

        $this->fpdf->Ln(5);
        $this->fpdf->Cell(50, 5, 'Yours sincerely', 0, 1, 'L');
        $this->fpdf->Cell(50, 5, 'Ahmed Amartei Kudjoe', 0, 1, 'L');
        $this->fpdf->Cell(50, 5, 'Director, Academic Affairs', 0, 1, 'L');
        $this->fpdf->Cell(50, 5, 'For: REGISTRAR', 0, 1, 'L');

        return response($this->fpdf->Output('D', 'Appointment-letter.pdf'))
            ->header('Content-Type', 'application/pdf');

        //dd($user->studentinfos->fullname);

        // $pdf = PDF::
        // loadView('admissionsubmitted.admission_confirm_appointment',
        // 	['user'=> $user, 'prog' => $prog, 'academicyear' => $academicyear]);
        // return $pdf->stream('Appointment-Letter.pdf');

        return view('admissionsubmitted.admission_confirm_appointment', ['user'=> $user, 'prog' => $prog, 'academicyear' => $academicyear]);
    }

    public function admission_confirm_all()
    {
        $studentinfos = Studentinfo::where('status', 1)->get();

        return view('admissionsubmitted.admission_confirmed_all');
    }

    public function admission_confirm_all_data()
    {
        $academicyear = Academicyear::where('status', 1)->first();
        $peronalinfo = Studentinfo::join('users', 'users.id', '=', 'studentinfos.user_id')
            ->select(
                ['studentinfos.id', 'studentinfos.fullname', 'studentinfos.gender', 'studentinfos.entrylevel', 'studentinfos.academic_year', 'users.pro_pic as profileimg', 'studentinfos.indexnumber', 'studentinfos.session', 'studentinfos.programme', 'studentinfos.user_id']
            )
            ->where('status', '1')
            ->where('academic_year', $academicyear->acdemicyear);

        return Datatables::of($peronalinfo)
            ->addColumn('action', function ($user) {
            return '<a href="/Allstudents/student-information-view/' . $user->id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>';
        })
            ->make(true);
    }

    public function admission_unconfirm_all()
    {
        $studentinfos = Studentinfo::where('status', 1)->get();

        return view('admissionsubmitted.admission_unconfirmed_all');
    }

    public function admission_unconfirm_all_data()
    {
        $academicyear = Academicyear::where('status', 1)->first();
        $peronalinfo = Studentinfo::join('users', 'users.id', '=', 'studentinfos.user_id')
            ->select(
                ['studentinfos.id', 'studentinfos.fullname', 'studentinfos.gender', 'studentinfos.entrylevel', 'studentinfos.academic_year', 'users.pro_pic as profileimg', 'studentinfos.indexnumber', 'studentinfos.session', 'studentinfos.programme']
            )
            ->where('status', '0')
            ->where('academic_year', $academicyear->acdemicyear);

        return Datatables::of($peronalinfo)
            ->addColumn('action', function ($user) {
            return '<a href="/LatestAdmission/admission-all-view/' . $user->id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>';
        })
            ->make(true);
    }
}
