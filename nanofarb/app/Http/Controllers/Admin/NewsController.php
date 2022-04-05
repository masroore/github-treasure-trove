<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('news.read');

        $nodes = News::orderBy('id', 'desc')->byLocales()->paginate();

        return view('admin.news.index', compact('nodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('news.create');

        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        $this->authorize('news.create');

        $node = News::create($request->only('name', 'body', 'teaser', 'publish', 'locale'));

        $destination = $request->get('destination', route('admin.news.edit', $node));

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
        $this->authorize('news.update');

        $node = News::findOrFail($id);

        return view('admin.news.edit', compact('node'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, $id)
    {
        $this->authorize('news.update');

        $node = News::findOrFail($id);
        $node->update($request->only('name', 'body', 'teaser', 'publish'));

        $destination = $request->get('destination', route('admin.news.edit', $node));

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
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
        $this->authorize('news.delete');

        $node = News::findOrFail($id);
        $node->delete();

        $destination = $request->session()->pull('destination', route('admin.news.index'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function seo($id)
    {
        $this->authorize('news.update');

        $node = News::findOrFail($id);
        $tab = 'seo';

        return view('admin.news.edit', compact('node', 'tab'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function seoSave(Request $request, $id)
    {
        $this->authorize('news.update');

        $node = News::findOrFail($id);

        $node->metaTag()->updateOrCreate([], $request->get('meta_tag'));

        $destination = $request->session()->pull('destination', route('admin.news.edit', $node));

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }
}
