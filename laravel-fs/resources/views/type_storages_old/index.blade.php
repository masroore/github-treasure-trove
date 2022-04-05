


@if(Session::has('mensaje'))
{{Session::get('mensaje')}}
@endif

<a href="{{route('typeStore.create')}}" class="btn btn-success link_ajax" >{{ __('Register Type Storage') }} </a>
<br/>
<br/>
<table class="dataTable" >   
    <thead >
        <tr>
            <th scope='col'>#</th>
            <th scope='col'>{{ __('Description555')}}</th>
			<th scope='col'>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($type_storages as $key=>$type_storage )
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$type_storage->description}}</td>
            <td> 
 
            @if($type_storage->status== '1')
				
				<a href="{{route('typeStore.edit', $type_storage->id)}}" class="btn btn-warning link_ajax" >
					{{__('Edit')}}
				</a>
				<a href="{{route('typeStore.destroy', $type_storage->id)}}" class="btn btn-warning link_ajax" >
				{{__('Delete')}}
				</a>
            
             @else
				<a href="{{route('typeStore.destroy', [$type_storage->id, 1] )}}" class="btn btn-warning link_ajax" >
				{{__('Activate')}}
				</a>	
				 
             @endif
            
            </td>  
        </tr>
        @endforeach
    </tbody>
  
</table>

