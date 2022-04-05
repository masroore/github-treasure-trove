<!doctype html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Pago de Paquete</title>

    <link rel="stylesheet" href="{{asset(mix('css/reports/payment.css'))}}" type="text/css">

</head>
<body>


<header>


    <h1 class="text-center">RECIBO DE COMPRA</h1>

    <!-- HEADER -->
    <table>
        <tr>
            <!--LOGO HEADER -->
            <td width="50%" class="text-left px-3 py-1">

                <table class="logo-header text-center">
                    <tr>
                        <td class="w-15">
                            <img src="{{asset('img/logos/icono-9a7aa0.png')}}" alt=""
                                 height="100%">
                        </td>
                        <td class="w-85 text-left px-3">
                            <img src="{{asset('img/logos/logo-9a7aa0.png')}}" alt=""
                                 width="200px">

                            <p class="mt-1"> Teléfono:+51 442 8674 284</p>
                            <p class="mt-1">Correo electrónico: babypassportc@medicalmeeting.co</p>
                        </td>
                    </tr>
                </table>

            </td>
            <!-- END LOGO HEADER -->

            <!--PAYMENT HEADER -->
            <td width="50%" class="text-right px-3 py-1">

                <h4>
                    <div class="d-block">Fecha Pago</div>
                    <span class="text-grey-suit font-weight-normal">{{$payment->created_at->format('d F Y h:i a')}}</span>
                </h4>


                <h4 class="mt-1">
                    <div class="d-block">UUID Pago</div>
                    <span class="text-grey-suit font-weight-normal">{{$payment->payment_uuid}}</span>
                </h4>


                <h4 class="mt-1">
                    <div class="d-block">Método de Pago</div>
                    <span class="text-grey-suit font-weight-normal">{{$payment->payment_type}}</span>
                </h4>
            </td>

            <!--END PAYMENT HEADER -->
        </tr>
    </table>

    <!--END HEADER-->
</header>

<footer>

    <table class="border-top">
        <tr>
            <td class="w-50">
                <h4>Este comprobante no tiene validez fiscal.</h4>
            </td>
            <td class="w-50 text-right">
                <table>
                    <tr>

                        <td class="w-85 text-right">
                            <h4>Medical Meeting</h4>
                            <p>Todos los derechos reservados {{date('Y')}}</p>
                        </td>
                        <td class="w-15 text-right">
                            <img src="{{asset('img/miscellaneous/MM3-azul.png')}}" alt="" class="logo">
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

    <script type="text/php">
      if (isset($pdf)) {
        $font = $fontMetrics->getFont("Roboto", "bold");
        $pdf->page_text(275, 740, "Página {PAGE_NUM}/{PAGE_COUNT}", $font, 12, array(0, 0, 0));
      }



    </script>
</footer>


<main>


    <table>

        <tr>
            <td width="50%">
                <table>

                    <tr>

                        <td>
                            <h3>DATOS DE LA PACIENTE</h3>


                            <h4 class="mt-3">Nombre:</h4>
                            <p class="text-grey-suit">{{$payment->cart->user->name}}</p>

                            <h4 class="mt-1">Teléfono:</h4>
                            <p class="text-grey-suit">{{$payment->cart->user->momProfile->phone}}</p>

                            <h4 class="mt-1">Correo:</h4>
                            <p class="text-grey-suit">{{$payment->cart->user->email}}</p>

                            <h4 class="mt-1">Semana de embarazo:</h4>
                            <p class="text-grey-suit">{{$payment->cart->user->momProfile->pregnancy_week}}</p>


                        </td>

                    </tr>
                </table>
            </td>
            <td width="50%">
                <table>
                    <tr>

                        <td>
                            <h3>DETALLE DE COMPRA</h3>


                            <h4 class="mt-1">Descripción</h4>
                            <p class="text-grey-suit">
                                {{$payment->description}}
                            </p>

                            <h4 class="mt-1">Subtotal</h4>
                            <p class="text-grey-suit">{{number_format($payment->subtotal,2)}} USD</p>

                            <h4 class="mt-1">IVA</h4>
                            <p class="text-grey-suit">{{number_format($payment->iva,2)}} USD</p>

                            <h4 class="mt-1">Descuento</h4>
                            <p class="text-grey-suit">{{number_format($payment->discount,2)}} USD</p>

                            <h4 class="mt-1">Total</h4>
                            <p class="text-grey-suit">{{number_format($payment->total,2)}} USD</p>

                        </td>

                    </tr>
                </table>
            </td>
        </tr>

    </table>


    @if($payment->cart->hospitalSchedule != null)
        <table class="mt-5">

            <tr>

                <td class="">
                    <h3>DATOS DEL HOSPITAL</h3>


                    <h4 class="mt-1">Nombre</h4>
                    <p class="text-grey-suit">{{$payment->cart->items[0]->hospitalProduct->hospital->name}}</p>

                    <h4 class="mt-1">Ciudad</h4>
                    <p class="text-grey-suit">{{$payment->cart->items[0]->hospitalProduct->hospital->city->city}}</p>


                    <h4 class="mt-1">Día de Cita</h4>
                    <p class="text-grey-suit">{{$payment->cart->hospitalSchedule->start_date->format('d F Y h:i a')}}</p>


                </td>

            </tr>
        </table>
@endif

<!-- MOM DATA HEADER -->
</main>


</body>
</html>
