<?php

namespace App\Http\Controllers;

use App\DocumentEntries;
use Auth;
use Illuminate\Http\Request;
use Validator;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //  $assets = Asset::where('created_by', '=', \Auth::user()->creatorId())->get();

        //     return view('assets.index', compact('assets'));
        $documents = DocumentEntries::where('created_by', '=', Auth::user()->creatorId())->get();
        // var_dump($documents);
        // exit();
        return view('documentEntries.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->can('create documents')) {
            return view('documentEntries.create');
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('create documents')) {
            $validator = Validator::make(
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
                // $img_ext = $request->file('file_upload')->getClientOriginalExtension();
                // $filename = 'company-logo-' . time() . '.' . $img_ext;
                // // $path = $request->file('file_upload')->move(public_path(), $filename);//image save public folder
                // $path = $request->file('file_upload')->storeAs('uploads/documents/', $filename);
                // echo $path;
                // exit();
                $filenameWithExt = $request->file('file_upload')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, \PATHINFO_FILENAME);
                $extension = $request->file('file_upload')->getClientOriginalExtension();
                $fileNameToStores = $filename . '_' . time() . '.' . $extension;

                // echo $fileNameToStores =  '_' . time();
                $dir = storage_path('uploads/documents/');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $path = $request->file('file_upload')->storeAs('uploads/documents/', $fileNameToStores);

                // $logo         = asset(Storage::url('uploads/logo/'));
                // $company_logo = Utility::getValByName('company_logo');
                // $img          = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo.png'));
            }
            $documents = new DocumentEntries();

            $documents->payment_text = $request->payment_text;
            $documents->file_type = $request->file_type;

            $documents->file_upload = !empty($request->file_upload) ? $fileNameToStores : 'default.jpg';
            $documents->created_by = Auth::user()->creatorId();
            $documents->save();

            return redirect()->route('document-entry.index')->with('success', __('Document successfully created.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
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
        if (Auth::user()->can('edit documents')) {
            $document = DocumentEntries::find($id);
            // var_dump($document);
            return view('documentEntries.edit', compact('document'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
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
        if (Auth::user()->can('edit documents')) {
            $asset = DocumentEntries::find($id);
            if ($asset->created_by == Auth::user()->creatorId()) {
                $validator = Validator::make(
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
                    // $img_ext = $request->file('file_upload')->getClientOriginalExtension();
                    // $filename = 'company-logo-' . time() . '.' . $img_ext;
                    // // $path = $request->file('file_upload')->move(public_path(), $filename);//image save public folder
                    // $path = $request->file('file_upload')->storeAs('uploads/documents/', $filename);
                    // echo $path;
                    // exit();
                    $filenameWithExt = $request->file('file_upload')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, \PATHINFO_FILENAME);
                    $extension = $request->file('file_upload')->getClientOriginalExtension();
                    $fileNameToStores = $filename . '_' . time() . '.' . $extension;

                    // echo $fileNameToStores =  '_' . time();
                    $dir = storage_path('uploads/documents/');
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $path = $request->file('file_upload')->storeAs('uploads/documents/', $fileNameToStores);
                    $asset->file_upload = !empty($request->file_upload) ? $fileNameToStores : 'default.jpg';
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

                return redirect()->route('document-entry.index')->with('success', __('Document successfully updated.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
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
        if (Auth::user()->can('delete documents')) {
            $document = DocumentEntries::find($id);
            if ($document->created_by == Auth::user()->creatorId()) {
                $document->delete();

                return redirect()->route('document-entry.index')->with('success', __('Document successfully deleted.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
