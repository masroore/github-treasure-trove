<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsers;
use App\Http\Requests\UpdateUsers;
use App\Models\Chart;
use App\Models\Countries;
use App\Models\Transaction;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function main(Request $request)
    {
        $transaction = Transaction::all();
        $monthUser = User::groupBy('date')
            ->orderBy('date', 'desc')
            ->take(6)
            ->get([
                DB::raw('MONTH(created_at) as date'),
                DB::raw('count(id) as total'),
            ])
            ->pluck('total', 'date');
        // dd($monthUser);
        $groups = DB::table('users')
            ->select('account_type', DB::raw('count(*) as total'))
            ->groupBy('account_type')
            ->pluck('total', 'account_type')->all();
        // Generate random colours for the groups
        for ($i = 0; $i <= \count($groups); ++$i) {
            $colours[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        }
        // Prepare the data for returning with the view
        $chart = new Chart();
        $chart->labels = (array_keys($groups));
        $chart->dataset = (array_values($groups));
        $chart->colours = $colours;
        // return view('charts.index', compact('chart'));

        return View::make('admin.index')->with([
            'transactions' => $transaction,
            'chart' => $chart,
        ]);
    }

    public function index(Request $request)
    {
        $freelancers = User::with('userSkills', 'saveInfo')->whereaccount_type('Freelancer')->get();

        return View::make('admin.freelancers-list')->with([
            'freelancers' => $freelancers,
        ]);
    }

    public function adminLogin(Request $request)
    {
        if ($request->isMethod('post')) {
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'admin'])) {
                //Authentication passed...
                if (Auth::guard('admin')->check()) {
                    // dd(Auth::guard('tech')->user()->name );
                    $freelancers = User::with('userSkills', 'saveInfo')->whereaccount_type('Freelancer')->get();
                    // return View::make('admin.freelancers-list')->with([
                    //     'freelancers' => $freelancers
                    // ]);
                    return redirect(RouteServiceProvider::ADMIN);
                }
            }
        }

        return view('admin.auth.login');
    }

    // Clients List
    public function clientsList(Request $request)
    {
        $clients = User::with('userSkills', 'saveInfo')->whereaccount_type('Client')->get();

        return View::make('admin.clients-list')->with([
            'clients' => $clients,
        ]);
    }

    // Blocked Users List
    public function blockedUsers(Request $request)
    {
        $blockedusers = User::with('userSkills', 'saveInfo')->whereaccount_type('Freelancer')->where('status', 'block')->get();

        return View::make('admin.blocked-users-list')->with([
            'blockedusers' => $blockedusers,
        ]);
    }

    public function unblockUsers(Request $request, $id)
    {
        $unblock = User::where('id', $id)->update(['status' => 'active']);
        if ($unblock) {
            return response()->json(['status' => 'true', 'message' => 'User unblocked'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'error occured please try again'], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Countries::get();

        return \View::make('admin.user-create')->with([
            'countries' => $countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsers $request)
    {
        $validatedData = $request->validated();
        $user = new User();
        $user->first_name = $validatedData['first_name'];
        $user->last_name = $validatedData['last_name'];
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->account_type = $validatedData['account_type'];
        $full_number = str_replace('+', '', $request->input('full'));
        $country_code = str_replace($request->input('mobile_number'), '', $full_number);
        // dd($country_code);
        $mobile_number = $request->input('mobile_number');
        $country = Countries::where('phonecode', $country_code)->orwhere('phonecode', '+' . $country_code)->first()->name;
        $user->password = Hash::make(trim($validatedData['password']));
        $user->mobile_number = $full_number;
        $user->user_status = 'offline';
        $user->remember_token = $request->input('_token');
        $user->country = $country;

        if ($user->save()) {
            return response()->json(['status' => 'true', 'message' => 'User added successfully', 'userType' => $user->account_type], 200);
        }

        return response()->json(['status' => 'errorr', 'message' => 'error occured please try again'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $getSingleData = User::find($id);

        return \View::make('admin.user-update', compact('getSingleData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsers $request, $id)
    {
        $validatedData = $request->validated();
        $findData = User::find($id);

        $findData->first_name = $validatedData['first_name'];
        $findData->last_name = $validatedData['last_name'];
        $findData->username = $validatedData['username'];
        $findData->email = $validatedData['email'];
        $findData->account_type = $validatedData['account_type'];
        $full_number = str_replace('+', '', $request->input('full'));
        $country_code = str_replace($request->input('mobile_number'), '', $full_number);
        // dd($country_code);
        $mobile_number = $request->input('mobile_number');
        $country = Countries::where('phonecode', $country_code)->orwhere('phonecode', '+' . $country_code)->first()->name;
        $findData->password = Hash::make(trim($validatedData['password']));
        $findData->mobile_number = $full_number;
        $findData->user_status = 'offline';
        $findData->remember_token = $request->input('_token');
        $findData->country = $country;

        if ($findData->save()) {
            return response()->json(['status' => 'true', 'message' => 'User updated successfully', 'userType' => $findData->account_type], 200);
        }

        return response()->json(['status' => 'errorr', 'message' => 'error occured please try again'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteData = User::find($id);
        if ($deleteData->delete()) {
            return response()->json(['status' => 'true', 'message' => 'User deleted successfully'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'error occured please try again'], 200);
    }

    // Verification List
    public function verificationList(Request $request)
    {
        $users = User::where('verification_image', '!=', '')->where('verification', 1)->get();

        return \View::make('admin.verification-request')->with([
            'users' => $users,
        ]);
    }

    public function verify(Request $request, $id)
    {
        $user = User::find($id);
        $user->verification = 2;

        if ($user->save()) {
            return response()->json(['status' => 'true', 'message' => 'User Verified successfully'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'error occured please try again'], 200);
    }

    public function rejectVerify(Request $request, $id)
    {
        $user = User::find($id);
        $user->verification = 1;

        if ($user->save()) {
            return response()->json(['status' => 'true', 'message' => 'User Verified successfully'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'error occured please try again'], 200);
    }

    public function live()
    {
        return '';
    }
}
