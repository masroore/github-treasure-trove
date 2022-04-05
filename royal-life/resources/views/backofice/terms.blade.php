@extends('backofice.layouts.dashboard')
@push('custom_css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;500&display=swap');
    .image{
        float: right;
    }
    .image2{
        float: left;
    }
    .fuente{
    font-family: 'Montserrat';
    font-style: normal;
}

</style>
@endpush

@section('content')
<div class="carousel-inner">
    <img class="d-block w-100 fuente" src="{{asset('assets/img/home/formas_fondo3.png')}}" style="background: #173138;">
    <div class="container carousel-caption d-flex justify-content-start" style="top:90px;left: 7%;">
        <div class="row">
            <div class="col-md-12">

                <div class="text-left">
                    <h3 class="text-white ml-4" style="font-size: 50px;"><strong> Terminos y condiciones </strong></h3>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container fuente pt-5">
    <div class="row">

    </div>
    <img class="image mr-5" src="{{asset('assets/img/home/terms3.png')}}" style="width: 25%;">
    <h4 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>Términos y condiciones de uso del sitio web y términos y condiciones de contrato de ROYAL LIFE  (TC)</strong> </h4>
    <p class="ml-3 mr-3 text-dark mt-1 fuente">
        Te rogamos que dediques unos minutos a leer las siguientes Condiciones generales de uso del sitio web y las Condiciones generales de contrato
        de ROYAL LIFE (“LIFE” o "nosotros") (“TC”), ya que contienen información importante relevante para ti como usuario de
        nuestro sitio web y como comprador de nuestros productos, y se aplican a todos los productos utilizados o comprados
        en nuestro sitio web. Este sitio web y todos los servicios que se ofrecen en él están expresamente sujetos a la
        aceptación de estos TC. Al utilizar nuestro sitio web, comprar productos en él o servirte de cualquiera de nuestros
        servicios, estás aceptando automáticamente estos TC, incluidas las modificaciones futuras que se publicarán en
         nuestro sitio web o que se notificarán de cualquier otra manera. LIFE ofrece acceso exclusivo a este sitio web
         y sus productos y servicios sobre la base de tu aceptación de los TC. Si no las apruebas, no tienes derecho a
         utilizar nuestro sitio web o nuestros servicios, ni a adquirir nuestros productos. Cualquier ambigüedad en la
         interpretación de esos TC no se puede usar contra LIFE.
    </p>
    <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>1. Aplicación de los términos y condiciones (TC)</strong> </h5>
    <p class="ml-3 mr-3 text-dark mt-1 fuente">
        1. Las presentes términos y condiciones (TC) se aplican al uso del sitio web de LIFE (royallife.company y cualquier subdominio
         relacionado: "sitio web") y todos los productos, ofertas, entregas y servicios de LIFE y cualquier otro contrato
         celebrado con, o en nombre de, LIFE, salvo que se acuerde lo contrario por escrito.<br>
<br>
        2. Al utilizar el sitio web y solicitar productos o aceptar servicios a través de él, el cliente ("cliente" o "tú")
        emite automáticamente la conformidad a LIFE de la última versión relevante de las presentes TC.<br>
<br>
        3. Todo el contenido publicado en el sitio web de LIFE (incluidos los logotipos, marcas, derechos de autor, etc.) es
         propiedad intelectual de LIFE y, sin el permiso expreso previo de LIFE, no puede distribuirse, modificarse ni
         utilizarse de ninguna otra manera.<br>
<br>
        4. Al utilizar el sitio web y aceptar estos TC, declaras que en tu país de residencia eres mayor de edad, y que la
        adquisición y el uso de nuestros productos o servicios son legales en tu lugar de residencia o en el destino previsto.
         Es responsabilidad exclusiva del cliente garantizar el cumplimiento de este requisito y LIFE renuncia a toda
          responsabilidad al respecto.<br>
<br>
        5. Nos reservamos el derecho de negarnos a celebrar un determinado contrato o prestación de servicios
        en cualquier momento, sin especificar las razones.<br>
    </p>
    <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>2. Información general y oferta de productos y servicios</strong> </h5>
    <p class="ml-3 mr-3 text-dark mt-1 fuente">
    1. Toda la información que se ofrece en el sitio web o en cualquier otro medio de comunicación escrito de LIFEl está
     elaborada con el máximo cuidado. Sin embargo, LIFE no puede garantizar que toda la información sea correcta,
     completa y/o actualizada. LIFE se reserva el derecho de alterar cualquier información en el sitio web o en otros
      documentos escritos sin previo aviso. Confirmas que estás de acuerdo con que tú eres el responsable de estar al día
       de dichas modificaciones.<br>
