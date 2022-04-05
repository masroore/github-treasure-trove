<div class="modal fade" id="create-folder" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            @if(Auth::user()->hasReachedFolderLimit())
            <div class="card card-danger mb-0">
                <div class="card-header">
                    <b>{{ __('vault.folder_limit') }}</b>
                </div>
            </div>
            @else
                @livewire('vault.folder.create-folder', ['vault' => $vault])
            @endif
        </div>
    </div>
</div>