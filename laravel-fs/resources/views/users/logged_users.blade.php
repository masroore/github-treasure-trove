<div class="content-table">
    <h3>{{ __('Sessions Actives') }}</h3> 
	<table class="dataTable table" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th scope='col'>N&deg;</th>
				<th scope='col'>{{__('User')}}</th>
				<th scope='col'>{{__('Start Login')}}</th>
				<th scope='col'>{{__('IP')}}</th>
				<th scope='col'>{{__('Actions')}}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($logged as $key => $value)
			<tr>
				<td>{{$key+1}}</td>
				<td>{{textUpper($value['full_name'])}}</td>
				<td>{{show_full_date($value['date_in'])}}</td>
				<td>{{$value['ip']}}</td>
				<td>				
					<a class="btn btn-moderation delete link_ajax" data-dataType="json" href="{{route('users.delete_logged',$value['crypt_id'])}}"><i class="fa fa-times"></i> {{ __('Kill') }}</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
