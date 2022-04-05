@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.secured.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.secureds.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.secured.fields.id') }}
                        </th>
                        <td>
                            {{ $secured->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.secured.fields.kecamatan') }}
                        </th>
                        <td>
                            {{ $secured->kecamatan->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.secured.fields.access') }}
                        </th>
                        <td>
                            {{ $secured->access->secure ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.secured.fields.communal') }}
                        </th>
                        <td>
                            {{ $secured->communal }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.secured.fields.individual') }}
                        </th>
                        <td>
                            {{ $secured->individual }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.secured.fields.mck_user') }}
                        </th>
                        <td>
                            {{ $secured->mck_user }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.secured.fields.qty_sr_pdpal') }}
                        </th>
                        <td>
                            {{ $secured->qty_sr_pdpal }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.secured.fields.year') }}
                        </th>
                        <td>
                            {{ App\Models\Secured::YEAR_SELECT[$secured->year] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.secureds.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
