


 <div id="accordion" class="accordion bg-transparent">



    <div class="card border-0  btn-full-rounded">
        <div class="card-header border-0" id="headingIm">
            <h1 class="mb-0 ">
                <button class="btn btn-link text-ce-soir   text-uppercase" type="button" data-toggle="collapse"
                        data-target="#collapseIm" aria-expanded="true" aria-controls="collapseIm">
                    <i class="fas fa-caret-down"></i> 1. YO
                </button>
            </h1>
        </div>

        <div id="collapseIm" class="collapse show" aria-labelledby="headingIm" data-parent="#accordion">
            <div class="card-body btn-full-rounded">
                Únicamente necesitas tener VISA vigente al momento del parto (No importa que tipo de VISA sea).
            </div>
        </div>
    </div>

    <div class="card border-0  btn-full-rounded mt-3">
        <div class="card-header border-0" id="headingPreregister">
            <h1 class="mb-0 ">
                <button class="btn btn-link text-ce-soir   text-uppercase" type="button" data-toggle="collapse"
                        data-target="#collapsePreregister" aria-expanded="true" aria-controls="collapsePreregister">
                    <i class="fas fa-caret-down"></i> 2. PREREGISTRO
                </button>
            </h1>
        </div>

        <div id="collapsePreregister" class="collapse show" aria-labelledby="headingPreregister" data-parent="#accordion">
            <div class="card-body btn-full-rounded">
                Únicamente necesitas tener VISA vigente al momento del parto (No importa que tipo de VISA sea).
            </div>
        </div>
    </div>



    <div class="card border-0  btn-full-rounded mt-3">
        <div class="card-header border-0" id="headingItem">
            <h1 class="mb-0 ">
                <button class="btn btn-link text-ce-soir   text-uppercase" type="button" data-toggle="collapse"
                        data-target="#collapseItem" aria-expanded="true" aria-controls="collapseItem">
                    <i class="fas fa-caret-down"></i> 3. SELECCIONA TU PAQUETE
                </button>
            </h1>
        </div>

        <div id="collapseItem" class="collapse show" aria-labelledby="headingItem" data-parent="#accordion">
            <div class="card-body btn-full-rounded">
                Únicamente necesitas tener VISA vigente al momento del parto (No importa que tipo de VISA sea).
            </div>
        </div>
    </div>




    <div class="card border-0  btn-full-rounded mt-3">
        <div class="card-header border-0" id="headingAppointment">
            <h1 class="mb-0 ">
                <button class="btn btn-link text-ce-soir   text-uppercase" type="button" data-toggle="collapse"
                        data-target="#collapseAppointment" aria-expanded="true" aria-controls="collapseAppointment">
                    <i class="fas fa-caret-down"></i> 4.- AGENDA TU CITA
                </button>
            </h1>
        </div>

        <div id="collapseAppointment" class="collapse show" aria-labelledby="headingAppointment" data-parent="#accordion">
            <div class="card-body btn-full-rounded">
                Únicamente necesitas tener VISA vigente al momento del parto (No importa que tipo de VISA sea).
            </div>
        </div>
    </div>




    <div class="card border-0  btn-full-rounded mt-3">
        <div class="card-header border-0" id="headingVISA">
            <h1 class="mb-0 ">
                <button class="btn btn-link text-ce-soir   text-uppercase" type="button" data-toggle="collapse"
                        data-target="#collapseVISA" aria-expanded="true" aria-controls="collapseVISA">
                    <i class="fas fa-caret-down"></i> 5.- ADJUNTA TU VISA
                </button>
            </h1>
        </div>

        <div id="collapseVISA" class="collapse show" aria-labelledby="headingVISA" data-parent="#accordion">
            <div class="card-body btn-full-rounded">
                Únicamente necesitas tener VISA vigente al momento del parto (No importa que tipo de VISA sea).
            </div>
        </div>
    </div>

    <div class="card border-0  btn-full-rounded mt-3">
        <div class="card-header border-0" id="headingPayment">
            <h1 class="mb-0 ">
                <button class="btn btn-link text-ce-soir   text-uppercase" type="button" data-toggle="collapse"
                        data-target="#collapsePayment" aria-expanded="true" aria-controls="collapsePayment">
                    <i class="fas fa-caret-down"></i> 6.- REALIZA EL PAGO
                </button>
            </h1>
        </div>

        <div id="collapsePayment" class="collapse show" aria-labelledby="headingPayment" data-parent="#accordion">
            <div class="card-body btn-full-rounded">
                Únicamente necesitas tener VISA vigente al momento del parto (No importa que tipo de VISA sea).
            </div>
        </div>
    </div>





</div>


{{-- SMART WIZARD >=XL DEVICES ---}}
{{--<div id="smartwizard" class="d-none d-xl-block">
    <ul class="text-center">
        <li>
            <a href="#step-1">
                <span class="font-campton d-block">YO</span>

                <span class="badge {{$stepIndex < 1 ?'badge-selective-yellow':'badge-success'}}  text-light">
                   {{$stepIndex < 1 ?'Pendiente':'Completado'}}
                </span>
            </a>
        </li>
        <li>
            <a href="#step-2">
                <span class="font-campton d-block">PREREGISTRO</span>
                <span class="badge {{$stepIndex <= 2 ?'badge-selective-yellow':'badge-success'}}  text-light">
                   {{$stepIndex <= 2 ?'Pendiente':'Completado'}}
                </span>
            </a>
        </li>
        <li>
            <a href="#step-3">
                <span class="font-campton d-block">PAQUETE</span>
                <span class="badge {{$stepIndex <= 3 ?'badge-selective-yellow':'badge-success'}}  text-light">
                   {{$stepIndex <= 3 ?'Pendiente':'Completado'}}
                </span>
            </a>
        </li>

        <li>
            <a href="#step-4">
                <span class="font-campton d-block">AGENDA TU CITA</span>
                <span class="badge {{$stepIndex < 4 ?'badge-selective-yellow':'badge-success'}}  text-light">
                   {{$stepIndex < 4 ?'Pendiente':'Completado'}}
                </span>
            </a>
        </li>
        <li>
            <a href="#step-5">
                <span class="font-campton d-block">ADJUNTA TU VISA</span>
                <span class="badge {{$stepIndex < 5 ?'badge-selective-yellow':'badge-success'}}  text-light">
                   {{$stepIndex < 5 ?'Pendiente':'Completado'}}
                </span>
            </a>
        </li>
        <li>
            <a href="#step-6">
                <span class="font-campton d-block">REALIZA EL PAGO</span>
                <span class="badge {{$stepIndex < 6 ?'badge-selective-yellow':'badge-success'}}  text-light">
                   {{$stepIndex < 6 ?'Pendiente':'Completado'}}
                </span>
            </a>
        </li>
    </ul>

    <div>
        <div id="step-1" class="">
            @include("_partials/mom_profile/mom_info")
        </div>
        <div id="step-2" class="">
            @include("_partials/mom_profile/preregister")
        </div>
        <div id="step-3" class="">
            Step Content
        </div>
        <div id="step-4" class="">
            Step Content
        </div>
        <div id="step-5" class="">
            Step Content
        </div>
        <div id="step-6" class="">
            Step Content
        </div>
    </div>
</div>--}}

{{-- END SMART WIZARD >=XL DEVICES --}}