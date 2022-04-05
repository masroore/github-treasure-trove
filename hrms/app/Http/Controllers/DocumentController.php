<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Auth;
use Illuminate\Http\Request;
use Validator;

class DocumentController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Manage Document Type')) {
            $documents = Document::where('created_by', '=', Auth::user()->creatorId())->get();

            return view('document.index', compact('documents'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function create()
    {
        if (Auth::user()->can('Create Document Type')) {
            return view('document.create');
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Document Type')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:20',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $document = new Document();
            $document->name = $request->name;
            $document->is_required = $request->is_required;
            $document->created_by = Auth::user()->creatorId();
            $document->save();

            return redirect()->route('document.index')->with('success', __('Document type successfully created.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function show(Document $document)
    {
        return redirect()->route('document.index');
    }

    public function edit(Document $document)
    {
        if (Auth::user()->can('Edit Document Type')) {
            if ($document->created_by == Auth::user()->creatorId()) {
                return view('document.edit', compact('document'));
            }

            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return response()->json(['error' => __('Permission denied.')], 401);
    }

    public function update(Request $request, Document $document)
    {
        if (Auth::user()->can('Edit Document Type')) {
            if ($document->created_by == Auth::user()->creatorId()) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|max:20',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $document->name = $request->name;
                $document->is_required = $request->is_required;
                $document->save();

                return redirect()->route('document.index')->with('success', __('Document type successfully updated.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function destroy(Document $document)
    {
        if (Auth::user()->can('Delete Document Type')) {
            if ($document->created_by == Auth::user()->creatorId()) {
                $document->delete();

                return redirect()->route('document.index')->with('success', __('Document type successfully deleted.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
