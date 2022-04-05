@foreach($vault->sites as $site)
<div class="modal fade" id="add-to-folder-{{ $site->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body bg-secondary p-0">
                <div class="modal-body">
                    @if($vault->folders->count() == 0)
                    <div>
                        <span>@lang('vault.add_to_folder_none')</span>
                    </div>
                    @else 
                    <span class="text-center">
                        <p><b>{!! Lang::get('vault.add_site_to_select_folder', ['name' => $site->name]) !!}</b></p>
                        <hr>
                    </span>
                    <form method="POST" action="{{ route('vault.folder.addToFolder', [$vault,$site]) }}">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <select class="form-control" name="folder" id="folder" required="">
                                    <option value="" selected="" disabled="">{{ __('vault.select_a_folder') }}</option>
                                    @foreach($vault->folders as $folder)
                                    <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-dark btn-shadow"><i class="fas fa-folder-plus"></i> {{ __('vault.add_to_folder') }}</button>
                        </div>
                    </form>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach