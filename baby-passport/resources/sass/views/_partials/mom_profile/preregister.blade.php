<form action="{{route('web.postSavePreregister',[$user->id])}}" method="POST" id="momPreregister"
      autocomplete="off">

    @csrf

    <div class="form-group row">
        <label for="father_name" class="col-12 col-md-4">Nombre Completo del papá</label>
        <div class="col-12 col-md-8">
            <input
                    type="text"
                    name="father_name"
                    class="form-control btn-full-rounded"
                    value="{{old('mom_history.father_name') ? old('mom_history.father_name'): ($user->momHistory ? $user->momHistory->father_name:'')}}">
            @include('_partials/field_error_handling',["fieldName"=>"mom_history.father_name"])
        </div>

    </div>

    <div class="form-group row">
        <label for="father_phone" class="col-12 col-md-4">Teléfono del papá</label>

        <div class="col-12 col-md-8">
            <input
                    type="text"
                    class="form-control btn-full-rounded"
                    required
                    name="father_phone"
                    data-parsley-group="format"
                    value="{{old('mom_history.father_phone') ? old('mom_history.father_phone'): ($user->momHistory ? $user->momHistory->father_phone:'')}}">
            @include('_partials/field_error_handling',["fieldName"=>"mom_history.father_phone"])
        </div>

    </div>

    <div class="form-group row">
        <label for="father_phone" class="col-12 col-md-4">Email del papá</label>
        <div class="col-12 col-md-8">
            <input
                    type="email"
                    name="father_email"
                    class="form-control btn-full-rounded"
                    required
                    data-parsley-group="format"
                    value="{{old('mom_history.father_email') ? old('mom_history.father_email'): ($user->momHistory ? $user->momHistory->father_email:'')}}">
            @include('_partials/field_error_handling',["fieldName"=>"mom_history.father_email"])
        </div>


    </div>

    <div class="form-group row">
        <label for="family_from" class="col-12 col-md-4">Estado del que proviene la pareja</label>
        <div class="col-12 col-md-8">
            <input
                    type="text"
                    name="family_from"
                    class="form-control btn-full-rounded"
                    required
                    data-parsley-group="format"
                    value="{{old('mom_history.family_from') ? old('mom_history.family_from'): ($user->momHistory ? $user->momHistory->family_from:'')}}">
            @include('_partials/field_error_handling',["fieldName"=>"mom_history.family_from"])
        </div>


    </div>

    <div class="form-group row">
        <label for="family_address" class="col-12 col-md-4">Dirección</label>
        <div class="col-12 col-md-8">
            <input
                    type="text"
                    name="family_address"
                    class="form-control btn-full-rounded"
                    required
                    data-parsley-group="format"
                    value="{{old('mom_history.family_address') ? old('mom_history.family_address'): ($user->momHistory ? $user->momHistory->family_address:'')}}">
            @include('_partials/field_error_handling',["fieldName"=>"mom_history.family_address"])
        </div>


    </div>

    <div class="form-group row align-items-center">
        <div class="col-12 col-md-6">
            <div class="form-check mb-2">
                <input
                        name="married"
                        class="form-check-input"
                        type="checkbox"
                        value="1"
                        {{old('mom_history.married') || ($user->momHistory && $user->momHistory->married) ? 'checked':''}}
                        data-parsley-group="format">
                <label class="form-check-label">
                    ¿Están casados?
                </label>
            </div>

            <div class="form-check mb-2">

                <input
                        name="marriage_paper"
                        class="form-check-input"
                        type="checkbox"
                        value="1"
                        {{old('mom_history.marriage_paper') || ($user->momHistory && $user->momHistory->marriage_paper) ? 'checked':''}}
                        data-parsley-group="format">
                <label class="form-check-label" for="gridCheck1">
                    ¿Tienen acta de matrimonio?
                </label>
            </div>

            <div class="form-check mb-2">
                <input
                        name="usa_family"
                        class="form-check-input"
                        type="checkbox"
                        value="1"
                        {{old('mom_history.usa_family') || ($user->momHistory && $user->momHistory->usa_family) ? 'checked':''}}
                        data-parsley-group="format">
                <label class="form-check-label">
                    ¿Tiene familiares en USA?
                </label>
            </div>

            <div class="form-check mb-2">
                <input
                        name="usa_zip"
                        class="form-check-input"
                        type="checkbox"
                        value="1"
                        {{old('mom_history.usa_zip') || ($user->momHistory && $user->momHistory->usa_zip) ? 'checked':''}}
                        data-parsley-group="format">
                <label class="form-check-label">
                    ¿Tiene código postal en USA?
                </label>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-check mb-2">
                <input
                        name="first_baby"
                        class="form-check-input"
                        type="checkbox"
                        value="1"
                        {{old('mom_history.first_baby') || ($user->momHistory && $user->momHistory->first_baby) ? 'checked':''}}
                        data-parsley-group="format">
                <label class="form-check-label">
                    ¿Es madre primeriza?
                </label>
            </div>

            <div class="form-check mb-2">
                <input
                        name="alone_ride"
                        class="form-check-input"
                        type="checkbox"
                        value="1"
                        {{old('mom_history.alone_ride') || ($user->momHistory && $user->momHistory->alone_ride) ? 'checked':''}}
                        data-parsley-group="format">
                <label class="form-check-label">
                    ¿Viaja sola?
                </label>
            </div>

            <div class="form-check">
                <input
                        name="usa_child"
                        class="form-check-input"
                        type="checkbox"
                        value="1"
                        {{old('mom_history.usa_child') || ($user->momHistory && $user->momHistory->usa_child) ? 'checked':''}}
                        data-parsley-group="format">
                <label class="form-check-label">
                    ¿Ha tenido hijos en USA?
                </label>
            </div>
        </div>
    </div>


    <div class="form-group pt-3 row">
        <label for="exampleInputPassword1" class="col-12 col-md-4">Nombre de un familiar de confianza</label>
        <div class="col-12 col-md-8">
            <input
                    name="familiar_name"
                    type="text"
                    class="form-control btn-full-rounded"
                    data-parsley-group="format"
                    value="{{old('mom_history.familiar_name') ? old('mom_history.familiar_name'): ($user->momHistory ? $user->momHistory->familiar_name:'')}}">
        </div>

    </div>

    <div class="form-group row">
        <label for="exampleInputPassword1" class="col-12 col-md-4">Teléfono del familiar</label>

        <div class="col-12 col-md-8">
            <input
                    name="familiar_phone"
                    type="text"
                    class="form-control btn-full-rounded"
                    value="{{old('mom_history.familiar_phone') ? old('mom_history.familiar_phone'): ($user->momHistory ? $user->momHistory->familiar_phone:'')}}"
                    data-parsley-group="format">
        </div>

    </div>


</form>

