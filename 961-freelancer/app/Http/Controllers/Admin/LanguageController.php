<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::all();

        return \View::make('admin.languages-list')->with([
          'languages' => $languages,
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \View::make('admin.language-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $language = new Language();
        $language->language_name = $request->input('language_name');

        if ($language->save()) {
            return response()->json(['status'=>'true', 'message' => 'Language added successfully'], 200);
        }

        return response()->json(['status'=>'errorr', 'message' => 'error occured please try again'], 200);
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
        $getSingleData = Language::find($id);

        return \View::make('admin.language-update', compact('getSingleData'));
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
        $findData = Language::find($id);
        $findData->language_name = $request->input('language_name');

        if ($findData->save()) {
            return response()->json(['status'=>'true', 'message' => 'Language updated successfully'], 200);
        }

        return response()->json(['status'=>'errorr', 'message' => 'error occured please try again'], 200);
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
        $deleteData = Language::find($id);
        if ($deleteData->delete()) {
            return response()->json(['status'=>'true', 'message' => 'Language deleted successfully'], 200);
        }

        return response()->json(['status'=>'error', 'message' => 'error occured please try again'], 200);
    }
}
