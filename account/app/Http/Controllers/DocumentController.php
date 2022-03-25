<?php

namespace App\Http\Controllers;

use App\DocumentEntry;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        // if(\Auth::user()->can('manage assets'))
        // {
        // $assets = DocumentEntry::where('created_by', '=', \Auth::user()->creatorId())->get();

        return view('dcoument_entry.index', compact('dcoument_entry'));
        // }
        // else
        // {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }

    public function create()
    {
        if (\Auth::user()->can('create assets')) {
            return view('dcoument_entry.create');
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create assets')) {
            $validator = \Validator::make(
                $request->all(),
                [
                                   'payment_text' => 'required',
                                   'file_type' => 'required',
                               ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            if (!empty($request->file_upload)) {
                $filenameWithExt = $request->file('file_upload')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, \PATHINFO_FILENAME);
                $extension = $request->file('file_upload')->getClientOriginalExtension();
                $fileNameToStores = $filename . '_' . time() . '.' . $extension;
                $dir = storage_path('uploads/is_cover_image/');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $path = $request->file('is_cover_image')->storeAs('uploads/logo/', $fileNameToStores);
                // $logo         = asset(Storage::url('uploads/logo/'));
                // $company_logo = Utility::getValByName('company_logo');
                // $img          = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo.png'));
            }
            $assets = new DocumentEntry();
            $assets->payment_text = $request->payment_text;
            $assets->file_type = $request->file_type;
            $assets->file_upload = !empty($request->file_upload) ? $fileNameToStores : 'default.jpg';
            // $assets->supported_date = $request->supported_date;
            // $assets->amount         = $request->amount;
            // $assets->description    = $request->description;
            $assets->created_by = \Auth::user()->creatorId();
            $assets->save();

            return redirect()->route('dcoument_entrys.index')->with('success', __('Document successfully created.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function show(Asset $asset)
    {

    }

    public function edit($id)
    {
        if (\Auth::user()->can('edit assets')) {
            $asset = DocumentEntry::find($id);

            return view('dcoument_entry.edit', compact('asset'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit assets')) {
            $asset = DocumentEntry::find($id);
            if ($asset->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                                        'payment_text' => 'required',
                                        'file_type' => 'required',
                                   ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                if (!empty($request->file_upload)) {
                    $filenameWithExt = $request->file('file_upload')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, \PATHINFO_FILENAME);
                    $extension = $request->file('file_upload')->getClientOriginalExtension();
                    $fileNameToStores = $filename . '_' . time() . '.' . $extension;
                    $dir = storage_path('uploads/is_cover_image/');
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $path = $request->file('is_cover_image')->storeAs('uploads/logo/', $fileNameToStores);
                    // $logo         = asset(Storage::url('uploads/logo/'));
                    // $company_logo = Utility::getValByName('company_logo');
                    // $img          = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo.png'));
                }
                $asset->payment_text = $request->payment_text;
                $asset->file_type = $request->file_type;
                // $asset->supported_date = $request->supported_date;
                // $asset->amount         = $request->amount;
                // $asset->description    = $request->description;
                $asset->save();

                return redirect()->route('dcoument_entry.index')->with('success', __('Document successfully updated.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('delete assets')) {
            $asset = DocumentEntry::find($id);
            if ($asset->created_by == \Auth::user()->creatorId()) {
                $asset->delete();

                return redirect()->route('dcoument_entry.index')->with('success', __('Document successfully deleted.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
