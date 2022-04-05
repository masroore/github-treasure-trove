<form action="{{ route('profile.update',$user->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PATCH') 

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <div class="controls">
                    <h2 class="font-weight-bold white">Dirección de Billetera </h2>
                </div>
            </div>
        </div>
  
        <div class="col-12">
            <div class="form-group">
                <div class="controls">
                    <label class=" white" for="wallet_address">Billetera</label>
                    <input type="text"
                        class="form-control border border-primary rounded-0 @error('wallet_address') is-invalid @enderror"
                        id="wallet_address" name="wallet_address"
                        value="{{ $user->wallet_address }}">
                    @error('wallet_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <label class=" white" for="type_wallet">Tipo de Billetera @if ($user->type_wallet != '') -> Billetera Selecionada: {{ $user->type_wallet }} @endif</label>
                    <select name="type_wallet" class="form-control border border-primary rounded-0 @error('wallet_address') is-invalid @enderror">
                        <option value="" selected disabled>Seleccione una billetera</option>
                        <option value="BTC">BTC</option>
                        <option value="USDT">USDT</option>
                    </select>
                    @error('type_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-12 mb-2">
            <a href="https://accounts.binance.com/es/register" target="_blank"
            class="gold waves-effect waves-light"> <b>¿No tiene billetera? Abre una cuenta en binance</b></a>
        </div>

    </div>
    <hr>
    <div class="media">
        <div class="custom-file">
            <label class="custom-file-label  border border-primary rounded-0" for="photoDB" style="background: #173138 ;color: white;">Seleccione su
                Foto <b>(Se permiten JPG o PNG.
                Tamaño máximo de 800kB)</b></label>
            <input type="file" id="photoDB"
                class="custom-file-input @error('photoDB') is-invalid @enderror"
                name="photoDB" onchange="previewFile(this, 'photo_preview')"
                accept="image/*">
            @error('photoDB')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="row mb-4 mt-4 d-none" id="photo_preview_wrapper">
        <div class="col"></div>
        <div class="col-auto">
          <img id="photo_preview" class="img-fluid rounded" />
        </div>
        <div class="col"></div>
    </div>
    
    <hr>
 
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <div class="controls">
                    <h2 class="font-weight-bold white">Datos Personales</h2>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <div class="controls">
                    <label class=" white" for="">Nombre Completo</label>
                    <input type="text"
                        class="form-control border border-primary rounded-0 @error('name') is-invalid @enderror"
                        id="fullname" name="fullname"
                        value="{{ $user->fullname }}">
                    @error('fullname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <div class="controls">
                    <label class=" white" for="email">Email</label>
                    <input type="email"
                        class="form-control border border-primary rounded-0 @error('email') is-invalid @enderror"
                        id="email" name="email"
                        value="{{ $user->email }}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <div class="controls">
                    <label class=" white" for="whatsapp">Telefono</label>
                    <input type="text"
                        class="form-control border border-primary rounded-0 @error('whatsapp') is-invalid @enderror"
                        name="whatsapp" value="{{ $user->whatsapp }}">
                    @error('whatsapp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <div class="controls">
                    <label class=" white" for="password">Contraseña Actual</label>
            
                    <input id="password" type="password" class="form-control border border-primary rounded-0" name="current_password"
                    autocomplete="current-password">
            
                </div>
            </div>
        </div>

        <div class="col-6">
        <div class="form-group">
            <div class="controls">
            <label for="password" class="white">Nueva Contraseña</label>
            
                <input id="new_password" type="password" class="form-control border border-primary rounded-0" name="new_password"
                    autocomplete="current-password">
            </div>
        </div>
        </div>

        <div class="col-6">
        <div class="form-group">
            <div class="controls">
            <label for="password" class="white">Confirme la Contraseña</label>
            
                <input id="new_confirm_password" type="password" class="form-control border border-primary rounded-0"
                    name="new_confirm_password" autocomplete="current-password">
            </div>
        </div>
        </div>

        

    </div>
    <hr>

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <div class="controls">
                    <h2 class="font-weight-bold white">Más Información</h2>
                </div>
            </div>
        </div>
  
        <div class="col-12">
            <div class="form-group">
                <div class="controls">
                    <label class=" white" for="address">Dirección</label>
                    <textarea type="text"
                        class="form-control border border-primary white rounded-0 @error('address') is-invalid @enderror"
                        id="address"name="address" style="background: #11262C;">{{ $user->address}}</textarea>
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <div class="controls">
                    <h6 class="font-weight-bold white"><span class="text-danger">Nota:
                        </span> Si no quieres añadir <span
                            class="text-danger">Más Información</span> deja
                        estos
                        espacios en blanco.</h6>
                </div>
            </div>
        </div>
        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
            <button type="submit"
                class="btn btn-outline-warning padding-button-short mt-1 waves-effect waves-light text-white">GUARDAR</button>
        </div>
    </div>
</form>