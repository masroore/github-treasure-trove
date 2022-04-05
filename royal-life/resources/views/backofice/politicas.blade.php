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
                    <h3 class="text-white ml-4" style="font-size: 50px;"><strong> Politicas y privacidad </strong></h3>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container fuente pt-5">
    <div class="row">

    </div>
    <img class="ml-1 image mr-3" src="{{asset('assets/img/home/policity1.png')}}" style="width: 35%;">
    <h4 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong> Política de Privacidad </strong> </h4>
    <p class="ml-3 mr-3 text-dark mt-1 fuente">
        Con el fin de proporcionar un espacio online seguro que garantice la protección de datos, cumplimos rigurosamente todos los requisitos
        legales. En esta declaración de privacidad ofrecemos información sobre la forma y la finalidad de nuestra obtención de datos, las medidas
        de seguridad, los periodos de retención y la información de contacto.
    </p>
    <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong> SECCIÓN 1 - QUÉ INFORMACIÓN PERSONAL RECOPILAMOS</strong> </h5>
        <h6 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong> 1.1 Cuenta</strong> </h6>
            <p class="ml-3 mr-3 text-dark mt-1 fuente">
            Únicamente se pueden realizar compras a través de una cuenta personal. Cuando creas una cuenta o adquieres un producto de nuestra
            tienda, como parte del proceso de compraventa, recopilamos la siguiente información:<br>
            • Nombre y apellidos<br>
            • Domicilio y dirección de facturación<br>
            • Número de teléfono<br>
            • Sexo<br>
            • Dirección IP<br>
            • Dirección de correo electrónico<br>
            • Fecha de nacimiento<br>
            Esta información es necesaria para poder efectuar la entrega. Además, cuando navegas por nuestra tienda, recibimos la dirección IP
            de tu ordenador de forma automática. Basándonos en estos datos, podemos optimizar tu experiencia online y proteger nuestro espacio
            online de forma simultánea.
            </p>
            <h6 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>Finalidad de la recopilación de datos</strong> </h6>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
            Recopilamos y almacenamos información relacionada con tu cuenta con los siguientes fines:<br>
            a. Cumplir con las obligaciones derivadas de cualquier contrato entre tú y nosotros, y facilitarte la información, productos y servicios que
            solicites de nuestra parte;<br>

            b. Configurar, administrar y ponernos en contacto contigo en relación a tu cuenta y pedidos;<br>
            c. Llevar a cabo investigaciones y análisis de mercado;<br>
            d. Confirmar tu edad e identidad, y detectar y prevenir el fraude. <br>
                </p>
                <h6 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>1.2 Newsletters</strong> </h6>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
            En ocasiones podemos enviarte boletines informativos sobre nuestra tienda, productos nuevos, y otras actualizaciones. Únicamente enviamos
            newsletters en función de un consentimiento expreso. Recopilamos la siguiente información en relación a los boletines informativos:<br>
             • Nombre y apellidos<br>
             • Sexo<br>
             • Dirección de correo electrónico<br>
                </p>
          <h6 class="ml-3 mr-3 text-dark mt-1 fuente">  <strong> Finalidad de la recopilación de datos</strong> <h6>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
                Los datos recopilados se utilizan para:
                a. personalizar nuestros emails, incluyendo tu nombre y sexo para poder proporcionarte un contenido adaptado a tu género;
                Podrás retirar tu consentimiento en cualquier momento a través del enlace proporcionado en el boletín de noticias o la
                información de contacto de la sección 2.
                </p>
                <h6 class="ml-3 mr-3 text-dark mt-1 fuente">  <strong> 1.3 Servicio de atención al cliente</strong> <h6>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
                 Para poder ofrecerte una asistencia adecuada, nuestro personal del servicio de atención al cliente tiene acceso a la
                 información relacionada con tu cuenta. Por lo tanto, su ayuda será sumamente grata y eficaz.
                </p>
                <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong> SECCIÓN 2 - CONSENTIMIENTO </strong> </h5>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
                 l proporcionarnos tus datos personales para llevar a cabo una transacción, verificar tu tarjeta de crédito, realizar un
                 pedido, organizar un envío, o devolver una compra, nos facilitas tu consentimiento para recopilar dicha información y utilizarla únicamente con esos fines.
                 Si necesitamos más datos personales por otra razón, como motivos publicitarios, pediremos tu consentimiento expreso o te ofreceremos la opción de negarte.
                </p>
                <h6 class="ml-3 mr-3 text-dark mt-1 fuente">  <strong>2.1 Cómo retirar el consentimiento</strong> <h6>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
                Si cambias de opinión, podrás retirar tu consentimiento para que contactemos contigo con el fin de recopilar, usar y divulgar
                tus datos, en cualquier momento, poniéndote en contacto con nosotros a través de <a href="#">soporte@royallife.company</a>
                </p>
                <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>SECCIÓN 3 - DIVULGACIÓN DE DATOS</strong> </h5>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
                Podemos divulgar tu información personal si nos vemos obligados a hacerlo por ley o en el caso de que infrinjas nuestros
                Términos de servicio.
                </p>
                <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>SECCIÓN 4 - ¿CUÁNTO TIEMPO CONSERVAMOS TUS DATOS?</strong> </h5>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
                 Para Royal Life es de suma importancia el almacenamiento de una cantidad de información mínima. Por lo tanto, no conservaremos
                 tus datos más tiempo del necesario para conseguir los fines establecidos en esta Política de Privacidad. Para diferentes tipos
                 de datos se aplican plazos de retención distintos, pero el período de tiempo más largo que solemos conservar cualquier información
                 personal es de 10 años.
                </p>
                <h6 class="ml-3 mr-3 text-dark mt-1 fuente">  <strong>4.1 Información de la cuenta</strong> <h6>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
                Los datos relacionados con una cuenta seguirán vigentes mientras el consumidor esté en posesión de ella. Por lo tanto, esta
                información continuará estando documentada durante la existencia de dicha cuenta. Cuando nuestros clientes eliminan una cuenta,
                los datos relacionados con ella se borran en un plazo de tiempo razonable. Todas las solicitudes relacionadas con la inspección
                o corrección de datos personales almacenados y la eliminación de una cuenta, deberán enviarse a <a href="#">soporte@royallife.company</a>
                </p>
                <h6 class="ml-3 mr-3 text-dark mt-1 fuente">  <strong>4.2 Newsletters </strong> <h6>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
               El consentimiento relativo a los boletines informativos y a los datos asociados con ellos, seguirá estando vigente mientras los
               clientes estén registrados para recibir dichos emails. No obstante, llevamos a cabo comprobaciones periódicas. Los clientes
                registrados (y su información personal) serán eliminados cuando no respondan a nuestras peticiones. Además, nuestro boletín
                ofrece una función de baja voluntaria. Los consumidores podrán retirar su consentimiento a través de esta función.
                </p>
                <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>SECCIÓN 5 - COOKIES</strong> </h5>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
                Las cookies son unos pequeños fragmentos de información que notifican a tu ordenador las interacciones anteriores con
                nuestra página web. Estas cookies se almacenan en tu disco duro, y no en nuestra web. Cuando utilizas nuestra página web,
                tu ordenador nos muestra tus cookies e informa a nuestro sitio de que ya lo has visitado antes. Esto permite que nuestra
                web funcione de forma más rápida y que recuerde ciertos aspectos relacionados con tus visitas anteriores (por ejemplo,
                tu nombre de usuario), para que su uso te resulte mucho más cómodo. En Royal Life, utilizamos dos tipos de
                cookies: funcionales y analíticas.
                </p>
                <h6 class="ml-3 mr-3 text-dark mt-1 fuente">  <strong>5.1 Cookies funcionales</strong> <h6>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
                 Las cookies funcionales se utilizan para mejorar tu experiencia online. Entre otras cosas, estas cookies realizan un
                 seguimiento de lo que se añade al carrito de la compra. Para usar estas cookies no se necesita autorización previa.
                </p>
                <h6 class="ml-3 mr-3 text-dark mt-1 fuente">  <strong>5.2 Cookies analíticas</strong> <h6>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
                Las cookies analíticas se utilizan para llevar a cabo investigaciones y análisis de mercado. La información recopilada
                con las cookies analíticas es anónima y, por lo tanto, inservible para terceros. Para usar estas cookies no se necesita
                autorización previa.
                </p>
                <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>SECCIÓN 6 - SERVICIOS DE TERCEROS</strong> </h5>
                 <br><img class="image" src="{{asset('assets/img/home/terms2.png')}}" style="width: 25%;">
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
                Los servicios proporcionados por terceros son necesarios para poder llevar a cabo transacciones y ofrecer nuestros servicios. En general, los proveedores indirectos que utilizamos solo recopilan, usan y divulgan tu información en la medida de lo necesario para llevar a cabo los servicios que proporcionan.
                Sin embargo, algunos de estos proveedores, como las pasarelas de pagos online y otros procesadores de pagos, tienen sus propias políticas de privacidad con respecto a la información que debemos proporcionarles para llevar a cabo transacciones relacionadas con tus compras.<br>
                Te recomendamos que leas sus políticas de privacidad para entender mejor la forma en que estos proveedores manejan tus datos personales.<br>
                Ciertos proveedores podrían estar ubicados o disponer de instalaciones situadas en una jurisdicción distinta a la tuya y a la nuestra. Por lo tanto, si decides continuar con una transacción que implique los servicios de un tercero, tu información podría estar sujeta a las leyes de la jurisdicción en la que se encuentre dicho proveedor o su sede.
                Cuando abandonas la tienda de nuestra web, o se te redirige a una página o aplicación de terceros, dejas de regirte por esta Política de privacidad y los Términos de servicio de nuestra web.
                </p>
                <h6 class="ml-3 mr-3 text-dark mt-1 fuente">  <strong>Servicio de análisis web (datos anonimizados)</strong> <h6>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
                    En esta página web, hemos integrado un servicio de análisis web (con la función anonimizadora). El análisis web puede definirse
                    como la recopilación, la reunión y el análisis de datos relacionados con el comportamiento de las personas que visitan una página
                     web. Un servicio de análisis web recopila, entre otras cosas, información sobre el sitio web desde el que llega una persona
                      (llamado referer), qué subpáginas ha visitado, y con qué frecuencia y durante cuánto tiempo. La analítica web se utiliza princ
                      ipalmente para la optimización de una página web y para llevar a cabo un análisis de costes y beneficios de la publicidad online.
                </p>
                <h6 class="ml-3 mr-3 text-dark mt-1 fuente">  <strong>Servicio de mensajería</strong> <h6>
                <p class="ml-3 mr-3 text-dark mt-1 fuente">
                    Para efectuar nuestros envíos utilizamos un servicio de mensajería. Este servicio realiza los envíos entre nuestra empresa y la dirección
                     del consumidor. Para completar esta función logística, nuestra empresa necesita saber el nombre y la dirección del consumidor.
                </p>
                <h6 class="ml-3 mr-3 text-dark mt-1 fuente">  <strong>Servicio de mailing</strong> <h6>
                    <p class="ml-3 mr-3 text-dark mt-1 fuente">
                        Para enviar nuestro boletín de noticias utilizamos un proveedor de servicios de mailing externo. Este proveedor
                         tiene acceso limitado a la información relacionada con el consentimiento del alta en este servicio
                          (p. ej. dirección de correo electrónico).
                    </p>
                    <h6 class="ml-3 mr-3 text-dark mt-1 fuente">  <strong>Servicio de marketing</strong> <h6>
                        <p class="ml-3 mr-3 text-dark mt-1 fuente">
                            Royal Life cuenta con el apoyo de una empresa especializada en actividades de marketing y de comunicación. Su acceso
                            a tu información personal es muy limitado y, en su mayor parte, anonimizado.
                        </p>
                        <h6 class="ml-3 mr-3 text-dark mt-1 fuente">  <strong>Servicios de pago</strong> <h6>
                            <p class="ml-3 mr-3 text-dark mt-1 fuente">
                                Utilizamos servicios de pago externos para completar las transacciones comerciales
                                (p. ej. pagos con tarjeta de crédito).
                            </p>
                            <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>SECCIÓN 7 - SEGURIDAD</strong> </h5>
                            <p class="ml-3 mr-3 text-dark mt-1 fuente">
                                <img class="image" src="{{asset('assets/img/home/security.png')}}" style="width: 40%;">

                                Con el fin de proteger tu información personal, tomamos las precauciones necesarias y adoptamos las mejores
                                prácticas del sector, para garantizar que no se pierda, abuse, acceda, divulgue, modifique o destruya.<br>

                                Cuando nos proporcionas los datos de tu tarjeta de crédito, esta información se encripta mediante la tecnología
                                de capa de conexión segura (SSL) y se almacena con una clave de cifrado AES-256. Aunque ningún método de transmisión
                                online ni almacenamiento electrónico es 100% seguro, cumplimos con todos los requisitos PCI-DSS e implementamos
                                 estándares adicionales aceptados generalmente por la industria. Toda información relacionada con tu cuenta está
                                 protegida por el método hashing, que la transforma en un código hash y, como resultado, es invisible incluso para
                                 nosotros. Además, nuestras bases de datos se protegen contra personas no autorizadas, y su acceso es solo posible
                                 por parte de direcciones IP aprobadas (p. ej., en la sede de Life). Otros intentos de acceso se rechazan en todo momento.<br>
                                Asimismo, la información se anonimiza todo lo posible, por lo que no se podrá vincular a un consumidor en concreto.
                                Sin embargo, con estos datos podemos llevar a cabo investigaciones y análisis de mercado. Además, las terceras partes
                                interesadas (como el servicio de mailing) son investigadas previamente a la colaboración, cumplen con el GDPR, y operan
                                 según un acuerdo de procesamiento de datos. A los empleados de Royal Life se les asignan distintos permisos de acceso.
                                  Estos permisos solo proporcionan acceso a la información estrictamente necesaria para realizar una tarea.<br>
                                Las medidas de seguridad digital están sujetas a cambios y deben cumplir unos estrictos requisitos que
                                garanticen la seguridad de los clientes online. Por eso, nombramos a un responsable de seguridad cuya función
                                consiste, en parte, en hacer comprobaciones de forma periódica y mejorar las medidas de seguridad
                                 (cuando sea necesario).
                            </p>
                            <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>SECCIÓN 8 - CAMBIOS DE LA POLÍTICA DE PRIVACIDAD</strong> </h5>
                            <p class="ml-3 mr-3 text-dark mt-1 fuente">
                                Nos reservamos el derecho a modificar esta Política de Privacidad en cualquier momento, por lo que te aconsejamos que
                                la revises con frecuencia. Cualquier cambio o actualización entrará en vigor inmediatamente después de su publicación
                                en la página web. Cuando efectuemos cambios materiales en esta política, te lo notificaremos aquí para que estés al tanto
                                 de qué tipo de información recopilamos, cómo la usamos, y bajo qué circunstancias, si las hubiese, la utilizamos y/o divulgamos
                            </p>
                            <h5 class="ml-3 mr-3 text-dark mt-1 fuente"> <strong>SECCIÓN 9 - INFORMACIÓN DE CONTACTO</strong> </h5>
                            <p class="ml-3 mr-3 text-dark mt-1 fuente">
                                Ponte en contacto con nosotros:
                                • De forma electrónica enviando un email a:  <a href="#">soporte@royallife.company</a>
                            </p>
                <div class="text-center">
                    <img class="text-center" src="{{asset('assets/img/home/policity.png')}}" style="width: 30%;">
                </div>
</div>





@endsection
