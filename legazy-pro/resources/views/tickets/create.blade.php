@extends('layouts.dashboard')

 @section('content')


 <section id="basic-vertical-layouts">
     <div class="row match-height d-flex justify-content-center">
         <div class="col-md-6 col-12">
             <div class="card bg-lp">
                 <div class="card-header">
                     <h4 class="card-title text-white">Creacion de Ticket</h4>
                 </div>
                 <div class="card-content">
                     <div class="card-body">
                         <form action="{{route('ticket.store')}}" method="POST">
                             @csrf
                             <div class="form-body">
                                 <div class="row">

                                     <div class="col-12">
                                         <label class="form-label text-white mb-1" for="issue"><b>Asunto del
                                                 ticket</b></label>
                                         <input class="form-control border border-warning rounded-0" required type="text"
                                             id="issue" name="issue" rows="3" />

                                     </div>

                                     <div class="col-12 mt-2">
                                         <div class="form-group">
                                             <div class="controls">
                                                 <label for="priority" class="text-white">Prioridad del Ticket</label>
                                                 <span class="text-danger text-bold-600">OBLIGATORIO</span>
                                                 <select name="priority"
                                                     style="background:#141414; color: #ffffff; border: #141414;"
                                                     id="priority"
                                                     class="custom-select priority @error('priority') is-invalid @enderror"
                                                     required data-toggle="select">
                                                     <option value="0">Alto</option>
                                                     <option value="1">Medio</option>
                                                     <option value="2">Bajo</option>
                                                 </select>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-12 mt-2 mb-2">
                                         <label class="form-label text-white mb-1" for="message"><b>Chat con el
                                                 administrador</b></label>

                                         <section class="chat-app-window mb-2 border border-warning rounded-0">
                                             <div class="active-chat">
                                                 <div class="user-chats ps ps--active-y bg-lp">
                                                     <div class="chats chat-thread">

                                    
                                                            {{-- admin --}}

                                                         <div class="chat chat-left">
                                                             <div class="chat-avatar">
                                                                 <span class="avatar box-shadow-1 cursor-pointer">
                                                                     <img src="{{ asset('assets/img/legazy_pro/logo.svg') }}"
                                                                         alt="avatar" height="36" width="36">
                                                                 </span>
                                                             </div>
                                                             <div class="chat-body">
                                                                 <div class="chat-content">
                                                                     <p>Hola!. ¿Cómo podemos ayudar? 😄</p>
                                                                 </div>
                                                             </div>
                                                         </div>


                                                   </div>
                                                 </div>
                                             </div>
                                         </section>

                                         <br>
                                        <span class="text-danger text-bold-600">Aqui podra escribir el mensaje para el admin</span>
                                         <textarea
                                             class="form-control border border-warning rounded-0 chat-window-message"
                                             type="text" id="message" name="message" required rows="3"></textarea>
                                     </div>


                                     <div class="col-12">
                                         <button type="submit"
                                             class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Enviar
                                             Ticket</button>
                                     </div>

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