{!! Form::open(['url' => 'M0002.update/'. $typeStorages->id,  "class"=>"validate"])  !!}

@include ('type_storages.form', ['modo'=>'Edit'])

{!! Form::close() !!}