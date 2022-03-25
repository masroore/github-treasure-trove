{{ Form::model($expense, array('route' => array('expenses.update', $expense->id), 'method' => 'PUT','enctype' => "multipart/form-data")) }}
<div class="row">
    <div class="form-group  col-md-6">
        {{ Form::label('category_id', __('Category')) }}
        {{ Form::select('category_id', $category,null, array('class' => 'form-control select2','required'=>'required')) }}
        @error('category_id')
        <span class="invalid-category_id" role="alert">
            <strong class="text-danger">{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group  col-md-6">
        {{ Form::label('amount', __('Amount')) }}
        {{ Form::number('amount', null, array('class' => 'form-control','required'=>'required')) }}
        @error('amount')
        <span class="invalid-amount" role="alert">
        <strong class="text-danger">{{ $message }}</strong>
    </span>
        @enderror
    </div>
    <div class="form-group  col-md-6">
        {{ Form::label('date', __('Date')) }}
        {{ Form::text('date', null, array('class' => 'form-control datepicker','required'=>'required')) }}
        @error('date')
        <span class="invalid-date" role="alert">
        <strong class="text-danger">{{ $message }}</strong>
    </span>
        @enderror
    </div>
    <div class="form-group  col-md-6">
        {{ Form::label('project_id', __('Project')) }}
        {{ Form::select('project_id', $projects,null, array('class' => 'form-control select2','required'=>'required')) }}
        @error('project_id')
        <span class="invalid-project_id" role="alert">
            <strong class="text-danger">{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group  col-md-6">
        {{ Form::label('user_id', __('User')) }}
        {{ Form::select('user_id', $users,null, array('class' => 'form-control select2','required'=>'required')) }}
        @error('user_id')
        <span class="invalid-user_id" role="alert">
            <strong class="text-danger">{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group  col-md-6">
        {{ Form::label('attachment', __('Attachment')) }}
        {{ Form::file('attachment', array('class' => 'form-control','accept'=>'.jpeg,.jpg,.png,.doc,.pdf')) }}
        @error('attachment')
        <span class="invalid-attachment" role="alert">
        <strong class="text-danger">{{ $message }}</strong>
    </span>
        @enderror
    </div>
    <div class="form-group  col-md-12">
        {{ Form::label('description', __('Description')) }}
        {!! Form::textarea('description', null, ['class'=>'form-control font-style','rows'=>'2']) !!}
        @error('terms')
        <span class="invalid-terms" role="alert">
        <strong class="text-danger">{{ $message }}</strong>
    </span>
        @enderror
    </div>
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
        {{Form::submit(__('Update'),array('class'=>'btn btn-primary'))}}
    </div>
</div>

{{ Form::close() }}


