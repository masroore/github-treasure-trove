<div class="card step-card btn-full-rounded">
    <h4 class="card-header text-ce-soir mb-1 d-flex justify-content-between align-items-center border border-ce-soir">
        @include('_partials/svg_render',["path"=>"img/miscellaneous/preregistro.svg","class"=>"profile-icon"])
        Preregistro
    </h4>

    <div class="card-body border border-ce-soir">

        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <b>Nombre del papá</b>
                <span class="float-right">
                {{$user->momHistory ? $user->momHistory->father_name:''}}
                </span>
            </li>

            <li class="list-group-item">
                <b>Teléfono del papá</b>
                <span class="float-right">
                {{$user->momHistory ? $user->momHistory->father_phone:''}}
                </span>
            </li>

            <li class="list-group-item">
                <b>Email del papá</b>
                <span class="float-right">
                {{$user->momHistory ? $user->momHistory->father_email:''}}
                </span>
            </li>
            <li class="list-group-item">
                <b>Estado del que proviene la pareja</b>
                <span class="float-right">
                {{$user->momHistory ? $user->momHistory->family_from:''}}
                </span>
            </li>

            <li class="list-group-item">
                <b>Dirección</b>
                <span class="float-right">
                {{$user->momHistory ? $user->momHistory->family_address:''}}
                </span>
            </li>


            <li class="list-group-item">
                <b>¿Están casados?</b>
                <span class="float-right">
                {!! $user->momHistory && $user->momHistory->married ?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>' !!}
                </span>
            </li>


            <li class="list-group-item">
                <b> ¿Tienen acta de matrimonio?</b>
                <span class="float-right">
                {!! $user->momHistory && $user->momHistory->marriage_paper ?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>' !!}
                </span>
            </li>

            <li class="list-group-item">
                <b> ¿Tiene familiares en USA?</b>
                <span class="float-right">
                {!! $user->momHistory && $user->momHistory->usa_family ?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>' !!}
                </span>
            </li>

            <li class="list-group-item">
                <b> ¿Tiene código postal en USA?</b>
                <span class="float-right">
                {!! $user->momHistory && $user->momHistory->usa_zip ?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>' !!}
                </span>
            </li>
            <li class="list-group-item">
                <b> ¿Es madre primeriza?</b>
                <span class="float-right">
                {!! $user->momHistory && $user->momHistory->first_baby ?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>' !!}
                </span>
            </li>
            <li class="list-group-item">
                <b>¿Viaja sola?</b>
                <span class="float-right">
                {!! $user->momHistory && $user->momHistory->alone_ride ?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>' !!}
                </span>
            </li>
            <li class="list-group-item">
                <b>¿Ha tenido hijos en USA?</b>
                <span class="float-right">
                {!! $user->momHistory && $user->momHistory->usa_child ?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>' !!}
                </span>
            </li>

            <li class="list-group-item">
                <b>Nombre de un familiar de confianza</b>
                <span class="float-right">
                {!! $user->momHistory && $user->momHistory->familiar_name ?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>' !!}
                </span>
            </li>

            <li class="list-group-item">
                <b>Teléfono del familiar de confianza</b>
                <span class="float-right">
                {!! $user->momHistory && $user->momHistory->familiar_phone ?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>' !!}
                </span>
            </li>
        </ul>
    </div>
</div>


