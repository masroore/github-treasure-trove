@extends('layouts.dashboard')

@section('content')

<section>
<div class="row match-height d-flex justify-content-center">
    <div class="col-md-12 col-12">
        <div class="card">

            <div class="card-header">
                <h4 class="card-title text-white">Editando el Ticket #{{ $ticket->id}}</h4>
            </div>

            <div class="card-content">
                <div class="card-body">
                        <div class="row">

                                    <div class="col-12">
                                        <label class="form-label text-white mb-1" for="issue"><b>Asunto del ticket</b></label>
                                        <input class="form-control rounded-0 border-primary" type="text" id="issue" name="issue" value="{{ $ticket->issue }}"/>
                                    </div>

                                    <div class="col-12 mt-1">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="priority" class="text-white">Prioridad del Ticket</label>
                                                <span class="text-danger text-bold-600">OBLIGATORIO</span>
                                                <select name="priority" class="custom-select priority form-control rounded-0 border-primary">
                                                    <option value="0" @if($ticket->priority == '0') selected @endif>Alto</option>
                                                    <option value="1" @if($ticket->priority == '1') selected @endif>Medio</option>
                                                    <option value="2" @if($ticket->priority == '2') selected @endif>Bajo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-1 mb-2" id="load_chat">
                                        <label class="form-label text-white" for="message"><b>Chat con el administrador</b></label>
                                        <section class="chat-app-window mb-2 rounded-0 border-primary">
                                            <div class="active-chat">
                                                <div class="user-chats ps ps--active-y ">
                                                    <div class="chats chat-thread p-2">

                                                        {{-- admin --}}
                                                        <div class="chat chat-left">
                                                            <div class="chat-avatar">
                                                                <span class="avatar box-shadow-1 cursor-pointer">
                                                                    <img src="{{ asset('assets/img/royal_green/logos/logo.svg') }}" alt="avatar" height="36" width="36">
                                                                </span>
                                                            </div>
                                                            <div class="chat-body">
                                                                <div class="chat-content">
                                                                    <p>Hola!. ¿Cómo podemos ayudar? 😄</p>
                                                                    <small class=" text-secondary">admin@binarystage.com</small>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @foreach ( $message as $item )
                                                        {{-- user --}}
                                                        @if ($item->type == 0)
                                                        <div class="chat">
                                                            <div class="chat-avatar">
                                                                <span class="avatar box-shadow-1 cursor-pointer">
                                                                    @if (Auth::user()->photoDB != NULL)
                                                                    <img src="{{asset('storage/photo/'.Auth::user()->photoDB)}}" alt="avatar" height="36" width="36">
                                                                    @else
                                                                    <img src="{{ asset('assets/img/royal_green/logos/logo.svg') }}" alt="avatar" height="36" width="36">
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="chat-body">
                                                                <div class="chat-content">
                                                                    <p>{{ $item->message }}</p>
                                                                    <small class=" text-secondary">{{ $item->getUser->email}}</small>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- admin --}}
                                                        @elseif ($item->type == 1)
                                                        <div class="chat chat-left">
                                                            <div class="chat-avatar">
                                                                <span class="avatar box-shadow-1 cursor-pointer">
                                                                    <img src="{{ asset('assets/img/royal_green/logos/logo.svg') }}" alt="avatar" height="36" width="36">
                                                                </span>
                                                            </div>
                                                            <div class="chat-body">
                                                                <div class="chat-content">
                                                                    <p>{{ $item->message }}</p>
                                                                    <small class=" text-secondary">admin@binarystage.com</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                        <span class="text-danger text-bold-600">Aqui podra escribir el mensaje para el admin</span>
                                        <textarea class="form-control rounded-0 border-primary" name="message" required id="message" rows="2"></textarea>
                                        
                                    </div>

                            <div class="col-12"><button class="btn btn-primary mb-1 float-right btn_msj">Actualizar Ticket</button></div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

var token =  $('meta[name="csrf-token"]').attr('content')

    $(document).on('click', '.btn_msj', function () {

        if($('#message').val() == null || $('#message').val() == '' ){
            toastr.error("El mensaje es requerido", '', {"timeOut":3000})
        }else{

        let item = {}
        var this_button = $(this)
        item ['_method'] = 'PATCH';
        $.ajax({
            method: "POST",
            url: "{{ route('ticket.update-user', $ticket->id) }}",
            data: { "_token": "{{ csrf_token() }}", message: $('#message').val(), "_method": 'PATCH' }
        }).done(function( data ) {
            // console.log(data);
            this_button.addClass('disabled').addClass('is-loading');
            $("#load_chat").load( "{{ route('ticket.edit-user', $ticket->id) }} #load_chat" );
            setTimeout(() => {
                toastr.success("El mensaje a sido enviado", '', {"timeOut":3000})
                this_button.removeAttr('disabled');
                this_button.removeClass('disabled').removeClass('is-loading');                           
            },1000)
        }) .fail(function(xhr, status, error) {
                toastr.error("Hubo un error al enviar el mensaje", '', {"timeOut":3000})
        });   

        }
    });

</script>