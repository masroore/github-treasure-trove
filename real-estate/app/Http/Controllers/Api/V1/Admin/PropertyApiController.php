<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\Admin\PropertyResource;
use App\Models\Property;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class PropertyApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('property_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PropertyResource(Property::with(['type', 'tags', 'amenities', 'created_by'])->get());
    }

    public function store(StorePropertyRequest $request)
    {
        $property = Property::create($request->all());
        $property->tags()->sync($request->input('tags', []));
        $property->amenities()->sync($request->input('amenities', []));
        if ($request->input('property_main_photo', false)) {
            $property->addMedia(storage_path('tmp/uploads/' . basename($request->input('property_main_photo'))))->toMediaCollection('property_main_photo');
        }

        if ($request->input('property_photos', false)) {
            $property->addMedia(storage_path('tmp/uploads/' . basename($request->input('property_photos'))))->toMediaCollection('property_photos');
        }

        if ($request->input('floor_plans', false)) {
            $property->addMedia(storage_path('tmp/uploads/' . basename($request->input('floor_plans'))))->toMediaCollection('floor_plans');
        }

        return (new PropertyResource($property))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Property $property)
    {
        abort_if(Gate::denies('property_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PropertyResource($property->load(['type', 'tags', 'amenities', 'created_by']));
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

        if ($request->input('property_photos', false)) {
            if (!$property->property_photos || $request->input('property_photos') !== $property->property_photos->file_name) {
                if ($property->property_photos) {
                    $property->property_photos->delete();
                }
                $property->addMedia(storage_path('tmp/uploads/' . basename($request->input('property_photos'))))->toMediaCollection('property_photos');
            }
        } elseif ($property->property_photos) {
            $property->property_photos->delete();
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

        return (new PropertyResource($property))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Property $property)
    {
        abort_if(Gate::denies('property_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $property->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