<br>
    2. Toda la información sobre nuestros productos y servicios aportada en nuestro sitio web es exclusivamente a título
    informativo, y no se puede considerar como conocimientos médicos ni como asesoramiento médico de LIFE. Cualquier
    decisión tomada por el cliente sobre el uso de nuestros productos y servicios en base a la información proporcionada
     por LIFEl estará sujeta a la responsabilidad personal del cliente, y será por su propio riesgo.<br>
<br>
    3. LIFEl se reserva el derecho, en cualquier momento y sin aceptar responsabilidad con respecto a los clientes o
    terceros, a alterar los productos y servicios proporcionados, y a eliminar productos y servicios de su gama.<br>

    4. En su sitio web, LIFE puede ocasionalmente publicar ofertas especiales relacionadas con sus productos y servicios.
    Nos reservamos el derecho de alterar, restringir o retirar por completo cualquier oferta de este tipo, según
    consideremos conveniente.<br>
<br>
    5. También nos reservamos el derecho, aunque no estamos obligados a ello, a limitar o anular en cualquier momento
    la venta de productos o la prestación de servicios a clientes específicos o a determinados países o territorios
    jurídicos regionales, según nos parezca conveniente y sin necesidad de alegar razones.<br>
<br>
    6. No podemos garantizar que nuestro sitio web y nuestros servicios se puedan proporcionar de forma ininterrumpida
    y sin errores. En el caso de pérdida de servicio o interrupciones, LIFE se pondrá en contacto con el cliente para
     buscar una solución adecuada.
    </p>

    <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>3. Registro, cuenta de usuario y datos personales</strong> </h5>
    <p class="ml-3 mr-3 text-dark mt-1 fuente">
    1. Para poder hacer pedidos en el sitio web, el cliente tiene que crear una cuenta personal en la página de registro.
     Durante el proceso de registro, se le indica al cliente que seleccione un nombre de usuario y contraseña adecuados.
      El nombre de usuario y la contraseña deben manejarse con estricta confidencialidad por parte del cliente.
      LIFE no es responsable de ningún abuso de la información de registro y asumirá que la persona que utiliza nuestro
       sitio web es el cliente registrado.<br>
<br>
    2. Ni LIFE ni sus empleados te pedirán nunca la contraseña. Si sospechas que tu información de registro ha llegado a
    manos no adecuadas, debes modificar dichos datos inmediatamente.<br>
<br>
    3. Como cliente, te comprometes a garantizar que toda la información de tu cuenta sea correcta y esté actualizada.
    LIFE no asume ninguna responsabilidad por retrasos o costes adicionales causados por información incorrecta o
     inexacta proporcionada por el cliente.<br>
<br>
    4. Todos los datos personales del cliente son procesados y protegidos por LIFE como se describe en nuestra Declaración
    de Protección de datos. Los formularios de declaración de protección de datos son parte integral de nuestros TC.
     Para más información, consulta nuestra Declaración de Protección de datos.<br>
    </p>

    <img class="image2" src="{{asset('assets/img/home/terms2.png')}}" style="width: 25%;">

    <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>4. Establecer y celebrar un contrato en el sitio web</strong> </h5>
    <p class="ml-3 mr-3 text-dark mt-1 fuente">

        1. La oferta de productos en el sitio web no se debe entender como una solicitud por parte de LIFE de firmar un contrato de compraventa. Debido a que los productos no están necesariamente disponibles en stock en todo momento, al hacer un pedido, el cliente no puede firmar de inmediato un acuerdo de compra.<br>
<br>
        2. El hecho de hacer un pedido es vinculante para el cliente, quedando este, por tanto, obligado por dicho pedido durante 7 días laborables. La simple confirmación de la recepción del pedido por parte de LIFE no representa la celebración de un acuerdo.<br>
<br>
        3. Aunque haremos todo lo posible para garantizar que toda la información y las especificaciones en nuestro sitio web u otros documentos escritos sean correctos, pueden ocurrir errores y omisiones. Nos reservamos el derecho de corregirlos según lo creamos oportuno, y de actualizar o cancelar un pedido que esté o pueda verse afectado por dichas correcciones.<br>
