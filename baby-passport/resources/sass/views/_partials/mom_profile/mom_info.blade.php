<form action="{{route('web.postMomProfile',[$user->id])}}" method="POST" id="momInfoForm" autocomplete="off"
      class="my-4 ">


@csrf
<!-- NAME -->
    <div class="form-row">
        <div class="md-form col-12 col-md-3">
            <label for="name">Nombre <sup class="text-danger">*</sup></label>
        </div>

        <div class="md-form col-12 col-md-9">
            <input
                    type="text"
                    name="name"
                    class="form-control"
                    required
                    data-parsley-group="general"
                    value="{{old('name') ? old('name'): (isset($user) ? $user->name:'')}}">
            @include('_partials/field_error_handling',["fieldName"=>"name"])
        </div>
    </div>

    <!--NAME -->

    <!-- PHONE -->

    <div class="form-row">
        <div class="md-form col-12 col-md-3">
            <label for="name">Teléfono <sup class="text-danger">*</sup></label>
        </div>

        <div class="md-form col-12 col-md-9">
            <input
                    type="text"
                    name="phone"
                    class="form-control"
                    required
                    data-parsley-group="general"
                    value="{{old('phone') ? old('phone'): (isset($user->momProfile) ? $user->momProfile->phone:'')}}">
            @include('_partials/field_error_handling',["fieldName"=>"phone"])
        </div>
    </div>

    <!--END PHONE-->

    <!-- BIRTH DATE -->

    <div class="form-row">
        <div class="md-form col-12 col-md-3">
            <label for="name">Fecha de nacimiento <sup class="text-danger">*</sup></label>
        </div>

        <div class="md-form col-12 col-md-9">
            <input
                    type="text"
                    name="birth_date"
                    class="form-control"
                    required
                    data-parsley-group="general"
                    value="{{old('birth_date') ? old('birth_date'): (isset($user->momProfile) ? $user->momProfile->birth_date->format('Y-m-d'):'')}}">
            @include('_partials/field_error_handling',["fieldName"=>"birth_date"])
        </div>
    </div>


    <!-- END BIRTH DATE --->


    <!-- JOB -->

    <div class="form-row">
        <div class="md-form col-12 col-md-3">
            <label for="name">Ocupación <sup class="text-danger">*</sup></label>
        </div>

        <div class="md-form col-12 col-md-9">
            <input
                    type="text"
                    name="job"
                    class="form-control"
                    required
                    data-parsley-group="general"
                    value="{{old('job') ? old('job'): (isset($user->momProfile) ? $user->momProfile->job:'')}}">
            @include('_partials/field_error_handling',["fieldName"=>"job"])
        </div>
    </div>

    <!-- END JOB -->

    <!-- PREGNANCY WEEK -->


    <div class="form-row">
        <div class="md-form col-12 col-md-3">
            <label for="name">Semana de embarazo <sup class="text-danger">*</sup></label>
        </div>

        <div class="md-form col-12 col-md-9">
            <select class="selectpicker"
                    name="pregnancy_week"
                    data-live-search="true"
                    required
                    data-parsley-group="general">
                <option value="">Seleccione la semana de embarazo</option>

                @for ($i = 1; $i <= 37; $i++)
                    <option
                            value="{{$i}}"
                            {{old('pregnancy_week') ==$i ? 'selected': ''}}
                            {{$user->momProfile ? ($user->momProfile->pregnancy_week == $i ? 'selected':''):'' }}
                    >
                        {{$i}}
                    </option>
                @endfor
            </select>
            @include('_partials/field_error_handling',["fieldName"=>"pregnancy_week"])
        </div>
    </div>


    <!-- END PREGNANCY WEEK -->

    <!-- HOW FOUND -->


    <div class="form-row">
        <div class="md-form col-12 col-md-3">
            <label for="name">¿Cómo nos encontraste? <sup class="text-danger">*</sup></label>
        </div>

        <div class="md-form col-12 col-md-9">
            {{Form::select('how_found',
                            ["Facebook","Google","Otro"],old('how_found') ? old('how_found'): ($user->momProfile ? $user->momProfile->how_found:''),
                            ["required","class"=>"selectpicker",'data-live-search'=>'true',"placeholder"=>"Seleccione una opción"])}}
            @include('_partials/field_error_handling',["fieldName"=>"how_found"])
        </div>
    </div>


    <!-- END HOW FOUND -->


</form>

