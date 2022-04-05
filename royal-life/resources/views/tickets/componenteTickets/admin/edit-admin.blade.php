@extends('layouts.dashboard')

@section('content')

<section id="basic-vertical-layouts">
    <div class="row match-height d-flex justify-content-center">
        <div class="col-md-12 col-12">
            <div class="card bg-lp">

                <div class="card-header">
                    <h4 class="card-title text-white">Atendiendo el Ticket #{{ $ticket->id }}</h4>
                    <h4 class="card-title mt-2 text-white">Usuario: <span
                            class="text-primary">{{ $ticket->getUser->fullname}}</span></h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <form action="{{route('ticket.update-admin', $ticket->id)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="row">


                                <div class="col-12">
                                    <label class="form-label text-white mb-1" for="issue"><b>Asuto del
                                            Ticket</b></label>
                                    <input class="form-control border border-primary rounded-0" type="text" id="issue"
                                        name="issue" rows="3" value="{{ $ticket->issue }}" readonly />

                                </div>


                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label for="status" class="text-white">Estado del Ticket</label>
                                            <span class="text-danger text-bold-600">OBLIGATORIO</span>
                                            <select name="status" id="status"
                                                class="custom-select status form-control bg-lp border border-primary rounded-0 @error('status') is-invalid @enderror"
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
                                                class="custom-select priority form-control bg-lp border border-primary rounded-0 @error('priority') is-invalid @enderror"
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

                                <div class="col-12 mt-2 mb-2">
                                    <label class="form-label text-white" for="note"><b>Chat con el usuario</b></label>

                                    <section class="chat-app-window mb-2 border border-primary rounded-0">
                                        <div class="active-chat">
                                            <div class="user-chats ps ps--active-y bg-lp">
                                                <div class="chats chat-thread">

                                                    <div class="chat">
                                                        <div class="chat-avatar">
                                                            <span class="avatar box-shadow-1 cursor-pointer">
                                                                @if (Auth::user()->photoDB != NULL)
                                                                <img src="{{asset('storage/photo/'.Auth::user()->photoDB)}}"
                                                                    alt="avatar" height="36" width="36">
                                                                @else
                                                                <img src="{{ asset('assets/img/royal_green/logos/logo.svg') }}"
                                                                    alt="avatar" height="36" width="36">
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <div class="chat-body">
                                                            <div class="chat-content">
                                                                <p>Hola!. ¿Cómo podemos ayudar? 😄</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @foreach ( $message as $item )

                                                    {{-- user --}}
                                                    @if ($item->type == 0)

                                                    <div class="chat chat-left">
                                                        <div class="chat-avatar">
                                                            <span class="avatar box-shadow-1 cursor-pointer">
                                                                <img src="{{ asset('assets/img/royal_green/logos/logo.svg') }}"
                                                                    alt="avatar" height="36" width="36">
                                                            </span>
                                                        </div>
                                                        <div class="chat-body">
                                                            <div class="chat-content">
                                                                <td>{{ $item->getUser->email}}</td>
                                                                <p>{{ $item->message }}</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- admin --}}
                                                    @elseif ($item->type == 1)
                                                    <div class="chat">
                                                        <div class="chat-avatar">
                                                            <span class="avatar box-shadow-1 cursor-pointer">
                                                                @if (Auth::user()->photoDB != NULL)
                                                                <img src="{{asset('storage/photo/'.Auth::user()->photoDB)}}"
                                                                    alt="avatar" height="36" width="36">
                                                                @else
                                                                <img src="{{ asset('assets/img/royal_green/logos/logo.svg') }}"
                                                                    alt="avatar" height="36" width="36">
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <div class="chat-body">
                                                            <div class="chat-content">
                                                                <td>{{ $item->getAdmin->email}}</td>
                                                                <p>{{ $item->message }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <span class="text-danger text-bold-600">Aqui podra escribir el mensaje para el
                                        admin</span>
                                    <textarea class="form-control border border-primary rounded-0 chat-window-message"
                                        required type="text" id="message" name="message"></textarea>
                                </div>

                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Enviar
                                        Ticket</button>
                                </div>

                            </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

@endsection
