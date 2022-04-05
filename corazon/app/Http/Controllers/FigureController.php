<?php

namespace App\Http\Controllers;

use App\Http\Requests\FigureStoreRequest;
use App\Http\Requests\FigureUpdateRequest;
use App\Models\Figure;
use Illuminate\Http\Request;

class FigureController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $figures = Figure::all();

        return view('figure.index', compact('figures'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('figure.create');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(FigureStoreRequest $request)
    {
        $figure = Figure::create($request->validated());

        $request->session()->flash('figure.id', $figure->id);

        return redirect()->route('figure.index');
    }

    /**
     * @param \App\Figure $figure
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Figure $figure)
    {
        return view('figure.show', compact('figure'));
    }

    /**
     * @param \App\Figure $figure
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Figure $figure)
    {
        return view('figure.edit', compact('figure'));
    }

    /**
     * @param \App\Figure $figure
     *
     * @return \Illuminate\Http\Response
     */
    public function update(FigureUpdateRequest $request, Figure $figure)
    {
        $figure->update($request->validated());

        $request->session()->flash('figure.id', $figure->id);

        return redirect()->route('figure.index');
    }

    /**
     * @param \App\Figure $figure
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Figure $figure)
    {
        $figure->delete();

        return redirect()->route('figure.index');
    }
}
