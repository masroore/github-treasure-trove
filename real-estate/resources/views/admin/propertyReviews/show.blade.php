@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.propertyReview.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.property-reviews.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.propertyReview.fields.id') }}
                        </th>
                        <td>
                            {{ $propertyReview->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.propertyReview.fields.property') }}
                        </th>
                        <td>
                            {{ $propertyReview->property->property_title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.propertyReview.fields.full_name') }}
                        </th>
                        <td>
                            {{ $propertyReview->full_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.propertyReview.fields.ratings') }}
                        </th>
                        <td>
                            {{ $propertyReview->ratings }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.propertyReview.fields.email') }}
                        </th>
                        <td>
                            {{ $propertyReview->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.propertyReview.fields.review') }}
                        </th>
                        <td>
                            {{ $propertyReview->review }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.propertyReview.fields.photos') }}
                        </th>
                        <td>
                            @foreach($propertyReview->photos as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.property-reviews.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection