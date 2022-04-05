<div class='btn-group'>


    <a href="{{route('blogs.create',[$id])}}" class="btn btn-success btn-sm">
        <i class="fas fa-edit"></i> Editar
    </a>


    @if($status==1)
        {{Form::button('<i class="fas fa-times"></i> Cancelar',["class"=>'btn btn-danger btn-sm','id'=>'deactivateBlog','data-id'=>$id])}}
    @endif

    @if($status==0)
        {{Form::button('<i class="fas fa-check"></i> Publicar',["class"=>'btn btn-primary btn-sm','id'=>'activateBlog','data-id'=>$id])}}
    @endif


</div>

