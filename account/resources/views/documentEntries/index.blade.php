
@extends('layouts.admin')
@section('page-title')
    {{__('Documents')}}
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        @can('create assets')
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" data-url="{{ route('document-entry.create') }}" data-ajax-popup="true" data-title="{{__('Create New Documents')}}" class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fas fa-plus"></i> {{__('Create')}}
                </a>
            </div>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr>
                                <th>{{__('Image')}}</th>
                                <th>{{__('Payment Text')}}</th>
                                <th>{{__('File type')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($documents as $document)
                                <tr>
                                    <td class="font-style"><img src="/storage/uploads/documents/{{ $document->file_upload }}" style="width:80px;"></td>
                                    <td class="font-style">{{ $document->payment_text }}</td>
                                    <td class="font-style">{{ $document->file_type }}</td>
                                    <td class="Action">
                                        <span>
                                        @can('edit documents')
                                                <a href="#" class="edit-icon" data-url="{{ route('document-entry.edit',$document->id) }}" data-ajax-popup="true" data-title="{{__('Edit Documents')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            @endcan
                                            @can('delete documents')
                                                <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$document->id}}').submit();">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['document-entry.destroy', $document->id],'id'=>'delete-form-'.$document->id]) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
