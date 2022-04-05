{!! Form::open(['route'=>'typeStore.update',  "class"=>"validate", 'autocomplete'=>'Off'])  !!}

	@include ('type_storages.form', ['modo'=>__('Edit')])

{!! Form::close() !!}

