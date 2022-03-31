<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = ReportUser::with('freelancer', 'user')->get();

        return View::make('admin.reports-list')->with([
        'reports' => $reports,
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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
        $deleteData = ReportUser::find($id);
        if ($deleteData->delete()) {
            return response()->json(['status'=>'true', 'message' => 'Report deleted successfully'], 200);
        }

        return response()->json(['status'=>'error', 'message' => 'error occured please try again'], 200);
    }

    // Block User

    public function blockUser(Request $request, $id)
    {
        $getSingleData = ReportUser::find($id);
        $getSingleData->status = 1;
        $blockuser = User::where('id', $getSingleData->user_id)->update(['status' => 'block']);
        if ($blockuser) {
            $getSingleData->save();

            return response()->json(['status'=>'true', 'message' => 'User Blocked'], 200);
        }

        return response()->json(['status'=>'error', 'message' => 'error occured please try again'], 200);
    }
}
