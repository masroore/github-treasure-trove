@extends('layouts.app')

@section('title')
    <title>BabyPassport | Preguntas Frecuentes</title>
@endsection



@section('content')

    <div class="mb-5 faqs">

        <h1 class="text-center mb-3 text-ce-soir">PREGUNTAS FRECUENTES</h1>

        <div class="container">
            <div class="accordion" id="accordionExample">


                <!-- FAQ 2 -->
                <div class="card border-0">
                    <div class="card-header border-purple border-bottom  border-ce-soir mb-3" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link text-uppercase titule-accordion" type="button"
                                    data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                                    aria-controls="collapseTwo">
                               <i class="fas fa-plus-circle mr-2" style="color:#9A7AA0;"></i>
                                <span class="text-ce-soir">¿Puedo viajar embarazada?</span> 
                            </button>
                        </h2>
                    </div>

                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body border-0 mb-1 lead text-grey-suit">
                            Si pasa de la semana 38 es recomendable viajar en auto.
                        </div>
                    </div>
                </div>
                <!--END FAQ 2-->

                <!-- FAQ 3 -->
                <div class="card border-0">
                    <div class="card-header border-bottom  border-ce-soir mb-3" id="headingThree">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
                                    aria-controls="collapseThree">
                               <i class="fas fa-plus-circle mr-2" style="color:#9A7AA0;"></i><span class="text-ce-soir"> ¿Es legal tener a mi bebé en EUA para que tenga la
                                    ciudadanía?</span> 
                            </button>
                        </h2>
                    </div>

                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                         data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">

                            Es totalmente legal. Es importante identificar que existe una diferencia entre un extranjero
                            ilegal
                            (sin documentación y que permanece en los Estados Unidos) y un extranjero legal (una persona
                            que cuenta
                            con documentación para internación, permiso o Visa a los Estados Unidos).
                            Si bien hay reformas migratorias enfocadas en limitar los derechos de extranjeros
                            indocumentados o "ilegales",
                            la ciudadanía por nacimiento jus soli es un derecho constitucional.
                        </div>
                    </div>
                </div>
                <!--END FAQ 3 -->

                <!-- FAQ 4 -->
                <div class="card border-0">
                    <div class="card-header  border-bottom  border-ce-soir mb-3" id="headingFour">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseFour" aria-expanded="true"
                                    aria-controls="collapseFour">
                               <i class="fas fa-plus-circle mr-2" style="color:#9A7AA0;"></i> <span class="text-ce-soir">¿Puedo perder mi visa o tener algún problema para la
                                    renovación si tengo a mi bebé en EUA?</span>  
                            </button>
                        </h2>
                    </div>

                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                         data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">

                            Nuestro programa es 100% legal, sin repercusiones migratorias a tu visa. Es importante
                            declarar honestamente tu embarazo
                            y parto como el motivo de tu visita al ingresar a los Estados Unidos.
                        </div>
                    </div>
                </div>
                <!-- END FAQ 4 -->

                <!-- FAQ 5 -->
                <div class="card border-0">
                    <div class="card-header  border-bottom  border-ce-soir mb-3" id="headingFive">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseFive" aria-expanded="true"
                                    aria-controls="collapseFive">
                               <i class="fas fa-plus-circle" style="color:#9A7AA0;"></i>
                                <span class="text-ce-soir mr-2"> ¿Se necesita tener algún visado o permiso de
                                    internamiento para hacer mi parto en EUA?</span>              
                            </button>
                        </h2>
                    </div>

                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                         data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">
                            Ninguno, nada mas el permiso si permanece mas de 60 días en el país.
                        </div>
                    </div>
                </div>
                <!-- END FAQ 5 -->

                <!-- FAQ 6 -->
                <div class="card border-0">
                    <div class="card-header border-bottom  border-ce-soir mb-3" id="headingSix">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseSix" aria-expanded="true"
                                    aria-controls="collapseSix">
                               <i class="fas fa-plus-circle" style="color:#9A7AA0;"></i>
                                <span class="text-ce-soir mr-2" style="color:#9A7AA0;"> ¿Qué debo decir al oficial de migración al ser
                                    cuestionada sobre el propósito de mi visita a los Estados Unidos?</span> 
                            </button>
                        </h2>
                    </div>

                    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">
                            Nunca mientas sobre tu propósito de dar a luz en los Estados Unidos. Es muy importante
                            siempre decir la verdad, contar con tu documentación,
                            carta de cita médica y comprobante de pago (documentos que nosotros te otorgaremos).
                        </div>
                    </div>
                </div>
                <!-- END FAQ 6-->

                <!-- FAQ 7 -->
                <div class="card border-0 ">
                    <div class="card-header  border-bottom  border-ce-soir mb-3" id="headingSeven">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true"
                                    aria-controls="collapseSeven">
                               <i class="fas fa-plus-circle" style="color:#9A7AA0;"></i>
                                <span class="text-ce-soir mr-2" > ¿Me dan algún documento para mostrar en migración?</span>        
                            </button>
                        </h2>
                    </div>

                    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven"
                         data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">
                            Sí, nosotros te proporcionamos tu carta de cita y un comprobante de pago por la contratación
                            del servicio.
                        </div>
                    </div>
                </div>
                <!-- END FAQ 7 -->

                <!-- FAQ 8 -->
                <div class="card border-0">
                    <div class="card-header  border-bottom  border-ce-soir mb-3" id="headingEight">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseEight" aria-expanded="true"
                                    aria-controls="collapseEight">
                               <i class="fas fa-plus-circle mr-2" style="color:#9A7AA0;"></i> <span class="text-ce-soir">¿Cuál es el primer paso?</span>          
                            </button>
                        </h2>
                    </div>

                    <div id="collapseEight" class="collapse" aria-labelledby="headingEight"
                         data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">

                            <a href="{{asset('img/miscellaneous/guia_mama.pdf')}}" download="guia_mama.pdf">
                                Descargar
                            </a>
                            la guía gratuita de Baby Passport.

                        </div>
                    </div>
                </div>
                <!-- END FAQ 8 -->
                <!-- FAQ 9 -->
                <div class="card border-0">
                    <div class="card-header  border-bottom  border-ce-soir mb-3" id="headingNine">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link  text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseNine" aria-expanded="true"
                                    aria-controls="collapseNine">
                               <i class="fas fa-plus-circle mr-2" style="color:#9A7AA0;"></i> <span class="text-ce-soir"> ¿Necesito asistir a alguna consulta con el doctor antes del parto? </span> 
                            </button>
                        </h2>
                    </div>

                    <div id="collapseNine" class="collapse" aria-labelledby="headingNine"
                         data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">
                            No es necesario, aconsejamos llevar tu tratamiento prenatal en tu lugar de residencia.
                        </div>
                    </div>
                </div>
                <!-- END FAQ 9 -->


                <!-- FAQ 10 -->
                <div class="card border-0">
                    <div class="card-header border-bottom  border-ce-soir mb-3" id="headingTen">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseTen" aria-expanded="true"
                                    aria-controls="collapseTen">
                                    <i class="fas fa-plus-circle  mr-2" style="color:#9A7AA0;"></i>
                                <span class="text-ce-soir"> ¿Qué información/ documentos necesito llevar al doctor
                                    en la primera cita?</span> 
                              
                            </button>
                        </h2>
                    </div>

                    <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">
                            Trae todos los estudios prenatales que te hayas realizado.
                        </div>
                    </div>
                </div>
                <!-- END FAQ 10 -->

                <!-- FAQ 11 -->
                <div class="card border-0">
                    <div class="card-header  border-bottom  border-ce-soir mb-3" id="headingEleven">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseEleven" aria-expanded="true"
                                    aria-controls="collapseEleven">
                                    <i class="fas fa-plus-circle mr-2" style="color:#9A7AA0;"></i>
                                <span class="text-ce-soir"> ¿Cuánto tiempo toma realizar todo el proceso?</span>       
                            </button>
                        </h2>
                    </div>

                    <div id="collapseEleven" class="collapse" aria-labelledby="headingeleven"
                         data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">
                            Debes tomar en cuenta que tu estancia con nosotros será aproximadamente de un mes. Toma
                            alrededor de
                            4 semanas desde el día en que llegas a revisión médica hasta la entrega del acta de
                            nacimiento de
                            tu bebé.
                        </div>
                    </div>
                </div>
                <!-- END FAQ 11 -->

                <!-- FAQ 12 -->
                <div class="card border-0">
                    <div class="card-header border-bottom  border-ce-soir mb-3" id="headingTwelve">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseTwelve" aria-expanded="true"
                                    aria-controls="collapseTwelve">
                               <i class="fas fa-plus-circle mr-2" style="color:#9A7AA0;"></i>
                                <span class="text-ce-soir">¿Cuánto tiempo debo permanecer en el hospital después
                                    del parto?</span>
                            </button>
                        </h2>
                    </div>

                    <div id="collapseTwelve" class="collapse" aria-labelledby="headingTwelve"
                         data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">
                            La estancia es de 24 a 36 horas, dependiendo el procedimiento.
                        </div>
                    </div>
                </div>
                <!--END FAQ 12-->

                <!-- FAQ 13 -->
                <div class="card border-0 ">
                    <div class="card-header  border-bottom  border-ce-soir mb-3" id="headingThirteen">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseThirteen" aria-expanded="true"
                                    aria-controls="collapseThirteen">
                                    <i class="fas fa-plus-circle mr-2" style="color:#9A7AA0;"></i>
                                <span class="text-ce-soir">¿Si tengo alguna condición médica, hay algún
                                    impedimento?</span>      
                            </button>
                        </h2>
                    </div>

                    <div id="collapseThirteen" class="collapse" aria-labelledby="headingThirteen"
                         data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">
                            Ninguno, se trata de acuerdo a la condición de cada paciente.
                        </div>
                    </div>
                </div>
                <!-- END FAQ 13 -->

                <!-- FAQ 14 --->
                <div class="card border-0">
                    <div class="card-header  border-bottom  border-ce-soir mb-3" id="headingFourteen">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseFourteen" aria-expanded="true"
                                    aria-controls="collapseFourteen">
                               <i class="fas fa-plus-circle mr-2" style="color:#9A7AA0;"></i>
                                <span class="text-ce-soir">¿Cuáles son los riesgos del procedimiento?</span>                                 
                            </button>
                        </h2>
                    </div>

                    <div id="collapseFourteen" class="collapse" aria-labelledby="headingFourteen"
                         data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">
                            Son los mismos riegos de un parto normal, infección, sangrado, etc.
                        </div>
                    </div>
                </div>
                <!-- END FAQ 14 -->

                <!--FAQ 15 -->
                <div class="card border-0">
                    <div class="card-header  border-bottom  border-ce-soir mb-3" id="headingFifteen">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseFifteen" aria-expanded="true"
                                    aria-controls="collapseFifteen">
                               <i class="fas fa-plus-circle mr-2" style="color:#9A7AA0;"></i>
                                <span class="text-ce-soir" >¿Qué sucede si tengo complicaciones en el parto?</span>            
                            </button>
                        </h2>
                    </div>

                    <div id="collapseFifteen" class="collapse" aria-labelledby="headingFifteen"
                         data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">
                            En caso de cualquier tipo de complicación que pueda surgir contamos con especialistas
                            capacitados para resolverla.
                        </div>
                    </div>
                </div>
                <!-- END FAQ 15 -->

                <!-- FAQ 16 -->
                <div class="card border-0">
                    <div class="card-header  border-bottom  border-ce-soir mb-3" id="headingSixteen">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseSixteen" aria-expanded="true"
                                    aria-controls="collapseSixteen">
                               <i class="fas fa-plus-circle mr-2" style="color:#9A7AA0;"></i>
                                <span class="text-ce-soir">¿En caso de tener una complicación en mi parto los
                                    costos adicionales van incluidos dentro del paquete que contraté?</span>    
                                
                            </button>
                        </h2>
                    </div>

                    <div id="collapseSixteen" class="collapse" aria-labelledby="headingSixteen"
                         data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">
                            Los costos adicionales no están incluidos dentro de ningún paquete. Los mismos corren por
                            cuenta del paciente.

                        </div>
                    </div>
                </div>
                <!-- END FAQ 16 -->

                <!-- FAQ 17 -->
                <div class="card border-0">
                    <div class="card-header  border-bottom  border-ce-soir mb-3" id="headingSeventeen">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseSeventeen" aria-expanded="true"
                                    aria-controls="collapseSeventeen">
                               <i class="fas fa-plus-circle mr-2" style="color:#9A7AA0;"></i>
                                <span class="text-ce-soir mr-2">¿Qué costo tiene si es embarazo gemelar?</span>
                            </button>
                        </h2>
                    </div>

                    <div id="collapseSeventeen" class="collapse" aria-labelledby="headingSeventeen"
                         data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">
                            Únicamente se suman 800 dólares al costo original de cada paquete.
                        </div>
                    </div>
                </div>
                <!--END FAQ 17 -->

                <!-- FAQ 18 -->
                <div class="card border-0">
                    <div class="card-header  border-bottom  border-ce-soir mb-3" id="headingEighteen">
                        <h2 class="mb-0 ">
                            <button class="btn btn-link text-ce-soir text-uppercase" type="button"
                                    data-toggle="collapse" data-target="#collapseEighteen" aria-expanded="true"
                                    aria-controls="collapseEighteen">
                               <i class="fas fa-plus-circle mr-2" style="color:#9A7AA0;"></i>
                                <span class="text-ce-soir"> ¿Tienen convenio con algún hotel o medio de trasporte?</span>    
                            </button>
                        </h2>
                    </div>

                    <div id="collapseEighteen" class="collapse" aria-labelledby="headingEighteen"
                         data-parent="#accordionExample">
                        <div class="card-body border-grey-suit lead text-grey-suit">
                            Como tal nosotros no nos encargamos del hospedaje ni del transporte durante la estancia.
                            Sin embargo, como parte del servicio te proporcionamos un directorio de proveedores
                            recomendados.
                        </div>
                    </div>
                </div>
                <!-- END FAQ 18 -->


            </div>
        </div>

    </div>
@endsection


