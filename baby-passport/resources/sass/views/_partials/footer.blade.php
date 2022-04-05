<footer class="container-fluid px-4 pt-4 pb-2 btn-ce-soir lighten-5 shadow">
    <div class="row flex-column flex-lg-row px-0 px-lg-5">

        <div class="col text-center text-lg-left mt-lg-4 pb-2 pb-lg-5">

            <a href="{{route('web.index')}}" class="text-white lead d-block mt-3">
                Inicio
            </a>

            <a href="{{route('web.getAtentionCenter')}}" class="text-white lead d-block">
                Centros de atención
            </a>

            <a href="{{route('web.getBlog')}}" class="text-white lead d-block">
                Blog
            </a>

            <a href="{{route('web.getFaqs')}}" class="text-white lead d-block">
                Preguntas frecuentes
            </a>

           <!-- <a href="{{route('web.getTerms')}}" class="text-ce-soir lead d-block">
                Términos y condiciones
            </a>


            <a href="{{route('web.getPolicies')}}" class="text-ce-soir lead d-block mb-3">
                Políticas de privacidad
            </a>-->

            <a href="{{route('web.getFaqs')}}" class="text-white lead d-block">
                ¿Eres doctor?
            </a>
           

        </div>

        <div class="col border-left mt-lg-3  text-center pl-lg-5 ml-lg-5">
        <div class="mx-auto">
            <img class="mt-4 mb-3 text-center" src="{{asset("img/logos/MM1-blanco.png")}}" alt="logo-medical-meeting" height="70">
        </div>
            <a href="{{route('web.getTerms')}}" class="text-white text-center py-2 d-block">
                        
                Términos y condiciones
           
             </a>
             <a href="{{route('web.getPolicies')}}" class="text-white  text-center py-2 d-block">
                        
                Políticas de privacidad
          
        </a>
  
        </div>

        <div class="col border-left mt-lg-4 text-center text-lg-left pl-lg-5 ml-lg-5">

          

            <div class=" mt-3 mt-lg-3 mb-3 lead">Línea Baby Passport</div>

                   

            <!--<a href="" class="ml-2 mr-2">
                <i class="fab fa-instagram fa-2x text-ce-soir"></i>
            </a>-->


            <!--<a href="" class="mr-2">
                <i class="fab fa-twitter fa-2x text-ce-soir"></i>
            </a>-->


            <!-- <a href="#" class="btn-whats">
                <i class="fab fa-whatsapp fa-2x text-ce-soir"></i>
            </a>-->

        

   

            <a href="tel:+4424540213" class="btn-call text-white  d-block">
               
                     <i class="fa fa-phone"></i> 442 454 0213
            
            </a>

    
            <a href="mailto:info@thebabypassport.co" class="text-white d-block my-3">
               
                    <i class="fa fa-envelope"></i> babypassport@medicalmeeting.co
               
            </a>


    <a href="https://www.facebook.com/BaPassport/?ref=br_rs" class="text-white d-block mt-2" target="_blank">
      <i class="fab fa-facebook"></i> Siguenos en facebook
    </a>

        </div>
    </div>

    <div class="row">
        <div class="col ">
            <p class=" mt-4 pt-0 pt-lg-5 mt-lg-3 text-center">
                &copy;{{date('Y')}} Medical Meeting, Inc. Todos los derechos reservados.
            </p>
        </div>
    </div>
</footer>

