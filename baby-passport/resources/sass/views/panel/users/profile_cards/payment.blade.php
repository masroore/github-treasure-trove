@if($hospital != null)
    @include("_partials/hospital_profile/confirm_appointment")
@endif

<div class="card step-card btn-full-rounded mt-5">
    <h4 class="card-header text-ce-soir mb-1 d-flex justify-content-between align-items-center border border-ce-soir">
        @include('_partials/svg_render',["path"=>"img/miscellaneous/credit-cards-payment.svg","class"=>"profile-icon"])
        PAQUETES CONTRATADOS
    </h4>

    <div class="card-body border border-ce-soir">


        <table class="table bg-light font-campton font-weight-bold rounded">

            <thead>
            <tr>
                <th scope="col">Concepto</th>
                <th scope="col">Importe</th>
                <th scope="col">Acciones</th>
            </tr>

            <tbody>

            @foreach($user->cart as $cart)

                <tr>

                    <td class="text-left" scope="row">
                        <p class="mb-1">{{preg_match('(deposit)',$cart->status)? 'DEPÓSITO DE '.$cart->items[0]->hospitalProduct->deposit.'%':''}}
                            {{$cart->items[0]->hospitalProduct->product->product}}
                        </p>

                        <span class="badge badge-ce-soir text-light p-2 btn-full-rounded">
                           @lang('custom.'.$cart->status)
                       </span>

                        @if($cart->hospitalSchedule)
                            <h5 class="mt-3">Cita</h5>
                            <p class="mt-2 mb-1">
                                <i class="fas fa-user"></i>
                                {{$cart->hospitalSchedule->hospital->name}}
                            </p>
                            <p>
                                <i class="fas fa-calendar"></i>
                                {{$cart->hospitalSchedule->start_date->format('d F Y h:i a')}}
                            </p>

                        @endif

                    </td>
                    <td>
                        {{number_format($cart->amount,2)}} USD
                    </td>
                    <td>
                        @switch($cart->status)

                            @case('deposit_pending')
                            @case('pending')


                            @if($cart->voucher != null)
                                <div class="btn-group">


                                    <a href="{{asset('storage/moms/'.$cart->user_id.'/'.$cart->voucher)}}"
                                       download="{{$cart->voucher}}"
                                       class="btn btn-ce-soir text-light"
                                    >

                                        <i class="fas fa-download"></i> Voucher
                                    </a>

                                    @if($cart->status =="deposit_pending")
                                        <a class="btn btn-ce-soir"
                                           href="{{route('web.getSetAppointment',[rawurlencode($cart->items[0]->hospitalProduct->hospital->name),$cart->user_id,$cart->id])}}"
                                        >
                                            <i class="fas fa-calendar"></i> Agendar cita
                                        </a>
                                    @endif

                                    <a
                                            href="{{route('web.generateReceipt',[$cart->id])}}"
                                            class="btn btn-ce-soir text-light"
                                    >

                                        <i class="fas fa-file-pdf"></i> Generar recibo
                                    </a>

                                </div>


                            @endif
                            @break


                            @case('sold')
                            @case('deposit_sold')

                            <a class="btn btn-ce-soir btn-full-rounded"
                               href="{{route('web.getSetAppointment',[rawurlencode($cart->items[0]->hospitalProduct->hospital->name),$cart->user_id,$cart->id])}}"
                            >
                                <i class="fas fa-calendar"></i> Agendar cita
                            </a>

                            <a class="btn btn-ce-soir btn-full-rounded"
                               href="{{asset('storage/moms/'.$cart->user_id.'/'.$cart->id.'.pdf')}}"
                               download="recibo-{{strtotime($cart->user->updated_at->format('Y-m-d h:i:s'))}}">
                                <i class="fas fa-file-pdf"></i> Ver recibo
                            </a>

                            @break

                        @endswitch
                    </td>
                </tr>
            @endforeach

            </tbody>
            </thead>
        </table>


    </div>


    <div class="card-footer mt-1 text-center">


    </div>
</div>



