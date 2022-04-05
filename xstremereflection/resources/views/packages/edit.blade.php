@extends('layouts.dashboard')

@section('page-title', __('Edit Package'))
@section('page-heading', __('Edit Package'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('New Package')
    </li>
@stop

@section('content')
    @include('partials.messages')

    <div class="row">
        <div class="col-lg-10">
            <form action="/package/store/{{$package->id}}" id="addPackageForm" method="post">
                @csrf
                @method('put')
                <fieldset>
                    <div class="form-group">
                        <label for="description">Package Name (required, at least 2 characters)</label>
                        <input id="description" class="form-control" name="description" minlength="2" type="text" value="{{$package->description}}" required>
                    </div>
                    <div class="form-group">
                        <label for="cost">Package Cost</label>
                        <input id="cost" class="form-control" type="number" name="cost" value="{{$package->cost}}" required>
                    </div>
                    <div class="form-group">
                        <label for="most_purchased"><input id="most_purchased" class="form-check-input" type="checkbox" value="1" name="most_purchased" @if($package->most_purchased) checked @endif> Mark item as most purchased (optional)</label>

                    </div>

                    <div class="form-group">
                        <label>Select services which are included in this package.</label>
                        <select class="js-example-basic-multiple" name="package_items[]" multiple="multiple" style="width:100%">
                            @foreach($services as $service)
                                <option value="{{$service->id}}" >{{$service->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Submit">
                </fieldset>


            </form>
        </div>
    </div>


@stop

@section('scripts')




@stop
