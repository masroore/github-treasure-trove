@extends('layouts.admin')
@section('page-title')
    {{__('Expense')}}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Expense')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Expense')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>{{__('Manage Expense')}}</h4>
                                @can('create invoice')
                                    <div class="col-auto">
                                        <a href="#" data-url="{{ route('expenses.create') }}" data-ajax-popup="true" data-title="{{__('Create New Expense')}}" class="btn btn-xs btn-warning">
                                            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                                            <span class="btn-inner--text"> {{__('Create')}}</span>
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body p-0">
                                <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                    <div class="table-responsive">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-flush" id="dataTable">
                                                    <thead>
                                                    <tr>

                                                        <th> {{__('Category')}}</th>
                                                        <th width="40%"> {{__('Description')}}</th>
                                                        <th> {{__('Amount')}}</th>
                                                        <th> {{__('Date')}}</th>
                                                        <th> {{__('Project')}}</th>
                                                        <th> {{__('User')}}</th>
                                                        <th> {{__('Attachment')}}</th>
                                                        @if(Gate::check('edit expense') || Gate::check('delete expense'))
                                                            <th class="text-right"> {{__('Action')}}</th>
                                                        @endif
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @foreach ($expenses as $expense)
                                                        <tr>
                                                            <td>{{  (!empty($expense->category)?$expense->category->name:'')}}</td>
                                                            <td>{{ $expense->description }}</td>
                                                            <td>{{ Auth::user()->priceFormat($expense->amount) }} </td>
                                                            <td>{{ Auth::user()->dateFormat($expense->date) }}</td>
                                                            <td>{{ $expense->projects->name }}</td>
                                                            <td>{{ (!empty($expense->user)?$expense->user->name:'') }}</td>
                                                            <td class="text-center">

                                                                @if($expense->attachment)
                                                                    <a href="{{asset(Storage::url('uploads/attachment/'. $expense->attachment))}}" download="" class="table-action" data-toggle="tooltip" data-original-title="{{__('Download')}}">
                                                                        <i class="fa fa-download"></i>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                            @if(Gate::check('edit expense') || Gate::check('delete expense'))
                                                                <td class="action text-right">
                                                                    @can('edit expense')
                                                                        <a href="#" class="table-action" data-url="{{ route('expenses.edit',$expense->id) }}" data-ajax-popup="true" data-title="{{__('Edit Expense')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                                            <i class="far fa-edit"></i>
                                                                        </a>
                                                                    @endcan
                                                                    @can('delete expense')
                                                                        <a href="#" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$expense->id}}').submit();">
                                                                            <i class="far fa-trash-alt"></i>
                                                                        </a>
                                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['expenses.destroy', $expense->id],'id'=>'delete-form-'.$expense->id]) !!}
                                                                        {!! Form::close() !!}
                                                                    @endcan
                                                                </td>

                                                            @endif
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
