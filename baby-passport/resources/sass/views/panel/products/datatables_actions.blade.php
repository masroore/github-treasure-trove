<div class='btn-group'>

    {{Form::button('<i class="fas fa-edit"></i> Editar',
    [
        "class"=>'btn btn-success btn-sm editProduct',
        'data-id'=>$id
    ])}}


    @if($status==1)
        {{Form::button('<i class="fas fa-times"></i> Desactivar',["class"=>'btn btn-danger btn-sm','id'=>'deactivateProduct','data-id'=>$id])}}
    @endif

    @if($status==0)
        {{Form::button('<i class="fas fa-check"></i> Activar',["class"=>'btn btn-primary btn-sm','id'=>'activateProduct','data-id'=>$id])}}
    @endif


</div>

