<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyInfographicRequest;
use App\Http\Requests\StoreInfographicRequest;
use App\Http\Requests\UpdateInfographicRequest;
use App\Models\Infographic;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class InfographicController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('infographic_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $infographics = Infographic::all();

        return view('admin.infographics.index', compact('infographics'));
    }

    public function create()
    {
        abort_if(Gate::denies('infographic_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.infographics.create');
    }

    public function store(StoreInfographicRequest $request)
    {
        $infographic = Infographic::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $infographic->id]);
        }

        return redirect()->route('admin.infographics.index');
    }

    public function edit(Infographic $infographic)
    {
        abort_if(Gate::denies('infographic_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.infographics.edit', compact('infographic'));
    }

    public function update(UpdateInfographicRequest $request, Infographic $infographic)
    {
        $infographic->update($request->all());

        return redirect()->route('admin.infographics.index');
    }

    public function show(Infographic $infographic)
    {
        abort_if(Gate::denies('infographic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.infographics.show', compact('infographic'));
    }

    public function destroy(Infographic $infographic)
    {
        abort_if(Gate::denies('infographic_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $infographic->delete();

        return back();
    }

    public function massDestroy(MassDestroyInfographicRequest $request)
    {
        Infographic::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('infographic_create') && Gate::denies('infographic_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Infographic();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
