<div class='btn-group'>

    {{Form::button('<i class="fas fa-edit"></i> Editar',["class"=>'btn btn-success btn-sm editTag','data-id'=>$id,'data-tag'=>$tag])}}


    @if($status==1)
        {{Form::button('<i class="fas fa-times"></i> Desactivar',["class"=>'btn btn-danger btn-sm','id'=>'deactivateTag','data-id'=>$id])}}
    @endif

    @if($status==0)
        {{Form::button('<i class="fas fa-check"></i> Activar',["class"=>'btn btn-primary btn-sm','id'=>'activateTag','data-id'=>$id])}}
    @endif


</div>

