<?php

namespace App\Http\Controllers;

use App\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['permission:site-settings.footer-customize']);
    }

    public function index()
    {
        $row = Footer::first();

        return view('admin.footer.edit', compact('row'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $footer = Footer::first();
        $input = $request->all();
        if (empty($footer)) {
            $data = Footer::create($input);
            $data->save();

            return back()
                ->with('added', __('Footer has been created !'));
        }

        $footer->update($input);

        return back()->with('updated', __('Footer has been updated !'));
    }
}
