<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePropertyReviewRequest;
use App\Http\Requests\UpdatePropertyReviewRequest;
use App\Http\Resources\Admin\PropertyReviewResource;
use App\Models\PropertyReview;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class PropertyReviewsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('property_review_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PropertyReviewResource(PropertyReview::with(['property', 'created_by'])->get());
    }

    public function store(StorePropertyReviewRequest $request)
    {
        $propertyReview = PropertyReview::create($request->all());

        if ($request->input('photos', false)) {
            $propertyReview->addMedia(storage_path('tmp/uploads/' . basename($request->input('photos'))))->toMediaCollection('photos');
        }

        return (new PropertyReviewResource($propertyReview))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PropertyReview $propertyReview)
    {
        abort_if(Gate::denies('property_review_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PropertyReviewResource($propertyReview->load(['property', 'created_by']));
    }

    public function update(UpdatePropertyReviewRequest $request, PropertyReview $propertyReview)
    {
        $propertyReview->update($request->all());

        if ($request->input('photos', false)) {
            if (!$propertyReview->photos || $request->input('photos') !== $propertyReview->photos->file_name) {
                if ($propertyReview->photos) {
                    $propertyReview->photos->delete();
                }
                $propertyReview->addMedia(storage_path('tmp/uploads/' . basename($request->input('photos'))))->toMediaCollection('photos');
            }
        } elseif ($propertyReview->photos) {
            $propertyReview->photos->delete();
        }

        return (new PropertyReviewResource($propertyReview))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PropertyReview $propertyReview)
    {
        abort_if(Gate::denies('property_review_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $propertyReview->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
