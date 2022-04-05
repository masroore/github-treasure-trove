@extends('layouts.dashboard')

@section('content')

<section id="basic-vertical-layouts">
    <div class="row match-height d-flex justify-content-center">
        <div class="col-md-6 col-12">
            <div class="card bg-dark">
                <div class="card-header">
                    <h4 class="card-title text-white">Revisando el Ticket #{{ $ticket->id}}</h4>
                    <h4 class="card-title mt-1 text-white">Usuario: <span
                            class="text-primary">{{ $ticket->getUser->fullname}}</span></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-body">
                            <div class="row">
                              
                                  <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-white">Asunto del Ticket</label>
                                        <textarea type="text"  id="asunto"
                                            class="form-control bg-lp border border-warning rounded-0"
                                            name="asunto">{{ $ticket->issue }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label for="status" class="text-white">Estado del Ticket</label>
                                            <span class="text-danger text-bold-600">OBLIGATORIO</span>
                                            <select name="status" id="status"
                                                class="custom-select status form-control bg-lp border border-warning rounded-0 @error('status') is-invalid @enderror"
                                                required data-toggle="select">
                                                <option value="0" @if($ticket->status == '0') selected
                                                    @endif>Abierto</option>
                                                <option value="1" @if($ticket->status == '1') selected
                                                    @endif>Cerrado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label for="priority" class="text-white">Prioridad del
                                                Ticket</label>
                                            <span class="text-danger text-bold-600">OBLIGATORIO</span>
                                            <select name="priority" id="priority"
                                                class="custom-select priority form-control bg-lp border border-warning rounded-0 @error('priority') is-invalid @enderror"
                                                required data-toggle="select">
                                                <option value="0" @if($ticket->priority == '0') selected
                                                    @endif>Alto</option>
                                                <option value="1" @if($ticket->priority == '1') selected
                                                    @endif>Medio</option>
                                                <option value="2" @if($ticket->priority == '2') selected
                                                    @endif>Bajo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-white">Descripcion del Ticket</label>
                                        <textarea type="text" rows="5" readonly id="description"
                                            class="form-control form-control bg-lp border border-warning rounded-0"
                                            name="description">{{ $ticket->description }}</textarea>
                                    </div>
                                </div>


                                <div class="col-12 mt-2 mb-2">
                                    <label class="form-label text-white" for="note"><b>Chat con el administrador</b></label>

                                        <section class="chat-app-window mb-2 border border-warning rounded-0">
                                            <div class="active-chat">
                                                <div class="user-chats ps ps--active-y bg-lp">
                                                    <div class="chats">

                                                        {{-- admin --}}
                                                        <div class="chat">
                                                            <div class="chat-avatar">
                                                                <span class="avatar box-shadow-1 cursor-pointer">
                                                                    <img src="{{ asset('assets/img/legazy_pro/logo.svg') }}"
                                                                        alt="avatar" height="36" width="36">
                                                                </span>
                                                            </div>
                                                            <div class="chat-body">
                                                                <div class="chat-content">
                                                                    <p>How can we help? We're here for you! 😄</p>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        {{-- user --}}
                                                        <div class="chat chat-left">
                                                            <div class="chat-avatar">
                                                                <span class="avatar box-shadow-1 cursor-pointer">
                                                                    <img src="{{ asset('assets/img/legazy_pro/user.png') }}"
                                                                        alt="avatar" height="36" width="36">
                                                                </span>
                                                            </div>
                                                            <div class="chat-body">
                                                                <div class="chat-content">
                                                                    <p>Hey John, I am looking for the best admin
                                                                        template.</p>
                                                                </div>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                        <label for="note">Escribir mensaje</label>
                                        <span class="text-danger text-bold-600">(Espere que el admin responda antes de enviar
                                            otro mensaje)</span>
                                        <textarea class="form-control border border-warning rounded-0 chat-window-message"
                                            type="text" id="note" name="note"></textarea>
                                </div>
                             </div>  
                              <div class="col-12">
                                    <div class="form-group d-flex justify-content-center">
                                        <div class="controls">
                                            @if ( $ticket->status == 0 )
                                            <a class=" btn btn-info text-white text-bold-600">En Espera</a>
                                            @elseif($ticket->status == 1)
                                            <a class=" btn btn-success text-white text-bold-600">Solucionado</a>
                                            @elseif($ticket->status == 2)
                                            <a class=" btn btn-warning text-white text-bold-600">Procesando</a>
                                            @elseif($ticket->status == 3)
                                            <a class=" btn btn-danger text-white text-bold-600">Cancelada</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