<br>
        4. El contrato entre tú y LIFE queda establecido con el envío de los productos a tu dirección. LIFE se reserva el derecho de rechazar total o parcialmente el establecimiento de un contrato sin especificar las razones.<br>
<br>
        5. Si se anula, se restringe o se aplaza el pedido de un determinado cliente, LIFE intentará por todos los medios razonables ponerse en contacto con el cliente para aclarar la situación.<br>

    </p>

    <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>5. Precios y condiciones de pago</strong> </h5>
    <p class="ml-3 mr-3 text-dark mt-1 fuente">
        1. Todos los precios especificados por LIFE en sus sitios web y en cualquier otro medio de comunicación escrita incluyen impuestos. Todos los gastos incluidos en el precio están claramente especificados. Los posibles costes adicionales se especificarán aparte y correrán por cuenta del cliente.<br>
<br>
2. Los productos serán enviados por Royal Life by cannabitz  con domicilio en Bogota, Colombia (“royal Life Company”). Todos los derechos de aduana y de importación que haya que abonar son responsabilidad del cliente. Dichos costes adicionales no dependen de LIFE y, por tanto, tampoco puede dar información sobre ellos. Si deseas información al respecto, puedes ponerte en contacto con las autoridades aduaneras del lugar de destino.<br>
<br>
3. El cliente deberá abonar el precio de la compra por anticipado, y se abonará en el momento de la concertación del contrato. Los productos no se entregarán al cliente hasta que esté abonada la totalidad del precio de compra. En caso de retraso en el pago, sin conceder ninguna prórroga, LIFE puede retirarse del acuerdo.<br>
<br>
4. Los métodos de pago aceptados por nosotros están especificados en el sitio web. Nos reservamos el derecho de cambiar estos métodos en cualquier momento, a nuestra discreción.
    </p>

    <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>6. Envío</strong> </h5>
    <p class="ml-3 mr-3 text-dark mt-1 fuente">
        1. En términos generales, los productos se entregarán en la dirección de entrega que hayas especificado al realizar el pedido en un plazo de 8 a 10 días laborables, en la medida en que los productos en cuestión estén completamente disponibles. Los plazos de entrega en determinados países pueden ser más largos;  Los plazos de entrega no son vinculantes; su incumplimiento no te da derecho a rescindir el contrato.<br>
