<?php

namespace App\Http\Controllers\Admin;

use App\AutoResponder;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class AutoResponderController extends Controller
{
    public function __construct()
    {
    }

    /*
    Method Name:    getList
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To get all added templates
    Params:
    */
    public function getList(Request $request)
    {
        if ($request->has('search_keyword') && $request->search_keyword != '') {
            $keyword = $request->search_keyword;
        } else {
            $keyword = '';
        }
        $data = AutoResponder::when($request->search_keyword, function ($q) use ($request): void {
            $q->where('template_name', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('template', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('id', $request->search_keyword);
        })
            ->sortable('id')
            ->paginate(Config::get('constants.PAGINATION_NUMBER'));

        return view('admin.autoresponder.list', compact('data', 'keyword'));
    }
    // End Method getList

    /*
    Method Name:    update_record
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To update template details
    Params:         [edit_record_id, subject, template_name, template, status]
    */
    public function edit_form($id)
    {
        $record = AutoResponder::find($id);
        if (!$record) {
            return redirect()->route('autoresponder.list');
        }

        return view('admin.autoresponder.edit', compact('record'));
    }
    // End Method edit_form

    /*
    Method Name:    update_record
    Developer:      Shine Dezign
    Created Date:   2020-12-22 (yyyy-mm-dd)
    Purpose:        To update template details
    Params:         [edit_record_id, subject, template_name, template, status]
    */
    public function update_record(Request $request)
    {
        $request->validate(['subject' => 'required', 'template' => 'required']);

        try {
            $data = [
                'subject' => $request->subject,
                'template' => $request->template,
            ];
            $record = AutoResponder::where('id', $request->edit_record_id)
                ->update($data);

            return redirect()->route('autoresponder.list')
                ->with('status', 'success')
                ->with('message', 'Auto responder template ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch (Exception $e) {
            return redirect()->back()
                ->with('status', 'error')
                ->with('message', $e->getMessage());
        }
    }
    // End Method update_record
}
