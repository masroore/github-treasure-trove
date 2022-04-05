<div class='btn-group'>

    {{Form::button('<i class="fas fa-edit"></i> Editar',
    [
        "class"=>'btn btn-success btn-sm editCategory',
        'data-id'=>$id,
        'data-category'=>$category,
        'data-color'=>$color,
        'data-text_color'=>$text_color
    ])}}


    @if($status==1)
        {{Form::button('<i class="fas fa-times"></i> Desactivar',["class"=>'btn btn-danger btn-sm','id'=>'deactivateCategory','data-id'=>$id])}}
    @endif

    @if($status==0)
        {{Form::button('<i class="fas fa-check"></i> Activar',["class"=>'btn btn-primary btn-sm','id'=>'activateCategory','data-id'=>$id])}}
    @endif


</div>

