<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBuildGalleryRequest;
use App\Http\Requests\StoreBuildGalleryRequest;
use App\Http\Requests\UpdateBuildGalleryRequest;
use App\Models\Build;
use App\Models\BuildGallery;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BuildGalleryController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('build_gallery_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BuildGallery::with(['build'])->select(sprintf('%s.*', (new BuildGallery())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'build_gallery_show';
                $editGate = 'build_gallery_edit';
                $deleteGate = 'build_gallery_delete';
                $crudRoutePart = 'build-galleries';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('build_address', function ($row) {
                return $row->build ? $row->build->address : '';
            });

            $table->editColumn('photo', function ($row) {
                if ($photo = $row->photo) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });

            $table->rawColumns(['actions', 'placeholder', 'build', 'photo']);

            return $table->make(true);
        }

        return view('admin.buildGalleries.index');
    }

    public function create()
    {
        abort_if(Gate::denies('build_gallery_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $builds = Build::pluck('address', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.buildGalleries.create', compact('builds'));
    }

    public function store(StoreBuildGalleryRequest $request)
    {
        $buildGallery = BuildGallery::create($request->all());

        if ($request->input('photo', false)) {
            $buildGallery->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $buildGallery->id]);
        }

        return redirect()->route('admin.build-galleries.index');
    }

    public function edit(BuildGallery $buildGallery)
    {
        abort_if(Gate::denies('build_gallery_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $builds = Build::pluck('address', 'id')->prepend(trans('global.pleaseSelect'), '');

        $buildGallery->load('build');

        return view('admin.buildGalleries.edit', compact('builds', 'buildGallery'));
    }

    public function update(UpdateBuildGalleryRequest $request, BuildGallery $buildGallery)
    {
        $buildGallery->update($request->all());

        if ($request->input('photo', false)) {
            if (!$buildGallery->photo || $request->input('photo') !== $buildGallery->photo->file_name) {
                if ($buildGallery->photo) {
                    $buildGallery->photo->delete();
                }
                $buildGallery->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($buildGallery->photo) {
            $buildGallery->photo->delete();
        }

        return redirect()->route('admin.build-galleries.index');
    }

    public function show(BuildGallery $buildGallery)
    {
        abort_if(Gate::denies('build_gallery_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildGallery->load('build');

        return view('admin.buildGalleries.show', compact('buildGallery'));
    }

    public function destroy(BuildGallery $buildGallery)
    {
        abort_if(Gate::denies('build_gallery_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildGallery->delete();

        return back();
    }

    public function massDestroy(MassDestroyBuildGalleryRequest $request)
    {
        BuildGallery::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('build_gallery_create') && Gate::denies('build_gallery_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new BuildGallery();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
