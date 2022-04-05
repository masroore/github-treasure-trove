<div class="content-table">
	<h3>{{ __('Monitoring of Login') }}</h3> 

	<div class="content-space "> 
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
					{{ Form::label('', __('Profiles Users'), ['class' => 'selec2label'])}}   
					{{ Form::select('user_id', $Users, null,  ['class' => 'form-select select2','placeholder' => __('All Users'), 'id'=> 'user_id'])}}
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
				<th scope='col'>{{__('Start Date')}}</th>
				<th scope='col'>{{__('Date End')}}</th>
				<th scope='col'>{{__('IP')}}</th>
				<th scope='col'>{{__('Actions')}}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($History as $key => $value)
			<tr>
				<td>{{$key+1}}</td>
				<td>{{$value['full_name']}}</td>
				<td>{{show_full_date($value['date_in'])}}</td>
				<td>{{show_full_date($value['date_out'])}}</td>
				<td>{{$value['ip']}}</td>
				<td> 
                    {{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-moderation', 'id'=>'history_', 'data-bs-toggle'=>'modal', 'data-bs-target'=>'#detail_history','onClick'=>"get_detail_history('".$value['h_id']."')"]) }}
            </td> 
			</tr>
			@endforeach
		</tbody>
	</table>
	@include('users.access_history_detail')
</div>
<script type="text/javascript">
 $(document).ready(function() {
	  $('#date_range').on('change', function() {
	  		var date_range = $('#date_range').val();
	  		$('#date_in').val(date_range.substr(0,3)+date_range.substr(3,3)+date_range.substr(6,4));
	  		$('#date_out').val(date_range.substr(13,3)+date_range.substr(16,3)+date_range.substr(19,5));
	  });
 });
 function get_detail_history(id){
    $.get("{{url('U0005.search_history_detail')}}/"+id,function(response){
    		$('#user').text('');
     		$('#in').text('');
     		$('#out').text('');
     		$('#histories').dataTable().fnClearTable();
     		

     	$('#user').text(response.data.name_user);
     	$('#in').text(response.data.date_in);
     	$('#out').text(response.data.date_out);
     	for(i in response.data.history){
     		params= JSON.parse(response.data.history[i].processed_data);
     		text='';
     		for(j in params){
     			text+=j+'='+params[j]+'<br/>';
     		}
     		row_table = [    
                 response.data.history[i].data_formate,
                 response.data.history[i].name_process,
                 text,
             ];
          $('#histories').dataTable().fnAddData(row_table); 
     	}
     },'json');
 }
</script>