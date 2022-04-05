{!! Form::open(['url' => 'M0002.store', "id"=>"frm_typeStorage", "class"=>"validate", 'autocomplete'=>'Off']) !!}

	@include ('type_storages.form', ['modo'=>__('Create')])

{!! Form::close() !!}
