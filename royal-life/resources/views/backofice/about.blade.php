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


<div class="fondo3 fondo0">
    <div class="container"  >
        <div class="row">
            <div class="col-sm-12 mt-5 mb-5">
                <h1 class="text-white"  style="font-size: 50px;"><strong> ¿Quienes sómos?</strong> </h1>
                <a class="text-white" href="{{route('inicio.index')}}"><strong> Inicio </strong></a><strong class="ml-1">
                    > </strong>
                <a style="color: #52CCA7" class="ml-1"><strong> Nosotros </strong></a>

            </div>
        </div>
    </div>
    </div>
@include('backofice.ui.estylos')
@include('backofice.ui.estylosHome')

<div class="row fondo fondo2 ">

    <div class="container ">
       <div class="row     mb-5" >
         <div class="ml-1 col-sm head mb-5">
           <h1 class="fs-1  mt-5  "><strong> ¿QUIENES SOMOS? </strong> </h1>

               <p class="text-dark mt-2 mb-3 font2"> Una vida en abundancia económica es importante, pero una vida saludable es el equilibrio perfecto, y entendiendo esto nace Royal Life, después de muchos análisis estamos seguros que
                El CBD tiene el potencial de fortalecer, mejorar y contribuir a tu día a día,  y es allí donde entramos nosotros!!  cuyo objetivo es aportar al equilibrio de tu vida, cualquiera que sea tu reto de vida estamos
                Seguros que podemos ayudar a mejorarlo.
                Gracias a nuestro amplio portafolio de productos, podrás encontrar la combinación perfecta, para ello nos hemos aliado con los mejores laboratorios en los Estados Unidos que gracias a sus investigaciones
                Hoy te entregamos la mejor del mercado, productos excepcionales, los mejores procesos y la mas alta pureza.</p>

         </div>
         <div class="col-sm ">
           <img src="{{asset('assets/img/home/Polygon5Forma.png')}}" class=" img-fluid no mt-5 mb-5"  style="max-width: 100%;  min-width: 20%;">
         </div>
       </div>
     </div>
