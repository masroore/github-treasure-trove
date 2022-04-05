<div class="modal fade" id="move-site" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body bg-secondary p-0">
                <div class="modal-body">
                    <span class="text-center">
                        <p><b>{!! Lang::get('vault.move_title', ['title' => $site->name]) !!}</b></p>
                        <hr>
                    </span>
                    <form method="POST" action="{{ route('vault.site.move', [$vault,$site]) }}">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <select class="form-control" name="vault" id="vault" required="">
                                    <option value="" selected="" disabled="">{{ __('vault.select_vault') }}</option>
                                    @foreach(auth()->user()->vaults as $v)
                                    @if($v->id != $site->vault->id)
                                    <option value="{{ $v->id }}">{{ $v->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-shadow"><i class="fas fa-people-carry"></i> {{ __('vault.move_btn') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>