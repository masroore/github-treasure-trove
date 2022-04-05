<div class="content-table"> 
	<h3>{{ __('Monitoring Attempts of Login') }}</h3> 
    <div class="content-space">
		{{ Form::open(['id' => 'formlogin', 'class' => 'validate' , 'autocomplete' => 'Off','data-dataType'=>'html']) }}
		    <div class="row ">
	           <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
	            	<div class="form-group floating-label">
						{{	Form::text('date_range', null, ['id'=>'date_range','class'=>'form-control date_range', 'placeholder'=>__('Date Start'), 'required' => 'required' ]) }}
						{{	Form::label('', __('Date Start'), ['class' => 'title'])}}    

						{{ Form::hidden('date_in', date('d/m/Y'), ['id'=> 'date_in'])}}
						{{ Form::hidden('date_out', date('d/m/Y'), ['id'=> 'date_out'])}}
			        </div>
	            </div>
	            <div class="col-xs-11 col-sm-11 col-md-5 te-1 mb-3">
	            	<div class="form-group floating-label">
	              		{{ Form::select('user_id', $Users, null,  ['class' => 'form-select ','placeholder' => __('All Users'), 'id'=> 'user_id'])}}
	              		{{ Form::label('', __('Profiles Users'), ['class' => 'title'])}} 
	              	</div>
	            </div>

		     	<div class="col-xs-1 col-sm-1 col-md-1">
		        	{{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary link_ajax', 'id' => 'submit', 'type' => 'submit']) }}
		    	</div>
		    </div>
	    {{ Form::close() }}  
     </div>
	<table class="dataTable table" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th scope='col'>N&deg;</th>
				<th scope='col'>{{__('User')}}</th>
				<th scope='col'>{{__('Date')}}</th>				
				<th scope='col'>{{__('IP')}}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($History as $key => $value)
			<tr>
				<td>{{$key+1}}</td>
				<td>{{$value['full_name']}}</td>
				<td>{{show_full_date($value['date_in'])}}</td>				
				<td>{{$value['ip']}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<script type="text/javascript">
 $(document).ready(function() {
	  $('#date_range').on('change', function() {
	  		var date_range = $('#date_range').val();
	  		$('#date_in').val(date_range.substr(0,3)+date_range.substr(3,3)+date_range.substr(6,4));
	  		$('#date_out').val(date_range.substr(13,3)+date_range.substr(16,3)+date_range.substr(19,5));
	  });
 });
</script>