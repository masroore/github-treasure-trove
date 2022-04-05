<div class="modal fade in alert-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-grey-suit">Baby Passport</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Lo sentimos por el momento la agenda online está llena, si quieres agendar una cita comunícate
                    con uno de nuestros agentes.</p>
            </div>
            <div class="modal-footer">

                @if(!Auth::guest())
                    <a href="{{route('web.getMomProfile',[Auth::user()->id])}}"
                       class="btn btn-ce-soir btn-full-rounded text-light close-modal">
                        <i class="fas fa-user"></i> Ir a mi perfil
                    </a>
                @else
                    <a href="{{route('register')}}"
                       class="btn btn-ce-soir btn-full-rounded text-light">
                        <i class="fas fa-play"></i> Iniciar mi proceso
                    </a>
                @endif

                {{--  <a href="{{route('web.getContactForm')}}"
                     class="btn btn-whatsapp btn-full-rounded text-light " data-whats="">
                      <i class="fab fa-whatsapp"></i> Enviar mensaje
                  </a>
                  <a class="btn btn-blue-call  btn-full-rounded" href="tel:+5214428674284">
                      <i class="fas fa-phone"></i> LLamar
                  </a>--}}
            </div>
        </div>
    </div>
</div>