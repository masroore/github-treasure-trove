<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPropertyTagRequest;
use App\Http\Requests\StorePropertyTagRequest;
use App\Http\Requests\UpdatePropertyTagRequest;
use App\Models\PropertyTag;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class PropertyTagsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('property_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $propertyTags = PropertyTag::all();

        return view('admin.propertyTags.index', compact('propertyTags'));
    }

    public function create()
    {
        abort_if(Gate::denies('property_tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.propertyTags.create');
    }

    public function store(StorePropertyTagRequest $request)
    {
        $propertyTag = PropertyTag::create($request->all());

        return redirect()->route('admin.property-tags.index');
    }

    public function edit(PropertyTag $propertyTag)
    {
        abort_if(Gate::denies('property_tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.propertyTags.edit', compact('propertyTag'));
    }

    public function update(UpdatePropertyTagRequest $request, PropertyTag $propertyTag)
    {
        $propertyTag->update($request->all());

        return redirect()->route('admin.property-tags.index');
    }

    public function show(PropertyTag $propertyTag)
    {
        abort_if(Gate::denies('property_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.propertyTags.show', compact('propertyTag'));
    }

    public function destroy(PropertyTag $propertyTag)
    {
        abort_if(Gate::denies('property_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $propertyTag->delete();

        return back();
    }

    public function massDestroy(MassDestroyPropertyTagRequest $request)
    {
        PropertyTag::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
