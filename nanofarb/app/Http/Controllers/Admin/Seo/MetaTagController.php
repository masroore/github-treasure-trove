<?php

namespace App\Http\Controllers\Admin\Seo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Seo\MetaTagRequest;
use Fomvasss\LaravelMetaTags\Models\MetaTag;
use Illuminate\Http\Request;

class MetaTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metaTags = MetaTag::whereNotNull('path')->paginate();

        return view('admin.seo.meta-tags.index', compact('metaTags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.seo.meta-tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(MetaTagRequest $request)
    {
        $metaTag = MetaTag::create($request->validated());

        $destination = $request->get('destination', route('admin.meta-tags.edit', $metaTag));

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
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
        $metaTag = MetaTag::findOrFail($id);

        return view('admin.seo.meta-tags.edit', compact('metaTag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(MetaTagRequest $request, $id)
    {
        $metaTag = MetaTag::findOrFail($id);

        $metaTag->update($request->validated());

        $destination = $request->get('destination', route('admin.meta-tags.edit', $metaTag));

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
        $metaTag = MetaTag::findOrFail($id);
        $metaTag->delete();

        if (file_exists(public_path($metaTag->og_image))) {
            unlink(public_path($metaTag->og_image));
        }

        $destination = $request->session()->pull('destination', route('admin.meta-tags.index'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }
}
