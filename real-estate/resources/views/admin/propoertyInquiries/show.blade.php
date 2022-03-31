@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.propoertyInquiry.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.propoerty-inquiries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.propoertyInquiry.fields.id') }}
                        </th>
                        <td>
                            {{ $propoertyInquiry->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.propoertyInquiry.fields.property') }}
                        </th>
                        <td>
                            {{ $propoertyInquiry->property->property_title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.propoertyInquiry.fields.full_name') }}
                        </th>
                        <td>
                            {{ $propoertyInquiry->full_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.propoertyInquiry.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $propoertyInquiry->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.propoertyInquiry.fields.email_address') }}
                        </th>
                        <td>
                            {{ $propoertyInquiry->email_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.propoertyInquiry.fields.message') }}
                        </th>
                        <td>
                            {{ $propoertyInquiry->message }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.propoerty-inquiries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection