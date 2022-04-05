<div>
               <div class="card-body">
               <div>
                    @if (session()->has('message'))
                          <div class="alert alert-warning my-3">
                              {{ session('message') }}
                          </div>
                      @endif
                    </div>

                  <!--layout-->
                    <h1>Ingreso</h1>
                    <p class="text-muted">Ingresa con tu cuenta</p>
                    <form wire:submit.prevent="login">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend"><span class="input-group-text">
                      <i class="cil-user"></i>
                        </span></div>
                      <input type="email" class="form-control" wire:model.defer="email" placeholder="Email">
                    </div>
                      @error('email') <span class="d-block text-danger error mb-2">{{ $message }}</span>@enderror
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="cil-asterisk"></i>
                        </span></div>
                       <input type="password" class="form-control" wire:model.defer="password" placeholder="Password">
                    </div>
                       @error('password') <span class="d-block text-danger error  mb-2">{{ $message }}</span>@enderror
                    <div class="row">
                      <div class="col-6">          
                                       
                         <button  class="btn btn-primary" wire:keydown.enter="login"><i class="cil-https"></i> Ingresar</button>
                      </div>
                    </div>
                       </form>
            <!--layout-->

               </div>
</div>


