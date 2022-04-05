@extends('layouts.admin')

@section('title', 'Show Role')
@section('content')
    <div class="header ">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-dark d-inline-block mb-0">{{ __('app.role') }}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('roles.index') }}">{{ __('app.role') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('app.show') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <form class="form-horizontal" method="POST" action="{{ route('roles_permit', $role->id) }}">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12 order-xl-1">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="heading-small text-muted mb-4">{{ __('app.all_permissions') }}</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            @foreach ($allmodules as $module)
                                                <label for="name">{{ ucfirst(__($module)) }}</label>
                                                <div class="col-lg-12 p-3">
                                                    @if (in_array('manage-' . $module, (array) $allpermissions))
                                                        @if ($key = array_search('manage-' . $module, $allpermissions))
                                                            @if (in_array('manage-' . $module, (array) $permissions))
                                                                @php $ch = 'checked' @endphp
                                                            @else
                                                                @php $ch = '' @endphp
                                                            @endif
                                                            <div
                                                                class="custom-control custom-checkbox custom-control-inline">
                                                                <input type="checkbox" {{ $ch }}
                                                                    name="permissions[]" class="custom-control-input"
                                                                    id="role{{ $key }}"
                                                                    value="manage-{{ $module }}">
                                                                <label class="custom-control-label"
                                                                    for="role{{ $key }}">
                                                                    manage-{{ $module }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @if (in_array('create-' . $module, (array) $allpermissions))
                                                        @if ($key = array_search('create-' . $module, $allpermissions))
                                                            @if (in_array('create-' . $module, (array) $permissions))
                                                                @php $ch = 'checked' @endphp
                                                            @else
                                                                @php $ch = '' @endphp
                                                            @endif
                                                            <div
                                                                class="custom-control custom-checkbox custom-control-inline">
                                                                <input type="checkbox" {{ $ch }}
                                                                    name="permissions[]" class="custom-control-input"
                                                                    id="role{{ $key }}"
                                                                    value="create-{{ $module }}">
                                                                <label class="custom-control-label"
                                                                    for="role{{ $key }}">
                                                                    create-{{ $module }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @if (in_array('edit-' . $module, (array) $allpermissions))
                                                        @if ($key = array_search('edit-' . $module, $allpermissions))
                                                            @if (in_array('edit-' . $module, (array) $permissions))
                                                                @php $ch = 'checked' @endphp
                                                            @else
                                                                @php $ch = '' @endphp
                                                            @endif
                                                            <div
                                                                class="custom-control custom-checkbox custom-control-inline">
                                                                <input type="checkbox" {{ $ch }}
                                                                    name="permissions[]" class="custom-control-input"
                                                                    id="role{{ $key }}"
                                                                    value="edit-{{ $module }}">
                                                                <label class="custom-control-label"
                                                                    for="role{{ $key }}">
                                                                    edit-{{ $module }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @if (in_array('delete-' . $module, (array) $allpermissions))
                                                        @if ($key = array_search('delete-' . $module, $allpermissions))
                                                            @if (in_array('delete-' . $module, (array) $permissions))
                                                                @php $ch = 'checked' @endphp
                                                            @else
                                                                @php $ch = '' @endphp
                                                            @endif
                                                            <div
                                                                class="custom-control custom-checkbox custom-control-inline">
                                                                <input type="checkbox" {{ $ch }}
                                                                    name="permissions[]" class="custom-control-input"
                                                                    id="role{{ $key }}"
                                                                    value="delete-{{ $module }}">
                                                                <label class="custom-control-label"
                                                                    for="role{{ $key }}">
                                                                    delete-{{ $module }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @if (in_array('show-' . $module, (array) $allpermissions))
                                                        @if ($key = array_search('show-' . $module, $allpermissions))
                                                            @if (in_array('show-' . $module, (array) $permissions))
                                                                @php $ch = 'checked' @endphp
                                                            @else
                                                                @php $ch = '' @endphp
                                                            @endif
                                                            <div
                                                                class="custom-control custom-checkbox custom-control-inline">
                                                                <input type="checkbox" {{ $ch }}
                                                                    name="permissions[]" class="custom-control-input"
                                                                    id="role{{ $key }}"
                                                                    value="show-{{ $module }}">
                                                                <label class="custom-control-label"
                                                                    for="role{{ $key }}">
                                                                    show-{{ $module }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class=" mt-4 ">
                                        <button type="submit"
                                            class="btn btn-primary col-md-2 float-right ">{{ __('app.update_permission') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
