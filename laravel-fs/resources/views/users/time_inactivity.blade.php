<div class="content-table"> 

	<h3>{{ __('Time Inactivity') }}</h3> 

	<div class="content-space">
		{{ Form::open(['route'=>'users.time_inactivity','id' => 'formTimer', 'class' => 'validate notClean' , 'autocomplete' => 'Off']) }}
		<div class="row ">
			<div class="col-xs-11 col-sm-11 col-md-3 mb-3">
				<div class="form-group floating-label">
					{{	Form::text('inactivity_time',$timer->timer, ['id'=>'inactivity_time','class'=>'form-control number required', 'placeholder'=>__('Time Inactivity'), 'required' => 'required','minlength'=>'3','maxlength'=>'10']) }}
					{{	Form::label('', __('Time Inactivity'), ['class' => 'title'])}}  
				</div>
			</div>
			<div class="col-xs-1 col-sm-1 col-md-1">
				{{ Form::button('<i class="fa fa-save"></i>', ['class' => 'btn btn-primary', 'id' => 'saveFormTimer', 'type' => 'submit']) }}
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="note-footer"><i class="fa fa-exclamation"></i>
			   		{{__('The field is in seconds. The minimum is 180 seconds which is equivalent to 3 minutes.')}}
			 	</div>
			</div>
		</div>
		{{ Form::close() }}
	</div>	
</div>
