<!doctype html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ficha de Referencia</title>

    <link rel="stylesheet" href="{{asset(mix('css/reports/payment.css'))}}" type="text/css">

</head>
<body>


<header>


    <h1 class="text-center">FICHA DE DEPÓSITO</h1>

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
        </tr>
    </table>

    <!--END HEADER-->
</header>


<main>

    <table class="mt-5">

        <tr>
            <td class="font-campton text-ce-soir">
                <h3>RAZÓN SOCIAL</h3>
            </td>
            <td class="text-grey-suit">TURISMO MÉDICO DIGITAL,S.A.P.I. DE C.V.</td>
        </tr>

        <tr>
            <td class="text-ce-soir">
                <h3>BANCO</h3>
            </td>
            <td class="text-grey-suit">BANREGIO</td>
        </tr>

        <tr>
            <td class="text-ce-soir">
                <h3>NO. DE CUENTA</h3>
            </td>
            <td class="text-grey-suit">165 94619 001 01</td>
        </tr>

        <tr>
            <td class="text-ce-soir">
                <h3>CLABE</h3>
            </td>
            <td class="text-grey-suit">058680000002731053</td>
        </tr>

        <tr>
            <td class="text-ce-soir">
                <h3>REFERENCIA</h3>
            </td>
            <td class="text-grey-suit">{{$userId}} - {{$package}}</td>
        </tr>

        <tr>
            <td class="text-ce-soir">
                <h3>IMPORTE USD</h3>
            </td>
            <td class="text-grey-suit">{{number_format($amount,2)}} USD</td>
        </tr>

        <tr>
            <td class="text-ce-soir">
                <h3>TIPO CAMBIO</h3>
            </td>
            <td class="text-grey-suit">{{$exchange_rate}} MXN</td>
        </tr>

        <tr>
            <td class="text-ce-soir">
                <h3>TOTAL A DEPOSITAR</h3>
            </td>
            <td class="text-grey-suit">{{number_format(round($exchange_rate*$amount,2),2)}} MXN</td>
        </tr>


    </table>


    <!-- MOM DATA HEADER -->
</main>
<footer>

    <table class="border-top">
        <tr>
            <td class="w-50">
                <h4>Presenta este pdf en ventanilla.</h4>
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


</body>
</html>
