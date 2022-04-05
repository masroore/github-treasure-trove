<form wire:submit.prevent="addSite">
    @csrf
    <div class="card card-success mb-0">
        <div class="card-header">
            <h4 class="text-success">{!! Lang::get('vault.add_site_to', ['vault' => $vault->name] ) !!}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('vault.site_name') }} <small class="text-danger">*</small></label>
                <div class="input-group">
                    <input type="text" wire:model.lazy="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('vault.site_name_placeholder') }}">
                </div>
                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>{{ __('vault.site_link') }}</label>
                <div class="input-group">
                    <input type="text" wire:model.lazy="link" class="form-control {{ $errors->has('link') ? ' is-invalid' : '' }}" placeholder="{{ __('vault.site_link_placeholder') }}">
                </div>
                @error('link') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>{{ __('vault.site_login_id') }} <small class="text-danger">*</small></label>
                <div class="input-group">
                    <input type="text" wire:model.lazy="login_id" class="form-control {{ $errors->has('login_id') ? ' is-invalid' : '' }}" placeholder="{{ __('vault.site_login_id_placeholder') }}">
                </div>
                @error('login_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>{{ __('vault.site_login_pass') }} <small class="text-danger">*</small></label>
                <div class="input-group">
                    <input type="text" wire:model.lazy="login_password" class="form-control {{ $errors->has('login_password') ? ' is-invalid' : '' }}" placeholder="{{ __('vault.site_login_pass_placeholder') }}">
                    <button type="button" wire:click="rpg" class="btn btn-success btn-sm random" name="random" id="random">{{ __('vault.generate') }}</button>
                </div>
                @error('login_password') <span class="error text-danger">{{ $message }}</span> @enderror
                <small id="sitesHelpBlock" class="form-text text-muted">
                    {!! Lang::get('vault.site_login_pass_sub', ['profile' => '/profile']) !!}.
                </small>
            </div>
            <div class="form-group">
                <label>{{ __('vault.site_add_info') }} </label>
                <div class="input-group">
                    <textarea type="text" class="form-control {{ $errors->has('additional_info') ? ' is-invalid' : '' }}" wire:model.lazy="additional_info"></textarea>
                </div>
                @error('additional_info') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            @if($folder)
            <div class="form-group">
                <label>{{ __('vault.add_to_folder') }} <small class="text-danger">*</small></label>
                <div class="input-group">
                    <input type="text" value="{{ $folder->name }}" class="form-control {{ $errors->has('folder') ? ' is-invalid' : '' }}" readonly>
                </div>
                @error('folder') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            @elseif($vault->folders->count() > 0)
            <div class="form-group">
                <label>{{ __('vault.site_add_to_folder') }}</label>
                <div class="input-group">
                    <select class="form-control {{ $errors->has('folder') ? ' is-invalid' : '' }}" wire:model.lazy="folder">
                        <option value="" selected>{{ __('vault.site_add_to_select') }}</option>
                        @foreach($vault->folders as $folder)
                        <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('folder') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            @endif
        </div>
    </div>
    <div class="modal-footer bg-whitesmoke">
        <div class="mr-auto"><span class="text-danger">*</span> {{ __('vaults.input_req') }}</div>
        <button type="submit" class="btn btn-success btn-shadow"><i class="fas fa-plus"></i> {{ __('vault.add_site') }}</button>
    </div>
</form>
