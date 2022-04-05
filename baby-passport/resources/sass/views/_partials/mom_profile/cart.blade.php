<form id="maternityPackageForm" method="GET" data-action="{{URL::to('')}}/mom/setMaternityPackage/">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">


            <div class="form-group">
                <label for="color" class="label text-ce-soir">
                    Ciudad
                    <sp class="text-danger">*</sp>
                </label>
                <select name=""
                        id="citiesSelect"
                        class="selectpicker"
                        data-live-search="true"
                        required
                        data-width="100%">
                    <option value="">Seleccione una ciudad</option>
                    @foreach($cities as $city)
                        <option value="{{$city->id}}"
                                data-content="<img style='height:30px;width:30px;border-radius:50%;' src='{{asset('storage/cities/'.$city->image)}}' /> {{$city->city}}"></option>

                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="color" class="label text-ce-soir">
                    Clínica
                    <sp class="text-danger">*</sp>
                </label>
                <select name=""
                        id="hospitalsSelect"
                        class="selectpicker"
                        required
                        data-live-search="true"
                        data-width="100%">

                </select>
            </div>

            <div class="form-group">
                <label for="color" class="label text-ce-soir">
                    Paquete
                    <sp class="text-danger">*</sp>
                </label>
                <select
                        name=""
                        id="itemsSelect"
                        class="selectpicker"
                        data-live-search="true"
                        required
                        data-width="100%">

                </select>
            </div>
        </div>
    </div>
</form>

