<div class='btn-group'>

    {{Form::button('<i class="fas fa-edit"></i> Editar',
    [
        "class"=>'btn btn-success btn-sm editRating',
        'data-id'=>$id,
        'data-star_number'=>$star_number,
        'data-rating_description'=>$rating_description,
    ])}}


    @if($status==1)
        {{Form::button('<i class="fas fa-times"></i> Desactivar',["class"=>'btn btn-danger btn-sm','id'=>'deactivateRating','data-id'=>$id])}}
    @endif

    @if($status==0)
        {{Form::button('<i class="fas fa-check"></i> Activar',["class"=>'btn btn-primary btn-sm','id'=>'activateRating','data-id'=>$id])}}
    @endif


</div>