</div>
    <div class="container fuente">
        <div class="row">
          <div class="col-sm text-dark mt-5 mb-5">
            <br>
            <br>
                    <h1 class="font1"><strong> ROYAL LIFE EL EQUILIBRIO PERFECTO </strong> </h1>
                    <br>
                    Cada proceso de nuestros productos son cuidadosamente vigilados por expertos, nuestros laboratorios aliados garantizan el CBD mas puro del mercado y nuestra linea de productos lo demuestra.
                    Nuestra principal misión es mejorar tu calidad de vida, por eso queremos sorprenderte no una sola ves, si no todos los días!!
                    LO QUE NECESITAS SABER PARA INICIAR CON NOSOTROS.<br>
                    <br>
                    <br>
                    <br>
                    <br>

                    <h1  class="font1"><strong> Entonces, QUE ES EL CBD?</strong> </h1>
                    <br>
                    El CBD (cannabidiol) pertenece a una familia de compuestos llamados cannabinoides. Son únicos porque existen fuera del cuerpo y, cuando se consumen, pueden influir sobre una amplia red de receptores.
                    Asi que el  CBD es uno de los dos componentes cannabinoides más importantes de la planta de cannabis, que se encuentra en proporciones variables dependiendo de la cepa,
                    cuando el ser humano consume CBD y otros cannabinoides, sucede algo realmente extraordinario. Los cannabinoides interactúan con una extensa red de receptores que existe en todos nosotros. El alcance total de esta interacción sigue siendo objeto de investigación, pero podría afectar positivamente  el sueño, el apetito, el animo, etc.
                    Afortunadamente, el CBD no solo interactúa con nuestro cuerpo de diversas formas, sino que además se tolera bien y no es tóxico. Esta combinación beneficiosa ha despertado mucho interés.
                </div>
            </div>
          </div>
          <div class="pb-5 pl-5 pr-5 no" style="background:#F0FFFA;">
                    <div class="container fuente">
                        <div class="row">
                          <div class="col-sm text-dark mt-5 mb-5">
                    <h1  class="font1"><strong> DE DONDE VIENE EL CBD?</strong> </h1>
                    <br>
                    El CBD se encuentra en todos los tipos de cannabis sativa, pero el Cañamo es el que tiene las concentraciones mas altas.
                    La relación entre la Humanidad y el cannabis comenzó hace miles de años. Esta larga historia nació en el Neolítico, cuando los humanos empezaron a practicar la agricultura y asentarse en poblados donde cultivaban esta planta por sus propiedades terapéuticas. Siendo originario de Asia central, el cannabis fue expandiéndose, primero, hacia China, donde la evidencia arqueológica muestra la quema de cogollos hace 2.500 años; para después viajar hacia Europa, hoy en dia se sigue cultivando esta planta de forma selectiva con propiedad comerciales, convirtiéndose en una fuente natural y rica en CBD.
                    como Lo dijimos anteriormente, el CBD es parte de una amplia familia de cannabionoides. Aunque la mayoría de estos compuestos (incluyendo el CBD) no son psicoactivos, todas las familias tienen un miembro no deseado.
                    La familia de los cannabinoides también incluye el THC, el compuesto ilegal que está presente en las plantaciones de marihuana.
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <h1  class="font1"><strong> EL CBD ES LO MISMO QUE EL THC?</strong></h1>
                    <br>
                    Quizás sientas algún temor por que escuchaste primero el THC que el CBD, Y usualmente solemos pensar que es lo mismo.
                    La principal diferencia entre el THC y el CBD es que el THC (tetrahidrocannabinol) es ilegal en gran parte del mundo ya que es derivado de la marihuana otra especie de cannabis sativa, pero lo primordial es
                    Que este tiene efectos psicotropicos. ( hace que te drogues o eleves).
                    Podrá parecer muy sencilla la diferencia que en la molécula química del THC y CBD existe, pero esta es suficiente para que el efecto del CBD no afecte de manera psicotropica el cuerpo, como resultado final
                    El CBD no es TOXICO,NO DROGA y según la organización mundial de la salud (OMS) no causa adiccion ni tiene potencial al ABUSO.
                </div>
            </div>
          </div>
        </div>
          <div class="container fuente">
            <div class="row">
              <div class="col-sm text-dark mt-5 mb-5">
                    <h1  class="font1"><strong>EL CBD ME DROGA?</strong></h1>
                    <br>
                    La Respuesta rapida es: NO.<br>
                    Sin importar la cantidad que consumas, el CBD por sí solo no produce un EFECTO SUBIDON, ya que químicamente es imposible. Pero eso no significa que este compuesto no influya en cómo pensamos y nos sentimos. Las propiedades del CBD indican que puede mejorar los altibajos de la vida moderna, apoyando al cuerpo a conservar ese estado de equilibrio tan importante.
                    Siempre que compres tus productos de CBD de un productor de confianza (Royal Life), no tendrás que preocuparte de que el THC vaya a dañar tu experiencia de bienestar a base de cannabinoides. Relájate y Tómate tu tiempo, acostúmbrate a sus efectos positivos, y deja que este cannabinoide natural contribuya a  tu bienestar cuando más lo requieras.
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <h1  class="font1"><strong> EN QUE ME AYUDA EL CBD?</strong></h1>
                    <br>
                    El cannabidiol (CBD) se ha convertido en el compuesto cannabinoide no psicotrópico más prometedor de los últimos años debido a su diverso potencial en la medicina y en lo terapéutico.
                    Propiedades terapéuticas del CBD<br>
                    Las propiedades terapéuticas más importantes del CBD, demostradas con distinta calidad de evidencia son:<br>
                    <br>
                    <li>antiinflamatorio</li>
                    <li>analgésico</li>
                    <li>neuroprotector</li>
                    <li>anticonvulsivante</li>
                    <li>antioxidante</li>
                    <li>anti-náusea y antiemético</li>
                    <li>antitumoral</li>
                    <li>ansiolítico</li>
                    <li>antipsicótico</li>
                    <li>reductor de la apetencia por heroína, cocaína y alcohol</li>
                    <li>inmuno-modulador</li><br>
                    <br>
                    <br>
                    <h2><strong> Estas propiedades hacen que el CBD se utilice en el tratamiento de múltiples enfermedades, algunas de las cuales son:</strong> </h2>
                    <li>epilepsia</li>
                    <li>enfermedades neurodegenerativas (por ejemplo, Alzheimer, Parkinson y Esclerosis Múltiple)</li>
                    <li>dependencias químicas</li>
                    <li>ansiedad</li>
                    <li>psicosis</li>
                    <li>trastorno de espectro autista</li>
                    <li> enfermedades inflamatorias crónicas como la poliartritis crónica, enfermedad de Crohn, enfermedad inflamatoria intestinal,</li>
                    <li>acompañamiento de la quimioterapia</li>
                    <li>tratamiento antitumoral</li>
                    <li>Depresión</li>
                    <li>Insomnio</li>
                    <li>Stres oxidativo</li>
                    <li>Disminución del apetito</li>
                    <li>Diabetes</li>
                    <li>Artritis reumatoide</li><br>
                    <h5><strong> Entre muchas otras, en algunos países más allá de sus usos terapéuticos también es recomendable usar CBD como suplemento alimentario.</strong> </li>
          </div>
        </div>
      </div>

      <div class="pb-5 pl-5 pr-5 no" style="background:#F0FFFA;">
        <h1 class="texto-title mb-4 text-center"><strong> ¿Porqué elergirnos? </strong></h1>

        <div class="container">

        <div class="row  justify-content-center text-center col-sm">
            <div class="card mb-1 cas-md-3 col-sm-3  ml-md-4" style="width: 18rem; background: white;">
                <img class="mx-auto d-block mt-1 mb-2" src="{{asset('assets/img/home/about1.png')}}">
                <div class="text-center text-about mb-1"><strong> Evíos <br> seguros </strong></div>
            </div>
            <div class="card mb-1 cas-md-3 col-md-3  ml-md-4" style="width: 18rem; background: white;">
                <img class="mx-auto d-block mt-3 mb-2" src="{{asset('assets/img/home/about2.png')}}" alt="">
                <div class="text-center text-about mb-1"><strong> Atención <br> Personalizada</strong></div>
            </div>
            <div class="card mb-1 cas-md-3 col-md-3  ml-md-4" style="width: 18rem; background: white;">
                <img class="mx-auto d-block mt-3 mb-2" src="{{asset('assets/img/home/about3.png')}}" alt="">
                <div class="text-center text-about mb-1"><strong> Productos <br> legales</strong></div>
            </div>
        </div>
    </div>
    </div>


@endsection
