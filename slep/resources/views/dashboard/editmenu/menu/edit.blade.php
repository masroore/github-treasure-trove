@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>{{ __('coreuiforms.edit') }}: {{ $menulist->name }}</h4></div>
            <div class="card-body">
                @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                @endif
                <form action="{{ route('menu.menu.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $menulist->id }}" id="menuElementId"/>
                    <table class="table table-striped table-bordered datatable">
                        <tbody>
                            <tr>
                                <th>
                                    {{ __('coreuiforms.menu.name') }}
                                </th>
                                <td>
                                    <input type="text" name="name" class="form-control" value="{{ $menulist->name }}"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-primary" type="submit">{{ __('coreuiforms.save') }}</button>
                    <a class="btn btn-primary" href="{{ route('menu.menu.index') }}">{{ __('coreuiforms.return') }}</a>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')

@endsection