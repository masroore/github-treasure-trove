@extends('layouts.panel')

@section('sectionTitle')
    <h1>Usuarios</h1>

@endsection()



@section('content')


    <div class="container">

        <div class="row">
            <div class="col-12">
                <h2 class="text-ce-soir mb-3">
                    Usuarios
                </h2>
            </div>
        </div>

        <div class="row align-items-center justify-content-between mb-3">

            <div class="md-form">
                <label for="registerFrom" class="label control-label">Registro desde</label>
                {{Form::text('',null,["class"=>"form-control datepicker","id"=>"registerFrom"])}}
            </div>


            <div class="md-form">
                <label for="registerTo" class="label control-label">Registro hasta</label>
                {{Form::text('',null,["class"=>"form-control datepicker","id"=>"registerTo"])}}
            </div>


            <label for="userFilter" class="label control-label">Tipo usuario</label>
            {{Form::select('',['pacient'=>'Mamá','main_doctor'=>'Doctor'],null,["class"=>"selectpicker","placeholder"=>"Ver todos",'id'=>"userFilter"])}}


            <label for="userFilter" class="label control-label">Etapa</label>
            {{Form::select('',['lead'=>'Lead','profile'=>'Perfil','maternity_package'=>'Paquete seleccionado','parcial_payment'=>'Pago parcial'],null,
            ["class"=>"selectpicker","placeholder"=>"Ver todos",'id'=>"stepFilter"])}}


            <button class="btn btn-ce-soir white-text btn-md" id="filterSubmit">
                <i class="fas fa-search"></i> Buscar
            </button>

        </div>

        {!! $dataTable->table(['width' => '100%']) !!}
    </div>

@endsection

@section('custom_scripts')


    {!! $dataTable->scripts() !!}

    <script type="text/javascript" src="{{asset(mix('js/panel/user.js'))}}"></script>
@endsection()
