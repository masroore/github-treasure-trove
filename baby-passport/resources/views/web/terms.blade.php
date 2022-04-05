@extends('layouts.app')

@section('title')
    <title>BabyPassport| Términos y condiciones de uso</title>
@endsection


@section('navbar')
    @include("_partials/navbar",["color"=>"ce-soir","logo"=>"9a7aa0"])
@endsection

@section('content')

<section class="pb-lg-5 terms">

    <h1 class="text-center text-grey-suit mb-5 ">TÉRMINOS Y CONDICIONES.</h1>

  <div class="container">


      <div
        class="accordion"
        id="accordion"
        role="tablist"
        aria-multiselectable="true"
      >
        <!--SECTION 1-->
        @include('_partials/term_section',[
            'termIndex'=>0,
            'termTitle'=>'SECCIÓN 1 - TÉRMINOS DE LA TIENDA EN LÍNEA',
            'termContent'=>'
                <p>
                    Al utilizar este sitio, declaras que tienes al menos la mayoría de
                    edad en tu estado, provincia de residencia o en tu país, y que nos has
                    dado tu consentimiento para permitir que cualquiera de tus
                    dependientes menores use este sitio.
                </p>
                <p>
                    No puedes usar nuestros productos con ningún propósito ilegal o no
                    autorizado tampoco puedes, en el uso del Servicio, violar cualquier
                    ley en tu jurisdicción (incluyendo pero no limitado a las leyes de
                    derecho de autor).
                </p>
                <p>
                    El incumplimiento o violación de cualquiera de estos Términos darán
                    lugar al cese inmediato de tus Servicios.
                </p>'])

        <!--END SECTION 1-->

        <!--SECTION 2-->

        @include('_partials/term_section',[
            'termIndex'=> 1,
            'termTitle'=>'SECCIÓN 2 - CONDICIONES GENERALES',
            'termContent'=>'
                <p>
                    Nos reservamos el derecho de rechazar la prestación de servicio a
                    cualquier persona, por cualquier motivo y en cualquier momento.
                </p>
                <p>
                    Entiendes que tu contenido (sin incluir la información de tu tarjeta
                    de crédito), puede ser transferida sin encriptar e involucrar (a)
                    transmisiones a través de varias redes; y (b) cambios para ajustarse o
                    adaptarse a los requisitos técnicos de conexión de redes o
                    dispositivos. La información de tarjetas de crédito está siempre
                    encriptada durante la transferencia a través de las redes.
                </p>
                <p>
                    Estás de acuerdo con no reproducir, duplicar, copiar, vender, revender
                    o explotar cualquier parte del Servicio, uso del Servicio, o acceso al
                    Servicio o cualquier contacto en el sitio web a través del cual se
                    presta el servicio, sin el expreso permiso por escrito de nuestra
                    parte.
                </p>
                <p>
                    Los títulos utilizados en este acuerdo se incluyen solo por
                    conveniencia y no limita o afecta a estos Términos.
                </p>'])

        <!--END SECTION 2-->

        <!--SECTION 3-->

        @include('_partials/term_section',[
            'termIndex'=> 2,
            'termTitle'=>'SECCIÓN 3 - EXACTITUD, EXHAUSTIVIDAD Y ACTUALIDAD DE LA INFORMACIÓN',
            'termContent'=>'
                <p>
                    No nos hacemos responsables si la información disponible en este sitio
                    no es exacta, completa o actual. El material en este sitio es provisto
                    sólo para información general y no debe confiarse en ella o utilizarse
                    como la única base para la toma de decisiones sin consultar
                    primeramente, información más precisa, completa u oportuna. Cualquier
                    dependencia en el materia de este sitio es bajo su propio riesgo.
                </p>
                <p>
                    Este sitio puede contener cierta información histórica. La información
                    histórica, no es necesariamente actual y es provista únicamente para
                    tu referencia. Nos reservamos el derecho de modificar los contenidos
                    de este sitio en cualquier momento, pero no tenemos obligación de
                    actualizar cualquier información en nuestro sitio. Aceptas que es tu
                    responsabilidad de monitorear los cambios en nuestro sitio.
                </p>'])


        <!--END SECTION 3-->

        <!--SECTION 4-->

        @include('_partials/term_section',[
            'termIndex'=> 3,
            'termTitle'=>'SECCIÓN 4 - MODIFICACIONES AL SERVICIO Y PRECIOS',
            'termContent'=>'
                <p>
                    Los precios de nuestros productos están sujetos a cambio sin aviso.
                </p>
                <p>
                    Nos reservamos el derecho de modificar o discontinuar el Servicio (o
                    cualquier parte del contenido) en cualquier momento sin aviso previo.
                </p>
                <p>
                    No seremos responsables ante ti o alguna tercera parte por cualquier
                    modificación, cambio de precio, suspensión o discontinuidad del
                    Servicio.
                </p>'])


        <!--END SECTION 4-->

        <!--SECTION 5-->

        @include('_partials/term_section',[
            'termIndex'=> 4,
            'termTitle'=>'SECCIÓN 5 - PRODUCTOS O SERVICIOS (si aplicable)',
            'termContent'=>'
                <p>
                    Ciertos productos o servicios pueden estar disponibles exclusivamente
                    en línea a través del sitio web. Estos productos o servicios pueden
                    tener cantidades limitadas y estar sujetas a devolución o cambio de
                    acuerdo a nuestra política de devolución solamente.
                </p>
                <p>
                    Hemos hecho el esfuerzo de mostrar los colores y las imágenes de
                    nuestros productos, en la tienda, con la mayor precisión de colores
                    posible. No podemos garantizar que el monitor de tu computadora
                    muestre los colores de manera exacta.
                </p>
                <p>
                    Nos reservamos el derecho, pero no estamos obligados, para limitar las
                    ventas de nuestros productos o servicios a cualquier persona, región
                    geográfica o jurisdicción. Podemos ejercer este derecho basados en
                    cada caso. Nos reservamos el derecho de limitar las cantidades de los
                    productos o servicios que ofrecemos. Todas las descripciones de
                    productos o precios de los productos están sujetos a cambios en
                    cualquier momento sin previo aviso, a nuestra sola discreción. Nos
                    reservamos el derecho de discontinuar cualquier producto en cualquier
                    momento. Cualquier oferta de producto o servicio hecho en este sitio
                    es nulo donde esté prohibido.
                </p>'])

        <!--END SECTION 5-->

        <!--SECTION 6-->

        @include('_partials/term_section',[
            'termIndex'=> 5,
            'termTitle'=>'SECCIÓN 6 - EXACTITUD DE FACTURACIÓN E INFORMACIÓN DE CUENTA',
            'termContent'=>'
                <p>
                    Nos reservamos el derecho de rechazar cualquier pedido que realice con
                    nosotros. Podemos, a nuestra discreción, limitar o cancelar las
                    cantidades compradas por persona, por hogar o por pedido. Estas
                    restricciones pueden incluir pedidos realizados por o bajo la misma
                    cuenta de cliente, la misma tarjeta de crédito, y/o pedidos que
                    utilizan la misma facturación y/o dirección de envío.
                </p>
                <p>
                    En el caso de que hagamos un cambio o cancelemos una orden, podemos
                    intentar notificarte poniéndonos en contacto vía correo electrónico
                    y/o dirección de facturación / número de teléfono proporcionado en el
                    momento que se hizo pedido. Nos reservamos el derecho de limitar o
                    prohibir las órdenes que, a nuestro juicio, parecen ser colocado por
                    los concesionarios, revendedores o distribuidores.
                </p>
                <p>
                    Te comprometes a proporcionar información actual, completa y precisa
                    de la compra y cuenta utilizada para todas las compras realizadas en
                    nuestra tienda. Te comprometes a actualizar rápidamente tu cuenta y
                    otra información, incluyendo tu dirección de correo electrónico y
                    números de tarjetas de crédito y fechas de vencimiento, para que
                    podamos completar tus transacciones y contactarte cuando sea
                    necesario.
                </p>
                <p>
                    Para más detalles, por favor revisa nuestra Política de Devoluciones.
                </p>'])



        <!--END SECTION 6-->

        <!--SECTION 7-->

        @include('_partials/term_section',[
            'termIndex'=> 6,
            'termTitle'=>'SECCIÓN 7 - HERRAMIENTAS OPCIONALES',
            'termContent'=>'
            <p>
                Es posible que te proporcionemos acceso a herramientas de terceros a
                los cuales no monitoreamos y sobre los que no tenemos control ni
                entrada.
            </p>
            <p>
                Reconoces y aceptas que proporcionamos acceso a este tipo de
                herramientas "tal cual" y "según disponibilidad" sin garantías,
                representaciones o condiciones de ningún tipo y sin ningún respaldo.
                No tendremos responsabilidad alguna derivada de o relacionada con tu
                uso de herramientas proporcionadas por terceras partes.
            </p>
            <p>
                Cualquier uso que hagas de las herramientas opcionales que se ofrecen
                a través del sitio bajo tu propio riesgo y discreción y debes
                asegurarte de estar familiarizado y aprobar los términos bajo los
                cuales estas herramientas son proporcionadas por el o los proveedores
                de terceros.
            </p>
            <p>
                También es posible que, en el futuro, te ofrezcamos nuevos servicios
                y/o características a través del sitio web (incluyendo el lanzamiento
                de nuevas herramientas y recursos). Estas nuevas características y/o
                servicios también estarán sujetos a estos Términos de Servicio. Z
            </p>
                '])
        <!--END SECTION 7-->



        <!--SECTION 8-->


        @include('_partials/term_section',[
            'termIndex'=> 7,
            'termTitle'=>'SECCIÓN 8 - ENLACES DE TERCERAS PARTES',
            'termContent'=>'
            <p>
                Cierto contenido, productos y servicios disponibles vía nuestro
                Servicio puede incluir material de terceras partes.
            </p>
            <p>
                Enlaces de terceras partes en este sitio pueden direccionarte a sitios
                web de terceras partes que no están afiliadas con nosotros. No nos
                responsabilizamos de examinar o evaluar el contenido o exactitud y no
                garantizamos ni tendremos ninguna obligación o responsabilidad por
                cualquier material de terceros o sitios web, o de cualquier material,
                productos o servicios de terceros.
            </p>
            <p>
                No nos hacemos responsables de cualquier daño o daños relacionados con
                la adquisición o utilización de bienes, servicios, recursos,
                contenidos, o cualquier otra transacción realizadas en conexión con
                sitios web de terceros. Por favor revisa cuidadosamente las políticas
                y prácticas de terceros y asegúrate de entenderlas antes de participar
                en cualquier transacción. Quejas, reclamos, inquietudes o preguntas
                con respecto a productos de terceros deben ser dirigidas a la tercera
                parte.
            </p>
                '])

        <!--END SECTION 8-->

        <!--SECTION 9-->

        @include('_partials/term_section',[
            'termIndex'=> 8,
            'termTitle'=>'SECCIÓN 9 - COMENTARIOS DE USUARIO, CAPTACIÓN Y OTROS ENVÍOS',
            'termContent'=>'
            <p>
                Cierto contenido, productos y servicios disponibles vía nuestro
                Servicio puede incluir material de terceras partes.
            </p>
            <p>
                Enlaces de terceras partes en este sitio pueden direccionarte a sitios
                web de terceras partes que no están afiliadas con nosotros. No nos
                responsabilizamos de examinar o evaluar el contenido o exactitud y no
                garantizamos ni tendremos ninguna obligación o responsabilidad por
                cualquier material de terceros o sitios web, o de cualquier material,
                productos o servicios de terceros.
            </p>
            <p>
                No nos hacemos responsables de cualquier daño o daños relacionados con
                la adquisición o utilización de bienes, servicios, recursos,
                contenidos, o cualquier otra transacción realizadas en conexión con
                sitios web de terceros. Por favor revisa cuidadosamente las políticas
                y prácticas de terceros y asegúrate de entenderlas antes de participar
                en cualquier transacción. Quejas, reclamos, inquietudes o preguntas
                con respecto a productos de terceros deben ser dirigidas a la tercera
                parte.
            </p>
                '])

            @include('_partials/term_section',[
                'termIndex'=> 9,
                'termTitle'=>'SECCIÓN 10 - INFORMACIÓN PERSONAL',
                'termContent'=>'
                <p>
                    Tu presentación de información personal a través del sitio se rige por
                    nuestra Política de Privacidad. Para ver nuestra
                    <a href=""
                        >Política de Privacidad.</a
                    >
                </p>
                    '])

            @include('_partials/term_section',[
                'termIndex'=> 10,
                'termTitle'=>'SECCIÓN 11 - ERRORES, INEXACTITUDES Y OMISIONES',
                'termContent'=>'
                    <p>
                        De vez en cuando puede haber información en nuestro sitio o en el
                        Servicio que contiene errores tipográficos, inexactitudes u omisiones
                        que puedan estar relacionadas con las descripciones de productos,
                        precios, promociones, ofertas, gastos del producto o servicio, el
                        tiempo de tránsito y la disponibilidad. Nos reservamos el derecho de
                        corregir los errores, inexactitudes u omisiones y de cambiar o
                        actualizar la información o cancelar pedidos si alguna información en
                        el Servicio o en cualquier sitio web relacionado es inexacta en
                        cualquier momento sin previo aviso (incluso después de que hayas
                        enviado tu orden) .
                    </p>
                    <p>
                        No asumimos ninguna obligación de actualizar, corregir o aclarar la
                        información en el Servicio o en cualquier sitio web relacionado,
                        incluyendo, sin limitación, la información de precios, excepto cuando
                        sea requerido por la ley. Ninguna especificación actualizada o fecha
                        de actualización aplicada en el Servicio o en cualquier sitio web
                        relacionado, debe ser tomada para indicar que toda la información en
                        el Servicio o en cualquier sitio web relacionado ha sido modificado o
                        actualizado.
                    </p>
                    '])

        <!--END SECTION 11-->

        <!--SECTION 12-->

            @include('_partials/term_section',[
                    'termIndex'=> 11,
                    'termTitle'=>'SECCIÓN 12 - USOS PROHIBIDOS',
                    'termContent'=>'
                    <p>
                        En adición a otras prohibiciones como se establece en los Términos de
                        Servicio, se prohibe el uso del sitio o su contenido: (a) para ningún
                        propósito ilegal; (b) para pedirle a otros que realicen o participen
                        en actos ilícitos; (c) para violar cualquier regulación, reglas, leyes
                        internacionales, federales, provinciales o estatales, u ordenanzas
                        locales; (d) para infringir o violar el derecho de propiedad
                        intelectual nuestro o de terceras partes; (e) para acosar, abusar,
                        insultar, dañar, difamar, calumniar, desprestigiar, intimidar o
                        discriminar por razones de género, orientación sexual, religión,
                        etnia, raza, edad, nacionalidad o discapacidad; (f) para presentar
                        información falsa o engañosa; (g) para cargar o transmitir virus o
                        cualquier otro tipo de código malicioso que sea o pueda ser utilizado
                        en cualquier forma que pueda comprometer la funcionalidad o el
                        funcionamiento del Servicio o de cualquier sitio web relacionado,
                        otros sitios o Internet; (h) para recopilar o rastrear información
                        personal de otros; (i) para generar spam, phish, pharm, pretext,
                        spider, crawl, or scrape; (j) para cualquier propósito obsceno o
                        inmoral; o (k) para interferir con o burlar los elementos de seguridad
                        del Servicio o cualquier sitio web relacionado¿ otros sitios o
                        Internet. Nos reservamos el derecho de suspender el uso del Servicio o
                        de cualquier sitio web relacionado por violar cualquiera de los ítems
                        de los usos prohibidos.
                    </p>
                        '])

        <!--END SECTION 12-->

        <!--SECTION 13-->


        @include('_partials/term_section',[
            'termIndex'=> 12,
            'termTitle'=>'SECCIÓN 13 - EXCLUSIÓN DE GARANTÍAS; LIMITACIÓN DE RESPONSABILIDAD',
            'termContent'=>'
            <p>
                En adición a otras prohibiciones como se establece en los Términos de
                Servicio, se prohibe el uso del sitio o su contenido: (a) para ningún
                propósito ilegal; (b) para pedirle a otros que realicen o participen
                en actos ilícitos; (c) para violar cualquier regulación, reglas, leyes
                internacionales, federales, provinciales o estatales, u ordenanzas
                locales; (d) para infringir o violar el derecho de propiedad
                intelectual nuestro o de terceras partes; (e) para acosar, abusar,
                insultar, dañar, difamar, calumniar, desprestigiar, intimidar o
                discriminar por razones de género, orientación sexual, religión,
                etnia, raza, edad, nacionalidad o discapacidad; (f) para presentar
                información falsa o engañosa; (g) para cargar o transmitir virus o
                cualquier otro tipo de código malicioso que sea o pueda ser utilizado
                en cualquier forma que pueda comprometer la funcionalidad o el
                funcionamiento del Servicio o de cualquier sitio web relacionado,
                otros sitios o Internet; (h) para recopilar o rastrear información
                personal de otros; (i) para generar spam, phish, pharm, pretext,
                spider, crawl, or scrape; (j) para cualquier propósito obsceno o
                inmoral; o (k) para interferir con o burlar los elementos de seguridad
                del Servicio o cualquier sitio web relacionado¿ otros sitios o
                Internet. Nos reservamos el derecho de suspender el uso del Servicio o
                de cualquier sitio web relacionado por violar cualquiera de los ítems
                de los usos prohibidos.
            </p>
                '])

        <!-- END SECTION 13 -->


        <!-- SECTION 14 -->

        @include('_partials/term_section',[
            'termIndex'=> 13,
            'termTitle'=>'SECCIÓN 14 - INDEMNIZACIÓN',
            'termContent'=>'
                <p>
                    Aceptas indemnizar, defender y mantener indemne TURISMO MÉDICO
                    DIGITAL, S.A.P.I. DE C.V. y nuestras matrices, subsidiarias,
                    afiliados, socios, funcionarios, directores, agentes, contratistas,
                    concesionarios, proveedores de servicios, subcontratistas,
                    proveedores, internos y empleados, de cualquier reclamo o demanda,
                    incluyendo honorarios razonables de abogados, hechos por cualquier
                    tercero a causa o como resultado de tu incumplimiento de las
                    Condiciones de Servicio o de los documentos que incorporan como
                    referencia, o la violación de cualquier ley o de los derechos de u
                    tercero.
                </p>
                '])

        <!-- END SECTION 14 -->


        <!--SECTION 15-->

        @include('_partials/term_section',[
            'termIndex'=> 14,
            'termTitle'=>'SECCIÓN 15 - DIVISIBILIDAD',
            'termContent'=>'
                <p>
                    En el caso de que se determine que cualquier disposición de estas
                    Condiciones de Servicio sea ilegal, nula o inejecutable, dicha
                    disposición será, no obstante, efectiva a obtener la máxima medida
                    permitida por la ley aplicable, y la parte no exigible se considerará
                    separada de estos Términos de Servicio, dicha determinación no
                    afectará la validez de aplicabilidad de las demás disposiciones
                    restantes.
                </p>
                '])

        <!--END SECTION 15-->

        <!--SECTION 16-->

        @include('_partials/term_section',[
            'termIndex'=> 15,
            'termTitle'=>'SECCIÓN 16 - RESCISIÓN ',
            'termContent'=>'
                    <p>
                        Las obligaciones y responsabilidades de las partes que hayan incurrido
                        con anterioridad a la fecha de terminación sobrevivirán a la
                        terminación de este acuerdo a todos los efectos.
                    </p>
                    <p>
                        Estas Condiciones de servicio son efectivos a menos que y hasta que
                        sea terminado por ti o nosotros. Puedes terminar estos Términos de
                        Servicio en cualquier momento por avisarnos que ya no deseas utilizar
                        nuestros servicios, o cuando dejes de usar nuestro sitio.
                    </p>
                    <p>
                        Si a nuestro juicio, fallas, o se sospecha que haz fallado, en el
                        cumplimiento de cualquier término o disposición de estas Condiciones
                        de Servicio, también podemos terminar este acuerdo en cualquier
                        momento sin previo aviso, y seguirás siendo responsable de todos los
                        montos adeudados hasta incluida la fecha de terminación; y/o en
                        consecuencia podemos negarte el acceso a nuestros servicios (o
                        cualquier parte del mismo).
                    </p>
                '])

        <!--END SECTION 16-->

        <!--SECTION 17-->

        @include('_partials/term_section',[
            'termIndex'=> 16,
            'termTitle'=>'SECCIÓN 17 - ACUERDO COMPLETO ',
            'termContent'=>'
                <p>
                    Nuestra falla para ejercer o hacer valer cualquier derecho o
                    disposición de estas Condiciones de Servicio no constituirá una
                    renuncia a tal derecho o disposición.
                </p>
                <p>
                    Estas Condiciones del servicio y las políticas o reglas de operación
                    publicadas por nosotros en este sitio o con respecto al servicio
                    constituyen el acuerdo completo y el entendimiento entre tu y nosotros
                    y rigen el uso del Servicio y reemplaza cualquier acuerdo,
                    comunicaciones y propuestas anteriores o contemporáneas, ya sea oral o
                    escrita, entre tu y nosotros (incluyendo, pero no limitado a,
                    cualquier versión previa de los Términos de Servicio).
                </p>
                <p>
                    Cualquier ambigüedad en la interpretación de estas Condiciones del
                    servicio no se interpretarán en contra del grupo de redacción.
                </p>
                '])

        <!--END SECTION 17-->

        <!--SECTION 18-->
        @include('_partials/term_section',[
            'termIndex'=> 17,
            'termTitle'=>'SECCIÓN 18 - POLÍTICA DE CANCELACIÓN',
            'termContent'=>'
                <p>
                    Cualquier cambio o cancelación a su reservación deberá solicitarla al
                    siguiente correo electrónico babypassportc@medicalmeeting.co con
                    anticipación mínima de 120 horas antes de la fecha programada,
                    proporcionando su (s) clave (s) de confirmación o nombre de paciente.
                </p>
                <p>
                    Para las reservas realizadas el mismo día aplicarán cancelaciones, por
                    lo que no se hará el cargo alguno correspondiente al cobro
                    proporcional o completo por el servicio.
                </p>
                <p>
                    Independientemente, de no realizarse la cancelación en el tiempo y
                    forma antes mencionada, o en caso de no presentarse en la fecha
                    programada, se hará el cargo del 30% sobre el total del servicio.
                </p>
                <p>
                    Toda reserva deberá ser garantizada mediante tarjeta de crédito a
                    nombre de la paciente o familiar, o depósito por una cantidad igual al
                    monto total a pagar por el servicio.
                </p>
                <p>
                    TURISMO MÉDICO DIGITAL, S.A.P.I. DE C.V. realizará una
                    pre-verificación con el banco emisor de la tarjeta de crédito o débito
                    24 horas después de agendar el servicio. En caso de no ser aprobada
                    dicha pre-verificación, la reservación se considerara como No
                    garantizada y TURISMO MÉDICO DIGITAL, S.A.P.I. DE C.V. no estará
                    obligado a respetar la estancia de la misma.
                </p>
                <p>
                    En caso de no realizarse el pago al momento solicitado y al no recibir
                    respuesta alguna por parte del solicitante del servicio o que no
                    cumpla con lo que establece el punto anterior, será interpretado como
                    una falta de presentación del paciente y dará lugar al cargo del 30%
                    sobre el total del servicio.
                </p>
                '])

        <!--END SECTION 18-->

        <!--SECTION 19-->

        @include('_partials/term_section',[
            'termIndex'=> 18,
            'termTitle'=>'SECCIÓN 19 - LEY',
            'termContent'=>'
                    <p>
                        Estas Condiciones del servicio y cualquier acuerdos aparte en el que
                        te proporcionemos servicios se regirán e interpretarán en conformidad
                        con las leyes de los Estados Unidos Mexicanos.
                    </p>
                '])

        <!--END SECTION 19-->

        <!--SECTION 20-->
        @include('_partials/term_section',[
            'termIndex'=> 19,
            'termTitle'=>'SECCIÓN 20 - CAMBIOS EN LOS TÉRMINOS DE SERVICIO',
            'termContent'=>'
                <p>
                    Puedes revisar la versión más actualizada de los Términos de Servicio
                    en cualquier momento en esta página.
                </p>
                <p>
                    Nos reservamos el derecho, a nuestra sola discreción, de actualizar,
                    modificar o reemplazar cualquier parte de estas Condiciones del
                    servicio mediante la publicación de las actualizaciones y los cambios
                    en nuestro sitio web. Es tu responsabilidad revisar nuestro sitio web
                    periódicamente para verificar los cambios. El uso contínuo de o el
                    acceso a nuestro sitio Web o el Servicio después de la publicación de
                    cualquier cambio en estas Condiciones de servicio implica la
                    aceptación de dichos cambios.
                </p>
                '])

        <!--END SECTION 20-->

        <!--SECTION 21-->
        @include('_partials/term_section',[
            'termIndex'=> 20,
            'termTitle'=>'SECCIÓN 21 - INFORMACIÓN DE CONTACTO',
            'termContent'=>'
                    <p>
                    Para cualquier duda o aclaración puedes comunicarte vía correo
                    electrónico a la siguiente dirección babypassportc@medicalmeeting.co
                </p>
                '])

        <!--END SECTION 2-->
      </div>

  </div>
</section>




@endsection


@section('footer')
    @include('_partials/footer',["background"=>"bg-ce-soir","button"=>"btn-mandys-pink"])
@endsection
