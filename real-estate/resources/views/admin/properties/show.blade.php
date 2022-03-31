@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.property.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.properties.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.id') }}
                        </th>
                        <td>
                            {{ $property->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.property_title') }}
                        </th>
                        <td>
                            {{ $property->property_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.property_main_photo') }}
                        </th>
                        <td>
                            @if($property->property_main_photo)
                                <a href="{{ $property->property_main_photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $property->property_main_photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.property_description') }}
                        </th>
                        <td>
                            {!! $property->property_description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.type') }}
                        </th>
                        <td>
                            {{ $property->type->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.rooms') }}
                        </th>
                        <td>
                            {{ $property->rooms }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.property_price') }}
                        </th>
                        <td>
                            {{ $property->property_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.per') }}
                        </th>
                        <td>
                            {{ App\Models\Property::PER_SELECT[$property->per] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.google_map_location') }}
                        </th>
                        <td>
                            {{ $property->google_map_location }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.year_built') }}
                        </th>
                        <td>
                            {{ $property->year_built }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.area') }}
                        </th>
                        <td>
                            {{ $property->area }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.property_photos') }}
                        </th>
                        <td>
                            @foreach($property->property_photos as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.property_video') }}
                        </th>
                        <td>
                            {{ $property->property_video }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.floor_plans') }}
                        </th>
                        <td>
                            @if($property->floor_plans)
                                <a href="{{ $property->floor_plans->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $property->floor_plans->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.tags') }}
                        </th>
                        <td>
                            @foreach($property->tags as $key => $tags)
                                <span class="label label-info">{{ $tags->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Property::STATUS_SELECT[$property->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.available') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $property->available ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.feature_property') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $property->feature_property ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.location') }}
                        </th>
                        <td>
                            {{ $property->location }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.property.fields.amenities') }}
                        </th>
                        <td>
                            @foreach($property->amenities as $key => $amenities)
                                <span class="label label-info">{{ $amenities->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.properties.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection