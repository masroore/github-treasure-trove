<?php

namespace App\Http\Controllers;

use App\Http\Requests\StyleStoreRequest;
use App\Http\Requests\StyleUpdateRequest;
use App\Models\Style;
use Illuminate\Http\Request;

class StyleController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $styles = Style::all();

        return view('style.index', compact('styles'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('style.create');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(StyleStoreRequest $request)
    {
        $style = Style::create($request->validated());

        $request->session()->flash('style.id', $style->id);

        return redirect()->route('style.index');
    }

    /**
     * @param \App\Style $style
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Style $style)
    {
        return view('style.show', compact('style'));
    }

    /**
     * @param \App\Style $style
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Style $style)
    {
        return view('style.edit', compact('style'));
    }

    /**
     * @param \App\Style $style
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StyleUpdateRequest $request, Style $style)
    {
        $style->update($request->validated());

        $request->session()->flash('style.id', $style->id);

        return redirect()->route('style.index');
    }

    /**
     * @param \App\Style $style
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Style $style)
    {
        $style->delete();

        return redirect()->route('style.index');
    }
}
