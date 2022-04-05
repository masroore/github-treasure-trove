<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyIpalRequest;
use App\Http\Requests\StoreIpalRequest;
use App\Http\Requests\UpdateIpalRequest;
use App\Models\Category;
use App\Models\Ipal;
use App\Models\Kelurahan;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class IpalController extends Controller
{
    use CsvImportTrait;
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('ipal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ipals = Ipal::with(['kelurahans', 'categories', 'services', 'media'])->get();

        return view('admin.ipals.index', compact('ipals'));
    }

    public function create()
    {
        abort_if(Gate::denies('ipal_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kelurahans = Kelurahan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = Category::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $services = Kelurahan::pluck('name', 'id');

        return view('admin.ipals.create', compact('kelurahans', 'categories', 'services'));
    }

    public function store(StoreIpalRequest $request)
    {
        $ipal = Ipal::create($request->all());
        $ipal->services()->sync($request->input('services', []));
        foreach ($request->input('photos', []) as $file) {
            $ipal->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $ipal->id]);
        }

        return redirect()->route('admin.ipals.index');
    }

    public function edit(Ipal $ipal)
    {
        abort_if(Gate::denies('ipal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kelurahans = Kelurahan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = Category::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $services = Kelurahan::pluck('name', 'id');

        $ipal->load('kelurahans', 'categories', 'services');

        return view('admin.ipals.edit', compact('kelurahans', 'categories', 'services', 'ipal'));
    }

    public function update(UpdateIpalRequest $request, Ipal $ipal)
    {
        $ipal->update($request->all());
        $ipal->services()->sync($request->input('services', []));
        if (count($ipal->photos) > 0) {
            foreach ($ipal->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $ipal->photos->pluck('file_name')->toArray();
        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $ipal->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
            }
        }

        return redirect()->route('admin.ipals.index');
    }

    public function show(Ipal $ipal)
    {
        abort_if(Gate::denies('ipal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ipal->load('kelurahans', 'categories', 'services');

        return view('admin.ipals.show', compact('ipal'));
    }

    public function destroy(Ipal $ipal)
    {
        abort_if(Gate::denies('ipal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ipal->delete();

        return back();
    }

    public function massDestroy(MassDestroyIpalRequest $request)
    {
        Ipal::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('ipal_create') && Gate::denies('ipal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Ipal();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
