<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SmtpInformation;
use Crypt;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SmtpDetailsController extends Controller
{
    public function __construct()
    {
    }

    /*
    Method Name:    getList
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To fetch list of all smtp
    Params:
    */
    public function getList(Request $request)
    {
        $data = SmtpInformation::when($request->search_keyword, function ($q) use ($request): void {
            $q->where('host', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('id', $request->search_keyword)
                ->orWhere('from_email', 'like', '%' . $request->search_keyword . '%');
        })->sortable('id')->paginate(Config::get('constants.PAGINATION_NUMBER'));

        return view('admin.smtp.list', compact('data'));
    }
    // End Method getList

    /*
    Method Name:    edit_form
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        Form to update smtp details
    Params:         [id]
    */
    public function edit_form($id)
    {
        $record = SmtpInformation::find($id);
        if (!$record) {
            return redirect()->route('smtp.list');
        }

        return view('admin.smtp.edit', compact('record'));
    }
    // End Method edit_form

    /*
    Method Name:    update_record
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To update smtp details
    Params:         [edit_record_id, host, port, username, from_email, from_name, password, encryption, status]
    */
    public function update_record(Request $request)
    {
        $request->validate([
            'host' => 'required',
            'port' => 'required',
            'username' => 'required',
            'from_email' => 'required|email',
            'from_name' => 'required',
            'password' => 'required',
            'encryption' => 'required',
            'status' => 'required',
        ]);

        try {

            //$request->password = Crypt::encrypt($request->password);
            $data = [
                'host' => $request->host,
                'port' => $request->port,
                'from_email' => $request->from_email,
                'username' => $request->username,
                'from_name' => $request->from_name,
                'password' => $request->password,
                'encryption' => $request->encryption,
                'status' => $request->status,
            ];
            $record = SmtpInformation::where('id', $request->edit_record_id)->update($data);

            return redirect()->route('smtp.list')->with('status', 'success')->with('message', 'SMTP detail ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch (Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }
    // End Method update_record
}
