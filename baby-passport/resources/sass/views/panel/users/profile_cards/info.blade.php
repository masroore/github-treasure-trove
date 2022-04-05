
{{--
<div class="card step-card  btn-full-rounded">
    <h4 class="card-header text-ce-soir border border-ce-soir d-flex justify-content-between align-items-center">
        @include('_partials/svg_render',["path"=>"img/miscellaneous/resume.svg","class"=>"profile-icon"])
        Perfil

    </h4>


    <div class="card-body border border-ce-soir">


        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <b>Teléfono</b>
                <span class="float-right">
                {{$user->momProfile ? $user->momProfile->phone:'Sin llenar'}}
                </span>
            </li>
            <li class="list-group-item">
                <b> Edad</b>
                <span class="float-right">  {{$user->momProfile ? $user->momProfile->birth_date->diffInYears('y').' años.':'Sin llenar'}}</span>
            </li>
            <li class="list-group-item">
                <b>Ocupación</b>
                <span class="float-right">
                {{$user->momProfile ? $user->momProfile->job:'Sin llenar'}}
                </span>
            </li>
            <li class="list-group-item">
                <b>Semana de embarazo</b>
                <span class="float-right">
                {{$user->momProfile ? $user->momProfile->pregnancy_week:'Sin llenar'}}
                </span>
            </li>

        </ul>

    </div>
</div>
--}}
