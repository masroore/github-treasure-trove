<h1> {{ $modo }} Description {{__('User')}} </h1>


@if(count($errors)>0)

    <div class="alert alert-danger" role="alert">
<ul>
    @foreach($errors->all() as $error)
    <li> {{ $error }} </li>
    @endforeach
</ul>
    </div>
@endif

<div class="form-group">
    {!!Form::label('type_storages', 'Description')!!}
    {!!Form::text('description', $value = isset($typeStorages ->description)?$typeStorages ->description:'', ['class' => 'form-control required']) !!}


</div>



{!! Form::submit('Save', ['class' => 'btn btn-success']) !!}




<a class="btn btn-primary link_ajax" href="{{url('M0002')}}">Return </a>
