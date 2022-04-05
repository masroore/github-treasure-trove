@extends('layouts.panel')

@section('sectionTitle')
    <h1>PUBLICIDAD</h1>

@endsection()


@section('content')
    <form id="adForm"
          data-advertising_id="{{isset($ad)?$ad->id:null}}"
          data-action="{{isset($ad)?'/ads/'.$ad->id:'/ads'}}"
    >

        @csrf

        <div class="container">

            <h2 class="text-center mb-3 text-ce-soir">{{isset($ad)?'EDITAR':'NUEVO'}} PUBLICIDAD</h2>


            <div class="form-group">
                <label for="title" class="label text-ce-soir">Título de la Publicidad</label>
                <input type="text"
                       class="form-control btn-full-rounded"
                       name="title"
                       required
                       value="{{isset($ad)?$ad->title:''}}"
                >
            </div>

            <div class="form-group">
                <label for="url" class="label text-ce-soir">URL destino</label>
                <input type="text"
                       class="form-control btn-full-rounded"
                       name="url"
                       required
                       value="{{isset($ad)?$ad->url:''}}"
                >
            </div>


            <div class="form-group">
                <label for="content" class="label text-ce-soir">Contenido</label>
                <textarea class="form-control btn-full-rounded"
                          name="content"
                          required
                >{!! isset($ad)? $ad->content:null !!}</textarea>
            </div>


            <div class="form-group mb-5">
                <label for="image" class="label text-ce-soir">Imagen Póster</label>
                {!! Form::file('image', [
                'id'=>'',
                 !isset($ad)? 'required':null,
                'data-caption'=>isset($ad)? $ad->image:null,

                'data-url'=>isset($ad)? asset('storage/ads/'.$ad->image):null]) !!}
            </div>

            <div class="form-group">
                <label for="published_at" class="label text-ce-soir">Fecha Publicación</label>
                <input type="text"
                       class="form-control btn-full-rounded datepicker"
                       name="published_at"
                       value="{{isset($ad)? $ad->published_at->format('Y-m-d'):null}}"
                       required
                >
            </div>


            <div class="form-group">
                <label for="expires_at" class="label text-ce-soir">Fecha Expiración</label>
                <input type="text"
                       class="form-control btn-full-rounded datepicker"
                       name="expires_at"
                       value="{{isset($ad) && !empty($ad->expires_at) ? $ad->expires_at->format('Y-m-d'):null}}"
                >
            </div>

            <button class="btn btn-ce-soir btn-full-rounded btn-medium">
                <i class="fa fa-save"></i> Guardar
            </button>

        </div>
    </form>


@endsection

@section('custom_scripts')
    <script type="text/javascript" src="{{asset(mix('js/panel/ads.js'))}}"></script>
@endsection()
