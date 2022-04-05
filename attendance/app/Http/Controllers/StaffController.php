<?php

namespace App\Http\Controllers;

use App\Attendamce;
use App\Course;
use App\Faculty;
use App\LecCource;
use App\Payroll;
use App\Staff;
use App\Staffdoc;
use App\Staffleave;
use App\User;
use DB;
use Exception;
use FPDF as pdfs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Response;
use URL;

class StaffController extends Controller
{
    public function addstaff()
    {
        $courses = Course::all();
        $faculty = Faculty::all();
        $role = DB::table('roles')->get();
        //dd($role);
        return view('Staff.add_staff', ['courses' => $courses, 'roles' => $role, 'faculty' => $faculty]);
    }

    public function savestaff(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'faculty' => 'required',
            'dateofbirth' => 'required',
            'religion' => 'required',
            'mobile' => 'required|min:10',
            'email' => 'required|email',
            'mstatus' => 'required',
            'wrkexperience' => 'required',
            'qualification' => 'required',
            'address' => 'required',
            'image' => 'required',
            'grade' => 'required',
            'salary' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $role = $request->input('role');

            if ('Lecturer' == $role) {
                $maxcode = DB::table('users')->where('indexnumber', 'like', '%LEC%')->max('indexnumber');
                if ($maxcode) {
                    $max = (int) substr($maxcode, 3);
                    $number = $max + 1;
                    $code = 'LEC' . $number;
                } else {
                    $code = 'LEC1019330';
                }
            } else {
                $maxcode = DB::table('users')->where('indexnumber', 'like', '%OSMS%')->max('indexnumber');
                if ($maxcode) {
                    $max = (int) substr($maxcode, 3);
                    $number = $max + 1;
                    $code = 'LEC' . $number;
                } else {
                    $code = 'LEC1037870';
                }
            }

            $regemail = strtolower($code) . '@osms.edu.com';

            $user = User::create([
                'name' => $request->input('fullname'),
                'email' => $regemail,
                'regemail' => $request->input('email'),
                'indexnumber' => $code,
                'pro_pic' => $request->file('image')->store('profileimage', 'public'),
                'password' => Hash::make($request->input('email')),
            ]);

            $user->assignRole($role);

            if ($request->has('otherdocs')) {
                $otherdocs = $request->file('otherdocs');
                $filecount = \count($otherdocs);

                foreach ($otherdocs as $file) {
                    $name = $file->getClientOriginalName();
                    $staffdata = [
                        'user_id' => $user->id,
                        'title' => $file->getFilename(),
                        'doc' => $file->move('StaffDoc', $name),
                    ];

                    $staffdoc = new Staffdoc($staffdata);
                    $staffdoc->save();
                }
            }

            $data = [
                'user_id' => $user->id,
                'role' => $request->input('role'),
                'fullname' => $request->input('fullname'),
                'dateofbirth' => $request->input('dateofbirth'),
                'address' => $request->input('address'),
                'faculty' => $request->input('faculty'),
                'gender' => $request->input('gender'),
                'religion' => $request->input('religion'),
                'qualification' => $request->input('qualification'),
                'number' => $request->input('mobile'),
                'fathername' => $request->input('fname'),
                'mothername' => $request->input('mname'),
                'maritalstatus' => $request->input('mstatus'),
                'workexperience' => $request->input('wrkexperience'),
                'eployid' => $code,
                'salarygrade' => $request->input('grade'),
                'salary' => $request->input('salary'),
                'acctitle' => $request->input('acctitle'),
                'accnum' => $request->input('accnumber'),
                'bankname' => $request->input('bankname'),
                'bankbranch' => $request->input('branch'),
            ];

            $staff = new Staff($data);
            $staff->save();
            $lecid = $staff->user_id;

            if ($request->has('resume')) {
                $staff->resumedoc = $request->file('resume')->store('Resume', 'public');
                $staff->save();
            }

            if ('Lecturer' == $role) {
                $courses = $request->input('courses');

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
            }

            DB::commit();

            return Redirect()->back()->with('message', 'Staff Added Successfully');
        } catch (Exception $e) {
            DB::rollback();

            return Redirect()->back()->with('message', 'Failed, Try again Later');
        }
    }

    public function editStaff($id)
    {
        $courses = Course::all();
        $faculty = Faculty::all();
        $role = DB::table('roles')->get();
        $staff = Staff::findorfail($id);
        $lectcorse = LecCource::where('lecturer_id', $staff->user_id)->get();
        $users = DB::table('users')->where('indexnumber', 'not like', '%GES%')->get();

        return view('Staff.editStaff', ['staff' => $staff, 'user' => $users, 'courses' => $courses, 'roles' => $role, 'faculty' => $faculty, 'leccources' => $lectcorse, 'lectid' => $staff->user_id]);
    }

    public function update_staff_info(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'faculty' => 'required',
            'dateofbirth' => 'required',
            'religion' => 'required',
            'mobile' => 'required|min:10',
            'email' => 'required|email',
            'mstatus' => 'required',
            'wrkexperience' => 'required',
            'qualification' => 'required',
            'address' => 'required',
            'grade' => 'required',
            'salary' => 'required',
        ]);

        //dd($request);

        $user_id = $request->post('user_id');
        $staff_id = $request->post('hiddenid');

        $user = User::findorfail($user_id);
        $user->name = $request->input('fullname');
        $user->regemail = $request->input('email');

        if ($request->has('image')) {
            $image = $user->pro_pic;
            $storage = Storage::disk('public')->delete($image);
            $user->pro_pic = $request->file('image')->store('profileimage', 'public');
        }
        $user->save();

        //docs
        if ($request->has('otherdocs')) {
            $otherdocs = $request->file('otherdocs');
            $filecount = \count($otherdocs);

            if ($filecount > 0) {
                foreach ($otherdocs as $file) {
                    $name = $file->getClientOriginalName();
                    $staffdata = [
                        'user_id' => $user->id,
                        'title' => $file->getFilename(),
                        'doc' => $file->move('StaffDoc', $name),
                    ];

                    $staffdoc = new Staffdoc($staffdata);
                    $staffdoc->save();
                }
            }
        }

        //staff

        if ($request->has('resume')) {
            $data = [
                'fullname' => $request->input('fullname'),
                'dateofbirth' => $request->input('dateofbirth'),
                'address' => $request->input('address'),
                'faculty' => $request->input('faculty'),
                'gender' => $request->input('gender'),
                'religion' => $request->input('religion'),
                'qualification' => $request->input('qualification'),
                'number' => $request->input('mobile'),
                'fathername' => $request->input('fname'),
                'mothername' => $request->input('mname'),
                'maritalstatus' => $request->input('mstatus'),
                'workexperience' => $request->input('wrkexperience'),
                'salarygrade' => $request->input('grade'),
                'salary' => $request->input('salary'),
                'acctitle' => $request->input('acctitle'),
                'accnum' => $request->input('accnumber'),
                'bankname' => $request->input('bankname'),
                'bankbranch' => $request->input('branch'),
                'resumedoc' => $request->file('resume')->store('Resume', 'public'),
            ];
        } else {
            $data = [
                'fullname' => $request->input('fullname'),
                'dateofbirth' => $request->input('dateofbirth'),
                'address' => $request->input('address'),
                'faculty' => $request->input('faculty'),
                'gender' => $request->input('gender'),
                'religion' => $request->input('religion'),
                'qualification' => $request->input('qualification'),
                'number' => $request->input('mobile'),
                'fathername' => $request->input('fname'),
                'mothername' => $request->input('mname'),
                'maritalstatus' => $request->input('mstatus'),
                'workexperience' => $request->input('wrkexperience'),
                'salarygrade' => $request->input('grade'),
                'salary' => $request->input('salary'),
                'acctitle' => $request->input('acctitle'),
                'accnum' => $request->input('accnumber'),
                'bankname' => $request->input('bankname'),
                'bankbranch' => $request->input('branch'),
            ];
        }

        $staff = Staff::findorfail($staff_id)->update($data);

        return Redirect()->back()->with('message', 'Staff Info Updated Successfully');
    }

    public function allStaff()
    {
        $staff = Staff::latest()->get();
        $users = DB::table('users')->where('indexnumber', 'not like', '%GES%')->get();

        return view('Staff.all_staff', ['staff' => $staff, 'user' => $users]);
    }

    public function Staffprofile()
    {
        $staff = User::with('staff')->where('id', auth()->user()->id)->first();

        if (!isset($staff->staff)) {
            return Redirect()->back();
        }

        $staffdoc = Staffdoc::where('user_id', auth()->user()->id)->get();

        $lectcorse = LecCource::where('lecturer_id', auth()->user()->id)->get();

        $courses = Course::all();

        $attendance = Attendamce::where('user_id', auth()->user()->id)
            ->where('year', date('Y'))->get();

        $totalpresent = Attendamce::where('user_id', auth()->user()->id)
            ->where('year', date('Y'))
            ->where('attendance', 'P')->count();

        $totallate = Attendamce::where('user_id', auth()->user()->id)
            ->where('year', date('Y'))
            ->where('attendance', 'L')->count();

        $totalabsent = Attendamce::where('user_id', auth()->user()->id)
            ->where('year', date('Y'))
            ->where('attendance', 'A')->count();

        $totalholiday = Attendamce::where('user_id', auth()->user()->id)
            ->where('year', date('Y'))
            ->where('attendance', 'H')->count();

        $totalhalfday = Attendamce::where('user_id', auth()->user()->id)
            ->where('year', date('Y'))
            ->where('attendance', 'F')->count();

        $leave = Staffleave::where('user_id', auth()->user()->id)->get();

        $totalleave = Staffleave::where('user_id', auth()->user()->id)->count();

        $totalrejected = Staffleave::where('user_id', auth()->user()->id)
            ->where('status', 'Rejected')->count();

        $totalapproved = Staffleave::where('user_id', auth()->user()->id)
            ->where('status', 'Approved')->count();

        $totalrevert = Staffleave::where('user_id', auth()->user()->id)
            ->where('status', 'Reverted')->count();

        //payroll
        $payrol = Payroll::where('user_id', auth()->user()->id)->get();

        $totalnetsalary = Payroll::where('user_id', auth()->user()->id)->sum('netsalary');
        $totalgrosssalary = Payroll::where('user_id', auth()->user()->id)->sum('grosssalary');
        $totalnetearning = Payroll::where('user_id', auth()->user()->id)->sum('totalearn');
        $totalnetdeduction = Payroll::where('user_id', auth()->user()->id)->sum('totalded');

        return view('Staff.view_staff', ['lectid' => auth()->user()->id, 'staff' => $staff, 'staffdoc' => $staffdoc, 'leccources' => $lectcorse,
            'courses' => $courses, 'attendance' => $attendance, 'totalpresent' => $totalpresent, 'totallate' => $totallate, 'totalabsent' => $totalabsent, 'totalholiday' => $totalholiday, 'totalhalfday' => $totalhalfday, 'leave' => $leave, 'totalleave' => $totalleave, 'totalrejected' => $totalrejected, 'totalapproved' => $totalapproved, 'totalrevert' => $totalrevert, 'payrol' => $payrol, 'totalnetsalary' => $totalnetsalary, 'totalgrosssalary' => $totalgrosssalary, 'totalnetearning' => $totalnetearning, 'totalnetdeduction' => $totalnetdeduction, ]);
    }

    public function viewStaff($id)
    {
        $staff = User::with('staff')->where('id', $id)->first();

        $staffdoc = Staffdoc::where('user_id', $id)->get();
        $lectcorse = LecCource::where('lecturer_id', $id)->get();
        $courses = Course::all();

        $attendance = Attendamce::where('user_id', $id)
            ->where('year', date('Y'))->get();

        $totalpresent = Attendamce::where('user_id', $id)
            ->where('year', date('Y'))
            ->where('attendance', 'P')->count();

        $totallate = Attendamce::where('user_id', $id)
            ->where('year', date('Y'))
            ->where('attendance', 'L')->count();

        $totalabsent = Attendamce::where('user_id', $id)
            ->where('year', date('Y'))
            ->where('attendance', 'A')->count();

        $totalholiday = Attendamce::where('user_id', $id)
            ->where('year', date('Y'))
            ->where('attendance', 'H')->count();

        $totalhalfday = Attendamce::where('user_id', $id)
            ->where('year', date('Y'))
            ->where('attendance', 'F')->count();

        $leave = Staffleave::where('user_id', $id)->get();

        $totalleave = Staffleave::where('user_id', $id)->count();

        $totalrejected = Staffleave::where('user_id', $id)
            ->where('status', 'Rejected')->count();

        $totalapproved = Staffleave::where('user_id', $id)
            ->where('status', 'Approved')->count();

        $totalrevert = Staffleave::where('user_id', $id)
            ->where('status', 'Reverted')->count();

        //payroll
        $payrol = Payroll::where('user_id', $id)->get();

        $totalnetsalary = Payroll::where('user_id', $id)->sum('netsalary');
        $totalgrosssalary = Payroll::where('user_id', $id)->sum('grosssalary');
        $totalnetearning = Payroll::where('user_id', $id)->sum('totalearn');
        $totalnetdeduction = Payroll::where('user_id', $id)->sum('totalded');

        return view('Staff.view_staff', ['lectid' => $id, 'staff' => $staff, 'staffdoc' => $staffdoc, 'leccources' => $lectcorse,
            'courses' => $courses, 'attendance' => $attendance, 'totalpresent' => $totalpresent, 'totallate' => $totallate, 'totalabsent' => $totalabsent, 'totalholiday' => $totalholiday, 'totalhalfday' => $totalhalfday, 'leave' => $leave, 'totalleave' => $totalleave, 'totalrejected' => $totalrejected, 'totalapproved' => $totalapproved, 'totalrevert' => $totalrevert, 'payrol' => $payrol, 'totalnetsalary' => $totalnetsalary, 'totalgrosssalary' => $totalgrosssalary, 'totalnetearning' => $totalnetearning, 'totalnetdeduction' => $totalnetdeduction, ]);
    }

    public function deletedoc(Request $request, $id)
    {
        $staffdoc = Staffdoc::where('id', $id)->first();
        $url = public_path($staffdoc->doc);
        if (file_exists($url)) {
            unlink($url);
            $staffdoc->delete();

            return Redirect()->back()->with('message', 'Success, Document Deleted Successfully!');
        }
        $staffdoc->delete();

        return Redirect()->back()->with('error', 'Failed, Try again Later');
    }

    public function recordattendance()
    {
        $role = DB::table('roles')->get();

        return view('Staff.record_attendance', ['roles' => $role]);
    }

    public function fetchstaff(Request $request)
    {
        $role = $request->post('role');
        $date = $request->post('date');

        $staff = Staff::where('role', $role)->get();
        $attendance = Attendamce::where('role', $role)
            ->where('date', $date)->get();

        $count = \count($attendance);
        $html = '';
        $html .= '
  <form method="post" action="" id="submitattendance">

  <table id="example1" class="table table-bordered">
  <thead>
  <tr>
  <th></th>
  <th>StaffID</th>
  <th>Name</th>
  <th>Role</th>
  <th>Attendance</th>
  <th>Note</th>
  <th></th>
  </tr>
  </thead>
  <tbody>';

        if (\count($staff) > 0) {
            $loop = 1;
            foreach ($staff as $row) {
                $html .= '
    <tr>
    <td></td>
    <td>' . $row->eployid . '</td>
    <td>' . $row->fullname . '</td>
    <td>' . $row->role . '</td>
    <td>';
                if ($count > 0) {
                    foreach ($attendance as $value) {
                        if ($value->user_id == $row->user_id) {
                            if ('' == $value->attendance) {
                                $html .= '
            <input type="hidden" name="loop[]" value="' . $loop . '" />
            <input type="hidden" name="role" value="' . $role . '" />

            <input type="hidden" name="date" value="' . $date . '" id="date"/>

            <input type="hidden" name="user' . $loop . '" value="' . $row->user_id . '" id="date"/>

            <label>
            <input type="radio"  name="attend' . $loop . '" value="P" >
            Present
            </label>


            <label>
            <input type="radio"  name="attend' . $loop . '" value="A" >
            Absent
            </label>


            <label>
            <input type="radio"  name="attend' . $loop . '" value="F" >
            Half Day
            </label>

            <label>
            <input type="radio" name="attend' . $loop . '" value="H" >
            Holiday
            </label>
            ';
                            } else {
                                $html .= '
            <input type="hidden" name="loop[]" value="' . $loop . '" />
            <input type="hidden" name="role" value="' . $role . '" />

            <input type="hidden" name="date" value="' . $date . '" id="date"/>

            <input type="hidden" name="user' . $loop . '" value="' . $row->user_id . '" id="date"/>



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
            <input type="radio"  ';
                                if ('F' == $value->attendance) {
                                    $html .= 'checked';
                                }

                                $html .= ' name="attend' . $loop . '" value="F" >
            Half Day
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
      <input type="hidden" name="loop[]" value="' . $loop . '" />
      <input type="hidden" name="role" value="' . $role . '" />

      <input type="hidden" name="date" value="' . $date . '" id="date"/>

      <input type="hidden" name="user' . $loop . '" value="' . $row->user_id . '" id="date"/>

      <label>
      <input type="radio"  name="attend' . $loop . '" value="P" >
      Present
      </label>


      <label>
      <input type="radio"  name="attend' . $loop . '" value="A" >
      Absent
      </label>


      <label>
      <input type="radio"  name="attend' . $loop . '" value="F" >
      Half Day
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
                        if ($value->user_id == $row->user_id) {
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
                ++$loop;
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
<td  colspan="6"><input type="submit" class="btn btn-success pull-right" value="Submit" /> </td>
</tr>
</tbody>
</table>
</form>';

        return $html;
    }

    public function saveattendant(Request $request)
    {
        $count = \count($request->post('loop'));
        $mumber = $request->post('loop');
        $role = $request->post('role');
        $date = $request->post('date');

        for ($i = 0; $i < $count; ++$i) {
            $loop = $mumber[$i];
            $userid = $request->post('user' . $loop);
            $attend = $request->post('attend' . $loop);
            $note = $request->post('note' . $loop);
            $day = substr($date, 8);
            $month = substr($date, 5, 2);
            $year = substr($date, 0, 4);

            $data = [
                'user_id' => $userid,
                'attendance' => $attend,
                'note' => $note,
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'role' => $role,
                'date' => $date,
            ];

            //make query

            $attendance = Attendamce::where('user_id', $userid)
                ->where('date', $date)->first();

            if ($attendance) {
                //record dey so update

                $attendance->attendance = $attend;
                $attendance->note = $note;
                $attendance->save();
            } else {
                //new record so update
                //
                $newrecord = new Attendamce($data);
                $newrecord->save();
            }
        }

        return 'success';
    }

    public function yearfetch(Request $request)
    {
        $id = $request->post('lectid');
        $year = $request->post('value');

        $attendance = Attendamce::where('user_id', $id)
            ->where('year', $year)->get();

        $totalpresent = Attendamce::where('user_id', $id)
            ->where('year', $year)
            ->where('attendance', 'P')->count();

        $totallate = Attendamce::where('user_id', $id)
            ->where('year', $year)
            ->where('attendance', 'L')->count();

        $totalabsent = Attendamce::where('user_id', $id)
            ->where('year', $year)
            ->where('attendance', 'A')->count();

        $totalholiday = Attendamce::where('user_id', $id)
            ->where('year', $year)
            ->where('attendance', 'H')->count();

        $totalhalfday = Attendamce::where('user_id', $id)
            ->where('year', $year)
            ->where('attendance', 'F')->count();

        return view('Staff.attendance', ['attendance' => $attendance, 'totalpresent' => $totalpresent, 'totallate' => $totallate, 'totalabsent' => $totalabsent, 'totalholiday' => $totalholiday, 'totalhalfday' => $totalhalfday, 'year' => $year]);
    }

    public function add_payroll()
    {
        $role = DB::table('roles')->get();

        $staff = Staff::all();

        return view('Staff.add_payroll', ['roles' => $role, 'staff' => $staff]);
    }

    public function payroll_fetch(Request $request)
    {
        $role = $request->post('role');
        $month = $request->post('month');
        $year = $request->post('year');

        if ('All' == $role) {
            $staff = Staff::all();
        } else {
            $staff = Staff::where('role', $role)->get();
        }

        //dd($staff);

        $payroll = Payroll::where('role', $role)
            ->where('year', $year)
            ->where('month', $month)->get();

        return view('Staff.payroll', ['staff' => $staff, 'payroll' => $payroll, 'month' => $month, 'year' => $year, 'role' => $role]);
    }

    public function generate_payroll($id, $month, $year, $role)
    {
        $staff = Staff::where('role', $role)
            ->where('user_id', $id)->first();

        if ('January' == $month) {
            $aliase = '01';
        }

        if ('February' == $month) {
            $aliase = '02';
        }

        if ('Match' == $month) {
            $aliase = '03';
        }

        if ('April' == $month) {
            $aliase = '04';
        }

        if ('May' == $month) {
            $aliase = '05';
        }

        if ('June' == $month) {
            $aliase = '06';
        }

        if ('July' == $month) {
            $aliase = '07';
        }

        if ('August' == $month) {
            $aliase = '08';
        }

        if ('September' == $month) {
            $aliase = '09';
        }

        if ('October' == $month) {
            $aliase = '10';
        }

        if ('November' == $month) {
            $aliase = '11';
        }

        if ('December' == $month) {
            $aliase = '12';
        }

        $attendance = Attendamce::where('user_id', $id)
            ->where('year', $year)
            ->where('month', $aliase)
            ->get();

        $payroll = Payroll::where('role', $role)
            ->where('year', $year)
            ->where('month', $month)
            ->where('user_id', $id)->get();

        $user = User::where('id', $id)->first();

        $totalpresent = Attendamce::where('user_id', $id)
            ->where('year', $year)
            ->where('month', $aliase)
            ->where('attendance', 'P')->count();

        $totallate = Attendamce::where('user_id', $id)
            ->where('year', $year)
            ->where('attendance', 'L')->count();

        $totalabsent = Attendamce::where('user_id', $id)
            ->where('year', $year)
            ->where('month', $aliase)
            ->where('attendance', 'A')->count();

        $totalholiday = Attendamce::where('user_id', $id)
            ->where('year', $year)
            ->where('month', $aliase)
            ->where('attendance', 'H')->count();

        $totalhalfday = Attendamce::where('user_id', $id)
            ->where('year', $year)
            ->where('month', $aliase)
            ->where('attendance', 'F')->count();

        return view('Staff.generatepay', ['staff' => $staff, 'payroll' => $payroll, 'attendance' => $attendance, 'aliase' => $aliase, 'month' => $month, 'year' => $year,  'user' => $user, 'totalpresent' => $totalpresent, 'totallate' => $totallate, 'totalabsent' => $totalabsent, 'totalholiday' => $totalholiday, 'totalhalfday' => $totalhalfday, 'role' => $role]);
    }

    public function genearn()
    {
        $value = mt_rand(300, 500);
        $html = '';
        $html .= '
  <div class="row" id="' . $value . '">
  <div class="col-md-4">
  <div class="form-group">
  <input class="form-control form-border" name="etype[]"  type="text" placeholder="Type" />
  </div>
  </div>

  <div class="col-md-6">
  <input class="form-control form-border" name="earn[]" type="number" placeholder="Amount" />
  </div>

  <div class="col-md-1">
  <a href="#" class="btn btn-info earnminus" cid="' . $value . '" id="earnminus"><i class="fa fa-minus"></i></a>
  </div>
  </div>';

        return $html;
    }

    public function gendeduct()
    {
        $value = mt_rand(600, 2000);
        $html = '';
        $html .= '
  <div class="row" id="' . $value . '">
  <div class="col-md-4">
  <div class="form-group">
  <input class="form-control form-border" name="dtype[]"  type="text" placeholder="Type" />
  </div>
  </div>

  <div class="col-md-6">
  <input class="form-control form-border" name="deduct[]" type="number" placeholder="Amount" />
  </div>

  <div class="col-md-1">
  <a href="#" class="btn btn-info deducminus" cid="' . $value . '" id="deducminus"><i class="fa fa-minus"></i></a>
  </div>
  </div>';

        return $html;
    }

    public function calculate_payroll(Request $request)
    {
        $type = $request->post('stype');

        $earntype = $request->post('etype');
        $earn = $request->post('earn');

        $deductype = $request->post('dtype');
        $deduct = $request->post('deduct');

        $basicsalary = $request->post('deduct');

        $basic = $request->post('basic');

        $tax = $request->post('tax');

        $role = $request->post('role');

        $total_alawa = $request->post('total_allowance');
        $totoal_deduc = $request->post('total_deduction');
        $grsalary = $request->post('gross_salary');
        $netsalary = $request->post('tax');
        $stafid = $request->post('staff_id');
        $month = $request->post('month');
        $year = $request->post('year');
        $aliase = $request->post('aliase');

        if ('calcu' == $type) {
            $counttype = \count($earntype);
            $earmamount = 0;
            if ($counttype > 0) {
                for ($i = 0; $i < $counttype; ++$i) {
                    $earmamount += $earn[$i];
                }
            }

            $coundec = \count($deductype);
            $deductamount = 0;
            if ($coundec > 0) {
                for ($d = 0; $d < $coundec; ++$d) {
                    $deductamount += $deduct[$d];
                }
            }

            $initial = ($earmamount + $basic) - $deductamount;

            if ($tax > 0) {
                $ctax = ($tax / 100) * $initial;

                $gross = $initial - $ctax;
            } else {
                $gross = $initial;
            }

            return Response::json([
                'msg' => 'calculate',
                'totalearn' => $earmamount,
                'totaldeduc' => $deductamount,
                'gross' => $initial,
                'tax' => $tax,
                'net' => $gross,

            ], 200);
        }

        $counttype = \count($earntype);
        $earmamount = 0;
        $earnmnt = '';
        if ($counttype > 0) {
            $etypes = '';
            for ($i = 0; $i < $counttype; ++$i) {
                $earmamount += $earn[$i];
                $etypes .= $earntype[$i] . ',';
                $earnmnt .= $earn[$i] . ',';
            }
        } else {
            $etypes = '';
            $earnmnt = '';
        }

        $coundec = \count($deductype);
        $deductamount = 0;
        $dtyamnt = '';
        if ($coundec > 0) {
            $dtypes = '';
            for ($d = 0; $d < $coundec; ++$d) {
                $deductamount += $deduct[$d];
                $dtypes .= $deductype[$d] . ',';
                $dtyamnt .= $deduct[$d] . ',';
            }
        } else {
            $dtypes = '';
            $dtyamnt = '';
        }

        $initial = ($earmamount + $basic) - $deductamount;

        if ($tax > 0) {
            $ctax = ($tax / 100) * $initial;

            $gross = $initial - $ctax;
        } else {
            $gross = $initial;
        }

        $data = [
            'user_id' => $stafid,
            'role' => $role,
            'month' => $month,
            'monthalise' => $aliase,
            'year' => $year,
            'earning' => $etypes,
            'earnamnts' => $earnmnt,
            'totalearn' => $earmamount,
            'deduction' => $dtypes,
            'deductamnts' => $dtyamnt,
            'totalded' => $deductamount,
            'grosssalary' => $initial,
            'netsalary' => $gross,
            'tax' => $tax,
            'paymentdate' => date('Y-m-d'),
            'status' => 'Generated',
        ];

        $payroll = new Payroll($data);
        $payroll->save();

        return Response::json([
            'msg' => 'save',
            'datas' => 'Payroll Generated Successfully!',
        ], 200);
    }

    public function view_staff_payroll_now($id)
    {
        $payroll = Payroll::where('id', $id)->first();
        $user = User::where('id', $payroll->user_id)->first();
        $staff = Staff::where('user_id', $payroll->user_id)->first();

        $earn = $payroll->earning;
        $earnamnt = $payroll->earnamnts;

        $deduct = $payroll->deduction;
        $deductamnt = $payroll->deductamnts;

        $totearn = $payroll->totalearn;

        $earmim = explode(',', $earn);
        $earnamnts = explode(',', $earnamnt);

        $dedt = explode(',', $deduct);
        $dedtamnts = explode(',', $deductamnt);

        $schoolname = 'Ogua School Management System';

        $image = URL::to('images/logo-80.png');

        $back = URL::to('images/logo.png');

        //dd($image);

        $this->fpdf = new pdfs();
        $this->fpdf->AliasNbPages();

        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->AddPage('P');
        // $this->fpdf->SetTitle("Students With Their Enrollment Numbers");

        //$this->fpdf->centreImage($back);
        //$this->fpdf->imageUniformToFill($image,10,10,0,0,"C");
        $this->fpdf->Cell(190, 10, $schoolname, 0, 1, 'C');
        $this->fpdf->Cell(190, 10, 'Payslip For The Period Of ' . $payroll->month . ' ' . $payroll->year, 0, 1, 'C');

        $this->fpdf->Image($image, 10, 6, 20);

        $this->fpdf->line(20, 45, 210 - 20, 45);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell(20, 5, 'Payslip #', 0, 0, 'L');
        $this->fpdf->Cell(25, 5, ': ' . $payroll->payslipid, 0, 0, 'L');
        $this->fpdf->Cell(100, 5, '', 0, 0, 'L');
        $this->fpdf->Cell(25, 5, 'Payment Date', 0, 0, 'L');
        $this->fpdf->Cell(20, 5, ': ' . $payroll->paymentdate, 0, 1, 'L');

        $this->fpdf->Cell(20, 5, 'Staff Name', 0, 0, 'L');
        $this->fpdf->Cell(25, 5, ': ' . $staff->fullname, 0, 0, 'L');
        $this->fpdf->Cell(100, 5, '', 0, 0, 'L');
        $this->fpdf->Cell(25, 5, 'Role in School', 0, 0, 'L');
        $this->fpdf->Cell(20, 5, ': ' . $staff->role, 0, 1, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell(95, 10, 'Earnings', 'B', 0, 'L');
        $this->fpdf->Cell(95, 10, 'Amount', 'B', 1, 'L');

        $mnt = 0;
        $last = \count($earmim);
        foreach ($earmim as $key => $value) {
            if (0 == --$last) {
                continue;
            }

            $this->fpdf->Cell(95, 10, strtoupper($value), 0, 0, 'L');
            $this->fpdf->Cell(95, 10, 'Gh ' . $earnamnts[$mnt], 0, 1, 'L');
            ++$mnt;
        }

        $this->fpdf->Cell(95, 10, 'Total Earnings', 'B', 0, 'L');
        $this->fpdf->Cell(95, 10, 'Gh ' . $payroll->totalearn, 'B', 1, 'L');

        //DEDUCTIONS

        $this->fpdf->Ln(20);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell(95, 10, 'Deductions', 'B', 0, 'L');
        $this->fpdf->Cell(95, 10, 'Amount', 'B', 1, 'L');

        $dmnt = 0;
        $lasts = \count($dedt);
        foreach ($dedt as $key => $value) {
            if (0 == --$lasts) {
                continue;
            }

            $this->fpdf->Cell(95, 10, strtoupper($value), 0, 0, 'L');
            $this->fpdf->Cell(95, 10, 'Gh ' . $dedtamnts[$dmnt], 0, 1, 'L');
            ++$dmnt;
        }

        $this->fpdf->Cell(95, 10, 'Total Deductions', 'B', 0, 'L');
        $this->fpdf->Cell(95, 10, 'Gh ' . $payroll->totalded, 'B', 1, 'L');

        $this->fpdf->Ln(20);

        $this->fpdf->Cell(95, 10, 'Payment Mode', 'B', 0, 'L');
        $this->fpdf->Cell(95, 10, $payroll->modepay, 'B', 1, 'L');

        $this->fpdf->Cell(95, 10, 'Basic Salary', 'B', 0, 'L');
        $this->fpdf->Cell(95, 10, 'Gh ' . $staff->salary, 'B', 1, 'L');

        $this->fpdf->Cell(95, 10, 'Gross Salary', 'B', 0, 'L');
        $this->fpdf->Cell(95, 10, 'Gh ' . $payroll->grosssalary, 'B', 1, 'L');

        $this->fpdf->Cell(95, 10, 'Tax', 'B', 0, 'L');
        $this->fpdf->Cell(95, 10, $payroll->tax . '%', 'B', 1, 'L');

        $this->fpdf->Cell(95, 10, 'Net Salary', 'B', 0, 'L');
        $this->fpdf->Cell(95, 10, 'Gh ' . $payroll->netsalary, 'B', 1, 'L');

        return response($this->fpdf->Output('I', 'payslip-for-' . $staff->fullname . '-' . $payroll->month . '-period.pdf'))
            ->header('Content-Type', 'application/pdf');
    }

    public function staffleave()
    {
        $leave = Staffleave::latest()->latest()->get();

        return view('Staff.Staff_leave', ['leave' => $leave]);
    }

    public function requestleave()
    {
        $leave = Staffleave::where('user_id', auth()->user()->id)->latest()->get();

        return view('Staff.requestleave', ['leave' => $leave]);
    }

    public function save_requestleave(Request $request)
    {
        $user = Staff::where('user_id', auth()->user()->id)->first();

        $reason = $request->post('reasons');
        $type = $request->post('leavetype');
        $date = $request->post('daterange');
        $days = $request->post('days');
        $now = date('Y-m-d');
        $edit = $request->post('editrequest');
        $hiddenid = $request->post('hiddenid');

        if ($user) {
            $role = $user->role;
        } else {
            $role = auth()->user()->name;
        }

        $data = [
            'user_id' => auth()->user()->id,
            'staffid' => $user->eployid,
            'role' => $role,
            'applydate' => $now,
            'leavedate' => $date,
            'leavetype' => $type,
            'days' => $days,
            'status' => 'Processing',
            'reason' => $reason,
        ];

        if ('edit' == $edit) {
            $rqleave = Staffleave::where('id', $hiddenid)->update($data);

            return Response::json([
                'msg' => 'true',
                'message' => 'Leave Updated Successfully!',
            ], 200);
        }
        $rqleave = new Staffleave($data);
        $rqleave->save();

        return Response::json([
            'msg' => 'true',
            'message' => 'Leave Requested Successfully!',
        ], 200);
    }

    public function update_requestleave(Request $request)
    {
        $id = $request->post('cid');
        $note = $request->post('note');
        $status = $request->post('apprve');

        $rqleave = Staffleave::where('id', $id)->first();
        $rqleave->note = $note;
        $rqleave->status = $status;
        $rqleave->save();

        return Response::json([
            'msg' => 'true',
            'message' => 'Leave Request Updated Successfully!',
        ], 200);
    }

    public function leave_req_revert(Request $request)
    {
        $id = $request->post('cid');

        $rqleave = Staffleave::where('id', $id)->first();
        $rqleave->status = 'Reverted';
        $rqleave->save();

        return Response::json([
            'msg' => 'true',
            'message' => 'Leave Request Reverted Successfully!',
        ], 200);
    }

    public function fetch_payroll_fetail(Request $request)
    {
        $id = $request->post('id');
        $payroll = Payroll::where('id', $id)->first();
        $staff = Staff::where('user_id', $payroll->user_id)->first();

        return Response::json([
            'msg' => 'true',
            'userid' => $id,
            'fname' => $staff->fullname,
            'employid' => $staff->eployid,
            'salary' => $payroll->netsalary,
            'note' => $payroll->note,
        ], 200);
    }

    public function save_payroll_now(Request $request)
    {
        $id = $request->post('hiddenid');
        $mode = $request->post('modeofpay');
        $note = $request->post('reasons');

        $maxcode = DB::table('payrolls')->max('payslipid');
        if ($maxcode) {
            $max = substr($maxcode, 4);
            $number = $max + 1;
            $code = 'OSMS' . $number;
        } else {
            $code = 'OSMS100';
        }

        $payroll = Payroll::where('id', $id)->first();
        $payroll->modepay = $mode;
        $payroll->paymentdate = date('Y-m-d');
        $payroll->status = 'Paid';
        $payroll->payslipid = $code;
        $payroll->note = $note;
        $payroll->save();

        return Response::json([
            'msg' => 'true',
            'message' => 'Staff Paid Successfully!',
        ], 200);
    }

    public function view_payroll_now(Request $request)
    {
        $id = $request->post('cid');
        $payroll = Payroll::where('id', $id)->first();
        $user = User::where('id', $payroll->user_id)->first();
        $staff = Staff::where('user_id', $payroll->user_id)->first();

        $earn = $payroll->earning;
        $earnamnt = $payroll->earnamnts;

        $deduct = $payroll->deduction;
        $deductamnt = $payroll->deductamnts;

        $totearn = $payroll->totalearn;

        $earmim = explode(',', $earn);
        $earnamnts = explode(',', $earnamnt);

        $dedt = explode(',', $deduct);
        $dedtamnts = explode(',', $deductamnt);

        $html = '';

        $html .= '<div class="modal fade" id="viewpay">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Payslip #' . $payroll->payslipid . '</h4>
  </div>
  <div class="modal-body">

  <div id="html-2-pdfwrapper">

  <div class="row">
  <!-- left column -->
  <div class="col-md-12">

  <div class="">
  <table width="100%">
  <tbody>
  <tr>


  <td style="height: 100px;width: 850px;">
  <div class="row">
  <div class="col-md-2">
  <img width="90" height="90"src="' . URL::to('images/logo.png') . '"/>
  </div>
  <div class="col-md-1"></div>
  <div class="col-md-9">
  <h2 class="text-left">Ogua College School Management System</h2>
  </div>
  </div>

  </td>
  </tr>
  <tr>
  <td align="center"><h3 style="margin: 10px 0 20px;">Payslip for the period of ' . $payroll->month . ' ' . $payroll->year . '</h3></td>
  </tr>
  </tbody></table>
  <table width="100%" class="paytable2">
  <tbody><tr>
  <th>Payslip #31</th> <td></td>
  <th class="text-right"></th> <th class="text-right">Payment Date: ' . $payroll->paymentdate . '</th>

  </tr>
  </tbody></table>
  <hr>


  <table width="100%" class="paytable2">
  <tbody><tr>
  <th width="25%">Staff ID</th>
  <td width="25%">' . $user->indexnumber . '</td>
  <th width="25%">Name</th>
  <td width="25%">' . $user->name . '</td>
  </tr>
  <tr>
  <th>Department / Faculty</th>
  <td>' . $staff->faculty . '</td>

  <th>role</th>
  <td>' . $staff->role . '</td>
  </tr>
  </tbody></table>
  <hr>

  <div class="row">
  <div class="col-md-6">

  <table class="earntable table table-responsive">
  <tbody><tr>
  <th width="19%">Earning</th>
  <th width="16%" class="pttright reborder">Amount</th>
  </tr>';

        $mnt = 0;
        $last = \count($earmim);
        foreach ($earmim as $key => $value) {
            if (0 == --$last) {
                continue;
            }

            $html .= '
    <tr>
    <td>' . strtoupper($value) . '</td>
    <td class="pttright reborder">GH&cent;' . $earnamnts[$mnt] . '</td>
    </tr>
    ';

            ++$mnt;
        }

        $html .= '
  </tr>
  <tr>

  </tr>

  <tr style="background-color: #ccc;">
  <th>Total Earnings</th>
  <th class="pttright reborder">GH&cent;' . $payroll->totalearn . '</th>
  </tr>
  </tbody></table>

  </div>


  <div class="col-md-6">

  <table class="earntable table table-responsive">
  <tbody><tr>
  <th width="19%">Deductions</th>
  <th width="16%" class="pttright reborder">Amount</th>
  </tr>';

        $mnt = 0;
        $lasts = \count($dedt);
        foreach ($dedt as $key => $value) {
            if (0 == --$lasts) {
                continue;
            }

            $html .= '
    <tr>
    <td>' . strtoupper($value) . '</td>
    <td class="pttright reborder">GH&cent;' . $dedtamnts[$mnt] . '</td>
    </tr>
    ';

            ++$mnt;
        }

        $html .= '
  </tr>
  <tr>

  </tr>

  <tr style="background-color: #ccc;">
  <th>Total Deductions</th>
  <th class="pttright reborder">GH&cent;' . $payroll->totalded . '</th>
  </tr>
  </tbody></table>

  </div>
  </div>

  <hr>

  <table class="totaltable table table-bordered table-responsive">
  <tbody>
  <tr>
  <th colspan="3">Payment Mode</th>
  <td>' . $payroll->modepay . '</td>
  </tr>

  <tr>
  <th colspan="3">Basic Salary</th>
  <td>GH&cent;' . $staff->salary . '</td>
  </tr>


  <tr>
  <th colspan="3" >Gross Salary</th>
  <td>GH&cent;' . $payroll->grosssalary . '</td>

  </tr>

  <tr style="border-top:1px solid #fff; border-bottom: 1px solid #fff;">
  <th colspan="3">Tax</th>
  <td>' . $payroll->tax . '%</td>
  </tr>

  <tr style="background-color: #ccc;">
  <th colspan="3">Net Salary</th>
  <td>GH&cent;' . $payroll->netsalary . '</td>
  </tr>

  <tr>


  <tr>

  <td align="center">
  <div style="position: absolute;left:15px">This payslip is computer generated hence no signature is required. <p></p></div>

  </td>
  </tr>

  </tbody></table>

  </div>
  </div>
  <!--/.col (left) -->

  </div>
  </div>

  </div>
  <div class="modal-footer">
  <button type="button" class="btn btn-primary" id="print_pay">Print</button>
  </div>
  </div>
  </div>
  </div>';

        return Response::json([
            'msg' => 'true',
            'message' => $html,
        ], 200);
    }

    public function disable_staff()
    {
        $users = User::with('staff')
            ->where('indexnumber', 'not like', '%GES%')->get();

        return view('Staff.disable_staff', ['users' => $users]);
    }
}
