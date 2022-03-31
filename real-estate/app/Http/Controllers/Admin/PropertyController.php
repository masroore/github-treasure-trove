<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPropertyRequest;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Amenity;
use App\Models\Category;
use App\Models\Property;
use App\Models\PropertyTag;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class PropertyController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('property_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $properties = Property::with(['type', 'tags', 'amenities', 'created_by', 'media'])->get();

        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        abort_if(Gate::denies('property_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = Category::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = PropertyTag::pluck('name', 'id');

        $amenities = Amenity::pluck('name', 'id');

        return view('admin.properties.create', compact('types', 'tags', 'amenities'));
    }

    public function store(StorePropertyRequest $request)
    {
        $property = Property::create($request->all());
        $property->tags()->sync($request->input('tags', []));
        $property->amenities()->sync($request->input('amenities', []));
        if ($request->input('property_main_photo', false)) {
            $property->addMedia(storage_path('tmp/uploads/' . basename($request->input('property_main_photo'))))->toMediaCollection('property_main_photo');
        }

        foreach ($request->input('property_photos', []) as $file) {
            $property->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('property_photos');
        }

        if ($request->input('floor_plans', false)) {
            $property->addMedia(storage_path('tmp/uploads/' . basename($request->input('floor_plans'))))->toMediaCollection('floor_plans');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $property->id]);
        }

        return redirect()->route('admin.properties.index');
    }

    public function edit(Property $property)
    {
        abort_if(Gate::denies('property_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = Category::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = PropertyTag::pluck('name', 'id');

        $amenities = Amenity::pluck('name', 'id');

        $property->load('type', 'tags', 'amenities', 'created_by');

        return view('admin.properties.edit', compact('types', 'tags', 'amenities', 'property'));
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $property->update($request->all());
        $property->tags()->sync($request->input('tags', []));
        $property->amenities()->sync($request->input('amenities', []));
        if ($request->input('property_main_photo', false)) {
            if (!$property->property_main_photo || $request->input('property_main_photo') !== $property->property_main_photo->file_name) {
                if ($property->property_main_photo) {
                    $property->property_main_photo->delete();
                }
                $property->addMedia(storage_path('tmp/uploads/' . basename($request->input('property_main_photo'))))->toMediaCollection('property_main_photo');
            }
        } elseif ($property->property_main_photo) {
            $property->property_main_photo->delete();
        }

        if (\count($property->property_photos) > 0) {
            foreach ($property->property_photos as $media) {
                if (!\in_array($media->file_name, $request->input('property_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $property->property_photos->pluck('file_name')->toArray();
        foreach ($request->input('property_photos', []) as $file) {
            if (0 === \count($media) || !\in_array($file, $media)) {
                $property->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('property_photos');
            }
        }

        if ($request->input('floor_plans', false)) {
            if (!$property->floor_plans || $request->input('floor_plans') !== $property->floor_plans->file_name) {
                if ($property->floor_plans) {
                    $property->floor_plans->delete();
                }
                $property->addMedia(storage_path('tmp/uploads/' . basename($request->input('floor_plans'))))->toMediaCollection('floor_plans');
            }
        } elseif ($property->floor_plans) {
            $property->floor_plans->delete();
        }

        return redirect()->route('admin.properties.index');
    }

    public function show(Property $property)
    {
        abort_if(Gate::denies('property_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $property->load('type', 'tags', 'amenities', 'created_by');

        return view('admin.properties.show', compact('property'));
    }

    public function destroy(Property $property)
    {
        abort_if(Gate::denies('property_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $property->delete();

        return back();
    }

    public function massDestroy(MassDestroyPropertyRequest $request)
    {
        Property::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('property_create') && Gate::denies('property_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Property();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    // message page
    public function sendMessage()
    {
        return view('admin.properties.send-message');
    }
}
