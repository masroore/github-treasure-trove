<?php

namespace App\Http\Controllers;

use App\Academicyear;
use App\Account;
use App\Coureregistration;
use App\Examresults;
use App\Jobs\Dispatchfees;
use App\MandatoryFee;
use App\OtherservicesFee;
use App\Paymentdeadline;
use App\Programmecourse;
use App\Regacademicyear;
use App\Semesterfee;
use App\Studentfee;
use App\Studentinfo;
use App\User;
use App\Wallettop;
use Exception;
use FPDF as pdfs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    private $fpdf;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $v = 9;
        // $z = 9;

        // if ($v != '9') {
        //     echo 'not qual';
        // }else{
        //     echo'eqaul';
        // }

        // exit;

        $accounts = MandatoryFee::latest()->get();

        return view('Accounts.add_mandatory_fees', ['mandatory' => $accounts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $maxcode = DB::table('mandatory_fees')->max('feecode');

        if ($maxcode) {
            $max = substr($maxcode, 3);
            $number = $max + 1;
            $code = 'FEE' . $number;
        } else {
            $code = 'FEE100';
        }

        if ($request->has('hiddenid')) {
            $data = [
                'title' => $request->input('title'),
            ];

            $mandatoryfees = MandatoryFee::findorfail($request->input('hiddenid'))
                ->update($data);

            toastr()->success('Fee Updated Successfully!');

            return Redirect()->route('add-mandatory-fees');
        }

        $data = [
            'title' => $request->input('title'),
            'feecode' => $code,
        ];

        $mandatoryfees = new MandatoryFee($data);
        $mandatoryfees->save();

        toastr()->success('Fee Added Successfully!');

        return Redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mandatory
     *
     * @return \Illuminate\Http\Response
     */
    public function deletemandatory($id)
    {
        $mandatoryfees = MandatoryFee::findorfail($id)->delete();
        toastr()->success('Fee Deleted Successfully!');

        return Redirect()->back();
    }

    public function editmandatory($id)
    {
        $accounts = MandatoryFee::findorfail($id);

        return view('Accounts.edit_mandatory_fees', ['mandatory' => $accounts]);
    }

    // Other Services Fees

    public function add_other_services()
    {
        $accounts = OtherservicesFee::latest()->get();

        return view('Accounts.add_other_services_fees', ['otherservce' => $accounts]);
    }

    public function save_other_services(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'fee' => 'required',
        ]);

        $maxcode = DB::table('otherservices_fees')->max('feecode');

        if ($maxcode) {
            $max = substr($maxcode, 4);
            $number = $max + 1;
            $code = 'OFEE' . $number;
        } else {
            $code = 'OFEE100';
        }

        if ($request->has('hiddenid')) {
            $data = [
                'title' => $request->input('title'),
                'fee' => $request->input('fee'),
            ];

            $mandatoryfees = OtherservicesFee::findorfail($request->input('hiddenid'))
                ->update($data);

            toastr()->success('Fee Updated Successfully!');

            return Redirect()->route('add_other_services');
        }

        $data = [
            'title' => $request->input('title'),
            'feecode' => $code,
            'fee' => $request->input('fee'),
        ];

        $mandatoryfees = new OtherservicesFee($data);
        $mandatoryfees->save();

        toastr()->success('Fee Added Successfully!');

        return Redirect()->back();
    }

    public function delete_other_services($id)
    {
        $mandatoryfees = OtherservicesFee::findorfail($id)->delete();
        toastr()->success('Fee Deleted Successfully!');

        return Redirect()->back();
    }

    public function edit_other_services($id)
    {
        $accounts = OtherservicesFee::findorfail($id);

        return view('Accounts.edit_other_services', ['otherservce' => $accounts]);
    }

    // Fees Master

    public function add_fees_master()
    {
        $accounts = OtherservicesFee::all();
        $mandatory = MandatoryFee::all();
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semesterfee = Semesterfee::where('academicyear', $year)
            ->orderBy('level')->latest()->get();

        return view('Accounts.add_fees_master', ['otherservce' => $accounts, 'mandatory' => $mandatory, 'year' => $year, 'semesterfee' => $semesterfee]);
    }

    public function view_fees_level100()
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semesterfee = Semesterfee::where('academicyear', $year)
            ->where('level', 'Level 100')
            ->orderBy('feecode')->latest()->get();

        return view('Accounts.view_fee_level_100', ['year' => $year, 'semesterfee' => $semesterfee]);
    }

    public function view_fees_level200()
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semesterfee = Semesterfee::where('academicyear', $year)
            ->where('level', 'Level 200')
            ->orderBy('feecode')->latest()->get();

        return view('Accounts.view_fee_level_200', ['year' => $year, 'semesterfee' => $semesterfee]);
    }

    public function view_fees_level300()
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semesterfee = Semesterfee::where('academicyear', $year)
            ->where('level', 'Level 300')
            ->orderBy('feecode')->latest()->get();

        return view('Accounts.view_fee_level_300', ['year' => $year, 'semesterfee' => $semesterfee]);
    }

    public function view_fees_level400()
    {
        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;
        $semesterfee = Semesterfee::where('academicyear', $year)
            ->where('level', 'Level 400')
            ->orderBy('feecode')->latest()->get();

        return view('Accounts.view_fee_level_400', ['year' => $year, 'semesterfee' => $semesterfee]);
    }

    public function save_fees_master_man(Request $request)
    {
        $this->validate($request, [
            'level' => 'required',
            'session' => 'required',
            'title' => 'required',
            'fee' => 'required',
            'academicyear' => 'required',
        ]);

        $input = explode('-', $request->post('title'));
        $fee = $input[0];
        $feecode = $input[1];

        if ($request->has('hiddenid')) {
        } else {
            $sess = $request->post('session');
            $count = \count($request->post('session'));

            $data = [
                'level' => $request->post('level'),
                'fee' => trim($fee),
                'feecode' => $feecode,
                'feeamount' => $request->post('fee'),
                'academicyear' => $request->post('academicyear'),
            ];

            //check if fee has already been added
            $fee = Semesterfee::where('level', $request->post('level'))
                ->where('feecode', $feecode)
                ->where('academicyear', $request->post('academicyear'))->first();

            if ($fee) {
                toastr()->success('Fee Already Added!');

                return Redirect()->back();
            }

            for ($i = 0; $i < $count; ++$i) {
                $session = $sess[$i];
                $feeadd = new Semesterfee($data);
                $feeadd->save();
                $feeadd->session = $session;
                $feeadd->save();
            }

            toastr()->success('Fees Added Successfully!');

            return Redirect()->back();
        }
    }

    public function save_fees_master_otherservice(Request $request)
    {
        $this->validate($request, [
            'level' => 'required',
            'session' => 'required',
            'title' => 'required',
            'academicyear' => 'required',
        ]);

        $input = explode('-', $request->post('title'));
        $fee = $input[0];
        $feecode = $input[1];
        $amount = $input[2];

        // dd($feecode);

        if ($request->has('hiddenid')) {
        } else {
            $sess = $request->post('session');
            $count = \count($request->post('session'));

            $data = [
                'level' => $request->post('level'),
                'fee' => $fee,
                'feecode' => $feecode,
                'feeamount' => $amount,
                'academicyear' => $request->post('academicyear'),
            ];

            //check if fee has already been added
            $fee = Semesterfee::where('level', $request->post('level'))
                ->where('feecode', $feecode)
                ->where('academicyear', $request->post('academicyear'))->first();

            if ($fee) {
                toast('Fees Already Added!', 'error');

                return Redirect()->back();
            }

            for ($i = 0; $i < $count; ++$i) {
                $session = $sess[$i];
                $feeadd = new Semesterfee($data);
                $feeadd->save();
                $feeadd->session = $session;
                $feeadd->save();
            }

            toastr()->success('Fee Added Successfully!');

            return Redirect()->back();
        }
    }

    public function delete_fees_master($id)
    {
        $mandatoryfees = Semesterfee::findorfail($id)->delete();
        toastr()->success('Fee Deleted Successfully!');

        return Redirect()->back();
    }

    public function edit_fees_master($id)
    {
        $feemaster = Semesterfee::findorfail($id);

        return view('Accounts.edit_fee_master', ['mandatory' => $feemaster]);
    }

    public function update_fees_master(Request $request, $id)
    {
        $this->validate($request, [
            'level' => 'required',
            'session' => 'required',
            'title' => 'required',
            'feecode' => 'required',
            'fee' => 'required',
        ]);

        $data = [
            'level' => $request->post('level'),
            'fee' => $request->post('title'),
            'feecode' => $request->post('feecode'),
            'feeamount' => $request->post('fee'),
            'session' => $request->post('session'),
        ];

        //dd($data);

        $mandatoryfees = Semesterfee::findorfail($id)->update($data);
        toastr()->success('Fee Updated Successfully!');

        return Redirect()->back();
    }

    public function dispatch_fees()
    {
        $feemaster = Semesterfee::all();
        $getdeadline = Paymentdeadline::latest()->take(10)->get();
        //dd($getdeadline);
        return view('Accounts.dispatch_fees', ['semesterfee' => $feemaster, 'deadline' => $getdeadline]);
    }

    public function dispatch_fees_now()
    {
        $this->dispatch(new Dispatchfees());
        toastr()->success('Fee Dispatched Successfully!');

        return Redirect()->back();
    }

    // Student Script

    public function search_student()
    {
        return view('Accounts.search_student');
    }

    public function search_student_check(Request $request)
    {
        $this->validate($request, [
            'index' => 'required',
        ]);

        $user = User::where('indexnumber', $request->input('index'))->first();
        if ($user) {
            return Redirect()->route('search_student_information', ['id' => $user->id]);
        }

        return Redirect()->back()->with('error', 'Index Number Dont Exist');
    }

    public function search_student_information($id)
    {
        $wallet = User::with('wallet')
            ->where('id', $id)->get();

        //dd($wallet);

        $studentinfo = Studentinfo::where('user_id', $id)->get();

        $cademicyear = Academicyear::where('status', 1)->first();
        $academicyear = $cademicyear->acdemicyear;
        $academicsem = $cademicyear->semester;

        //dd($studentinfo);

        return view('Accounts.search_info', ['wallet' => $wallet, 'studentinfo' => $studentinfo, 'acdemicyear' => $academicyear, 'semester' => $academicsem]);
    }

    public function view_student_fees($indexnumber)
    {
        $studentid = Studentinfo::where('indexnumber', $indexnumber)->first();

        if ($studentid) {
            return Redirect()->route('getstudentfees_view', ['id' => $studentid->id]);
        }
        toastr()->warning('The index Number Entered Dont Exist!', 'error');

        return Redirect()->back();
    }

    public function pay_students_fes($indexnumber)
    {
        $studentid = Studentinfo::where('indexnumber', $indexnumber)->first();

        if ($studentid) {
            return Redirect()->route('paystudentfees_view', ['id' => $studentid->id]);
        }
        toastr()->warning('he index Number Entered Dont Exist!');

        return Redirect()->back();
    }

    public function getstudentfees_view($id)
    {
        $studentinfo = Studentinfo::findorfail($id);
        $userinf = User::where('indexnumber', $studentinfo->indexnumber)->first();

        //get fees
        $fees = Studentfee::where('indexnumber', $studentinfo->indexnumber)->get();

        return view('Accounts.displayfees', ['studentinfo' => $studentinfo, 'user' => $userinf, 'semesterfee' => $fees]);
        //dd($studentinfo);
    }

    public function remove_fee(Request $request)
    {
        $id = $request->post('cid');
        $fees = Studentfee::where('id', $id)->first();
        $fees->delete();

        return true;
    }

    public function edit_fee(Request $request)
    {
        $id = $request->post('hiddenid');
        $changeto = $request->post('chngeamount');

        $fees = Studentfee::where('id', $id)->first();
        $feeamount = $fees->feeamount;
        $paid = $fees->paid;
        $owed = $fees->owed;

        //$chfee = $feeamount - $changeto;
        $chowed = $changeto - $paid;

        $fees->feeamount = $changeto;
        $fees->owed = $chowed;
        $fees->save();

        return true;
    }

    public function paystudentfees_view($id)
    {
        $studentinfo = Studentinfo::findorfail($id);
        $userinf = User::where('indexnumber', $studentinfo->indexnumber)->first();

        //get fees
        $fees = Studentfee::where('indexnumber', $studentinfo->indexnumber)->get();

        return view('Accounts.payfees', ['studentinfo' => $studentinfo, 'user' => $userinf, 'semesterfee' => $fees]);
        //dd($studentinfo);
    }

    public function debit_wallet(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'confirmamount' => 'required',
        ]);

        $amount = $request->input('amount');
        $camount = $request->input('confirmamount');
        $id = $request->input('studntid');

        if ($amount !== $camount) {
            toastr()->warning('Amount Entered Do Not Match');

            return Redirect()->back();
        }

        $user = User::findorfail($id);
        $user->deposit($amount, ['Trantype' => 'WALLET TOPUP/DEPOSITE', 'Reference' => 'DEPOSITE']);

        return Redirect()->back()->with('message', 'Amount Debited Successfully!');
    }

    public function all_transactions()
    {
        $wallet = DB::table('transactions')->latest()->get();
        $user = User::all();
        $studentinfo = Studentinfo::all();

        return view('Accounts.transactions', ['transaction' => $wallet,
            'user' => $user, 'studentinfo' => $studentinfo, ]);
    }

    public function get_transactions()
    {
        $studentinfo = Studentinfo::all();

        $wallet = DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.payable_id')
            ->select([
                'users.id', 'transactions.payable_id', 'users.name',
                'users.indexnumber', 'transactions.created_at', 'transactions.meta',
                'transactions.uuid', 'transactions.amount', 'transactions.id AS tranid',
            ])->orderBy('transactions.id', 'Desc')->get();

        $studentinfo = Studentinfo::all();

        return Datatables::of($wallet)
            ->addColumn('session', function ($user) use ($studentinfo) {
                foreach ($studentinfo as $key => $row) {
                    if ($user->payable_id == $row->user_id) {
                        return $row->session;
                    }
                }
            })
            ->addColumn('trtype', function ($user) {
                $data = json_decode($user->meta, true);

                return $data['Trantype'];
            })
            ->addColumn('trrefrence', function ($user) {
                $data = json_decode($user->meta, true);

                return $data['Reference'];
            })
            ->addColumn('revert', function ($user) {
                $data = json_decode($user->meta, true);
                if (isset($data['revert'])) {
                    return $data['revert'];
                }

                return 'false';
            })
            ->addColumn('program', function ($user) use ($studentinfo) {
                foreach ($studentinfo as $key => $row) {
                    if ($user->payable_id == $row->user_id) {
                        return $row->programme;
                    }
                }
            })
            ->addColumn('refund', function ($user) {
                return $user->tranid;
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function revert_transactions(Request $request): void
    {
        $id = $request->post('id');
        $wallet = DB::table('transactions')->where('id', $id)->first();

        $amount = (int) substr($wallet->amount, 1);

        //dd($amount);

        $type = $wallet->type;

        $data = json_decode($wallet->meta, true);

        $transactiontype = $data['Trantype'];
        $transactionreference = $data['Reference'];

        $tranupdate = '{"Trantype":"' . $transactiontype . '","Reference":"' . $transactionreference . '","revert":"true"}';

        //dd($tranupdate);

        $user_id = $wallet->payable_id;

        $user = User::findorfail($user_id);
        $indexnumber = $user->indexnumber;

        //dd($user);

        if (isset($data['feecode'])) {
            $feecode = $data['feecode'];
        } else {

        //reverting deposite
            //dd('this is a deposite');
            $amounts = (int) $wallet->amount;

            $user->withdraw($amounts, ['Trantype' => 'WITHDRAW CASH', 'Reference' => 'CASH RECEIVED', 'revert' => 'true']);

            //$wallet->delete();
            DB::table('transactions')->delete($id);

            echo 'success';

            exit;
        }

        //dd('this is a fee code');

        DB::beginTransaction();

        try {
            $studentfee = Studentfee::where('indexnumber', $indexnumber)
                ->where('feecode', $feecode)->first();
            $paid = $studentfee->paid;
            $owed = $studentfee->owed;
            $feecode = $studentfee->feecode;

            //substract from paid
            //

            $sub = (int) $paid - $amount;
            //add to owed
            //
            $add = (int) $owed + $amount;

            //save it
            //
            $studentfee->paid = $sub;
            $studentfee->owed = $add;
            $studentfee->save();

            //debit account wallet
            //

            $user->deposit($amount, ['Trantype' => 'WALLET TOPUP/DEPOSITE', 'Reference' => 'FEE REFUND', 'revert' => 'true']);

            DB::table('transactions')->delete($id);

            DB::commit();

            echo 'success';

            exit;
        } catch (Exception $e) {
            DB::rollback();

            echo 'failed';
        }
    }

    public function get_transactions_bydate(Request $request, $start, $end)
    {
        $startdate = $start;
        $enddate = $end;

        $studentinfo = Studentinfo::all();
        $wallet = DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.payable_id')
            ->select([
                'users.id', 'transactions.payable_id', 'users.name',
                'users.indexnumber', 'transactions.created_at', 'transactions.meta',
                'transactions.uuid', 'transactions.amount',
            ])
            ->whereBetween('transactions.created_at', [$startdate, $enddate])
            ->orderBy('transactions.id', 'Desc')->get();

        $studentinfo = Studentinfo::all();

        return Datatables::of($wallet)
            ->addColumn('session', function ($user) use ($studentinfo) {
                foreach ($studentinfo as $key => $row) {
                    if ($user->payable_id == $row->user_id) {
                        return $row->session;
                    }
                }
            })
            ->addColumn('trtype', function ($user) {
                $data = json_decode($user->meta, true);

                return $data['Trantype'];
            })
            ->addColumn('trtype', function ($user) {
                $data = json_decode($user->meta, true);

                return $data['Reference'];
            })
            ->addColumn('program', function ($user) use ($studentinfo) {
                foreach ($studentinfo as $key => $row) {
                    if ($user->payable_id == $row->user_id) {
                        return $row->programme;
                    }
                }
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function makepayment()
    {
        return view('Accounts.make_payment');
    }

    // Student Online Payment

    public function pay_mandatory_fees()
    {
        $id = auth()->user()->id;

        $studentinfo = Studentinfo::where('user_id', $id)->first();

        if (!auth()->user()->hasRole('Student')) {
            return Redirect()->route('dashboard');
        }

        //get fees
        $wallet = User::with('wallet')
            ->where('id', $id)->first();

        $fees = Studentfee::where('indexnumber', $studentinfo->indexnumber)
            ->where('type', 'mandatory')->get();

        return view(
            'Accounts.student_view_mandatory',
            ['studentinfo' => $studentinfo, 'semesterfee' => $fees, 'wallet' => $wallet]
        );
    }

    public function pay_mandatory_student(Request $request)
    {
        $id = $request->post('id');
        $fee = $request->post('fee');
        $amount = $request->post('amount');

        DB::beginTransaction();

        try {
            $studentfee = Studentfee::where('id', $id)->first();
            $paid = $studentfee->paid;
            $owed = $studentfee->owed;
            $feecode = $studentfee->feecode;

            if ($paid > 0) {
                $paidnow = $amount;

                //add paynow to paid
                $feeamount = $studentfee->feeamount;
                $paidnowpaid = $paidnow + $paid;

                $owingnow = $feeamount - $paidnowpaid;

                $studentfee->paid = $paidnowpaid;
                $studentfee->owed = $owingnow;
                $studentfee->save();
            } else {
                $feeamount = $studentfee->feeamount;
                $paidnow = $amount;
                $owednow = $feeamount - $amount;

                $studentfee->paid = $paidnow;
                $studentfee->owed = $owednow;
                $studentfee->save();
            }

            $user = User::findorfail(auth()->user()->id);

            $user->withdraw($amount, ['Trantype' => 'Fees Payment', 'Reference' => $fee, 'feecode' => $feecode]);

            DB::commit();

            echo 'success';

            exit;
        } catch (Exception $e) {
            DB::rollback();

            return $e->getMessage();
        }
    }

    public function other_services_fees()
    {
        if (!auth()->user()->hasRole('Student')) {
            return Redirect()->route('dashboard');
        }

        $fees = OtherservicesFee::all();
        $wallet = User::with('wallet')
            ->where('id', auth()->user()->id)->first();

        return view(
            'Accounts.student_view_otherservices',
            ['semesterfee' => $fees, 'wallet' => $wallet]
        );
    }

    public function request_services(Request $request): void
    {
        $id = $request->post('id');
        $fee = $request->post('fee');
        $qty = $request->post('qty');
        $title = $request->post('title');
        $feecode = $request->post('feecode');
        $indexnumber = auth()->user()->indexnumber;

        $amt = $qty * $fee;

        $academicyear = Academicyear::where('status', '1')->first();
        $year = $academicyear->acdemicyear;

        $data = [
            'indexnumber' => $indexnumber,
            'fee' => $title,
            'feecode' => $feecode,
            'feeamount' => $amt,
            'paid' => 0,
            'owed' => $amt,
            'type' => 'request',
            'semester' => $year,
        ];

        $newfees = new Studentfee($data);
        $newfees->save();

        echo 'success';
    }

    public function pay_other_services_fees()
    {
        $id = auth()->user()->id;

        if (!auth()->user()->hasRole('Student')) {
            return Redirect()->route('dashboard');
        }

        $studentinfo = Studentinfo::where('user_id', $id)->first();

        if (!auth()->user()->hasRole('Student')) {
            return Redirect()->route('dashboard');
        }

        //get fees
        $wallet = User::with('wallet')
            ->where('id', $id)->first();

        $fees = Studentfee::where('indexnumber', $studentinfo->indexnumber)
            ->where('type', 'request')->get();

        return view(
            'Accounts.pay_other_request',
            ['studentinfo' => $studentinfo, 'semesterfee' => $fees, 'wallet' => $wallet]
        );
    }

    public function remove_request_services(Request $request): void
    {
        $id = $request->post('id');
        Studentfee::findorfail($id)->delete();
        echo 'success';
    }

    public function submiited_other_services_fees()
    {
        $id = auth()->user()->id;
        if (!auth()->user()->hasRole('Student')) {
            return Redirect()->route('dashboard');
        }

        $studentinfo = Studentinfo::where('user_id', $id)->first();

        //get fees
        $wallet = User::with('wallet')
            ->where('id', $id)->first();

        $fees = Studentfee::where('indexnumber', $studentinfo->indexnumber)
            ->where('type', 'request')
            ->where('owed', 0)->get();

        return view(
            'Accounts.student_req_submission',
            ['studentinfo' => $studentinfo, 'semesterfee' => $fees, 'wallet' => $wallet]
        );
    }

    public function print_statement()
    {
        if (!auth()->user()->hasRole('Student')) {
            return Redirect()->route('dashboard');
        }

        return view('Accounts.print_statement');
    }

    public function print_statement_generate($start, $end)
    {
        $transaction = DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.payable_id')
            ->select([
                'users.id', 'transactions.payable_id', 'users.name',
                'users.indexnumber', 'transactions.created_at', 'transactions.type', 'transactions.meta',
                'transactions.uuid', 'transactions.amount',
            ])
            ->where('users.id', auth()->user()->id)
            ->whereBetween('transactions.created_at', [$start, $end])
            ->orderBy('transactions.id', 'Desc')->get();

        //dd($transaction);

        $studeninfo = Studentinfo::where('user_id', auth()->user()->id)->first();

        $wallet = User::with('wallet')
            ->where('id', auth()->user()->id)->first();

        //dd($wallet);

        $this->fpdf = new pdfs();
        $this->fpdf->AliasNbPages();

        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->AddPage('L');
        $this->fpdf->Cell(270, 10, 'OGUA SCHOOL MANAGEMENT SYSTEM', 0, 1, 'C');
        // $this->fpdf->ln(3);

        //walletID
        $this->fpdf->SetFont('Arial');
        $this->fpdf->Cell(27, 5, '', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Cell(40, 5, '', 0, 1, 'L');

        $this->fpdf->SetFont('Arial');
        $this->fpdf->Cell(260, 5, 'As on ' . date('m/d/Y'), 0, 1, 'R');

        $this->fpdf->SetFont('Arial');
        $this->fpdf->Cell(20, 5, 'Wallet ID:', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Cell(40, 5, $wallet->id, 0, 1, 'L');

        // //Studentname
        $this->fpdf->SetFont('Arial');
        $this->fpdf->Cell(29, 5, 'Student Name:', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Cell(40, 5, ucwords(strtolower($studeninfo->fullname)), 0, 1, 'L');

        // //programme
        $this->fpdf->SetFont('Arial');
        $this->fpdf->Cell(25, 5, 'Programme:', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Cell(40, 5, ucwords(strtolower($studeninfo->programme . ' (' . $studeninfo->session . ')')), 0, 1, 'L');

        // Wallet Balance
        $this->fpdf->SetFont('Arial');
        $this->fpdf->Cell(30, 5, 'Wallet Balance:', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Cell(40, 5, $wallet->balance . '.00', 0, 1, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Cell(10, 10, 'Sr', 0, 0, 'L');
        $this->fpdf->Cell(50, 10, 'Transaction Type', 0, 0, 'L');
        $this->fpdf->Cell(40, 10, 'Amount (GH¢)', 0, 0, 'C');
        $this->fpdf->Cell(45, 10, 'Date', 0, 0, 'C');
        $this->fpdf->Cell(66, 10, 'Reference', 0, 1, 'L');

        $loop = 1;
        foreach ($transaction as $row) {
            $data = json_decode($row->meta, true);

            $amount = $row->amount;
            $type = $row->type;

            if ('withdraw' == $type) {
                $real = (int) substr($amount, 1);
            } else {
                $real = (int) $amount;
            }

            $this->fpdf->SetFont('Arial');
            $this->fpdf->Cell(10, 10, $loop, 0, 0, 'L');
            $this->fpdf->Cell(50, 10, ucfirst(strtolower($data['Trantype'])), 0, 0, 'L');
            $this->fpdf->Cell(40, 10, $real . '.00', 0, 0, 'R');
            $this->fpdf->Cell(45, 10, date('jS M y', strtotime($row->created_at)), 0, 0, 'C');
            $this->fpdf->Cell(66, 10, ucfirst(strtolower($data['Reference'])), 0, 1, 'L');
            ++$loop;
        }

        return response($this->fpdf->Output('D', 'student-statement.pdf'))
            ->header('Content-Type', 'application/pdf');
    }

    public function ledge_account()
    {
        if (!auth()->user()->hasRole('Student')) {
            return Redirect()->route('dashboard');
        }

        return view('Accounts.walletledger');
    }

    public function wallet_ledger_report($start, $end)
    {
        $transaction = DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.payable_id')
            ->select([
                'users.id', 'transactions.payable_id', 'users.name',
                'users.indexnumber', 'transactions.created_at', 'transactions.type', 'transactions.meta',
                'transactions.uuid', 'transactions.amount',
            ])
            ->where('users.id', auth()->user()->id)
            ->whereBetween('transactions.created_at', [$start, $end])
            ->orderBy('transactions.id', 'ASC')->get();

        $studeninfo = Studentinfo::where('user_id', auth()->user()->id)->first();

        $wallet = User::with('wallet')
            ->where('id', auth()->user()->id)->first();

        //dd($wallet);

        $this->fpdf = new pdfs();
        $this->fpdf->AliasNbPages();

        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->AddPage('L');
        $this->fpdf->Cell(270, 10, 'WALLET LEDGER REPORT', 0, 1, 'C');
        // $this->fpdf->ln(3);

        //walletID
        $this->fpdf->SetFont('Arial');
        $this->fpdf->Cell(27, 5, '', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Cell(40, 5, '', 0, 1, 'L');

        $this->fpdf->SetFont('Arial', 'B');
        $this->fpdf->Cell(20, 5, 'FROM:', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 12);
        $this->fpdf->Cell(50, 5, $start, 0, 0, 'L');

        $this->fpdf->SetFont('Arial', 'B');
        $this->fpdf->Cell(25, 5, 'Student:', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 12);
        $this->fpdf->Cell(40, 5, auth()->user()->name, 0, 1, 'L');

        $this->fpdf->SetFont('Arial', 'B');
        $this->fpdf->Cell(20, 5, 'TO:', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 12);
        $this->fpdf->Cell(50, 5, $end, 0, 0, 'L');

        $time = \Carbon\Carbon::now();
        $this->fpdf->SetFont('Arial', 'B');
        $this->fpdf->Cell(25, 5, 'DATETIME', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 12);
        $this->fpdf->Cell(40, 5, $time->toDateTimeString(), 0, 1, 'L');

        $this->fpdf->SetFont('Arial', 'B');
        $this->fpdf->Cell(20, 5, 'SEARCH:', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 12);
        $this->fpdf->Cell(50, 5, 'N/A', 0, 0, 'L');

        $this->fpdf->SetFont('Arial', 'B');
        $this->fpdf->Cell(20, 5, 'Wallet ID:', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 12);
        $this->fpdf->Cell(50, 5, $wallet->id, 0, 0, 'L');

        $this->fpdf->SetFont('Arial', 'B');
        $this->fpdf->Cell(25, 5, 'CURRENCY', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 12);
        $this->fpdf->Cell(40, 5, 'GH¢', 0, 1, 'L');

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Cell(35, 10, 'Transaction Date', 'B', 0, 'L');
        $this->fpdf->Cell(30, 10, 'Value Date', 'B', 0, 'L');
        $this->fpdf->Cell(100, 10, 'Description', 'B', 0, 'L');
        $this->fpdf->Cell(25, 10, 'Debit', 'B', 0, 'R');
        $this->fpdf->Cell(25, 10, 'Credit', 'B', 0, 'R');
        $this->fpdf->Cell(28, 10, 'Balance', 'B', 1, 'R');

        $loop = 1;
        $total = 0;

        foreach ($transaction as $row) {
            $data = json_decode($row->meta, true);

            $amount = $row->amount;
            $type = $row->type;

            if ('withdraw' == $type) {
                $real = (int) substr($amount, 1);
            } else {
                $real = (int) $amount;
            }

            $total += $amount;

            $this->fpdf->SetFont('Arial');
            $this->fpdf->Cell(35, 10, date('d/m/Y', strtotime($row->created_at)), 1, 0, 'L');
            $this->fpdf->Cell(30, 10, date('d/m/Y', strtotime($row->created_at)), 1, 0, 'L');

            $this->fpdf->Cell(100, 10, ucfirst(strtolower($data['Reference'])), 'B', 0, 'L');

            if ($amount < 0) {
                $this->fpdf->Cell(25, 10, $amount . '.00', 1, 0, 'R');
                $this->fpdf->Cell(25, 10, '', 1, 0, 'R');
            } else {
                $this->fpdf->Cell(25, 10, '', 1, 0, 'R');
                $this->fpdf->Cell(25, 10, $amount . '.00', 1, 0, 'R');
            }

            $this->fpdf->Cell(28, 10, $total . '.00', 1, 1, 'R');

            ++$loop;
        }

        return response($this->fpdf->Output('D', 'wallet-ledger.pdf'))
            ->header('Content-Type', 'application/pdf');
    }

    public function transaction_history_student()
    {
        if (!auth()->user()->hasRole('Student')) {
            return Redirect()->route('dashboard');
        }
        $id = auth()->user()->id;
        $wallet = DB::table('transactions')
            ->where('payable_id', $id)->latest()->get();
        $user = User::findorfail($id);
        $studentinfo = Studentinfo::where('user_id', $id)->first();

        return view('Accounts.student_transaction_history', ['transaction' => $wallet,
            'user' => $user, 'studentinfo' => $studentinfo, ]);
    }

    public function payment_deadline(Request $request): void
    {
        $date = $request->post('deadline');

        $cademicyear = Academicyear::where('status', 1)->first();
        $academic = $cademicyear->acdemicyear;
        $semester = $cademicyear->semester;

        $data = [
            'deadline' => $date,
            'acdemicyear' => $academic,
            'semester' => $semester,
            'date' => date('Y-m-d'),
        ];

        $add = new Paymentdeadline($data);
        $add->save();
    }

    public function register_course_student($prog, $currentlevel, $semester, $academicyear, $indexnumber, $userid)
    {

        //check if student has paid fess
        $fees = Studentfee::where('indexnumber', $indexnumber)->get();

        //dd($fees);

        if (\count($fees) > 0) {
            // code...
        } else {
            toastr()->warning('Course Registration Under Contruction, Check in Later, or make sure all financial obligations has been met!');

            return Redirect()->back();
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

                    if ($paid < $half) {
                        toast('Please Make sure, all financial obligations are met to proceed!', 'error');

                        return Redirect()->back();
                    }
                }
            }
        } else {
            //for second semester
            $feessum = Studentfee::where('indexnumber', $indexnumber)->sum('owed');

            if (1 > $feessum) {
            } else {
                toastr()->warning('Please Make sure, all financial obligations are met to proceed!');

                return Redirect()->back();
            }
        }

        $cousereg = Coureregistration::where('semester', $semester)
            ->where('academic_year', $academicyear)
            ->where('user_id', $userid)->get();

        if (\count($cousereg) > 0) {
            toastr()->warning('Course Has Already Been Registered!');

            return Redirect()->back();
        }

        //get courses from Programmes and their course
        $Progcouse = Programmecourse::where('programme', $prog)
            ->where('level', $currentlevel)->where('semester', $semester)->get();

        $countcourse = $Progcouse->count();
        $stuinfo = Studentinfo::where('user_id', $userid)->first();

        foreach ($Progcouse as $courses) {
            $code = $courses->coursecode;
            $codetittle = $courses->coursetitle;
            $credithours = $courses->credithours;

            $data = [
                'user_id' => $userid,
                'indexnumber' => $indexnumber,
                'cource_code' => $code,
                'level' => $currentlevel,
                'cource_title' => $codetittle,
                'credithours' => $credithours,
                'semester' => $semester,
                'session' => $stuinfo->session,
                'academic_year' => $academicyear,
            ];

            $cousereg = new Coureregistration($data);
            $cousereg->save();
        }

        //add semester record into the database

        $regdata = [
            'user_id' => $userid,
            'semester' => $semester,
            'academicyear' => $academicyear,
        ];

        $userreg = new Regacademicyear($regdata);
        $userreg->save();

        return Redirect()->route('print_course_student', ['prog' => $prog, 'currentlevel' => $currentlevel, 'semester' => $semester, 'academicyear' => $academicyear, 'userid' => $userid]);
    }

    public function print_course_student($prog, $currentlevel, $semester, $academicyear, $userid)
    {
        $cousereg = Coureregistration::where('semester', $semester)
            ->where('academic_year', $academicyear)
            ->where('user_id', $userid)
            ->orWhere('resit', '1')->get();

        $studentinfo = Studentinfo::where('user_id', $userid)->first();
        //dd($cousereg);
        return view('CourseRegistration.prin_courses_reg', ['courses' => $cousereg, 'academicyear' => $academicyear, 'semester' => $semester, 'studentinfo' => $studentinfo]);
    }

    public function register_resit_student($indexnumber, $userid)
    {
        $peronalinfo = User::join('studentinfos', 'users.id', '=', 'studentinfos.user_id')
            ->where('studentinfos.user_id', $userid)->first();

        $regsem = Regacademicyear::where('user_id', $peronalinfo->user_id)->get();

        $creg = Coureregistration::where('user_id', $peronalinfo->user_id)->get();

        $exresults = Examresults::where('user_id', $peronalinfo->user_id)->get();

        return view('Accounts.student_course', ['personal' => $peronalinfo, 'course' => $creg, 'regsem' => $regsem, 'examsresults' => $exresults]);
    }

    public function resit_student_save(Request $request)
    {
        $id = $request->post('cid');
        $creg = Coureregistration::where('id', $id)->first();
        $creg->resit = 1;
        $creg->save();

        return Response::json([
            'success' => true,
            'msg' => 'Resit Registered Successfully!',
        ], 200);
    }

    public function top_up_wallet()
    {
        $student = Studentinfo::where('user_id', auth()->user()->id);
        //dd($student);
        return view('Accounts.wallet-top-up', ['student' => $student]);
    }

    public function save_top_up_wallet(Request $request): void
    {
        $name = $request->post('fullname');
        $index = $request->post('indexnumber');
        $amount = $request->post('amount');
        $trid = $request->post('trid');

        $data = [
            'tr_id' => $trid,
            'fullname' => $name,
            'indexnumber' => $index,
            'amount' => $amount,
        ];

        $new = new Wallettop($data);
        $new->save();
    }

    public function get_wallet_details(Request $request): void
    {
        $nvoice = 'TST556359522145';
        $curl = curl_init();

        curl_setopt_array($curl, [
            \CURLOPT_URL => 'https://manage.ipaygh.com/gateway/json_status_chk?merchant_key=5c841bf2-d29b-11e7-aebc-f23c9170642f&invoice_id=' . $nvoice,
            \CURLOPT_RETURNTRANSFER => true,
            \CURLOPT_ENCODING => '',
            \CURLOPT_MAXREDIRS => 10,
            \CURLOPT_TIMEOUT => 0,
            \CURLOPT_FOLLOWLOCATION => true,
            \CURLOPT_HTTP_VERSION => \CURL_HTTP_VERSION_1_1,
            \CURLOPT_CUSTOMREQUEST => 'GET',  ]);

        $response = curl_exec($curl);

        curl_close($curl);
        $tr = json_decode($response);

        $success = $tr->$nvoice->success;
        $status = $tr->$nvoice->status;
        $buyer_firstname = $tr->$nvoice->buyer_firstname;
        $buyer_lastname = $tr->$nvoice->buyer_lastname;
        $buyer_email = $tr->$nvoice->buyer_email;
        $buyer_phone = $tr->$nvoice->buyer_phone;
        $payment_reference = $tr->$nvoice->payment_reference;
        $payment_instrument = $tr->$nvoice->payment_instrument;
        $amount = $tr->$nvoice->amount;
        $total_amount_charged = $tr->$nvoice->total_amount_charged;
        $status_reason = $tr->$nvoice->status_reason;
        $service_fee = $tr->$nvoice->service_fee;
        $date = $tr->$nvoice->as_at;
        $narration = $tr->$nvoice->narration;
        $invoice_id = $tr->$nvoice->invoice_id;
        $tran_type = $tr->$nvoice->tran_type;
        $wallet_issuer_hint = $tr->$nvoice->extra->wallet_issuer_hint;
        $channel = $tr->$nvoice->extra->channel;
        $card_type = $tr->$nvoice->extra->card_type;
        $mobile_no = $tr->$nvoice->extra->mobile_no;
        $name = $tr->$nvoice->extra->name;
        $wallet_issuer_hint = $tr->$nvoice->extra->email;

        print_r($tr);
    }

    public function payment_successful()
    {
        $student = Studentinfo::findorfail(auth()->user()->id);

        return view('Accounts.payment_success', ['student' => $student]);
    }

    public function payment_failed()
    {
        $student = Studentinfo::findorfail(auth()->user()->id);

        return view('Accounts.payment_failed', ['student' => $student]);
    }
}
