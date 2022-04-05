<div class='btn-group'>

    {{Form::button('<i class="fas fa-edit"></i> Editar',
    [
        "class"=>'btn btn-success btn-sm editCity',
        'data-id'=>$id,
        'data-city'=>$city,
        'data-copy'=>$copy,
        'data-image'=> $image ? asset('storage/cities/'.$image):null,
        'data-bg_image'=> $bg_image ? asset('storage/cities/'.$bg_image):null,

    ])}}


    @if($status==1)
        {{Form::button('<i class="fas fa-times"></i> Desactivar',["class"=>'btn btn-danger btn-sm','id'=>'deactivateCity','data-id'=>$id])}}
    @endif

    @if($status==0)
        {{Form::button('<i class="fas fa-check"></i> Activar',["class"=>'btn btn-primary btn-sm','id'=>'activateCity','data-id'=>$id])}}
    @endif


</div>

