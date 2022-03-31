<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPropertyReviewRequest;
use App\Http\Requests\StorePropertyReviewRequest;
use App\Http\Requests\UpdatePropertyReviewRequest;
use App\Models\Property;
use App\Models\PropertyReview;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class PropertyReviewsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('property_review_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $propertyReviews = PropertyReview::with(['property', 'created_by', 'media'])->get();

        return view('admin.propertyReviews.index', compact('propertyReviews'));
    }

    public function create()
    {
        abort_if(Gate::denies('property_review_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $properties = Property::pluck('property_title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.propertyReviews.create', compact('properties'));
    }

    public function store(StorePropertyReviewRequest $request)
    {
        $propertyReview = PropertyReview::create($request->all());

        foreach ($request->input('photos', []) as $file) {
            $propertyReview->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $propertyReview->id]);
        }

        return redirect()->route('admin.property-reviews.index');
    }

    public function edit(PropertyReview $propertyReview)
    {
        abort_if(Gate::denies('property_review_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $properties = Property::pluck('property_title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $propertyReview->load('property', 'created_by');

        return view('admin.propertyReviews.edit', compact('properties', 'propertyReview'));
    }

    public function update(UpdatePropertyReviewRequest $request, PropertyReview $propertyReview)
    {
        $propertyReview->update($request->all());

        if (\count($propertyReview->photos) > 0) {
            foreach ($propertyReview->photos as $media) {
                if (!\in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $propertyReview->photos->pluck('file_name')->toArray();
        foreach ($request->input('photos', []) as $file) {
            if (0 === \count($media) || !\in_array($file, $media)) {
                $propertyReview->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
            }
        }

        return redirect()->route('admin.property-reviews.index');
    }

    public function show(PropertyReview $propertyReview)
    {
        abort_if(Gate::denies('property_review_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $propertyReview->load('property', 'created_by');

        return view('admin.propertyReviews.show', compact('propertyReview'));
    }

    public function destroy(PropertyReview $propertyReview)
    {
        abort_if(Gate::denies('property_review_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $propertyReview->delete();

        return back();
    }

    public function massDestroy(MassDestroyPropertyReviewRequest $request)
    {
        PropertyReview::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('property_review_create') && Gate::denies('property_review_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new PropertyReview();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