<br>
2. Si LIFE no puede realizar su entrega, primero debes concedernos una prórroga de al menos 20 días laborables durante los cuales aún podamos cumplir el acuerdo antes de que tengas derecho a rescindirlo. En caso de rescisión del contrato por parte del cliente, LIFE solamente se compromete a reembolsar el precio de compra como máximo. Se excluirá toda responsabilidad por compensación adicional por entrega tardía o fallida.<br>
<br>
3. El cliente debe aceptar envíos por partes si, por ejemplo, una parte de los productos pedidos ya no están disponibles o solo se pueden entregar en una fecha posterior.<br>
<br>
4. El lugar de cumplimiento es la ubicación en la que Royal Life company  entrega los productos al servicio postal americano (u otra empresa de transporte). Los beneficios y riesgos se transfieren al cliente tras el envío de dichos productos. LIFE no será responsable por la pérdida o daño de los productos durante el transporte.<br>
    </p>

    <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>7. Garantía y derecho a la devolución</strong> </h5>
    <p class="ml-3 mr-3 text-dark mt-1 fuente">
        1. LIFE es responsable de los defectos que puedan tener los productos comprados, El cliente deberá inspeccionar los productos inmediatamente después de su recepción y comunicar por escrito a LIFE los posibles defectos dentro del plazo de 7 días; en caso contrario se considerará que los productos se han dado por buenos. Los defectos ocultos también se deberán comunicar por escrito a LIFE  dentro del plazo de 7 días desde su descubrimiento.<br>
        <br>
        2. Todos los productos de LIFE se basan en ingredientes naturales y están sujetos a variaciones naturales. No podemos ofrecer ninguna garantía respecto a cualquier desviación en ellos (en color, olor, sabor, etc.).<br>
        <br>
        3. Todos los productos se entregan tal como son. El hecho de que difieran las imágenes, la información o las descripciones de nuestros productos incluidas en el sitio web o de las incluidas en otros medios de comunicación escritos de LIFE no constituye garantía alguna de determinadas propiedades.<br>
        <br>
        4. Los productos defectuosos deben devolverse a Royal Life Company para su inspección, en la dirección de nuestro aliado ubicado en Bogota Colombia en la CR 54 no 153-75. LIFE tiene derecho a proporcionar productos de sustitución o a reembolsar el precio de compra. En el caso de reembolso del precio de compra, los impuestos de importación no se reembolsarán. LIFE no se hace responsable de los daños sufridos por el cliente en base a productos defectuosos. <br>
        <br>
        5. Si no estás satisfecho con tu pedido, tienes derecho a devolver los productos a Royal green Company dentro del plazo de 14 días desde su recepción. Por favor, ponte en contacto con el departamento de atención al cliente con suficiente tiempo de antelación. Los productos deben devolverse sellados, en la medida de lo posible, sin abrir, sin usar, sin daños y en su embalaje original. Tan pronto como hayamos recibido los productos devueltos y se cumplan las condiciones de devolución, se te reembolsará el precio de compra; los gastos de devolución no serán reembolsados.<br>

    </p>
    <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>8. Exclusión de responsabilidad</strong> </h5>
    <p class="ml-3 mr-3 text-dark mt-1 fuente">
        1. LIFE y las empresas vinculadas a ella declinan cualquier responsabilidad, en la medida que sea posible legalmente, por los daños o por cualquier consecuencia negativa para el cliente, resultantes del contrato de compraventa o de la entrega o del uso de productos y servicios de LIFE, o relacionados con ellos.<br>
        <br>
        2. El cliente manifiesta su conformidad con que el uso de los productos entregados y de los servicios prestados por LIFEl es por cuenta y riesgo propios.<br>
            </p>
            <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>9. Atención al cliente</strong> </h5>
            <p class="ml-3 mr-3 text-dark mt-1 fuente">
                Si tienes preguntas, observaciones o reclamaciones sobre nuestros productos o servicios, te puedes poner en contacto por teléfono o por e-mail con nuestro servicio de atención al cliente (información de contacto en el sitio web). LIFE hará todo lo que razonablemente esté en su mano para ponerse en contacto contigo dentro del plazo máximo de 3 días laborables.
            </p>
            <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>10. Modificaciones de los términos y condiciones (TC)</strong> </h5>
            <p class="ml-3 mr-3 text-dark mt-1 fuente">
                Nos reservamos el derecho de modificar o complementar los TC en cualquier momento, sin previo aviso. Los TC se publican en la última versión en nuestro sitio web o se notifican por otras vías.
            </p>

            <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>11. Disposiciones finales</strong> </h5>
            <p class="ml-3 mr-3 text-dark mt-1 fuente">

                1. En caso de que alguna de las disposiciones de estos TC sea total o parcialmente inefectiva, la validez de las disposiciones restantes no se verá afectada. Las disposiciones anuladas serán sustituidas por disposiciones efectivas que coincidan lo máximo posible con la intención original de las partes.<br>
<br>
                2. El acuerdo entre LIFE, el cliente y estos TC está sujeto exclusivamente a normas de conflicto de leyes en el país que Life crea conveniente ( EEUU o COLOMBIA) . La aplicabilidad de la Convención de las Naciones Unidas sobre Contratos para la Venta Internacional de Bienes (CISG) está explícitamente excluida.<br>
                <br>
                3. Cualquier discrepancia que surja de o en relación con el acuerdo entre LIFE, el cliente y estos TC (incluida su aceptación válida) se presentará exclusivamente ante el tribunal en el lugar de establecimiento de Royal Life Company.<br>

                            </p>

            <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>12. Contacto</strong> </h5>
            <p class="ml-3 mr-3 text-dark mt-1 fuente">
                El sitio web está gestionado por Royal Life Company, Si tienes cualquier duda o pregunta sobre este sitio web o su contenido, te puedes poner en contacto por escrito o por e-mail con nuestro servicio de atención al cliente o números designados. (información de contacto en el sitio web).
            </p>



<div class="text-center">
    <img class="text-center" src="{{asset('assets/img/home/terms.png')}}" style="width: 30%;">
</div>
</div>





@endsection

