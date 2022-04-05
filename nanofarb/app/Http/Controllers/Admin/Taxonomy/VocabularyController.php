<?php

namespace App\Http\Controllers\Admin\Taxonomy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VocabularyRequest;
use App\Models\Taxonomy\Vocabulary;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('term.read');

        $vocabularies = Vocabulary::withCount('terms')->paginate();

        return view('admin.taxonomy.vocabularies.index', compact('vocabularies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('term.create');

        return view('admin.taxonomy.vocabularies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(VocabularyRequest $request)
    {
        $this->authorize('term.create');

        $vocabulary = Vocabulary::create($request->validated());

        $destination = $request->session()->pull('destination', route('admin.vocabularies.edit', $vocabulary));

        return redirect()->to($destination)
            ->with('success', trans('notifications.store.success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vocabulary = Vocabulary::findOrFail($id);

        return view('admin.taxonomy.vocabularies.edit', compact('vocabulary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $vocabulary = Vocabulary::findOrFail($id);

        if ($vocabulary->terms->count()) {
            return redirect()->route('admin.vocabularies.index')
                ->with('error', trans('notifications.destroy.error_children'));
        }

        $vocabulary->delete();

        $destination = $request->session()->pull('destination', route('admin.vocabularies.index'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }
}
